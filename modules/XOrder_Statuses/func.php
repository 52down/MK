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
 * Order statuses page interface
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0559ca8bda5978a4247cd80d0c9c0635f06a7290, v25 (xcart_4_7_8), 2017-06-01 10:08:00, func.php, Ildar
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

/**
 * Initialize module
 *
 * @global array $xostat_statuses_cache
 */
function func_orderstatuses_init()
{// {{{
    global $smarty, $xostat_statuses_cache;

    $xostat_statuses_cache = array();

    $smarty->register_prefilter('func_orderstatuses_orders_list_prefilter');
    $smarty->register_function('tpl_order_statuses', 'func_orderstatuses_smarty');
    $smarty->register_function('order_status_desc', 'func_orderstatuses_get_status_desc');
} //}}}

/**
 * Add new order status.
 * status - array, containing the following keys
 *     name              - status name;
 *     descr             - status description;
 *     color             - status color (hex);
 *     code              - code (for system statuses only: I, Q, P, C, D, F, B, A);
 *     orderby           - order;
 *     show_in_progress  - 'Y' if the status should be visible in the progress bar
 *                          on order invoice, 'N' - otherwise;
 *     reserve_products  - 'Y' if the product quantity should be decreased when
 *                          the order is set to this status, otherwise - 'N'
 *     notify_customer   - 'Y' if e-mail notification should be sent to customer
 *                          when the order is set to this status
 *     notify_orders_dep - 'Y' if e-mail notification should be sent to orders
 *                          department when the order is set to this status
 *     notify_provider   - 'Y' if e-mail notification should be sent to provider
 *                          when the order is set to this status
 */
function func_orderstatuses_add($status, $lang=null)
{// {{{
    global $sql_tbl, $top_message;

    $data = array(
        'color'             => $status['color'],
        'inactive_color'    => func_orderstatuses_get_inactive_color($status['color']),
        'show_in_progress'  => isset($status['show_in_progress']) ? 'Y' : 'N',
        'only_when_active'  => isset($status['only_when_active']) ? 'Y' : 'N',
        'reserve_products'  => isset($status['reserve_products']) ? 'Y' : 'N',
        'notify_customer'   => isset($status['notify_customer']) ? 'Y' : 'N',
        'notify_orders_dep' => isset($status['notify_orders_dep']) ? 'Y' : 'N',
        'notify_provider'   => isset($status['notify_provider']) ? 'Y' : 'N',
        'orderby'           => intval($status['orderby'])
    );

    $data['code'] = func_orderstatuses_generate_custom_status_code();

    if (!empty($data['code'])) {
        // Main insert
        $id = func_array2insert('custom_order_statuses', $data);
    }

    if (empty($id)) {
        $top_message = array(
            'type'      => 'E',
            'content'   => func_get_langvar_by_name('err_xostat_cant_generate_custom_code')
        );

        func_header_location('xorder_statuses.php');
    }

    $langs = func_query_column("SELECT DISTINCT code FROM $sql_tbl[languages]");

    foreach ($langs as $__lang) {
        // Insert status name
        $data = array(
            'code'  => $__lang,
            'name'  => 'order_status_' . $id . '_name',
            'value' => $status['name'],
            'topic' => 'Labels'
        );
        func_array2insert('languages', $data);

        // Insert status description
        $data = array(
            'code'  => $__lang,
            'name'  => 'order_status_' . $id . '_descr',
            'value' => $status['descr'],
            'topic' => 'Text'
        );

        func_array2insert('languages', $data);
    }

    return $id;
} //}}}

/**
 * Update status.
 * statusid - status ID
 * status - array with status info (see func_orderstatuses_add function).
 */
