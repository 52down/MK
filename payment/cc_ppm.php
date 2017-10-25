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
 * "PurePayMerchant" payment module (credit card processor)
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Payment interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v40 (xcart_4_7_7), 2017-01-24 09:29:34, cc_ppm.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ($_SERVER['REQUEST_METHOD']=="GET" && isset($_GET['ref'])) {
    require __DIR__.'/auth.php';

    $bill_output['mess'] = base64_decode($config['ppm_gateway_data']);

    echo $bill_output['mess'];

} else {
    if (!defined('XCART_START')) { header("Location: ../"); die("Access denied"); }

    $url = $module_params['param01'];
    $id = $module_params['param02'];
    $curr = $module_params['param03'];
    $levels = array("0056"=>"1","0300"=>"1","0380"=>'1','0442'=>'1','0724'=>'1','0392'=>'1');

    if (!is_array($secure_oid))
        $secure_oid = array();
    $ref=$module_params['param04'].join("-",$secure_oid);
    if ($duplicate)
        db_query("delete from $sql_tbl[cc_pp3_data] WHERE sessid='$XCARTSESSID'");

?>
<html>
<body onload="document.process.submit();">
  <form action="<?php echo $url;?>" method="post" name="process">
    <input type="hidden" name="merchantID" value="<?php echo $id; ?>" />
    <input type="hidden" name="lang" value="EN" />
    <input type="hidden" name="currency" value="<?php echo $curr; ?>" />
    <input type="hidden" name="command" value="charge" />
    <input type="hidden" name="amount" value="<?php echo $cart['total_cost']*(($levels[$curr])?(1):(100)); ?>" />
    <input type="hidden" name="merchant" value="<?php echo $ref; ?>" />
  </form>
  <table width="100%" style="height: 100%">
    <tr><td align="center" valign="middle">Please wait while connecting to <b>PurePayMerchant</b> server...</td></tr>
  </table>
</body>
</html>
<?php
}
exit;
?>
