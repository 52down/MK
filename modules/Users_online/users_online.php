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
 * Users online
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v38 (xcart_4_7_7), 2017-01-24 09:29:34, users_online.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../../"); die("Access denied"); }

$where_condition = '';

if (
    $current_area == 'C'
    || empty($login)
) {

    $users_online = func_query("SELECT usertype, COUNT(*) as count, is_registered FROM $sql_tbl[users_online] WHERE usertype = 'C' GROUP BY is_registered ORDER BY NULL");

} else {

    if (
        $current_area == 'P'
        && empty($active_modules['Simple_Mode'])
    ) {

        $where_condition = " AND usertype IN ('C', 'P')";

    } elseif ($current_area == 'B') {

        $where_condition = " AND usertype IN ('C', 'B')";
    }

    $users_online = func_query("SELECT usertype, COUNT(*) as count, is_registered FROM $sql_tbl[users_online] WHERE IF(usertype = 'C', 'Y', is_registered) = 'Y' " . $where_condition . " GROUP BY usertype, IF(usertype = 'C', is_registered, '') ORDER BY NULL");
}


if (
    !empty($active_modules['Simple_Mode'])
    && (
        $current_area == 'P'
        || $current_area == 'A'
    )
    && $users_online
) {
    $count = 0;

    foreach($users_online as $k => $v) {

        if (
            $v['usertype'] == 'P'
            || $v['usertype'] == 'A'
        ) {

            $count += $v['count'];

            unset($users_online[$k]);

        }

    }

    $users_online[] = array(
        'usertype'     => 'A',
        'count'     => $count,
    );

}

if (!empty($users_online)) {

    $smarty->assign('users_online', $users_online);

    $container_classes[] = "uo-container";

}

?>
