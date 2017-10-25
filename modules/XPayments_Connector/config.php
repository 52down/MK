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
 * @version    fdf4c40775b539a54bc228e488550b992e275a43, v37 (xcart_4_7_8), 2017-05-31 11:32:26, config.php, Ildar
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header('Location: ../../'); die('Access denied'); }

global $config, $smarty, $xcart_dir, $xpc_crypted_map_fields, $sql_tbl;
$addons['XPayments_Connector'] = true;

// --------------------
// Module inner version
// v3.1.0.0
// --------------------

// Synchronize with $bf_crypted_tables from include/blowfish.php
$xpc_crypted_map_fields = array(
    'store_id'              => 'xpc_shopping_cart_id',
    'previous_store_id'     => 'xpc_previous_cart_id',
    'url'                   => 'xpc_xpayments_url',
    'public_key'            => 'xpc_public_key',
    'private_key'           => 'xpc_private_key',
    'private_key_password'  => 'xpc_private_key_password',
);

// Saved cards list
$sql_tbl['xpc_saved_cards'] = XC_TBL_PREFIX . 'xpc_saved_cards';
// Old-style data migration indicator
$sql_tbl['xpc_saved_cards_migrated'] = XC_TBL_PREFIX . 'xpc_saved_cards_migrated';

$_module_dir  = $xcart_dir . XC_DS . 'modules' . XC_DS . 'XPayments_Connector';
/*
 Load module functions
*/

if (!empty($include_func))
    require_once $_module_dir . XC_DS . 'func.php';

define('XPC_IFRAME_DO_NOTHING',      0);
define('XPC_IFRAME_CHANGE_METHOD',   1);
define('XPC_IFRAME_CLEAR_INIT_DATA', 2);
define('XPC_IFRAME_ALERT',           3);

if (!defined('XC_TIME')) {
    define('XC_TIME', time());
}

// Add modules/XPayments_Connector/main.css
$css_files['XPayments_Connector'][] = array();
$css_files['XPayments_Connector'][] = array('admin' => TRUE);

?>
