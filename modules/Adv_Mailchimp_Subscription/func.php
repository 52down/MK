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
 * Functions for the Mailchimp subscription
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    733d8c5a22c6bdf6433b4dbca86aca75631d9b56, v41 (xcart_4_7_8), 2017-06-05 23:12:15, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!defined('XCART_START')) {
    header('Location: ../');
    die('Access denied');
}

function func_adv_mailchimp_init() {}

/**
 * Return the object of lib  class by API key
 * https://github.com/drewm/mailchimp-api
 *
 * @param string
 *
 * @return object or error_string
 * @see    ____func_see____
 * @since  1.0.0
 */
function func_adv_mailchimp_get_obj_MCAPI($_apikey = false)
{//{{{
    global $xcart_dir, $top_message, $HTTP_REFERER, $config;

    $_apikey = $_apikey ?: $config['Adv_Mailchimp_Subscription']['adv_mailchimp_apikey'];

    static $inst = array();
    if (isset($inst[$_apikey])) {
        return $inst[$_apikey];
    }
    // require $xcart_dir . '/modules/Adv_Mailchimp_Subscription/lib/autoload.php'; //is not used for performance reason

    require $xcart_dir . '/modules/Adv_Mailchimp_Subscription/lib/drewm/mailchimp-api/src/MailChimp.php';

    try {
        $inst[$_apikey] = new \DrewM\MailChimp\MailChimp($_apikey);
    } catch(Exception $e) {
        x_session_register('top_message');
        $top_message['content'] = '<a href="configuration.php?option=Adv_Mailchimp_Subscription">Adv_Mailchimp_Subscription:</a>' . $e->getMessage();
        $top_message['type'] = 'E';
        func_header_location(func_header_location(func_is_internal_url($HTTP_REFERER) ? $HTTP_REFERER : $_SERVER['PHP_SELF']));
    }

    return $inst[$_apikey];
}//}}}

/**
 * Subscription wrapper for Mailchimp service  (lists method)
 *
 * @param mixed  $listid        id of Mailchimp account
 * @param mixed  $apikey        apikey of Mailchimp account
 *
 * @return array
 * @see    ____func_see____
 * @since  1.0.0
 */
function func_mailchimp_get_lists($listid = false, $apikey = false)
{//{{{

    $mailchimp_api = func_adv_mailchimp_get_obj_MCAPI($apikey);

    $mailchimp_return = $mailchimp_api->get('lists');
    if ($mailchimp_api->getLastError()) {
        $mailchimp_return['Error_message'] = $mailchimp_api->getLastError();
        return $mailchimp_return;
    }

    $mailchimp_return['data'] = empty($mailchimp_return['lists']) ? array() : $mailchimp_return['lists'];
    if (!empty($mailchimp_return['lists'])) {
        $mailchimp_return['data'] = $mailchimp_return['lists'];
        unset($mailchimp_return['lists']);
    } else {
        $mailchimp_return = array();
    }
    return $mailchimp_return;
}//}}}

function func_adv_mailchimp_get_campaigns($in_campaignid = false, $fields = array())
{//{{{
    $mailchimp_api = func_adv_mailchimp_get_obj_MCAPI();

    if (empty($in_campaignid)) {
        $mailchimp_return = $mailchimp_api->get('campaigns');
    } else {
        $mailchimp_return = $mailchimp_api->get("campaigns/$in_campaignid", $fields);
    }

    if ($mailchimp_api->getLastError()) {
        $mailchimp_return = array();
        $mailchimp_return['Error_message'] = $mailchimp_api->getLastError();
    }

    return isset($mailchimp_return['campaigns']) ? $mailchimp_return['campaigns'] : $mailchimp_return;
}//}}}

function func_mailchimp_get_list_by_email($email, $apikey = false)
{//{{{
    global $mailchimp_lists_by_email;
    x_session_register('mailchimp_lists_by_email', array());

    if (isset($mailchimp_lists_by_email[$email]) && empty($mailchimp_lists_by_email[$email]['lock_cache'])) {
        return $mailchimp_lists_by_email[$email]['data'];
    }

    $mailchimp_api = func_adv_mailchimp_get_obj_MCAPI($apikey);
    $mailchimp_return = array();

    if (!empty($email)){
        $mailchimp_res = $mailchimp_api->get('lists', array('email' => $email, 'fields' => 'lists.id'));
        if ($mailchimp_api->getLastError() || empty($mailchimp_res['lists'])) {
            $mailchimp_return = array();
        } else {
            foreach ($mailchimp_res['lists'] as $list) {
                $mailchimp_return[] = $list['id'];
            }
        }
    }

    $mailchimp_lists_by_email[$email]['data'] = $mailchimp_return;
    return $mailchimp_return;
}//}}}

function func_mailchimp_lock_session_cache()
{//{{{
    global $mailchimp_lists_by_email;
    x_session_register('mailchimp_lists_by_email');
    $args = func_get_args();
    if (empty($args)) {
        return false;
    }

    foreach ($args as $email) {
        if (isset($mailchimp_lists_by_email[$email])) {
            $mailchimp_lists_by_email[$email] = array('lock_cache' => true);
        }
    }
}//}}}

function func_adv_mailchimp_subscribe($email_address, $user_info, $listid = false,  $apikey = false, $send_confirm_email = false) {
    global $config;

    $mailchimp_api = func_adv_mailchimp_get_obj_MCAPI($apikey);

    $mailchimp_merge_vars = $user_info;
    $mailchimp_response = array();

    $mailchimp_return = $mailchimp_api->post("lists/$listid/members",
        array(
            'status' => ($send_confirm_email ? 'pending' : 'subscribed'),
            'email_address' => $email_address,
            'merge_fields' => $mailchimp_merge_vars)
    );

    if (
        !empty($mailchimp_return['status'])
        && $mailchimp_return['status'] == 400
        && $mailchimp_return['title'] == 'Member Exists'
        && $config['Adv_Mailchimp_Subscription']['adv_mailchimp_register_opt'] == 'Y'
    ) {
        $subscriber_hash = $mailchimp_api->subscriberHash($email_address);

        $status = $mailchimp_api->get("lists/$listid/members/$subscriber_hash", array('fields' => 'status'));

        if (
            !empty($status)
            && $status['status'] == 'pending'
        ) {
            //resend confirmation email
            $mailchimp_return = $mailchimp_api->put("lists/$listid/members/$subscriber_hash",
                array(
                    'status' => ($send_confirm_email ? 'pending' : 'subscribed'),
                    'status_if_new' => ($send_confirm_email ? 'pending' : 'subscribed'),
                    'email_address' => $email_address,
                    'merge_fields' => $mailchimp_merge_vars)
            );
        }

    }

    if ($mailchimp_api->getLastError()) {
        $mailchimp_response['Error_message'] = $mailchimp_api->getLastError();
    } else {
        func_mailchimp_lock_session_cache($email_address);
        $mailchimp_response['Response'] = $mailchimp_return;
    }

    return $mailchimp_response;
}