function func_orderstatuses_update($statusid, $status, $lang=null)
{// {{{
    global $sql_tbl, $shop_language;


    // Update status info
    $data = array(
        'show_in_progress'  => isset($status['show_in_progress']) ? 'Y' : 'N',
        'only_when_active'  => isset($status['only_when_active']) ? 'Y' : 'N',
        'notify_customer'   => isset($status['notify_customer']) ? 'Y' : 'N',
        'notify_orders_dep' => isset($status['notify_orders_dep']) ? 'Y' : 'N',
        'notify_provider'   => isset($status['notify_provider']) ? 'Y' : 'N',
        'orderby'           => intval($status['orderby'])
    );

    if (
        isset($status['color'])
    ) {
        $data['color']          = $status['color'];
        $data['inactive_color'] = func_orderstatuses_get_inactive_color($status['color']);
    }

    $statusid = intval($statusid);
    // Update reserve_products property for custom statuses only
    $status_code = func_query_first_cell("SELECT code FROM $sql_tbl[custom_order_statuses] WHERE statusid='$statusid'");
    if (
        !func_orderstatuses_check_if_system_status($status_code)
    ) {
        $data['reserve_products'] = isset($status['reserve_products']) ? 'Y' : 'N';
    }

    func_array2update('custom_order_statuses', $data, "statusid=" . $statusid);

    // Update name and description
    if (
        is_null($lang)
    ) {
        $lang = $shop_language;
    }

    db_query("UPDATE $sql_tbl[languages] SET value='" . $status['name'] . "' WHERE name='order_status_" . $statusid . "_name' AND code='" . addslashes($lang) . "'");
    db_query("UPDATE $sql_tbl[languages] SET value='" . $status['descr'] . "' WHERE name='order_status_" . $statusid . "_descr' AND code='" . addslashes($lang) . "'");
} //}}}

/**
 * Delete status
 */
function func_orderstatuses_delete_status($statusid)
{// {{{
    global $sql_tbl;

    $status = func_orderstatuses_statusinfo($statusid, null, 'get_total_count');

    //System statuses or a status with orders in it can not be removed.
    if (
        $status === false
        || func_orderstatuses_check_if_system_status($status['code'])
        || $status['orders_count'] > 0
    ) {
        return false;
    }

    $statusid = intval($statusid);

    db_query("DELETE FROM $sql_tbl[custom_order_statuses] WHERE statusid='$statusid'");
    db_query("DELETE FROM $sql_tbl[languages] WHERE name IN ('order_status_" . $statusid . "_name', 'order_status_" . $statusid . "_descr')");

    return true;
} //}}}

/**
 * Generate unique custom order status code
 */
function func_orderstatuses_generate_custom_status_code()
{// {{{
    global $sql_tbl;

    assert('XC_XOSTAT_STATUS_LENGTH > 1 /* '.__FUNCTION__.': The code below does support 2+ symbols codes*/');

    $existing_statuses = func_query_column("SELECT DISTINCT status FROM $sql_tbl[orders] UNION ALL SELECT code FROM $sql_tbl[custom_order_statuses]");
    $existing_statuses = array_merge(func_orderstatuses_get_system_statuses(), $existing_statuses);
    $existing_statuses[] = 'S'; //reserve for ShippingEasy module
    $existing_statuses = array_unique($existing_statuses);
    $existing_statuses = array_map('strtoupper', $existing_statuses);

    $try_count = 0;
    $max_attempts_count = 10000;

    do {
        $first_symbol = chr(mt_rand(65,90)); //[A-Z]
        $new_code = $first_symbol . strtoupper(substr(md5(uniqid(__FUNCTION__)), 0, XC_XOSTAT_STATUS_LENGTH-1));

        if ($try_count++ >= $max_attempts_count) {
            break;
        }
    } while(
        in_array($new_code, $existing_statuses)
        || in_array($new_code, func_query_column("SELECT code FROM $sql_tbl[custom_order_statuses]"))
    );

    if ($try_count >= $max_attempts_count) {
        // The new code cannot be generated. XC_XOSTAT_STATUS_LENGTH should be increased ?
        $new_code = false;
    }

    return $new_code;
} //}}}

/**
 * System statuses
 */
function func_orderstatuses_get_system_statuses()
{// {{{
    return array('I', 'Q', 'A', 'P', 'B', 'D', 'F', 'C', 'X', 'R');
} //}}}

