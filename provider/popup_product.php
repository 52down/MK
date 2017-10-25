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
 * Pop up products selection interface
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Provder interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v53 (xcart_4_7_7), 2017-01-24 09:29:34, popup_product.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require __DIR__.'/auth.php';
require $xcart_dir.'/include/security.php';

x_load('product');

$popup_type = 'P';

require $xcart_dir.'/include/popup_product_category.php';

$cat = intval(@$cat);

$display_template = 'main/popup_product.tpl';

if ($cat > 0) {
    $provider_condition = ($single_mode ? '' : " AND $sql_tbl[products].provider = '$logged_userid'");
    $search_query       = " AND $sql_tbl[products_categories].categoryid = '$cat'" . $provider_condition;

    $query['skip_tables'] = XCSearchProducts::getSkipTablesByTemplate($display_template);
    if (!empty($only_regular) && 'Y' === $only_regular) {
        $search_query .= " AND ($sql_tbl[products].product_type = 'N' OR $sql_tbl[products].product_type = '') ";
    } else {
        $query['skip_tables'][] = 'products';
    }

    $orderby  = empty($popup_product_1st_column) || $popup_product_1st_column == 'product_name' ? "$sql_tbl[products_lng_current].product" : "$sql_tbl[products].productcode";
    $query['query'] = $search_query;
    $query['fields'] = array("$sql_tbl[products].forsale");
    $_products = func_search_products ($query, '', $orderby);

    $smarty->assign('forsale_colors', array('H' => 'cyan', 'N' => 'red', '' => 'red'));
    $smarty->assignByRef('products', $_products);
}

func_display($display_template, $smarty);
?>
