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
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    abb7bdb4113eb817a1fd17d3569538080df45f5d, v15 (xcart_4_7_8), 2017-05-30 16:33:09, xps_subscriptions.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require __DIR__.'/auth.php';

include $xcart_dir . '/include/common.php';

if (empty($logged_userid)) {
    func_403(104);
}

if (empty($active_modules['XPayments_Subscriptions'])) {
    func_403(105);
}

if ('POST' === $REQUEST_METHOD) {
    if (
        ('attach_card' === $mode)
        && !empty($_POST['subscription_id'])
        && !empty($_POST['card_id'])
    ) {
        $saved_cards = xpc_get_saved_cards($logged_userid);
        $subscription = func_query_first("SELECT $sql_tbl[xps_subscriptions].* FROM $sql_tbl[xps_subscriptions] JOIN $sql_tbl[orders] ON $sql_tbl[xps_subscriptions].orderid = $sql_tbl[orders].orderid WHERE $sql_tbl[orders].userid = '$logged_userid' AND $sql_tbl[xps_subscriptions].subscriptionid =" . $_POST['subscription_id']);

        if (
            array_key_exists($_POST['card_id'], $saved_cards)
            && $subscription
        ) {
            func_array2update(
                'xps_subscriptions',
                array(
                    'cardid' => $_POST['card_id']
                ),
                'subscriptionid = ' . $_POST['subscription_id']
            );

            $top_message = array(
                'type'    => 'I',
                'content' => func_get_langvar_by_name('txt_xps_card_used_for_subscription_updated'),
            );

            func_header_location('xps_subscriptions.php');
        }
    }
}// if ('PoST' === $REQUeST_METHOD)

if (isset($subscriptionid)) {
    $subscription = func_query_first("SELECT $sql_tbl[xps_subscriptions].* FROM $sql_tbl[xps_subscriptions] JOIN $sql_tbl[orders] ON $sql_tbl[xps_subscriptions].orderid = $sql_tbl[orders].orderid WHERE $sql_tbl[orders].userid = '$logged_userid' AND $sql_tbl[xps_subscriptions].subscriptionid = '$subscriptionid'");

    if (empty($subscription)) {
        func_403();
    }

    x_load('product');

    $subscription['product'] = func_select_product($subscription['productid'], @$user_account['membershipid']);
    $subscription['desc'] = func_xps_getDesc($subscription);
    $subscription['dates'] = htmlentities(json_encode(func_xps_getSubscriptionDates($subscription)));
    $smarty->assign('subscription', $subscription);

    $template_name = 'modules/XPayments_Subscriptions/customer/calendar.tpl';
    $smarty->assign('template_name', $template_name);

    func_display('customer/help/popup_info.tpl', $smarty);

    exit;
}

$subscriptions = func_query("SELECT $sql_tbl[xps_subscriptions].* FROM $sql_tbl[xps_subscriptions] JOIN $sql_tbl[orders] ON $sql_tbl[xps_subscriptions].orderid = $sql_tbl[orders].orderid WHERE $sql_tbl[orders].userid = '$logged_userid' AND $sql_tbl[xps_subscriptions].status != 'N' ORDER BY FIELD($sql_tbl[xps_subscriptions].status, 'A', 'S', 'F'), $sql_tbl[xps_subscriptions].real_next_date");

if ($subscriptions) {

    x_load('product');

    $saved_cards = xpc_get_saved_cards($logged_userid);

    foreach ($subscriptions as $k => $subscription) {
        $subscriptions[$k]['product'] = func_select_product($subscription['productid'], @$user_account['membershipid']);

        $subscriptions[$k]['desc'] = func_xps_getDesc($subscription);

        $subscriptions[$k]['card_details'] = array_key_exists($subscription['cardid'], $saved_cards) ? $saved_cards[$subscription['cardid']] : null;
    }

    $smarty->assign('saved_cards', $saved_cards);
}

$smarty->assign('subscriptions', $subscriptions);

$smarty->assign('main', 'xps_subscriptions');

// Assign the current location line
$smarty->assign('location',         $location);
$smarty->assign('display_captcha',  true);

func_display('customer/home.tpl', $smarty);

?>
