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
 * Tracking number import
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v33 (xcart_4_7_7), 2017-01-23 20:12:10, orders_tracking.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../"); die("Access denied"); }

x_load('files');

$delimiters = array (";", ",", "\t");
$import_file = func_move_uploaded_file('userfile');

if ($import_file == '') {
    $top_message['content'] = func_get_langvar_by_name('txt_import_error');
    $top_message['type'] = 'E';
    func_header_location('orders.php');
}

$fp = @fopen($import_file, 'r');
foreach ($delimiters as $delimiter) {
    $parced_data = array();
    while (($data = @fgetcsv($fp, 1024,$delimiter)) !== false) {
        if (count($data) < 2) {
            func_unset($parced_data);
            break;
        }
        $data = func_array_map('trim', $data);
        $parced_data[] = $data;
    }

    if (!empty($parced_data))
        break;

    @rewind($fp);
}
@fclose($fp);

if (!empty($parced_data)) {
    foreach ($parced_data[0] as $key=>$data) {
        if ($data == 'PackageTrackingNumber') {
            $tracking_key = $key;
        }
        if ($data == 'PackageReference1') {
            $order_key = $key;
        }
    }
}

if (!isset($order_key) || !isset($tracking_key)) {
    $top_message['content'] = func_get_langvar_by_name('txt_import_error');
    $top_message['type'] = 'E';
    func_header_location('orders.php');
}

x_load('order');//For XCORderTracking

$provider_condition = (($single_mode || $login_type == 'A') ? "WHERE" : ", $sql_tbl[order_details] WHERE $sql_tbl[orders].orderid=$sql_tbl[order_details].orderid AND $sql_tbl[order_details].provider='$logged_userid' AND");

$log = $tracking_ids2update = array();
foreach ($parced_data as $key=>$data) {
    if ($key == 0) {
        continue;
    }
    $order_id = intval($data[$order_key]);
    $tracking_id = $data[$tracking_key];
    $log[$key]['orderid'] = $order_id;
    $log[$key]['trackingid'] = $tracking_id;
    if (intval($order_id) == 0) {
        $log[$key]['status'] = false;
        continue;
    }
    $order_access_allow = func_query_first_cell("SELECT orderid FROM $sql_tbl[orders] $provider_condition $sql_tbl[orders].orderid='$order_id'");
    if (!$order_access_allow) {
        $log[$key]['status'] = false;
        continue;
    }

    if (empty($tracking_id)) {
        XCOrderTracking::delete($order_id);
    } else {
        $tracking_ids2update[] = array('orderid' => $order_id, 'tracking' => addslashes($tracking_id));
    }

    $log[$key]['status'] = true;

    if (!empty($active_modules['AfterShip'])) {

        func_aftership_set_tracking($tracking_id);
    }
}

XCOrderTracking::replace_multiple($tracking_ids2update);

unlink($import_file);

$smarty->assign('log', $log);
$smarty->assign('main','ups_import');

$location[] = array(func_get_langvar_by_name('lbl_orders_management'), 'orders.php');
$location[] = array(func_get_langvar_by_name('lbl_import_trackingid_log'), '');

// Assign the current location line
$smarty->assign('location', $location);

if (is_readable($xcart_dir.'/modules/gold_display.php')) {
    include $xcart_dir.'/modules/gold_display.php';
}
func_display('admin/home.tpl', $smarty);

exit;

?>
