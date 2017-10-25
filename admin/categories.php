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
 * Categories management interface
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v71 (xcart_4_7_7), 2017-01-24 09:29:34, categories.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require __DIR__.'/auth.php';
require $xcart_dir.'/include/security.php';

$location[] = array(func_get_langvar_by_name('lbl_categories_management'), 'categories.php');

x_load('category');
settype($cat, 'int');

if ($categories = func_get_categories_list($cat)) {

    /**
     * Override subcategory_count for Admin area
     */
    $product_counts = func_query_hash("SELECT categoryid, COUNT(*) FROM $sql_tbl[products_categories] WHERE categoryid IN ('".implode("','", array_keys($categories))."') GROUP BY categoryid ORDER BY NULL", "categoryid", false, true);

    foreach ($categories as $k => $v) {

        $categories[$k]['subcategory_count']    = ($v['rpos']-$v['lpos']-1)/2;
        $categories[$k]['product_count_global'] = $categories[$k]['product_count'];
        $categories[$k]['product_count']        = isset($product_counts[$k]) ? intval($product_counts[$k]) : 0;

    }

    $smarty->assign('categories', $categories);
}

if ($cat > 0) {

    if ($current_category = func_get_category_data($cat)) {

        $smarty->assign('current_category', $current_category);

    } else {

        $top_message = array(
            'content' => func_get_langvar_by_name('msg_category_not_exist'),
            'type'    => 'E',
        );

        func_header_location('categories.php');

    }

    $smarty->assign('cat', $cat);
}

if (!isset($mode)) {
    $mode = '';
}

/**
 * Ajust category_location array
 */
$category_location = array();
require $xcart_dir . DIR_ADMIN . '/location_adjust.php';

$category_location[count($category_location)-1][1] = '';
$smarty->assign('category_location', $category_location);

// FEATURED PRODUCTS
$f_cat = (empty ($cat) ? '0' : $cat);

if ($REQUEST_METHOD == 'POST') {

    if ($mode == 'update') {

        // Update featured products list

        if (is_array($posted_data)) {
            foreach ($posted_data as $productid => $v) {
                $query_data = array(
                    'avail' => (!empty($v['avail']) ? 'Y' : 'N'),
                    'product_order' => intval($v['product_order'])
                );
                func_array2update('featured_products', $query_data, "productid='$productid' AND categoryid='$f_cat'");
            }
            $top_message['content'] = func_get_langvar_by_name('msg_adm_featproducts_upd');
            $top_message['anchor'] = 'featured';
        }

    } elseif ($mode == 'delete') {

        // Delete selected featured products from the list

        if (is_array($posted_data)) {
            foreach ($posted_data as $productid=>$v) {
                if (empty($v['to_delete']))
                    continue;
                db_query ("DELETE FROM $sql_tbl[featured_products] WHERE productid='$productid' AND categoryid='$f_cat'");
            }
            $top_message['content'] = func_get_langvar_by_name('msg_adm_featproducts_del');
        }

    } elseif ($mode == 'add' &&
        (
            intval($newproductid) > 0
            || (!empty($newproduct_ids))
        )
    ) {
        $newproduct_ids = !empty($newproductid) ? array(intval($newproductid)) : XCAjaxSearchProducts::extractIdsFromStr($newproduct_ids);

        // Add new featured product
        $newavail = (!empty($newavail) ? 'Y' : 'N');
        if (empty($neworder)) {
            $neworder = func_query_first_cell("SELECT MAX(product_order) FROM $sql_tbl[featured_products] WHERE categoryid='$f_cat'") + 10;
        }

        $insert_str = '';
        foreach ($newproduct_ids as $newproductid) {
            if (empty($newproductid)) {
                continue;
            }
            $insert_str .= "('$newproductid','$neworder','$newavail', '$f_cat'), ";
            $neworder += 10;
        }

        if (!empty($insert_str)) {
            $insert_str = rtrim($insert_str, ', ');
            db_query("REPLACE INTO $sql_tbl[featured_products] (productid, product_order, avail, categoryid) VALUES $insert_str");
            $top_message['content'] = func_get_langvar_by_name('msg_adm_featproducts_upd');
        } else {
            $top_message['content'] = func_get_langvar_by_name('txt_no_products_found');
            $top_message['type'] = 'W';
        }
    }

    $top_message['anchor'] = 'featured';

    func_data_cache_clear('get_categories_tree');
    func_data_cache_clear('get_offers_categoryid');

    func_header_location("categories.php?cat=$cat");

}

$products = func_query ("
SELECT $sql_tbl[featured_products].productid, $sql_tbl[products_lng_current].product,
       $sql_tbl[featured_products].product_order, $sql_tbl[featured_products].avail, $sql_tbl[products].productcode
  FROM $sql_tbl[featured_products]
 INNER JOIN $sql_tbl[products]
 INNER JOIN $sql_tbl[products_lng_current] ON $sql_tbl[products_lng_current].productid=$sql_tbl[products].productid
 WHERE $sql_tbl[featured_products].productid    = $sql_tbl[products].productid
   AND $sql_tbl[featured_products].categoryid   = '$f_cat'
 ORDER BY $sql_tbl[featured_products].product_order");

$anchors = array(
    'Categories' => 'lbl_categories'
);

if (!empty($products)) {
    $anchors['featured'] = 'lbl_featured_products';
}

foreach ($anchors as $anchor => $anchor_label) {

    $dialog_tools_data['left'][] = array(
        'link'  => "#" . $anchor,
        'title' => func_get_langvar_by_name($anchor_label)
    );
}

$smarty->assign('dialog_tools_data', $dialog_tools_data);

$smarty->assign ('products', $products);
$smarty->assign ('f_cat', $f_cat);

$smarty->assign('main','categories');

// Assign the current location line
$smarty->assign('location', $location);

if (is_readable($xcart_dir.'/modules/gold_display.php')) {
    include $xcart_dir.'/modules/gold_display.php';
}
func_display('admin/home.tpl',$smarty);
?>
