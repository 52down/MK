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
 * X-Payments iframe handling script
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v37 (xcart_4_7_7), 2017-01-24 09:29:34, cc_xpc_iframe.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */


if (isset($_GET['xpc_action']) || isset($_POST['xpc_action'])) {

    require_once '../top.inc.php';
    define('SKIP_CHECK_REQUIREMENTS.PHP', true);
    define('QUICK_START', true);
    define('SKIP_ALL_MODULES', true);
    define('AREA_TYPE', 'C');
    if (!empty($_GET['xpc_action']) && $_GET['xpc_action'] == 'xpc_popup_show_message') {
        define('DO_NOT_START_SESSION', 1);
    }
    require_once '../init.php';
}

if (!isset($_GET['xpc_action']) && !isset($_POST['xpc_action'])) {
    $xpc_action = '';
}

if ($xpc_action == 'xpc_popup') {

    if (!func_is_ajax_request()) {
        exit;
    }
    
    // Initialize X-Payments Connector module 
    $include_func = true;
    require_once '../modules/XPayments_Connector/config.php';
    func_xpay_func_load();

    if (
        !empty($paymentid)
        && (
            $type == XPC_IFRAME_CLEAR_INIT_DATA
            || $type == XPC_IFRAME_CHANGE_METHOD
        )
    ) {
        xpc_clear_initiated_payment_in_session($paymentid);
    }

    if ($type == XPC_IFRAME_CHANGE_METHOD && empty($save_cc)) {
        x_load('cart');
        x_session_register('cart');
        $new_paymentid = 0;

        $payment_methods = check_payment_methods(!empty($user_account['membershipid']) ? $user_account['membershipid'] : 0);
        foreach ($payment_methods as $pm) {
            if ($pm['processor_file'] != 'cc_xpc.php' && $pm['payment_script'] != 'payment_xpc_recharge.php') {
                $new_paymentid = $pm['paymentid'];
                break;
            }
        }

        $cart = func_cart_set_paymentid($cart, $new_paymentid);
    }

    // Set popup to reload page on close and add OK button
    $lbl_ok = func_get_langvar_by_name('lbl_ok', NULL, FALSE, TRUE);
    $close_action = ($type != XPC_IFRAME_ALERT) ? 'window.location.reload();' : '$'+"(o.element).dialog('destroy').remove();";

    if (func_strlen($payment_method, !empty($default_charset) ? $default_charset : 'UTF-8') > 32) {
        // Strip too long payment method name because it will not fit popup 
        $payment_method = func_substr($payment_method, 0, 32). '...';
    }

    $jscode = <<<JS
var buttons = {};
buttons['$lbl_ok'] = function() {
    o.close();
}

$(o.element).dialog(
    {
        title: '$payment_method',
        close: function() {
            $close_action
        },
        buttons: buttons
    }
);
JS;

    func_register_ajax_message(
        'popupDialogCall',
        array(
            'action' => 'jsCall',
            'toEval' => $jscode
        )
    );

    // Show error text
    func_register_ajax_message(
        'popupDialogCall',
        array(
            'action' => 'load',
            'src'    => $current_location . '/payment/cc_xpc_iframe.php?xpc_action=xpc_popup_show_message&type=' . intval($type) . '&message=' . urlencode(stripslashes($message)),
        )
    );


    func_ajax_finalize();

} elseif ($xpc_action == 'xpc_popup_show_message') {

    if (isset($message) && strlen($message) > 0) {
        $lang_msg = func_get_langvar_by_name($message, null, false, true);
        if ($lang_msg) {
            $message = $lang_msg;
        } else {
            $message = stripslashes($message);
        }
    } else {
        $message = '';
    }

    $smarty->assign('type', $type);
    $smarty->assign('message', $message);
    
    func_flush(func_display('modules/XPayments_Connector/xpc_popup.tpl', $smarty, false));

} elseif ($xpc_action == 'xpc_before_place_order') {

    // Initialize X-Payments Connector module
    $include_func = true;
    require_once '../modules/XPayments_Connector/config.php';
    
    func_xpay_func_load();

    if (!xpc_api_supported('1.6')) {
        xpc_set_allow_save_cards(!empty($allow_save_cards) && 'Y' == $allow_save_cards);
    }

    // Save details in session to use on check_cart callback
    $extras = array(
        'customer_notes' => !empty($Customer_Notes) ? $Customer_Notes : '',
        'ip' => $CLIENT_IP,
        'proxy_ip' => $PROXY_IP,
        'store_currency' => !empty($store_currency) ? $store_currency : '',
        'mailchimp_subscription' => !empty($mailchimp_subscription) ? $mailchimp_subscription : array(),
    );
    xpc_set_customer_extras_in_session($extras);

    if (!empty($partner_id)) {
        include $xcart_dir . '/include/partner_info.php';
    }

} elseif (empty($xpc_action) && !empty($_GET['paymentid'])) {

    if (
        defined('XCART_SESSION_START')
        && !empty($current_area)
        && (
            $current_area == 'A'
            || $current_area == 'P' && !empty($active_modules['Simple_Mode'])
        )
    ) {
        $is_admin = true;
        $save_cc = true;
    } else {
        require_once __DIR__ . '/auth.php';
        $is_admin = false;
        $for_userid = $logged_userid;
    }

    func_xpay_func_load();
    
    if (xpc_api_supported('1.3')) {

        x_load('cart', 'user');

        if (empty($save_cc)) {
            x_session_register('cart');
            $united_cart = $cart;

            if (empty($united_cart['products'])) {
                // For backwards compatibility
                x_session_register('products');
                if (!empty($products)) {
                    $united_cart['products'] = $products;
                }
            }
            $united_cart['userinfo'] = func_userinfo($for_userid);

        } else {
            $united_cart = xpc_get_save_card_cart($for_userid);
        }

        $xpc_payment = xpc_get_initiated_payment_from_session($paymentid, (empty($save_cc) ? 'checkout' : 'save_cc'));
     
        if ($xpc_payment) {

            // Payment was already initiated - use existing token and redirect to XP directly

            $redirect_form = xpc_get_initiated_payment_redirect_form($xpc_payment);

            xpc_display_payment_redirect_form($redirect_form, xpc_allow_save_card($paymentid, $cart, !empty($save_cc)));

        } else {

            // Should inititate new payment
            $ref_id = md5($for_userid . $paymentid . XC_TIME);

            func_array2insert(
                'cc_pp3_data',
                array(
                    'ref'    => 'XPC' . $ref_id,
                    'sessid' => $XCARTSESSID,
                    'param1' => 'TEMPORARY',
                    'param2' => $for_userid,
                    'param3' => (empty($save_cc) ? '' : 'SAVE_CC'),
                    'param4' => (empty($is_admin) ? '' : 'A'),
                ),
                true
            );

            list($status, $response) = xpc_request_payment_init(
                intval($paymentid),
                $ref_id,
                $united_cart,
                !empty($save_cc), // forces Auth when in save_cc mode
                empty($save_cc) ? 'temporary' : 'save_cc'
            );

            if ($status) {

                xpc_save_initiated_payment_in_session($paymentid, $response['fields']['token'], (empty($save_cc) ? 'checkout' : 'save_cc'));

                xpc_display_payment_redirect_form($response, xpc_allow_save_card($paymentid, $cart, !empty($save_cc)));

            } else {

                // Post message to parent window which will show popup with default error
                $error = !empty($response['detailed_error_message']) ? $response['detailed_error_message'] : '';
                xpc_iframe_popup_error($error);

            }

        }
    } else {

        /* Legacy iframe which produces a lot of X-Payments Started orders is not supported */
        xpc_iframe_popup_error('Iframe embed is not supported in the current X-Payments version.');

    }

}

?>
