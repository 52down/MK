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
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Customer interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    57dbb5ba8cb0569da03c2c3a6f7ff9e4f0c91317, v26 (xcart_4_7_8), 2017-03-13 18:29:10, amazon_checkout.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require __DIR__.'/auth.php';

if (empty($active_modules['Amazon_Payments_Advanced'])) {
    func_page_not_found();
}

x_load('cart', 'product', 'user', 'shipping', 'xml');

x_session_register('cart');

x_session_register('intershipper_rates');
x_session_register('intershipper_recalc');

if (!defined('ALL_CARRIERS')) {
    define('ALL_CARRIERS', 1);
}

// can't checkout with empty cart
if (func_is_cart_empty($cart)) {
    func_header_location('cart.php');
}

x_session_register('amazon_pa_order_ref_id');
x_session_register('amazon_pa_client_access_token');

if ($REQUEST_METHOD == 'GET') {

    if (!empty($amz_pa_gaorid) && !empty($amz_pa_gaact)) {
        $amazon_pa_order_ref_id = $amz_pa_gaorid;
        $amazon_pa_client_access_token = $amz_pa_gaact;

        func_header_location($xcart_catalogs['customer'].'/amazon_checkout.php');
    }

    $intershipper_recalc = 'Y';

    if (!empty($amazon_pa_order_ref_id) && !empty($amazon_pa_client_access_token)) {

        $shipping_address = func_amazon_pa_get_aorefid_shipping_address($amazon_pa_order_ref_id, $amazon_pa_client_access_token);

        if (!empty($shipping_address)) {
            $uinfo = func_userinfo(0, $login_type, false, false, 'H');

            foreach ($shipping_address as $k => $v) {
                $uinfo['address']['B'][$k] = $v;
                $uinfo['address']['S'][$k] = $v;
            }

            $uinfo['firstname'] = $shipping_address['firstname'];
            $uinfo['lastname'] = $shipping_address['lastname'];

            func_set_anonymous_userinfo($uinfo);
        }
    }
}

$cart = func_cart_set_paymentid($cart, 0);

$products = func_products_in_cart($cart, @$userinfo['membershipid']);

$cart = func_array_merge(
    $cart,
    func_calculate(
        $cart,
        $products,
        0, // $logged_userid, // always anonymous
        $current_area,
        0
    )
);

