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
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v10 (xcart_4_7_7), 2017-01-23 20:12:10, config.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined("XCART_SESSION_START") ) { header("Location: ../"); die("Access denied"); }

global $config, $smarty;
$addons['Cost_Pricing'] = true;

$_module_dir  = $xcart_dir . XC_DS . 'modules' . XC_DS . 'Cost_Pricing';

//$css_files['Cost_Pricing'][] = array();

$sql_tbl['cp_order_costs'] = XC_TBL_PREFIX . 'cp_order_costs';
$sql_tbl['cp_product_costs'] = XC_TBL_PREFIX . 'cp_product_costs';

/*
 Load module functions
*/
if (!empty($include_func)) {
    require_once $_module_dir . XC_DS . 'func.php';
    if (!empty($include_init)) {
        func_costp_system_init();
    }
}

if (defined('IS_IMPORT'))
{//{{{

    $modules_import_specification['PRODUCTS']['columns']['cost_price'] = array('type' => 'P', 'default' => 0.00);
}//}}}

if (defined('TOOLS'))
{//{{{
    $tbl_demo_data['Cost_Pricing'] = array(
        'cp_product_costs' => '',
        'cp_order_costs' => '',
    );

    $tbl_keys['cp_product_costs.productid as cost_pricing_repair_products1'] = array(
        'keys' => array('cp_product_costs.productid' => 'products.productid'),
        'fields' => array('productid','cost_price'),
        'url' => 'repair_integrity.php?mode=cost_pricing_repair_products&amp;id=',
    );

    /*Not used as 'products INNER JOIN cp_product_costs' is used in export_Products.php only
    $tbl_keys['products.productid as cost_pricing_repair_products2'] = array(
        'keys' => array('products.productid' => 'cp_product_costs.productid'),
        'fields' => array('productid'),
        'url' => 'repair_integrity.php?mode=cost_pricing_repair_products&amp;id=',
    );
    */

    $tbl_keys['cp_order_costs.orderid as cost_pricing_repair_orders1'] = array(
        'keys'         => array('cp_order_costs.orderid' => 'orders.orderid'),
        'fields'     => array('orderid', 'costs_total'),
        'url' => 'repair_integrity.php?mode=cost_pricing_repair_orders&amp;id=',
    );

    /*Not used as 'orders INNER JOIN cp_order_costs' is not needed
    $tbl_keys['orders.orderid'] = array(
        'keys' => array('orders.orderid' => 'cp_order_costs.orderid'),
        'fields' => array('orderid'),
        'url' => 'repair_integrity.php?mode=cost_pricing_repair_orders',
    );
    */

}//}}}

?>
