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
 * Functions for X-Payments Connector module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    ab88660f07fe4c0b284691bd18276d276f9832f0, v187 (xcart_4_7_8), 2017-06-01 10:29:24, xpc_func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

x_load('payment');

global $config;

/**
 *  Some XP errors details which depend on the current XP connector module realization.
 */
global $xpc_errors;

$xpc_errors = array(
    '505' => 'err_xpc_templates_not_approved',
);

// Kount prefix in transaction details
define('XPC_KOUNT_PREFIX', '[Kount] ');

// Fraud check data codes
define('XPC_FRAUD_KOUNT',     'kount');
define('XPC_FRAUD_NOFRAUD',   'nofraud');
define('XPC_FRAUD_ANTIFRAUD', 'antifraud');
define('XPC_FRAUD_XPAYMENTS', 'xpayments');
define('XPC_FRAUD_GATEWAY',   'gateway');

define('XPC_FRAUD_RESULT_UNKNOWN', 0);
define('XPC_FRAUD_RESULT_ACCEPTED', 1);
define('XPC_FRAUD_RESULT_REVIEW', 2);
define('XPC_FRAUD_RESULT_FAIL', 3);

// Salt block length
define('XPC_SALT_LENGTH', 32);

// Salt generator start character code
define('XPC_SALT_BEGIN', 33);

// Salt generator end character code
define('XPC_SALT_END', 255);

// Encryption check length
define('XPC_CHUNK_LENGTH', 128);

define('XPC_NEW_ACTION', 1);
define('XPC_AUTH_ACTION', 2);
define('XPC_CHARGED_ACTION', 4);
define('XPC_DECLINED_ACTION', 3);
define('XPC_REFUND_ACTION', 5);
define('XPC_PART_REFUND_ACTION', 6);

/****************************************** Allowable transactions *******************************************/

define('XPC_TRAN_TYPE_SALE',          'sale');
define('XPC_TRAN_TYPE_AUTH',          'auth');
define('XPC_TRAN_TYPE_CAPTURE',       'capture');
define('XPC_TRAN_TYPE_CAPTURE_PART',  'capturePart');
define('XPC_TRAN_TYPE_CAPTURE_MULTI', 'captureMulti');
define('XPC_TRAN_TYPE_VOID',          'void');
define('XPC_TRAN_TYPE_VOID_PART',     'voidPart');
define('XPC_TRAN_TYPE_VOID_MULTI',    'voidMulti');
define('XPC_TRAN_TYPE_REFUND',        'refund');
define('XPC_TRAN_TYPE_REFUND_PART',   'refundPart');
define('XPC_TRAN_TYPE_REFUND_MULTI',  'refundMulti');
define('XPC_TRAN_TYPE_GET_INFO',      'getInfo');
define('XPC_TRAN_TYPE_ACCEPT',        'accept');
define('XPC_TRAN_TYPE_DECLINE',       'decline');
define('XPC_TRAN_TYPE_TEST',          'test');
define('XPC_TRAN_TYPE_GET_CARD',      'getCard');

/****************************** Common definitions for XML requests / responses ******************************/

// Root-level tag for all XML messages
define('XPC_TAG_ROOT', 'data');

// Value of the 'type' attribute for list items in XML
define('XPC_TYPE_CELL', 'cell');

define('XPC_MODULE_INFO', 'payment_module');

// Include connection API essential functions
include $xcart_dir . '/modules/XPayments_Connector/xpc_api.php';

/*********************************************** XML routines ************************************************/

/**
 * Check if passed variable is an array with numeric keys
 *
 * @param mixed $data data to check
 *
 * @return bool
 */
function xpc_is_anonymous_array($data)
{
    return (is_array($data) && (1 > count(preg_grep('/^\d+$/', array_keys($data), PREG_GREP_INVERT))));
}

/**
 * Write XML tag for current level
 *
 * @param mixed  $data  node content
 * @param string $name  node name
 * @param int    $level current recursion level
 * @param string $type  value for 'type' attribute
 *
 * @return string
 */
function xpc_write_xml_tag($data, $name, $level = 0, $type = '')
{
    $xml    = '';
    $indent = str_repeat('  ', $level);

    // Open tag
    $xml .= $indent . '<' . $name . (empty($type) ? '' : ' type="' . $type . '"') . '>';
    // Sublevel tags or tag value
    $xml .= is_array($data) ? "\n" . xpc_hash2xml($data, $level + 1) . $indent : xpc_local2utf8($data);
    // Close tag
    $xml .= '</' . $name . '>' . "\n";

    return $xml;
}

/**
 * Convert hash array to XML
 *
 * @param array $data  hash array
 * @param int   $level current recursion level
 *
 * @return string
 */
function xpc_hash2xml($data, $level = 0)
{
    $xml = '';

    foreach ($data as $name => $value) {

        if (xpc_is_anonymous_array($value)) {
            foreach ($value as $item) {
                $xml .= xpc_write_xml_tag($item, $name, $level, XPC_TYPE_CELL);
            }
        } else {
            $xml .= xpc_write_xml_tag($value, $name, $level);
        }

    }

    return $xml;
}

/**
 * Convert XML to hash array
 *
 * @param string $xml XML string
 *
 * @return array|string
 * @access private
 * @see    ____func_see____
 * @since  1.0.0
 */
function xpc_xml2hash($xml)
{
    $data = array();

    while (!empty($xml) && preg_match('/<([\w\d]+)(?:\s*type=["\'](\w+)["\']\s*)?' . '>(.*)<\/\1>/Us', $xml, $matches)) {

        // Sublevel tags or tag value
        if (XPC_TYPE_CELL === $matches[2]) {
            $data[$matches[1]][] = xpc_xml2hash($matches[3]);
        } else {
            $data[$matches[1]] = xpc_xml2hash($matches[3]);
        }

        // Exclude parsed part from XML
        $xml = str_replace($matches[0], '', $xml);

    }

    return empty($data) ? $xml : $data;
}

/************************************** Import / export payment methods **************************************/

/**
 * Get list of available payment configurations from X-Payments
 *
 * @return array
 */
function xpc_request_get_payment_methods()
{
    $result = array();

    // Call the "api.php?target=payment_confs&action=get" URL
    list($status, $response) = xpc_api_request(
        'payment_confs',
        'get',
        array(),
        xpc_request_get_payment_methods_schema()
    );

    // Check status
    if ($status) {
        if (!isset($response['payment_module']) || !is_array($response['payment_module'])) {
            $status = array();

        } else {
            $status = $response['payment_module'];
        }
    }

    return $status;
}

/**
 * Import payment methods to the database
 *
 * @param array $methods_list payment methods list
 *
 * @return bool
 */
function xpc_import_payment_methods($methods_list, $clear_payment_methods = false)
{
    global $sql_tbl, $recent_payment_methods, $config;

    $result = false;

    if (!empty($methods_list) && is_array($methods_list)) {

        $result = true;

        // Match already available methods
        $matched_paymentid = array();
        if (!$clear_payment_methods) {
            $current_processors = func_query_hash("SELECT param01, param08, param09, paymentid FROM $sql_tbl[ccprocessors] WHERE processor='cc_xpc.php' AND paymentid > 0", 'param01', false);
            foreach ($methods_list as $method) {
                if (
                    array_key_exists($method['id'], $current_processors)
                ) {
                    $class_name = xpc_get_class_name($current_processors[$method['id']]);

                    if (
                        // Match by inner class name
                        !empty($method['class']) 
                        && strcmp($method['class'], $class_name) == 0
                        ||
                        // Or match by display name
                        strcmp($method['moduleName'], $current_processors[$method['id']]['param08']) == 0
                    ) {
                        $matched_paymentid[$method['id']] = $current_processors[$method['id']]['paymentid'];
                    }
                }
            }
        }

        $extra_condition = (!empty($matched_paymentid) ? " AND paymentid NOT IN ('" . implode("', '", $matched_paymentid). "')" : '');

        // Remove all payment processors imported from X-Payments earlier
        // and all associated with them payment methods
        db_query('DELETE FROM ' . $sql_tbl['ccprocessors'] . ' WHERE processor=\'cc_xpc.php\'' . $extra_condition);
        XCPayment::deleteByCond('processor_file=\'cc_xpc.php\'' . $extra_condition);

        x_session_register('recent_payment_methods');

        // Remove X-Payments payment methods from recently added payment methods list
        if (!empty($recent_payment_methods) && is_array($recent_payment_methods)) {

            foreach ($recent_payment_methods as $key => $value) {
                if (preg_match('/cc_xpc\.php/S', $key)) {
                    unset($recent_payment_methods[$key]);
                }
            }

        }

        // Translate boolean value into the {Y,N} char
        function getTranTypeFlag($tranTypes, $type)
        {
            return (!isset($tranTypes[$type]) || !$tranTypes[$type]) ? 'N' : 'Y';
        }

        // Save payment processors imported from X-Payments
        foreach ($methods_list as $method) {

            $tranTypes       = $method['transactionTypes'];
            $authCaptureInfo = $method['authCaptureInfo'];

            if (!isset($method['canSaveCards'])) {
                $method['canSaveCards'] = '';
            }
            if (!isset($method['currency'])) {
                $method['currency'] = '';
            }

            // Prepare data to insert to the database
            $data = array(
                'module_name'       => $method['name'],
                'type'              => 'X',
                'processor'         => 'cc_xpc.php',
                'template'          => 'cc_xpc.tpl',
                'param01'           => $method['id'],
                'param02'           => getTranTypeFlag($tranTypes, XPC_TRAN_TYPE_CAPTURE),
                'param03'           => getTranTypeFlag($tranTypes, XPC_TRAN_TYPE_VOID),
                'param04'           => getTranTypeFlag($tranTypes, XPC_TRAN_TYPE_REFUND),
                'param05'           => getTranTypeFlag($tranTypes, XPC_TRAN_TYPE_REFUND_PART),
                'param06'           => getTranTypeFlag($tranTypes, XPC_TRAN_TYPE_SALE),
                'param07'           => getTranTypeFlag($tranTypes, XPC_TRAN_TYPE_ACCEPT) 
                    . getTranTypeFlag($tranTypes, XPC_TRAN_TYPE_DECLINE)
                    . getTranTypeFlag($tranTypes, XPC_TRAN_TYPE_GET_INFO)
                    . $method['canSaveCards']
                    . $method['currency'],
                'param08'           => $method['moduleName'],
                'param09'           => $method['settingsHash']
                    . (!empty($method['class']) ? $method['class'] : ''),
                'testmode'          => !empty($method['isTestMode']) ? $method['isTestMode'] : 'N',
                'disable_ccinfo'    => 'Y',
                'background'        => 'N',
                'is_refund'         => getTranTypeFlag($tranTypes, XPC_TRAN_TYPE_REFUND),
                'has_preauth'       => getTranTypeFlag($tranTypes, XPC_TRAN_TYPE_AUTH),
                'preauth_expire'    => $authCaptureInfo['authExp'] * SECONDS_PER_DAY,
                'capture_min_limit' => ($authCaptureInfo['captMinLimit'] * 100) . '%',
                'capture_max_limit' => ($authCaptureInfo['captMaxLimit'] * 100 - 100) . '%',
            );

            if (
                !empty($matched_paymentid)
                && array_key_exists($method['id'], $matched_paymentid)
            ) {

                $id = true;
                func_array2update('ccprocessors', $data, "param01 = '$method[id]' AND processor = 'cc_xpc.php'");

            } else {

                $id = func_array2insert('ccprocessors', $data);

                if (
                    false !== $id
                ) { 
                    $id = func_add_processor('cc_xpc.php_' . $method['id']);     
                    // Automatically enable created payment
                    func_array2update('payment_methods', array('active' => 'Y'), "paymentid = '$id'");
                }    

            }

            $result = ($result && (false !== $id));
        }
    }

    return $result;
}



/***************************************** Functions to init payment *****************************************/

/**
 * Send request to X-Payments to initialize new payment
 *
 * @param int     $paymentid  X-Cart initernal ID for payment method
 * @param string  $refId      order ID
 * @param array   $cart       shopping cart info
 * @param boolean $force_auth Force enable AUTH mode
 *
 * @return array
 * @see    ____func_see____
 * @since  1.0.0
 */
