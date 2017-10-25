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
 * Address book management
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    f2dbf5cb9431ad2896fd3b4e20ca2432b155874b, v37 (xcart_4_7_7), 2017-01-12 19:34:36, address_book.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header('Location: ../'); die('Access denied'); }

x_load('user');

#IN address_book 
#IN $is_anonymous, $logged_userid, $newuserid, $new_user_flag
#IN $ship2diff, $existing_address, $new_address

/**
 * Update address book during profile edit
 */
if ($REQUEST_METHOD == 'POST') {

    if (!isset($address_book) || empty($address_book)) {
        return;
    }

    $addr_errors = array();
    $address_book = func_prepare_address_book_data_for_save($address_book);
    $address_book_additional_values = (!empty($additional_values)) ? func_address_additional_values_hash_by_type($additional_values) : array();

    if (
        $current_area == 'C'
        && $main == 'checkout'
    ) {
        // Update request from customer area
        if (!$is_anonymous) {
            // logged_userid may be empty when Email_Activation is used
            $address_book = func_customer_save_address_book_indb(
                $address_book,
                empty($ship2diff) ? '' : $ship2diff,
                empty($existing_address) ? array() : $existing_address,
                empty($new_address) ? array() : $new_address,
                $address_book_additional_values,
                !empty($new_user_flag) && empty($logged_userid) ? $newuserid : $logged_userid
            );
        }

        $cart = func_customer_save_address_book_insession($cart, $address_book, @$ship2diff, $address_book_additional_values);

    } elseif ($current_area != 'C') {
        // Update request from admin area
        if (!empty($delete_address)) {
            $address_book = func_delete_from_address_book($address_book, $delete_address);
        }            

        // Update address_book for customer logged_userid
        list($address_book, $new_addressid) = func_admin_save_address_book($address_book, $logged_userid, $address_book_additional_values);
        // Mark default address(es)
        func_admin_mark_default_addresses($logged_userid, $new_addressid);

    }

    if (!empty($active_modules['TwoFactorAuth'])) {
        func_twofactor_on_phone_update(!empty($new_user_flag) && empty($logged_userid) ? $newuserid : $logged_userid);
    }

    if (
        !empty($active_modules['IContact_Subscription'])
        && $usertype == 'C'
    ) {
        func_icontact_update_contactaddress($logged_userid, $anonymous_userinfo);
    }

}

