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
 * Orders management library
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    fdf4c40775b539a54bc228e488550b992e275a43, v192 (xcart_4_7_8), 2017-05-31 11:32:26, orders.php, Ildar
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../"); die("Access denied"); }

x_load('export');

$location[] = array(func_get_langvar_by_name('lbl_orders_management'), 'orders.php');

$smarty->assign('location', $location);

$advanced_options = array(
    'orderid1', 
    'orderid2', 
    'total_max', 
    'paymentid', 
    'shipping_method', 
    'status', 
    'provider', 
    'features', 
    'product_substring', 
    'productcode', 
    'productid', 
    'price_max', 
    'customer', 
    'address_type', 
    'email', 
    'company', 
    'one_return_customer',
    'email_search_type',
);

if (!empty($active_modules['XPayments_Subscriptions'])) {
    $advanced_options[] = 'subscriptions_orders';
}

if (!empty($active_modules['POS_System'])) {
    $advanced_options[] = func_pos_add_advanced_options_orders();
}

if (
    in_array(
        $mode, 
        array(
            'export',
            'export_found', 
            'export_all', 
            'export_continue',
        )
    )
) {
    // Export all orders
    require_once $xcart_dir . '/include/orders_export.php';
}

if ($REQUEST_METHOD == 'GET') {

    // Quick orders search

    $go_search = false;

    if (
        !empty($date) 
        && in_array(
            $date, 
            array(
                'M',
                'W',
                'D',
            )
        )
    ) {

        $search_data = array(
            'orders' => array(
                'date_period' => $date,
            )
        );

        $go_search = true;

    }

    if (
        !empty($status) 
        && in_array(
            $status, 
            array(
                'P',
                'C',
                'D',
                'F',
                'Q',
                'B',
            )
        )
    ) {

        $search_data = array(
            'orders' => array(
                'status' => $status,
            )
        );

        $go_search = true;

    }

    if (!empty($userid)) {

        $search_data = array(
            'orders' => array(
                'customer_id' => $userid,
            )
        );

        $go_search = true;

    }

    if (!empty($active_modules['XPayments_Subscriptions'])) {
        if (!empty($subscriptionid)) {
            $search_data = array(
                'orders' => array(
                    'subscriptionid' => $subscriptionid,
                )
            );

            $go_search = true;
        }
    }

    if ($go_search) {

        func_header_location("orders.php?mode=search");

    }

}

if ($REQUEST_METHOD == 'POST') {

    // Update the session $search_data variable from $posted_data

    if (!empty($posted_data)) {

        $need_advanced_options = false;

        foreach ($posted_data as $k => $v) {

            if (
                !is_array($v) 
                && !is_numeric($v)
            ) {
                $posted_data[$k] = stripslashes($v);
            }

            if (is_array($v)) {

                $tmp = array();

                foreach ($v as $k1 => $v1) {

                    $tmp[$v1] = 1;

                }

                $posted_data[$k] = $tmp;

            }

            if (
                !empty($v)
                && in_array($k, $advanced_options)
            ) {
                $need_advanced_options = true;
            }

        }

        if (!$need_advanced_options)
            $need_advanced_options = (doubleval($posted_data['price_min']) != 0 || doubleval($posted_data['total_min']) != 0);

        $posted_data['need_advanced_options'] = $need_advanced_options;

        if (!empty($start_date)) {
            $posted_data['start_date'] = func_prepare_search_date($start_date);
            $posted_data['end_date']   = func_prepare_search_date($end_date, true);
        }

        if (empty($search_data['orders']['sort_field'])) {

            $posted_data['sort_field'] = 'orderid';
            $posted_data['sort_direction'] = 1;

        } else {

            if (!isset($posted_data['sort_field'])) {

                $posted_data['sort_field'] = $search_data['orders']['sort_field'];

            }

            if (!isset($posted_data['sort_direction'])) {

                $posted_data['sort_direction'] = $search_data['orders']['sort_direction'];

            }

        }

        $search_data['orders'] = $posted_data;

    }

    func_header_location("orders.php?mode=search");
}