function func_mailchimp_update($email_address, $listid, $mailchimp_updates, $apikey = false)
{//{{{
    $mailchimp_api = func_adv_mailchimp_get_obj_MCAPI($apikey);

    $mailchimp_merge_vars = $mailchimp_updates;

    $subscriber_hash = $mailchimp_api->subscriberHash($email_address);
    $mailchimp_return = $mailchimp_api->patch("lists/$listid/members/$subscriber_hash", array('merge_fields' => $mailchimp_merge_vars));

    $mailchimp_response = array();
    if ($mailchimp_api->getLastError()) {
        $mailchimp_response['Error_message'] = $mailchimp_api->getLastError();
    } else {
        if (isset($mailchimp_merge_vars['status'])) {
            func_mailchimp_lock_session_cache($email_address);
        }
        $mailchimp_response['Response'] = $mailchimp_return;
    }

    return $mailchimp_response;
}//}}}

function func_mailchimp_unsubscribe($email_address, $listid = false, $apikey = false)
{
    $mailchimp_api = func_adv_mailchimp_get_obj_MCAPI($apikey);

    $mailchimp_response = array();

    $subscriber_hash = $mailchimp_api->subscriberHash($email_address);
    $mailchimp_return = $mailchimp_api->patch("lists/$listid/members/$subscriber_hash", array('status' => 'unsubscribed'));

    if ($mailchimp_api->getLastError()) {
        $mailchimp_response['Error_message'] = $mailchimp_api->getLastError();
    } else {
        func_mailchimp_lock_session_cache($email_address);
        $mailchimp_response['Response'] = $mailchimp_return;
    }

    return $mailchimp_response;
}

class XCMailChimpEcomm {
    const ID_LIMIT_LENGTH = 50;//http://developer.mailchimp.com/documentation/mailchimp/guides/getting-started-with-ecommerce/#using-the-api
    const CAMPAIGN_EXPIRE_SQL = 7776000;//86400 * 30 * 3
    const PRODUCTS_EXPIRE_SQL = 15768000;//86400 * 365/2
    const PRODUCT_BATCHES_EXPIRE_SQL = 300;//60 * 5 enough lag to wait while a previous batch is executed

    public static function getStoreByCampaignId($in_campaign_code)
    {//{{{
        global $sql_tbl;
        static $res;

        if (!empty($res)) {
            return $res;
        }

        $store = $res = func_query_first("SELECT store_code FROM $sql_tbl[mailchimp_campaigns_stores] WHERE campaign_code='" . addslashes($in_campaign_code) . "'") ?: array();
        if (!empty($store)) {
            if (!empty($store['store_code'])) {
                return $store;
            } else {
                return false;
            }
        }

        $list_from_campaign = XCMailChimpEcomm::getListIdByCampaignId($in_campaign_code);
        if (empty($list_from_campaign)) {
            // raw with empty store_code to support cache
            db_query("DELETE FROM $sql_tbl[mailchimp_campaigns_stores] WHERE expire<" . XC_TIME);
            db_query("INSERT IGNORE INTO $sql_tbl[mailchimp_campaigns_stores] SET campaign_code='" . addslashes($in_campaign_code) . "', expire='" . (XC_TIME+86400) . "'");
            return false;
        }

        $store_code = $store['store_code'] = static::getStoreIdByListId($list_from_campaign['list_id']) ?: XCMailChimpEcomm::addStore($list_from_campaign);

        if (!empty($store_code)) {
            $expiry = XC_TIME+static::CAMPAIGN_EXPIRE_SQL;
            db_query("DELETE FROM $sql_tbl[mailchimp_campaigns_stores] WHERE expire<" . XC_TIME);
            db_query("INSERT INTO $sql_tbl[mailchimp_campaigns_stores] SET campaign_code='" . addslashes($in_campaign_code) . "', store_code='" . addslashes($store_code) . "', expire='$expiry' ON DUPLICATE KEY UPDATE expire='$expiry'");
        }

        return !empty($store_code) ? $store : array();
    }//}}}

    public static function addStore($list, $res_format='')
    {//{{{
        global $xcart_http_host, $config;

        $mailchimp_api = func_adv_mailchimp_get_obj_MCAPI();
        $params = array(
            'id' => substr($list['list_id'] . static::getStoreSuffix(), 0, static::ID_LIMIT_LENGTH),
            'list_id' => $list['list_id'],
            'name' => $xcart_http_host . ': list ' . $list['list_id'] . ' ' . (empty($list['list_name']) ? '' : $list['list_name']),
            'currency_code' => $config['Adv_Mailchimp_Subscription']['adv_mailchimp_currency_code'],
        );
        $mailchimp_return = $mailchimp_api->post("ecommerce/stores", $params);

        return empty($mailchimp_return['id']) ? false :
            ($res_format == 'get_all_fields' ? $mailchimp_return : $mailchimp_return['id']);
    }//}}}

