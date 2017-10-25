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
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v18 (xcart_4_7_7), 2017-01-23 20:12:10, config.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header('Location: ../../'); die('Access denied'); }

global $config, $XCART_SESSION_NAME, $xcart_dir, $sql_tbl;
$addons['EU_Cookie_Law'] = true;

$sql_tbl['customer_eu_cookie_accesses'] = XC_TBL_PREFIX . 'customer_eu_cookie_accesses';

settype($config['EU_Cookie_Law']['strictly_necessary_cookies'], 'array');
$config['EU_Cookie_Law']['strictly_necessary_cookies'] = 
array_merge($config['EU_Cookie_Law']['strictly_necessary_cookies'],
    array(
        $XCART_SESSION_NAME,
        'eucl_cookie_access',
    )
);


settype($config['EU_Cookie_Law']['functional_cookies'], 'array');

$config['EU_Cookie_Law']['functional_cookies'] = array_merge($config['EU_Cookie_Law']['functional_cookies'],
    array(
        $XCART_SESSION_NAME . 'C_remember',
        $XCART_SESSION_NAME . 'B_remember',
        $XCART_SESSION_NAME . 'A_remember',
        $XCART_SESSION_NAME . 'P_remember',
        'GreetingCookie',
        'RefererCookie',
        'access_key',
        'adv_campaignid',
        'adv_campaignid_time',
        'partner',
        'partner_clickid',
        'partner_time',
        'popup_product_1st_column',
        'store_language',
    )
);


$css_files['EU_Cookie_Law'][] = array();
$css_files['EU_Cookie_Law'][] = array('altskin' => TRUE);

$_module_dir  = $xcart_dir . XC_DS . 'modules' . XC_DS . 'EU_Cookie_Law';
/*
 Load module functions
*/
if (!empty($include_func))
    require_once $_module_dir . XC_DS . 'func.php';

?>
