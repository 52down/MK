<?php
/* vim: set ts=4 sw=4 sts=4 et: */
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| X-Cart Software license agreement                                           |
| Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>         |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
| PLEASE READ  THE FULL TEXT OF SOFTWARE LICENSE AGREEMENT IN THE "COPYRIGHT" |
| FILE PROVIDED WITH THIS DISTRIBUTION. THE AGREEMENT TEXT IS ALSO AVAILABLE  |
| AT THE FOLLOWING URL: https://www.x-cart.com/license-agreement-classic.html |
|                                                                             |
| THIS AGREEMENT EXPRESSES THE TERMS AND CONDITIONS ON WHICH YOU MAY USE THIS |
| SOFTWARE PROGRAM AND ASSOCIATED DOCUMENTATION THAT QUALITEAM SOFTWARE LTD   |
| (hereinafter referred to as "THE AUTHOR") OF REPUBLIC OF CYPRUS IS          |
| FURNISHING OR MAKING AVAILABLE TO YOU WITH THIS AGREEMENT (COLLECTIVELY,    |
| THE "SOFTWARE"). PLEASE REVIEW THE FOLLOWING TERMS AND CONDITIONS OF THIS   |
| LICENSE AGREEMENT CAREFULLY BEFORE INSTALLING OR USING THE SOFTWARE. BY     |
| INSTALLING, COPYING OR OTHERWISE USING THE SOFTWARE, YOU AND YOUR COMPANY   |
| (COLLECTIVELY, "YOU") ARE ACCEPTING AND AGREEING TO THE TERMS OF THIS       |
| LICENSE AGREEMENT. IF YOU ARE NOT WILLING TO BE BOUND BY THIS AGREEMENT, DO |
| NOT INSTALL OR USE THE SOFTWARE. VARIOUS COPYRIGHTS AND OTHER INTELLECTUAL  |
| PROPERTY RIGHTS PROTECT THE SOFTWARE. THIS AGREEMENT IS A LICENSE AGREEMENT |
| THAT GIVES YOU LIMITED RIGHTS TO USE THE SOFTWARE AND NOT AN AGREEMENT FOR  |
| SALE OR FOR TRANSFER OF TITLE. THE AUTHOR RETAINS ALL RIGHTS NOT EXPRESSLY  |
| GRANTED BY THIS AGREEMENT.                                                  |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

