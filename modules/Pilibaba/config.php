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
|                                                                             |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

/**
 * Module configuration
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ildar Amankulov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v8 (xcart_4_7_7), 2017-01-23 20:12:10, config.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined("XCART_SESSION_START") ) { header("Location: ../"); die("Access denied"); }

//define('XC_PILIBABA_DEBUG', 1);
define('XC_PILIBABA_WITH_ENTRY_POINTS', '4.7.7');

global $config, $smarty;
$addons['Pilibaba'] = true;


//$css_files['Pilibaba'][] = array();
$sql_tbl['pilibaba_data'] = XC_TBL_PREFIX . 'pilibaba_data';
$sql_tbl['pilibaba_service_orders'] = XC_TBL_PREFIX . 'pilibaba_service_orders';

// check configuration compability issues
if (func_constant('AREA_TYPE') == 'C') {
    if (
        empty($config['Pilibaba']['pilibaba_merchant_no'])
        || empty($config['Pilibaba']['pilibaba_secret_key'])
    ) {
        // disable module for customers/ TODO change order load
        unset($active_modules['Pilibaba']);
        $smarty->assign('active_modules', $active_modules);

        return;
    } else {
        $pilibaba_enabled = true;
        $smarty->assign('pilibaba_enabled', $pilibaba_enabled);
    }
}


/*
 Load module functions
*/
if (!empty($include_func)) {
    $_module_dir  = $xcart_dir . XC_DS . 'modules' . XC_DS . 'Pilibaba';

    require_once $_module_dir . XC_DS . 'func.php';

    if (!empty($include_init)) {
        func_pilibaba_checkout_init();
    }
}

?>
