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
 * Dashboard interface
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    be9581a5c8bee4302a16debb9e0897116cdf6192, v81 (xcart_4_7_8), 2017-04-03 20:33:15, main.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../"); die("Access denied"); }

x_session_register('previous_login_date');

$location[] = array(func_get_langvar_by_name('lbl_top_info'), '');

$max_top_sellers = 10;

/**
 * Generate dates range
 */
$curtime = XC_TIME + $config['Appearance']['timezone_offset'];

$start_dates[] = $previous_login_date;  // Since last login
$start_dates[] = func_prepare_search_date($curtime) - $config['Appearance']['timezone_offset']; // Today

$start_week = $curtime - date('w', $curtime) * 24 * 3600; // Week starts since Sunday

$start_dates[] = func_prepare_search_date($start_week) - $config['Appearance']['timezone_offset']; // Current week
$start_dates[] = mktime(0, 0, 0, date('m', $curtime), 1, date('Y', $curtime)) - $config['Appearance']['timezone_offset']; // Current month

$curtime = XC_TIME;

foreach($start_dates as $start_date) {

    $date_condition = "AND $sql_tbl[orders].date>='$start_date' AND $sql_tbl[orders].date<='$curtime'";

    // Get the orders info
    $orders['C'][] = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[orders] WHERE status='C' $date_condition");
    $orders['P'][] = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[orders] WHERE status='P' $date_condition");
    $orders['F'][] = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[orders] WHERE (status='F' OR status='D') $date_condition");
    $orders['I'][] = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[orders] WHERE status='I' $date_condition");
    $orders['Q'][] = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[orders] WHERE status='Q' $date_condition");

    $gross_total[] = price_format(func_query_first_cell("SELECT SUM(total) FROM $sql_tbl[orders] WHERE 1 $date_condition"));

    $_paid_cond = "(status='P' OR status='C') $date_condition";
    $gross_total_one_date = func_query_first_cell("SELECT SUM(total) FROM $sql_tbl[orders] WHERE $_paid_cond");

    if (!empty($active_modules['Cost_Pricing'])) {
        $gross_profit[] = price_format(XCCostOrder::getGrossProfitByQuery($gross_total_one_date, 'AND ' . $_paid_cond));
    }

    $total_paid[] = price_format($gross_total_one_date);

    // Get top N products
    $ordered_products = func_query("
    SELECT $sql_tbl[order_details].productid, $sql_tbl[products].productcode, $sql_tbl[products_lng_current].product,
           SUM($sql_tbl[order_details].amount) AS count
     FROM $sql_tbl[orders]
     INNER JOIN $sql_tbl[order_details] USING (orderid)
     INNER JOIN $sql_tbl[products] ON $sql_tbl[order_details].productid=$sql_tbl[products].productid
     INNER JOIN $sql_tbl[products_lng_current] ON $sql_tbl[products_lng_current].productid=$sql_tbl[products].productid
     WHERE 1 $date_condition
       AND $sql_tbl[orders].status NOT IN ('F','D')
     GROUP BY $sql_tbl[order_details].productid
     ORDER BY count DESC LIMIT 0, $max_top_sellers");

    if (is_array($ordered_products)) {

        // Get top N categories
        $categories = func_query("
        SELECT $sql_tbl[products_categories].categoryid, SUM($sql_tbl[order_details].amount) as count
          FROM $sql_tbl[order_details]
         INNER JOIN $sql_tbl[orders]
            ON $sql_tbl[order_details].orderid    = $sql_tbl[orders].orderid
         INNER JOIN $sql_tbl[products_categories]
            ON $sql_tbl[order_details].productid  = $sql_tbl[products_categories].productid
           AND $sql_tbl[products_categories].main = 'Y'
         WHERE 1 $date_condition
         GROUP BY $sql_tbl[products_categories].categoryid
         ORDER BY count DESC LIMIT 0, $max_top_sellers
        ");

        if (is_array($categories)) {

            foreach ($categories as $idx => $category) {

                x_load('category');
                $c = func_get_category_path($category['categoryid'], 'category');

                if (empty($c)) {
                    continue;
                }

                $category['category'] = count($c) > 1
                    ? $c[0] . '/.../' . $c[count($c)-1]
                    : implode('/', $c);

                $categories[$idx] = $category;
            }
        }

        $top_sellers[] = $ordered_products;
        $top_categories[] = $categories;

    } else {
        $top_sellers[] = array();
        $top_categories[] = array();
    }

}

/**
 * Get the last order information
 */
$last_order = func_query_first("SELECT orderid, status, total, title, firstname, b_firstname, lastname, b_lastname, date FROM $sql_tbl[orders] ORDER BY date DESC");

if (!empty($last_order)) {
    // Get products ordered in the last order
    $last_order_products = func_query("SELECT productid, product_options, price, amount FROM $sql_tbl[order_details] WHERE orderid='$last_order[orderid]'");
    if (is_array($last_order_products)) {
        foreach ($last_order_products as $k=>$v) {
            $last_order['products'][] = func_array_merge(func_query_first("SELECT p.*, pl.* FROM $sql_tbl[products] AS p INNER JOIN $sql_tbl[products_lng_current] AS pl USING(productid) WHERE p.productid='$v[productid]'"), $v);
        }
    }
    // Get gift certificates ordered in the last order
    $last_order['giftcerts'] = func_query("SELECT gcid, amount FROM $sql_tbl[giftcerts] WHERE orderid='$last_order[orderid]'");

    $last_order['date'] += $config["Appearance"]["timezone_offset"];
}

if (!x_session_is_registered('hide_security_warning') && empty($active_modules['Demo_Mode'])) {

    $smarty->assign('current_passwords_security', func_check_default_passwords($logged_userid));
    $smarty->assign('default_passwords_security', func_check_default_passwords());
    $smarty->assign('not_secure_config_values', func_is_not_secure_config_values());
    $smarty->assign('blowfish_key_expired', func_check_bf_generation_date());
    $smarty->assign('db_backup_expired', func_check_db_backup_generation_date());
    $smarty->assign('dashboard_news', func_tpl_get_admin_dashboard_news());

    $dashboard_notifications = $dashboard_warnings = array();

    if (
        !empty($active_modules['RMA'])
        && func_rma_new_returns_avail()
    ) {
        $dashboard_notifications[] = func_get_langvar_by_name('txt_rma_new_requests_avail_note');
    }

    // Sort by Product/Price/Sales/Rating are not compatible with 'use_simple_product_sort' setting https://sd.x-cart.com/view.php?id=141143
    if (
        $config['Appearance']['products_order'] != 'orderby'
        && $config['General']['use_simple_product_sort'] == 'Y'
    ) {
        $dashboard_notifications[] = func_get_langvar_by_name('msg_adm_products_order_n_use_simple_product_sort_incompatible');
    }

    //  notification about disabled use_new_module_initialization option
    if (
        !empty($config['General']['use_new_module_initialization'])
        && $config['General']['use_new_module_initialization'] != 'Y'
    ) {
        $dashboard_notifications[] = func_get_langvar_by_name('msg_adm_use_new_module_initialization_is_disabled');
    }

    //  notification about disabled FLyout_Menus cache option
    if (
        !empty($active_modules['Flyout_Menus'])
        && $config['Flyout_Menus']['fancy_cache'] != 'Y'
    ) {
        $dashboard_notifications[] = func_get_langvar_by_name('msg_adm_fancy_cache_is_disabled');
    }

    // 'enable_all_shippings' == 'Y' and 'apply_default_country' == 'N' are not compatible for realtime shippings https://sd.x-cart.com/view.php?id=138309#728056
    if (
        $config['Shipping']['enable_shipping'] == 'Y'
        && $config['Shipping']['realtime_shipping'] == 'Y'
        && $config['Shipping']['enable_all_shippings'] == 'Y'
        && $config['General']['apply_default_country'] == 'N'
    ) {
        $dashboard_warnings[] = func_get_langvar_by_name('msg_adm_enable_all_shippings_apply_default_country_incompatible');
    }

    //  Warning about non-moderate provider registration
    if (
        !empty($config['General']['provider_register'])
        && $config['General']['provider_register'] == 'Y'
        && $config['General']['provider_register_moderated'] != 'Y'
    ) {
        $dashboard_warnings[] = func_get_langvar_by_name('msg_adm_provider_register_non_moderated_insecure');
    }

    // Warning about both enabled modules and one of it has empty news lists
    if (
        !empty($active_modules['News_Management'])
        && !empty($active_modules['Adv_Mailchimp_Subscription'])
        && (
            func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[newslists] WHERE avail='Y'") == 0
            || func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[mailchimp_newslists] WHERE avail='Y'") == 0
        )
    ) {
        $dashboard_warnings[] = func_get_langvar_by_name('msg_adm_both_news_modules_are_enabled');
    }

    // Warning about incompatible store settings
    if (
        !empty($active_modules['Pitney_Bowes'])
        && ($pitney_bowes_message = func_pitney_bowes_has_compability_issues())
        && !empty($pitney_bowes_message)
    ) {
        $dashboard_warnings[] = $pitney_bowes_message;
    }

    if (
        !empty($active_modules['Google_Analytics'])
        && !empty($active_modules['Segment'])//segment_compatible from xcart_4_6_5
    ) {
        $dashboard_warnings[] = func_get_langvar_by_name('msg_adm_segment_ga_both_modules_are_enabled');
    }

    if (!empty($config['applied_offers_need2be_converted'])) {
        $dashboard_warnings[] = func_get_langvar_by_name('msg_adm_orders_structure_not_optimized');
    }

    x_load('pages');//For Xc_ALIASED_STATIC_PAGES_FILES
    $_tmp_count_aliased_pages = explode(',', XC_ALIAS_STATIC_PAGES_FILES);
    if (
        $config['General']['checkout_module'] == 'One_Page_Checkout'
        && count($_tmp_count_aliased_pages) > func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[pages] WHERE filename IN ('".implode("','", $_tmp_count_aliased_pages)."') AND level = 'E'")
    ) {
        $dashboard_warnings[] = func_get_langvar_by_name('txt_adm_deleted_aliased_pages_opc');
    }


    $smarty->assign('dashboard_notifications', $dashboard_notifications);
    $smarty->assign('dashboard_warnings', $dashboard_warnings);

    x_session_register('hide_security_warning');
}

/**
 * Set up the smarty templates variables
 */
$smarty->assign('orders', $orders);
$smarty->assign('gross_total', $gross_total);
$smarty->assign('total_paid', $total_paid);

if (!empty($active_modules['Cost_Pricing'])) {
    $smarty->assign('gross_profit', $gross_profit);
}

$smarty->assign('max_top_sellers', $max_top_sellers);
$smarty->assign('top_sellers', $top_sellers);
$smarty->assign('top_categories', $top_categories);

$smarty->assign('last_order', $last_order);

?>
