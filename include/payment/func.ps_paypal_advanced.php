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
 * Functions for PayPal Advanced and Payflow Link payment methods
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v32 (xcart_4_7_7), 2017-01-24 09:29:34, func.ps_paypal_advanced.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!defined('XCART_START')) { //{{{
    header('Location: ../../');
    die('Access denied');
} //}}}

x_load('http', 'payment');

/**
 * Returns array with variables from name-value pairs string
 */
function func_payflow_parse_str($str) { //{{{

    $workstr = $str;
    $out = array();

    while(strlen($workstr) > 0) {
        $loc = strpos($workstr, '=');
        if($loc === FALSE) {
            // Truncate the rest of the string, it's not valid
            $workstr = "";
            continue;
        }

        $substr = substr($workstr, 0, $loc);
        $workstr = substr($workstr, $loc + 1); // "+1" because we need to get rid of the "="

        $matches = array();

        if(preg_match('/^(\w+)\[(\d+)]$/', $substr, $matches)) {
            // This one has a length tag with it.  Read the number of characters

            // specified by $matches[2].
            $count = intval($matches[2]);

            $out[$matches[1]] = substr($workstr, 0, $count);
            $workstr = substr($workstr, $count + 1); // "+1" because we need to get rid of the "&"
        } else {
            // Read up to the next "&"
            $count = strpos($workstr, '&');
            if($count === FALSE) { // No more "&"'s, read up to the end of the string
                $out[$substr] = $workstr;
                $workstr = "";
            } else {
                $out[$substr] = substr($workstr, 0, $count);
                $workstr = substr($workstr, $count + 1); // "+1" because we need to get rid of the "&"
            }
        }
    }

    return $out;
} //}}}

function func_payflow_get_processor_name($module_params) { //{{{
    $processor_name = preg_replace('/ps_([a-z_]+)\\.php/', '$1', $module_params['processor']);

    return !empty($processor_name)
        ? $processor_name
        : 'paypal_advanced';
} //}}}

function func_payflow_get_processor_address($module_params) { //{{{
    $function_name = 'func_ps_' . func_payflow_get_processor_name($module_params) . '_get_processor_url';

    return !function_exists($function_name)
        ? 'https://' . (
            $module_params['testmode']  == 'Y'
            ? 'pilot-payflowpro.paypal.com'
            : 'payflowpro.paypal.com'
        )
        : $function_name($module_params);
} //}}}

function func_payflow_call($post, $module_params) { //{{{

    $post['VENDOR']       = $module_params['param01'];
    $post['PARTNER']      = $module_params['param02'];
    $post['USER']         = $module_params['param04'];
    $post['PWD']          = $module_params['param05'];
    $post['BUTTONSOURCE'] = 'Qualiteam_Cart_XCart_PHS';

    return func_payflow_call_raw($post, $module_params);

} //}}}

function func_payflow_call_raw($post, $module_params) { //{{{

    $_apost = array();

    if (!empty($post)){
        foreach($post as $index => $value) {
            $_apost[] = $index . '[' . strlen($value) . ']=' . $value;
        }
    }

    $_post = implode('&', $_apost);

    $url = func_payflow_get_processor_address($module_params);
    $log_prefix = func_payflow_get_processor_name($module_params);

    list($a, $return) = func_https_request('POST', $url, $_post);

    $ret = func_payflow_parse_str($return);

    if (defined('PAYPAL_DEBUG')) {
        func_pp_debug_log($log_prefix, 'request', print_r($post, true) . "\n Testmode: $module_params[testmode]");
        func_pp_debug_log($log_prefix, 'response', print_r($ret, true));
    }

    return $ret;
} //}}}

/**
 * Common function to perform different types of Advanced/PayFlow Link transactions
 */
 function func_ps_paypal_advanced_do($order, $transaction_type, $amount = 0) { //{{{

    global $xcart_dir, $module_params;

    if ($order['order']['paypal']['method'] == 'AD') {
        $module_params = func_get_pm_params('ps_paypal_advanced.php');
    } elseif ($order['order']['paypal']['method'] == 'PF') {
        $module_params = func_get_pm_params('ps_paypal_payflowlink.php');
    }

    $post = array(
        'TRXTYPE' => $transaction_type,
        'ORIGID' => $order['order']['extra']['pnref'],
    );

    if ($amount) {
        $post['AMT'] = $amount;
    }

    $res = func_payflow_call($post, $module_params);

    if ($res['RESULT'] == '0') {
        $status = true;
        $err_msg = 'TRXTYPE:' . $transaction_type . '; RESULT: ' . $res['RESULT'] . '; RESPMSG: ' . $res['RESPMSG'] . '; PNREF: ' . $res['PNREF'];
    } else {
        $status = false;
        $err_msg = 'TRXTYPE:' . $transaction_type . 'RESULT: ' . $res['RESULT'] . '; RESPMSG: ' . $res['RESPMSG'] . '; PNREF: ' . $res['PNREF'];
    }

    $extra = array(
        'name' => 'pnref',
        'value' => $res['PNREF'],
    );

    return array($status, $err_msg, $extra);

} //}}}

function func_ps_paypal_advanced_do_capture($order) { //{{{

    $return = func_ps_paypal_advanced_do($order, 'D');
    if ($return[0] == true && !empty($return[2])) {

        if (!empty($return[2])) {
            func_array2insert(
                'order_extras',
                array(
                    'orderid' => $order['order']['orderid'],
                    'khash' => $return[2]['name'],
                    'value' => $return[2]['value']
                ),
                true
            );
        }
    }

    return $return;

} //}}}

function func_ps_paypal_advanced_do_void($order) { //{{{

    return func_ps_paypal_advanced_do($order, 'V');

} //}}}

function func_ps_paypal_advanced_do_refund($order, $amount = 0) { //{{{

    $return = func_ps_paypal_advanced_do($order, 'C', $amount);
    if ($return[0] == true) {
        if (empty($order['order']['extra']['paypal'])) {
            $order['order']['extra']['paypal'] = array();
            $order['order']['extra']['paypal']['subtrans'] = array();
        }


        $order['order']['extra']['paypal']['subtrans'][$return[2]['value']] = array(
            'type' => 'Refunded',
            'amount' => $amount,
            'date' => XC_TIME,
            'note' => $return[1],
        );

        func_array2update(
            'orders',
            array(
                'extra' => addslashes(serialize($order['order']['extra'])),
            ),
            "orderid = '" . $order['order']['orderid'] . "'"
        );
    }

    return $return;

} //}}}

function func_ps_paypal_advanced_get_refund_mode($paymentid, $orderid) { //{{{

    return 'P';

} //}}}

?>
