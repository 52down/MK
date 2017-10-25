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
 * Functions for ShippingEasy module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Alexey Zakharov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    1570ad059fc3dd81e1e3723f1770f61d5e2c6d59, v2 (xcart_4_7_8), 2017-06-01 15:37:47, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header('Location: ../../'); die('Access denied'); }

function func_shippingeasy_init() {//{{{
    if (!function_exists('func_shippingeasy_load_class')) {
        function func_shippingeasy_load_class($class_name) {
            global $xcart_dir;

            static $shippingEasyClasses = array(
                'ShippingEasy'                     => 'lib/ShippingEasy/ShippingEasy.php',
                'ShippingEasy_Error'               => 'lib/ShippingEasy/Error.php',
                'ShippingEasy_ApiError'            => 'lib/ShippingEasy/ApiError.php',
                'ShippingEasy_ApiConnectionError'  => 'lib/ShippingEasy/ApiConnectionError.php',
                'ShippingEasy_AuthenticationError' => 'lib/ShippingEasy/AuthenticationError.php',
                'ShippingEasy_InvalidRequestError' => 'lib/ShippingEasy/InvalidRequestError.php',
                'ShippingEasy_ApiRequestor'        => 'lib/ShippingEasy/ApiRequestor.php',
                'ShippingEasy_Authenticator'       => 'lib/ShippingEasy/Authenticator.php',
                'ShippingEasy_Object'              => 'lib/ShippingEasy/Object.php',
                'ShippingEasy_Order'               => 'lib/ShippingEasy/Order.php',
                'ShippingEasy_Signature'           => 'lib/ShippingEasy/Signature.php',
                'ShippingEasy_SignedUrl'           => 'lib/ShippingEasy/SignedUrl.php',
                'ShippingEasy_Cancellation'        => 'lib/ShippingEasy/Cancellation.php',
            );

            if (
                isset($shippingEasyClasses[$class_name])
            ) {
                include $xcart_dir . XC_DS . 'modules' . XC_DS . SHIPPING_EASY . XC_DS . $shippingEasyClasses[$class_name];
            }
        }
    }

    spl_autoload_register('func_shippingeasy_load_class');
} //}}}

/**
 * Adding an order
 */
function func_shippingeasy_create_order($orderid, $skip_status_check = false) { //{{{
    global $config, $sql_tbl;

    $api_key       = $config['ShippingEasy']['shippingeasy_api_key'];
    $api_secret    = $config['ShippingEasy']['shippingeasy_api_secret'];
    $store_api_key = $config['ShippingEasy']['shippingeasy_store_api_key'];

    if (
        empty($api_key)
        || empty($api_secret)
        || empty($store_api_key)
        || !$orderid
    ) {
        return false;
    }

    $already_exported = func_query_first_cell("SELECT status FROM $sql_tbl[shippingeasy_order_status] WHERE orderid = '$orderid'");
    if ($already_exported == 'Y') {
        return false;
    }

    if ($skip_status_check) {
        $shippingeasy_status = 'awaiting_shipment';
    } else {
        $shippingeasy_status = func_shippingeasy_status_check($orderid);
        if (empty($shippingeasy_status)) {
            return false;
        }
    }

    ShippingEasy::setApiKey($api_key);
    ShippingEasy::setApiSecret($api_secret);

    if ($config['ShippingEasy']['shippingeasy_staging_account'] == 'Y') {
        ShippingEasy::setApiBase('https://staging.shippingeasy.com');
    }

    $order_data = func_order_data($orderid);
    $order = $order_data['order'];
    $products = $order_data['products'];

    $data = array(
        'external_order_identifier' => $orderid,
        'ordered_at' => date('Y-m-d H:i:s', $order['date']),
        'order_status' => $shippingeasy_status,
        'total_including_tax' => price_format($order['total']),
        'subtotal_including_tax' => price_format($order['subtotal']),
        'total_tax' => price_format($order['tax']),
        'discount_amount' => price_format($order['discount']),
        'coupon_discount' => price_format($order['coupon_discount']),
        'base_handling_cost' => 0.00,
        'handling_cost_excluding_tax' => 0.00,
        'handling_cost_including_tax' => 0.00,
        'handling_cost_tax' => 0.00,
        'base_shipping_cost' => price_format($order['shipping_cost']),
        'base_wrapping_cost' => 0.00,
        'wrapping_cost_including_tax' => 0.00,
        'wrapping_cost_excluding_tax' => 0.00,
        'wrapping_cost_tax' => 0.00,
        'shipping_cost_including_tax' => price_format($order['shipping_cost']),
        'notes' => $order['customer_notes'],
        'billing_company' => $order['company'],
        'billing_first_name' => $order['b_firstname'],
        'billing_last_name' => $order['b_lastname'],
        'billing_address' => $order['b_address'],
        'billing_address2' => $order['b_address_2'],
        'billing_city' => $order['b_city'],
        'billing_state' => $order['b_state'],
        'billing_postal_code' => $order['b_zipcode'],
        'billing_country' => $order['b_country'],
        'billing_phone_number' => $order['b_phone'],
        'billing_email' => $order['email'],
        'recipients' => array(
            array(
                'first_name' => $order['s_firstname'],
                'last_name' => $order['s_lastname'],
                'company' => $order['company'],
                'email' => $order['email'],
                'phone_number' => $order['s_phone'],
                'residential' => 'true',
                'address' => $order['s_address'],
                'address2' => $order['s_address_2'],
                'province' => '',
                'state' => $order['s_state'],
                'city' => $order['s_city'],
                'postal_code' => $order['s_zipcode'],
                'postal_code_plus_4' => '',
                'country' => $order['s_country'],
                'shipping_method' => $order['shipping'],
                'base_cost' => price_format($order['subtotal']),
                'cost_including_tax' => price_format($order['subtotal']),
                'base_handling_cost' => 0.00,
                'handling_cost_excluding_tax' => 0.00,
                'handling_cost_including_tax' => 0.00,
                'handling_cost_tax' => 0.00,
                'items_total' => count($products),
                'items_shipped' => 0,
                'line_items' => array()
            )
        )
    );

    foreach ($products as $p) {
        $product = array(
            'item_name' => $p['product'],
            'sku' => $p['productcode'],
            'bin_picking_number' => 'N/A',
            'unit_price' => price_format($p['price']),
            'total_excluding_tax' => price_format($p['price']),
            'weight_in_ounces' => price_format($p['weight'] * ($config['General']['weight_symbol_grams'] / 28.3495231)),
            'product_options' => array(),
            'quantity' => $p['amount']
        );

        if (!empty($p['product_options'])) {
            foreach ($p['product_options'] as $po) {
                $product['product_options'][$po['classtext']] = $po['option_name'];
            }
        }

        $data['recipients'][0]['line_items'][] = $product;
    }

    try {
        $shippingeasy_order = new ShippingEasy_Order($store_api_key, $data);
        $result = $shippingeasy_order->create();

        db_query("REPLACE INTO $sql_tbl[shippingeasy_order_status] (orderid, status) VALUES ('$orderid', 'Y')");
        return true;
    } catch (Exception $e) {
        x_log_add('shippingeasy', 'Error exporting order #' . $orderid);
        x_log_add('shippingeasy', $e);
        return false;
    }
} //}}}

