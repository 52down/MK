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
 * Collect infos about ordered products
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    be9581a5c8bee4302a16debb9e0897116cdf6192, v97 (xcart_4_7_8), 2017-04-03 20:33:15, history_order.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../"); die("Access denied"); }

x_load('order');

if (empty($mode)) $mode = '';

if ('xpdf_invoice' == $mode) {

    if (!empty($active_modules['XPDF'])) {
        $orders = explode(',', $orderid);
        xpdf_display_invoices($orders);
    }
    func_page_not_found($current_area);

} elseif (
    in_array(
        $mode,
        array(
            'invoice',
            'label',
            'history',
            'packing_slip',
        )
    )
) {

    $charset = $smarty->getTemplateVars('default_charset');
    $charset_text = ($charset)
        ? "; charset=$charset"
        : '';

    header("Content-Type: text/html$charset_text");
    header("Content-Disposition: inline; filename=invoice.txt");

    $orders = explode(",", $orderid);

    if ($orders) {

        $orders_data = array();
        settype($access_key, 'string');

        foreach ($orders as $orderid) {

            $order_data = func_order_data($orderid);

            if (empty($order_data))
                continue;

            // Security check if order owned by another customer
            if (
                $current_area == 'C'
                && !func_order_check_owner($order_data, $access_key)
            ) {
                func_403(34);
            }

            $order     = $order_data['order'];
            $customer  = $order_data['userinfo'];
            $giftcerts = $order_data['giftcerts'];
            $products  = $order_data['products'];

            $orders_data[] = array (
                'order'     => $order,
                'customer'  => $customer,
                'products'  => $products,
                'giftcerts' => $giftcerts,
            );
        }

        if (empty($orders_data)) {
            func_page_not_found($current_area);
        }

        $smarty->assign('orders_data', $orders_data);

        $_tmp_smarty_debug = $smarty->debugging;
        $smarty->debugging = false;

        if (
            $mode == 'history'
            && !empty($active_modules['Advanced_Order_Management'])
        ) {

            include $xcart_dir.'/modules/Advanced_Order_Management/history.php';

            $smarty->assign('history',$order['history']);

            func_display('modules/Advanced_Order_Management/popup_history.tpl',$smarty);

        } elseif ($mode == 'invoice') {

            if (defined('IS_ADMIN_USER')) {

                if (!empty($active_modules['XMultiCurrency'])) {

                    define('ADMIN_INVOICE', TRUE);
                }

                $smarty->assign('show_order_details', 'Y');
            }

            func_display('main/order_invoice_print.tpl',$smarty);

        } elseif ($mode == 'label') {

            func_display('main/order_labels_print.tpl',$smarty);

        } elseif ($mode == 'packing_slip') {

            func_display('main/order_packing_slip_print.tpl',$smarty);

        }

        $smarty->debugging = $_tmp_smarty_debug;
    }

    exit;

} else {

    $order_data = func_order_data($orderid);

    $split_checkout_data = func_get_split_checkout_order_data_by_orderid($orderid);

    if (false !== $split_checkout_data) {

        $smarty->assign('split_checkout_data', $split_checkout_data);

        $order_data['order']['payment_method'] = $split_checkout_data['payment_method'] . ', ' . $order_data['order']['payment_method'];

    }

    if (empty($order_data)) {
        func_page_not_found($current_area);
    }

    $shippingid = $order_data['order']['shippingid'];
    $ship_code = func_query_first_cell("SELECT code FROM $sql_tbl[shipping] WHERE shippingid='$shippingid'");

    if ($ship_code == 'DHL') {

        $dhl_account = func_query_first_cell("SELECT value FROM $sql_tbl[order_extras] WHERE orderid='$orderid' AND khash='dhl_account'");

        $smarty->assign('dhl_account', $dhl_account);
        $smarty->assign('is_ship_DHL', true);
    }

    if ($ship_code == '1800C') {
        $smarty->assign('ship_code', $ship_code);
    }

    settype($access_key, 'string');
    // Security check if order owned by another customer
    if (
        $current_area == 'C'
        && !func_order_check_owner($order_data, $access_key)
    ) {
        func_403(35);
    }

    if (!empty($active_modules['XPayments_Subscriptions'])) {
        $subscriptions_info = func_xps_getSubscriptionsByOrderId($orderid);
        $smarty->assign('subscriptions_info', $subscriptions_info);
    }

    if (//Special_Offers related data need to be moved to separate table
        !empty($order_data['order']['extra']['applied_offers'])
        && empty($config['applied_offers_need2be_converted'])
    ) {
        //toggle util on the tools.php page
        func_array2insert('config', array('name' => 'applied_offers_need2be_converted', 'value' => true), true);
    }

    $smarty->assign('order_details_fields_labels', func_order_details_fields_as_labels());
    $smarty->assign('order',                       $order_data['order']);
    $smarty->assign('customer',                    $order_data['userinfo']);
    $smarty->assign('products',                    $order_data['products']);
    $smarty->assign('giftcerts',                   $order_data['giftcerts']);

    if (
        $order_data
        && !empty($login)
    ) {

        if ($current_area == 'C') {
            // check customer's perms for next/prev orders
            $where[] = "$sql_tbl[orders].userid = '" . $logged_userid . "'";

        } elseif (
                $current_area == 'P'
                && !$single_mode
        ) {
            // check provider's perms for next/prev orders
            $joins = array("INNER JOIN $sql_tbl[order_details] ON $sql_tbl[order_details].orderid=$sql_tbl[orders].orderid");
            $where[] = "$sql_tbl[order_details].provider = '" . $logged_userid . "'";
            $distinct = 'DISTINCT';

        } else {
            // full access for admins for next/prev orders
            $joins = $where = array();
        }

        $where = empty($where) ? '' : (" AND " . implode(" AND ", $where));
        $joins = empty($joins) ? '' : implode(" ", $joins);
        $distinct = empty($distinct) ? '' : $distinct;

        x_session_register('search_data', array());

        settype($search_data['orders'], 'array');
        $search_condition = isset($search_data['orders']['search_condition']) ? $search_data['orders']['search_condition'] : '';

        // find next
        if (!empty($search_condition)) {

            $tmp = func_query_first_cell("SELECT $sql_tbl[orders].orderid ".$search_condition." AND $sql_tbl[orders].orderid > '" . $orderid . "' GROUP BY $sql_tbl[orders].orderid ORDER BY $sql_tbl[orders].orderid ASC");

        } else {
            $tmp = func_query_first_cell("SELECT $distinct $sql_tbl[orders].orderid FROM $sql_tbl[orders] $joins WHERE $sql_tbl[orders].orderid > '" . $orderid . "' $where ORDER BY $sql_tbl[orders].orderid ASC");
        }

        if (!empty($tmp))
            $smarty->assign('orderid_next', $tmp);

        // find prev
        if (!empty($search_condition)) {

            $tmp = func_query_first_cell("SELECT $sql_tbl[orders].orderid " . $search_condition . " AND $sql_tbl[orders].orderid < '" . $orderid . "' GROUP BY $sql_tbl[orders].orderid ORDER BY $sql_tbl[orders].orderid DESC");

        } else {
            $tmp = func_query_first_cell("SELECT $distinct $sql_tbl[orders].orderid FROM $sql_tbl[orders] $joins WHERE $sql_tbl[orders].orderid < '" . $orderid . "' $where ORDER BY $sql_tbl[orders].orderid DESC");
        }

        if (!empty($tmp)) {
            $smarty->assign('orderid_prev', $tmp);
        }

        if (isset($search_data['orders'])) {
            $smarty->assign('search_data_orders', $search_data['orders']);
        }
    }
}