    public static function getEcommerceCustomer($store_code, $order_userinfo, $b_addrress)
    { //{{{
        global $sql_tbl;

        $allowed_addr_fields = array('address1','address2','city','province','province_code','postal_code','country','country_code');
        $allowed_customer_fields = array('id','email_address','opt_in_status','company','first_name','last_name','orders_count','total_spent','address');

        $cond = empty($order_userinfo['all_userid']) ? ("email='" . addslashes($order_userinfo['email_address']) . "'") : ("all_userid='" . intval($order_userinfo['all_userid']) . "'");
        $customer_orders = func_query_first("SELECT COUNT(*) AS cnt, SUM(total) AS sum FROM $sql_tbl[orders] WHERE $cond");
        $order_userinfo['orders_count'] = intval($customer_orders['cnt']);
        $order_userinfo['total_spent'] = $customer_orders['sum'];
        $order_userinfo['address'] = array_intersect_key($b_addrress, array_flip($allowed_addr_fields));

        $_operation = array(
            'method' => 'PUT',
            'path' => "ecommerce/stores/$store_code/customers/$order_userinfo[id]",
            'body' => json_encode(array_intersect_key($order_userinfo, array_flip($allowed_customer_fields))),
        );

        return $_operation;
    }//}}}

    public static function getOrderCustomer($userinfo)
    { //{{{
        global $config;
        $data = array(
            'id'    => !empty($userinfo['userid']) ? $userinfo['userid'] : md5($userinfo['email']),
            'email_address' => !empty($userinfo['email']) ? $userinfo['email'] : '',
            'first_name' => !empty($userinfo['firstname']) ? $userinfo['firstname'] : (!empty($userinfo['s_firstname']) ? $userinfo['s_firstname'] : ''),
            'last_name' => !empty($userinfo['lastname']) ? $userinfo['lastname'] : (!empty($userinfo['s_lastname']) ? $userinfo['s_lastname'] : ''),
            'company' => !empty($userinfo['company']) ? $userinfo['company'] : '',
            'opt_in_status' => $config['Adv_Mailchimp_Subscription']['adv_mailchimp_subscribe_order'] == 'Y',
            'address' => array(
                'address1' => !empty($userinfo['s_address']) ? $userinfo['s_address'] : '',
                'city' => !empty($userinfo['s_city']) ? $userinfo['s_city'] : '',
                'province' => !empty($userinfo['s_statename']) ? $userinfo['s_statename'] : '',
                'province_code' => !empty($userinfo['s_state']) ? $userinfo['s_state'] : '',
                'postal_code' => !empty($userinfo['s_zipcode']) ? $userinfo['s_zipcode'] : '',
                'country' => !empty($userinfo['s_countryname']) ? $userinfo['s_countryname'] : '',
                'country_code' => !empty($userinfo['s_country']) ? $userinfo['s_country'] : '',
            ),
        );

        return $data;
    }//}}}

    public static function getOrderAddress($order, $in_prefix)
    { //{{{
        $data = array(
            'address1' => !empty($order[$in_prefix . 'address']) ? $order[$in_prefix . 'address'] : '',
            'city' => !empty($order[$in_prefix . 'city']) ? $order[$in_prefix . 'city'] : '',
            'province' => !empty($order[$in_prefix . 'statename']) ? $order[$in_prefix . 'statename'] : '',
            'province_code' => !empty($order[$in_prefix . 'state']) ? $order[$in_prefix . 'state'] : '',
            'postal_code' => !empty($order[$in_prefix . 'zipcode']) ? $order[$in_prefix . 'zipcode'] : '',
            'country' => !empty($order[$in_prefix . 'countryname']) ? $order[$in_prefix . 'countryname'] : '',
            'country_code' => !empty($order[$in_prefix . 'country']) ? $order[$in_prefix . 'country'] : '',
            'phone' => !empty($order[$in_prefix . 'phone']) ? $order[$in_prefix . 'phone'] : '',
        );

        return $data;
    }//}}}

    public static function getLineItems($order_data)
    { //{{{
        $items = array();

        if (empty($order_data['products'])) {
            return array();
        }

        foreach ($order_data['products'] as $k => $pr) {
            $items[] = array(
                'id' => !isset($pr['itemid']) ? ('cart_item' . $k) : ('order_item' . $pr['itemid']),
                'product_id' => static::getProductId($pr),
                'product_variant_id' => static::getProductVariantId($pr),
                'quantity' => intval($pr['amount']),
                'price' => empty($pr['taxed_price']) ? $pr['price'] : $pr['taxed_price'],
            );
        }

        return $items;
    }//}}}

    public static function sendCart($cart, $in_campaignid='', $product_operations=array())
    { //{{{
        global $config, $mailchimp_carts, $current_location, $logged_userid, $login, $user_account;

        if (
            empty($cart['products'])
            || $config['Adv_Mailchimp_Subscription']['adv_mailchimp_send_carts'] != 'Y'
            || empty($cart['products'])
        ) {
            return false;
        }

        if (!empty($in_campaignid)) {
            $store = array();
        } elseif (!empty($config['Adv_Mailchimp_Subscription']['adv_mailchimp_default_store'])) {
            $store = array('store_code' => $config['Adv_Mailchimp_Subscription']['adv_mailchimp_default_store']);
        } else {
            return false;
        }

        $store = $store ?: XCMailChimpEcomm::getStoreByCampaignId($in_campaignid);

        if (empty($store['store_code'])) {
            return false;
        }

        //The same call as from Include/Checkout_init.php to use static cache
        x_load('user');
        x_session_register('logged_userid');
        x_session_register('login');
        $userinfo = func_userinfo($logged_userid, !empty($login) ? $user_account['usertype'] : '', false, false, 'H');

        if (empty($userinfo['email'])) {
            return false;
        }

        $cart2send = array(
            'customer' => XCMailChimpEcomm::getOrderCustomer($userinfo),
            'currency_code' => $config['Adv_Mailchimp_Subscription']['adv_mailchimp_currency_code'],
            'order_total' => $cart['total_cost'],
            'tax_total'         => empty($cart['tax_cost']) ? 0 : $cart['tax_cost'],
            'shipping_total'    => empty($cart['shipping_cost']) ? 0 : $cart['shipping_cost'],
            'lines' => XCMailChimpEcomm::getLineItems($cart),
        );

        if (!empty($in_campaignid)) {
            $cart2send['campaign_id'] = $in_campaignid;
        }

        $cart2send['id'] = $current_cart_id = md5(serialize($cart2send));
        $cart2send['checkout_url'] = XCMailChimpAbandonedCarts::getRestoreUrl($current_cart_id);

        x_session_register('mailchimp_carts', array());
        if (!isset($mailchimp_carts[$current_cart_id])) {
            if (!empty($mailchimp_carts)) {
                XCMailChimpAbandonedCarts::deleteObsolete(array_keys($mailchimp_carts));
            }

            $_operations = array();
            // remove obsolete Carts
            foreach ($mailchimp_carts as $session_cart_id => $val) {
                $_operations[] = array(
                    'method' => 'DELETE',
                    'path' => "ecommerce/stores/$store[store_code]/carts/$session_cart_id",
                );
                unset($mailchimp_carts[$session_cart_id]) ;
            }

            XCMailChimpAbandonedCarts::addCart($current_cart_id);
            $mailchimp_carts[$current_cart_id] = true;
            $_operations[] = array(
                'method' => 'POST',
                'path' => "ecommerce/stores/$store[store_code]/carts",
                'body' => json_encode($cart2send),
            );
        }

        if (empty($_operations)) {
            return false;
        }

        $mailchimp_api = func_adv_mailchimp_get_obj_MCAPI();

        if (defined('XC_MAILCHIMP_DELETE_BATCHES')) {//{{{
            $all_batches = $mailchimp_api->get('batches', array('fields' => 'batches.id'));
            if (!empty($all_batches['batches'])) {
                foreach ($all_batches['batches'] as $batch) {
                    $res = $mailchimp_api->delete('batches/' . $batch['id']);
                }
            }
        }//}}}

        $mailchimp_return = $mailchimp_api->post('batches', json_encode(array('operations'=>array_merge($product_operations, $_operations))));
        return true;
    }//}}}

