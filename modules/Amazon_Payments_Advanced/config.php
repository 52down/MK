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
 * Module configuration
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    dd95a1e8f063200d8d76f64a881fef1ca66dd24a, v12 (xcart_4_7_8), 2017-03-01 19:26:09, config.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header('Location: ../../'); die('Access denied'); }

// uncomment this to write transactions logs into xcart/var/log
// define('AMAZON_PA_DEBUG', 1);

define('AMAZON_PAYMENTS_ADVANCED', 'Amazon_Payments_Advanced');

global $smarty, $config, $xcart_dir, $css_files;
$addons['Amazon_Payments_Advanced'] = true;

define('AMAZON_PA_PLATFORM_ID', 'A1PQFSSKP8TT2U');
define('AMAZON_PA_AUTH_PREFIX', (defined('AMAZON_PA_DEBUG_UNIQ_PREFIX') ? date('dm') : '') . 'auth_');
define('AMAZON_PA_CAPT_PREFIX', (defined('AMAZON_PA_DEBUG_UNIQ_PREFIX') ? date('dm') : '') . 'capture_');
define('AMAZON_PA_REFD_PREFIX', (defined('AMAZON_PA_DEBUG_UNIQ_PREFIX') ? date('dm') : '') . 'refund_');
define('XC_AMAZON_PA_WITH_ENTRY_POINTS', '4.7.7');

$css_files[AMAZON_PAYMENTS_ADVANCED][] = array();
$css_files[AMAZON_PAYMENTS_ADVANCED][] = array('altskin' => TRUE);

$_module_dir  = $xcart_dir . XC_DS . 'modules' . XC_DS . AMAZON_PAYMENTS_ADVANCED;

/*
 Load module functions
*/
if (!empty($include_func)) {

    require_once $_module_dir . XC_DS . 'func.php';

    if (!empty($include_init)) {
        func_amazon_pa_init();
    }
}