/**
 * "ePDQ" payment module (credit card processor)
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Payment interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v75 (xcart_4_7_7), 2017-01-24 09:29:34, cc_epdq.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET["oid"])) {
    require __DIR__.'/auth.php';
    if (defined('EPDQ_DEBUG')) {
        func_pp_debug_log('epdq_cpi', 'C', $_GET);
    }

    $skey = $_GET['oid'];
    require($xcart_dir.'/payment/payment_ccview.php');

} else {

    if (!defined('XCART_START')) { header("Location: ../"); die("Access denied"); }

    x_load('http');

    $merchant = $module_params['param01'];
    $clientid = $module_params['param02'];
    $phrase   = $module_params['param03'];
    $currency = $module_params['param04'];
    $auth     = $module_params['param05'];
    $cpi_logo = $module_params['param06'];
    $ordr = $module_params['param07'].join("-",$secure_oid);

    // the following parameters have been obtained earlier in the merchant's webstore: clientid, passphrase, oid, currencycode, total
    $post = array();
    $post[] = 'clientid=' . $clientid;
    $post[] = 'password=' . $phrase;
    $post[] = 'oid=' . $ordr;
    $post[] = 'chargetype=' . $auth;
    $post[] = 'currencycode=' . $currency;
    $post[] = 'total=' . $cart['total_cost'];
    $post[] = 'mandatecsc=1';


    list($a1, $epdqdata) = func_https_request('POST', 'https://secure2.epdq.co.uk/cgi-bin/CcxBarclaysEpdqEncTool.e', $post);

    if (defined('EPDQ_DEBUG')) {
        func_pp_debug_log('epdq_cpi', 'I', array('posted_data' => $post, 'response' => $epdqdata));
    }

    if (empty($epdqdata)) {
        $top_message = array(
            'type' => 'E',
            'content' => func_get_langvar_by_name('err_payment_cc_not_found')
        );
        func_header_location($xcart_catalogs['customer']."/cart.php?mode=checkout&paymentid=" . $paymentid);
    }

    $returnurl = $current_location.'/payment/cc_epdq.php';
    if (!$duplicate)
        db_query("REPLACE INTO $sql_tbl[cc_pp3_data] (ref,sessid,trstat) VALUES ('".addslashes($ordr)."','".$XCARTSESSID."','GO|".implode('|',$secure_oid)."')");

?>
  <form action="https://secure2.epdq.co.uk/cgi-bin/CcxBarclaysEpdq.e" method="post" name="process">
    <?php print $epdqdata . "\n"; ?>
    <input type="hidden" name="merchantdisplayname" value="<?php echo htmlspecialchars($merchant); ?>" />
    <input type="hidden" name="cpi_logo" value="<?php echo htmlspecialchars($cpi_logo); ?>" />
    <input type="hidden" name="email" value="<?php echo htmlspecialchars(substr($userinfo['email'], 0, 64)); ?>" />
    <input type="hidden" name="baddr1" value="<?php echo htmlspecialchars(substr($userinfo['b_address'], 0, 60)); ?>" />
    <?php if (!empty($userinfo['b_address_2'])) { ?>
        <input type="hidden" name="baddr2" value="<?php echo htmlspecialchars(substr($userinfo['b_address_2'], 0, 60)); ?>" />
    <?php }?>
    <input type="hidden" name="bcity" value="<?php echo htmlspecialchars(substr($userinfo['b_city'], 0, 25)); ?>" />
    <input type="hidden" name="bcountry" value="<?php echo htmlspecialchars($userinfo['b_country']); ?>" />
    <input type="hidden" name="bpostalcode" value="<?php echo htmlspecialchars($userinfo['b_zipcode']); ?>" />
    <input type="hidden" name="<?php echo htmlspecialchars(($userinfo['b_country']=="US")?('bstate'):('bcountyprovince')); ?>" value="<?php echo htmlspecialchars(($userinfo['b_country']=="US")?($userinfo['b_state']):(substr($userinfo['b_statename'], 0, 25))); ?>" />
    <input type="hidden" name="<?php echo htmlspecialchars(($userinfo['s_country']=="US")?('sstate'):('scountyprovince')); ?>" value="<?php echo htmlspecialchars(($userinfo['s_country']=="US")?($userinfo['s_state']):(substr($userinfo['s_statename'], 0, 25))); ?>" />
    <input type="hidden" name="saddr1" value="<?php echo htmlspecialchars(substr($userinfo['s_address'], 0, 60)); ?>" />
    <?php if (!empty($userinfo['s_address_2'])) { ?>
        <input type="hidden" name="saddr2" value="<?php echo htmlspecialchars(substr($userinfo['s_address_2'], 0, 60)); ?>" />
    <?php }?>
    <input type="hidden" name="scity" value="<?php echo htmlspecialchars(substr($userinfo['s_city'], 0, 25)); ?>" />
    <input type="hidden" name="spostalcode" value="<?php echo htmlspecialchars($userinfo['s_zipcode']); ?>" />
    <input type="hidden" name="scountry" value="<?php echo htmlspecialchars($userinfo['s_country']); ?>" />
    <input type="hidden" name="returnurl" value="<?php echo $returnurl; ?>" />
    </form>
    <table width="100%" style="height: 100%">
    <tr><td align="center" valign="middle">Please wait while connecting to <b>ePDQ</b> payment gateway...</td></tr>
    </table>

<script type="text/javascript">
//<![CDATA[
setTimeout('document.process.submit();', 500);
//]]>
</script>
<?php
}
exit;

?>
