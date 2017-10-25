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
 * PayPal IPN processing module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Payment interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    8b4be33bd0486f61bf66cd46c972d855dd796d76, v17 (xcart_4_7_8), 2017-04-06 11:56:38, ps_paypal_ipn.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

// "custom" parameter in POSTed data contains "order_secureid"

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['payment_type']) && isset($_POST['custom'])) {

    require_once __DIR__.'/auth.php';

    if (defined('PAYPAL_DEBUG')) {
        func_pp_debug_log('paypal_ipn', 'C', print_r($_GET, true) . print_r($_POST, true));
    }

    if ($config['paypal_solution'] == 'uk') {
        exit;
    }

    if (!empty($notify_from)) {

        switch ($notify_from) {
            case 'pro':
                $_processor = 'ps_paypal_pro.php';
                break;

            case 'pro_hosted':
                $_processor = 'ps_paypal_pro_hosted.php';
                break;
        }

    } else {

        $_processor = 'ps_paypal.php';

    }

    x_load('http', 'paypal', 'payment');

    if (!func_is_active_payment($_processor)) {
        exit;
    }

    if (isset($_POST['mc_gross'])) {
        $payment_return = array(
            'total' => $_POST['mc_gross'],
            'possible_reason' => 'http://help.x-cart.com/index.php?title=X-Cart:PayPal#Troubleshooting',
        );
    }

    $skey = $_POST['custom'];
    $bill_output['sessid'] = func_query_first_cell("SELECT sessid FROM $sql_tbl[cc_pp3_data] WHERE ref='$skey'");

    $module_params = func_get_pm_params($_processor);
    $cur = func_paypal_get_currency($module_params);

    $testmode = func_query_first_cell("SELECT testmode FROM $sql_tbl[ccprocessors] WHERE processor='$_processor'");

    $pp_host = ($testmode == 'N' ? 'ipnpb.paypal.com' : 'ipnpb.sandbox.paypal.com');

    $https_success = true;
    $https_msg = '';

    if ($config['paypal_solution'] != 'uk') {
        // do PayPal (IPN) background request...
        $post = array();

        foreach ($_POST as $key => $val) {
            $post[] = $key . '=' . func_stripslashes($val);
        }

        list($a, $result) = func_https_request('POST',"https://$pp_host:443/cgi-bin/webscr?cmd=_notify-validate", $post,
            '&', // join
            '', // cookie
            'application/x-www-form-urlencoded',
            '', // referer
            '', // cert
            '', // kcert
            array('User-Agent' => 'XCart4')//Headers
        );

        $is_verified = preg_match('/VERIFIED/i', $result);

        if (defined('PAYPAL_DEBUG')) {
            func_pp_debug_log('paypal_ipn', 'validate', print_r($post, true) . print_r($result, true));
        }

        if (empty($a)) {
            // HTTPS client error
            $https_success = false;
            $https_msg = $result;
        }

    } else {
        $is_verified = true;
    }

    if (!$https_success) {
        $bill_message = "Queued: HTTPS client error ($https_msg).";
        $bill_output['code'] = 3;
    } elseif (!$is_verified) {
        $bill_output['code'] = 2;
        $bill_message = 'Declined (invalid request)';

    } elseif (
            (strcasecmp($payment_status,'Completed') == 0)
            || (strcasecmp($payment_status, 'Pending') == 0)
    ) {

        $bill_output['code'] = 2;
        if (strcasecmp($payment_status, 'Pending') == 0) {
            $bill_message = 'Queued';
            $bill_output['code'] = 3;

            // It is pre-authorization response
            if (!empty($transaction_entity) && $transaction_entity == 'auth') {
                $bill_output['is_preauth'] = true;
                if ($_processor == 'ps_paypal.php') {
                    $extra_order_data = array(
                        'paypal_type' => 'USSTD',
                        'paypal_txnid' => $txn_id,
                        'capture_status' => 'A'
                    );

                } else if ($_processor == 'ps_paypal_pro.php') {
                    exit;
                }
            }

        } elseif (
                (strcasecmp($payment_status, 'Completed') == 0)
                && !empty($auth_id)
                && ($orderids = func_paypal_get_capture_orderid($auth_id))
        ) {

            // Order(s) captured on PayPal backend
            $total = func_query_first_cell("SELECT SUM(total) FROM $sql_tbl[orders] WHERE orderid IN ('" . implode("','", $orderids) . "')");
            if ($cur == $_POST['mc_currency'] && $total == $_POST['mc_gross']) {
                x_load('order');
                func_order_process_capture($orderids);
            }
            exit;

        } elseif ($cur != $_POST['mc_currency']) {
            $bill_message = "Declined: Payment amount mismatch: wrong order currency ( $cur <> $_POST[mc_currency] ).";

        } elseif ($is_verified) {
            $bill_output['code'] = 1;
            $bill_message = 'Accepted';

        } else {
            $bill_message = "Declined (processor error)";
        }

        $_oids = explode('|', func_query_first_cell("SELECT trstat FROM $sql_tbl[cc_pp3_data] WHERE ref='$skey'"));
        array_shift($_oids);
        if (!empty($_oids)) {
            foreach($_oids as $_oid) {
                func_paypal_update_order($_oid);
            }
        }

    } elseif (strcasecmp($payment_status, 'Voided') == 0) {

        // Order(s) voided on PayPal backend
        $orderids = func_paypal_get_capture_orderid($auth_id);
        x_load('order');
        func_order_process_void($orderids);
        exit;

    } elseif (strcasecmp($payment_status, 'Refunded') == 0) {
        // Register Refund transaction
        if (!empty($parent_txn_id)) {
            func_paypal_reg_refund($parent_txn_id, $txn_id);
        }

        exit;

    } elseif (strcasecmp($payment_status, 'Reversed') == 0) {
        // Register Reverse transaction
        if (!empty($parent_txn_id)) {
            func_paypal_reg_reversal($parent_txn_id, $txn_id);
        }

        exit;

    } elseif (strcasecmp($payment_status, 'Canceled_Reversal') == 0) {
        // Register Cancel Reversal transaction
        if (!empty($parent_txn_id)) {
            func_paypal_reg_cancel_reversal($parent_txn_id, $txn_id);
        }

        exit;

    } else {
        $bill_message = 'Declined';
        $bill_output['code'] = 2;
    }

    $bill_output['billmes'] = "$bill_message Status: $payment_status (TransID #$txn_id)";
    if (!empty($pending_reason)) {
        $bill_output['billmes'] .= " Reason: $pending_reason";
    }

    if (empty($ipn_skip_payment_ccmid)) {

        if ($_processor == 'ps_paypal_pro_hosted.php' && !empty($txn_id)) {

            if (empty($extra_order_data)) {
                $extra_order_data = array();
            }

            $extra_order_data['paypal_type'] = 'PH';
            $extra_order_data['paypal_txnid'] = $txn_id;
            $extra_order_data['capture_status'] = (!empty($bill_output['is_preauth'])) ? 'A' : '';

        }

        require $xcart_dir . '/payment/payment_ccmid.php';
    }

} else {

    header('Location: ../');
    die('Access denied');

}
