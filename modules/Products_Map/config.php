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
 * @subpackage Products Map
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v21 (xcart_4_7_7), 2017-01-23 20:12:10, config.php, aim
 * @since      4.4.0
 * @see        ____file_see____
 */

if (!defined('XCART_START')) {
    header('Location: ../../');
    die('Access denied');
}

$addons['Products_Map'] = true;

// Db table added by the module
$sql_tbl['pmap_missed_symbols'] = XC_TBL_PREFIX . 'pmap_missed_symbols';

if (defined('PMAP_PAGE')) {

    // Additional css files
    $css_files['Products_Map'][] = array(// load module main.css
        'main_tpls' => array('pmap_customer'), // load module altskin/main.css for $main eq 'pmap_customer' only
    );

    // Page template filename
    $template_main['pmap_customer'] = 'modules/Products_Map/customer.tpl';

    // fake for loading js/check_quantity.js file on pmap page
    $smarty->assign('products', array(1));

}

if (
    isset($_POST['process_pmap'])
    && $_POST['process_pmap'] == 'Y'
    && (
        (
            $_SERVER['REQUEST_METHOD'] == 'POST'
            && isset($_POST['mode'])
            && $_POST['mode'] == 'catalog_gen'
        ) || (
            $_SERVER['REQUEST_METHOD'] == 'GET'
            && isset($_POST['mode'])
            && $_POST['mode'] == 'continue'
        )
    )
) {
    $additional_hc_data[] = array(
        'generation_script' => $xcart_dir . '/modules/Products_Map/html_catalog.php',
        'page_url'          => 'products_map.php',
        'page_params'       => 'symb=',
        'name_func'         => 'pmap',
        'name_func_params'  => array('Products-Map-%s-p-%s.html'),
        'src_func'          => 'pmap_process_page',
    );
}

$_module_dir  = $xcart_dir . XC_DS . 'modules' . XC_DS . 'Products_Map';
/*
 Load module functions
*/
if (!empty($include_func)) {
    require_once $_module_dir . XC_DS . 'func.php';
}

?>