function xpc_request_payment_init($paymentid, $refId, $cart, $force_auth, $is_temporary = false)
{
    global $config, $XCARTSESSID, $current_location, $shop_language;

    // Retrieve module settings
    $module_params = xpc_get_module_params($paymentid);

    if (!$module_params) {
        return xpc_api_error('Unable to retrieve payment module settings');
    }

    // Prepare cart
    $cart = xpc_prepare_cart($cart, $refId, $force_auth, $is_temporary);

    if (!$cart) {
        return xpc_api_error('Unable to prepare cart data');
    }

    // Data to send to X-Payments
    $data = array(
        'confId'      => intval($module_params['param01']),
        'refId'       => $refId,
        'cart'        => $cart,
        'returnUrl'   => $current_location . '/payment/cc_xpc.php',
        'callbackUrl' => $current_location . '/payment/cc_xpc.php',
        'language'    => (!empty($shop_language) ? $shop_language : 'en'),
    );

    if (
        $is_temporary == 'save_cc'
        && !xpc_api_supported('1.6')
    ) {
        // Force iframe template for save card request (backward compatibility)
        $data['template'] = 'lite';
    }

    list($status, $response) = xpc_api_request('payment', 'init', $data, xpc_request_payment_init_schema());

    // The main entry in the response is the 'token'
    if (
        $status 
        && (
            !isset($response['token']) 
            || !is_string($response['token'])
        )
    ) {

        xpc_api_error('Transaction token is not found or has a wrong type');

        $status = false;

    }

    if ($status) {
        $config['XPayments_Connector'] = xpc_prepare_config_vars($config['XPayments_Connector']);

        // Use the default URL if X-Payments did not return one
        if (substr($config['XPayments_Connector']['xpc_xpayments_url'], -1) == '/') {
            $config['XPayments_Connector']['xpc_xpayments_url'] = substr($config['XPayments_Connector']['xpc_xpayments_url'], 0, -1);
        }

        // Set fields for the "Redirect to X-Payments" form
        $token = $response['token'];

        $response = array(
            'txnId'       => $response['txnId'],
            'module_name' => $module_params['module_name'],
        );

        $response += xpc_get_initiated_payment_redirect_form($token);

    } else {

        $response = array(
            'detailed_error_message' => isset($response['error_message'])
                                            ?  $response['error_message'] 
                                            : (is_string($response) ? $response : 'Unknown'),

        );

    }

    return array($status, $response);
}

function xpc_save_initiated_payment_in_session($paymentid, $token, $type = 'checkout')
{ //{{{

    global $xpc_initiated_payments;
    x_session_register('xpc_initiated_payments', array());

    $xpc_initiated_payments[$paymentid][$type] = $token;

} //}}}

function xpc_get_initiated_payment_from_session($paymentid, $type = 'checkout')
{ //{{{

    global $xpc_initiated_payments;
    x_session_register('xpc_initiated_payments', array());
    
    return (!empty($xpc_initiated_payments[$paymentid][$type])) ? $xpc_initiated_payments[$paymentid][$type] : false;

} //}}}

function xpc_clear_initiated_payment_in_session($paymentid = 0)
{ //{{{

    global $xpc_initiated_payments;

    if ($paymentid != 0) {
        x_session_register('xpc_initiated_payments', array());
        unset($xpc_initiated_payments[$paymentid]);
    } else {
        x_session_unregister('xpc_initiated_payments');
    }

} //}}}

function xpc_allow_save_card($paymentid, $cart, $force)
{ //{{{

    global $active_modules, $logged_userid;

    $force = (
        $force
        || (!empty($active_modules['XPayments_Subscriptions']) && func_xps_hasCartSubscriptionProducts($cart))
    );

    if (
        xpc_can_recharge($paymentid)
        && xpc_use_recharges($paymentid)
        && !empty($logged_userid)
    ) {
        $result = $force ? 'Y' : 'O';
    } else {
        $result = 'N';
    }

    return $result;

} //}}}

function xpc_get_initiated_payment_redirect_form($token)
{ //{{{

    global $config;
    $config['XPayments_Connector'] = xpc_prepare_config_vars($config['XPayments_Connector']);

    $result = array(
                'url'         => $config['XPayments_Connector']['xpc_xpayments_url'] . '/payment.php',
                'fields'      => array(
                    'target' => 'main',
                    'action' => 'start',
                    'token'  => $token,
                ),
            );

    return $result;

} //}}}

function xpc_display_payment_redirect_form($redirect_form, $allow_save_card = '')
{ //{{{

    global $smarty;

    if (!empty($allow_save_card) && xpc_api_supported('1.6')) {
        $redirect_form['fields']['allow_save_card'] = $allow_save_card;
    }

    $smarty->assign('action', $redirect_form['url']);
    $smarty->assign('fields', $redirect_form['fields']);

    func_display('modules/XPayments_Connector/xpc_iframe_content.tpl', $smarty);

} //}}}

function xpc_pop_customer_extras_from_session()
{ //{{{

    global $xpc_customer_extras;
    x_session_register('xpc_customer_extras', '');

    $return = $xpc_customer_extras;

    x_session_unregister('xpc_customer_extras');

    return $return;
} //}}}

function xpc_set_customer_extras_in_session($extras)
{ //{{{

    global $xpc_customer_extras;
    x_session_register('xpc_customer_extras');

    $xpc_customer_extras = $extras;

} //}}}

/**
 * Parses "Your company name" <store@example.com> and returns first actual email found
 */
function xpc_strip_extended_email_data($email_in_extended_format)
{

    // Synchronize with func_email_validation_regexp function on change
    $validation = "/[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z](?:[a-z0-9-]*[a-z0-9])/Di";

    if (preg_match_all($validation, $email_in_extended_format, $matches)) {
        return $matches[0][0];
    }

    // emails not found, return original string
    return $email_in_extended_format;

}

/**
 * Get customer unique ID for Kount UNIQ field
 *
 * @param array  $cart  X-Cart shopping cart
 *
 * @return string
 */
function xpc_get_kount_customer_uniq($cart)
{
    $user_info = $cart['userinfo'];

    $uniq = (!empty($user_info['login'])) ? $user_info['login'] : $user_info['email'];

    return substr($uniq, 0, 32);
}

/**
 * Prepare shopping cart data
 *
 * @param array  $cart  X-Cart shopping cart
 * @param string $refId order ID
 *
 * @return array
 * @see    ____func_see____
 * @since  1.0.0
 */
function xpc_prepare_cart($cart, $refId, $force_auth, $is_temporary = false)
{
    global $config, $sql_tbl, $active_modules;

    $user_info = $cart['userinfo'];

    $user_login = (!empty($user_info['login'])) ? $user_info['login'] : $user_info['email'];
    $user_id_string = (!empty($user_info['id'])) ? " (User ID #$user_info[id])" : ' (Anonymous user)';

    if (!$is_temporary) {
        $description = 'Order(s) #' . $refId;
    } elseif ($is_temporary == 'save_cc') {
        $description = 'Save credit card transaction';
    } else {
        $description = 'Temporary order';
    }

    $result = array(
        'login'                => $user_login . $user_id_string,
        'billingAddress'       => array(),
        'shippingAddress'      => array(),
        'items'                => array(),
        'currency'             => xpc_get_currency($refId),
        'shippingCost'         => 0.00,
        'taxCost'              => 0.00,
        'discount'             => 0.00,
        'totalCost'            => 0.00,
        'description'          => $description,
        'merchantEmail'        => xpc_strip_extended_email_data($config['Company']['orders_department']),
        'forceTransactionType' => $force_auth ? 'A' : '',
    );

    $name_prefixes  = array(
        'b_' => 'billing', 
        's_' => 'shipping',
    );

    $address_fields = array(
        'firstname' => '', 
        'lastname' => '', 
        'address' => '', 
        'city' => '', 
        'state' => 'N/A', 
        'country' => '', 
        'zipcode' => '', 
        'phone' => '', 
        'fax' => '',
    );

    if ($config['General']['zip4_support'] == 'Y') {
        $address_fields['zip4'] = '';
    }

    // Prepare shipping and billing address
    foreach ($name_prefixes as $prefix => $type) {

        $addressIndex = $type . 'Address';

        foreach ($address_fields as $field => $def_value) {

            $result[$addressIndex][$field] = (
                !empty($user_info[$prefix . $field])
            )
                ? $user_info[$prefix . $field] 
                : (
                    !empty($user_info[$field]) 
                        ? $user_info[$field] 
                        : $def_value
                );

        }

        foreach (array('company', 'email') as $field) {
            $result[$addressIndex][$field] = isset($user_info[$field]) ? $user_info[$field] : '';
        }

    }

    // Set products
    if (!empty($cart['products']) && is_array($cart['products'])) {

        foreach ($cart['products'] as $product) {
            $result['items'][] = array(
                'sku'      => $product['productcode'],
                'name'     => $product['product'],
                'price'    => $product['price'],
                'quantity' => $product['amount'],
            );
        }

    }

    // Set giftcerts
    if (!empty($cart['giftcerts']) && is_array($cart['giftcerts'])) {

        foreach ($cart['giftcerts'] as $k => $giftcert) {
            $result['items'][] = array(
                'sku'      => !empty($giftcert['gcid']) ? $giftcert['gcid'] : 'GIFTCERT' . $k,
                'name'     => 'Gift certificate',
                'price'    => $giftcert['amount'],
                'quantity' => 1,
            );
        }

    }

    if (!empty($cart['payment_surcharge']) && !func_decimal_empty($cart['payment_surcharge'])) {
        $result['items'][] = array(
            'sku'      => 'PAYMENT_SURCHARGE',
            'name'     => 'Payment method surcharge',
            'price'    => $cart['payment_surcharge'],
            'quantity' => 1,
        );
    }

    if (!empty($cart['giftwrap_cost']) && !empty($cart['need_giftwrap']) && $cart['need_giftwrap'] == 'Y') {
        $result['items'][] = array(
            'sku'      => 'GIFTWRAP_COST',
            'name'     => 'Gift wrap',
            'price'    => $cart['giftwrap_cost'],
            'quantity' => 1,
        );
    }

    // Set costs
    $result['shippingCost'] = round($cart['shipping_cost'], 2);
    $result['taxCost']      = round($cart['tax_cost'], 2);
    $result['totalCost']    = round($cart['total_cost'], 2);
    $result['discount']     = round($cart['discount'], 2);

    if (
        !empty($cart['coupon_discount'])
        && (empty($cart['coupon_type']) || $cart['coupon_type'] != 'free_ship')
    ) {
        $result['discount'] += round($cart['coupon_discount'], 2);
    }

    if (!empty($cart['giftcert_discount']) && !func_decimal_empty($cart['giftcert_discount'])) {
        $result['discount'] += round($cart['giftcert_discount'], 2);
    }

    // Get admin email if Orders department email is empty
    if (empty($result['merchantEmail'])) {

        x_load('user');

        $usertypes = array('A');

        if (!empty($active_modules['Simple_Mode'])) {
            $usertypes[] = 'P';
        }

        $admin_email = func_query_first_cell("SELECT email FROM $sql_tbl[customers] WHERE usertype IN ('" . implode("', '", $usertypes). "') AND status = 'Y' AND email != ''");

        $result['merchantEmail'] = $admin_email;

    }

    // Send customer unique Id for Kount UNIQ field (API v1.6 and higher)
    if (xpc_api_supported('1.6')) {
        $result['kountCustomerUniq'] = xpc_get_kount_customer_uniq($cart);
    }

    return $result;
}

function xpc_get_save_card_cart($userid = null)
{ //{{{

    global $config, $logged_userid, $xpc_save_card_address;

    if (is_null($userid)) {
        $userid = $logged_userid;
    }

    $united_cart = array();
    $united_cart['total_cost'] = $config['XPayments_Connector']['xpc_save_cc_amount'];
    $united_cart['shipping_cost'] = $united_cart['tax_cost'] = $united_cart['discount'] = 0;
    $united_cart['products'] = array(
        array(
            'productcode' => 'SAVE_CARD_AUTH',
            'product' => 'Credit card authorization (to obtain payment token)',
            'price' => $united_cart['total_cost'],
            'amount' => 1,
        )
    );

    x_load('user');
    $united_cart['userinfo'] = func_userinfo($userid);

    x_session_register('xpc_save_card_address', array());

    foreach ($xpc_save_card_address as $addr => $value) {
        foreach (array('b_', 's_') as $prefix) {
            $united_cart['userinfo'][$prefix . $addr] = $value;
        }
    }

    return $united_cart;

} //}}}

function xpc_prepare_config_vars($config_XPayments_Connector) {
    global $xpc_crypted_map_fields;

    static $is_decrypted = FALSE;

    if (empty($is_decrypted)) {

        x_load('crypt');

        foreach ($xpc_crypted_map_fields as $field) {
            $config_XPayments_Connector[$field] = 
                (isset($config_XPayments_Connector[$field]))
                ? text_decrypt($config_XPayments_Connector[$field])
                : '';
        }   

        if ($config_XPayments_Connector['xpc_xpayments_url']) {
            $config_XPayments_Connector['xpc_xpayments_url'] = preg_replace('/\/+$/Ss', '', $config_XPayments_Connector['xpc_xpayments_url']);
        }
        $is_decrypted = TRUE;
    }

    return $config_XPayments_Connector;
}

/**
 * Get currency code (alpha-3)
 *
 * @param string $ref_id Reference id
 *
 * @return string Currency code
 * @see    ____func_see____
 * @since  1.0.0
 */
function xpc_get_currency($ref_id)
{
    global $config;

    return $config['XPayments_Connector']['xpc_currency'];
}

/***************************************** Functions to init payment *****************************************/

/**
 * Get payment info
 *
 * @param string $txn_id      Transaction id
 *
 * @return array Operation status & payment data array
 */
