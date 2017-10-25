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
 * @version    498558a93b7a62d6ecee14fa8f2b3bdec954976a, v12 (xcart_4_7_8), 2017-03-21 13:31:00, order_statuses.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../"); die("Access denied"); }

if ($REQUEST_METHOD == 'POST') {

    x_session_register('top_message');

    if ($mode == 'update' && isset($statuses) && is_array($statuses)) {
        // Update the statuses list
        foreach ($statuses as $id => $status) {

            func_orderstatuses_update($id, $status);
        }

        func_orderstatuses_rebuild_css();

        $top_message['type'] = 'I';
        $top_message['content'] = func_get_langvar_by_name('txt_xostat_order_status_updated');
    }

    if ($mode == 'update' && isset($add_status) && is_array($add_status) && !empty($add_status['name'])) {
        // Add new order status
        func_orderstatuses_add($add_status);

        func_orderstatuses_rebuild_css();

        $top_message['type'] = 'I';
        $top_message['content'] = func_get_langvar_by_name('txt_xostat_order_status_created');
    }

    if ($mode == 'delete' && isset($delete_status) && is_array($delete_status))
    {
        foreach ($delete_status as $statusid) {

            func_orderstatuses_delete_status($statusid);
        }

        func_orderstatuses_rebuild_css();

        $top_message['type'] = 'I';
        $top_message['content'] = func_get_langvar_by_name('txt_xostat_order_status_removed');
    }

    func_header_location('xorder_statuses.php');
} // $REQUEST_METHOD == 'POST'

$statuses = func_orderstatuses_list(false, null, null, null, 'get_total_count');
$smarty->assign('order_statuses', $statuses);
$smarty->assign('new_orderby', func_orderstatuses_get_maxorderby(10));

?>