    public static function sendCartProducts($cart_products, $in_campaignid='')
    { //{{{
        global $config, $sql_tbl;

        if (empty($cart_products)) {
            return array();
        }

        if (!empty($in_campaignid)) {
            $store = array();
        } elseif (!empty($config['Adv_Mailchimp_Subscription']['adv_mailchimp_default_store'])) {
            $store = array('store_code' => $config['Adv_Mailchimp_Subscription']['adv_mailchimp_default_store']);
        } else {
            return array();
        }

        $store = $store ?: XCMailChimpEcomm::getStoreByCampaignId($in_campaignid);

        if (empty($store['store_code'])) {
            return array();
        }

        $search_products_ids = array();
        foreach ($cart_products as $pr) {
            $search_products_ids[] = static::getProductId($pr);
        }
        $already_added_products = func_query_hash("SELECT productid,product_variant_id FROM $sql_tbl[mailchimp_products] WHERE productid IN ('".implode("', '", $search_products_ids)."') AND store_code='" . addslashes($store['store_code']) . "'", 'productid', true, true);

        $_operations = array();
        $replace_str = $replace_str_mailchimp_product_batches = '';
        foreach ($cart_products as $pr) {
            $productid = static::getProductId($pr);
            $product_variant_id = static::getProductVariantId($pr);
            $is_added = false;

            if (empty($already_added_products[$productid])) {
                $product_image = static::getImage($productid, empty($pr['variantid']) ? 0 : $pr['variantid']);
                // add full product with variant
                $body = array(
                        'id' => $productid,
                        'title' => $pr['product'],
                        'image_url' => $product_image,
                        'url' => func_get_resource_url('product', $productid),
                        'variants' => array(
                            'id' => $product_variant_id,
                            'title' => $pr['product'],
                            'sku' => $pr['productcode'],
                            'price' => empty($pr['taxed_price']) ? $pr['price'] : $pr['taxed_price'],
                            'inventory_quantity' => 10, // As the product is in the cart than it is available for sale
                            'image_url' => $product_image,
                        ),
                );

                if (empty($body['image_url'])) {
                    unset($body['image_url']);
                }

                if (empty($body['variants']['image_url'])) {
                    unset($body['variants']['image_url']);
                }

                $_operations[] = array(
                    'method' => 'DELETE',
                    'path' => "ecommerce/stores/$store[store_code]/products/$productid",
                );

                $body = str_replace('variants":{"', 'variants":[{"', json_encode($body));
                $body = str_replace('}}', '}]}', $body);
                $_operations[] = $one_product_operations = array(
                    'method' => 'POST',
                    'path' => "ecommerce/stores/$store[store_code]/products",
                    'body' => $body,
                );

                $is_added = true;
                if (!func_decimal_empty($pr['taxed_price']) || !func_decimal_empty($pr['price'])) {
                    $already_added_products[$productid] = array($product_variant_id);
                }
            } elseif (!in_array($product_variant_id, $already_added_products[$productid])) {
                //add variant to existent product
                $body = array(
                    'id' => $product_variant_id,
                    'title' => $pr['product'],
                    'sku' => $pr['productcode'],
                    'inventory_quantity' => 10, // As the product is in the cart than it is available for sale
                    'image_url' => static::getImage($productid, empty($pr['variantid']) ? 0 : $pr['variantid']),
                );

                if (empty($body['image_url'])) {
                    unset($body['image_url']);
                }

                $body = json_encode($body);

                $_operations[] = $one_product_operations = array(
                    'method' => 'POST',
                    'path' => "ecommerce/stores/$store[store_code]/products/$productid/variants",
                    'body' => $body,
                );
                $is_added = true;
                $already_added_products[$productid][] = $product_variant_id;
            }

            if (!empty($is_added)) {
                $replace_str .= "('" . addslashes($store['store_code']) . "','" . intval($productid) . "','" . addslashes($product_variant_id) . "', '" . (XC_TIME+static::PRODUCTS_EXPIRE_SQL). "'),";
                $replace_str_mailchimp_product_batches .= "('" . intval($productid) . "','" . addslashes($product_variant_id) . "', '" . (XC_TIME+static::PRODUCT_BATCHES_EXPIRE_SQL). "','" . addslashes(serialize($one_product_operations)) . "'),";
            }
        } // foreach ($cart_products as $pr)

        if (empty($_operations)) {
            return array();
        }

        $mailchimp_api = func_adv_mailchimp_get_obj_MCAPI();

        $operations = json_encode(array('operations'=>$_operations));

        $mailchimp_return = $mailchimp_api->post('batches', $operations);
        if (!empty($replace_str)) {
            if (!mt_rand(0, 50)) {
                db_query("DELETE FROM $sql_tbl[mailchimp_products] WHERE expire<" . XC_TIME);
            }
            db_query("REPLACE INTO $sql_tbl[mailchimp_products] (store_code,productid,product_variant_id,`expire`) VALUES " . trim($replace_str, ','));

            db_query("REPLACE INTO $sql_tbl[mailchimp_product_batches] (productid,product_variant_id,`expire`,batch) VALUES " . trim($replace_str_mailchimp_product_batches, ','));
        }

        return $_operations;
    }//}}}

