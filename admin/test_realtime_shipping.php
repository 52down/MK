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
 * Test realtime shipping methods interface
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v58 (xcart_4_7_7), 2017-01-24 09:29:34, test_realtime_shipping.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require __DIR__.'/auth.php';
require $xcart_dir.'/include/security.php';

define ('X_SHOW_HTTP_ERRORS', 1);

x_load(
    'http', 'shipping',
    'cart' // For func_cart_is_empty_address_fields function used in func_shipper function
);

if (!isset($weight)) {
    $weight=1;
} else {
    $weight = (float)$weight;
    if ($weight <= 0) {
        $weight = 1;
    }
}

$productid  = isset($productid) ? $productid : (defined('DEVELOPMENT_MODE') ? 17551 : '');
$productid  = intval($productid);

if (!empty($productid)) {
    $productcode = func_query_first_cell("SELECT productcode FROM $sql_tbl[products] WHERE productid = '$productid'");
} else {
    $productcode = '';
}

$length = isset($length) ? $length : 5;
$width  = isset($width) ? $width : 5;
$height = isset($height) ? $height : 4;
$amount = isset($amount) ? $amount : 1;
$price  = isset($price) ? $price : 12.34;

$items = array (
    0 => array
        (
            'cartid' => 1,
            'productid' => $productid,
            'productcode' => $productcode,
            'weight' => $weight,
            'length' => $length,
            'width'  => $width,
            'height' => $height,
            'free_shipping' => 'N',
            'amount' => $amount,    // Quantity of items, for Packages & Insured Value calculation
            'price'  => $price,     // Item price, for Insured Value calculation
            'provider' => 0,        // To avoid PHP notice in USPS module
            'small_item' => 'N',    // Use the dimensions of this product for shipping cost calculation
            'separate_box' => 'N',  // Ship in a separate box
            'items_per_box' => 0,   // Quantity per shipping box (only relevant if $separate_box == 'Y')
        )
);

if (empty($productid)) {
    unset($items[0]['productid']);
    unset($items[0]['productcode']);
}

if (!empty($active_modules['UPS_OnLine_Tools']) and $config['Shipping']['realtime_shipping'] == 'Y' and $config['Shipping']['use_intershipper'] != 'Y') {
    if (isset($selected_carrier))
        $current_carrier = $selected_carrier;
    else
        $current_carrier = '';
    $smarty->assign('current_carrier', $current_carrier);
}

if ($config['Shipping']['use_intershipper'] == 'Y')
    include $xcart_dir.'/shipping/intershipper.php';
else
    include $xcart_dir.'/shipping/myshipper.php';

require $xcart_dir.'/include/countries.php';
require $xcart_dir.'/include/states.php';

$userinfo = array();
if (isset($s_country)) $userinfo['s_country'] = $s_country;
if (isset($s_state)) $userinfo['s_state'] = $s_state;
if (isset($s_zipcode)) $userinfo['s_zipcode'] = $s_zipcode;
if (isset($s_city)) $userinfo['s_city'] = $s_city;
if (isset($s_address)) $userinfo['s_address'] = $s_address;

if (empty($userinfo)) {
    $userinfo['s_country'] = $config['General']['default_country'];
    $userinfo['s_state'] = $config['General']['default_state'];
    $userinfo['s_zipcode'] = $config['General']['default_zipcode'];
    $userinfo['s_city'] = $config['General']['default_city'];
}

if (!empty($origin)) {
    $orig_address = array(
        'address' => $origin['address'],
        'city'    => $origin['city'],
        'state'   => $origin['state'],
        'country' => $origin['country'],
        'zipcode' => $origin['zipcode']
    );
}
else {
    $orig_address = XCShipFrom::getAddressArray();
}

$smarty->assign('orig_address', $orig_address);
$smarty->assign('userinfo', $userinfo);

func_https_ctl('IGNORE');

ob_start();
$intershipper_rates = func_shipper($items, $userinfo, $orig_address, 'Y');
$_content = ob_get_contents();
ob_end_clean();

func_https_ctl('STORE');

$content = "<font>$_content</font><br /><br />";

if (!empty($intershipper_error)) {
    $content .= "Service: $shipping_calc_service<br />Error: ".$intershipper_error;
}

$smarty->assign('productid', $productid);

$smarty->assign('content', $content);
$smarty->assign('weight', $weight);
$smarty->assign('length', $length);
$smarty->assign('width', $width);
$smarty->assign('height', $height);
$smarty->assign('amount', $amount);
$smarty->assign('price', $price);

func_display('admin/main/test_shippings.tpl',$smarty);

?>
