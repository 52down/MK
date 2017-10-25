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
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v12 (xcart_4_7_7), 2017-01-23 20:12:10, config.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!defined('XCART_SESSION_START')) {
    header('Location: ../');
    die('Access denied');
}

define('KLARNA_CHECKOUT_PAGE', 0);
define('KLARNA_PRODUCT_PAGE', 1);
//define('XC_KLARNA_DEBUG', 1);

$css_files['Klarna_Payments'][] = array();
$addons['Klarna_Payments'] = true;

$var_dirs['klarna_pclass_dir'] = $xcart_dir . '/var';


$addons['Klarna_Payments'] = true;

$_klarna_data = func_query_hash("SELECT processor_file, active, surcharge FROM $sql_tbl[payment_methods] WHERE processor_file IN ('cc_klarna.php', 'cc_klarna_pp.php')", 'processor_file', false);
$config['Klarna_Payments']['invoice_payment_enabled'] = !empty($_klarna_data['cc_klarna.php']) && $_klarna_data['cc_klarna.php']['active'] == 'Y';
$config['Klarna_Payments']['part_payment_enabled'] = !empty($_klarna_data['cc_klarna_pp.php']) && $_klarna_data['cc_klarna_pp.php']['active'] == 'Y';
$config['Klarna_Payments']['invoice_payment_surcharge'] = !empty($_klarna_data['cc_klarna.php']) && $_klarna_data['cc_klarna.php']['surcharge'];
$_klarna_data = null;//memory clear

$config['Klarna_Payments']['klarna_supported_countries'] = array('se', 'de', 'no', 'dk', 'fi', 'nl');

$config['Klarna_Payments']['klarna_avail_countries'] = array();

foreach ($config['Klarna_Payments']['klarna_supported_countries'] as $c) {

    if ($config['Klarna_Payments']['klarna_active_' . $c] == 'Y') {
        $config['Klarna_Payments']['klarna_avail_countries'][] = $c;
    }
}

$_module_dir  = $xcart_dir . XC_DS . 'modules' . XC_DS . 'Klarna_Payments';
require_once $_module_dir . '/lib/autoload.php';

use Klarna\XMLRPC\Klarna;
use Klarna\XMLRPC\Country;
use Klarna\XMLRPC\Language;
use Klarna\XMLRPC\Currency;

/*
 Load module functions
*/
if (!empty($include_func)) {

    require_once $_module_dir . XC_DS . 'func.php';

    if (!empty($include_init)) {
        func_klarna_payments_init();
    }
}
