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
 * "Alipay" payment module (credit card processor)
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Payment interface
 * @author     Michael Bugrov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v6 (xcart_4_7_7), 2017-01-24 09:29:34, cc_alipay.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!isset($REQUEST_METHOD)) {
    $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
}

define('XC_ALIPAY_PM', 'cc_alipay.php');

abstract class XCAlipayDefs { // {{{

    const WAIT_BUYER_PAY = 'WAIT_BUYER_PAY';
    const TRADE_FINISHED = 'TRADE_FINISHED';
    const TRADE_CLOSED   = 'TRADE_CLOSED';

    public static function getTransactionMessage($status) {
        $messages = array (
            self::WAIT_BUYER_PAY    => 'The buyer is expected to make the payment',
            self::TRADE_FINISHED    => 'The payment has been made, transaction closed',
            self::TRADE_CLOSED      => 'Transaction closed without payment',
        );

        if (!empty($messages[$status])) {
            return $messages[$status];
        }

        return 'Unknown status';
    }

} // }}}

if ($REQUEST_METHOD == 'POST' && !empty($_POST['sign'])) {

    require __DIR__.'/auth.php';

    x_load('payment');

    if (!func_is_active_payment(XC_ALIPAY_PM)) {
        exit;
    }

    if (defined('XC_ALIPAY_PM_DEBUG')) { // {{{

        $response = array(
            'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
            'GET' => $_GET,
            'POST' => $_POST,
        );

        func_pp_debug_log('alipay', 'R', $response);
    } // }}}

    x_session_register('cart');
    x_session_register('secure_oid');

    // get transaction UID
    $req_transaction_uuid = $out_trade_no;

    // get session by UID
    $bill_output['sessid'] = func_query_first_cell("SELECT sessid FROM $sql_tbl[cc_pp3_data] WHERE ref = '" . $req_transaction_uuid . "'");

    func_pm_load(XC_ALIPAY_PM);
    $module_params = func_get_pm_params(XC_ALIPAY_PM);

    $alipay_secret      = $module_params['param02'];
    $alipay_currency    = $module_params['param03'];

    // check signature
    $signature_result = func_cc_alipay_verify_signature($_POST, $alipay_secret);

    if ($signature_result) {
        $bill_output['code'] = ($trade_status == XCAlipayDefs::TRADE_FINISHED) ? 1 : 2;
        $bill_output['billmes'] = XCAlipayDefs::getTransactionMessage($trade_status) . ' (code ' . $trade_status . ").\n";
    } else {
        $bill_output['code'] = 2;
        $bill_output['billmes'] = 'Signature check failed';
    }

    if ($trade_no) {
        $bill_output['billmes'] .= 'Transaction no: ' . $trade_no . "\n";
    }

    $skey = $req_transaction_uuid;

    // Enable basic checks
    $payment_return = array (
        '_currency' => $alipay_currency, // configured currency

        'currency'  => $currency,   // check currency
        'total'     => $total_fee,  // check order total
    );

    require $xcart_dir.'/payment/payment_ccend.php';

} else { // {{{

    if (!defined('XCART_START')) { header('Location: ../'); die('Access denied'); }

    $alipay_order_prefix            = $module_params['param04'];

    $alipay_orders                  = $alipay_order_prefix.implode('-', $secure_oid);

    $alipay_partner_id              = $module_params['param01'];
    $alipay_secret_key              = $module_params['param02'];

    $alipay_transaction_uuid        = uniqid($alipay_orders . ':', XC_TIME);
    $alipay_reference_number        = implode('-', $secure_oid);

    $alipay_amount                  = $cart['total_cost'];
    $alipay_currency                = $module_params['param03'];

    $alipay_payment_info            = $config['Company']['company_name'] . ' - Order #' . substr($alipay_orders, 0, 256);

    $alipay_callback_url            = $current_location . '/payment/' . $module_params['processor'];

    $alipay_url = 'https://mapi.alipay.'.(($module_params['testmode'] == 'Y') ? 'net' : 'com') . '/gateway.do';

    if (!$duplicate) {
        db_query("REPLACE INTO $sql_tbl[cc_pp3_data] (ref, sessid, trstat) VALUES ('" . addslashes($alipay_transaction_uuid) . "', '" . $XCARTSESSID . "', 'GO|" . implode('|', $secure_oid) . "')");
    }

    $post = array(
        '_input_charset'        => 'utf-8',
        'service'               => 'create_forex_trade',
        'partner'               => $alipay_partner_id,
        'out_trade_no'          => $alipay_reference_number,
        'notify_url'            => $alipay_callback_url,
        'return_url'            => $alipay_callback_url,
        'subject'               => $alipay_payment_info,
        'order_gmt_create'      => func_cc_alipay_get_timestamp(),
        'sign_type'             => 'MD5', // signature type
    );

    if ($alipay_currency != 'RMB') {
        $post['currency']  = $alipay_currency;
        $post['total_fee'] = $alipay_amount;
    } else {
        $post['rmb_fee'] = $alipay_amount;
    }

    $post['sign'] = func_cc_alipay_generate_signature($post, $alipay_secret_key);

    ksort($post);

    if (defined('XC_ALIPAY_PM_DEBUG')) {
        func_pp_debug_log('alipay', 'I', array('Post URL' => $alipay_url, 'data' => $post));
    }

    func_create_payment_form($alipay_url, $post, 'Alipay');

    exit();
} // }}}
