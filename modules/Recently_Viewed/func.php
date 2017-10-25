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
 * Recently viewed products module functions
 *
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @category   X-Cart
 * @package    Modules
 * @subpackage Recently Viewed
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v31 (xcart_4_7_7), 2017-01-24 09:29:34, func.php, aim
 * @since      4.4.0
 */

if (!defined('XCART_START')) { header('Location: ../../'); die('Access denied'); }

/**
 * Save viewed product in the session
 *
 * @param  int  $id product id
 * @return boolean
 */
function rviewed_save_product($id) {//{{{
    global $recently_viewed_products, $config;

    $id = intval($id);

    if ($id == 0) {
        return false;
    }

    x_session_register('recently_viewed_products', array());

    array_unshift($recently_viewed_products, $id);
    $recently_viewed_products = array_values(array_unique($recently_viewed_products));

    // remove products which are out of limit
    $limit = intval($config['Recently_Viewed']['recently_viewed_products_count']);
    $recently_viewed_products = array_slice($recently_viewed_products, 0, $limit);

    return true;
}//}}}

/**
 * Get recently viewed products from the session
 *
 * @return array numeric array with products data
 */
function rviewed_get_products() {//{{{
    global $sql_tbl, $XCART_SESSION_VARS;

    // XCART_SESSION_VARS is used instead of x_session_get_var('recently_viewed_products' to avoid showing the product in the same session
    $_recently_viewed_products = !empty($XCART_SESSION_VARS['recently_viewed_products'])
        ? $XCART_SESSION_VARS['recently_viewed_products']
        : array();

    if (
        !empty($_recently_viewed_products)
        && is_array($_recently_viewed_products)
    ) {
        // get membershipid
        if (isset($GLOBALS['user_account']) && isset($GLOBALS['user_account']['membershipid'])) {
            $membershipid = $GLOBALS['user_account']['membershipid'];
        } else {
            $membershipid = 0;
        }

        x_load('product');

        // two calls of Func_search_products to collect products is not used as IN ($_recently_viewed_products) should have good selectivity
        $where = array();
        $where[] = "$sql_tbl[products].productid IN (" . implode($_recently_viewed_products, ',') . ')';
        $where[] = "$sql_tbl[products].forsale IN ('Y','H')";

        $products = func_search_products(
            array(
                'where' => $where,
                'skip_tables' => XCSearchProducts::getSkipTablesByTemplate('modules/Recently_Viewed/content.tpl'),
            ),
            $membershipid,
            'skip_orderby',
            '',
            false,
            true
        );

        $sorted_array = array_flip($_recently_viewed_products);
        usort($products, function($a, $b) use($sorted_array) {#nolint
            return $sorted_array[$a['productid']] > $sorted_array[$b['productid']] ? 1 : -1;#nolint
        });

        return $products;
    } else {
        return array();
    }
}//}}}

function func_tpl_get_recently_viewed_products() {
    return rviewed_get_products();
}

?>
