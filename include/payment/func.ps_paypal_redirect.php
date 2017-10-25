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
 * Functions for PayPal Payflow Pro - Transparent redirect (Partner Hosted with PCI Compliance)
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Michael Bugrov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v6 (xcart_4_7_7), 2017-01-24 09:29:34, func.ps_paypal_redirect.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

func_pm_load('ps_paypal_advanced');

function func_ps_paypal_redirect_get_processor_url($module_params)
{ // {{{
    return 'https://' . ($module_params['testmode'] == 'Y' ? 'pilot-payflowlink.paypal.com' : 'payflowlink.paypal.com');
} // }}}

function func_ps_paypal_redirect_create_secure_token($module_params)
{ // {{{
    global $secure_oid, $cart, $userinfo, $current_location, $oid;

    $ccprocessor = 'ps_paypal_redirect.php';

    $oid = $module_params['param06'] . join('-', $secure_oid);

    $pp_currency = func_paypal_get_currency($module_params);
    $pp_total = func_paypal_convert_to_BasicAmountType($cart['total_cost'], $pp_currency);

    $post = array(
        'TRXTYPE'           => $module_params['use_preauth'] == 'Y' ? 'A' : 'S',
        'AMT'               => $pp_total,
        'INVNUM'            => $oid,
        'CURRENCY'          => $module_params['param03'],
        'CREATESECURETOKEN' => 'Y',
        'SECURETOKENID'     => $oid,
        'DISABLERECEIPT'    => 'TRUE',
        'RETURNURL'         => $current_location . '/payment/' . $ccprocessor,
        'CANCELURL'         => $current_location . '/payment/' . $ccprocessor,
        'ERRORURL'          => $current_location . '/payment/' . $ccprocessor,
        'SILENTPOSTURL'     => $current_location . '/payment/' . $ccprocessor,
        'URLMETHOD'         => 'POST',
        'ADDROVERRIDE'      => '1',

        'SILENTTRAN'        => 'TRUE',

        'EMAIL' => $userinfo['email'],
    );

    $profile = func_paypal_get_userinfo_payflow($userinfo, array('B', 'S'), TRUE);

    if (!empty($profile)) {
        $post = array_merge($post, $profile);
    }

    $line_items = func_paypal_get_line_items_payflow($cart, $pp_total, $pp_currency);

    if (!empty($line_items)) {

        $post = array_merge($post, $line_items);

    } else {
        // Or just use whole order as LineItem

        $post['L_NAME0'] = 'Order #' . join(', #', $secure_oid);
        $post['L_QTY0'] = 1;
        $post['L_COST0'] = $pp_total;
        $post['ITEMAMT'] = $pp_total;

    }

    return func_payflow_call($post, $module_params);
} // }}}
