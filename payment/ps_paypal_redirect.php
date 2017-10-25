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
 * PayPal Payflow Pro - Transparent redirect (Partner Hosted with PCI Compliance)
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Payment interface
 * @author     Michael Bugrov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v5 (xcart_4_7_7), 2017-01-24 09:29:34, ps_paypal_redirect.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

/**
 * https://developer.paypal.com/docs/classic/payflow/integration-guide/#pci-compliance-without-hosted-pages---transparent-redirect
 */

$ccprocessor = 'ps_paypal_redirect.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !defined('XCART_START') ) {

    // Process response

    require 'ps_paypal_advanced.php';

} else {

    // Create checkout token

    if (!defined('XCART_START')) { header('Location: ../'); die('Access denied'); }

    x_load('payment', 'paypal', 'http');

    func_pm_load('ps_paypal_redirect');

    $module_params = func_get_pm_params($ccprocessor);

    $ret = func_ps_paypal_redirect_create_secure_token($module_params);

    if ($ret['RESULT'] == '0') {

        if (!$duplicate) {
            db_query("REPLACE INTO $sql_tbl[cc_pp3_data] (ref,sessid) VALUES ('" . addslashes($oid) . "','" . $XCARTSESSID . "')");
        }

        $params = array(
            'action' => func_ps_paypal_redirect_get_processor_url($module_params),
            'secureToken' => $ret['SECURETOKEN'],
            'secureTokenID' => $ret['SECURETOKENID']
        );

        if (defined('PAYPAL_DEBUG')) {
            func_pp_debug_log($ccprocessor_log_name, 'ajax', $params);
        }

        func_flush(json_encode($params));

        exit;

    } else {

        $bill_output['code'] = 2;
        $bill_output['billmes'] = '(' . $ret['RESULT'] . ') ' . $ret['RESPMSG'];

        require $xcart_dir . '/payment/payment_ccend.php';

    }
}
