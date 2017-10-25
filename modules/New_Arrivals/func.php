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
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v26 (xcart_4_7_7), 2017-01-24 09:29:34, func.php, aim
 * @link       http://www.x-cart.com/
 */

if ( !defined("XCART_SESSION_START") ) { header("Location: ../"); die("Access denied"); }

x_load('product');

function func_get_new_arrivals($cat = 0, $membershipid = 0, $is_new_arrivals_page = false) {
    global $config, $sql_tbl, $smarty, $config, $xcart_dir, $total_items, $objects_per_page, $is_new_arrivals_page, $active_modules, $PHP_SELF;

    $membershipid = intval($membershipid);

    $products = array();

    if (!$is_new_arrivals_page) {
        if (!is_numeric($config['New_Arrivals']['number_of_new_arrivals'])
            || $config['New_Arrivals']['number_of_new_arrivals'] <= 0
        ) {
            $number_of_new_arrivals = 5;
        } else {
            $number_of_new_arrivals = $config['New_Arrivals']['number_of_new_arrivals'];
        }
    } else {
        if (!is_numeric($config['New_Arrivals']['number_of_new_arrivals_page'])
            || $config['New_Arrivals']['number_of_new_arrivals_page'] <= 0
        ) {
            $number_of_new_arrivals = 10;
        } else {
            $number_of_new_arrivals = $config['New_Arrivals']['number_of_new_arrivals_page'];
        }
    }

    if (!is_numeric($config['New_Arrivals']['show_products_for_last_n_days'])
        || $config['New_Arrivals']['show_products_for_last_n_days'] < 0
    ) {
        $config['New_Arrivals']['show_products_for_last_n_days'] = 7;
    }

    $now = XC_TIME;

    $start_time = $now - $config['New_Arrivals']['show_products_for_last_n_days'] * 86400; // 3600 * 24

    $show_products_marked_as_new_time = intval($config['New_Arrivals']['show_products_marked_new_n_days'] * 86400);

    $membershipid_string = ($membershipid == 0 || empty($active_modules['Wholesale_Trading'])) ? "= '0'" : "IN ('" . $membershipid . "', '0')";

    $n_cat_condition = '';
    $n_catids = array();

    if (!empty($cat)) {
        x_load('category');
        $category_data = func_get_category_data($cat);

        $n_catids = array($cat);

        if ($config['New_Arrivals']['show_products_including_subcat'] == 'Y') {

            $cat_params = func_get_categories_list($cat);
            if (!empty($cat_params)) {
                $n_catids = func_array_merge($n_catids, array_keys($cat_params));
            }
        } else {
            $category_data['product_count'] = $category_data['top_product_count'];
        }

        if (!empty($n_catids)) {
            $n_cat_condition = " AND $sql_tbl[products_categories].categoryid IN ('" . implode("', '", $n_catids) . "') ";
        }
    }

    $condition = " AND (
        (
            $sql_tbl[products].mark_as_new = 'N'
            AND $sql_tbl[products].add_date > '$start_time'
        ) OR (
            $sql_tbl[products].mark_as_new = 'S'
            AND $sql_tbl[products].show_as_new_from <= $now
            AND $sql_tbl[products].show_as_new_to >= $now
        ) OR (
            $sql_tbl[products].mark_as_new = 'A'
            AND $sql_tbl[products].show_as_new_from <= $now
            AND IF ($show_products_marked_as_new_time = 0, 1, ($sql_tbl[products].show_as_new_from + $show_products_marked_as_new_time) >= $now)
        )
    )";

    $condition .= $n_cat_condition;

    if ($config['New_Arrivals']['show_manually_added_na_first'] == 'Y') {
        $sort_condition = "$sql_tbl[products].show_as_new_from DESC, $sql_tbl[products].add_date DESC";
        if (
            empty($cat)
            || $category_data['product_count'] > XCSearchProducts::PRODUCT_NUMBER_2SKIP_GROUP_BY
        ) {
            $query['from_tbls'] = array('products' => ' USE INDEX(sa) ');
            $query['use_group_by'] = FALSE;
        }
    } else {
        $sort_condition = "$sql_tbl[products].add_date DESC";
        if (
            empty($cat)
            || $category_data['product_count'] > XCSearchProducts::PRODUCT_NUMBER_2SKIP_GROUP_BY
        ) {
            $query['from_tbls'] = array('products' => ' USE INDEX(add_date) ');
            $query['use_group_by'] = FALSE;
        }
    }

    $query['query'] = $condition;
    $query['skip_tables'] = XCSearchProducts::getSkipTablesByTemplate(XCSearchProducts::SKIP_ALL_POSSIBLE);

    if (!empty($active_modules['Hidden_Categories'])) {
        func_hc_get_categories_query_for_modules($query);
    }

    $products_short = func_search_products($query, $membershipid, $sort_condition, $number_of_new_arrivals, TRUE);

    if (!empty($products_short) && is_array($products_short)) {
        if ($is_new_arrivals_page) {
            // Prepare navigation
            $total_items = count($products_short);
            $objects_per_page = $config['Appearance']['products_per_page'];
            $page = isset($_GET['page']) ? intval($_GET['page']) : 0;

            include $xcart_dir . '/include/navigation.php';

            // Assign navigation data to smarty
            $smarty->assign('new_arrivals_navigation_script', 'new_arrivals.php?');
            $smarty->assign('first_item', $first_page + 1);
            $smarty->assign('last_item', min($first_page + $objects_per_page, $total_items));
     
            // Limit products array
            $products_short = array_slice($products_short, $first_page, $objects_per_page);
        }

        $ids = array();
        foreach ($products_short as $k => $v) {
            $product = func_select_product($v['productid'], $membershipid, false, false, false, 'T');

            if (!isset($product['page_url'])) {
                $product['page_url'] = 'product.php?productid=' . $product['productid'];
            }

            // Get product image: tiny thumbnail(menu block) or thumbnail(usual page)
            $to_be_displayed_on_home_page = empty($cat) && $config['New_Arrivals']['new_arrivals_home'] == 'Y' && strpos(basename($PHP_SELF), 'home.php') !== false;
            if (
                $product['image_type'] == 'T'
                && $config['New_Arrivals']['new_arrivals_menu'] == 'Y'
                && !$is_new_arrivals_page
                && !$to_be_displayed_on_home_page
                && ($image_id = func_query_first_cell("SELECT imageid FROM $sql_tbl[images_T] WHERE id = '$product[productid]'"))
                && ($thumb_url_data = func_image_cache_get_image('T', 'tinythmbn', $image_id))
            ) {
                 $product['tmbn_url'] = $thumb_url_data['url'];
                 $product['image_x']   = $thumb_url_data['width'];
                 $product['image_y']   = $thumb_url_data['height'];
                 unset($thumb_url_data);
            } elseif($product['image_type'] == 'T') {
                $product['tmbn_url'] = $product['image_url'];
            }

            if (empty($product['tmbn_url'])) {
                $product['tmbn_url'] = func_get_image_url($product['productid'], 'T', $product['image_path_T']);
            }

            $_limit_width = $config['Appearance']['thumbnail_width'];
            $_limit_height = $config['Appearance']['thumbnail_height'];

            if (!empty($active_modules['Klarna_Payments'])) {
                $product['monthly_cost'] = func_klarna_get_monthly_cost($product['taxed_price'], KLARNA_PRODUCT_PAGE);
            }

            $product = func_get_product_tmbn_dims($product, $_limit_width, $_limit_height);

            $products[] = $product;
            $ids[] = $v['productid'];
        }

        if (
            !empty($active_modules['Product_Options'])
            && !empty($products)
        ) {
            $_prices = $products;

            array_walk($_prices, create_function('&$val, $key', '$val = $val["price"];'));
            $options_markups = func_get_default_options_markup_list(array_combine($ids , $_prices));

            foreach ($products as $key => $product) {
                if (!empty($options_markups[$product['productid']])) {
                    // Add product options markup
                    if ($product['price'] != 0) {
                        $product['price'] += $options_markups[$product['productid']];
                        if (isset($product['taxed_price'])) {
                            $product['taxed_price'] += $options_markups[$product['productid']];
                        }
                    }

                    $products[$key] = $product;
                }
            }
        }
    }

    return $products;
}