/**
 * Checks if the given status is default system status
 */
function func_orderstatuses_check_if_system_status($status)
{// {{{
    return ((in_array($status, func_orderstatuses_get_system_statuses())) ? true : false);
} //}}}

function func_orderstatuses_check_if_status_changes_stock($status)
{// {{{
    $info = func_orderstatuses_get_status_info_by_code($status);

    return (($info['reserve_products'] == 'Y') ? true : false);
} //}}}

/**
 * Generate inactive version for the given color.
 * In other words, this function projects the given
 * color onto (255, 255, 255) vector.
 */
function func_orderstatuses_get_inactive_color($color)
{// {{{
    while (strlen($color) < 6) $color = $color . 'f';

    $r = '0x' . substr($color, 0, 2);
    $g = '0x' . substr($color, 2, 2);
    $b = '0x' . substr($color, 4, 2);

    $c = round(($r + $g + $b) / 3);
    $c = base_convert($c, 10, 16);

    return $c . $c . $c;
} //}}}

/**
 * Get information about the given status.
 */
function func_orderstatuses_statusinfo($statusid, $lang = null, $get_count='')
{// {{{//{{{
    global $sql_tbl, $shop_language;
    static $res;
    $statusid = intval($statusid);

    if (is_null($lang)) {
        $lang = $shop_language;
    }

    $md5_args = $statusid . '|' . $lang . '|' . $get_count;
    if (isset($res[$md5_args])) {
        return $res[$md5_args];
    }

    $status = func_query_first("SELECT * FROM $sql_tbl[custom_order_statuses] WHERE statusid='$statusid'");

    if (empty($status)) {
        $res[$md5_args] = false;
        return false;
    }


    $status_names = func_query_hash("SELECT name, value FROM $sql_tbl[languages] WHERE name IN ('order_status_" . $statusid . "_name', 'order_status_" . $statusid . "_descr') AND code='" . addslashes($lang) . "'", 'name', false, true);
    $status['name'] = $status_names['order_status_' . $statusid . '_name'];
    $status['descr'] = isset($status_names['order_status_' . $statusid . '_descr']) ? $status_names['order_status_' . $statusid . '_descr'] : '';

    // Get orders count
    if ($get_count == 'get_total_count') {
        $status['orders_count'] = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[orders] WHERE status='".addslashes($status['code'])."'");
    }

    $status['system_status'] = (func_orderstatuses_check_if_system_status($status['code'])) ? 'Y' : 'N';

    $res[$md5_args] = $status;
    return $status;
} //}}}//}}}

/**
 * Get the list of all available statuses.
 * for_progress_bar - indicate if the function should return the statuses
 *                    with show_in_progress='Y' or all statuses.
 */
function func_orderstatuses_list($for_progress_bar=false, $lang=null, $orderid=null, $order_status = null, $get_count='')
{// {{{
    global $sql_tbl, $config;
    static $query_statusids;

    $cond = '';

    if (
        $for_progress_bar
    ) {
        $cond .= "WHERE show_in_progress = 'Y'";
    }

    if (
        $for_progress_bar
        && $orderid != null
        && !empty($orderid)
    ) {
        $order_statuses = func_orderstatuses_get_status_history($orderid);

        if (
            !empty($order_statuses)
        ) {

            $cond .= " AND (only_when_active = 'N' OR ( only_when_active = 'Y' AND code IN ('" . implode("','", $order_statuses) . "') ) )";

        } else {

            $cond .= " AND only_when_active = 'N'";
        }
    }

    $statusids = isset($query_statusids[$cond]) ? $query_statusids[$cond] : func_query_column("SELECT statusid FROM $sql_tbl[custom_order_statuses] $cond ORDER BY orderby");
    $query_statusids[$cond] = $statusids;

    if (
        empty($statusids)
    ) {
        return false;
    }

    $statuses = array();
    $show_color_before_active = 'Y';

    foreach ($statusids as $id)
    {
        $_tmp = func_orderstatuses_statusinfo($id, $lang, $get_count);

        $_tmp['css_name'] = $_tmp['code'];

        if (
            $for_progress_bar
        ) {
            $_tmp['active_color']   = ($config['XOrder_Statuses']['xostat_use_colors'] == 'Y') ? $_tmp['color'] : '000000';
            $_tmp['inactive_color'] = ($config['XOrder_Statuses']['xostat_use_colors'] == 'Y') ? $_tmp['inactive_color'] : '888888';

            if (
                !is_null($order_status)
                && !empty($order_status)
                && (
                    $_tmp['statusid'] == $order_status
                    || $_tmp['code'] == $order_status
                )
            ) {
                $_tmp['show_color'] = $show_color_before_active;
                $_tmp['active'] = 'Y';

                $show_color_before_active = 'N';

            } else {

                $_tmp['show_color'] = $show_color_before_active;
                $_tmp['active'] = 'N';
            }
        }

        $statuses[] = $_tmp;
    }

    return $statuses;
} //}}}

