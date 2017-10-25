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
 * "Netbanx Hosted Payments (credit card processor)
 * https://developer.optimalpayments.com/en/documentation/hosted-payment-api/test-cards/
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Payment interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v5 (xcart_4_7_7), 2017-01-24 09:29:34, cc_netbanx_hosted.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

// Uncomment the below line to enable the debug log
// define('XC_NETBANX_DEBUG', 1);

if (!isset($REQUEST_METHOD)) {
    $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
}

if ($REQUEST_METHOD == 'GET'
    && !empty($_GET['mode'])
    && !empty($_GET['ref_full'])
    && in_array($_GET['mode'], array('cancel', 'return'))
) { //{{{ Customer Return or Cancel

    require __DIR__.'/auth.php';

    if (!func_is_active_payment('cc_netbanx_hosted.php')) {
        exit;
    }

    if (defined('XC_NETBANX_DEBUG')) {
        func_pp_debug_log('netbanx-hosted', 'B', $_GET);
    }

    $skey = $ref_full;
    if ($mode == 'cancel') {
        $bill_output['sessid'] = func_query_first_cell("SELECT sessid FROM $sql_tbl[cc_pp3_data] WHERE ref='$skey'");
        $bill_output['code'] = 2;
        $bill_output['billmes'] = 'Canceled by the user';
        require $xcart_dir . '/payment/payment_ccend.php';
    } else {
        require $xcart_dir . '/payment/payment_ccview.php';
    }
//}}}
} elseif (!empty($_POST['secure_callback_key']) || !empty($_GET['secure_callback_key'])) {
    //{{{ Callback received
    require __DIR__.'/auth.php';

    if (!func_is_active_payment('cc_netbanx_hosted.php')) {
        exit;
    }

    if (defined('XC_NETBANX_DEBUG')) {
        func_pp_debug_log('netbanx-hosted', 'C', print_r($_GET, true) . print_r($_POST, true));
    }

    $skey = $ref_full;
    $bill_output['sessid'] = func_query_first_cell("SELECT sessid FROM $sql_tbl[cc_pp3_data] WHERE ref='$skey'");
    $module_params = func_get_pm_params('cc_netbanx_hosted.php');

    if(!empty($callback_on_success)) {

        $validated_callback = func_query_first("SELECT param1, param2 FROM $sql_tbl[cc_pp3_data] WHERE ref='$secure_callback_key'");
        $bill_output['code'] = !empty($validated_callback) ? 1 : 3;
        $bill_output['billmes'] = (!empty($validated_callback) ? '' : ('Signature is incorrect! ')) . (empty($id) ? '' : ('AuthNo: ' . $id));

        if ($module_params['use_preauth'] == 'Y' || func_is_preauth_force_enabled($secure_oid)) {
            $bill_output['is_preauth'] = true;
            $extra_order_data = array(
                'txnid' => $validated_callback['param1'],
                'transaction_data' => $validated_callback['param2'],
                'capture_status' => 'A'
            );
        }
    } else {
        $bill_output['code'] = 2;
        $bill_output['billmes'] = 'Status: transaction ' . $id . ' has been declined';
    }

    include $xcart_dir . '/payment/payment_ccmid.php';
    include $xcart_dir . '/payment/payment_ccwebset.php';
    //}}}
} else {
//Initial request{{{

    if (!defined('XCART_START')) { header('Location: ../'); die('Access denied'); }

    if (!func_is_active_payment('cc_netbanx_hosted.php')) {
        exit;
    }

    x_load('http');


    func_pm_load('cc_netbanx_hosted');

    // https://developer.optimalpayments.com/en/documentation/hosted-payment-api/addendumdata-object/
    $callback_key = func_get_secure_random_key(50);
    $ref_num = substr($module_params['param09'] . join('-', $secure_oid), 0, 40);
    $ref_full = substr(uniqid($module_params['param09'] . join('_', $secure_oid), true) . 'OID' . join('_', $secure_oid), 0, 100);

    $post = array(
        'merchantRefNum'            => $ref_num,
        'currencyCode'              => $module_params['param03'],
        'totalAmount'               => round($cart['total_cost'] * 100),
        //'customerIp'                => $_SERVER['REMOTE_ADDR'],
        'customerNotificationEmail' => $userinfo['email'],
        'merchantNotificationEmail' => $module_params['param05'],
        'shoppingCart'              => array(),
        'billingDetails'            => array(
            'city'                 => $userinfo['b_city'],
            'country'              => $userinfo['b_country'],
            'street'               => $userinfo['b_address'],
            'street2'               => empty($userinfo['b_address_2']) ? '' : $userinfo['b_address_2'],
            'zip'                  => $userinfo['b_zipcode'],
            'state'                => $userinfo['b_state'],
            'phone'                => $userinfo['b_phone'],
        ),
        'shippingDetails'            => array(
            'city'                 => $userinfo['s_city'],
            'country'              => $userinfo['s_country'],
            'street'               => $userinfo['s_address'],
            'street2'               => empty($userinfo['s_address_2']) ? '' : $userinfo['s_address_2'],
            'zip'                  => $userinfo['s_zipcode'],
            'state'                => $userinfo['s_state'],
            'phone'                => $userinfo['s_phone'],
        ),
        'ancillaryFees'            => array(),
        'link'                  => array(
            array(
                'rel' => 'cancel_url',
                'uri' => $current_location . '/payment/cc_netbanx_hosted.php?mode=cancel',
            ),
            array(
                'rel' => 'return_url',
                'uri' => $current_location . '/payment/cc_netbanx_hosted.php?mode=return',
            ),
        ),
        'callback'                  => array(
            array(
                'format' => 'form-urlencoded',
                'rel' => 'on_success',
                'synchronous' => false,
                'uri' => $current_location . '/payment/cc_netbanx_hosted.php?callback_on_success=1&secure_callback_key=' . $callback_key . '&ref_full=' . $ref_full,
                'returnKeys' => array('id'), //This is the transaction ID returned in response to the initial order request.
            ),
            array(
                'format' => 'form-urlencoded',
                'rel' => 'on_decline',
                'synchronous' => false,
                'uri' => $current_location . '/payment/cc_netbanx_hosted.php?callback_on_decline=1&secure_callback_key=' . $callback_key . '&ref_full=' . $ref_full,
                'returnKeys' => array('id'),
            ),
        ),
        'addendumData' => array(
            array(
                'key'   => 'ref_full',
                'value' => $ref_full,
            ),
        ),
        'extendedOptions' => array(
            array(
                'key'   => 'authType',
                'value' => ($module_params['use_preauth'] == 'Y' || func_is_preauth_force_enabled($secure_oid))
                    ? 'auth'
                    : 'purchase',
            ),
        ),
    );

    $post = XCNetbanxUtil::array_filter_recursive($post);
    $post['totalAmount'] = empty($post['totalAmount']) ? 0 : $post['totalAmount'];

    $result = XCNetbanxUtil::makeRequest($module_params, 'POST','/orders', $post);

    // Parse response
    $response = !empty($result) ? json_decode($result, true) : array();

    if (
        !empty($response['link'])
        && !empty($response['merchantRefNum'])
        && $response['merchantRefNum'] == $ref_num
    ) {
        foreach($response['link'] as $v) {
            if ($v['rel'] == 'hosted_payment') {
                $next_url = $v['uri'];
                break;
            }
        }

        // Redirect to NetBanx
        if (!$duplicate) {
            $cc_data = array(
                'ref' => $ref_full,
                'sessid' => $XCARTSESSID,
                'trstat' => 'GO|' . implode('|', $secure_oid),
            );
            func_array2insert('cc_pp3_data', $cc_data, true);

            // save data for callbacks and settle
            $cc_data = array(
                'ref' => $callback_key,
                'sessid' => $XCARTSESSID,
                'param1' => $response['id'],// order ID
                'param2' => serialize(array_intersect_key($post, array_flip(array('merchantRefNum', 'totalAmount')))), //For capture (Settle an Authorization)
            );
            func_array2insert('cc_pp3_data', $cc_data, true);
        }

        func_header_location($next_url);
    } else {
        // Return with error
        $bill_output['code'] = 2;
        $bill_output['billmes'] = 'Status: ' . $response['error']['code']
            . '|' . (!empty($response['merchantRefNum'])) . ($response['merchantRefNum'] == $ref_num) . '|'
            . ' (' . $response['error']['message'] . ')';

        require $xcart_dir . '/payment/payment_ccend.php';
    }
}//}}}