    protected static function getListIdByCampaignId($in_campaignid)
    {//{{{
        $res = func_adv_mailchimp_get_campaigns($in_campaignid, array('fields' => 'recipients.list_id,recipients.list_name'));
        return !empty($res['recipients']['list_id']) ? $res['recipients'] : false;
    }//}}}

    public static function getStoreIdByListId($listid, $res_format='')
    {//{{{
        static $res = array();

        if (isset($res[$res_format])) {
            $mailchimp_return = $res[$res_format];
        } else {
            $mailchimp_api = func_adv_mailchimp_get_obj_MCAPI();
            if (empty($res_format)) {
                $mailchimp_return = $mailchimp_api->get('ecommerce/stores', array('fields' => 'stores.id,stores.list_id'));
            } elseif ($res_format == 'get_all_fields') {
                $mailchimp_return = $mailchimp_api->get('ecommerce/stores');
            }

            $res[$res_format] = $mailchimp_return;
        }

        $store_code = false;
        if (!empty($mailchimp_return['stores'])) {
            foreach ($mailchimp_return['stores'] as $store) {
                if ($store['list_id'] == $listid) {
                    if (defined('DEVELOPMENT_MODE') && strpos($store['id'], ' ') !== false) {
                        continue;
                    }
                    $store_code = $res_format == 'get_all_fields' ? $store : $store['id'];
                    if (strpos($store['id'], static::getStoreSuffix()) !== false) {
                        $store_matched_by_domain = $res_format == 'get_all_fields' ? $store : $store['id'];
                        break;
                    }
                }
            }
        }

        return empty($store_matched_by_domain) ? $store_code : $store_matched_by_domain;
    }//}}}

    protected static function getStoreSuffix()
    {//{{{
        global $xcart_http_host;
        return '_' . md5($xcart_http_host);
    }//}}}

    protected static function getProductId($product)
    {//{{{
        return $product['productid'];
    }//}}}

    protected static function getProductVariantId($product)
    {//{{{
        return empty($product['variantid']) ? $product['productid'] : $product['productcode'];
    }//}}}

    protected static function getImage($productid, $variantid)
    {//{{{
        global $config, $xcart_http_host;

        if ($config['Adv_Mailchimp_Subscription']['adv_mailchimp_p_recommendations'] != 'Y') {
            return '';
        }

        $image_ids = array(
            'P' => $productid,
            'T' => $productid,
        );

        if (!empty($variantid)) {
            $image_ids['W'] = $variantid;
        }

        $images = func_get_image_url_by_types($image_ids, empty($variantid) ? 'P' : 'W');
        $image_url = '';

        if (is_array($images) && is_array($images['images'])) {
            foreach (array('W', 'P', 'T') as $type) {
                if (isset($images['images'][$type])) {
                    $image = $images['images'][$type];
                    if (is_array($image) && empty($image['is_default'])) {
                        $image_url = $image['url'];
                        break;
                    }
                }

            }
        }

        if (defined('XC_NGROK_PROXY')) {
            $image_url = str_replace($xcart_http_host, XC_NGROK_PROXY, $image_url);
        }
        return $image_url;
    }//}}}
}

class XCMailChimpAbandonedCarts {
    public static function deleteObsolete($cart_ids)
    {//{{{
        global $sql_tbl;

        if (empty($cart_ids)) {
            return false;
        }

        $cart_ids = is_array($cart_ids) ? $cart_ids : array($cart_ids);
        db_query("DELETE FROM $sql_tbl[mailchimp_abandoned_carts] WHERE cartid IN ('".implode("', '", $cart_ids)."')");

        // Delete expired Carts
        if (!mt_rand(0, 200)) {
            db_query("DELETE FROM $sql_tbl[mailchimp_abandoned_carts] WHERE expiry < '" . XC_TIME . "'");
        }

    }//}}}

    public static function addCart($cart_id)
    {//{{{
        global $cart, $XCARTSESSID, $logged_userid, $sql_tbl;

        x_session_register('cart');
        x_session_register('logged_userid');

        // core saved Carts will be used for logged userid
        $serialized_cart = empty($logged_userid) ? addslashes(serialize($cart)) : $logged_userid;
        $data_query = "saved_cart='$serialized_cart', expiry='" . (XC_TIME + SECONDS_PER_DAY*180) . "', cartid='$cart_id'";

        return db_query("INSERT INTO $sql_tbl[mailchimp_abandoned_carts] SET $data_query, sessid='$XCARTSESSID' ON DUPLICATE KEY UPDATE $data_query");
    }//}}}

    public static function getRestoreUrl($key)
    {//{{{
        global $current_location;
        return $current_location . DIR_CUSTOMER . '/cart.php?mailchimp_cart_restore_key=' . $key;
    }//}}}

