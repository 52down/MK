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
 * Manage news related data
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v11 (xcart_4_7_7), 2017-01-23 20:12:10, mailchimp_news_manage.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!defined('XCART_START')) { header("Location: ../../"); die("Access denied"); }

x_load('mail');
x_session_register('validated_emails', array());
x_session_register('stored_newsemail');

$subscribe_lng = $store_language;
if (empty($mode)) {
    $mode = $REQUEST_METHOD == 'GET' ? 'archive' : 'view';
}

if ($REQUEST_METHOD == 'POST') {

    $subscribe_err = false;

    // Check email
    $email = trim($newsemail);
    if (!func_check_email($email)) {
        $top_message = array(
            'type' => 'E',
            'content' => func_get_langvar_by_name('err_subscribe_email_invalid')
        );
        $subscribe_err = true;
    }

    // Image verification feature
 
    if ($mode == 'view' && !empty($active_modules['Image_Verification']) && func_validate_image("on_news_panel", $antibot_input_str)) {
        $top_message = array(
            'type' => 'E',
            'content' => func_get_langvar_by_name('msg_err_antibot')
        );
        $subscribe_err = true;
    }

    if ($subscribe_err) {
        $stored_newsemail = $email;
        func_header_location(func_is_internal_url($HTTP_REFERER) ? $HTTP_REFERER : 'mailchimp_news.php');
    }

    // Get the newslists
    
    $lists = func_query("SELECT * FROM $sql_tbl[mailchimp_newslists] WHERE avail = 'Y'");
   
    if (!is_array($lists) || empty($lists)) {
        $top_message['type'] = 'I';
        $top_message['content'] = func_get_langvar_by_name('lbl_no_subscr_news');
        $subscribe_err = true;
    }

    $news_lists_num = count($lists);
    if ($news_lists_num > 1 && $mode == 'view') {
        $validated_emails[] = stripslashes($email);
        func_header_location("mailchimp_news.php?mode=list&email=".urlencode(stripslashes($email)));
    }

    if ($mode == 'view' || ($mode == "subscribe" && in_array(stripslashes($email), $validated_emails))) {
        if ($news_lists_num == 1) {
            $s_lists=array();
            $s_lists[] = $lists[0]['mc_list_id'];
        } elseif (empty($lists) || !is_array($lists)) {
            func_header_location('mailchimp_news.php');
        }
        if (!empty($logged_userid)) {
            $userinfo = func_userinfo($logged_userid, $login_type, false, true, array('C','H'));
            $mailchimp_user_info = array ('FName'=> $userinfo['firstname'],
                                         'LName'=> $userinfo['lastname'],
                                         );
        }else{
            $mailchimp_user_info = array ('FName'=> 'Anonymous',
                                          'LName'=> 'Anonymous',
                                     );
        }
        foreach ($s_lists as $key => $listid) {
            $mailchimp_response=func_adv_mailchimp_subscribe($email, $mailchimp_user_info, $listid, false, true); 
        }
        func_header_location("mailchimp_news.php?mode=subscribed&email=".urlencode(stripslashes($email)));
    }

}

$smarty->assign('main', 'mc_news_archive');

if ($REQUEST_METHOD == 'GET' && $mode == 'list') {
    if (empty($email) || !in_array(stripslashes($email), $validated_emails) || !func_check_email($email))
        func_header_location('mailchimp_news.php');
    
    $lists = func_query("SELECT * FROM $sql_tbl[mailchimp_newslists] WHERE avail='Y'");
    if (!is_array($lists) || empty($lists)) {
        $top_message['type'] = 'I';
        $top_message['content'] = func_get_langvar_by_name('lbl_no_subscr_news');
        func_header_location('mailchimp_news.php');
    }

    $location[] = array(func_get_langvar_by_name('lbl_news_subscribe_to_newslists'), '');
    $smarty->assign('main', 'mc_news_lists');
    $smarty->assign('mc_lists', $lists);
    $smarty->assign('newsemail', $email);

} elseif ($REQUEST_METHOD == 'GET' && $mode == 'archive') {

    // Show the news from Archive of standart news module
    $standart_news = XC_News_Management::getNews();
    if (empty($standart_news)) {
        $standart_news = func_query("SELECT name AS subject, descr AS body FROM $sql_tbl[mailchimp_newslists] WHERE avail='Y'");
        $location[] = array(func_get_langvar_by_name('lbl_news_lists'), '');
    } else {
        $location[] = array(func_get_langvar_by_name('lbl_news_archive'), '');
    }


    $smarty->assign('news_messages', $standart_news);
    $smarty->assign('navigation_script', "mailchimp_news.php?");

    if (!empty($stored_newsemail)) {
        $smarty->assign('newsemail', $stored_newsemail);
        $stored_newsemail = false;
    }
}

$smarty->assign('location', $location);

class XC_News_Management {
    public static function getNews() {//{{{
        global $shop_language, $xcart_dir, $config, $first_page, $objects_per_page, $total_items, $active_modules;
        if (empty($active_modules['News_Management'])) {
            return array();
        }

        $total_items = func_news_get($shop_language, false, true);
        $objects_per_page = $config['News_Management']['newsletter_limit'];

        include $xcart_dir.'/include/navigation.php';
        return func_news_get($shop_language, false, false, "$first_page, $objects_per_page");
    }//}}}
}
