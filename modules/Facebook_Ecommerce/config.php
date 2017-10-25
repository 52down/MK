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
 * @author     Ildar Amankulov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    6c63806b2654732df812bfe1dd496de111c2a9d3, v2 (xcart_4_7_8), 2017-05-23 12:51:22, config.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

global $config, $smarty, $addons, $sql_tbl, $module_namespaces_g, $export_product_extrafields_headers_g;
$addons['Facebook_Ecommerce'] = true;

//$css_files['Facebook_Ecommerce'][] = array('admin' => true); // admin.css

$sql_tbl['facebook_ecomm_feed_files'] = XC_TBL_PREFIX . 'facebook_ecomm_feed_files';
$sql_tbl['facebook_ecomm_marked_products'] = XC_TBL_PREFIX . 'facebook_ecomm_marked_products';
$sql_tbl['facebook_ecomm_pending_export'] = XC_TBL_PREFIX . 'facebook_ecomm_pending_export';

$module_namespaces_g['Facebook_Ecommerce'] = 'XC\FacebookEcommerce\Backend\\';

/*
* Add a new value below to use the extra_field with the respective service_name for froogle export
*/
$export_product_extrafields_headers_g = empty($export_product_extrafields_headers_g) ? array() : $export_product_extrafields_headers_g;//{{{
$export_product_extrafields_headers_g['Facebook_Ecommerce'] = array(
    /* Google's category of item */
    "google_product_category",
    /* Unique Product Identifiers */
    "gtin",
    "mpn",
    /* Submit the 'identifier exists' attribute with a value of FALSE when the item does not have unique GTIN/MPN/brand */
    "identifier_exists",
    "upc",
    "ean",
    "jan",
    /* Shared by Apparel and Variants */
    "color",
    "size",
    /* Variant Products */
    "material",
    "pattern",
    /* Apparel Products */
    "gender",
    "age_group",
    "brand",
    /* Custom attributes */
);//}}}

if (empty($config['Facebook_Ecommerce']['facebook_ecomm_pixel_id'])) {
    if (func_constant('AREA_TYPE') == 'C') {
        // Disable module for customer area
        unset($active_modules['Facebook_Ecommerce']);

        if (!empty($smarty)) {
            $smarty->assign('active_modules', $active_modules);
        }

        return;
    }
} else {
    $facebook_ecomm_is_configured = true;
}

/*
 Load module functions
*/
if (!empty($include_func) || !empty($include_init)) {
    func_fb_ecomm_init();
}

/*
* Functions definitions
*/
function func_fb_ecomm_init() {//{{{
    global $PHP_SELF, $cron_tasks, $xcart_dir;

    // Load classes on demand via autoloader for backend
    func_constant('AREA_TYPE') != 'C' && spl_autoload_register('func_fb_ecomm_backend_autoloader');

    //Register smarty filters
    if (basename($PHP_SELF) == 'product_modify.php') {
        \XC\FacebookEcommerce\Backend\ProductModifyPage::registerSmartyFunc();
    }

    // Register module config update handler
    if (
        defined('ADMIN_CONFIGURATION_CONTROLLER')
        && !empty($_GET['option']) && $_GET['option'] == 'Facebook_Ecommerce'
    ) {
        func_add_event_listener('module.config.update', '\XC\Module\Backend\RequestProcessor::processRequest');
    }

    // register cron jobs for cli mode
    $cron_tasks[] = array(
        'function' => 'func_facebook_ecomm_update_all_feeds',
        'include'  => $xcart_dir . '/modules/Facebook_Ecommerce/cron.php',
    );

}//}}}

function func_fb_ecomm_backend_autoloader($class_name) {//{{{
    global $xcart_dir;
    static $call_include_counter = 0;

    $match_array = array(
        'XC\FacebookEcommerce\Backend\ProductModifyPage' => 'modules/Facebook_Ecommerce/backend/product_modify.php',
        'XC\Module\Backend\RequestProcessor' => 'include/classes/class.ModuleBackendRequestProcessor.php',
        'XCStringUtils' => 'include/classes/class.XCStringUtils.php',
        'csvFileExporter' => 'include/classes/class.csvFileExporter.php',
        'FacebookEcommerce' => 'modules/Facebook_Ecommerce/backend/classes.php',
    );

    if ($call_include_counter >= count($match_array)) {
        spl_autoload_unregister(__FUNCTION__);
        return;
    }

    foreach($match_array as $class_pattern => $file) {
        if (strpos($class_name, $class_pattern) !== false) {
            include_once $xcart_dir . XC_DS . $file;
            $call_include_counter++;
            return;
        }
    }

}//}}}

array_map('strtolower', $export_product_extrafields_headers_g['Facebook_Ecommerce']);