    public static function restoreNredirect($in_cartid, $in_campaignid)
    {//{{{
        global $sql_tbl, $cart, $logged_userid, $top_message, $current_location, $mailchimp_carts;

        x_session_register('cart');
        x_session_register('top_message', array());
        x_session_register('logged_userid');
        x_session_register('mailchimp_carts', array());
        $cart_restore_data = func_query_first_cell("SELECT saved_cart FROM $sql_tbl[mailchimp_abandoned_carts] WHERE cartid='$in_cartid'");

        if (!empty($cart_restore_data)) {
            if (!func_is_cart_empty($cart)) {
                if (
                    empty($logged_userid)
                    || $cart_restore_data != $logged_userid
                ) {
                    $top_message['content'] = func_get_langvar_by_name('txt_adv_mailchimp_cart_cannot_be_restored');
                } else {
                    // For logged users we do not need to restore cart
                    $delete_mailchimp_cart = true;
                }

                $redirect_url = $current_location . DIR_CUSTOMER . '/cart.php';
            } else {
                // Current cart is empty
                $delete_mailchimp_cart = true;

                x_load('cart');//For Func_restore_serialized_cart/Func_cart_set_flag
                if (is_numeric($cart_restore_data)) {
                    //Try to restore from core table as cart_restore_data is userid
                    func_restore_serialized_cart($cart_restore_data);
                } else {
                    $cart = @unserialize($cart_restore_data) ?: $cart;
                }

                if (
                    !empty($cart)
                    && !func_is_cart_empty($cart)
                ) {
                    $cart = func_cart_set_flag('need_recalculate', true);
                    $redirect_url = $current_location . DIR_CUSTOMER . '/cart.php';
                }
            }
        } else {
            $delete_mailchimp_cart = true;
        }

        if (
            !empty($delete_mailchimp_cart)
            && !empty($in_campaignid)
            && ($store = XCMailChimpEcomm::getStoreByCampaignId($in_campaignid))
            && !empty($store['store_code'])
        ) {
            // Do not send abandon emails again
            $mailchimp_api = func_adv_mailchimp_get_obj_MCAPI();
            // Delete the cart
            $_operations = array();
            $_operations[] = array(
                'method' => 'DELETE',
                'path' => "ecommerce/stores/$store[store_code]/carts/$in_cartid",
            );
            $mailchimp_api->post('batches', json_encode(array('operations'=>$_operations)));

            if (!empty($cart_restore_data)) {
                self::deleteObsolete($in_cartid);
            }
        } elseif(!empty($mailchimp_carts[$in_cartid])) {
            // Do not remove session cart from DB
            unset($mailchimp_carts[$in_cartid]);
        }

        return empty($redirect_url) ? false : func_header_location($redirect_url);
    }// RestoreNredirect}}}
}

function func_mailchimp_adv_campaign_commission($orderid)
{//{{{
    global $mailchimp_campaignid, $config, $mailchimp_carts, $sql_tbl;

    if (
        defined('XC_MAILCHIMP_CAMPAIGNID')
        && empty($mailchimp_campaignid)
    ) {
        $mailchimp_campaignid = XC_MAILCHIMP_CAMPAIGNID;
    }

    if (!empty($mailchimp_campaignid)) {
        $store = array();
    } elseif (!empty($config['Adv_Mailchimp_Subscription']['adv_mailchimp_default_store'])) {
        $store = array('store_code' => $config['Adv_Mailchimp_Subscription']['adv_mailchimp_default_store']);
        $mailchimp_campaignid = '';//to avoid notice
    } else {
        return false;
    }

    if ($config['Adv_Mailchimp_Subscription']['adv_mailchimp_send_orders'] != 'Y') {
        return false;
    }

    $store = $store ?: XCMailChimpEcomm::getStoreByCampaignId($mailchimp_campaignid);

    if (empty($store['store_code'])) {
        return false;
    }

    $order_data = func_order_data($orderid);
    $line_items = XCMailChimpEcomm::getLineItems($order_data);

    if (empty($line_items)) {
        return false;
    }

    $prefix = defined('XC_MAILCHIMP_DEBUG') && defined('DEVELOPMENT_MODE') ? ('_' . XC_TIME) : '';
    $customer_data = XCMailChimpEcomm::getOrderCustomer($order_data['userinfo']);
    $s_addr = XCMailChimpEcomm::getOrderAddress($order_data['order'], 's_');
    $b_addr = XCMailChimpEcomm::getOrderAddress($order_data['order'], 'b_');
    $order2send = array(
        'id'          => $order_data['order']['orderid'] . $prefix,
        'customer'    => $customer_data,
        'currency_code' => $config['Adv_Mailchimp_Subscription']['adv_mailchimp_currency_code'],
        'order_total' => $order_data['order']['total'],
        'tax_total'         => empty($order_data['order']['tax']) ? 0 : $order_data['order']['tax'],
        'shipping_total'    => empty($order_data['order']['shipping_cost']) ? 0 : $order_data['order']['shipping_cost'],
        'updated_at_foreign'  => date('c', $order_data['order']['date']),
        'processed_at_foreign' => date('c', $order_data['order']['date']),
        'financial_status' => 'Processing',
        'fulfillment_status' => 'New',
        'shipping_address' => $s_addr,
        'billing_address' => $b_addr,
        'lines'       => $line_items,
    );

    if (!empty($mailchimp_campaignid)) {
        $order2send['campaign_id'] = $mailchimp_campaignid;
    }

    $order2send = json_encode($order2send);


    $mailchimp_api = func_adv_mailchimp_get_obj_MCAPI();
    $_operations = array();
    $_operations[] = array(
        'method' => 'POST',
        'path' => "ecommerce/stores/$store[store_code]/orders",
        'body' => $order2send,
    );

    // add just added products to batch to avoid errors
    $product_keys = $variant_keys = array();
    foreach ($line_items as $item) {
        $product_keys[intval($item['product_id'])] = 1;
        $variant_keys[addslashes($item['product_variant_id'])] = 1;
    }
    db_query("DELETE FROM $sql_tbl[mailchimp_product_batches] WHERE expire<" . XC_TIME);
    $product_batches = func_query_column("SELECT batch FROM $sql_tbl[mailchimp_product_batches] WHERE productid IN ('".implode("', '", array_keys($product_keys))."') AND product_variant_id IN ('".implode("', '", array_keys($variant_keys))."')");
    $product_batches = empty($product_batches) ? array() : array_map('unserialize', $product_batches);
    $_operations = array_merge($product_batches, $_operations);


    // Delete all session Carts
    if ($config['Adv_Mailchimp_Subscription']['adv_mailchimp_send_carts'] == 'Y') {
        x_session_register('mailchimp_carts', array());
        foreach ($mailchimp_carts as $session_cart_id => $val) {
            $_operations[] = array(
                'method' => 'DELETE',
                'path' => "ecommerce/stores/$store[store_code]/carts/$session_cart_id",
            );
        }
        $mailchimp_carts = array();
    }

    // UPdate ecommerce customer http://developer.mailchimp.com/documentation/mailchimp/guides/getting-started-with-ecommerce/#orders-count-and-total-spent
    $customer_data['all_userid'] = empty($order_data['order']['all_userid']) ? 0 : $order_data['order']['all_userid'];
    if ($operation_update_customer = XCMailChimpEcomm::getEcommerceCustomer($store['store_code'], $customer_data, empty($b_addr) ? $s_addr : $b_addr)) {
        $_operations[] = $operation_update_customer;
    }

    if (defined('XC_MAILCHIMP_DELETE_BATCHES')) {//{{{
        $all_batches = $mailchimp_api->get('batches', array('fields' => 'batches.id'));
        if (!empty($all_batches['batches'])) {
            foreach ($all_batches['batches'] as $batch) {
                $res = $mailchimp_api->delete('batches/' . $batch['id']);
            }
        }
    }//}}}

    $mailchimp_return = $mailchimp_api->post('batches', json_encode(array('operations'=>$_operations)));
    return true;
}//}}}