function func_orderstatuses_get_maxorderby($add_number = 10)
{//{{{
    global $sql_tbl;
    return func_query_first_cell("SELECT MAX(orderby) FROM $sql_tbl[custom_order_statuses]") + $add_number;
}//}}}

/**
 * 2 level cache array set
 */
function func_orderstatuses_manage_data_cache_set($val, $i, $j = '')
{// {{{
    global $xostat_statuses_cache;

    if (
        empty($i)
    ) {
        return false;
    }

    if (
        !isset($xostat_statuses_cache)
        || !is_array($xostat_statuses_cache)
    ) {
        $xostat_statuses_cache = array();
    }

    if (
        !empty($j)
    ) {
        if (
            !is_array($xostat_statuses_cache[$i])
        ) {
            $xostat_statuses_cache[$i] = array();
        }

        $xostat_statuses_cache[$i][$j] = $val;

    } else {

        $xostat_statuses_cache[$i] = $val;
    }

    return true;
} //}}}

/**
 * 2 level cache array get
 */
function func_orderstatuses_manage_data_cache_get($i, $j = '')
{// {{{
    global $xostat_statuses_cache;

    if (
        empty($i)
    ) {
        return false;
    }

    if (
        !isset($xostat_statuses_cache)
        || !isset($xostat_statuses_cache[$i])
    ) {
        return false;
    }

    if (
        !empty($j)
    ) {
        if (
            !isset($xostat_statuses_cache[$i][$j])
        ) {
            return false;
        }

        return $xostat_statuses_cache[$i][$j];

    } else {

        return $xostat_statuses_cache[$i];
    }
} //}}}

function func_orderstatuses_get_status_list_by_id()
{// {{{
    global $sql_tbl;

    $info = func_orderstatuses_manage_data_cache_get('list_by_id');

    if (
        $info === false
    ) {

        $info = func_orderstatuses_manage_data_cache_get('list_by_code');

        if (
            $info === false
        ) {
            $statusids = func_query_column("SELECT statusid FROM $sql_tbl[custom_order_statuses] ORDER BY orderby");

            $info = array();

            foreach ($statusids as $id) {

                $_tmp = func_orderstatuses_statusinfo($id);

                $info[$_tmp['statusid']] = $_tmp;
            }

        } else {

            $_tmp = array();

            foreach ($info as $status) {

                $_tmp[$status['statusid']] = $status;
            }

            $info = $_tmp;
        }

        func_orderstatuses_manage_data_cache_set($info, 'list_by_id');
    }

    return $info;
} //}}}

