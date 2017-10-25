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
 * ShippingEasy callback script
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Customer interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    1570ad059fc3dd81e1e3723f1770f61d5e2c6d59, v2 (xcart_4_7_8), 2017-06-01 15:37:47, shippingeasy_callback.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

define('SKIP_COOKIE_CHECK', true);

require './auth.php';

$values = file_get_contents('php://input');
$output = json_decode($values, true);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$authenticator = new ShippingEasy_Authenticator('POST', $path, $_GET, $output, $config['ShippingEasy']['shippingeasy_api_secret']);
if (!$authenticator->isAuthenticated()) {
    func_403();
}

$orderid = $output['shipment']['orders'][0]['external_order_identifier'];
$shipping_id = $output['shipment']['id'];
$tracking_number = $output['shipment']['tracking_number'];
$carrier_key = $output['shipment']['carrier_key'];
$carrier_service_key = $output['shipment']['carrier_service_key'];
$shipment_cost_cents = $output['shipment']['shipment_cost'];
$shipment_cost = price_format($shipment_cost_cents / 100);

$note_update = 'Shipping Tracking Number: ' . $tracking_number . "\nCarrier Key: " . $carrier_key . "\nCarrier Service Key: " . $carrier_service_key . "\nCost: " . $shipment_cost;

$shipped_items = $output['shipment']['orders'][0]['recipients'][0]['line_items'];
if (!empty($shipped_items)) {
    $shipped_items2update = array();
    foreach ($shipped_items as $item) {
        $itemid = func_query_first_cell("SELECT itemid FROM $sql_tbl[order_details] WHERE orderid = '$orderid' AND productcode = '$item[sku]'");
        if ($itemid) {
            $shipped_items2update[] = array('itemid' => $itemid);
        }
    }

    if (!empty($shipped_items2update)) {
        func_array2insert_multiple($sql_tbl['shippingeasy_shipped_order_items'], $shipped_items2update, 'use_replace');
    }
}

x_load('order');//For XCORderTracking
$items_unshipped = func_query_first_cell("SELECT od.itemid FROM $sql_tbl[order_details] as od LEFT JOIN $sql_tbl[shippingeasy_shipped_order_items] as ssoi ON (od.itemid = ssoi.itemid) WHERE od.orderid = '$orderid' AND ssoi.itemid IS NULL");
if ($items_unshipped) {
    func_change_order_status($orderid, 'S'); // Partially shipped
} else {
    func_change_order_status($orderid, 'C');
}

XCOrderTracking::replace($orderid, addslashes($tracking_number));

$notes = func_query_first_cell("SELECT notes FROM $sql_tbl[orders] WHERE orderid = '$orderid'");
$new_notes = (!empty($notes)) ? ($notes . "\n\n" . $note_update) : $note_update;
db_query("UPDATE $sql_tbl[orders] SET notes = '" . addslashes($new_notes)  . "' WHERE orderid = '$orderid'");

die('Order has been updated successfully');