function func_mailchimp_batch_subscribe($userinfo, $_mailchimp_subscription)
{//{{{
    if (!empty($userinfo['email']) && $_mailchimp_subscription) {

        $mailchimp_user_info = array(
            'FNAME' => $userinfo['firstname'],
            'LNAME' => $userinfo['lastname'],
            'email' => $userinfo['email'],
            'phone' => $userinfo['b_phone'],
            'website' => $userinfo['url'],
            'address' => array(
                           'addr1'   => $userinfo['b_address'],
                           'city'    => $userinfo['b_city'],
                           'state'   => $userinfo['b_state'],
                           'zip'     => $userinfo['b_zipcode'],
                           'country' => $userinfo['b_country']
                         )
        );
        foreach ($_mailchimp_subscription as $key => $id) {
            func_adv_mailchimp_subscribe(
                $userinfo['email'],
                $mailchimp_user_info,
                $key,
                false,
                true
            );
        }
    }
}//}}}

function func_mailchimp_resubscribe()
{//{{{
    global $sql_tbl, $config;
    global $firstname, $lastname, $email;
    global $old_userinfo,$mailchimp_subscription,$mc_newslists;

    $mc_newslists = func_query("SELECT mc_list_id FROM $sql_tbl[mailchimp_newslists] WHERE avail='Y'");

    if (!empty($mc_newslists) && !func_is_ajax_request() && $email) {
        $mailchimp_user_info = array(
            'FNAME' => $firstname,
            'LNAME' => $lastname,
            'phone' => $old_userinfo['b_phone'],
            'website' => $old_userinfo['url'],
            'address' => array(
                           'addr1'   => $old_userinfo['b_address'],
                           'city'    => $old_userinfo['b_city'],
                           'state'   => $old_userinfo['b_state'],
                           'zip'     => $old_userinfo['b_zipcode'],
                           'country' => $old_userinfo['b_country']
                         )

        );
        $mc_nls = array();
        foreach($mc_newslists as $mc_lt){
            $mc_nls[] = $mc_lt['mc_list_id'];
        }

        $mailchimp_cur_subs = array();
        $mailchimp_cur_subs = $orig_mailchimp_cur_subs = func_mailchimp_get_list_by_email($old_userinfo['email']);
        $mailchimp_cur_subs = array_intersect($mailchimp_cur_subs,$mc_nls);
        $mailchimp_ext_subs = array();

        if ($email != $old_userinfo['email']) {
            $mailchimp_ext_subs = func_mailchimp_get_list_by_email($email);
        } else {
            $mailchimp_ext_subs = $orig_mailchimp_cur_subs;
        }
        $mailchimp_ext_subs = array_intersect($mailchimp_ext_subs,$mc_nls);

        $mailchimp_subs_keys = array();
        if (is_array($mailchimp_subscription)) {
            $mailchimp_subs_keys = array_keys($mailchimp_subscription);
        }

        $mailchimp_delid = array_diff($mailchimp_cur_subs, $mailchimp_subs_keys);
        $mailchimp_insid = array_diff($mailchimp_subs_keys, $mailchimp_cur_subs,$mailchimp_ext_subs);
        $mailchimp_updid = array_intersect($mailchimp_cur_subs, $mailchimp_subs_keys);
        $mailchimp_updid = array_diff($mailchimp_updid, $mailchimp_ext_subs);

        foreach ($mailchimp_delid as $id) {
            $mailchimp_response = func_mailchimp_unsubscribe($old_userinfo['email'], $id);
        }

        if (
            count($mailchimp_updid) > 0
            && ($old_userinfo['email'] != stripslashes($email) || $old_userinfo['firstname'] != $firstname  )
        ) {
            foreach ($mailchimp_updid as $id) {
                func_mailchimp_update(
                    $old_userinfo['email'],
                    $id,
                    array(
                        'EMAIL' => $email,
                        'FNAME' => $firstname,
                        'LNAME' => $lastname,
                    )
                );
            }
        }

        if ($config['Adv_Mailchimp_Subscription']['adv_mailchimp_register_opt'] == 'Y') {
            $_send_confirm_email = true;
        } else {
            $_send_confirm_email = false;
        }

        foreach ($mailchimp_insid as $id) {
            $mailchimp_response = func_adv_mailchimp_subscribe($email, $mailchimp_user_info, $id, false, $_send_confirm_email);
        }
    }
}//}}}