function func_new_arrivals_search_define_options(&$advanced_options, &$sort_fields) {
    if (AREA_TYPE != 'C') {
        $advanced_options[] = 'date_period';
        $advanced_options[] = 'date_range';
        $sort_fields['add_date'] = 'lbl_new_arrivals_date_added';
    }
}

function func_new_arrivals_search_define_date_period(&$posted_data, $start_date, $end_date) {
    if ($start_date) {
        $posted_data['start_date'] = func_prepare_search_date($start_date);
        $posted_data['end_date']   = func_prepare_search_date($end_date, true);
    }
}

function func_new_arrivals_search_add_date_conditions($data, &$where) {
    global $config, $sql_tbl;

    // Search by date condition
    if (!empty($data['date_period'])) {

        if ($data['date_period'] == 'C') {
            // ...orders within specified period
            $start_date = $data['start_date'] - $config['Appearance']['timezone_offset'];
            $end_date = $data['end_date'] - $config['Appearance']['timezone_offset'];

        } else {

            $end_date = XC_TIME + $config['Appearance']['timezone_offset'];

            if ($data['date_period'] == 'M') {
                // ...orders within the current month
                $start_date = mktime(0, 0, 0, date('n', $end_date), 1, date('Y', $end_date));

            } elseif ($data['date_period'] == 'D') {
                // ...orders within the current day
                $start_date = func_prepare_search_date($end_date);

            } elseif ($data['date_period'] == 'W') {
                // ...orders within the current week

                // Get the end date's day of the week (0-6, Sun-Mon week)
                $end_date_weekday = date('w', $end_date);

                // Adjust $end_date_weekday value to conform to the woring week (0-6, Mon-Sun week)
                if ($config['Appearance']['working_week_starts_from'] == 'Monday') {
                    $end_date_weekday = ($end_date_weekday > 0) ? ($end_date_weekday - 1) : 6;
                }

                // Get first day of the current week
                $first_weekday = $end_date - ($end_date_weekday * SECONDS_PER_DAY);

                // Prepare timestamp for the beginning of the start date
                $start_date = func_prepare_search_date($first_weekday);

            }

            $start_date -= $config['Appearance']['timezone_offset'];
            $end_date = XC_TIME;
        }

        $where[] = "$sql_tbl[products].add_date >= '" . ($start_date) . "'";
        $where[] = "$sql_tbl[products].add_date <= '" . ($end_date) . "'";
    }

    // Search by date range condition
    if (!empty($data['date_range'])) {
        $parsed_daterange = func_daterange_get_start_end_timestamp_from_range($data['date_range']);

        if (!empty($parsed_daterange)) {

            $where[] = "$sql_tbl[products].add_date >= '" . ($parsed_daterange['start_timestamp']) . "'";
            $where[] = "$sql_tbl[products].add_date <= '" . ($parsed_daterange['end_timestamp']) . "'";
        }
    }
}