function xpc_request_get_payment_info($txn_id, $refresh = false)
{
    $data = array(
        'txnId' => $txn_id,
        'refresh' => $refresh ? 1 : 0
    );

    list($status, $response) = xpc_api_request('payment', 'get_info', $data);

    if ($status) {
        if (!is_array($response) || !isset($response['status'])) {
            xpc_api_error('GetInfo request. Server response has not status');
            $status = false;

        } elseif (!isset($response['message'])) {
            xpc_api_error('GetInfo request. Server response has not message');
            $status = false;

        } elseif (!isset($response['transactionInProgress'])) {
            xpc_api_error('GetInfo request. Server response has not transaction progress status');
            $status = false;

        } elseif (!isset($response['isFraudStatus'])) {
            xpc_api_error('GetInfo request. Server response has not fraud filter status');
            $status = false;

        } elseif (!isset($response['currency']) || strlen($response['currency']) != 3) {
            xpc_api_error('GetInfo request. Server response has not currency code or currency code has wrong format');
            $status = false;

        } elseif (!isset($response['amount'])) {
            xpc_api_error('GetInfo request. Server response has not payment amount');
            $status = false;

        } elseif (!isset($response['capturedAmount'])) {
            xpc_api_error('GetInfo request. Server response has not captured amount');
            $status = false;

        } elseif (!isset($response['capturedAmountAvail'])) {
            xpc_api_error('GetInfo request. Server response has not available for capturing amount');
            $status = false;

        } elseif (!isset($response['refundedAmount'])) {
            xpc_api_error('GetInfo request. Server response has not refunded amount');
            $status = false;

        } elseif (!isset($response['refundedAmountAvail'])) {
            xpc_api_error('GetInfo request. Server response has not available for refunding amount');
            $status = false;

        } elseif (!isset($response['voidedAmount'])) {
            xpc_api_error('GetInfo request. Server response has not voided amount');
            $status = false;

        } elseif (!isset($response['voidedAmountAvail'])) {
            xpc_api_error('GetInfo request. Server response has not available for cancelling amount');
            $status = false;

        }
    }

    return array($status, $response);
}

/**
 * Update local payment info based on callback request
 *
 * @param string $txn_id      Transaction id
 * @param array  $update_data Callback Transaction id
 *
 * @return array Operations status & message
 */
function xpc_update_payment($txn_id, $update_data)
{
    global $sql_tbl;

    // Check txn id
    $orderids = xpc_get_order_ids($txn_id);

    $card_txn_id = $txn_id;

    if (!$orderids && !empty($update_data['parentId'])) {
        $orderids = xpc_get_order_ids_by_parent($update_data['parentId']);

        if ($orderids) {
            $card_txn_id = $update_data['parentId'];
            db_query("DELETE FROM $sql_tbl[order_extras] WHERE khash = 'xpc_parent_txnid' AND orderid IN ('" . implode("', '", $orderids) . "')");
        }
    }

    if (
        !$orderids
        && xpc_can_auto_create_order()
    ) {
        $card_txn_id = $update_data['parentId'];
        $orderids = xpc_create_order_ids($txn_id, $update_data);
    }

    if (!$orderids) {

        return xpc_api_error('Process callback data. Transaction id is not found');
    }

    // Check update_data
    if (!is_array($update_data)) {

        return xpc_api_error('Process callback data. Callback data is not array');

    } elseif (
        !isset($update_data['status']) 
        || !is_numeric($update_data['status'])
    ) {

        return xpc_api_error('Process callback data. Status cell is not found or is not numeric');

    }

    $status = xpc_process_get_info($update_data, $orderids);

    if ($status) {

        if (
            xpc_api_supported('1.6')
            && !empty($update_data['maskedCardData'])
        ) {
            xpc_process_masked_card($card_txn_id, $update_data['maskedCardData']);
        }

        if (!defined('STATUS_CHANGE_REF')) {
            define('STATUS_CHANGE_REF', 13);
        }

        foreach ($orderids as $orderid) {
            func_change_order_status($orderid, $status);
        }

    }

    return array(true, '');
}

function xpc_process_masked_card($txn_id, $masked_card_data)
{
    global $sql_tbl;

    $orig_card = func_query_first("SELECT * FROM $sql_tbl[xpc_saved_cards] WHERE xpc_txnid='" . addslashes($txn_id) . "'");

    if (!empty($orig_card)) {

        $card_type = !empty($masked_card_data['type']) ? $masked_card_data['type'] : $orig_card['card_type'];

        if (
            !empty($masked_card_data['expire_month']) 
            && !empty($masked_card_data['expire_year'])
        ) {
            $card_expire = $masked_card_data['expire_month'] . '/' . $masked_card_data['expire_year'];
        } else {
            $card_expire = $orig_card['card_expire'];
        }

        if (!empty($masked_card_data['last4'])) {
            $card_num = !empty($masked_card_data['first6']) ? $masked_card_data['first6'] : str_repeat('*', 6);
            $card_num .= str_repeat('*', 6) . $masked_card_data['last4'];
        } else {
            $card_num = $orig_card['card_num'];
        }

        $card_num = array(
            'card_type'   => $card_type,
            'card_expire' => $card_expire,
            'card_num'    => $card_num,
        );

        xpc_store_saved_card(
            $orig_card['userid'], 
            $card_num,
            $card_type,
            $txn_id,
            $orig_card['orderid'], 
            $orig_card['paymentid'], 
            $orig_card['date_added'], 
            $orig_card['is_default']
        );
    }
}

function xpc_process_get_info($update_data, $orderids)
{
    global $sql_tbl;

    x_load('order');

    $order = func_order_data($orderids[0]);

    $capture_total_updated = false;

    switch ($update_data['status']) {

        case XPC_NEW_ACTION:
            break;

        case XPC_AUTH_ACTION:
            break;

        case XPC_CHARGED_ACTION:
            if (
                function_exists('func_order_is_authorized')
                && func_order_is_authorized($orderids[0])
            ) {
                if (
                    !isset($update_data['capturedAmount']) 
                    || !is_numeric($update_data['capturedAmount'])
                ) {
                    return xpc_api_error('Process callback data. Capture amount cell is not found or is not numeric');
                }

                func_order_process_capture($orderids, $update_data['capturedAmount']);

                $capture_total_updated = true;
            }

            break;

        case XPC_DECLINED_ACTION:
            if (
                function_exists('func_order_is_authorized')
                && func_order_is_authorized($orderids[0])
            ) {
                func_order_process_void($orderids);
            }

            break;

        case XPC_REFUND_ACTION:
        case XPC_PART_REFUND_ACTION:
            if (
                !isset($update_data['refundedAmount']) 
                || !is_numeric($update_data['refundedAmount'])
            ) {
                return xpc_api_error('Process callback data. Refund amount cell is not found or is not numeric');
            }

            break;
    }

    // Auto-accept or decline
    if (
        function_exists('func_order_process_decline')
        && isset($order['order']['fmf']) 
        && $order['order']['fmf']['blocked'] 
        && !$update_data['isFraudStatus']
    ) {

        if (XPC_DECLINED_ACTION == $update_data['status']) {

            func_order_process_decline($orderids);

        } else {

            func_order_process_accept($orderids);

        }

    }

    // Update captured amount
    if (
        !$capture_total_updated
        && $update_data['capturedAmount'] > 0
        && $order['extra']['captured_total'] != $update_data['capturedAmount']
    ) {
        foreach ($orderids as $orderid) {

            $extra = func_query_first_cell("SELECT extra FROM $sql_tbl[orders] WHERE orderid = '" . $orderid . "'");

            if ($extra) {
                $extra = unserialize($extra);
            }

            $extra['captured_total'] = doubleval($update_data['capturedAmount']);

            func_array2update(
                'orders',
                array('extra' => addslashes(serialize($extra))),
                "orderid = '" . $orderid . "'"
            );
        }
    }

    // Update refunded amount
    if (
        function_exists('func_order_process_refund')
        && $update_data['refundedAmount'] > 0
        && (!isset($order['order']['charge_info']) || $order['order']['charge_info']['refunded_total'] != $update_data['refundedAmount'])
    ) {

        db_query("DELETE FROM $sql_tbl[order_extras] WHERE khash = 'refunded_total' AND orderid IN ('" . implode("','", $orderids) . "')");

        func_order_process_refund($orderids, $update_data['refundedAmount']);

    }

    // Update refund available amount
    if (isset($update_data['refundedAmountAvailGateway'])) {
        foreach ($orderids as $orderid) {
            func_array2insert(
                'order_extras',
                array(
                    'orderid' => $orderid,
                    'khash' => 'refund_avail',
                    'value' => $update_data['refundedAmountAvailGateway']
                ),
                true
            );
        }
    }

    xpc_update_advinfo($update_data, $orderids);

    xpc_update_fraud_check_data($update_data, $orderids);

    return xpc_get_order_status_by_action($update_data['status']);
}

/**
 * Update advinfo field for specific orders
 *
 * @param array $data     response data array
 * @param array $orderids orderids array
 *
 * @return void
 * @see    ____func_see____
 * @since  1.0.0
 */
function xpc_update_advinfo($data, $orderids)
{

    x_load('order');

    if (isset($data['advinfo'])) {

        $advinfo = '';

        foreach ($data['advinfo'] as $name => $value) {

            $advinfo .= "\n" . $name . ':' . $value;

        }

        foreach ($orderids as $orderid) {

            func_store_advinfo($orderid, $advinfo);

        }
    }

    // Worldpay US important data
    if (
        !empty($data['advinfo']['Message'])
        && preg_match('/Authorization code: ([\d]+)/', $data['advinfo']['Message'], $m)
    ) {

        $wp_data = array(
            'wp_auth_code'  => $m[1],
            'wp_status'     => (XPC_REFUND_ACTION == $data['status'] || XPC_PART_REFUND_ACTION == $data['status']) 
                ? 'Credit' 
                : 'Purchase',
        );

        foreach ($orderids as $orderid) {

            foreach ($wp_data as $key => $value) {
               func_array2insert(
                    'order_extras',
                    array(
                        'orderid' => $orderid,
                        'khash'   => $key,
                        'value'   => $value,
                    ),
                    true
                );
        
            }
        }
    }
}

/**
 * Update fraud check data from X-Payments
 *
 * @param array $data     response data array
 * @param array $orderids orderids array
 *
 * @return void
 * @see    ____func_see____
 * @since  1.0.0
 */
function xpc_update_fraud_check_data($data, $orderids)
{
    if (
        xpc_api_supported('1.7')
        && isset($data['fraudCheckData'])
    ) {

        $parsed_data = array();

        $antifraud_result = '';

        foreach ($data['fraudCheckData'] as $k => $fraud_check) {
            if (XPC_FRAUD_KOUNT == $fraud_check['code']) {
                $fraud_check['code'] = XPC_FRAUD_ANTIFRAUD;
                $fraud_check['module'] = 'Kount';
            } elseif (XPC_FRAUD_NOFRAUD == $fraud_check['code']) {
                $fraud_check['code'] = XPC_FRAUD_ANTIFRAUD;
                $fraud_check['module'] = 'NoFraud';
            }

            switch ($fraud_check['result']) {
                case XPC_FRAUD_RESULT_ACCEPTED:
                    $fraud_check['result_code'] = 'A';
                    break;
                case XPC_FRAUD_RESULT_REVIEW:
                    $fraud_check['result_code'] = 'R';
                    break;
                case XPC_FRAUD_RESULT_FAIL:
                    $fraud_check['result_code'] = 'D';
                    break;
                default:
                    $fraud_check['result_code'] = 'E';
                    break;
            }

            if (XPC_FRAUD_ANTIFRAUD == $fraud_check['code']) {
                $antifraud_result = $fraud_check['result_code'];
            }

            $parsed_data[$fraud_check['code']] = $fraud_check;

        }

        foreach ($orderids as $orderid) {

            func_array2insert(
                'order_extras',
                array(
                    'orderid' => $orderid,
                    'khash'   => 'xpc_fraud_check_data',
                    'value'   => serialize($parsed_data),
                ),
                true
            );

            if ($antifraud_result) {
                func_array2insert(
                    'order_extras',
                    array(
                        'orderid' => $orderid,
                        'khash'   => 'xpc_antifraud_result',
                        'value'   => $antifraud_result,
                    ),
                    true
                );
            }

        }

    } else {
        xpc_update_kount_data($data, $orderids);
    }
}

/**
 * Update kount data from payment details
 *
 * @param array $data     response data array
 * @param array $orderids orderids array
 *
 * @return void
 * @see    ____func_see____
 * @since  1.0.0
 */
function xpc_update_kount_data($data, $orderids)
{
    if (empty($data['transactions']) || !is_array($data['transactions'])) {
        return;
    }

    $kount_data = $kount_rules = array();
    
    foreach (array_reverse($data['transactions']) as $transaction) {

        if (empty($transaction['fields']) || !is_array($transaction['fields'])) {
            continue;
        }

        foreach ($transaction['fields'] as $field) {

            if (strpos($field['name'], XPC_KOUNT_PREFIX) !== false) {

                $key = str_replace(XPC_KOUNT_PREFIX, '', $field['name']);

                if (is_numeric($key)) {
                    $kount_rules[$key] = $field['value'];
                } else {
                    $kount_data[$key] = $field['value'];
                }
            }
        }

        if (!empty($kount_data)) {

            $kount_data['Rules'] = implode(PHP_EOL, $kount_rules);

            $kount_data = serialize($kount_data);

            foreach ($orderids as $orderid) {

                func_array2insert(
                    'order_extras',
                    array(
                        'orderid' => $orderid,
                        'khash'   => 'xpc_kount_data',
                        'value'   => $kount_data,
                    ),
                    true
                );
            }

            // Kount data is saved, exit function
            return;
        }
    }
}