if (
    $order_data
    && $mode == 'view_cnote'
) {

    $default_charset = $e_langs[$order_data['order']['language']];

    if ($default_charset) {

        $smarty->assign('default_charset',     $default_charset);
        $smarty->assign('current_language', $order_data['order']['language']);

        header("Content-Type: text/html; charset=" . $default_charset);
        header("Content-Language: " . $order_data['order']['language']);

    }

    func_display('main/order_view_cnotes.tpl', $smarty);
    exit;
}

$location[] = array(func_get_langvar_by_name('lbl_orders_management'), 'orders.php');
$location[] = array(func_get_langvar_by_name('lbl_order_details_location', array('orderid' => intval($orderid))), '');

if(!empty($active_modules['RMA'])) {
    include $xcart_dir . '/modules/RMA/add_returns.php';
}

if(!empty($active_modules['Anti_Fraud'])) {
    include $xcart_dir . '/modules/Anti_Fraud/order.php';
}

// Prepare XPayments_Connector config vars for skin/common_files/main/history_order.tpl
if (!empty($active_modules['XPayments_Connector'])) {
    func_xpay_func_load();
    $config['XPayments_Connector'] = xpc_prepare_config_vars($config['XPayments_Connector']);
    $smarty->assignByRef('config', $config);
}  

if (!empty($active_modules['POS_System'])) {
    $smarty->assign('pos_receipts', func_pos_get_receipts($orderid));
}

?>