if ($mode == 'search') {

    // Perform search and display results

    $data = array();

    $flag_save = false;

    // Prepare the search data
    $allowed_sort_fields = array(
        'orderid',
        'status',
        'customer',
        'date',
        'provider',
        'total',
    );

    if (
        !empty($sort) 
        && in_array(
            $sort, 
            $allowed_sort_fields
        )
    ) {
        // Store the sorting type in the session
        $search_data['orders']['sort_field'] = $sort;

        if (isset($sort_direction)) {

            $search_data['orders']['sort_direction'] = intval($sort_direction);

        } elseif (!isset($search_data['orders']['sort_direction'])) {

            $search_data['orders']['sort_direction'] = 1;

        }

        $flag_save = true;

    }

    if (!isset($search_data['orders']['page'])) {

        $search_data['orders']['page'] = 1;

    }

    if (
        !empty($page) 
        && $search_data['orders']['page'] != intval($page)
    ) {
        // Store the current page number in the session
        $search_data['orders']['page'] = $page;

        $flag_save = true;

    }

    if (
        defined('XC_SESSION_DB_SAVE_ORDERS')
        && $flag_save
    ) {
        x_session_save('search_data');
    }

    if (is_array($search_data['orders'])) {

        $data = $search_data['orders'];

        foreach ($data as $k => $v) {

            if (
                !is_array($v) 
                && !is_numeric($v)
            ) {
                $data[$k] = addslashes($v);
            }

        }

    }

    $search_condition = $distinct_opt = $group_by_opt = $search_condition_count = '';
    $search_in_order_details = false;
    $search_in_products = false;
    $search_from = array($sql_tbl['orders']);
    $search_links = array();

    // Search by orderid
    if (!empty($data['orderid1']))
        $search_condition .= " AND $sql_tbl[orders].orderid>='".intval($data["orderid1"])."'";

    if (!empty($data['orderid2']))
        $search_condition .= " AND $sql_tbl[orders].orderid<='".intval($data["orderid2"])."'";

    // Search by order total
    if (!empty($data['total_min']) && doubleval($data['total_min']) != 0)
        $search_condition .= " AND $sql_tbl[orders].total>='".doubleval($data["total_min"])."'";

    if (!empty($data['total_max']))
        $search_condition .= " AND $sql_tbl[orders].total<='".doubleval($data["total_max"])."'";

    // Search by payment method
    if (!empty($data['paymentid'])) {
        if ($data['paymentid'] == 'Amazon_Checkout_as_payment') {
            $search_from[] = $sql_tbl['amazon_orders'] . " ON $sql_tbl[amazon_orders].orderid = $sql_tbl[orders].orderid ";

        } elseif ($data['paymentid'] == 'Pay_with_Amazon_as_payment') {
            $search_from[] = $sql_tbl['order_extras'] . " ON $sql_tbl[order_extras].orderid = $sql_tbl[orders].orderid AND $sql_tbl[order_extras].khash = 'amazon_pa_auth_id' ";

        } elseif (!empty($active_modules['Pilibaba']) && $data['paymentid'] == 'Pilibaba_as_payment') {
            $search_from[] = XCPilibabaOrders::getJoinCondition();

        } else {
            $search_condition .= " AND $sql_tbl[orders].paymentid = '$data[paymentid]'";
        }
    }        

    // Search by shipping method
    if (!empty($data['shipping_method']))
        $search_condition .= " AND $sql_tbl[orders].shippingid='".intval($data["shipping_method"])."'";

    // Search by order status
    if (!empty($data['status'])) {
        $search_condition .= " AND $sql_tbl[orders].status='".$data["status"]."'";
    } else {
        $search_condition .= " AND $sql_tbl[orders].status != 'X'";
    }

    // Exact search by provider (for provider area and $single_mode = false)

    if (!empty($data['provider_id'])) {
        $search_in_order_details = true;
        $search_condition .= " AND $sql_tbl[order_details].provider='" . $data["provider_id"] . "'";
    }

    // Search by provider
    if (!empty($data['provider'])) {
        $search_in_order_details = true;
        $search_condition .= " AND $sql_tbl[order_details].provider = '" . intval($data["provider"]) . "'";
    }

    // Search by date condition

    if (!empty($data['date_period'])) {

        if ($data['date_period'] == 'C') {

            // ...orders within specified period
            $start_date = $data['start_date'] - $config['Appearance']['timezone_offset'];
            $end_date = $data['end_date'] - $config['Appearance']['timezone_offset'];

        } else {

            $end_date = XC_TIME + $config['Appearance']['timezone_offset'];

            // ...orders within the current month
            if ($data['date_period'] == 'M') {

                $start_date = mktime(0,0,0,date('n',$end_date),1,date('Y',$end_date));

            // ...orders within the current day
            } elseif ($data['date_period'] == 'D') {

                $start_date = func_prepare_search_date($end_date);

            // ...orders within the current week
            } elseif ($data['date_period'] == 'W') {

                // Get the end date's day of the week (0-6, Sun-Mon week)
                $end_date_weekday = date('w', $end_date);

                // Adjust $end_date_weekday value to conform to the woring week (0-6, Mon-Sun week)
                if ($config['Appearance']['working_week_starts_from'] == "Monday")
                    $end_date_weekday = ($end_date_weekday > 0) ? ($end_date_weekday-1) : 6;

                // Get first day of the current week
                $first_weekday = $end_date - ($end_date_weekday * SECONDS_PER_DAY);

                // Prepare timestamp for the beginning of the start date
                $start_date = func_prepare_search_date($first_weekday);

            }

            $start_date -= $config['Appearance']['timezone_offset'];
            $end_date = XC_TIME;
        }

        $search_condition .= " AND $sql_tbl[orders].date>='".($start_date)."'";
        $search_condition .= " AND $sql_tbl[orders].date<='".($end_date)."'";
    }

    // Search by date range condition

    if (!empty($data['date_range'])) {

        $parsed_daterange = func_daterange_get_start_end_timestamp_from_range($data['date_range']);

        if (!empty($parsed_daterange)) {

            // ...orders within specified date range
            $search_condition .= " AND $sql_tbl[orders].date>='".($parsed_daterange['start_timestamp'])."'";
            $search_condition .= " AND $sql_tbl[orders].date<='".($parsed_daterange['end_timestamp'])."'";
        }
    }

    // Exact search by customer login (for customers area)

    if (!empty($data['customer_id']))
        $search_condition .= " AND $sql_tbl[orders].all_userid='" . $data["customer_id"]."'";

    // Search by customer

    if (!empty($data['customer'])) {

        $condition = array();

        if (
            !empty($data['by_username']) 
            || (
                empty($data['by_username']) 
                && empty($data['by_firstname']) 
                && empty($data['by_lastname'])
            )
        ) {
            $condition[] = "$sql_tbl[customers].login = '$data[customer]'";
        }

        if (!empty($data['by_firstname'])) {

            $condition[] = "$sql_tbl[orders].firstname LIKE '%".$data["customer"]."%'";

            $condition[] = "$sql_tbl[orders].b_firstname LIKE '%".$data["customer"]."%'";

            $condition[] = "$sql_tbl[orders].s_firstname LIKE '%".$data["customer"]."%'";

        }

        if (!empty($data['by_lastname'])) {

            $condition[] = "$sql_tbl[orders].lastname LIKE '%".$data["customer"]."%'";

            $condition[] = "$sql_tbl[orders].b_lastname LIKE '%".$data["customer"]."%'";

            $condition[] = "$sql_tbl[orders].s_lastname LIKE '%".$data["customer"]."%'";

        }

        if (
            preg_match("/^(.+)\s+(.+)$/", $data['customer'], $found) 
            && !empty($data['by_firstname']) 
            && !empty($data['by_lastname'])
        ) {
            $condition[] = "($sql_tbl[orders].firstname LIKE '%".trim($found[1])."%' AND $sql_tbl[orders].lastname LIKE '%".trim($found[2])."%')";
            $condition[] = "($sql_tbl[orders].b_firstname LIKE '%".trim($found[1])."%' AND $sql_tbl[orders].b_lastname LIKE '%".trim($found[2])."%')";
            $condition[] = "($sql_tbl[orders].s_firstname LIKE '%".trim($found[1])."%' AND $sql_tbl[orders].s_lastname LIKE '%".trim($found[2])."%')";
}
        if (!empty($condition)) {
            $t = " AND (".implode(" OR ", $condition).")";
            $search_condition .= " AND (".implode(" OR ", $condition).")";
        }    
    }

    // Search by Company name pattern
    if (!empty($data['company'])) {
        $search_condition .= " AND $sql_tbl[orders].company LIKE '%".$data["company"]."%'";
    }

    if (!empty($data['address_type'])) {

        // Search by address...

        $address_condition = array();

        if (!empty($data['city']))
            $address_condition[] = "$sql_tbl[orders].PREFIX_city LIKE '%".$data["city"]."%'";

        if (!empty($data['state']))
            $address_condition[] = "$sql_tbl[orders].PREFIX_state='".$data["state"]."'";

        if (!empty($data['country']))
            $address_condition[] = "$sql_tbl[orders].PREFIX_country='".$data["country"]."'";

        if (!empty($data['zipcode']))
            $address_condition[] = "$sql_tbl[orders].PREFIX_zipcode LIKE '%".$data["zipcode"]."%'";

        // Search by phone/fax pattern
        if (!empty($data['phone'])) 
            $address_condition[] = "($sql_tbl[orders].PREFIX_phone LIKE '%".$data["phone"]."%' OR $sql_tbl[orders].PREFIX_fax LIKE '%".$data["phone"]."%')";

        $address_condition = implode(" AND ", $address_condition);

        $b_address_condition = preg_replace('/'.$sql_tbl['orders']."\.PREFIX_(city|state|country|zipcode|phone|fax)/Ss", $sql_tbl['orders'].".b_\\1", $address_condition);

        $s_address_condition = preg_replace('/'.$sql_tbl['orders']."\.PREFIX_(city|state|country|zipcode|phone|fax)/s", $sql_tbl['orders'].".s_\\1", $address_condition);

        if ($data['address_type'] == 'B' && !empty($b_address_condition))
            $search_condition .= " AND ".$b_address_condition;

        if ($data['address_type'] == 'S' && !empty($s_address_condition))
            $search_condition .= " AND ".$s_address_condition;

        if ($data['address_type'] == 'Both' && !empty($b_address_condition))
            $search_condition .= " AND ((".$b_address_condition.") OR (".$s_address_condition."))";

    }

    // Search by e-mail pattern
    if (!empty($data['email'])) {
        $email_search_prefix = (empty($data['email_search_type']) || $data['email_search_type'] == 'start_with')
            ? ''
            : '%';
        $search_condition .= " AND $sql_tbl[orders].email LIKE '" . $email_search_prefix . $data['email'] . "%'";
    }

    // Search by special features
    if (!empty($data['features'])) {
        // Search for orders that payed by Gift Certificates
        if (!empty($data['features']['gc_applied']))
            $search_condition .= " AND $sql_tbl[orders].giftcert_discount>'0'";

        // Search for orders with global discount applied
        if (!empty($data['features']['discount_applied']))
            $search_condition .= " AND $sql_tbl[orders].discount>'0'";

        // Sea4rch for orders with discount coupon applied
        if (!empty($data['features']['coupon_applied']))
            $search_condition .= " AND $sql_tbl[orders].coupon!=''";

        // Search for orders with free shipping (shipping cost = 0)
        if (!empty($data['features']['free_ship']))
            $search_condition .= " AND $sql_tbl[orders].shipping_cost='0'";

        // Search for orders with free taxes
        if (!empty($data['features']['free_tax']))
            $search_condition .= " AND $sql_tbl[orders].tax='0' ";

        // Search for orders with notes assigned
        if (!empty($data['features']['notes']))
            $search_condition .= " AND $sql_tbl[orders].notes!=''";

        // Search for orders with Gift Certificates ordered
        if (!empty($data['features']['gc_ordered'])) {
            $search_from[] = $sql_tbl['giftcerts'] . " ON $sql_tbl[orders].orderid=$sql_tbl[giftcerts].orderid ";
        }

        // Search for orders placed in fCommerce_Go
        if (!empty($data['features']['fb_added'])) {
            $search_in_order_details = true;
            $search_condition .= " AND $sql_tbl[order_details].extra_data LIKE '%added_in_facebook%'";
        }
    }

    // Search All/POS orders
    if (
        !empty($active_modules['POS_System'])
        && !empty($data['pos_filter'])
    ) {
        $search_condition .= XCPosAdmin::getOrderSearchCondition($data['pos_filter']);
        $_pos_from = XCPosAdmin::getOrderFromTbl($data['pos_filter']);
        if (!empty($_pos_from)) {
            $search_from[] = $_pos_from;
        }
    }

    // Search by ordered products

    if (!empty($data['product_substring'])) {

        $condition = array();

        // Search by product title
        if (!empty($data['by_title'])) {
            $search_in_products = true;
            $condition[] = "$sql_tbl[products_lng_current].product LIKE '%".$data["product_substring"]."%'";
        }

        // Search by product options
        if (!empty($data['by_options'])) {
            $search_in_order_details = true;
            $condition[] = "$sql_tbl[order_details].product_options LIKE '%".$data["product_substring"]."%'";
        }

        if (!empty($condition) && is_array($condition)) {
            $search_in_order_details = true;
            $search_condition .= " AND (".implode(" OR ", $condition).")";
        }
    }

    // Search by product code (SKU)
    if (!empty($data['productcode'])) {
        $search_in_order_details = true;
        $search_condition .= " AND $sql_tbl[order_details].productcode LIKE '" . $data['productcode'] . "%'";
    }

    // Search by product ID
    if (!empty($data['productid'])) {
        $search_in_order_details = true;
        $search_condition .= " AND $sql_tbl[order_details].productid='".$data["productid"]."'";
    }

    // Search by product price range

    if (!empty($data['price_min']) && doubleval($data['price_min']) != 0) {
        $search_in_order_details = true;
        $search_condition .= " AND $sql_tbl[order_details].price>='".$data["price_min"]."'";
    }

    if (!empty($data['price_max'])) {
        $search_in_order_details = true;
        $search_condition .= " AND $sql_tbl[order_details].price<='".$data["price_max"]."'";
    }

    $sort_string = "$sql_tbl[orders].orderid DESC";

    if (!empty($data['sort_field'])) {
        // Sort the search results...

        $direction = ($data['sort_direction'] ? 'DESC' : 'ASC');

        switch ($data['sort_field']) {
            case 'orderid':
                $sort_string = "$sql_tbl[orders].orderid $direction";
                break;

            case 'status':
                $sort_string = "$sql_tbl[orders].status $direction";
                break;

            case 'customer':
                $sort_string = "$sql_tbl[orders].userid $direction";
                break;

            case 'provider':
                if (!$single_mode) {
                    $search_in_order_details = true;
                    $sort_string = "providers.login $direction";
                    $sort_by_provider_login = true;
                } 

                break;

            case 'date':
                $sort_string = "$sql_tbl[orders].date $direction";
                break;

            case 'total':
                $sort_string = "$sql_tbl[orders].total $direction";
                break;

        }

    }

    // Prepare the SQL query

    if ($search_in_order_details) {

        $inner_join_order_details = $sql_tbl['order_details'] . " ON $sql_tbl[orders].orderid=$sql_tbl[order_details].orderid ";
        $search_from[] = $inner_join_order_details;

        if ($search_in_products) {
            $search_from[] = $sql_tbl['products_lng_current'] . " ON $sql_tbl[order_details].productid=$sql_tbl[products_lng_current].productid ";
        }

    } else {
        $inner_join_order_details = '';
    }

    if (is_array($search_from)) {

        if (count($search_from) > 1) {
            $group_by_opt = " GROUP BY $sql_tbl[orders].orderid";
            $distinct_opt = 'DISTINCT';
        }

        $search_from = "FROM ".implode(" INNER JOIN ", $search_from);

    }

    $left_join_customers = " LEFT JOIN $sql_tbl[customers] ON $sql_tbl[orders].userid = $sql_tbl[customers].id ";
    $search_from .= $left_join_customers;
    
    if (!empty($active_modules['XPayments_Subscriptions'])) {
        list($search_from, $search_condition) = func_xps_prepareSearchOrdersQueryParts($data, $search_from, $search_condition);
    }

    if (
        !$single_mode
        && !empty($sort_by_provider_login)
    ) {
        $left_join_providers4sort = " LEFT JOIN (SELECT id, login FROM $sql_tbl[customers] WHERE usertype = 'P') AS providers ON $sql_tbl[order_details].provider = providers.id ";
        $search_from .= $left_join_providers4sort;
    } else {
        $left_join_providers4sort = '';
    }


    if (!empty($data['one_return_customer'])) {

        if ($data['one_return_customer'] == 'R') {
            $search_from .= " INNER JOIN $sql_tbl[orders] AS ro ON ro.all_userid=$sql_tbl[orders].all_userid AND ro.all_userid>0 AND ro.orderid != $sql_tbl[orders].orderid ";
        } else {
            $search_from .= " LEFT JOIN $sql_tbl[orders] AS ro ON ro.all_userid=$sql_tbl[orders].all_userid AND ro.orderid != $sql_tbl[orders].orderid ";
            $search_links[] = "ro.orderid IS NULL";
        }

        $distinct_opt = 'DISTINCT';
        $group_by_opt = " GROUP BY $sql_tbl[orders].orderid";
    }

    $search_links = empty($search_links) ? '1' : implode(" AND ", $search_links);

    $search_condition = $search_condition_count = "$search_from WHERE $search_links $search_condition";
    if (!empty($left_join_providers4sort)) {
        $search_condition_count = str_replace($left_join_providers4sort, ' ', $search_condition_count);
    }

    // remove left join to $Sql_tbl[Customers] if the table is not used
    if (
        !empty($left_join_customers)
        && strpos(str_replace($left_join_customers, ' ', $search_condition_count), $sql_tbl['customers']) === false
    ) {
        $search_condition_count = str_replace($left_join_customers, ' ', $search_condition_count);
    }

    // remove inner join to $Sql_tbl[Order_details] if the table is not used
    if (
        !empty($inner_join_order_details)
        && strpos(str_replace($inner_join_order_details, ' ', $search_condition_count), $sql_tbl['order_details']) === false
    ) {
        $search_condition_count = preg_replace('/INNER\s*JOIN\s*' . preg_quote($inner_join_order_details) . '/si', ' ', $search_condition_count);
    }

    // Count the items in the search results
    $sql_resource = db_query("SELECT $distinct_opt $sql_tbl[orders].orderid $search_condition_count");

    $total_items = db_num_rows($sql_resource);

    if ($total_items > 0) {
        $_orderids = $orderids = array();

        // Perform the SQL and get the search results
        if (
            !empty($data['is_export']) 
            && $data['is_export'] == 'Y'
        ) {

            func_export_range_save('ORDERS', "SELECT $distinct_opt $sql_tbl[orders].orderid $search_condition_count");
            func_export_range_erase('GIFT_CERTIFICATES');
            func_export_range_erase('ORDER_ITEMS');

            if ($total_items < 100) {

                // Use range cache only for 100 orders to avoid memory overload.
                while ($row = db_fetch_row($sql_resource)) {
                    $_orderids[] = $row[0];
                }

                $_order_details_ids = func_query_column("SELECT $sql_tbl[order_details].itemid FROM $sql_tbl[order_details] WHERE $sql_tbl[order_details].orderid IN (".implode(',',$_orderids).") GROUP BY $sql_tbl[order_details].itemid ORDER BY itemid");

                func_export_range_save('ORDER_ITEMS', $_order_details_ids);

                $_gc_ids = func_query_column("SELECT $sql_tbl[giftcerts].gcid FROM $sql_tbl[giftcerts] WHERE $sql_tbl[giftcerts].orderid IN (".implode(',',$_orderids).") GROUP BY $sql_tbl[giftcerts].gcid ORDER BY gcid");

                func_export_range_save('GIFT_CERTIFICATES', $_gc_ids);
            }

            $top_message['content'] = func_get_langvar_by_name("lbl_export_orders_add");
            $top_message['type']    = 'I';
            db_free_result($sql_resource);

            func_header_location("import.php?mode=export");

        } elseif (
            !empty($_GET['export']) 
            && $_GET['export'] == 'export_found'
        ) {
            // Export all found orders
            $REQUEST_METHOD = 'POST';

            while ($row = db_fetch_row($sql_resource)) {
                $orderids[] = $row[0];
            }

            db_free_result($sql_resource);
            include $xcart_dir . '/include/orders_export.php';

        } else {
            db_free_result($sql_resource);

            // For next/prev links on the order details page

            $search_data['orders']['search_condition'] = str_replace(" GROUP BY $sql_tbl[orders].orderid",'', $search_condition_count);

            if (defined('XC_SESSION_DB_SAVE_ORDERS')) {
                x_session_save('search_data');
            }

            // If orders do not exports, separate them on the pages
            $page = $search_data['orders']['page'];

            // Prepare the page navigation

            $objects_per_page = $config['Appearance']['orders_per_page_admin'];

            include $xcart_dir . '/include/navigation.php';

            // Get the results for current pages

            $orders = func_query("SELECT $sql_tbl[orders].*, $sql_tbl[customers].id AS existing_userid, $sql_tbl[customers].login $search_condition $group_by_opt ORDER BY $sort_string LIMIT $first_page, $objects_per_page");

            // Assign the Smarty variables
            $smarty->assign('navigation_script', "orders.php?mode=search");
            $smarty->assign('first_item',        $first_page + 1);
            $smarty->assign('last_item',         min($first_page + $objects_per_page, $total_items));
        }

        if ($orders) {

            x_load('order');

            $total = 0;
            $total_paid = 0;

            if ($current_area != 'C') {
                $oids = $orders;
                array_walk($oids, function(&$val, $key) {$val = $val['orderid'];});#nolint

                // get provider,provider_login,item_productcodes columns
                if (!$single_mode) {
                    $_order_details = func_query_hash("SELECT orderid, od.provider, c.login AS provider_login, GROUP_CONCAT(productcode) AS item_productcodes FROM $sql_tbl[order_details] AS od LEFT JOIN $sql_tbl[customers] as c ON od.provider = c.id WHERE orderid IN ('" . implode("', '", $oids) . "') GROUP BY orderid ORDER BY NULL", 'orderid', false, false);
                } else {
                    $_order_details = func_query_hash("SELECT orderid, GROUP_CONCAT(productcode) AS item_productcodes FROM $sql_tbl[order_details] WHERE orderid IN ('" . implode("', '", $oids) . "')  GROUP BY orderid ORDER BY NULL", 'orderid', false, false);
                }
            }

            foreach ($orders as $k => $v) {

                if (!empty($_order_details[$v['orderid']])) {
                    $orders[$k] = func_array_merge($orders[$k], $_order_details[$v['orderid']]);
                }

                $orders[$k]['date'] += $config['Appearance']['timezone_offset'];

                if (!empty($v['add_date']))
                    $orders[$k]['add_date'] += $config['Appearance']['timezone_offset'];

                if ($current_area != 'C') {

                    if (!empty($active_modules['Stop_List'])) {

                        $_order_ips = func_query_hash("SELECT khash, value FROM $sql_tbl[order_extras] WHERE khash IN ('ip','proxy_ip') AND orderid = '$v[orderid]'", 'khash', false, true);
                        $order_ip = !empty($_order_ips['ip']) ? $_order_ips['ip'] : false;
                        $order_proxy_ip = !empty($_order_ips['proxy_ip']) ? $_order_ips['proxy_ip'] : false;

                        $orders[$k]['blocked'] = func_sl_ip_is_blocked(!empty($order_proxy_ip) ? $order_proxy_ip : $order_ip) ? 'Y' : 'N';
                        $orders[$k]['ip'] = $order_ip;

                    }

                    $orders[$k]['status_blocked'] = $v['status'] == 'A' && (func_order_can_captured(intval($v['orderid'])) || func_order_is_voided(intval($v['orderid'])));

                } else {

                    $total += $v['total'];

                    if ($v['status'] == 'P' || $v['status'] == 'C')
                        $total_paid += $v['total'];

                }

                $orders[$k]['gmap'] = func_get_gmap($v);
            } // foreach ($orders as $k => $v)

            if (!empty($active_modules['fCommerce_Go'])) {
                $orders = func_fb_mark_fb_orders($orders);
            }

            if (!empty($active_modules['XPayments_Connector'])) {
                func_xpay_func_load();
                $orders = xpc_set_orders_antifraud_result($orders);
            }
 
            if (!empty($active_modules['Cost_Pricing'])) {
                $orders = XCCostOrder::setField($orders);
            }

            $smarty->assign('orders', $orders);

            if ($current_area == 'C') {

                $smarty->assign('total',      $total);
                $smarty->assign('total_paid', $total_paid);

            }

        }

    } elseif (
        empty($top_message['content']) 
        && !defined("X_SEARCH_MODE_NEW")
    ) {
        db_free_result($sql_resource);

        $no_results_warning = array(
            'type' => 'W', 
            'content' => func_get_langvar_by_name("lbl_warning_no_search_results", false, false, true),
        );

        $smarty->assign('top_message', $no_results_warning);

    }

    $smarty->assign('total_items', $total_items);
    $smarty->assign('mode',        $mode);

    $dialog_tools_data = array('help' => true);
    $smarty->assign('dialog_tools_data', $dialog_tools_data);

} else {

    $anchors = array(
        'SearchOrders' => 'lbl_search_orders',
        'ExportOrders' => ($current_area == 'A' || !empty($active_modules['Simple_Mode'])) ? "lbl_export_delete_orders" : "lbl_export_orders",
    );

    if (!empty($active_modules['Order_Tracking'])) {
        $anchors['OrderTracking'] = 'lbl_import_trackingid_file';
    }

    foreach ($anchors as $anchor => $anchor_label) {
        $dialog_tools_data['left'][] = array(
            'link'  => "#" . $anchor, 
            'title' => func_get_langvar_by_name($anchor_label),
        );
    }

    if (!empty($active_modules['Advanced_Order_Management'])) {
        $dialog_tools_data['right'][] = array(
            'link' =>  'create_order.php',
            'title' => func_get_langvar_by_name('lbl_create_order')
        );
    }

    $dialog_tools_data['right'][] = array(
        'link' =>  'accounting_adv.php',
        'title' => func_get_langvar_by_name('lbl_accounting')
    );

    $smarty->assign('dialog_tools_data', $dialog_tools_data);
}