/**
 * Returns parsed fraud check data
 *
 * @param array $order
 *
 * @return array Parsed results
 */
function xpc_get_order_fraud_check_data($order)
{

    $result = array();

    if (
        xpc_api_supported('1.7')
        && isset($order['extra']['xpc_fraud_check_data'])
    ) {
        if (!is_array($order['extra']['xpc_fraud_check_data'])) {
            $result = unserialize($order['extra']['xpc_fraud_check_data']);
        }

    } elseif (isset($order['extra']['xpc_kount_data'])) {

        // For backwards compatiblity
        $kount_data = unserialize($order['extra']['xpc_kount_data']);

        foreach (array('rules', 'errors', 'warnings', 'score') as $kount_param) {
            $ucparam = ucfirst($kount_param);
            if (!empty($kount_data[$ucparam])) {
                if (strpos($kount_data[$ucparam], PHP_EOL) !== false) {
                    $kount_data[$ucparam] = explode(PHP_EOL, $kount_data[$ucparam]);
                }
                $result[$kount_param] = $kount_data[$ucparam];
            }
        }

        $result['transactionId'] = $kount_data['Transaction ID'];
        $result['url'] = '';
        $result['message'] = '';
        $result['code'] = XPC_FRAUD_ANTIFRAUD;
        $result['module'] = 'Kount';
        $result['service'] = 'KOUNT Antifraud Screening';
        $result['status'] = $kount_data['Auto'];
        $result['result_code'] = $kount_data['Auto'];

        switch ($kount_data['Auto']) {
            case 'A':
                $result['result'] = XPC_FRAUD_RESULT_ACCEPTED;
                break;
            case 'R':
                $result['result'] = XPC_FRAUD_RESULT_REVIEW;
                break;
            case 'D':
                $result['result'] = XPC_FRAUD_RESULT_FAIL;
                break;
            default:
                $result['result'] = XPC_FRAUD_RESULT_UNKNOWN;
                break;
        }

        $result = array(XPC_FRAUD_ANTIFRAUD => $result);

    }

    return $result;
}

/**
 * Sets antifraud result value for orders
 *
 * @param array $orders Orders
 *
 * @return array
 */
function xpc_set_orders_antifraud_result($orders)
{
    global $current_area, $sql_tbl;

    if (
        $current_area != 'C'
        && !empty($orders)
    ) {

        $oids = array();
        foreach ($orders as $o) {
            $oids[] = $o['orderid'];
        }

        $xpc_antifraud_data = func_query_hash("SELECT orderid, value FROM $sql_tbl[order_extras] WHERE khash='xpc_kount_data' OR khash='xpc_antifraud_result' AND orderid IN ('" . implode("', '", $oids) . "')", 'orderid', false, true);

        foreach ($orders as $key => $order) {

            $orderid = $order['orderid'];

            if (!empty($xpc_antifraud_data[$orderid])) {
                if (strlen($xpc_antifraud_data[$orderid]) > 1) {
                    $data = unserialize($xpc_antifraud_data[$orderid]);
                    $xpc_antifraud_data[$orderid] = (!empty($data['Auto'])) ? $data['Auto'] : '';
                }
                $orders[$key]['xpc_antifraud_result'] = $xpc_antifraud_data[$orderid];
            } else {
                $orders[$key]['xpc_antifraud_result'] = '';
            }

        }
    }

    return $orders;
}


/**
 * Get additional payment info
 *
 * @param string $txn_id Payment reference in X-Payments
 *
 * @return array Operation status & payment data array
 */
function xpc_request_get_additional_info_by_txnid($txn_id)
{
    $data = array(
        'txnId' => $txn_id,
    );

    list($status, $response) = xpc_api_request('payment', 'get_additional_info', $data);

    return array($status, $response);
}


/**
 * Get additional payment info
 *
 * @param string $orderid Order id
 *
 * @return array Operation status & payment data array
 */
function xpc_request_get_additional_info($orderid)
{
    $order = func_order_data($orderid);
    $txn_id = $order['order']['extra']['xpc_txnid'];

    return xpc_request_get_additional_info_by_txnid($txn_id);
}

/**
 * Get orders identificators by transaction id
 *
 * @return array
 */
function xpc_get_order_ids($txn_id)
{
    global $sql_tbl;

    return array_map('intval', func_query_column("SELECT o.orderid FROM $sql_tbl[orders] as o INNER JOIN $sql_tbl[order_extras] as oe1 ON o.orderid = oe1.orderid AND oe1.khash = 'xpc_txnid' AND oe1.value = '" . $txn_id . "'"));
}

/**
 * Get orders identificators by parent transaction id
 *
 * @return array
 */
function xpc_get_order_ids_by_parent($txn_id)
{
    global $sql_tbl;

    return array_map('intval', func_query_column("SELECT o.orderid FROM $sql_tbl[orders] as o INNER JOIN $sql_tbl[order_extras] as oe1 ON o.orderid = oe1.orderid AND oe1.khash = 'xpc_parent_txnid' AND oe1.value = '" . $txn_id . "'"));
}

function xpc_create_order_ids($txn_id, $update_data)
{
    global $active_modules, $sql_tbl, $config;

    $orderids = false;

    $recharge_paymentid = func_query_first_cell("SELECT paymentid FROM $sql_tbl[payment_methods] WHERE payment_script = 'payment_xpc_recharge.php'"); 

    if (
        isset($update_data['parentId'])
        && !empty($active_modules['Advanced_Order_Management'])
        && $recharge_paymentid
    ) {

        $orig_orderid = xpc_get_order_ids($update_data['parentId']);

        if (!empty($orig_orderid)) {
            // Get orig info from initial order
            $orig_orderid = reset($orig_orderid);

            $orig_data = func_query_first("SELECT userid, payment_method FROM $sql_tbl[orders] WHERE orderid = '" . $orig_orderid . "'");
        } else {
            // Search within saved cards
            $orig_orderid = '';
            $orig_data = array('userid' => 0, 'payment_method' => '');
            $saved_cards = xpc_get_saved_cards_admin();
            foreach ($saved_cards as $card_id => $card) {
                if ($card['xpc_txnid'] == $update_data['parentId']) {
                    $orig_orderid = $card['orderid'];
                    $orig_data['userid'] = $card['userid'];
                    $orig_data['payment_method'] = xpc_compose_payment_method_text($card['paymentid']);
                    break;
                }
            }
        }

        $userid = $orig_data['userid'];

        // Check customer's orders
        $mintime = 10;
        $placed_orders = func_query_first("SELECT orderid FROM $sql_tbl[orders] WHERE userid='" . $userid . "' AND '" . XC_TIME . "'-date < '$mintime'");

        // Check admin orders
        if (!$placed_orders) {
            $placed_orders = func_query_first(
               "SELECT $sql_tbl[orders].orderid FROM $sql_tbl[orders] 
                INNER JOIN $sql_tbl[order_extras] 
                    ON (khash = 'created_by_admin' AND value = 'Y' AND $sql_tbl[order_extras].orderid = $sql_tbl[orders].orderid)
                WHERE 
                    $sql_tbl[orders].userid='" . $userid . "' 
                    AND paymentid = '$recharge_paymentid'
                    AND status = 'Q'"   
               );
        }
        
        if (!empty($placed_orders)) {
            // Order already exists, no need to create it
            return $placed_orders;
        }

        $orderid = func_aom_create_new_order($userid);

        if ($orderid) {

            x_load('order');

            $order_data = array(
                'paymentid'     => $recharge_paymentid,
                'total'         => $update_data['amount'],
                'init_total'    => $update_data['amount'],
                'payment_method' => $orig_data['payment_method'],
            );

            func_array2update(
                'orders',
                $order_data,
                "orderid = '" . $orderid . "'"
            );    

            $extra_order_data = array(
                'xpc_txnid'        => $txn_id,
                'xpc_orig_orderid' => $orig_orderid,
            );

            $saved_cards = xpc_get_saved_cards($userid);
            foreach ($saved_cards as $card_id => $card) {
                if ($card['orderid'] == $orig_orderid) {
                    $extra_order_data += array(
                        'xpc_saved_card_num'       => $card['card_num'],
                        'xpc_saved_card_type'      => $card['card_type'],
                        'xpc_saved_card_id'        => $card_id,
                        'xpc_saved_card_paymentid' => $card['paymentid'],
                    );
                    if (!empty($card['card_expire'])) {
                        $extra_order_data['xpc_saved_card_expire'] = $card['card_expire'];
                    }
                    func_store_advinfo($orderid, 'Paid by card: ' . $card['card_type'] . ' ' . $card['card_num'] . ' ' . $card['card_expire']);
                    break;
                }
            }

            if (XPC_AUTH_ACTION == $update_data['status']) {
                $extra_order_data['capture_status'] = 'A';
            } elseif (XPC_CHARGED_ACTION == $update_data['status']) {
                $extra_order_data['capture_status'] = '';
            }

            foreach($extra_order_data as $khash => $value) {

                func_array2insert(
                    'order_extras',
                    array(
                        'orderid' => $orderid,
                        'khash'   => $khash,
                        'value'   => $value,
                    ),
                    true
                );

            }

            $orderids = array($orderid);

        }    
    }

    return $orderids;
}

/**
 * Check if payment methods from X-Payment have already been imported to the database
 *
 * @return boolean Operation status
 */
function xpc_is_payment_methods_exists ()
{
    global $sql_tbl;

    return func_query_first_cell("SELECT count(*) FROM $sql_tbl[ccprocessors] WHERE processor='cc_xpc.php'") > 0;
}

/**
 * Check if module X-Payments Connector is configured
 *
 * @return boolean Operation status
 */
function xpc_is_module_configured()
{
    return xpc_get_module_system_errors() === 0;
}

/**
 * Get X-Payments Connector configuration errors
 *
 * @return integer
 */
function xpc_get_module_system_errors()
{
    global $config;

    x_load('files');

    $failed = 0;

    // Check shopping cart id
    $config['XPayments_Connector'] = xpc_prepare_config_vars($config['XPayments_Connector']);
    if (empty($config['XPayments_Connector']['xpc_shopping_cart_id']) || !preg_match('/^[\da-f]{32}$/Ss', $config['XPayments_Connector']['xpc_shopping_cart_id'])) {
        $failed |= XPC_SYSERR_CARTID;
    }

    // Check URL
    if (
        empty($config['XPayments_Connector']['xpc_xpayments_url']) 
        || (
            function_exists('is_url')
            && !is_url($config['XPayments_Connector']['xpc_xpayments_url'])
        )
    ) {
        $failed |= XPC_SYSERR_URL;
    }

    $parsed_url = @parse_url($config['XPayments_Connector']['xpc_xpayments_url']);

    if (!$parsed_url || !isset($parsed_url['scheme']) || !in_array( $parsed_url['scheme'], array( 'https', 'http'))) {
        $failed |= XPC_SYSERR_URL;
    }

    // Check public key
    if (empty($config['XPayments_Connector']['xpc_public_key'])) {
        $failed |= XPC_SYSERR_PUBKEY;
    }

    // Check private key
    if (empty($config['XPayments_Connector']['xpc_private_key'])) {
        $failed |= XPC_SYSERR_PRIVKEY;
    }

    // Check private key password
    if (empty($config['XPayments_Connector']['xpc_private_key_password'])) {
        $failed |= XPC_SYSERR_PRIVKEYPASS;
    }

    return $failed;
}

/************************ Functions to test connection between X-Cart and X-Payments  ************************/


/**
 * Make test request to X-Payments
 *
 * @return bool
 */
function xpc_request_test()
{
    srand();

    // Make test request
    list($status, $response) = xpc_api_request(
        'connect',
        'test',
        array('testCode' => ($hash_code = strval(mt_rand(0, 1000000)))),
        xpc_request_test_schema()
    );

    // Compare MD5 hashes
    if ($status && !($status = (md5($hash_code) === $response['hashCode']))) {
        xpc_api_error('Test connection data is not valid');
    }

    return array(
        'status'   => $status,
        'response' => $response,
    );
}

/**
 * Detect supported APi version using test requests to X-Payments
 *
 * @return bool
 */
