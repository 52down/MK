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
 * Netbanx - Hosted Payments
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v5 (xcart_4_7_7), 2017-01-24 09:29:34, func.cc_netbanx_hosted.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header('Location: ../'); die('Access denied'); }

class XCNetbanxUtil {

  public static function array_filter_recursive($input) {//{{{
    foreach ($input as &$value) {#nolint
        if (is_array($value)) {#nolint
            $value = self::array_filter_recursive($value);
        }
    }

    return array_filter($input);
  }//}}}

  public static function makeRequest($module_params, $method, $api, $data= '', $return_mode='') {//{{{
    $pp_url = ($module_params['testmode'] == 'Y') ? 'https://api.test.netbanx.com/hosted/v1' : 'https://api.netbanx.com/hosted/v1';
    $pp_url .= $api;

    list($a, $result) = func_https_request(
        $method,
        $pp_url,
        !empty($data) ? json_encode($data) : '',
        '&', // join
        '', // cookie
        $method != 'DELETE' ? 'application/json' : '',
        '', // referer
        '', // cert
        '', // kcert
        array('Authorization' => 'Basic ' . base64_encode($module_params['param01'] . ':' . $module_params['param02']))//Headers
    );

    if (defined('XC_NETBANX_DEBUG')) {
        func_pp_debug_log('netbanx-hosted', $method . ' ' . $pp_url,  
            print_r($data, true) . 
            (empty($result) ? print_r($a, true) : ($result . print_r(json_decode($result, true), true)))
        );
    }

    return ($return_mode == 'return_headers') ? array($a, $result) : $result;
  }//}}}

}

/**
 * Do Capture transaction
 *
 * @param mixed $order Order data
 *
 * @return array
 * @see    ____func_see____
 */
function func_cc_netbanx_hosted_do_capture($order) {//{{{
    x_load('http','payment');
    $module_params = func_get_pm_params('cc_netbanx_hosted.php');
    $transaction_data = unserialize($order['order']['extra']['transaction_data']);

    $result = XCNetbanxUtil::makeRequest(
        $module_params, 
        'POST', 
        '/orders/' . $order['order']['extra']['txnid'] . '/settlement', 
        array('merchantRefNum' => $transaction_data['merchantRefNum'])
    );

    $response = !empty($result) ? json_decode($result, true) : array();

    $status = !empty($response['confirmationNumber']) && $response['amount'] == $transaction_data['totalAmount'];

    if (!$status) {
        $err_msg = ' Original amount:' . ($transaction_data['totalAmount'] / 100) . '<br />(code:' . $response['error']['code'] . '-' . $response['error']['message'] . ')';
    } else {
        $err_msg = '';
    }

    $extra = array(
        'name' => 'txnid',
        'value' => $response['id'],
    );

    return array($status, $err_msg, $extra);

}//}}}

/**
 * Do Void transaction
 *
 * @param mixed $order Order data
 *
 * @return array
 * @see    ____func_see____
 */
function func_cc_netbanx_hosted_do_void($order) {//{{{
    x_load('http','payment');
    $module_params = func_get_pm_params('cc_netbanx_hosted.php');

    list($a, $result) = XCNetbanxUtil::makeRequest($module_params, 'DELETE', '/orders/' . $order['order']['extra']['txnid'], '', 'return_headers');

    $response = !empty($result) ? json_decode($result, true) : array();

    $status = $response['transaction']['status'] == 'cancelled' || func_url_check_headers(array($a, $result), ' 200 OK') == ' 200 OK';

    if (!$status) {
        $err_msg = $response['transaction']['status'] . ': ' . $response['transaction']['reversed'] . ':' . $response['transaction']['errorCode'] . ':' . $response['transaction']['errorMessage'] . ' (' . $response['error']['code'] . '-' . $response['error']['message'] . ')';
    } else {
        $err_msg = '';
    }

    $extra = array(
        'name' => 'txnid',
        'value' => $order['order']['extra']['txnid']
    );

    return array($status, $err_msg, $extra);
}//}}}