function func_format_mark_as_new_fields($query_data, $mark_as_new, $date_period, $from, $to) { // {{{
    $_now = XC_TIME;

    if ($mark_as_new == 'Y') {
        $query_data['mark_as_new'] = ($date_period == 'S') ? 'S' : 'A';

        if ($date_period == 'S') {
            $query_data['show_as_new_from'] = (!empty($from)) ? $from : $_now;
            $query_data['show_as_new_to'] = (!empty($to)) ? $to : $_now;
        } else {
            $query_data['show_as_new_from'] = $_now;
            $query_data['show_as_new_to'] = 0;
        }
    } else {
        $query_data['mark_as_new'] = 'N';
        $query_data['show_as_new_from'] = 0;
        $query_data['show_as_new_to'] = 0;
    }

    if ($query_data['show_as_new_from'] > 0) {
        $query_data['show_as_new_from'] = func_prepare_search_date($query_data['show_as_new_from']);
    }

    if ($query_data['show_as_new_to'] > 0) {
        $query_data['show_as_new_to'] = func_prepare_search_date($query_data['show_as_new_to'], true);
    }

    return $query_data;
} // }}}

function func_mark_product_as_new_geid($productid, $query_data) { // {{{
    if (
        $productid > 0
        && !empty($query_data)
        && isset($query_data['mark_as_new'])
    ) {

        $data_tmp = array(
            'mark_as_new' => $query_data['mark_as_new'],
            'show_as_new_from' => $query_data['show_as_new_from'],
            'show_as_new_to' => $query_data['show_as_new_to'],
        );

        func_array2update('products', $data_tmp, "productid = '$productid'");

        return true;
    }

    return false;
} // }}}

function func_new_arrivals_set_sort_string(&$sort_string, $sort_field, $direction) {
    global $config;

    if (
        $config['New_Arrivals']['show_date_col_on_product_list'] == 'Y'
        && $sort_field == 'add_date'
    ) {
        $sort_string = 'add_date ' . $direction;
    }
}

function func_new_arrivals_search_categories_fields(&$to_search) {
    $to_search[] = 'node.show_new_arrivals';
}

function func_new_arrivals_categories_update_list(&$query_data, $show_new_arrivals) {
    $query_data['show_new_arrivals'] = ($show_new_arrivals == 'Y' ? 'Y' : 'N');
}

?>
