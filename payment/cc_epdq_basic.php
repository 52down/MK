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
 * "ePDQ basic" payment integration module (credit card processor)
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Payment interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v8 (xcart_4_7_7), 2017-01-24 09:29:34, cc_epdq_basic.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!defined('XCART_START')) { header('Location: ../'); die('Access denied'); }

// Prepare request and edirect to the gateway server

$epdqb_orderid = $module_params['param05'] . join('-', $secure_oid);

if (!$duplicate) {
    db_query("REPLACE INTO $sql_tbl[cc_pp3_data] (ref, sessid, trstat) VALUES ('" . addslashes($epdqb_orderid) . "','" . $XCARTSESSID . "','GO|" . implode('|', $secure_oid) . "')");
}

// Important: all parameter names should be in UPPERCASE (to avoid any case confusion)

$epdqb_fields = array(
    // Affiliation name in system
    'PSPID'         => $module_params['param01'],
    // Order number
    'ORDERID'       => $epdqb_orderid,
    // Amount to be paid
    // MULTIPLIED BY 100 since the format of the amount must not contain any decimals or other separators
    'AMOUNT'        => $cart['total_cost'] * 100,
    // ISO alpha code
    'CURRENCY'      => $module_params['param04'],
    // en_US, nl_NL, fr_FR, …
    'LANGUAGE'      => $all_languages[$shop_language]['code'] . '_' . $all_languages[$shop_language]['country_code'],
    // Merchant’s homepage URL
    'HOMEURL'       => $current_location,
    // Customer name
    'CN'            => $userinfo['b_firstname'] . ' ' . $userinfo['b_lastname'],
    'EMAIL'         => $userinfo['email'],
    'OWNERZIP'      => $userinfo['b_zipcode'],
    'OWNERADDRESS'  => $userinfo['b_address'],
    'OWNERADDRESS2' => $userinfo['b_address_2'],
    'OWNERCTY'      => $userinfo['b_country'],
    'OWNERTOWN'     => $userinfo['b_city'],
    'OWNERTELNO'    => $userinfo['phone']
);

$epdqb_fields = array_merge($epdqb_fields, array(
    'ACCEPTURL' => $current_location . '/payment/cc_epdq_basic_result.php',
    'DECLINEURL' => $current_location . '/payment/cc_epdq_basic_result.php',
    'EXCEPTIONURL' => $current_location . '/payment/cc_epdq_basic_result.php?mode=exception',
    'CANCELURL' => $current_location . '/payment/cc_epdq_basic_result.php?mode=cancel')
);

func_pm_load('cc_epdq_basic.php');

// Sign in request using SHA hashing algorithm
$epdqb_fields['SHASIGN'] = func_cc_epdq_basic_sign_request($epdqb_fields, $module_params['param02']);

if (defined('EPDQ_BASIC_DEBUG')) {
    func_pp_debug_log('epdq_basic', 'I', print_r($epdqb_fields, true));
}

$epdq_basic_processor_url = 'https://payments.epdq.co.uk/ncol/prod/orderstandard.asp';

if ($module_params['testmode'] == 'Y') {
    $epdq_basic_processor_url = 'https://mdepayments.epdq.co.uk/ncol/test/orderstandard.asp';
}

func_create_payment_form($epdq_basic_processor_url, $epdqb_fields, "ePDQ basic");

exit;

?>
