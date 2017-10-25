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
 * X-Payments Connector addon 
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Payment interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    fdf4c40775b539a54bc228e488550b992e275a43, v85 (xcart_4_7_8), 2017-05-31 11:32:26, cc_xpc.php, Ildar
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

$cur_auth_path = dirname(__FILE__) . '/auth.php';
$old_auth_path = dirname(__FILE__) . '/../auth.php';
$auth_path = is_file($cur_auth_path) && is_readable($cur_auth_path) ? $cur_auth_path : $old_auth_path;

if (
    $_SERVER['REQUEST_METHOD'] == 'POST' 
    && !empty($_POST['action'])
    && $_POST['action'] == 'return' 
    && !empty($_POST['refId']) 
    && !empty($_POST['txnId'])
) {

    // Return

    require_once $auth_path;

    func_xpay_func_load();

    xpc_send_anticache_headers();

    $key = 'XPC' . $_POST['refId'];
    $cc_pp3_data = func_query_first("SELECT sessid, param2, param3, param4 FROM $sql_tbl[cc_pp3_data] WHERE ref = '$key'");
    $bill_output['sessid'] = $cc_pp3_data['sessid'];

    list($status, $response) = xpc_request_get_payment_info($_POST['txnId']);

    $is_save_card_request = ($cc_pp3_data['param3'] == 'SAVE_CC');
    $is_admin_save_card   = ($cc_pp3_data['param4'] == 'A');

    $for_userid = ($is_save_card_request) ? intval($cc_pp3_data['param2']) : $logged_userid;
    $card_saved = false;

    $extra_order_data = array(
        'xpc_txnid' => $_POST['txnId'],
    );

    xpc_clear_initiated_payment_in_session();

    if ($status) {

        $bill_output['code'] = 2;

        if (!empty($response['maskedCardData'])) {

            // API 1.5 or higher

            $masked_data = $response['maskedCardData'];
            $card_num = $masked_data['first6'] . str_repeat('*', 6) . $masked_data['last4'];
            $card_type = $masked_data['type'];
            $card_expire = $masked_data['expire_month'] . '/' . $masked_data['expire_year'];

        } else {

            // Backward compatibility

            if (isset($_POST['last_4_cc_num'])) {
                $last_4_cc_num = $_POST['last_4_cc_num'];
            } elseif (isset($_GET['last_4_cc_num'])) {
                $last_4_cc_num = $_GET['last_4_cc_num'];
            } else {
                $last_4_cc_num = '';
            }

            if (isset($_POST['card_type'])) {
                $card_type = $_POST['card_type'];
            } elseif (isset($_GET['card_type'])) {
                $card_type = $_GET['card_type'];
            } else {
                $card_type = '';
            }

            $card_num = ($last_4_cc_num ? (str_repeat('*', 12) . $last_4_cc_num) : '');
            $card_expire = '';

        }

        if ('' !== $card_num) { 
            $extra_order_data['xpc_saved_card_num'] = $card_num;
            $extra_order_data['xpc_saved_card_type'] = $card_type;
            if ('' !== $card_expire) {
                $extra_order_data['xpc_saved_card_expire'] = $card_expire;
            }
        }

        // This field is only available since API 1.6
        $is_save_card_selected = xpc_api_supported('1.6') ? ('Y' == $response['saveCard']) : true;

        if (
            !$is_save_card_request
            && $is_save_card_selected
            && (
                xpc_api_supported('1.6')
                || xpc_get_allow_save_cards()
            )
            && xpc_use_recharges($cart['paymentid'])
        ) {
            // This is not save card request, but customer selected to save card during regular checkout
            $extra_order_data['xpc_use_recharges'] = 'Y';
        }

        x_session_register('secure_oid');

        if ($response['status'] == PAYMENT_AUTH_STATUS || $response['status'] == PAYMENT_CHARGED_STATUS) {

            $bill_output['code'] = 1;

            if (
                $is_save_card_request && $is_save_card_selected
                || !empty($extra_order_data['xpc_use_recharges'])
            ) {
                $orig_orderid = !empty($secure_oid[0]) ? $secure_oid[0] : 0;

                $card_saved = xpc_store_saved_card(
                    $for_userid,
                    array(
                        'card_num' => $card_num,
                        'card_type' => $card_type,
                        'card_expire' => $card_expire,
                    ),
                    '',
                    $_POST['txnId'],
                    $orig_orderid,
                    (!$is_save_card_request) ? $cart['paymentid'] : xpc_get_save_cc_paymentid()
                );

                $extra_order_data['xpc_saved_card_id'] = $card_saved;

                if (
                    !empty($active_modules['XPayments_Subscriptions'])
                    && isset($card_saved)
                ) {
                    func_xps_attachCardToSubscriptions($orig_orderid, $card_saved);
                }

            }

        } elseif ($response['transactionInProgress']) {

            $bill_output['code'] = 3;

        }

        $bill_output['billmes'] = ($bill_output['code'] == 1)
            ? $response['message']
                . "\n"
                . 'Paid by card: ' . $card_type . ' ' . $card_num . ' ' . $card_expire
            : $response['lastMessage'];

        if (!empty($response['3dsecure']) && is_array($response['3dsecure'])) {
            $bill_output['cavvmes'] = '3-D Secure: ' . "\n";
            foreach ($response['3dsecure'] as $s3d_key => $s3d_value) {
                if (!empty($s3d_value)) {
                    $bill_output['cavvmes'] .= ' - ' . $s3d_key . ': ' . $s3d_value . "\n";
                }
            }
        }

        if (
            !empty($active_modules['Anti_Fraud'])
            && func_antifraud_check_xpc_return_message_for_blocked_order($secure_oid, $bill_output['billmes'])
        ) {
            // Correct error message for orders blocked by AntiFraud
            $bill_output['billmes'] = func_get_langvar_by_name('txt_err_place_order_antifraud_block');
        }

        if (
            $response['status'] == PAYMENT_AUTH_STATUS
            || (
                $response['authorizeInProgress'] > 0 
                && $bill_output['code'] == 3
            )
        ) {

            $extra_order_data['capture_status'] = 'A';

            $bill_output['is_preauth'] = true;

        } else {

            $extra_order_data['capture_status'] = '';

        }

        if (
            $bill_output['code'] == 1 
            && $response['isFraudStatus']
        ) {

            $extra_order_data['fmf_blocked'] = 'Y';

        }

        $payment_return = array(
            'total'     => $response['amount'],
            'currency'  => $response['currency'],
            '_currency' => xpc_get_currency($_POST['refId']),
        );

        $xpc_order_status = xpc_get_order_status_by_action($response['status']);

        if (
            $bill_output['code'] == 1
            && !empty($active_modules['Anti_Fraud'])
            && func_antifraud_check_xpc_block_avs($response)
        ) {
            // Order status should be changed because of the AVS error

            $_oid = intval(@$secure_oid[0]);

            $_extra = func_query_first_cell("SELECT extra FROM $sql_tbl[orders] WHERE orderid = '$_oid'");
            $_extra = unserialize($_extra);

            if (
                is_array($_extra['Anti_Fraud'])
                && is_array($_extra['Anti_Fraud']['data'])
            ) {
                // Instead of the IS_AF_CHECK which is not defined here we check the existed data 
                
                $extra_order_data_inner['Anti_Fraud'] = $_extra['Anti_Fraud'];
                $extra_order_data_inner['Anti_Fraud']['data']['blocked_by_avs'] = 1;

                $xpc_order_status = 'Q';
                $bill_output['code'] = 3;

                define('STATUS_CHANGE_REF', 6);
            }
        }

    } else {

        $bill_output['code'] = 2;
        $bill_output['billmes'] = 'Internal error';

    }

    if ($is_save_card_request) {
        db_query("DELETE FROM $sql_tbl[cc_pp3_data] WHERE ref = '$key'");
    
        if ($card_saved) {
            $top_message = array(
                'type' => 'I',
                'content' => func_get_langvar_by_name('msg_xpc_new_card_saved'),
            );
        } else {
            $top_message = array(
                'type' => 'E',
                'content' => (!empty($response['lastMessage'])
                                ? $response['lastMessage']
                                : func_get_langvar_by_name('txt_payment_transaction_is_failed')
                            ),
            );
        }

        $redirect_page = 
                ($is_admin_save_card)
                ? DIR_ADMIN . '/user_modify.php?usertype=C&user=' . $for_userid
                : DIR_CUSTOMER . '/saved_cards.php'; 

        func_iframe_redirect($current_location . $redirect_page);
        exit;
    }

    $weblink = false;

    if ($config['XPayments_Connector']['xpc_use_iframe'] == 'Y') {
        $is_iframe = true;
        $use_xpc_iframe_redirect = true;
    }

    require($xcart_dir . '/payment/payment_ccend.php');

    exit;

} elseif (
    $_SERVER['REQUEST_METHOD'] == 'GET' 
    && !empty($_GET['action'])
    && (
        $_GET['action'] == 'cancel'
        || $_GET['action'] == 'abort' 
    ) && !empty($_GET['refId']) 
    && !empty($_GET['txnId'])
) {

    // Cancel

    require_once $auth_path;

    func_xpay_func_load();

    xpc_send_anticache_headers();

    $key = 'XPC' . $_GET['refId'];

    $bill_output['sessid'] = func_query_first_cell("SELECT sessid FROM $sql_tbl[cc_pp3_data] WHERE ref = '" . $key . "'");

    $bill_output['code'] = 2;

    $bill_output['billmes'] = 'cancel' == $_GET['action']
        ? 'Cancelled by customer'
        : 'Aborted due to errors during transaction processing';

    $weblink = false;

    $paymentid = intval($cart['paymentid']);

    if ($config['XPayments_Connector']['xpc_use_iframe'] == 'Y') {
        $is_iframe = true;
        $use_xpc_iframe_redirect = true;
    }

    require($xcart_dir . '/payment/payment_ccend.php');

    exit;

} elseif (
    $_SERVER['REQUEST_METHOD'] == 'POST'
    && !empty($_POST['txnId'])
    && !empty($_POST['action'])
    && (
        ($_POST['action'] == 'callback' && !empty($_POST['updateData']))
        || ($_POST['action'] == 'check_cart' && !empty($_POST['refId']))
    )
) {

    // Callback or check cart

    require_once $auth_path;

    func_xpay_func_load();

    xpc_send_anticache_headers();

    // Since output should be clean for callbacks,
    // we need to disable errors and notices display.
    // Check logs (if enabled) for them.
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    if (defined('DEVELOPMENT_MODE')) {
        function _xpc_assert_handler($file, $line, $code) {
            x_log_add('Assertion', debug_backtrace(!DEBUG_BACKTRACE_PROVIDE_OBJECT));
            if (strpos($code, '(EE)') !== FALSE) {
                die;
            }
        }
        assert_options(ASSERT_CALLBACK, '_xpc_assert_handler');
    }

    // Check module
    if (empty($active_modules['XPayments_Connector'])) {

        if (function_exists('x_log_add')) {
            x_log_add('xpay_connector', 'X-Payments Connector callback script is called', true);
        } else {
            error_log('xpay_connector: X-Payments Connector callback script is called', 0);
        }

        exit;

    }

    // Check callback IP addresses
    $ips = preg_grep('/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/Ss', array_map('trim', explode(',', $config['XPayments_Connector']['xpc_allowed_ip_addresses'])));

    $found = false;

    foreach ($ips as $ip) {
        if ($_SERVER['REMOTE_ADDR'] == $ip) {
            $found = true;
            break;
        }
    }

    if (
        $ips 
        && !$found
    ) {

        if (function_exists('x_log_add')) {
            x_log_add('xpay_connector', 'X-Payments Connector callback script is called from wrong IP address: \'' . $_SERVER['REMOTE_ADDR'] . '\'', true);
        } else {
            error_log('xpay_connector: X-Payments Connector callback script is called from wrong IP address: \'' . $_SERVER['REMOTE_ADDR'] . '\'', 0);
        }

        exit;

    }

    if ($action == 'callback') {

        // Release connection to speed up checkout
        xpc_force_close_connection();

        list($responseStatus, $response) = xpc_decrypt_xml($updateData);

        if (!$responseStatus) {

            xpc_api_error('Callback request is not decrypted (Error: ' . $response . ')');

            exit;
        }

        // Convert XML to array
        $response = xpc_xml2hash($response);

        if (!is_array($response)) {

            xpc_api_error('Unable to convert callback request into XML');

            exit;
        }

        // The 'Data' tag must be set in response
        if (!isset($response[XPC_TAG_ROOT])) {

            xpc_api_error('Callback request does not contain any data');

            exit;
        }

        $response = $response[XPC_TAG_ROOT];

        // Process data
        if (!xpc_api_process_error($response)) {

            if (!xpc_api_supported('1.7')) {
                // Backwards compatibility only - needed to get Kount info
                list($status, $detailed_response) = xpc_request_get_additional_info_by_txnid($txnId);

                if (
                    $status
                    && isset($detailed_response['transactions'])
                    && !empty($detailed_response['transactions'])
                ) {
                    $response['transactions'] = $detailed_response['transactions'];
                } else {
                    $response['transactions'] = array();
                }
            }

            xpc_update_payment($txnId, $response);

        }

    } else {

        // Check cart callback request

        $ref_key = 'XPC' . $_POST['refId'];
        $cc_pp3_data = func_query_first("SELECT sessid, param1, param2, param3 FROM $sql_tbl[cc_pp3_data] WHERE ref = '" . $ref_key . "'");

        x_session_id($cc_pp3_data['sessid']);
        x_session_register('secure_oid');
        include $xcart_dir . '/include/partner_info.php';

        $for_userid = intval($cc_pp3_data['param2']);

        $data = array(
            'status' => 'cart-not-changed',
        );

        xpc_clear_initiated_payment_in_session();

        if (
            !xpc_api_supported('1.3')
            || $cc_pp3_data['param1'] != 'TEMPORARY'
        ) {
            // Use backward compatiblity mode
            if (!$secure_oid) {
                // Order id was lost, need to create new order - throw error
                $data['status'] = 'cart-changed';
            }

        } elseif ($cc_pp3_data['param3'] == 'SAVE_CC') {
            // This is a save card request, billing address should be actual
            $data['status'] = 'cart-changed';
            $data['ref_id'] =  $_POST['refId'];
            $data['cart'] = xpc_prepare_cart(
                xpc_get_save_card_cart($for_userid),
                $data['ref_id'],
                true,
                'save_cc'
            );
            $data['saveCard'] = 'Y';

        } else {
            // Send actual cart and saveCard values
            $data['status'] = 'cart-changed';

            x_session_register('cart');

            x_load(
                'user',
                'crypt',
                'order',
                'payment',
                'tests'
            );

            $paymentid = intval($cart['paymentid']);

            x_session_register('logged_paymentid');
            $logged_paymentid = $paymentid;

            x_session_register('secure_oid_cost');
            x_session_register('initial_state_orders', array());
            x_session_register('initial_state_show_notif', 'Y');

            $module_params = func_get_pm_params($paymentid);
            $in_testmode = get_cc_in_testmode($module_params);

            $extra = array();
            if ($in_testmode) {
                $extra['in_testmode'] = $in_testmode;
            }

            $payment_method_text = xpc_compose_payment_method_text($paymentid);

            $united_cart = $cart;
            $united_cart['userinfo'] = func_userinfo($for_userid);

            if (empty($united_cart['products'])) {
                // For backwards compatibility
                x_session_register('products');
                if (!empty($products)) {
                    $united_cart['products'] = $products;
                }
            }

            $customer_extras = xpc_pop_customer_extras_from_session();

            $customer_notes = $customer_extras['customer_notes'];

            // Restore real customer IP and other saved data
            $CLIENT_IP = $customer_extras['ip'];
            $PROXY_IP = $customer_extras['proxy_ip'];

            if (!empty($active_modules['XMultiCurrency'])) {
                $store_currency = $customer_extras['store_currency'];
            }

            if (
                !empty($active_modules['Adv_Mailchimp_Subscription'])
                && !empty($customer_extras['mailchimp_subscription'])
            ) {
                func_mailchimp_batch_subscribe($united_cart['userinfo'], $customer_extras['mailchimp_subscription']);
            }

            if (func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[payment_methods] WHERE paymentid = '$paymentid' AND af_check = 'Y'")) {
                define('IS_AF_CHECK', true);
            }

            $orderids = func_place_order(
                $payment_method_text,
                'I', // X status is not used since API 1.3
                '',
                $customer_notes,
                $extra
            );

            if (
                !empty($orderids)
                && !in_array($orderids, XCPlaceOrderErrors::getAllCodes())
            ) {

                $secure_oid      = $orderids;
                $secure_oid_cost = $cart['total_cost'];
                $initial_state_orders     = func_array_merge($initial_state_orders, $orderids);
                $initial_state_show_notif = 'Y';

                foreach ($secure_oid as $oid) {
                    func_array2insert(
                        'order_extras',
                        array(
                            'orderid' => $oid,
                            'khash'   => 'xpc_txnid',
                            'value'   => $_POST['txnId'],
                        ),
                        true
                    );
                }

                $data['ref_id'] = implode('-', $secure_oid);

                db_query("DELETE FROM $sql_tbl[cc_pp3_data] WHERE ref = '" . $ref_key . "'");

                func_array2insert(
                    'cc_pp3_data',
                    array(
                        'ref'    => 'XPC' . $data['ref_id'],
                        'sessid' => $cc_pp3_data['sessid'],
                    ),
                    true
                );

                if (!xpc_api_supported('1.6')) {
                    $data['saveCard'] = (xpc_get_allow_save_cards() && xpc_use_recharges($paymentid)) ? 'Y' : 'N';
                }

                if (
                    !empty($active_modules['Anti_Fraud'])
                    && func_antifraud_check_block_order($orderids)
                ) {

                    define('STATUS_CHANGE_REF', 6);

                    x_load('order');

                    func_change_order_status(
                        $orderids,
                        'F',
                        func_get_langvar_by_name('txt_antifraud_order_note', array(), $config['default_admin_language'], true)
                    );

                } else {

                    $data['cart'] = xpc_prepare_cart(
                        $united_cart,
                        $data['ref_id'],
                        function_exists('func_is_preauth_force_enabled') ? func_is_preauth_force_enabled($secure_oid) : false
                    );
                }

                if (!$data['cart']) {
                    // Remove cart from output so that X-Payments will give error
                    unset($data['cart']);
                }

            }

        }
        $xml = xpc_hash2xml($data);

        if (!$xml) {
            die(xpc_api_error('Data is not valid'));
        }

        // Encrypt
        $xml = xpc_encrypt_xml($xml);

        if (!$xml) {
            die(xpc_api_error('Data is not encrypted'));
        }

        echo $xml;

    }

    exit;

} else {

    // For disabled iframe or API 1.2 only
    // Initialize transaction & redirect to X-Payments

    if (!defined('XCART_START')) { header('Location: ../'); die('Access denied'); }

    func_xpay_func_load();

    if (!xpc_api_supported('1.6')) {
        xpc_set_allow_save_cards('Y' == @$allow_save_cards);
    }

    $refId = implode('-', $secure_oid);

    if (!$duplicate) {
        func_array2insert(
            'cc_pp3_data',
            array(
                'ref'       => 'XPC' . $refId, 
                'sessid' => $XCARTSESSID,
            ), 
            true
        );
    }

    $united_cart = $cart;

    $united_cart['userinfo'] = $userinfo;
    $united_cart['products'] = $products;

    $paymentid = intval($paymentid);

    list($status, $response) = xpc_request_payment_init(
        $paymentid,
        $refId,
        $united_cart,
        function_exists("func_is_preauth_force_enabled") ? func_is_preauth_force_enabled($secure_oid) : false
    );

    if ($status) {

        foreach ($secure_oid as $oid) {
            func_array2insert(
                'order_extras',
                array(
                    'orderid' => $oid,
                    'khash'   => 'xpc_txnid',
                    'value'   => $response['txnId'],
                ),
                true
            );
        }

        xpc_display_payment_redirect_form($response, xpc_allow_save_card($paymentid, $cart, false));

        exit;

    } else {

        $bill_output['code'] = 2;
        $bill_output['billmes'] = 'Internal error';

        if (
            isset($response['detailed_error_message'])
            && !empty($response['detailed_error_message'])
        ) {

            $bill_output['billmes'] .= ' (' . $response['detailed_error_message'] . ')';

        }

        $weblink = false;

        if ($config['XPayments_Connector']['xpc_use_iframe'] == 'Y') {
            $is_iframe = true;
            $use_xpc_iframe_redirect = true;
        }


    }

}

?>