function func_mailchimp_new_adv_campaign_commission()
{//{{{
    global $mailchimp_campaignid, $REQUEST_METHOD, $mode, $config, $cart, $mailchimp_cart_restore_key;

    if (!empty($_GET['mc_cid'])) {
        x_session_register('mailchimp_campaignid');
        $mailchimp_campaignid = $_GET['mc_cid'];
        $days = $config['Adv_Mailchimp_Subscription']['adv_mailchimp_campaign_expire'];
        $days = empty($days) ? 1 : $days;
        $thirty_days = 60 * 60 * 24 * $days;
        func_setcookie('mailchimp_campaignid', $mailchimp_campaignid, XC_TIME + $thirty_days);
    }

    if (
        defined('XC_MAILCHIMP_CAMPAIGNID')
        && empty($mailchimp_campaignid)
    ) {
        $mailchimp_campaignid = XC_MAILCHIMP_CAMPAIGNID;
    }

    // restore Abandoned Mailchimp cart request
    if (!empty($mailchimp_cart_restore_key)) {
        XCMailChimpAbandonedCarts::restoreNredirect($mailchimp_cart_restore_key, empty($mailchimp_campaignid) ? '' : $mailchimp_campaignid);
    }

    // add cart products to mailchimp
    if (
        (
            strpos($_SERVER['PHP_SELF'], 'cart.php') !== false
            || strpos($_SERVER['PHP_SELF'], 'amazon_checkout.php') !== false // !empty($active_modules['Amazon_Payments_Advanced'])nolint
        )
        && $REQUEST_METHOD == 'GET'
        && !func_is_ajax_request()
        && (empty($mode) || $mode == 'checkout')
        && (
            !empty($mailchimp_campaignid)
            || !empty($config['Adv_Mailchimp_Subscription']['adv_mailchimp_default_store'])
        )
    ) {
        $mailchimp_campaignid = empty($mailchimp_campaignid) ? '' : $mailchimp_campaignid;
        x_session_register('cart');
        if (
            $config['Adv_Mailchimp_Subscription']['adv_mailchimp_send_orders'] == 'Y'
            || $config['Adv_Mailchimp_Subscription']['adv_mailchimp_send_carts'] == 'Y'
        ) {
            $_product_operations = XCMailChimpEcomm::sendCartProducts(empty($cart['products']) ? array() : $cart['products'], $mailchimp_campaignid);
        }

        if ($config['Adv_Mailchimp_Subscription']['adv_mailchimp_send_carts'] == 'Y') {
            XCMailChimpEcomm::sendCart($cart, $mailchimp_campaignid, $_product_operations);
        }
    }
}//}}}

function func_mailchimp_save_subscription($mailchimp_subscription) {

    global $saved_userinfo, $user;

    if (is_array($mailchimp_subscription)) {
        $saved_userinfo[$user]['mailchimp_subscription'] = $mailchimp_subscription;
    }

}

function func_mailchimp_get_subscription($userinfo)
{//{{{
    global $mailchimp_subscription;
    if (empty($userinfo['mailchimp_subscription'])) {
        $lists_by_email = func_mailchimp_get_list_by_email($userinfo['email']);
        if (!empty($lists_by_email)) {
            $mailchimp_subscription = array();
            foreach ($lists_by_email as $v) {
                $mailchimp_subscription[$v] = true;
            }
        }
   } else {
      $mailchimp_subscription = $userinfo['mailchimp_subscription'];
   }

}//}}}

function func_mailchimp_assign_to_smarty(){

    global $smarty, $sql_tbl, $mailchimp_subscription, $mc_newslists, $shop_language;

    if (isset($mailchimp_subscription)) {
         $smarty->assign('mailchimp_subscription', $mailchimp_subscription);
    }
    $mc_newslists = func_query("SELECT * FROM $sql_tbl[mailchimp_newslists] WHERE avail='Y' AND subscribe='Y' AND lngcode='$shop_language'");
    $smarty->assign('mc_newslists', $mc_newslists);
}

function func_mailchimp_unsubscribe_newslists($email){

    global $sql_tbl, $mc_newslists, $redirect_to;

    $mc_newslists = func_query("SELECT * FROM $sql_tbl[mailchimp_newslists] WHERE avail='Y'");
    if (count($mc_newslists) > 0) {
       foreach ($mc_newslists as $list){
           func_mailchimp_unsubscribe($email, $list['mc_list_id']);
       }
   }
   func_header_location($redirect_to . '/home.php?mode=unsubscribed&email=' . urlencode(stripslashes($email)));
}

function func_mailchimp_adm_get_currencies()
{//{{{
    global $sql_tbl;

    return func_query_hash("SELECT code, CONCAT(name, ' (', code, ')') FROM $sql_tbl[currencies] ORDER BY name", 'code', false, true);
}//}}}

function func_mailchimp_adm_get_stores()
{//{{{
    global $config, $sql_tbl;

    if (empty($config['Adv_Mailchimp_Subscription']['adv_mailchimp_apikey'])) {
        return array();
    }

    $lists = func_mailchimp_get_lists();

    if (empty($lists)) {
        return array('');
    }

    $saved_stores = func_query_hash("SELECT list_code,store_code,name FROM $sql_tbl[mailchimp_default_stores]", 'list_code', false, false) ?: array();

    $list_ids = array();

    foreach ($lists['data'] as $list) {
        $list_ids[] = $list['id'];

        if (isset($saved_stores[$list['id']])) {
            continue;
        }
        $list = array('list_id' => $list['id'], 'list_name' => $list['name']);
        $added_store = XCMailChimpEcomm::getStoreIdByListId($list['list_id'], 'get_all_fields') ?: XCMailChimpEcomm::addStore($list, 'get_all_fields');

        if (!empty($added_store['id'])) {
            db_query("INSERT INTO $sql_tbl[mailchimp_default_stores] SET list_code='" . addslashes($added_store['list_id']) . "', store_code='$added_store[id]', name='" . addslashes($added_store['name']) . "'");
            $added = true;
        }
    }
    db_query("DELETE FROM $sql_tbl[mailchimp_default_stores] WHERE list_code NOT IN ('".implode("', '", $list_ids)."')");

    if (db_affected_rows() > 0 || !empty($added) || empty($saved_stores)) {
        $saved_stores = func_query_hash("SELECT store_code,name FROM $sql_tbl[mailchimp_default_stores]", 'store_code', false, true) ?: array();
    } else {
        $new_saved_stores = array();
        foreach ($saved_stores as $k=>$store) {
            $new_saved_stores[$store['store_code']] = $store['name'];
        }
        $saved_stores = $new_saved_stores;
    }

    array_unshift($saved_stores, '');

    return $saved_stores;
}//}}}
