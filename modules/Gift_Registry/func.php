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
 * Gift Registry module functions
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v41 (xcart_4_7_7), 2017-01-24 09:29:34, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../../"); die("Access denied"); }

/**
 * Returns the events list for the certain customer
 */
function func_giftreg_get_events_list($userid, $detailed=false)
{
    global $sql_tbl;

    $events_list = func_query("SELECT $sql_tbl[giftreg_events].*, $sql_tbl[customers].firstname, $sql_tbl[customers].lastname, $sql_tbl[customers].email FROM $sql_tbl[giftreg_events], $sql_tbl[customers] WHERE $sql_tbl[customers].id=$sql_tbl[giftreg_events].userid AND $sql_tbl[giftreg_events].userid='$userid' ORDER BY $sql_tbl[giftreg_events].event_date");

    if (!empty($events_list) && $detailed) {
        foreach ($events_list as $k=>$v) {
            $events_list[$k]['emails'] = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[giftreg_maillist] WHERE event_id='$v[event_id]'");
            $events_list[$k]['allow_to_send'] = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[giftreg_maillist] WHERE event_id='$v[event_id]' AND status='Y'");
            $events_list[$k]['products'] = func_query_first_cell("SELECT COUNT($sql_tbl[wishlist].event_id) FROM $sql_tbl[wishlist], $sql_tbl[products] WHERE $sql_tbl[wishlist].userid='$userid' AND $sql_tbl[wishlist].event_id='$v[event_id]' AND $sql_tbl[wishlist].productid = $sql_tbl[products].productid AND $sql_tbl[products].forsale <> 'N'");

            if ($v['guestbook'] == 'Y') {
                $events_list[$k]['gb_count'] = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[giftreg_guestbooks] WHERE event_id='$v[event_id]'");
            }
        }
    }
    return $events_list;
}

/**
 * Returns event data
 */
function func_giftreg_get_event_data($eventid)
{
    global $sql_tbl;

    return func_query_first("SELECT $sql_tbl[giftreg_events].*, $sql_tbl[customers].title AS creator_title, $sql_tbl[customers].firstname, $sql_tbl[customers].lastname FROM $sql_tbl[giftreg_events], $sql_tbl[customers] WHERE $sql_tbl[customers].id=$sql_tbl[giftreg_events].userid AND event_id='$eventid'");
}

/**
 * Returns eventid by wishlistid
 */
function func_giftreg_get_eventid($wishlistid)
{
    global $sql_tbl;

    return func_query_first_cell("SELECT $sql_tbl[giftreg_events].event_id FROM $sql_tbl[wishlist], $sql_tbl[giftreg_events] WHERE $sql_tbl[wishlist].wishlistid = '$wishlistid' AND $sql_tbl[giftreg_events].event_id = $sql_tbl[wishlist].event_id");
}

?>
