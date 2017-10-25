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
 * Configuration script
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    1b7147749995cd4c99a6e6124f48ccf3aa34cb00, v24 (xcart_4_7_8), 2017-03-27 19:44:19, config.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

//define('XC_MAILCHIMP_DEBUG', 1);

if (!defined('XCART_START')) {
    header('Location: ../../');
    die('Access denied');
}
global $smarty, $config, $active_modules;
$addons['Adv_Mailchimp_Subscription'] = true;

// Additional css files
$css_files['Adv_Mailchimp_Subscription'][] = array(// load module main.css
    'main_tpls' => array('mc_news_archive'), // load module altskin/main.css for $main eq 'mc_news_archive' only
);

$sql_tbl['mailchimp_abandoned_carts'] = XC_TBL_PREFIX . 'mailchimp_abandoned_carts';
$sql_tbl['mailchimp_campaigns_stores'] = XC_TBL_PREFIX . 'mailchimp_campaigns_stores';
$sql_tbl['mailchimp_default_stores'] = XC_TBL_PREFIX . 'mailchimp_default_stores';
$sql_tbl['mailchimp_newslists'] = XC_TBL_PREFIX . 'mailchimp_newslists';
$sql_tbl['mailchimp_product_batches'] = XC_TBL_PREFIX . 'mailchimp_product_batches';
$sql_tbl['mailchimp_products'] = XC_TBL_PREFIX . 'mailchimp_products';

// Define cookies this module set up
$config['EU_Cookie_Law']['functional_cookies'][] = 'mailchimp_campaignid';

$_module_dir  = $xcart_dir . XC_DS . 'modules' . XC_DS . 'Adv_Mailchimp_Subscription';

/*
 Load module functions
*/

if (
    empty($config['Adv_Mailchimp_Subscription']['adv_mailchimp_apikey'])
    && func_constant('AREA_TYPE') == 'C'
) {
    // Disable module for customer area
    unset($active_modules['Adv_Mailchimp_Subscription']);

    if (!empty($smarty)) {
        $smarty->assign('active_modules', $active_modules);
    }

    return;
}

if (!empty($include_func)) {
    require_once $_module_dir . XC_DS . 'func.php';
    if (!empty($include_init)) {
        func_adv_mailchimp_init();
    }
}