function xpc_autodetect_api_version()
{
    global $config, $sql_tbl;

    srand();

    $minimal_version = '1.0';
    $config['XPayments_Connector']['xpc_api_version'] = XPC_API_VERSION;

    while (
        version_compare($config['XPayments_Connector']['xpc_api_version'], $minimal_version, '>=')
    ) {
        // Make test request
        $raw_response = xpc_api_request(
            'connect',
            'test',
            array('testCode' => ($hash_code = strval(mt_rand(0, 1000000)))),
            xpc_request_test_schema(),
            true
        );

        if (empty($raw_response['error']) || $raw_response['error'] != XPC_API_EXPIRED) {
            // Successful connection, store this version in DB
            db_query("UPDATE $sql_tbl[config] SET value = '" . $config['XPayments_Connector']['xpc_api_version'] . "' WHERE category = 'XPayments_Connector' AND name = 'xpc_api_version'");
            break;
        }

        // Current API version is not supported, try to downgrade it
        $_version_array = explode('.', $config['XPayments_Connector']['xpc_api_version']);
        if ($_version_array[1] > 0) {
            $_version_array[1]--;
        } else {
            $_version_array[1] = 9;
            $_version_array[0]--;
        }
        $config['XPayments_Connector']['xpc_api_version'] = implode('.', $_version_array);

    }

    list($status, $response) = xpc_api_request_finalize($raw_response);

    // Compare MD5 hashes
    if ($status && !($status = (md5($hash_code) === $response['hashCode']))) {
        xpc_api_error('Test connection data is not valid');
    }

    return array(
        'status'   => $status,
        'response' => $response,
    );
}

/************************ Functions to test connection between X-Cart and X-Payments  ************************/

/**
 * Check if X-Cart meets the PCI DSS requirements
 *
 * @return boolean Operation status
 */
function xpc_check_pci_dss_requirements ()
{
    global $store_cc, $store_cvv2, $config, $active_modules, $sql_tbl;

    $result = array();

    if (!empty($store_cvv2)) {
        $result['E']['store_cvv2'] = func_get_langvar_by_name('lbl_xpc_recommend_store_cvv2');
    }

    if (!empty($store_cc)) {
        $result['W']['store_cc'] = func_get_langvar_by_name('lbl_xpc_recommend_store_cc');
    }

    if (
        isset($config['General']['disable_cc'])
        && $config['General']['disable_cc'] != 'Y'
    ) {
        $result['W']['disable_cc'] = func_get_langvar_by_name('lbl_xpc_recommend_disable_cc');
    }

    if (!empty($active_modules['Subscriptions'])) {
        $result['W']['subscriptions'] = func_get_langvar_by_name('lbl_xpc_recommend_subscriptions');
    }

    $pm_enabled = func_query("SELECT $sql_tbl[ccprocessors].module_name, $sql_tbl[ccprocessors].processor FROM $sql_tbl[payment_methods], $sql_tbl[ccprocessors] WHERE ($sql_tbl[payment_methods].paymentid=$sql_tbl[ccprocessors].paymentid) AND $sql_tbl[ccprocessors].processor!='cc_xpc.php' AND $sql_tbl[ccprocessors].background='Y' AND $sql_tbl[ccprocessors].disable_ccinfo!='Y' AND $sql_tbl[ccprocessors].type NOT IN ('D','H') AND $sql_tbl[payment_methods].active='Y'");

    $methods = array();
    if (!empty($pm_enabled) && is_array($pm_enabled)) {
        foreach ($pm_enabled as $k => $v) {
            if ($v['processor'] == 'ps_paypal_pro.php') {
                if ($config['paypal_solution'] == 'express') {
                    continue;
                }
            }

            $methods[] = $v['module_name'];
        }
    }

    if (count($methods) > 0) {
        $result['W']['payment_methods'] = $methods;
    }

    return $result;

}

function xpc_can_capture($paymentid)
{
    $module_params = xpc_get_module_params($paymentid);

    return xpc_is_module_configured()
        && xpc_check_requirements() == 0
        && $module_params['param02'] == 'Y' ? 'xpc_do_capture' : false;
}

function xpc_can_void($paymentid)
{
    $module_params = xpc_get_module_params($paymentid);

    return xpc_is_module_configured()
        && xpc_check_requirements() == 0
        && $module_params['param03'] == 'Y' ? 'xpc_do_void' : false;
}

function xpc_can_refund($paymentid)
{
    return xpc_is_module_configured()
        && xpc_check_requirements() == 0
        && xpc_get_refund_mode($paymentid) ? 'xpc_do_refund' : false;
}

function xpc_get_refund_mode($paymentid)
{
    $module_params = xpc_get_module_params($paymentid);

    if (!empty($module_params['param05']) && $module_params['param05'] == 'Y') {
        return 'P';

    } elseif (!empty($module_params['param04']) && $module_params['param04'] == 'Y') {
        return 'Y';
    }

    return false;
}

function xpc_can_accept($paymentid)
{
    $module_params = xpc_get_module_params($paymentid);

    return xpc_is_module_configured()
        && xpc_check_requirements() == 0
//  All payments should be able to do Accept since it is not limited to fraud, but also to schema errors and etc. 
//        && substr($module_params['param07'], 0, 1) == 'Y'
        ? 'xpc_do_accept' : false;
}

function xpc_can_decline($paymentid)
{
    $module_params = xpc_get_module_params($paymentid);

    return xpc_is_module_configured()
        && xpc_check_requirements() == 0
//  All payments should be able to do Decline since it is not limited to fraud, but also to schema errors and etc. 
//        && substr($module_params['param07'], 1, 1) == 'Y'
        ? 'xpc_do_decline' : false;
}

function xpc_can_get_info($paymentid)
{
    $module_params = xpc_get_module_params($paymentid);

    return xpc_is_module_configured()
        && xpc_check_requirements() == 0 ? 'xpc_do_get_info' : false;
}

function xpc_can_recharge($paymentid)
{
    $module_params = xpc_get_module_params($paymentid);

    // The "can recharge" flag is stored in param07 at offset 3
    // If it is not available - assume recharge is possible (for backward compatibility)
    $params_ok = strlen($module_params['param07']) < 4 || substr($module_params['param07'], 3, 1) == 'Y';

    return xpc_is_module_configured()
        && xpc_check_requirements() == 0
        && $params_ok ? true : false;
}

function xpc_get_supported_currency($paymentid)
{
    $module_params = xpc_get_module_params($paymentid);

    // 3-letter currency code is stored in param07 at offset 4
    return (strlen($module_params['param07']) < 7) ? '' : substr($module_params['param07'], 4, 3);
}

function xpc_get_settings_hash($paymentid)
{
    $module_params = xpc_get_module_params($paymentid);

    // Settings hash (md5) is stored in the beginning of param09
    return (strlen($module_params['param09']) < 32) ? '' : substr($module_params['param09'], 0, 32);
}

function xpc_get_class_name($paymentid)
{
    if (is_array($paymentid)) {
        $module_params = $paymentid;
    } else {
        $module_params = xpc_get_module_params($paymentid);
    }

    // XP module class is stored after settings hash (md5) in param09
    return (strlen($module_params['param09']) <= 32) ? '' : substr($module_params['param09'], 32);
}
function xpc_do_capture($order)
{
    $data = array(
        'txnId' => $order["order"]["extra"]["xpc_txnid"],
        'amount' => $order["order"]['total'],
    );

    list($status, $response) = xpc_api_request('payment', 'capture', $data);

    $extra = array(
        'name' => 'xpc_txnid',
        'value' => $data['txnId']
    );

    if (!is_array($response)) {
        $response = array(
            'status' => 0,
            'message' => 'Internal error'
        );
    }

    $status = $response['status'] == 1;
    if ($response['status'] == 2) {
        $status = X_PAYMENT_TRANS_ALREADY_CAPTURED;
    }

    return array(
        $status,
        ($response['status'] == 0 && $response['message']) ? $response['message'] : false,
        $extra
    );
}

function xpc_do_void($order)
{
    $data = array(
        'txnId' => $order["order"]["extra"]["xpc_txnid"],
    );

    list($status, $response) = xpc_api_request('payment', 'void', $data);

    $extra = array(
        'name' => 'xpc_txnid',
        'value' => $data['txnId']
    );

    if (!is_array($response)) {
        $response = array(
            'status' => 0,
            'message' => 'Internal error'
        );
    }

    $status = $response['status'] == 1;
    if ($response['status'] == 2) {
        $status = X_PAYMENT_TRANS_ALREADY_VOIDED;
    }

    return array(
        $status,
        ($response['status'] == 0 && $response['message']) ? $response['message'] : '',
        $extra
    );
}

function xpc_do_refund($order, $amount = false)
{
    $data = array(
        'txnId' => $order["order"]["extra"]["xpc_txnid"],
    );

    if ($amount > 0) {
        $data['amount'] = $amount;
    }

    list($status, $response) = xpc_api_request('payment', 'refund', $data);

    $extra = array(
        'name' => 'xpc_txnid',
        'value' => $data['txnId']
    );

    if (!is_array($response)) {
        $response = array(
            'status' => 0,
            'message' => 'Internal error'
        );
    }

    $status = $response['status'] == 1;
    if ($response['status'] == 2) {
        $status = X_PAYMENT_TRANS_ALREADY_REFUNDED;
    }

    return array(
        $status,
        ($response['status'] == 0 && $response['message']) ? $response['message'] : '',
        $extra
    );

}

function xpc_do_accept($order)
{
    $data = array(
        'txnId' => $order["order"]["extra"]["xpc_txnid"],
    );

    list($status, $response) = xpc_api_request('payment', 'accept', $data);

    $extra = array(
        'name' => 'xpc_txnid',
        'value' => $data['txnId']
    );

    if (!is_array($response)) {
        $response = array(
            'status' => 0,
            'message' => 'Internal error'
        );
    }

    $status = $response['status'] == 1;
    if ($response['status'] == 2) {
        $status = X_PAYMENT_TRANS_ALREADY_ACCEPTED;
    }

    return array(
        $status,
        ($response['status'] == 0 && $response['message']) ? $response['message'] : '',
        $extra
    );

}

function xpc_do_decline($order)
{
    $data = array(
        'txnId' => $order["order"]["extra"]["xpc_txnid"],
    );

    list($status, $response) = xpc_api_request('payment', 'decline', $data);

    $extra = array(
        'name' => 'xpc_txnid',
        'value' => $data['txnId']
    );

    if (!is_array($response)) {
        $response = array(
            'status' => 0,
            'message' => 'Internal error'
        );
    }

    $status = $response['status'] == 1;
    if ($response['status'] == 2) {
        $status = X_PAYMENT_TRANS_ALREADY_DECLINED;
    }

    return array(
        $status,
        ($response['status'] == 0 && $response['message']) ? $response['message'] : '',
        $extra
    );

}

function xpc_do_get_info($order)
{
    $orderids = xpc_get_order_ids($order['order']['extra']['xpc_txnid']);

    list($status, $response) = xpc_request_get_payment_info($order['order']['extra']['xpc_txnid'], true);

    $extra = array(
        'name' => 'xpc_txnid',
        'value' => $order['order']['extra']['xpc_txnid']
    );

    $data = array(
        'status' => xpc_process_get_info($response, $orderids)
    );

    return array(
        $status,
        (!$status && $response['message']) ? $response['message'] : '',
        $extra,
        $data
    );

}

/**
 * Check - order use X-Payment connector as payment module or not
 *
 * @param integer $orderid Order id
 *
 * @return boolean
 */
function xpc_is_xpc_order($orderid)
{
    global $sql_tbl;

    $paymentid = func_query_first_cell("SELECT paymentid FROM $sql_tbl[orders] WHERE orderid = '" . $orderid . "'");

    $module_params = xpc_get_module_params($paymentid);
    $confirm = (count($module_params) > 0);

    if (!$confirm) {
        $payment_script = func_query_first_cell("SELECT payment_script FROM $sql_tbl[payment_methods] WHERE paymentid = '$paymentid'");
        if ($payment_script == 'payment_xpc_recharge.php') {
            $paymentid = xpc_get_orig_paymentid_for_recharge($orderid);
            $module_params = xpc_get_module_params($paymentid);
            $confirm = (count($module_params) > 0);
        }
    }

    return $confirm;
}

/**
 * Convert action code to order status
 *
 * @param integer $action Action code
 *
 * @return string Order status code
 */
function xpc_get_order_status_by_action($action)
{
    global $config;

    $action = intval($action);

    $cell = false;

    switch ($action) {
        case XPC_NEW_ACTION:
            $cell = 'xpc_status_new';
            break;

        case XPC_AUTH_ACTION:
            $cell = 'xpc_status_auth';
            break;

        case XPC_CHARGED_ACTION:
            $cell = 'xpc_status_charged';
            break;

        case XPC_DECLINED_ACTION:
            $cell = 'xpc_status_declined';
            break;

        case XPC_REFUND_ACTION:
            $cell = 'xpc_status_refunded';
            break;

        case XPC_PART_REFUND_ACTION:
            $cell = 'xpc_status_part_refunded';
            break;
    }

    return ($cell && isset($config['XPayments_Connector'][$cell]) && $config['XPayments_Connector'][$cell]) 
        ? $config['XPayments_Connector'][$cell] 
        : false;
}

/**
 * Make X-Payments API request
 *
 * @param string $target Request target
 * @param string $action Request action
 * @param array  $data   Request data
 *
 * @return array Operation status & data
 */
