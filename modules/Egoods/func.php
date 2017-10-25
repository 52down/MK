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
 * Functions for Egoods module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v31 (xcart_4_7_7), 2017-01-23 20:12:10, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

/**
 * This module generates download key which is sent to customer
 * and inserts this key into database
 */
function keygen($productid, $key_TTL, $itemid, $userid = 0)
{//{{{
    $key = md5(uniqid(mt_rand()));

    func_array2insert(
        'download_keys',
        array(
            'download_key'  => $key,
            'expires'       => XC_TIME + $key_TTL * 3600,
            'productid'     => $productid,
            'itemid'        => $itemid,
            'userid'        => $userid,
        ),
        true
    );

    return $key;
}//}}}

function func_egoods_has_esd_products($products) { // {{{
    if (empty($products))
        return false;

    foreach ($products as $product) {
        if (!empty($product['download_key'])) {
            return true;
        }
    }

    return false;
} // }}}

function func_egoods_remove_online_payments($payment_methods)
{
    global $config, $sql_tbl, $shop_language;

    $is_online_pm_removed = false;

    if (empty($payment_methods))
        return array($is_online_pm_removed, $payment_methods);

    foreach ($payment_methods as $k => $p) {

        if (
            func_is_online_payment_method($p)
            && (
                $config['Egoods']['egoods_manual_cc_processing'] == "Y"
                || (
                    $config['Egoods']['user_preauth_for_esd'] == 'Y'
                    && (
                        $p['has_preauth'] != 'Y'
                        || $p['use_preauth'] != 'Y'
                    )
                )
            )
        ) {
            unset($payment_methods[$k]);
            $is_online_pm_removed = true;
        }
    }

    $payment_methods = array_values($payment_methods);

    return array($is_online_pm_removed, $payment_methods);
}

/**
* Check if offline payment methods should be used for cart
*/
function func_egoods_use_offline_payments($products)
{
    global $config;

    if (       
        !empty($products)
        && (
            $config['Egoods']['user_preauth_for_esd'] == 'Y'
            || $config['Egoods']['egoods_manual_cc_processing'] == "Y"
        )
    ) {
        return true;
    } else {
        return false;
    }
    
}

function func_egoods_check_owner($in_download_data)
{//{{{
    global $logged_userid, $sql_tbl;

    if (empty($in_download_data) || empty($logged_userid)) {
        return false;
    }

    return $logged_userid == $in_download_data['userid'];
}//}}}

function func_egoods_send_keys($products, $userinfo)
{//{{{
    global $config, $mail_smarty;

    if (empty($products)) {
        return false;
    }


    /**
     * Generate keys for all E-products
     */
    $send_keys = false;

    foreach($products as $key=>$value){

        if ($value['distribution']) {

            $download_key = keygen($value['productid'], $config['Egoods']['download_key_ttl'], $value['itemid'], empty($userinfo['userid']) ? 0 : $userinfo['userid']);

            $products[$key]['download_key']          = $download_key;
            $products[$key]['distribution_filename'] = basename($products[$key]['distribution']);

            $send_keys = true;

        }

    }

    $mail_smarty->assign('products', $products);

    /**
     * If there is Egoods - send them !!!
     */

    if ($send_keys) {
        x_load('mail');

        $to_customer = func_get_to_customer_language($userinfo);

        func_send_mail(
            $userinfo['email'],
            'mail/egoods_download_keys_subj.tpl',
            'mail/egoods_download_keys.tpl',
            $config['Company']['orders_department'],
            false
        );

    }
}//}}}