include $xcart_dir . '/include/states.php';

include $xcart_dir . '/include/countries.php';

$_now = XC_TIME + $config['Appearance']['timezone_offset'];

$start_date = isset($start_date) ? $start_date : $_now;
$end_date   = isset($end_date) ? $end_date : $_now;

$smarty->assign('start_date',       $start_date);
$smarty->assign('end_date',         $end_date);
$smarty->assign('search_prefilled', !empty($search_data['orders']) ? $search_data['orders'] : array());

$payment_methods = func_query("SELECT $sql_tbl[payment_methods].payment_method, $sql_tbl[payment_methods].paymentid FROM $sql_tbl[payment_methods] INNER JOIN $sql_tbl[orders] ON $sql_tbl[orders].paymentid = $sql_tbl[payment_methods].paymentid GROUP BY $sql_tbl[payment_methods].paymentid ORDER BY $sql_tbl[payment_methods].payment_method");

$payment_methods = is_array($payment_methods) ? $payment_methods : array();

if (
    !empty($active_modules['Amazon_Checkout'])
    && func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[amazon_orders] WHERE orderid>0")
) {
    array_unshift($payment_methods, array('payment_method'=>"Amazon Checkout", 'paymentid' => 'Amazon_Checkout_as_payment'));
}

if (!empty($active_modules['Amazon_Payments_Advanced'])) {
    array_unshift($payment_methods, array('payment_method' => 'Amazon Pay', 'paymentid' => 'Pay_with_Amazon_as_payment'));
}

if (
    !empty($active_modules['Pilibaba'])
    && func_pilibaba_orders_exists()
) {
    array_unshift($payment_methods, array('payment_method' => 'Pilibaba Chinese Checkout', 'paymentid' => 'Pilibaba_as_payment'));
}

$smarty->assign('payment_methods', $payment_methods);

$shipping_methods = func_query("SELECT $sql_tbl[shipping].shippingid, $sql_tbl[shipping].shipping FROM $sql_tbl[shipping] INNER JOIN $sql_tbl[orders] ON $sql_tbl[orders].shippingid = $sql_tbl[shipping].shippingid GROUP BY $sql_tbl[shipping].shippingid ORDER BY code, shipping");

if (!empty($shipping_methods))
    $smarty->assign('shipping_methods', $shipping_methods);

$smarty->assign('orders_full', @$orders_full);

$smarty->assign('single_mode', $single_mode);

$smarty->assign('main',        'orders');

?>