function xpc_api_request($target, $action, $data = array(), $schema = array(), $raw_return = false)
{
    global $config;

    // Check requirements
    if (!xpc_is_module_configured()) {
        return xpc_api_error('Module is not configured');
    }

    if (xpc_check_requirements() != 0) {
        return xpc_api_error('Check module requirements is failed');
    }

    $data['target'] = $target;
    $data['action'] = $action;

    // send API version
    $data['api_version'] = xpc_get_api_version();

    // Convert array to XML
    $xml = xpc_hash2xml($data);

    if (!$xml) {
        return xpc_api_error('Data is not valid');
    }

    // Encrypt
    $xml = xpc_encrypt_xml($xml);

    if (!$xml) {
        return xpc_api_error('Data is not encrypted');
    }

    $config['XPayments_Connector'] = xpc_prepare_config_vars($config['XPayments_Connector']);
    // HTTPS request
    $post = array(
        'cart_id' => $config['XPayments_Connector']['xpc_shopping_cart_id'],
        'request' => $xml,
    );

    xpc_curl_headers_collector(false);
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $config['XPayments_Connector']['xpc_xpayments_url'] . '/api.php');
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15000);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_HEADERFUNCTION, 'xpc_curl_headers_collector');

    if (!empty($config['General']['https_proxy'])) {
        // uncomment this line if you need proxy tunnel
        // curl_setopt ($ch, CURLOPT_HTTPPROXYTUNNEL, true);
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
        curl_setopt($ch, CURLOPT_PROXY, $config['General']['https_proxy']);
    }

    // insecure key is supported by curl since version 7.10
    $version = curl_version();

    if (is_array($version)) {
        $version = 'libcurl/' . $version['version'];
    }

    if (preg_match('/libcurl\/([^ $]+)/Ss', $version, $m)) {
        $parts = explode('.', $m[1]);
        if ($parts[0] > 7 || ($parts[0] = 7 && $parts[1] >= 10)) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        }
    }

    $body = curl_exec($ch);
    $errno = curl_errno($ch);
    $error = curl_error($ch);

    $headers = xpc_curl_headers_collector(true);

    curl_close($ch);

    // Check raw data
    if (substr($body, 0, 3) !== 'API') {

        xpc_api_error("Response is not valid.\nResponse headers: " . var_export($headers, true) . "\nResponse: " . $body . "\n");

        return array(false, "Response is not valid.<br />Check logs.");

    }

    // Decrypt
    list($responseStatus, $response) = xpc_decrypt_xml($body);

    if (!$responseStatus) {
        return xpc_api_error('Response is not decrypted (Error: ' . $response . ')');
    }

    // Validate XML
    if (!empty($schema) && !xpc_validate_xml_against_schema($response, $schema, $error)) {
        return xpc_api_error('XML in response has a wrong format. Additional info: "' . $error . '"');
    }

    // Convert XML to array
    $response = xpc_xml2hash($response);

    if (!is_array($response)) {
        return xpc_api_error('Unable to convert response into XML');
    }

    // The 'Data' tag must be set in response
    if (!isset($response[XPC_TAG_ROOT])) {
        return xpc_api_error('Response does not contain any data');
    }

    $response = $response[XPC_TAG_ROOT];

    if ($raw_return) {
        // Need to return response without parsing errors in it
        return $response;
    }
    
    return xpc_api_request_finalize($response);

}

function xpc_api_request_finalize($response)
{
    // Process errors
    $error = xpc_api_process_error($response);

    if ($error) {
        return $error;

    } else {
        $compatError = xpc_check_compatibility($response);
        if ($compatError) {
            return $compatError;
        }
    }

    return array(true, $response);
}

/**
 * Check for unsupported features and take appropriate actions
 */
function xpc_check_compatibility($response)
{
    global $config, $top_message, $cart, $checkout_module, $user_account;

    if ($config['XPayments_Connector']['xpc_use_iframe'] == 'Y') {
        if (empty($response['version']) || version_compare($response['version'], '1.0.6') < 0) {
            return xpc_api_error('X-Payments version is not supported.');
        }
    }

    return false;
}

/**
 * CURL headers collector callback
 */
function xpc_curl_headers_collector()
{
    static $headers = '';

    $args = func_get_args();

    if (count($args) == 1) {

        $return = '';

        if ($args[0] == true) {
            $return = $headers;
        }

        $headers = '';

        return $return;
    }

    if (trim($args[1]) != '') {
        $headers .= $args[1];
    }

    return strlen($args[1]);

}

/**
 * Encrypt data (RSA)
 *
 * @param string $data Request data
 *
 * @return string Encrypted data
 */
function xpc_encrypt_xml($data)
{
    global $config;

    // Preprocess
    srand(XC_TIME);
    $salt = '';
    for ($i = 0; $i < XPC_SALT_LENGTH; $i++) {
        $salt .= chr(mt_rand(XPC_SALT_BEGIN, XPC_SALT_END));
    }

    $lenSalt = strlen($salt);

    $crcType = 'MD5';
    $crc = xpc_md5_raw($data);

    $crc = str_repeat(' ', 8 - strlen($crcType)) . $crcType . $crc;
    $lenCRC = strlen($crc);

    $lenData = strlen($data);

    $data = str_repeat('0', 12 - strlen((string)$lenSalt)) . $lenSalt . $salt
        . str_repeat('0', 12 - strlen((string)$lenCRC)) . $lenCRC . $crc
        . str_repeat('0', 12 - strlen((string)$lenData)) . $lenData . $data;

    $config['XPayments_Connector'] = xpc_prepare_config_vars($config['XPayments_Connector']);
    // Encrypt
    $key = openssl_pkey_get_public($config['XPayments_Connector']['xpc_public_key']);
    if (!$key) {
        return false;
    }

    $data = str_split($data, XPC_CHUNK_LENGTH);
    $crypttext = null;
    foreach ($data as $k => $chunk) {
        if (!openssl_public_encrypt($chunk, $crypttext, $key)) {
            return false;
        }

        $data[$k] = $crypttext;
    }

    // Postprocess
    $data = array_map('base64_encode', $data);

    return 'API' . implode("\n", $data);
}

/**
 * Decrypt (RSA)
 *
 * @param string $data Encrypted data
 *
 * @return string Decrypted data
 */
function xpc_decrypt_xml($data)
{
    global $config;

    // Decrypt
    $config['XPayments_Connector'] = xpc_prepare_config_vars($config['XPayments_Connector']);
    $res = openssl_get_privatekey($config['XPayments_Connector']['xpc_private_key'], $config['XPayments_Connector']['xpc_private_key_password']);
    if (!$res) {
        return array(false, 'Private key is not initialized');
    }

    $data = substr($data, 3);

    $data = explode("\n", $data);
    $data = array_map('base64_decode', $data);
    foreach ($data as $k => $s) {
        if (!openssl_private_decrypt($s, $newsource, $res)) {
            return array(false, 'Can not decrypt chunk');
        }

        $data[$k] = $newsource;
    }

    openssl_free_key($res);

    $data = implode('', $data);

    // Postprocess
    $lenSalt = substr($data, 0, 12);
    if (!preg_match('/^\d+$/Ss', $lenSalt)) {
        return array(false, 'Salt length prefix has wrong format');
    }

    $lenSalt = intval($lenSalt);
    $data = substr($data, 12 + intval($lenSalt));

    $lenCRC = substr($data, 0, 12);
    if (!preg_match('/^\d+$/Ss', $lenCRC) || $lenCRC < 9) {
        return array(false, 'CRC length prefix has wrong format');
    }

    $lenCRC = intval($lenCRC);
    $crcType = trim(substr($data, 12, 8));
    if ($crcType !== 'MD5') {
        return array(false, 'CRC hash is not MD5');
    }
    $crc = substr($data, 20, $lenCRC - 8);

    $data = substr($data, 12 + $lenCRC);

    $lenData = substr($data, 0, 12);
    if (!preg_match('/^\d+$/Ss', $lenData)) {
        return array(false, 'Data block length prefix has wrong format');
    }

    $data = substr($data, 12, intval($lenData));

    $currentCRC = xpc_md5_raw($data);
    if ($currentCRC !== $crc) {
        return array(false, 'Original CRC and calculated CRC is not equal');
    }

    return array(true, $data);
}

/**
 * Check string - UTF-8 encoding or not
 *
 * @param string $data Data
 *
 * @return boolean
 */
function xpc_isUTF8($data)
{
    $len = strlen($data);
    $result = true;
    for ($i = 0; $i < $len && $result; $i++) {
        $c = ord(substr($data, $i, 1));

        $l = false;
        if ($c > 193 && $c < 224) {
            $l = 2;

        } elseif ($c > 223 && $c < 240) {
            $l = 3;

        } elseif ($c > 239 && $c < 245) {
            $l = 4;

        } elseif ($c < 32 || $c > 127) {

            $result = false;
        }

        if ($l) {
            $result = $l + $i <= $len;
            for ($n = $i + 1; $n < $i + $l && $result; $n++) {
                $result = ord(substr($data, $n, 1)) >> 6 === 2;
            }

            $i += $l - 1;
        }

    }

    return $result;
}

/**
 * Process API response errors
 *
 * @param array $response Response data
 *
 * @return boolean True if error
 */
function xpc_api_process_error($response)
{
    global $xpc_errors;

    if (isset($response['error']) && $response['error']) {

        $connector_custom_error = isset($xpc_errors[$response['error']]) ? $xpc_errors[$response['error']] : '';

        $error = 'X-Payments error (code: ' . $response['error'] . '): '
            . (isset($response['error_message']) ? $response['error_message'] : 'Unknown')
            . ($connector_custom_error ? "\nConnector-specific error message: " . $connector_custom_error : '');
        
        xpc_api_error($error);

        $display_error = !empty($connector_custom_error) 
                            ? $connector_custom_error
                            : (!empty($response['is_error_message']) ? $response['error_message'] : '');

        return array(
            false, 
            array(
                'status'        => 0, 
                'message'       => "Internal error ($response[error])",
                'error_message' => $display_error,
            )
        );
    }

    return array();

}

/**
 * Make MD5 hash in raw format
 *
 * @param string $data Data
 *
 * @return string
 */
function xpc_md5_raw($data)
{
    $crc = md5($data);
    $str = '';
    for ($i = 0; $i < 32; $i += 2) {
        $str .= chr(hexdec(substr($crc, $i, 2)));
    }

    return $str;
}

/**
 * Format and log API errors
 *
 * @param string $msg Error message
 *
 * @return array false & error message
 */
function xpc_api_error($msg)
{
    if (function_exists('x_log_add')) {
        x_log_add('xpay_connector', $msg, true);
    } else {
        error_log($msg, 0);
    }

    return array(false, $msg);
}

/**
 * Get module parameters by payment id
 *
 * @param integer $paymentid Payment id
 *
 * @return array Module parameters
 */
function xpc_get_module_params($paymentid)
{
    global $sql_tbl, $config;

    $module_params = func_query_first("SELECT * FROM $sql_tbl[ccprocessors] WHERE processor = 'cc_xpc.php' AND paymentid = '$paymentid'");

    return $module_params;
}

function xpc_filter_hidden_processors($data)
{
    return $data;
}

/**
 *    Convert local string ti UTF-8
 */
function xpc_local2utf8($string, $charset = null)
{
    global $default_charset;

    if (is_null($charset)) {
        $charset = (!empty($default_charset)) ? $default_charset : 'iso-8859-1';
    }

    $charset = strtolower(trim($charset));

    if (function_exists('utf8_encode') && $charset == 'iso-8859-1') {
        $string = utf8_encode($string);

    } elseif (function_exists('iconv')) {
        $string = iconv($charset, 'utf-8', $string);

    } else {

        $len = strlen($string);
        $data = '';
        for ($i = 0; $i < $len; $i++) {
            $c = ord(substr($string, $i, 1));
            if (!($c < 32 || $c > 127)) {
                $data .= substr($string, $i, 1);
            }
        }

        $string = $data;
    }

    return $string;
}

/**
 * Get configuration array from configuration deployement path
 * 
 * @param string $configuration configuration string 
 * 
 * @return array
 * @see    ____func_see____
 * @since  1.0.0
 */
function xpc_get_configuration($configuration)
{
    $configuration = base64_decode($configuration);

    $validation_regex = '/a:[56]:{s:8:"store_id";s:\d+:"[0-9a-z]+";s:3:"url";s:\d+:"[^"]+";s:10:"public_key";s:\d+:"-----BEGIN CERTIFICATE-----[^"]+-----END CERTIFICATE-----";s:11:"private_key";s:\d+:"-----BEGIN [A-Z ]*PRIVATE KEY-----[^"]+-----END [A-Z ]*PRIVATE KEY-----";s:20:"private_key_password";s:32:".{32}";(s:9:"server_ip";s:\d+:"[0-9a-fA-F\.:]*";)?}/s';

    if (preg_match($validation_regex, $configuration)) {
        // It is serialized data and it contains only the configuration fields
        $result = unserialize($configuration);
    } else {
        // Try modern JSON bundle
        $result = func_json_decode($configuration);
        // Core function doesn't have parameter to return array
        $result = (is_object($result)) ? (array)$result : false;
    }

    if (!$result || !is_array($result)) {
        $result = array();
    }

    return $result;

}

