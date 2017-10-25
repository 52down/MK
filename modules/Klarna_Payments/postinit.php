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
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v11 (xcart_4_7_7), 2017-01-23 20:12:10, postinit.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!defined('XCART_SESSION_START')) {
    header('Location: ../');
    die('Access denied');
}

if (func_klarna_postinit_from_session()) {
    return true;
}

if (!empty($logged_userid)) {
    if (!empty($cart['used_b_address']) && !empty($cart['products'])) {
        
        if (is_array($cart['used_b_address'])) {
            
            $config['Klarna_Payments']['user_country'] = strtolower($cart['used_b_address']['country']);

        } else {
            
            $config['Klarna_Payments']['user_country'] = strtolower(func_query_first_cell("SELECT country FROM $sql_tbl[address_book] WHERE id = '$cart[used_b_address]'"));
        }

    } else {

        $config['Klarna_Payments']['user_country'] = strtolower(func_query_first_cell("SELECT country FROM $sql_tbl[address_book] WHERE userid = '$logged_userid' AND default_b = 'Y'"));
    }
} else {
    $_anonymous_userinfo = func_get_anonymous_userinfo();

    if (isset($_anonymous_userinfo['address']['B'])) {

        $config['Klarna_Payments']['user_country'] = strtolower($_anonymous_userinfo['address']['B']['country']);
    }
}

if (empty($config['Klarna_Payments']['user_country'])) {
    
    $config['Klarna_Payments']['user_country'] = ($config['General']['default_country']) ? strtolower($config['General']['default_country']) : strtolower($config['Company']['location_country']);
}

list($k_country, $k_language, $k_currency) = func_klarna_get_location_codes($config['Klarna_Payments']['user_country']);
if ($k_currency != Klarna\XMLRPC\Currency::getCode($config['Klarna_Payments']['klarna_default_store_currency'])) {

    $currency_avail = func_klarna_check_currency_avail($k_currency);
    
    if ($currency_avail) {

        $customer_currency = func_mc_get_currency($k_currency);

        $payment_currency_rate = (isset($customer_currency['rate']) && $customer_currency['is_default'] < 1 && 0 < doubleval($customer_currency['rate']) ? $customer_currency['rate'] : 1);
        $config['Klarna_Payments']['invoice_payment_surcharge'] = price_format($config['Klarna_Payments']['invoice_payment_surcharge'] * $payment_currency_rate);        
    }
}
if (!empty($config['Klarna_Payments']['klarna_eid_' . $config['Klarna_Payments']['user_country']])) {
    $config['Klarna_Payments']['klarna_default_eid'] = $config['Klarna_Payments']['klarna_eid_' . $config['Klarna_Payments']['user_country']];
}

if (isset($config['Klarna_Payments']['klarna_active_payments_' . $config['Klarna_Payments']['user_country']]) && !in_array($config['Klarna_Payments']['klarna_active_payments_' . $config['Klarna_Payments']['user_country']], array('I', 'B'))) {
    $config['Klarna_Payments']['invoice_payment_enabled'] = false;
}

if (isset($config['Klarna_Payments']['klarna_active_payments_' . $config['Klarna_Payments']['user_country']]) && !in_array($config['Klarna_Payments']['klarna_active_payments_' . $config['Klarna_Payments']['user_country']], array('P', 'B'))) {
    $config['Klarna_Payments']['part_payment_enabled'] = false;
}

x_session_register('klarna_postinit_data');
$klarna_postinit_data = array();

$klarna_enabled  = $klarna_postinit_data['klarna_enabled'] = (AREA_TYPE == 'A' || func_klarna_check_avail());

$klarna_postinit_data['store_currency_symbol'] = func_klarna_set_currency_symbol_for_monthly_cost();

if (!$klarna_enabled) {

    unset($active_modules['Klarna_Payments']);
    $config['Klarna_Payments']['invoice_payment_enabled'] = $config['Klarna_Payments']['part_payment_enabled'] = false;
}

$klarna_postinit_data['Klarna_Payments'] = $config['Klarna_Payments'];
