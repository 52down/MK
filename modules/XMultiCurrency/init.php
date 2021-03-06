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
 * Module initialization
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v13 (xcart_4_7_7), 2017-01-24 09:29:34, init.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header('Location: ../../'); die('Access denied'); }

// Add cron task
$cron_tasks[] = array(
    'function' => 'x_mc_periodic_rates_update',
    'include'  => $xcart_dir . '/modules/XMultiCurrency/func.php',
);

// Reset alter currency symbol for customer area
if (!defined('AREA_TYPE') || constant('AREA_TYPE') == 'C') {
    $config['General']['alter_currency_symbol'] = NULL;

    func_mc_switch_number_format();

    if (!empty($store_currency)) {
        $mc_selected_currency = func_mc_get_currency($store_currency);

        $config['XMultiCurrency']['selected_currency_format'] = (empty($mc_selected_currency['format']))
            ? $config['General']['currency_format'] : $mc_selected_currency['format'];
        $config['XMultiCurrency']['selected_currency_symbol'] = (empty($mc_selected_currency['symbol']))
            ? $store_currency : $mc_selected_currency['symbol'];

        $smarty->assign('config', $config);
    }
}

// Define cookies this module set up
$config['EU_Cookie_Law']['functional_cookies'][] = 'store_currency';
$config['EU_Cookie_Law']['functional_cookies'][] = 'store_country';

$smarty->assign('x_mc_hide_currency_selector', (count(func_mc_get_currencies(TRUE)) == 1) ? TRUE : FALSE);

// Register Smarty-prefilters to patch templates
$smarty->register_prefilter('x_mc_replace_languages_block');
$smarty->register_prefilter('x_mc_replace_order_total_block');
$smarty->register_prefilter('x_mc_replace_cart_subtotal_block');
$smarty->register_prefilter('x_mc_remove_currency_options');


// Re-register Smarty-functions {currency} and {alter_currency}
$smarty->unregister_function('currency');
$smarty->unregister_function('alter_currency');

$smarty->register_function('currency', 'x_mc_currency');
$smarty->register_function('alter_currency', 'x_mc_alter_currency');


require_once $xcart_dir . '/modules/XMultiCurrency/countries.php';

$mcAvailableLanguages = NULL;
