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
 * Module configuration
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ildar Amankulov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    57dbb5ba8cb0569da03c2c3a6f7ff9e4f0c91317, v14 (xcart_4_7_8), 2017-03-13 18:29:10, order_notifications.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../../"); die("Access denied"); }

x_load('order');
#IN

$pilibaba_oid = $pilibaba_oid_int = $_GET['orderNo'];
if (!empty($config['Pilibaba']['pilibaba_prefix'])) {
    $pilibaba_oid_int = intval(preg_replace('/^' . preg_quote($config['Pilibaba']['pilibaba_prefix']) . '/', '', $pilibaba_oid));
}
func_pilibaba_checkout_debug("\t+ \$pilibaba_oid: $pilibaba_oid, int $pilibaba_oid_int");
func_pilibaba_checkout_debug("\t+ \$Fields: ", $_GET);

$ref = func_query_first_cell("SELECT ref FROM $sql_tbl[pilibaba_service_orders] WHERE reserve_pilibaba_oid='$pilibaba_oid_int'");
if (empty($ref)){
    func_pilibaba_checkout_debug("\t+ [Error]: Absent pilibaba_oid: #$pilibaba_oid.");
    func_pilibaba_header_exit(403);
}

$xcart_cart_obj = new XCPilibabaCart();
$xcart_cart_obj->backupOld();

$customer_info = func_pilibaba_customer_info($pilibaba_oid);

$customer_info['email'] = empty($_GET['customerMail']) ? $customer_info['email'] : $_GET['customerMail'];
$customer_info = func_addslashes($customer_info);

x_load('user', 'cart', 'shipping');


func_pilibaba_checkout_debug("\t+ skey: $ref");
func_pilibaba_checkout_restore_session_n_global($ref);

if (empty($cart)) {
    func_pilibaba_checkout_debug("\t+ Cannot restore cart for $ref skey");
    func_array2update('cc_pp3_data', array('param2' => 'F', 'param4' => 'cart is empty'), "ref='$ref'"); // TODO use cart_state for new versions
    return ;
}

//$products = func_products_in_cart($cart, (!empty($user_account['membershipid']) ? $user_account['membershipid'] : ''));

if (empty($login) || $login_type != 'C') {
    // Fill anonymous profile
    $customer_info['usertype'] = 'C';
    func_set_anonymous_userinfo($customer_info);
    func_pilibaba_checkout_debug("\t+ Anonymous profile created");

} else {
    func_pilibaba_checkout_debug("\t+ login: $login, logged_userid: $logged_userid");
    $cart = func_set_cart_address($cart, 'S', $customer_info['address']['S']);
    $cart = func_set_cart_address($cart, 'B', $customer_info['address']['B']);

    // Fill address book for logged customer
    if (func_is_address_book_empty($logged_userid)) {
        foreach ($customer_info['address'] as $addr_type => $val) {
            $val['address'] = $val['address'] . "\n" . @$val['address_2'];
            func_unset($val, 'address_2');
            $val['default_' . strtolower($addr_type)] = 'Y';
            func_save_address($logged_userid, 0, $val);

            func_pilibaba_checkout_debug("\t+ New address($addr_type) has been is added to $login\'s address book");
        }
    } else {
        func_pilibaba_checkout_debug("\t+ Address book is not updated for $login customer");
    }
}

// Update current user info to place it into the order
$cart['userinfo'] = func_array_merge(empty($cart['userinfo']) ? array() : $cart['userinfo'], $customer_info);
$userinfo = $cart['userinfo'] = func_userinfo_from_scratch($cart['userinfo'], 'userinfo_for_payment');
$userinfo['additional_fields'] = $cart['userinfo']['additional_fields'] = empty($userinfo['additional_fields']) ? array() : $userinfo['additional_fields'];

#$shipping = func_pilibaba_get_choosen_shipping3($cart, $products, $shipping_name, $pilibaba_shipping);

#$cart = func_cart_set_shippingid($cart, $shipping['shippingid']);
#$totals = func_pilibaba_get_totals3($parsed, $_products, $pilibaba_oid);
func_pilibaba_checkout_debug("\t+ Calculated total_cost: $cart[total_cost], Received total_cost:$_GET[orderAmount]");

$cart['total_cost'] = empty($cart['total_cost']) ? ($_GET['orderAmount'] / 100) : $cart['total_cost'];
//$cart['shipping_cost'] = $_GET['fee'] / 100;

/*list($cart, $products) = func_generate_products_n_recalculate_cart();
$cart = func_cart_set_shippingid($cart, 0);
$cart = func_cart_set_paymentid($cart, 0);*/
//func_pilibaba_checkout_debug("\t+ Shipping selected - #$cart[shippingid]. '$shipping[shipping]': $cart[shipping_cost]");

// Restore the values from session, not from global scope
unset($secure_oid, $secure_oid_cost, $partner, $partner_clickid, $adv_campaignid);
x_session_register('secure_oid');
x_session_register('secure_oid_cost');
x_session_register('partner');
x_session_register('partner_clickid');
x_session_register('adv_campaignid');

$extra = $extras = array();
$extra['pilibaba_oid'] = $pilibaba_oid;//to mark order as pilibaba
$extras['pilibaba_oid'] = $pilibaba_oid;//to search order by pilibaba PG
// Skip Anti Fraud for Pilibaba orders
$extra['is_acheckout'] = true;// for version before 4.7.7 pilibaba_compatible
$extras['is_acheckout'] = true;

$order_details = func_pilibaba_get_order_details3($_GET);
$orderids = func_place_order('Checkout by Pilibaba ' . ($config['Pilibaba']['pilibaba_mode'] == 'test' ? ' (in test mode)' : ''), 'I', $order_details, '', $extra, $extras);
$xcart_cart_obj->restoreOld();
if (
    empty($orderids)
    || in_array($orderids, XCPlaceOrderErrors::getAllCodes())
) {
    $_err_txt = func_get_langvar_by_name('txt_err_place_order_' . $orderids,  null, FALSE, TRUE);
    x_log_flag('log_payment_processing_errors', 'PAYMENTS', 'Pilibaba checkout payment module: Order has not been created in X-Cart.' . $_err_txt, true);
    func_pilibaba_checkout_debug("\t+ [Error] Order has not been created in X-Cart" . $_err_txt);
    func_array2update('cc_pp3_data', array('param2' => 'F', 'param4' => $_err_txt), "ref='$ref'"); // TODO use cart_state for new versions
    return;
} else {
    func_pilibaba_checkout_debug("\t+ Order placed: orderids (" . implode(',',$orderids) . ")");
}

func_cart_unlock();

$order_status = 'P';
$secure_oid = $orderids;
$secure_oid_cost = $cart['total_cost'];

$oids = implode(',',$secure_oid);

func_pilibaba_checkout_debug("\t+ Order statuses is changed to $order_status for orderids (" . implode(',',$orderids) . ")");
func_change_order_status($orderids, $order_status);

func_array2update('cc_pp3_data', array('param1' => $pilibaba_oid, 'param2' => $order_status, 'param3' => $oids, 'param4' => '', 'trstat' => 'RECV|'), "ref='$ref'"); // TODO use cart_state for new versions


$cart = array();
x_session_save();
func_define('XC_DISABLE_SESSION_SAVE', true); // Do not call x_session_save from register_shutdown_function('x_session_finish'); pilibaba_compatible


echo 'OK';
