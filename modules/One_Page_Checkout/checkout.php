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
 * This script implements checkout facility for One Page Checkout module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage One Page Checkout
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v51 (xcart_4_7_7), 2017-01-24 09:29:34, checkout.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header('Location: ../../'); die('Access denied'); }

x_session_register('login_antibot_on');

$smarty->assign('allow_popup_login', empty($login_antibot_on));

$paymentid = func_cart_get_paymentid($cart, $checkout_module);
if (!func_is_valid_payment_method($paymentid)) {
    $cart = func_cart_set_paymentid($cart, 0);
    $top_message['content'] = func_get_langvar_by_name('err_payment_cc_not_available');
    $top_message['type']    = 'E';
    func_header_location('cart.php');
} else {
    $cart = func_cart_set_paymentid($cart, $paymentid);
}

if (
    !empty($shipping)
    && (
        !isset($cart['shippingid'])
        || empty($cart['shippingid'])
    )
) {
    $cart['shippingid'] = $shipping[0]['shippingid'];
}

if ($cart['total_cost'] == 0) {
    func_paypal_express_enable_1step();
}

$shippingid = (isset($shippingid) && !empty($shippingid))
    ? $shippingid
    : $cart['shippingid'];

/**
 * Prepare checkout details
 */

if ($checkout_step_modifier['payment_methods'] == 1) {
    $smarty->assign('ignore_payment_method_selection', 1);
}

if (!empty($payment_methods)) {
    x_load('paypal');

    foreach ($payment_methods as $k => $payment_data) {

        $payment_data['payment_script_url'] = $current_location . '/payment/' . $payment_data['payment_script'];

        if ($payment_data['paymentid'] == $paymentid) {
            $smarty->assign('payment_script_url', $payment_data['payment_script_url']);
            $smarty->assign('payment_method',     $payment_data['payment_method']);
        }

        $payment_methods[$k] = $payment_data;
    }
}

$smarty->assign('cart', $cart);

$paypal_expressid = func_cart_get_paypal_express_id();

if (
    $paymentid == $paypal_expressid
    && func_is_confirmed_paypal_express()
) {

    $smarty->assign('paypal_express_selected', true);
    $smarty->assign('paypal_expressid', $paypal_expressid);
}

if (!empty($active_modules['XPayments_Connector'])) {
    func_xpay_func_load();
    $smarty->assign('xpc_allow_full_width_iframe', xpc_api_supported('1.6'));
}

?>
