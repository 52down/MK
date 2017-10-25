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
 * Shop statistics interface
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v65 (xcart_4_7_7), 2017-01-24 09:29:34, atracking.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../"); die("Access denied"); }

$start_date_off = $start_date - $config["Appearance"]["timezone_offset"];
$end_date_off = $end_date - $config["Appearance"]["timezone_offset"];
$date_condition = "(date>='$start_date_off' AND date<='$end_date_off')";

if ($mode == 'logins') {
/**
 * Display login history
 */
    $location[] = array(func_get_langvar_by_name('lbl_log_in_history'), '');

    $start_date_off = $start_date - $config["Appearance"]["timezone_offset"];
    $end_date_off = $end_date - $config["Appearance"]["timezone_offset"];
    $date_condition = "($sql_tbl[login_history].date_time>='$start_date_off' AND $sql_tbl[login_history].date_time<='$end_date_off')";

    if ($REQUEST_METHOD == 'POST') {

    // Delete log in history

        if ($action == 'delete') {
            db_query("DELETE FROM $sql_tbl[login_history] WHERE ".$date_condition);
            $top_message['content'] = func_get_langvar_by_name('msg_adm_loginhistory_range_del');
        }
        elseif ($action == 'delete_all') {
            db_query("DELETE FROM $sql_tbl[login_history]");
            $top_message['content'] = func_get_langvar_by_name('msg_adm_loginhistory_all_del');
        }
        func_header_location("statistics.php?".$QUERY_STRING);
    }

    $statistics = func_query("SELECT $sql_tbl[login_history].*,INET_NTOA($sql_tbl[login_history].ip) as s_ip, $sql_tbl[customers].login FROM $sql_tbl[login_history], $sql_tbl[customers] WHERE $sql_tbl[login_history].userid = $sql_tbl[customers].id AND ".$date_condition." ORDER BY date_time DESC");
    if (!empty($statistics)) {
        foreach ($statistics as $k=>$v) {
            $statistics[$k]['date_time'] += $config['Appearance']['timezone_offset'];
        }
    }
}
else {
    $location[count($location)-1][1] = '';
}

$smarty->assign('mode', $mode);
$smarty->assign('start_date', $start_date);
$smarty->assign('end_date', $end_date);
$smarty->assign('statistics', $statistics);
$smarty->assign('main','atracking');

?>