/**
 * Check if the deploy configuration is correct array
 * 
 * @param array $configuration configuration array
 *  
 * @return boolean
 * @see    ____func_see____
 * @since  1.0.0
 */
function xpc_check_deploy_configuration($configuration)
{
    $required = array(
        'store_id',
        'url',
        'public_key',
        'private_key',
        'private_key_password',
    );

    return is_array($configuration)
        && ($required === array_intersect(array_keys($configuration), $required));
}

/**
 * Store configuration array into DB
 * 
 * @param array $configuration configuration array
 *  
 * @return void
 * @see    ____func_see____
 * @since  1.0.0
 */
function xpc_store_configuration($configuration)
{
    global $xpc_crypted_map_fields, $config, $sql_tbl;

    $config['XPayments_Connector'] = xpc_prepare_config_vars($config['XPayments_Connector']);

    // Previous store id required to check if deployed the same store
    $configuration['previous_store_id'] = $config['XPayments_Connector']['xpc_shopping_cart_id'];

    foreach ($xpc_crypted_map_fields as $origName => $dbName) {
        $value = str_replace("\n", "\r\n", $configuration[$origName]);
        func_array2update(
            'config',
            array(
                'value' => addslashes(text_crypt($value)),
            ),
            "name='" . $dbName . "' AND category='XPayments_Connector'"
        );
        $config['XPayments_Connector'][$dbName] = $value;
        if ($dbName == 'xpc_xpayments_url') {
            $config['XPayments_Connector'][$dbName] = preg_replace('/\/+$/Ss', '', $config['XPayments_Connector'][$dbName]);
        }
    }

    if (isset($configuration['server_ip'])) {
        // Update Allowed callback IPs address and generate its signature

        x_load('security');

        $dbName = 'xpc_allowed_ip_addresses';

        $_condition = "name='" . $dbName . "' AND category='XPayments_Connector'";

        if (XCConfigSignature::isApplicable(array('name' => $dbName))) {
            $old_configs = func_query("SELECT " . XCConfigSignature::getSignedFields() . " FROM $sql_tbl[config] WHERE $_condition");
        } else {
            $old_configs = array();
        }

        func_array2update(
            'config',
            array('value' => addslashes($configuration['server_ip'])),
            $_condition
        );

        if (XCConfigSignature::isApplicable(array('name'=> $dbName))) {
            func_secure_update_config_signatures($old_configs);
        }
    }

}

function xpc_get_saved_cards_admin()
{
    global $sql_tbl;
    $cards = func_query_hash("SELECT * FROM $sql_tbl[xpc_saved_cards]", 'id', false);

    return $cards;
}