function func_orderstatuses_get_status_list_by_code()
{// {{{
    global $sql_tbl;

    $info = func_orderstatuses_manage_data_cache_get('list_by_code');

    if (
        $info === false
    ) {
        $info = func_orderstatuses_manage_data_cache_get('list_by_id');

        if (
            $info === false
        ) {
            $statusids = func_query_column("SELECT statusid FROM $sql_tbl[custom_order_statuses] ORDER BY orderby");

            $info = array();

            foreach ($statusids as $id) {

                $_tmp = func_orderstatuses_statusinfo($id);

                $info[$_tmp['code']] = $_tmp;
            }

        } else {

            $_tmp = array();

            foreach ($info as $status) {

                $_tmp[$status['code']] = $status;
            }

            $info = $_tmp;
        }

        func_orderstatuses_manage_data_cache_set($info, 'list_by_code');
    }

    return $info;
} //}}}

function func_orderstatuses_get_status_info_by_code($code)
{// {{{
    global $sql_tbl;

    $info = func_orderstatuses_manage_data_cache_get('info_by_code', $code);

    if (
        $info === false
    ) {
        $info = func_orderstatuses_manage_data_cache_get('list_by_code', $code);

        if (
            $info === false
        ) {
            $id = func_query_first_cell("SELECT statusid FROM $sql_tbl[custom_order_statuses] WHERE code = '$code'");

            $info = func_orderstatuses_statusinfo($id);
        }

        func_orderstatuses_manage_data_cache_set($info, 'info_by_code', $code);
    }

    return $info;
} //}}}

function func_orderstatuses_get_custom_statuses_list()
{// {{{
    $info = func_orderstatuses_manage_data_cache_get('custom_statuses');

    if (
        $info === false
    ) {
        $info = array();

        $_tmp = func_orderstatuses_get_status_list_by_id();

        foreach ($_tmp as $id => $status) {

            if (
                $status['system_status'] == 'N'
            ) {
                $info[$id] = $status;
            }
        }

        func_orderstatuses_manage_data_cache_set($info, 'custom_statuses');
    }

    return $info;
} //}}}

/**
 * Smarty function. Assign all statuses into smarty variable,
 * specified as 'var' attribute. For example:
 * {Tpl_order_statuses var=avail_statuses}
 * {Tpl_order_statuses var=avail_statuses progress_bar='Y'}
 */
function func_orderstatuses_smarty($params, &$smarty)
{// {{{
    if (!empty($params['var'])){
/*
        $for_progress_bar = isset($params['progress_bar']) && $params['progress_bar'] == 'Y';

        $statuses_list = func_orderstatuses_list($for_progress_bar, null, $params['orderid'], $params['order_status']);
*/
        $statuses_list = func_orderstatuses_get_status_list_by_id();

        $smarty->assign($params['var'], $statuses_list);
    }
} //}}}

/**
 * Get status description for order status inside Smarty
 * {order_status_desc statys=$status [var="varname"]}
 */
function func_orderstatuses_get_status_desc($params)
{// {{{
    global $smarty;

    if (
        !isset($params)
        || empty($params)
        || !isset($params['status'])
        || empty($params['status'])
    ) {
        return '';
    }

    $info = func_orderstatuses_get_status_info_by_code($params['status']);

    if (
        isset($params['var'])
        && !empty($params['var'])
    ) {
        $smarty->assign($params['var'], $info['descr']);

        return '';

    } else {

        return $info['descr'];
    }
} //}}}

/**
 * Validate status code. It is valid if there is a status
 * with such statusid or code.
 */
function func_orderstatuses_is_valid($status)
{// {{{
    global $sql_tbl;
    $avail_statuses = func_query_column("SELECT code FROM $sql_tbl[custom_order_statuses]");
    $avail_statuses[] = 'S'; //reserve for ShippingEasy module

    return is_array($avail_statuses) && in_array($status, $avail_statuses);
} //}}}

/**
 * This function is used when the order status is changed
 * to send the notification.
 * See include/func/func.order.php::func_change_order_status
 */
