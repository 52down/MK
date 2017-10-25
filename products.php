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
 * Navigation code
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Customer interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v58 (xcart_4_7_7), 2017-01-24 09:29:34, products.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: home.php"); die("Access denied"); }

if ($config['General']['show_outofstock_products'] != 'Y') {

    $join      = '';
    $distinct = '';
    $condition = '';

    if ($config['General']['unlimited_products'] != 'Y') {

        if (!empty($active_modules['Product_Options'])) {

            $join      = XCVariantsSQL::getJoinQueryAllRows();
            $distinct = 'DISTINCT';
            $condition = " AND ".XCVariantsSQL::getVariantField('avail')." > '0' ";

        } else {

            $condition = " AND $sql_tbl[products].avail > '0' ";

        }

    }

    $current_category['product_count'] = func_query_first_cell("SELECT COUNT($distinct $sql_tbl[products].productid) FROM $sql_tbl[products] INNER JOIN $sql_tbl[products_categories] ON $sql_tbl[products].productid=$sql_tbl[products_categories].productid AND $sql_tbl[products].forsale='Y' AND $sql_tbl[products_categories].categoryid='$cat' $join WHERE 1 $condition ");

    if (
        !empty($subcategories)
        && is_array($subcategories)
    ) {

        foreach ($subcategories as $k => $v) {

            $subcategories[$k]['product_count'] = func_query_first_cell("SELECT COUNT($distinct $sql_tbl[products].productid) FROM $sql_tbl[products] INNER JOIN $sql_tbl[products_categories] ON $sql_tbl[products].productid=$sql_tbl[products_categories].productid AND $sql_tbl[products].forsale='Y' AND $sql_tbl[products_categories].categoryid='$v[categoryid]' $join WHERE 1 $condition ");

        }

        $smarty->assign('subcategories', $subcategories);

    }

}

/**
 * Get products data for current category and store it into $products array
 */

$old_search_data = isset($search_data['products']) ? $search_data['products'] : '';

$old_mode = isset($mode) ? $mode : '';

$search_data['products'] = array(
    'categoryid'              => $cat,
    'search_in_subcategories' => '',
    'category_main'           => 'Y',
    'category_extra'          => 'Y',
    'forsale'                 => 'Y',
    'use_cached_ids'          => TRUE,
);

if (!empty($active_modules['Refine_Filters'])) {
    include $xcart_dir . '/modules/Refine_Filters/incl_products.php';
}

if (!isset($sort)) {
    $sort = $config['Appearance']['products_order'];

    $desc_sort_fields = array(
        'review_rating',
        'sales_stats',
    );

    if (
        in_array($sort, $desc_sort_fields)
        && !isset($sort_direction)
    ) {
        $sort_direction = 1;
    }
}

if (!isset($sort_direction)) {
    $sort_direction = 0;
}

$mode = 'search';

include $xcart_dir . '/include/search.php';

$search_data['products'] = $old_search_data;

$mode = $old_mode;

$smarty->assign('cat_products',      isset($products) ? $products : array());
$smarty->assign('navigation_script', "home.php?cat=$cat&sort=" . urlencode($sort) . "&sort_direction=$sort_direction");
?>