function xpc_get_saved_cards($user_id = false, $clear_cache = false)
{
    global $logged_userid, $sql_tbl;

    if (false === $user_id) {
        $user_id = $logged_userid;
    }

    if (!is_numeric($user_id))
        return false;

    static $cards_cache = array();

    if ($clear_cache) {
        $cards_cache = array();
    } elseif (isset($cards_cache[$user_id])) {
        return $cards_cache[$user_id]; 
    }

    $cards = func_query_hash("SELECT * FROM $sql_tbl[xpc_saved_cards] WHERE userid = '$user_id'", 'id', false);
    if (empty($cards)) {
        // Check if old style data is available to migrate
        $can_migrate = (func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[xpc_saved_cards_migrated] WHERE userid='$user_id'") == 0);

        if ($can_migrate) {
        
            $cards = array();

            $cards_hash = func_query_hash(
               "SELECT $sql_tbl[order_extras].* 
                FROM $sql_tbl[order_extras] 
                INNER JOIN $sql_tbl[orders] 
                    ON ($sql_tbl[orders].userid = '" . $user_id . "' AND $sql_tbl[orders].orderid = $sql_tbl[order_extras].orderid) 
                WHERE khash IN ('xpc_saved_card_type', 'xpc_saved_card_num', 'xpc_use_recharges')
                ORDER BY orderid DESC",
                'orderid'
            );

            x_load('order');
            foreach ($cards_hash as $orderid => $extras) {
                $extras_hash = array();
                foreach ($extras as $extra) {
                    $extras_hash[$extra['khash']] = $extra['value'];
                }
                if (!empty($extras_hash['xpc_use_recharges']) && $extras_hash['xpc_use_recharges'] == 'Y') {
                    $order = func_order_data($orderid);

                    $card_saved = xpc_store_saved_card(
                        $user_id,
                        $extras_hash['xpc_saved_card_num'],
                        $extras_hash['xpc_saved_card_type'],
                        $order['order']['extra']['xpc_txnid'],
                        $orderid,
                        $order['order']['paymentid'],
                        $order['order']['date'],
                        'N'
                    );

                    if ($card_saved) {
                        $extra_order_data = array(
                            'xpc_saved_card_id'        => $card_saved,
                            'xpc_saved_card_paymentid' => $order['order']['paymentid'],
                        );

                        foreach($extra_order_data as $khash => $value) {
                            func_array2insert(
                                'order_extras',
                                array(
                                    'orderid' => $orderid,
                                    'khash'   => $khash,
                                    'value'   => $value,
                                ),
                                true
                            );
                        }
                    }
                }
            }

            // This will set the default to latest one
            xpc_get_default_card();

            $res = db_query("REPLACE INTO $sql_tbl[xpc_saved_cards_migrated] (userid) VALUES ('$user_id')");
            if ($res) {
                // Make sure query was applied to avoid endless recursion and call self to get cards again
                return xpc_get_saved_cards($user_id);
            }
        }
    }

    $cards_cache[$user_id] = $cards;

    return $cards;
}

function xpc_get_default_card($user_id = false) {
    global $logged_userid, $sql_tbl;

    if (false === $user_id) {
        $user_id = $logged_userid;
    }

    if (!is_numeric($user_id))
        return false;

    $default_id = intval(func_query_first_cell("SELECT id FROM $sql_tbl[xpc_saved_cards] WHERE userid = '$user_id' AND is_default = 'Y'"));

    if (!$default_id) {
        // Set the last card as a default one
        $default_id = intval(func_query_first_cell("SELECT id FROM $sql_tbl[xpc_saved_cards] WHERE userid = '$user_id' ORDER BY date_added DESC LIMIT 1"));
        if ($default_id) {
            xpc_set_default_card($user_id, $default_id);
        }
    }

    return $default_id;     
}

function xpc_store_saved_card($user_id, $card_num, $card_type, $xpc_txnid, $orig_orderid, $paymentid, $date_added = 0, $is_default = '')
{ //{{{

    global $sql_tbl;

    if (empty($is_default)) {
        $customer_has_cards = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[xpc_saved_cards] WHERE userid = '$user_id' AND is_default = 'Y'");
        $is_default = (!$customer_has_cards) ? 'Y' : 'N';
    }

    if (empty($date_added)) {
        $date_added = XC_TIME;
    }

    if (is_array($card_num)) {
        // API 1.5 or higher have extended card information
        $card_type = $card_num['card_type'];
        $card_expire = $card_num['card_expire'];
        $card_num = $card_num['card_num'];
    } else {
        // Old-style, without expiration date, must set empty value
        $card_expire = '';
    }

    $card_data = array(
        'xpc_txnid' => $xpc_txnid,
        'userid' => $user_id,
        'card_num' => $card_num,
        'card_type' => $card_type,
        'card_expire' => $card_expire,
        'date_added' => $date_added,
        'orderid' => $orig_orderid,
        'paymentid' => $paymentid,
        'is_default' => $is_default,
    );

    $card_id = func_query_first_cell("SELECT id FROM $sql_tbl[xpc_saved_cards] WHERE xpc_txnid = '" . addslashes($xpc_txnid) . "'");

    if ($card_id) {

        $card_data['id'] = $card_id;

        // Replace existing card
        func_array2insert('xpc_saved_cards', $card_data, true);

    } else {
        // Save new card
        $card_id = func_array2insert('xpc_saved_cards', $card_data);
    }

    return ($card_id) ? $card_id : 0;

} //}}}

function xpc_check_order_for_user($userid, $orderid)
{
    global $sql_tbl;

    $userid = intval($userid);
    $orderid = intval($orderid);

    return func_query_first_cell(
       "SELECT count(*) 
        FROM $sql_tbl[orders] 
        WHERE 
            userid='". $userid . "' 
            AND $sql_tbl[orders].orderid = '" . $orderid . "'"
    );
}

function xpc_get_allow_save_cards()
{
    global $session_allow_save_cards;
    x_session_register('session_allow_save_cards');

    if (true !== $session_allow_save_cards)
        $session_allow_save_cards = false;

    return $session_allow_save_cards;
}

function xpc_set_allow_save_cards($allow_save_cards)
{
    global $session_allow_save_cards;

    if (
        'Y' === $allow_save_cards
        || true === $allow_save_cards
    ) {
        $allow_save_cards = true;
    } else {
        $allow_save_cards = false;
    }

    x_session_register('session_allow_save_cards');
    $session_allow_save_cards = $allow_save_cards;

}

function xpc_delete_saved_card($userid, $id)
{//{{{
    global $sql_tbl, $active_modules, $top_message;

    $userid = intval($userid);
    $id = intval($id);

    if (
        !empty($active_modules['XPayments_Subscriptions'])
        && func_xps_isCardUsedBySubscription($id)
    ) {
        $top_message = array(
            'type'    => 'I',
            'content' => func_get_langvar_by_name('txt_xps_card_used_for_subscription_cannot_be_removed'),
        );

        return false;
    }

    $result = db_query("DELETE FROM $sql_tbl[xpc_saved_cards] WHERE id = '$id' AND userid = '$userid'");

    // This function will check if there are is_default entry and if not - fix it
    xpc_get_default_card();

    return $result;

}//}}}

function xpc_set_default_card($userid, $id)
{
    global $sql_tbl;

    $userid = intval($userid);
    $id = intval($id);

    return db_query("UPDATE $sql_tbl[xpc_saved_cards] SET is_default = IF(id = '$id', 'Y', 'N') WHERE userid = '$userid'");

}

function xpc_request_recharge_payment($orig_xpc_txnid, $amount, $description = false, $refId = '')
{
    global $current_location, $current_area, $cart, $logged_userid;

    $data = array(
        'txnId' => $orig_xpc_txnid,
        'refId' => $refId,
        'amount'=> $amount,
        'description' => (false === $description) ? 'Payment using saved card' : $description ,
        'callbackUrl' => $current_location . '/payment/cc_xpc.php',
    );

    if (
        $current_area == 'C'
        && !empty($cart)
        && xpc_api_supported('1.6')
    ) {

        $united_cart = $cart;
        $united_cart['userinfo'] = func_userinfo($logged_userid);

        // Prepare cart
        $xpc_cart = xpc_prepare_cart($united_cart, $refId, false);

        if (!$xpc_cart) {
            return xpc_api_error('Unable to prepare cart data');
        }

        $data['cart'] = $xpc_cart;
    }

    list($status, $response) = xpc_api_request('payment', 'recharge', $data);

    return array($status, $response);
}

function xpc_get_orig_paymentid_for_recharge($orderid)
{
    global $sql_tbl;

    $orderid = intval($orderid);

    $paymentid = func_query_first_cell(
       "SELECT value
        FROM $sql_tbl[order_extras] 
        WHERE orderid = '$orderid' AND khash = 'xpc_saved_card_paymentid'"
    );

    if (!$paymentid) {
        $paymentid = func_query_first_cell(
           "SELECT paymentid 
            FROM $sql_tbl[orders] 
            INNER JOIN $sql_tbl[order_extras] 
                ON ($sql_tbl[order_extras].orderid = '" . $orderid . "' AND khash = 'xpc_orig_orderid')
            WHERE $sql_tbl[orders].orderid = $sql_tbl[order_extras].value"
        );
    }

    return $paymentid;
}

function xpc_compose_payment_method_text($paymentid, $payment_method = '')
{ //{{{
    global $sql_tbl;

    x_load('payment', 'tests'); 

    $module_params = xpc_get_module_params($paymentid);
    $in_testmode = !empty($module_params) ? get_cc_in_testmode($module_params) : false;

    if (empty($payment_method)) {
        if ($module_params) {
            $payment_method = func_query_first_cell("SELECT payment_method FROM $sql_tbl[payment_methods] WHERE paymentid = '$paymentid'");
        } else {
            // payment method was removed - get name from the "Use saved card" one
            $payment_method = func_query_first_cell("SELECT payment_method FROM $sql_tbl[payment_methods] WHERE payment_script = 'payment_xpc_recharge.php'");
        }
    }

    if (empty($module_params) || strpos($module_params['processor'], 'ps_paypal') !== false) {
        $result = stripslashes($payment_method) . (($in_testmode) ? ' (in test mode)' : '');
    } else {
        $result = stripslashes($payment_method) . ' (' . $module_params['module_name'] . (($in_testmode) ? ', in test mode' : '') . ')';
    }

    return $result;

} //}}}

function xpc_use_recharges($paymentid = false) 
{
    global $sql_tbl;

    $paymentids = is_numeric($paymentid)
        ? " AND paymentid = '$paymentid' "
        : "";

    //TODO: Probably it's necessary to check active, membership etc condition     
    $result = func_query_first_cell("SELECT count(*) FROM $sql_tbl[payment_methods] WHERE use_recharges = 'Y' AND processor_file IN ('cc_xpc.php', 'ps_paypal_pro.php')  $paymentids");

    return $result;
}

function xpc_get_api_version() { //{{{
    global $config;

    return (!empty($config['XPayments_Connector']['xpc_api_version'])) ? $config['XPayments_Connector']['xpc_api_version'] : XPC_API_VERSION;
} //}}}

function xpc_lock_order_auto_create() { //{{{
    global $config;

    $insert = (!isset($config['xpc_lock_order_create']));

    $config['xpc_lock_order_create'] = XC_TIME;

    if ($insert) {
        func_array2insert(
            'config',
            array(
                'name' => 'xpc_lock_order_create',
                'value' => $config['xpc_lock_order_create'],
            )
        );
    } else {
        func_array2update(
            'config',
            array(
                'value' => $config['xpc_lock_order_create'],
            ),
            "name = 'xpc_lock_order_create'"
        );
    }

} //}}}

function xpc_unlock_order_auto_create() { //{{{
    global $config;

    $config['xpc_lock_order_create'] = 0;
    func_array2update(
        'config',
        array(
            'value' => $config['xpc_lock_order_create'],
        ),
        "name = 'xpc_lock_order_create'"
    );

} //}}}

function xpc_can_auto_create_order() { //{{{
    global $config;

    if (!empty($config['xpc_lock_order_create'])) {
        // lock works only within 30 sec period
        if (XC_TIME <= ($config['xpc_lock_order_create'] + 30)) {
            return false;
        } else {
            xpc_unlock_order_auto_create();
        }
    }

    return true;

} //}}}

function xpc_process_recharge($saved_card_id, $new_total, $new_orderids, $userid = false) { //{{{

    if (!is_array($new_orderids)) {
        $new_orderids = array($new_orderids);
    }

    $saved_cards = xpc_get_saved_cards($userid);
    $saved_card = $saved_cards[$saved_card_id];

    $orig_orderid = $saved_card['orderid'];

    $description = ($orig_orderid) ? "Using saved card from #$orig_orderid" : 'Using saved card';

    // Do not create new orders on callbacks to avoid race condition until txnId is stored in DB
    xpc_lock_order_auto_create();

    list($xpc_status, $xpc_result) = xpc_request_recharge_payment(
        $saved_card['xpc_txnid'],
        $new_total,
        'Order(s) #' . implode(', #', $new_orderids) . " ($description)",
        implode('-', $new_orderids)
    );

    if ($xpc_status) {

        $saved_cards = xpc_get_saved_cards($userid, true);
        $saved_card = $saved_cards[$saved_card_id];

        $extra_order_data = array(
            'xpc_txnid'                => $xpc_result['transaction_id'],
            'xpc_saved_card_id'        => $saved_card_id,
            'xpc_saved_card_num'       => $saved_card['card_num'],
            'xpc_saved_card_type'      => $saved_card['card_type'],
            'xpc_saved_card_paymentid' => $saved_card['paymentid'],
        );
        
        if (!empty($saved_card['card_expire'])) {
            $extra_order_data['xpc_saved_card_expire'] = $saved_card['card_expire'];
        }

        if ($orig_orderid) {
            $extra_order_data['xpc_orig_orderid'] = $orig_orderid;
        }

        $card_info = 'Paid by card: ' . $saved_card['card_type'] . ' ' . $saved_card['card_num'] . ' ' . $saved_card['card_expire'];

        if (XPC_AUTH_ACTION == $xpc_result['status']) {
            $extra_order_data['capture_status'] = 'A';
        } elseif (XPC_CHARGED_ACTION == $xpc_result['status']) {
            $extra_order_data['capture_status'] = '';
        }

        func_change_order_status($new_orderids, xpc_get_order_status_by_action($xpc_result['status']), $card_info);

        foreach($extra_order_data as $khash => $value) {

            foreach($new_orderids as $oid) {

                func_array2insert(
                    'order_extras',
                    array(
                        'orderid' => $oid,
                        'khash'   => $khash,
                        'value'   => $value,
                    ),
                    true
                );

            }
        }

    } else {
        func_change_order_status($new_orderids, 'F');
    }

    xpc_unlock_order_auto_create();

    return array($xpc_status, $xpc_result);

} //}}}

function xpc_get_cc_processors($recharge_only = false)
{ //{{{

    global $sql_tbl, $config;

    $extra_condition = ($recharge_only ? " AND $sql_tbl[payment_methods].active = 'Y' AND $sql_tbl[payment_methods].use_recharges = 'Y' AND $sql_tbl[ccprocessors].has_preauth = 'Y'" : '');

    $cc_processors = func_query(
        "SELECT $sql_tbl[ccprocessors].*, payment_template, use_recharges, active
         FROM $sql_tbl[ccprocessors]
         INNER JOIN $sql_tbl[payment_methods]
            ON $sql_tbl[ccprocessors].paymentid = $sql_tbl[payment_methods].paymentid
         WHERE $sql_tbl[ccprocessors].paymentid>0
            AND processor='cc_xpc.php'
         $extra_condition
         ORDER BY $sql_tbl[ccprocessors].param08
    ");

    if (empty($cc_processors)) {
        $cc_processors = array();
    }

    return $cc_processors;

} //}}}

function xpc_get_save_cc_paymentid()
{ //{{{

    global $sql_tbl, $config;

    // 'True' param is to get processors suitable for recharge only
    $cc_processors = xpc_get_cc_processors(true);

    if (empty($cc_processors)) {
        return 0;
    }

    $result = $config['XPayments_Connector']['xpc_save_cc_paymentid'];

    if (!empty($result)) {
        // Check if selected payment method is active and recharge is enabled
        $found = false;
        foreach ($cc_processors as $processor) {
            if ($processor['paymentid'] == $result) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $result = 0;
        }
    }

    if (empty($result)) {
        // get first active processor with recharge enabled as default
        $result = $cc_processors[0]['paymentid'];
    }

    return $result;

} //}}}

function xpc_process_import_payment_methods($clear_payment_methods = false)
{ //{{{

    global $top_message;

    $result = false;

    // Now request methods
    $list = xpc_request_get_payment_methods();

    if ($list) {

        $result = xpc_import_payment_methods($list, $clear_payment_methods);

        if ($result) {

            if (!isset($top_message['content'])) {
                $top_message['content'] = '';
            }
            $top_message['content'] .= func_get_langvar_by_name('txt_xpc_msg_import_success');

        } else {

            $top_message['type'] = 'E';
            $top_message['content'] = func_get_langvar_by_name('txt_xpc_msg_import_failed');

        }

    } elseif (is_array($list)) {

        $top_message = array(
            'type' => 'W',
            'content' => func_get_langvar_by_name('txt_xpc_msg_import_request_empty')
        );

    } else {

        $top_message = array(
            'type' => 'E',
            'content' => func_get_langvar_by_name('txt_xpc_msg_import_request_failed')
        );
    }

    return $result;

} //}}}

/**
 * Detects API version, tests it and then imports/updates payment methods
 *
 * @return bool
 */
function xpc_process_configuration_update($may_need_to_clear_payment_methods = false)
{ //{{{

    global $top_message, $config;

    $config['XPayments_Connector'] = xpc_prepare_config_vars($config['XPayments_Connector']);

    $clear_payment_methods = (
        $config['XPayments_Connector']['xpc_shopping_cart_id'] != $config['XPayments_Connector']['xpc_previous_cart_id']
        &&
        $may_need_to_clear_payment_methods
    );

    // Autodetect API and test module
    $result = xpc_autodetect_api_version();

    if (true === $result['status']) {

        // Now request methods
        return xpc_process_import_payment_methods($clear_payment_methods);

    } else {

        $top_message['type'] = 'W';
        $top_message['content'] = func_get_langvar_by_name('txt_xpc_msg_test_failed');

        return false;

    }

} //}}}

function xpc_is_callback_reachable()
{ //{{{

    global $https_location, $config, $xcart_https_host;

    // Check if script is accessible at all, even from the same host
    x_load('http');
    list($headers, $result) = func_https_request('GET', $https_location . '/payment/cc_xpc.php?mode=test');
    $is_success = (preg_match("/HTTP.*\s(200|301|302)\s/i", $headers) && !empty($result)) === true;

    return $is_success;
    

} //}}}

/**
 * Check module system requirements
 *
 * @return boolean Requirements checking result
 */
function xpc_check_requirements()
{
    $code = 0;

    if (!function_exists('curl_init')) {
        $code = $code | XPC_REQ_CURL;
    }

    if (
        !function_exists('openssl_pkey_get_public') || !function_exists('openssl_public_encrypt')
        || !function_exists('openssl_get_privatekey') || !function_exists('openssl_private_decrypt')
        || !function_exists('openssl_free_key')
    ) {
        $code = $code | XPC_REQ_OPENSSL;
    }

    if (!class_exists('DOMDocument')) {
        $code = $code | XPC_REQ_DOM;
    }

    return $code;
}

/**
 * Outputs headers that prevents caching of script
 */
function xpc_send_anticache_headers()
{
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
    header("Pragma: no-cache");
}

/**
 * Closes connection so that PHP can work in background
 */
function xpc_force_close_connection($force_code='')//Sync with func_force_close_connection
{//{{{
    ignore_user_abort(true);
    ob_end_clean();
    ob_start();
    // Force some http code usually 200 OK
    if (!empty($force_code)) {
        $server_protocol = filter_input(INPUT_SERVER, 'SERVER_PROTOCOL', FILTER_SANITIZE_STRING);
        header($server_protocol . ' ' . $force_code);//200 OK
    }
    header('Content-Encoding: none');
    header('Content-Length: '. ob_get_length());
    header('Connection: close');
    ob_end_flush();
    ob_flush();
    flush();

    if (is_callable('fastcgi_finish_request')) {
        // Required for nginx
        session_write_close();
        fastcgi_finish_request();
    }
}//}}}

/**
 * Checks if specified API version is supported during XP<->XC interactions in current configuration
 */
function xpc_api_supported($api_version) {
    return (version_compare(xpc_get_api_version(), $api_version) >= 0);
}

/**
 * Skip X-Payments payment method and show popup with error 
 */
function xpc_iframe_popup_error($error)
{
    $message_type = XPC_IFRAME_CHANGE_METHOD;

    $error = func_js_escape($error);

    $page = <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<script type="text/javascript">
//<![CDATA[
function postMessageToParent(msg) {
  if (window.parent !== window && window.JSON) {
    window.parent.postMessage(JSON.stringify(msg), '*');
  }
}
postMessageToParent({
    message: 'paymentFormSubmitError',
    params: {
        height: '0',
        error: '$error',
        type: '$message_type'
    }
});
//]]>
</script>
</body>
</html>
HTML;

    func_flush($page);
    func_exit();

}

/**
 * Defines variables in smarty for add new card feature
 */
function xpc_set_variables_add_new_card_smarty($userid, $membershipid)
{
    global $smarty, $config, $xpc_save_card_address, $xpc_save_card_show_form;

    $xpc_save_cc_paymentid = xpc_get_save_cc_paymentid();

    $allow_add_new_card =
                    $config['XPayments_Connector']['xpc_save_cc_enable'] == 'Y'
                    && $xpc_save_cc_paymentid > 0
                    && !func_is_address_book_empty($userid);
    
    if (
        $xpc_save_cc_paymentid
        && $allow_add_new_card
    ) {
        x_load('cart');
        $allow_add_new_card = false;
        $payment_methods = check_payment_methods($membershipid);
        foreach ($payment_methods as $payment) {
            if ($payment['paymentid'] == $xpc_save_cc_paymentid) {
                $allow_add_new_card = true;
                break;
            }
        }
    }

    $smarty->assign('xpc_save_cc_paymentid', $xpc_save_cc_paymentid);
    $smarty->assign('xpc_allow_add_new_card', $allow_add_new_card);

    if ($allow_add_new_card) {

        x_session_register('xpc_save_card_address', array());

        if (empty($xpc_save_card_address)) {
            $addresses = func_get_address_book($userid);
            foreach ($addresses as $address) {
                if ('Y' == $address['default_b']) {
                    $xpc_save_card_address = $address;
                    break;
                }
            }
        }

        // Additional address fields are skipped here since they're not used by X-Payments
        $smarty->assign('xpc_address', $xpc_save_card_address);

        $address_fields = func_get_default_fields('C', 'address_book', true, true);
        $smarty->assign('xpc_default_fields', $address_fields);

        x_session_register('xpc_save_card_show_form', false);
        $smarty->assign('auto_open_save_card', $xpc_save_card_show_form);
        $xpc_save_card_show_form = false;

    }

    return $allow_add_new_card;

}


?>