function func_orderstatuses_change($order_data,  $status)
{// {{{
    global $sql_tbl, $mail_smarty, $config, $active_modules;

    if (func_orderstatuses_check_if_system_status($status)) {
        // System status will be processed by the X-Cart core.
        return false;
    }

    // We are here because 'status' is statusid
    $new_status = func_orderstatuses_get_status_info_by_code($status);

    //
    // Notification
    //
    $order_data['order']['status'] = $status;

    $mail_smarty->assign('products',  $order_data['products']);
    $mail_smarty->assign('giftcerts', $order_data['giftcerts']);
    $mail_smarty->assign('order',     $order_data['order']);
    $mail_smarty->assign('userinfo',  $order_data['userinfo']);

    // to orders department
    if (
        $new_status['notify_orders_dep'] == 'Y'
    ) {
        func_send_mail(
            $config['Company']['orders_department'],
            'mail/order_notification_subj.tpl',
            'mail/order_notification_admin.tpl',
            $config['Company']['orders_department'],
            true,
            true
        );
    }

    // to providers
    if (
        (empty($active_modules['Simple_Mode']) && $new_status['notify_provider'] == 'Y')
        ||
        (!empty($active_modules['Simple_Mode']) && $config['XOrder_Statuses']['xostat_send_email_to_provider'] == 'Y')
    ) {
        $providers = func_query("SELECT provider FROM $sql_tbl[order_details] WHERE $sql_tbl[order_details].orderid='$order_data[orderid]' GROUP BY provider");

        if (
            is_array($providers)
        ) {
            foreach($providers as $provider) {

                $email_pro = func_query_first_cell("SELECT email FROM $sql_tbl[customers] WHERE id='$provider[provider]'");

                if (
                    !empty($email_pro)
                    && $email_pro != $config['Company']['orders_department']
                ) {
                    func_send_mail(
                        $email_pro,
                        'mail/order_notification_subj.tpl',
                        'mail/order_notification.tpl',
                        $config['Company']['orders_department'],
                        false
                    );
                }
            } // foreach($providers as $provider)
        } // if (is_array($providers))
    } // if ($new_status['notify_provider'] == 'Y')

    return $new_status['notify_customer'] == 'Y';
} //}}}

/**
 * This functions updates the quantities of the products
 * when the order status is changed.
 * See: include/func/func.order.php::func_change_order_status
 */
function func_orderstatuses_update_quantity(&$products, $old_status, $new_status)
{// {{{
    global $sql_tbl;

    $statuses = func_orderstatuses_get_status_list_by_code();

    $old_reserve = $statuses[$old_status]['reserve_products'] == 'Y';
    $new_reserve = $statuses[$new_status]['reserve_products'] == 'Y';

    if ($old_reserve != $new_reserve) {
        func_update_quantity($products, $old_reserve);
    }
} //}}}

/**
 * This function returns the status name on basis of its code.
 * If there is no status with such code, returns the array of all
 * available statuses.
 * See: modules/Advanced_Order_Management/func.php::func_aom_get_order_status
 */
function func_orderstatuses_get_order_status($status)
{// {{{
    $statuses = func_orderstatuses_list();

    // Search for status with the given code or statusid
    $index = -1;
    for ($i = 0; $i < count($statuses); $i++) {

        if ($statuses[$i]['code'] == $status || $statuses[$i]['statusid'] == $status)
        {
            $index = $i;
            break;
        }
    }

    $return = false;

    if ($index > -1) {
        // Return the found status
        $return = $statuses[$i]['name'];

    } else {
        // Return array of all statuses
        $return = array();
        foreach ($statuses as $item)
        {
            $return[] = $item['name'];
        }

    }

    return $return;
} //}}}

function func_orderstatuses_get_status_history($oid)
{// {{{
    global $sql_tbl;

    $statuses = func_query_column("SELECT details FROM $sql_tbl[order_status_history] WHERE orderid = '$oid'");

    $statuses_list = array();

    if (
        !empty($statuses)
    ) {
        foreach ($statuses as $status)
        {
            $status = unserialize($status);

            if (
                !empty($status['old_status'])
            ) {
                $statuses_list[$status['old_status']] = true;
            }

            if (
                !empty($status['new_status'])
            ) {
                $statuses_list[$status['new_status']] = true;
            }
        }
    }

    return (empty($statuses_list)) ? array() : array_keys($statuses_list);
} //}}}