if ($REQUEST_METHOD == 'POST') {

    if ($mode == 'check_address' && !empty($amazon_pa_order_ref_id) && !empty($amazon_pa_client_access_token)) {

        $addr_set = false;

        $billing_address = func_amazon_pa_get_aorefid_billing_address($amazon_pa_order_ref_id, $amazon_pa_client_access_token);
        $shipping_address = func_amazon_pa_get_aorefid_shipping_address($amazon_pa_order_ref_id, $amazon_pa_client_access_token);

        if (!empty($billing_address)) {
            $uinfo = func_userinfo(0, $login_type, false, false, 'H');

            foreach ($billing_address as $k => $v) {
                $uinfo['address']['B'][$k] = $v;
            }

            if (!empty($profile_info)) {
                $uinfo = array_merge($uinfo, $profile_info);
            }

            func_set_anonymous_userinfo($uinfo);
        }

        if (!empty($shipping_address)) {
            $uinfo = func_userinfo(0, $login_type, false, false, 'H');

            foreach ($shipping_address as $k => $v) {
                if (empty($billing_address)) {
                    $uinfo['address']['B'][$k] = $v;
                }
                $uinfo['address']['S'][$k] = $v;
            }

            if (!empty($profile_info)) {
                $uinfo = array_merge($uinfo, $profile_info);
            }

            func_set_anonymous_userinfo($uinfo);
            $addr_set = true;
        }

        if (!$addr_set) {
            echo 'error';
            func_amazon_pa_error("Check address error: amazon_pa_order_ref_id=$amazon_pa_order_ref_id");
        } else {
            echo 'ok';
        }

    } elseif ($mode == 'change_shipping' && !empty($shippingid)) {

        $cart = func_cart_set_shippingid($cart, $shippingid);
        echo 'ok';

    } elseif ($action == 'place_order' && !empty($amazon_pa_order_ref_id) && !empty($amazon_pa_client_access_token)) {

        if (func_is_cart_empty($cart)) {
            $top_message['type'] = 'E';
            $top_message['content'] = 'cart is empty';
            func_header_location('amazon_checkout.php?amz_pa_gaorid=' . $amazon_pa_order_ref_id . '&amz_pa_gaact=' . $amazon_pa_client_access_token);
        }

        x_load('order','payment'); // payment is for Func_get_urlencoded_orderids

        $billing_address = func_amazon_pa_get_aorefid_billing_address($amazon_pa_order_ref_id, $amazon_pa_client_access_token);
        $shipping_address = func_amazon_pa_get_aorefid_shipping_address($amazon_pa_order_ref_id, $amazon_pa_client_access_token);

        $profile_info = func_amazon_pa_get_aorefid_profile_info($amazon_pa_order_ref_id, $amazon_pa_client_access_token);

        if (!empty($billing_address)) {
            $uinfo = func_userinfo(0, $login_type, false, false, 'H');

            foreach ($billing_address as $k => $v) {
                $uinfo['address']['B'][$k] = $v;
            }

            if (!empty($profile_info)) {
                $uinfo = array_merge($uinfo, $profile_info);
            }

            func_set_anonymous_userinfo($uinfo);
        }

        if (!empty($shipping_address)) {
            $uinfo = func_userinfo(0, $login_type, false, false, 'H');

            foreach ($shipping_address as $k => $v) {
                if (empty($billing_address)) {
                    $uinfo['address']['B'][$k] = $v;
                }
                $uinfo['address']['S'][$k] = $v;
            }

            if (!empty($profile_info)) {
                $uinfo = array_merge($uinfo, $profile_info);
            }

            func_set_anonymous_userinfo($uinfo);
        }

        // prepare order data
        $customer_notes = $Customer_Notes;
        $extra = array();
        if (func_amazon_pa_is_API_in_test_mode()) {
            $extra['in_testmode'] = true;
        }
        $extra['AmazonOrderReferenceId'] = $amazon_pa_order_ref_id;

        $payment_method_text = func_get_langvar_by_name('module_name_Amazon_Payments_Advanced', null, false, true);

        // place not finished order
        $old_logged_userid = $logged_userid;
        $logged_userid = 0;
        $orderids = func_place_order( //{{{ simulate anonymous checkout
            $payment_method_text,
            'I',
            '',
            $customer_notes,
            $extra
        );
        $logged_userid = $old_logged_userid; // simulate anonymous checkout }}}

        if (empty($orderids) || in_array($orderids, XCPlaceOrderErrors::getAllCodes())) {
            $top_message = array(
                'content'   => func_get_langvar_by_name('txt_err_place_order_' . $orderids),
                'type'      => 'E',
            );

            func_header_location($xcart_catalogs['customer'] . '/cart.php');
        }

        if (
            !empty($active_modules['Anti_Fraud'])
            && function_exists('func_antifraud_check_block_order')//is added to avoid 'Could not patch' on upgrade from 4.7.[0-3] to 4.7.7
            && func_antifraud_check_block_order($orderids)
        ) {
            func_antifraud_decline_orders_n_redirect2error_page($orderids);
        }

        $_orderids_url_ready = func_get_urlencoded_orderids($orderids);

        $amazonAPI = func_amazon_pa_get_client_API();

        $params1 = array(
            'amazon_order_reference_id' => $amazon_pa_order_ref_id,
            'address_consent_token'     => $amazon_pa_client_access_token,
            'amount'                    => $cart['total_cost'],
            'currency_code'             => $config['Amazon_Payments_Advanced']['amazon_pa_currency'],
            'seller_note'               => func_amazon_pa_get_API_seller_notes(),
            'seller_order_id'           => urldecode($_orderids_url_ready),
            'store_name'                => $config['Company']['company_name'],
            'custom_information'        => '',
        );
        $response1 = $amazonAPI->setOrderReferenceDetails($params1);
        func_amazon_pa_debug('setOrderReferenceDetails:' . print_r($params1, true));
        func_amazon_pa_debug('result:' . print_r($response1->toArray(), true));

        $params2 = array(
            'amazon_order_reference_id' => $amazon_pa_order_ref_id,
        );
        $response2 = $amazonAPI->confirmOrderReference($params2);
        func_amazon_pa_debug('confirmOrderReference:' . print_r($params2, true));
        func_amazon_pa_debug('result:' . print_r($response2->toArray(), true));


        list($order_status, $advinfo, $amz_authorized) = XCAmazonOrder::authorize($amazon_pa_order_ref_id, $cart['total_cost'], $orderids);

        // change order status
        $override_completed_status = ($order_status != 'P');
        func_change_order_status($orderids, $order_status, join("\n", $advinfo), $override_completed_status);

        // show invoice or error message
        if ($order_status == 'F' || $order_status == 'D') {

            if (!empty($cart['applied_giftcerts'])) {
                $cart['applied_giftcerts_db_block_is_needed'] = true;
            }

            $bill_error = 'error_ccprocessor_error';
            $reason = "&bill_message=";
            if ($order_status == 'F') {
                // some error
                $reason .= urlencode(func_get_langvar_by_name('txt_payment_transaction_error', null, false, true));
            } elseif ($order_status == 'D') {
                // transaction declined
                $reason .= urlencode(func_get_langvar_by_name('txt_payment_transaction_is_failed', null, false, true));
            }

            func_header_location($xcart_catalogs['customer'] . "/error_message.php?" . "error=" . $bill_error . $reason);

        } else {

            if ($order_status == 'P' || $order_status == 'Q' || $order_status == 'A') {
                $cart = '';
            }

            func_header_location($xcart_catalogs['customer'] . "/cart.php?mode=order_message&orderids=$_orderids_url_ready");
        }
    }

    exit();
}

include $xcart_dir . '/include/common.php';

$current_carrier = '';
$checkout_module = '';

$userinfo = func_userinfo(0, $login_type, false, false, 'H');
include $xcart_dir . '/include/cart_calculate_totals.php';

$smarty->assign('cart', $cart);
$smarty->assign('products', $products);

$smarty->assign('amazon_pa_order_ref_id', $amazon_pa_order_ref_id);
$smarty->assign('amazon_pa_client_access_token', $amazon_pa_client_access_token);

$smarty->assign('main', 'checkout');
$smarty->assign('checkout_module', 'Amazon_Payments_Advanced');
$smarty->assign('page_container_class', 'opc-container checkout-container');

func_display('customer/home.tpl',$smarty);
