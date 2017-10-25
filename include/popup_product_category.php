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
 * Popup products and categories selection library
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v30 (xcart_4_7_7), 2017-01-24 09:29:34, popup_product_category.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../"); die("Access denied"); }

$id_attr     = ($popup_type == 'C') ? 'categoryid' : 'productid';
$name_attr   = ($popup_type == 'C') ? 'category' : 'product';

$tbl_name    = ($popup_type == 'C') ? 'category_bookmarks' : 'product_bookmarks';
$join_tbl    = ($popup_type == 'C') ? 'categories' : 'products_lng_current';

$id_value    = $$id_attr;

if ($mode == 'bookmark') {

    $bookmarks_count = func_query_first_cell("SELECT COUNT($id_attr) FROM $sql_tbl[$tbl_name] WHERE $id_attr = '$id_value' AND userid = '$logged_userid'");

    if ($bookmarks_count == 0) {

        $query_data = array(
            $id_attr    => $id_value,
            'userid'    => $logged_userid,
            'add_date'    => XC_TIME,
        );

        func_array2insert($tbl_name, $query_data);
    }
} elseif ($mode == 'delete_bookmark') {

    db_query("DELETE FROM $sql_tbl[$tbl_name] WHERE $id_attr = '$id_value' AND userid='$logged_userid'");

} elseif ($mode == 'set_popup_first_column') {
    func_setcookie('popup_product_1st_column', $_popup_first_column, XC_TIME + SECONDS_PER_DAY * 365 * 10);
    $popup_product_1st_column = $_popup_first_column;
}

$bookmarks = func_query("SELECT $sql_tbl[$tbl_name].$id_attr, $sql_tbl[$join_tbl].$name_attr FROM $sql_tbl[$tbl_name], $sql_tbl[$join_tbl] WHERE $sql_tbl[$tbl_name].$id_attr = $sql_tbl[$join_tbl].$id_attr AND $sql_tbl[$tbl_name].userid = '$logged_userid' ORDER BY $sql_tbl[$tbl_name].add_date DESC");

if ($popup_type == 'C' && is_array($bookmarks)) {

    foreach ($bookmarks as $k => $bookmark) {
        if (isset($all_categories[$bookmark[$id_attr]])) {
            $bookmarks[$k][$name_attr] = $all_categories[$bookmark[$id_attr]]['category_path'];
        }
    }
}

$smarty->assign ('bookmarks', $bookmarks);
$smarty->assign ('popup_product_1st_column', empty($popup_product_1st_column) ? 'product_name' : $popup_product_1st_column);

x_load('category');
$smarty->assign('allcategories', func_data_cache_get("get_categories_tree", array(0, true, $shop_language, $user_account['membershipid'])));

?>