function func_orderstatuses_get_gradient_pbar_css($name, $color, $for_ie = false)
{// {{{
    global $http_location;

    if (
        empty($color)
    ) {
        return '';
    }

    $color = strtolower($color);
    $text_color = func_orderstatuses_get_text_color($color);

    $css = "
.$name {
color: #$text_color;
background: #$color;
background: -moz-linear-gradient(left, #ffffff 0%, #$color 100%);
background: -webkit-gradient(linear, left top, right top, color-stop(0%,#ffffff), color-stop(100%, #$color));
background: -webkit-linear-gradient(left, #ffffff 0%, #$color 100%);
background: -o-linear-gradient(left, #ffffff 0%, #$color 100%);
background: -ms-linear-gradient(left, #ffffff 0%, #$color 100%);
background: linear-gradient(to right, #ffffff 0%, #$color 100%);
}
";

    return preg_replace('/[\n\r\t]/', '', trim($css));
} //}}}

function func_orderstatuses_get_gradient_circle_css($name, $color, $for_ie = false)
{// {{{
    global $http_location;

    if (
        empty($color)
    ) {
        return '';
    }

    $color = strtolower($color);

/*
        $css = "
.$name {
background: #$color;
background: -moz-linear-gradient(top, #$color 0%, #ffffff 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #$color), color-stop(100%, #ffffff));
background: -webkit-linear-gradient(top, #$color 0%, #ffffff 100%);
background: -o-linear-gradient(top, #$color 0%, #ffffff 100%);
background: -ms-linear-gradient(top, #$color 0%, #ffffff 100%);
background: linear-gradient(to bottom, #$color 0%, #ffffff 100%);
}
";
*/
        $css = "
.$name {
background: #$color;
}
";

    return preg_replace('/[\n\r\t]/', '', trim($css));
} //}}}

function func_orderstatuses_get_email_pbar_css($name, $color, $for_ie = false)
{// {{{
    if (
        empty($color)
    ) {
        return '';
    }

    if ($for_ie) {

        $css = "
.$name div {
border-width: 0px 0px 3px 0px;
border-color: #$color;
border-style: solid;
width: 80%;
}
";

    } else {

        $css = "
.$name div {
border-width: 0px 0px 3px 0px;
border-color: #$color;
border-style: solid;
width: 80%;
}
";
    }

    return preg_replace('/[\n\r\t]/', '', trim($css));
} //}}}

function func_orderstatuses_rebuild_css()
{// {{{
    global $config, $xcart_dir, $smarty_skin_dir, $http_location;

    if ($config['XOrder_Statuses']['xostat_use_colors'] != 'Y') {
        return false;
    }

    $statuses_list = func_orderstatuses_list();

    $css_normal = "/* This file was automatically generated. Any changes done to this file will be automatically overridden. */\n";
    $css_mail   = "/* This file was automatically generated. Any changes done to this file will be automatically overridden. */\n";

    foreach($statuses_list as $status) {
        $status['active_color']   = ($config['XOrder_Statuses']['xostat_use_colors'] == 'Y') ? $status['color'] : '000000';
        $status['inactive_color'] = ($config['XOrder_Statuses']['xostat_use_colors'] == 'Y') ? $status['inactive_color'] : '888888';

/*
        $css_normal .= func_orderstatuses_get_gradient_pbar_css("xostatus-pbar-background-$status[css_name]-active", $status['active_color']) . "\n";
        $css_normal .= func_orderstatuses_get_gradient_pbar_css("xostatus-pbar-background-$status[css_name]-inactive", $status['inactive_color']) . "\n";

        $css_ie     .= func_orderstatuses_get_gradient_pbar_css("xostatus-pbar-background-$status[css_name]-active", $status['active_color'], true) . "\n";
        $css_ie     .= func_orderstatuses_get_gradient_pbar_css("xostatus-pbar-background-$status[css_name]-inactive", $status['inactive_color'], true) . "\n";
*/

        $css_normal .= func_orderstatuses_get_gradient_circle_css("xostatus-orderstatus-background-$status[css_name]", $status['active_color']) . "\n";

/*
        $css_mail   .= func_orderstatuses_get_email_pbar_css("xostatus-pbar-background-$status[css_name]-active", $status['active_color'], true) . "\n";
        $css_mail   .= func_orderstatuses_get_email_pbar_css("xostatus-pbar-background-$status[css_name]-inactive", $status['inactive_color'], true) . "\n";
*/
    }

    $fh = fopen($xcart_dir . $smarty_skin_dir . '/modules/XOrder_Statuses/css/main.pbar.css', 'w+');
    fwrite($fh, $css_normal, strlen($css_normal));
    fclose($fh);

    $fh = fopen($xcart_dir . $smarty_skin_dir . '/modules/XOrder_Statuses/css/admin.pbar.css', 'w+');
    fwrite($fh, $css_normal, strlen($css_normal));
    fclose($fh);

    $fh = fopen($xcart_dir . $smarty_skin_dir . '/modules/XOrder_Statuses/css/mail.pbar.css', 'w+');
    fwrite($fh, $css_mail, strlen($css_mail));
    fclose($fh);

    return false;
} //}}}

function func_orderstatuses_get_text_color($color)
{// {{{
    while (strlen($color) < 6)
    {
        $color = $color . 'f';
    }

    $r = base_convert('0x' . substr($color, 0, 2), 16, 10) / 255;
    $g = base_convert('0x' . substr($color, 2, 2), 16, 10) / 255;
    $b = base_convert('0x' . substr($color, 4, 2), 16, 10) / 255;

    $text_color = (0.213 * $r + 0.715 * $g + 0.072 * $b < 0.2) ? 'ffffff' : '585858';

    return $text_color;
} //}}}

function func_orderstatuses_embedd_css_content($params)
{// {{{
    global $xcart_dir, $smarty_skin_dir;

    if (
        !isset($params)
        || !is_array($params)
        || empty($params)
        || !isset($params['file'])
        || empty($params['file'])
    ) {
        return '';
    }

    $fname = $xcart_dir .  $smarty_skin_dir . '/' .  $params['file'];

    if (
        !is_readable($fname)
        || strpos('.css', $fname) !== false
    ) {
        return '';
    }

    $fh = fopen($fname, 'r');
    $content = fread($fh, filesize($fname));
    fclose($fh);

    $content = preg_replace('/\/\*.*/i', '', $content);
    $content = preg_replace('/\*.*/i', '', $content);
    $content = preg_replace('/.*\*\//i', '', $content);

    $content = trim($content);

    return "\n" . $content . "\n";
} //}}}

function func_orderstatuses_orders_list_prefilter($tpl_source, &$smarty)
{// {{{
    if (
        strpos(
            $tpl_source,
            '<a href="order.php?orderid={$order.orderid}"><strong>{include file="main/order_status.tpl" status=$order.status mode="static"}</strong></a>'
        ) !== false
    ) {
        $tpl_source = str_replace(
            '<a href="order.php?orderid={$order.orderid}"><strong>{include file="main/order_status.tpl" status=$order.status mode="static"}</strong></a>',
            '{include file="modules/XOrder_Statuses/show_static_status_link.tpl" status=$order.status orderid=$order.orderid}',
            $tpl_source
        );

    } elseif (
        strpos(
            $tpl_source,
            '<a href="order.php?orderid={$orders[oid].orderid}"><b>{include file="main/order_status.tpl" status=$orders[oid].status mode="static"}</b></a>'
        ) !== false
    ) {
        $tpl_source = str_replace(
            '<a href="order.php?orderid={$orders[oid].orderid}"><b>{include file="main/order_status.tpl" status=$orders[oid].status mode="static"}</b></a>',
            '{include file="modules/XOrder_Statuses/show_static_status_link.tpl" status=$orders[oid].status orderid=$orders[oid].orderid}',
            $tpl_source
        );
    }

    return $tpl_source;
} //}}}
?>
