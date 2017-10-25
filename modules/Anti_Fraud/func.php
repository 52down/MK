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
 * Functions for Anti Fraud module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v45 (xcart_4_7_7), 2017-01-24 09:29:34, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

/**
 * AVS risk scores for ZIP, address, and cardholder name
 */
const AVS_ZIP_SCORE = 4;
const AVS_ADDRESS_SCORE = 2;
const AVS_CARDHOLDER_SCORE = 1;

/**
 * Threshold for the AVS
 */
const AVS_THRESHOLD = 5;

function func_af_check_error2msg($check_error)
{
    global $__AF_return_labels;

    $default_msg = 'txt_antifraud_service_generror';
    $check_error = trim($check_error);

    if (empty($check_error)) return '';

    $msg = '';

    if (isset($__AF_return_labels[$check_error]))
        $msg = $__AF_return_labels[$check_error];
    else
        $msg = $default_msg;

    return $msg;
}

function func_is_high_risk_country($code)
{
    global $config;

    if (empty($config['high_risk_countries']))
        return false;

    $hrisk = @explode(",", $config['high_risk_countries']);

    return in_array($code, $hrisk);
}

/**
 * Send customer IP address to Anti Fraud server
 */
function func_send_ip_to_af($orderid, $reason = '')
{
    global $sql_tbl, $xcart_http_host, $config;

    x_load('http','tests');

    if (!test_active_bouncer()) {
        // ERROR: cannot continue without https modules
        return false;
    }

    $anti_fraud_url = ANTIFRAUD_URL . '/add_fraudulent_ip.php';

    $ip = func_query_first_cell("SELECT value FROM $sql_tbl[order_extras] WHERE orderid = '$orderid' AND khash = 'ip'");

    if (empty($ip))
        return false;

    $post = array("mode=add_ip");
    $post[] = "ip=" . $ip;
    $post[] = "shop_host=" . $xcart_http_host;
    $post[] = "reason=" . $reason;
    $post[] = "service_key=" . $config['Anti_Fraud']['anti_fraud_license'];

    return func_https_request('POST', $anti_fraud_url, $post);
}

// Check IP address at Anti Fraud server
function func_check_ip_at_af($ip, $proxy_ip = false, $address = false)
{
    global $config;

    x_load('http','tests');

    $anti_fraud_url = ANTIFRAUD_URL . '/check_ip.php';

    if($proxy_ip === false)
        $proxy_ip = $ip;

    $post = '';
    $post[] = 'service_key=' . $config['Anti_Fraud']['anti_fraud_license'];
    $post[] = 'ip=' . $ip;
    $post[] = 'proxy_ip=' . $proxy_ip;

    if ($address) {
        $address = func_stripslashes($address);
        $post[] = 'city=' . $address['city'];
        $post[] = 'state=' . $address['state'];
        $post[] = 'country=' . $address['country'];
        if (
            isset($address['zipcode'])
            && !empty($address['zipcode'])
        ) {
            $post[] = 'zipcode=' . $address['zipcode'];
        }
    }

    list($headers, $result) = func_https_request('POST', $anti_fraud_url, $post);

    $tmp         = explode("\n",$result);
    $status     = unserialize($tmp[0]);
    $resolved     = unserialize($tmp[1]);

    return array(
        'headers'     => $headers,
        'status'     => $status,
        'data'        => $resolved,
    );
}

// Check order should be blocked (declined) because of threshold is exceeded
function func_antifraud_check_block_order($orderids)
{
    global $config;

    if (
        !is_array($orderids)
        || 'Y' != $config['Anti_Fraud']['block_order_after_threshold']
    ) {
        return false;
    }

    $risk = func_get_orders_fraud_risk_factor($orderids);

    $threshold = $config['Anti_Fraud']['anti_fraud_limit'];

    $result = (
        $risk
        && $threshold
        && doubleval($risk) >= doubleval($threshold)
    ); 

    return $result;
}

// Check that the order was blocked by AntiFraud and X-Payments check-cart failed
function func_antifraud_check_xpc_return_message_for_blocked_order($orderids, $message) 
{
    // List of messages retured by X-Payments for failed check cart callback (might be changed in next API versions)
    static $blocked_messages = array(
        'Unable to process payment because cart content has changed. Try to restart checkout.' // API <= 1.5
    );

    return func_antifraud_check_block_order($orderids)
        && in_array($message, $blocked_messages);
}

// Check if order should be blocked by AVS returned from X-Payments
function func_antifraud_check_xpc_block_avs($response)
{
    global $config;

    if (
        !isset($response['cardValidation'])
        || !is_array($response['cardValidation'])
        || 'Y' != $config['Anti_Fraud']['block_by_avs']
    ) {
        return false;
    }

    $avs = $response['cardValidation'];

    $score = 0;

    if (2 == $avs['avs_c']) {
        $score += AVS_CARDHOLDER_SCORE;
    }

    if (2 == $avs['avs_a']) {
        $score += AVS_ADDRESS_SCORE;
    }

    if (2 == $avs['avs_z']) {
        $score += AVS_ZIP_SCORE;
    }

    return $score >= AVS_THRESHOLD;
}

// Decline order and redirect to error page
function func_antifraud_decline_orders_n_redirect2error_page($orderids)
{
    global $config, $xcart_catalogs;

    define('STATUS_CHANGE_REF', 6);

    func_change_order_status(
        $orderids,
        'F',
        func_get_langvar_by_name('txt_antifraud_order_note', array(), $config['default_admin_language'], true)
    );

    $bill_error = 'error_ccprocessor_error';
    $reason = "&bill_message=" . urlencode(func_get_langvar_by_name('txt_err_place_order_antifraud_block', null, false, true));;

    func_header_location($xcart_catalogs['customer'] . "/error_message.php?" . "error=" . $bill_error . $reason);

    exit;
}

?>
