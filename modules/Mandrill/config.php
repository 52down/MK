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
 * @author     Ildar Amankulov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    1a6cd45805022f5fdf03361c73b08471854193f4, v1 (xcart_4_7_8), 2017-04-18 15:01:06, config.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

//define('XC_DEBUG_PHPMAILER', 1);

if (!defined('XCART_START')) { header('Location: ../../'); die('Access denied'); }
global $smarty, $config, $active_modules;

$addons['Mandrill'] = true;

if (
    $config['Mandrill']['mandrill_enable_mailer'] != 'Y'
    || empty($config['Mandrill']['mandrill_apikey'])
    || empty($config['Mandrill']['mandrill_smtp_username'])
) {
    if (func_constant('AREA_TYPE') == 'C') {
        // Disable module for customer area
        unset($active_modules['Mandrill']);

        if (!empty($smarty)) {
            $smarty->assign('active_modules', $active_modules);
        }

        return;
    }
} else {
    $mandrill_is_configured = true;
}

/*
 Load module functions
*/
if (!empty($include_func)) {
    $_module_dir = $xcart_dir . XC_DS . 'modules' . XC_DS . 'Mandrill';
    require_once $_module_dir . XC_DS . 'func.php';
    if (!empty($include_init)) {
        func_mandrill_init($mandrill_is_configured);
    }
}