function func_shippingeasy_status_check($orderid) { //{{{
    global $sql_tbl;

    $statuses = func_shippingeasy_get_statuses();
    $allowed_statuses = array_keys($statuses);
    $order_status = func_query_first_cell("SELECT status FROM $sql_tbl[orders] WHERE orderid = '$orderid'");

    if (in_array($order_status, $allowed_statuses)) {
        return $statuses[$order_status];
    } else {
        return false;
    }
} //}}}

function func_shippingeasy_cancel_order($orderid) { //{{{
    global $config, $sql_tbl;

    $can_be_cancelled = func_query_first_cell("SELECT status FROM $sql_tbl[shippingeasy_order_status] WHERE orderid = '$orderid'");

    if ($can_be_cancelled == 'Y') {
        $api_key       = $config['ShippingEasy']['shippingeasy_api_key'];
        $api_secret    = $config['ShippingEasy']['shippingeasy_api_secret'];
        $store_api_key = $config['ShippingEasy']['shippingeasy_store_api_key'];

        if (
            empty($api_key)
            || empty($api_secret)
            || empty($store_api_key)
        ) {
            return false;
        }

        ShippingEasy::setApiKey($api_key);
        ShippingEasy::setApiSecret($api_secret);

        if ($config['ShippingEasy']['shippingeasy_staging_account'] == 'Y') {
            ShippingEasy::setApiBase('https://staging.shippingeasy.com');
        }

        try {
            $cancellation = new ShippingEasy_Cancellation($store_api_key, $orderid);
            $cancellation->create();

            db_query("REPLACE INTO $sql_tbl[shippingeasy_order_status] (orderid, status) VALUES ('$orderid', 'C')");
        } catch (Exception $e) {
            x_log_add('shippingeasy', 'Error cancelling order #' . $orderid);
            x_log_add('shippingeasy', $e);
        }
    }
} //}}}

function func_shippingeasy_get_statuses() { //{{{
    global $sql_tbl;

    $statuses = array();
    $_statuses = func_query("SELECT x_status, se_status FROM $sql_tbl[shippingeasy_statuses] WHERE 1 ORDER BY id");
    if (!empty($_statuses)) {
        foreach ($_statuses as $s) {
            $statuses[$s['x_status']] = $s['se_status'];
        }
    }

    return $statuses;
} //}}}

function func_shippingeasy_is_already_exported($orderid) { //{{{
    global $sql_tbl;

    if (!$orderid) {
        return false;
    }

    $already_exported = func_query_first_cell("SELECT status FROM $sql_tbl[shippingeasy_order_status] WHERE orderid = '$orderid'");
    if ($already_exported == 'Y') {
        return true;
    }

    return false;
} //}}}

function func_shippingeasy_tpl_get_se_export_status($orderid) { //{{{
    global $sql_tbl;
    return func_query_first_cell("SELECT status FROM $sql_tbl[shippingeasy_order_status] WHERE orderid = " . intval($orderid));
} //}}}
