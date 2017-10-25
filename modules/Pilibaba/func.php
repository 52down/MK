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
|                                                                             |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

/**
 * Functions of the Pilibaba module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ildar Amankulov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v23 (xcart_4_7_7), 2017-01-23 20:12:10, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header('Location: ../../'); die('Access denied'); }

if (defined('AREA_TYPE') && in_array(AREA_TYPE, array('A', 'P'))) {
    global $xcart_dir;
    require $xcart_dir . XC_DS . 'modules' . XC_DS . 'Pilibaba' . XC_DS . 'backend_func.php';
}

class XCPilibaba {
    public static function getSettings() {//{{{
        global $config;
        $_params = array(
            'version' => 'V2.0.01',
            'merchantNo' => $config['Pilibaba']['pilibaba_merchant_no'],
            'currencyType' => $config['Pilibaba']['pilibaba_currency'],
            'shipper' => $config['Pilibaba']['pilibaba_shipping_fee'],
            'appSecret' => $config['Pilibaba']['pilibaba_secret_key'],
            'pilibaba_host' => $config['Pilibaba']['pilibaba_mode'] == 'test' ? 'http://pre.pilibaba.com' : 'https://www.pilibaba.com',
            'is_test_mode' => $config['Pilibaba']['pilibaba_mode'] == 'test',
        );
        return $_params;
    }//}}}

    public static function generateOrderNo($ref) {//{{{
        //TODO add security key ?
        global $config, $sql_tbl;
        // http://api.pilibaba.com/v2/doc.html#!pilipay-http-api-reference.md Max Length    50
        $max_length = 50;

        $id = func_array2insert("$sql_tbl[pilibaba_service_orders]", array('ref' => $ref, 'expire' => XC_TIME + SECONDS_PER_DAY / 24));
        $prefix = $config['Pilibaba']['pilibaba_prefix'];
        $no = substr($prefix, 0, $max_length - strlen($id) - 1) . $id;
        return $no;
    }//}}}

    public static function getSignMsg($data) {//{{{
        $_params = self::getSettings();
        $str = $data['version'] . $data['merchantNo'] . $data['currencyType'] . $data['orderNo'] . $data['orderAmount'] . $data['orderTime'] . $data['pageUrl'] . $data['serverUrl'] . $data['redirectUrl'] . $data['notifyType'] . $data['shipper'] . $data['tax'] . $data['signType'] . $_params['appSecret'];

        return md5($str);
    }//}}}

    public static function deleteExpiredServiceOrders() {//{{{
        global $sql_tbl;

        db_query("DELETE FROM $sql_tbl[pilibaba_service_orders] WHERE expire < '" . XC_TIME . "'");
        db_query("DELETE FROM $sql_tbl[pilibaba_data] WHERE expire < '" . XC_TIME . "'");
    }//}}}

}

class XCPilibabaCart {
    protected $old_data;
    protected $old_anonymous_userinfo;

    public function backupOld() {//{{{
        global $login, $logged_userid, $cart, $config;
        x_session_register('cart');
        $this->old_data = compact('cart', 'logged_userid', 'login', 'config');
        $this->old_anonymous_userinfo = func_get_anonymous_userinfo();
    }//}}}

    public function regenerateCart($params) {//{{{
        global $login, $logged_userid, $cart, $config;
        x_session_register('cart');
        $this->backupOld();

        $logged_userid = 0;
        $login = '';
        $cart = func_cart_set_shippingid($cart, 0);
        if (!empty($params['shipper'])) {
            $cart['shipping_cost_alt'] = $params['shipper'];
            $cart['use_shipping_cost_alt'] = 'Y';
            $cart['delivery'] = 'Pilibaba';
        }

        $warehouse = empty($config['Pilibaba']['pilibaba_warehouse_address']) ? array() : unserialize(base64_decode($config['Pilibaba']['pilibaba_warehouse_address']));
        if (!empty($warehouse)) {

            func_set_anonymous_userinfo(array());
            $config['General']['apply_default_country'] = 'Y';
            $config['General']['default_state'] = $warehouse['isoStateCode'];
            $config['General']['default_country'] = $warehouse['iso2CountryCode'];
            $config['General']['default_zipcode'] = $warehouse['zipcode'];
            $config['General']['default_city'] = $warehouse['city'];
            func_pilibaba_checkout_debug("\t+ warehouse_address is used $warehouse[isoStateCode]|$warehouse[iso2CountryCode]|$warehouse[zipcode]|$warehouse[city]");
        }

        list($cart, $products) = func_generate_products_n_recalculate_cart();
        $cart = func_cart_set_shippingid($cart, 0);
        settype($cart['userinfo'], 'array');
        func_pilibaba_checkout_debug("\t+ cart totals:total_cost:$cart[total_cost] shipping_cost:$cart[shipping_cost] payment_surcharge:$cart[payment_surcharge] tax_cost:$cart[tax_cost]");

        return $cart;
    }//}}}

    public function restoreOld() {//{{{
        global $login, $logged_userid, $cart, $config;
        x_session_register('cart');

        extract($this->old_data);
        func_set_anonymous_userinfo($this->old_anonymous_userinfo);
    }//}}}
}

/*
* dynamically add {include file="modules/Pilibaba/checkout_btn.tpl" btn_place="cart"} call to customer/main/cart.tpl
*/
function func_pilibaba_tpl_insertButton($tpl_name, $tpl_source) {//{{{
    if (strpos($tpl_source, 'pilibaba_enabled') !== false) {
        return $tpl_source;
    }

    // add button {include file="modules/Pilibaba/checkout_btn.tpl" btn_place=...
    #lintoff
    $search = '%{if \$amazon_pa_enabled}[^{]*{include file="modules/Amazon_Payments_Advanced/checkout_btn.tpl"[^{]*{/if}%Ss';
    $tpl_source = preg_replace_callback($search,
        function ($matches) {
            return $matches[0] . "\n" . str_replace(
                array('amazon_pa_enabled', 'Amazon_Payments_Advanced'),
                array('pilibaba_enabled','Pilibaba'), $matches[0]);
        },
        $tpl_source
    );

    if (strpos($tpl_source, 'pilibaba_enabled') === false) {
        $search = '%{if \$amazon_enabled}[^{]*{include file="modules/Amazon_Checkout/checkout_btn.tpl"[^{]*{/if}%Ss';
        $tpl_source = preg_replace_callback($search,
            function ($matches) {
                return $matches[0] . "\n" . str_replace(
                    array('amazon_enabled', 'Amazon_Checkout'),
                    array('pilibaba_enabled','Pilibaba'), $matches[0]);
            },
            $tpl_source
        );
    }

    if (strpos($tpl_source, 'pilibaba_enabled') === false) {
        $search = '%{if \$gcheckout_enabled}[^{]*{include file="modules/Google_Checkout/gcheckout_button.tpl"[^{]*{/if}%Ss';
        $tpl_source = preg_replace_callback($search,
            function ($matches) {
                return $matches[0] . "\n" . str_replace(
                    array('gcheckout_enabled', 'Google_Checkout/gcheckout_button.tpl'),
                    array('pilibaba_enabled','Pilibaba/checkout_btn.tpl'), $matches[0]);
            },
            $tpl_source
        );
    }

    if (strpos($tpl_source, 'pilibaba_enabled') === false) {
        $search = '%{if \$paypal_express_active}[^{]*{include file="payments/ps_paypal_pro_express_checkout.tpl"[^{]*{/if}%Ss';
        $tpl_source = preg_replace_callback($search,
            function ($matches) {
                return $matches[0] . "\n" . str_replace(
                    array('paypal_express_active', 'payments/ps_paypal_pro_express_checkout.tpl'),
                    array('pilibaba_enabled','modules/Pilibaba/checkout_btn.tpl'), $matches[0]);
            },
            $tpl_source
        );
    }

    // add {if $paypal_express_active || $amazon_pa_enabled || $pilibaba_enabled}
    $tpl_source = str_replace('{if $paypal_express_active || $amazon_pa_enabled', '{if $paypal_express_active || $amazon_pa_enabled || $pilibaba_enabled', $tpl_source);
    $tpl_source = str_replace('{if $paypal_express_active || $amazon_enabled', '{if $paypal_express_active || $amazon_enabled || $pilibaba_enabled', $tpl_source);
    $tpl_source = str_replace('{if $gcheckout_enabled or $paypal_express_active', '{if $gcheckout_enabled or $paypal_express_active || $pilibaba_enabled', $tpl_source);
    #linton

    if (defined('XC_PILIBABA_DEBUG')) {
       x_log_add('pilibaba_patched_files', 'patched_file:' . $tpl_name . "\n" . $tpl_source);
    }

    return $tpl_source;
}//}}}

function func_pilibaba_checkout_debug($message, $data = false) {//{{{
    global $pilibaba_checkout_log, $pilibaba_checkout_full_log;
    global $is_pilibaba_checkout_log_detailed;

    if (!defined('XC_PILIBABA_DEBUG') || empty($message)) {
        return true;
    }

    $pilibaba_checkout_log .= $message . "\n";

    if ($data && $is_pilibaba_checkout_log_detailed) {
        $pilibaba_checkout_full_log .= $message . "\n";
        $message = print_r($data, true);
        $message = preg_replace('/^\s*/m', '', $message);
        $message = preg_replace('/(.*)/m', "\t\t" . '$1', $message);
        $pilibaba_checkout_full_log .= $message . "\n";
    } else {
        $pilibaba_checkout_full_log .= $message . "\n";
    }

    return true;
}//}}}

/**
 * Attention! Must be called from global scope
 */
function func_pilibaba_checkout_restore_session_n_global($skey) {//{{{
    global $cart, $sql_tbl, $user_account, $products;

    $sessid = func_query_first_cell("SELECT sessid FROM $sql_tbl[cc_pp3_data] WHERE ref = '$skey'");
    if (empty($sessid)) {
        func_pilibaba_checkout_debug("\t+ [Error]: Absent ref: #$skey in xcartcc_pp3_data.");
        return false;
    }

    x_session_id($sessid);
    x_session_register('login');#nolint
    x_session_register('login_type');#nolint
    x_session_register('logged_userid');#nolint
    x_session_register('cart');#nolint
    x_session_register('user_tmp', array());#nolint
    x_session_register('current_carrier');#nolint

    // Do not initialize session vars from global. Use session values
    global $login, $login_type, $logged_userid, $cart, $user_tmp, $current_carrier;

   $saved_cart = func_query_first_cell("SELECT cart FROM $sql_tbl[pilibaba_data] WHERE ref='$skey'");
    if (!empty($saved_cart)) {
        $cart = unserialize($saved_cart);
    } else {
        func_pilibaba_checkout_debug("\t+ [Error]: Absent cart ref: #$skey in $sql_tbl[pilibaba_data].");
    }

    $products = func_pilibaba_products_in_cart($cart);

    $sess_result = !empty($cart);

    return $sess_result;
}//}}}

function func_pilibaba_checkout_save_log() {//{{{
    global $pilibaba_checkout_log, $pilibaba_checkout_full_log;
    global $is_pilibaba_checkout_log_detailed;

    if (!defined('XC_PILIBABA_DEBUG'))
        return true;

    if (!empty($pilibaba_checkout_log)) {

        list($_usec, $_sec) = explode(" ", constant('XCART_START_TIME'));
        list($_usec2, $_sec2) = explode(" ", microtime());

        $pilibaba_checkout_log .= "\t+ Running time (in seconds): " . (($_usec2 + $_sec2) - ($_usec + $_sec)) . "\n";

        if (XC_PILIBABA_DEBUG != 1) {
            // Preparing for sending to e-mail
            $emails_array = explode(',', XC_PILIBABA_DEBUG);
            x_log_add('pilibaba_checkout', $pilibaba_checkout_log, false, 0, $emails_array, true);
        }
        else
            x_log_add('pilibaba_checkout', $pilibaba_checkout_log);
    }

    if (!empty($pilibaba_checkout_full_log)) {
        $pilibaba_checkout_full_log .= "\t+ Running time (in seconds): " . (($_usec2 + $_sec2) - ($_usec + $_sec)) . "\n";
        x_log_add('pilibaba_checkout_full', $pilibaba_checkout_full_log);
    }

    return true;
}//}}}

function func_pilibaba_checkout_wait_for_orders_from_callback($skey, $wait_time = 20) {//{{{
    global $sql_tbl;

    $order_status = func_query_first_cell("SELECT param2 FROM $sql_tbl[cc_pp3_data] WHERE ref='$skey'");

    if (empty($order_status)) {

        // Return before callback
        $counter = $wait_time;

        do {
            sleep(1);
            $order_status = func_query_first_cell("SELECT param2 FROM $sql_tbl[cc_pp3_data] WHERE ref='$skey'");
        } while (
            empty($order_status)
            && $counter-- > 0
        );

    }

    return true;
}//}}}

function func_pilibaba_detect_state($state, $country, $zipcode = '') {//{{{
    global $sql_tbl;
    $state = trim($state);

    if ($s_code = func_query_first_cell("SELECT code FROM $sql_tbl[states] WHERE country_code='$country' AND (state='$state' OR code='$state')")) {
        return $s_code;
    } elseif ($country == 'GB') {

        x_load('user');
        if ($code = func_detect_state_by_zipcode($country, $zipcode)) {
            return $code;
        }
    }

    return 'Other';
}//}}}

/**
 * This function prepares string $str for including into the XML request
 */
function func_pilibaba_pre_encode_4XML($str) {//{{{

    if (empty($str))
        return $str;

    if (function_exists('mb_detect_encoding')) {
        global $e_langs;
        global $default_charset;
        static $_charsets = false;

        // Define static $_charsets var at once
        if (empty($_charsets)) {
            if (in_array(strtoupper($default_charset), array('KOI8-R','CP866','WINDOWS-1251','CP1251')))
                $_charsets = 'RU';
            else {
                $_charsets = $e_langs;
                array_unshift($_charsets, 'UTF-8');
                $_charsets = array_values(array_unique($_charsets));
            }
        }

        if ($_charsets == 'RU') {
            #use predefined charset for russian codepages.
            $charset = $default_charset;
        } else {
            #http://bugs.php.net/bug.php?id=38138 mb_detect_encoding can return false in some cases
            $charset = mb_detect_encoding($str, $_charsets);
        }

        if ($charset == 'UTF-8')
            return $str;
        elseif (empty($charset))
            return mb_convert_encoding($str, "UTF-8", "ISO-8859-1");
        else
            return mb_convert_encoding($str, "UTF-8", $charset);
    }

    return utf8_encode($str);
}//}}}

function func_pilibaba_encode($str, $limit=0) {//{{{
    $str = func_pilibaba_pre_encode_4XML($str);

    if (!empty($limit)) {
        if (function_exists('mb_substr'))
            $str = mb_substr($str, 0, $limit, 'UTF-8');
        else
            $str = substr($str, 0, $limit);
    }

    return $str;
}//}}}

function func_pilibaba_get_choosen_shipping3($cart, $products, $shipping_name, $pilibaba_shipping) {
    // Get the shipping methods list with rates
    $_allowed_shipping_methods = func_get_shipping_methods_list($cart, $products, $cart['userinfo']);

    // Generate the full list of shipping methods for current address
    $shipping = array();
    if (!empty($_allowed_shipping_methods)) {
        foreach ($_allowed_shipping_methods as $_ship_method) {
            if (func_insert_trademark($_ship_method['shipping'], 'use_alt') == $shipping_name) {
                $shipping['shippingid'] = $_ship_method['shippingid'];
                $shipping['shipping'] = $_ship_method['shipping'];
                $shipping['rate'] = $_ship_method['rate'];
                break;
            }
        }
    }

    // Reserve way to resolve shipping
    if (empty($shipping)) {
        $shipping = $cart['pilibaba_shippings'][$pilibaba_shipping];
    }

    return $shipping;
}

function func_pilibaba_get_order_details3($data) {//{{{
    $allowed = array('orderNo', 'orderAmount', 'fee', 'orderTime', 'customerMail');
    $str = '';
    foreach($allowed as $name) {
        $str .= (empty($data[$name]) ? '' : "[$name] => " . $data[$name] . "\n");
    }
    return $str;
}//}}}

/**
 * Override xcart_taxes.price_includes_tax display_including_tax tax options for each tax from Pilibaba module settings
 */
function func_pilibaba_get_tax_options() {//{{{
    global $config;
    x_load('taxes');
    if ($config['Pilibaba']['pilibaba_display_including_tax'] == 'Y') {
        return func_tax_get_override_display_including_tax($config['Pilibaba']['pilibaba_display_including_tax']);
    } else {
        return array();
    }

} //}}}

function func_pilibaba_get_totals3($parsed, $pilibaba_products, $pilibaba_oid, $type = 'NEWORDERNOTIFICATION') {
    $a_total = 0;
    $a_total_shipping = 0;
    foreach ($pilibaba_products as $_prd) {
        $charges = func_array_path($_prd['raw_data'],"ITEMCHARGES/COMPONENT");
        $p_total = 0;
        $p_total_shipping = 0;
        foreach ($charges as $charge) {
            $_type = func_array_path($charge,"TYPE/0/#");
            $_charge = func_array_path($charge,"CHARGE/AMOUNT/0/#");
            if ($_type != 'PrincipalPromo' && $_type != 'ShippingPromo') {
                $p_total += $_charge;
            } else {
                $p_total -= $_charge;
            }

            if ($_type == 'Shipping')
                $p_total_shipping += $_charge;
        }
        $a_total += $p_total;
        $a_total_shipping += $p_total_shipping;
    }

    return array('shipping_cost'=>$a_total_shipping, 'total_cost'=>$a_total);
}

function func_pilibaba_handle_cancel($skey) {//{{{
    global $xcart_catalogs, $sql_tbl;

    func_cart_unlock();

    if (func_is_pilibaba_checkout_enabled()) {
        func_pilibaba_checkout_debug("\t+ Customer canceled Pilibaba transaction");
        func_pilibaba_checkout_debug("\t+ skey: $skey");
    }

    if (!empty($skey)) {
        $skey = preg_replace('/,.*/s', '', $skey);
        db_query("DELETE FROM $sql_tbl[cc_pp3_data] WHERE ref='$skey'");
        db_query("DELETE FROM $sql_tbl[pilibaba_data] WHERE ref='$skey'");
    }

    XCPilibaba::deleteExpiredServiceOrders();

    func_header_location($xcart_catalogs['customer'] . '/cart.php');
}//}}}

function func_pilibaba_handle_return($skey) {//{{{
    global $config, $sql_tbl, $xcart_catalogs;
    global $cart, $current_location, $smarty, $logged_userid, $top_message;

    // Customer returned back to X-Cart
    func_pilibaba_checkout_debug("\t+ Customer returned back to the shop");
    func_pilibaba_checkout_debug("\t+ skey: $skey");

    if (!empty($skey)) {

        // Display 'Please wait page'
        $smarty->webmaster_mode = false;

        func_flush(func_display('customer/main/payment_wait.tpl', $smarty, false));

        if (!defined('NO_RSFUNCTION')) {
            register_shutdown_function('func_payment_footer');
        }

        XCPilibaba::deleteExpiredServiceOrders();
        $wait_for_callback_sec = 90;
        func_pilibaba_checkout_wait_for_orders_from_callback($skey, $wait_for_callback_sec);

        $ret = func_query_first("SELECT sessid, param2,param3,param4 FROM $sql_tbl[cc_pp3_data] WHERE ref='$skey'");
        $order_status = $ret['param2'];
        $_orderids = $ret['param3'];

        x_session_register('cart');

        func_cart_unlock();

        x_session_register('logged_userid');
        if (empty($order_status) || $order_status == 'F') {
            $userinfo = func_userinfo($logged_userid, 'C');
            if (
                !empty($userinfo['email'])
                && !empty($cart['products'])
            ) {
                $cart_content = '';
                foreach ($cart['products'] as $product) {
                    $cart_content .= "Requested product: #$product[productid], productcode:$product[productcode]\n";
                }

                x_log_add('pilibaba_possible_lost_orders', "From $userinfo[email] cart \n :" . $cart_content);
            }

            if (empty($order_status)) {
                $cart = '';
                x_session_register('top_message');
                $top_message['content'] = func_get_langvar_by_name('txt_pilibaba_return_before_callback');
                $redirect_url = $current_location . DIR_CUSTOMER . '/home.php';
            } else {
                $bill_error = "error_ccprocessor_error";
                $reason = "&bill_message=".urlencode($ret['param4']);
                $redirect_url = $current_location.DIR_CUSTOMER."/error_message.php?error=".$bill_error.$reason;
            }
        } else {

            db_query("DELETE FROM $sql_tbl[cc_pp3_data] WHERE ref='$skey'");
            db_query("DELETE FROM $sql_tbl[pilibaba_data] WHERE ref='$skey'");

            if (empty($logged_userid)) {
                // reload session from callback to avoid error Id: 32
                x_session_id($ret['sessid']);
            }

            $cart = '';
            $redirect_url = $xcart_catalogs['customer']."/cart.php?mode=order_message&orderids=$_orderids";
        }

        func_pilibaba_checkout_debug("\t+ Order status: $order_status" . (empty($order_status) ? 'empty' : ''));
        func_pilibaba_checkout_debug("\t+ Redirect to: $redirect_url");

        func_header_location($redirect_url);

    } else {
        func_header_location($xcart_catalogs['customer']."/cart.php");
    }

    return true;
}//}}}

function func_pilibaba_header_exit($code) {//{{{
    global $_SERVER;
    $codes = array(500 => 'Internal Server Error', 403 => 'Forbidden', 503 => 'Service Unavailable');
    @header("$_SERVER[SERVER_PROTOCOL] $code ".$codes[$code]);
    exit;
}//}}}

function func_pilibaba_is_validated_callback($data) {//{{{
    $_params = XCPilibaba::getSettings();
    $str = $data['merchantNo'] . $data['orderNo'] . $data['orderAmount'] . $data['signType'] . $data['fee'] . $data['orderTime'] . $data['customerMail'] . $_params['appSecret'];
    return md5($str) == strtolower($data['signMsg']) && !empty($data['signMsg']);
}//}}}

function func_pilibaba_customer_info($pilibaba_oid) {//{{{
    $_params = XCPilibaba::getSettings();

    x_load('http');
    $post = array();
    $post['merchantNo'] = $_params['merchantNo'];
    $post['orderNo'] = $pilibaba_oid;
    $post['signType'] = 'MD5';
    $post['signMsg'] = md5($post['merchantNo'] . $post['orderNo'] . $post['signType'] . $_params['appSecret']);
    func_pilibaba_checkout_debug("\t+ REQUEST Consumer information: ", $post);

    if ($_params['is_test_mode']) {
        list($a, $return) = func_http_post_request(str_replace('http://', '', $_params['pilibaba_host']), '/pilipay/consumerInfo', func_http_build_query($post));
    } else {
        list($a, $return) = func_https_request('POST',"$_params[pilibaba_host]/pilipay/consumerInfo" , $post);
    }
    func_pilibaba_checkout_debug("\t+ RESPONSE Consumer information: ", $return);
    $data = empty($return) ? array() : json_decode($return, true);
    if (empty($data)) {
        return array();
    }
    $customer_info = array();
    $customer_info['email'] = empty($data['email']) ? '' : $data['email'];
    $customer_info['s_country'] = $customer_info['b_country'] = $data['country'];
    $customer_info['s_address'] = $customer_info['b_address'] = $data['address'];
    $customer_info['s_city'] = $customer_info['b_city'] = $data['city'];
    $pc = $data['zipcode'];
    if (preg_match('/(\d{5})\-(\d{4})/', $pc, $matches)) {
        $pc = $matches[1];
    }

    $customer_info['s_zipcode'] = $customer_info['b_zipcode'] = $pc;
    $customer_info['s_state'] = $customer_info['b_state'] = func_pilibaba_detect_state($data['province'], $customer_info['s_country'], $customer_info['s_zipcode']);
    $customer_info['s_phone'] = $customer_info['b_phone'] = $data['mobile'];

    $log_addr = implode(",", array_unique($customer_info));
    $log_addr = str_replace("\n","", $log_addr);
    func_pilibaba_checkout_debug("\t+ Parsed address: $log_addr");

    $customer_info['address'] = array();
    $customer_info['address']['B']['country'] = $customer_info['b_country'];
    $customer_info['address']['B']['address'] = $customer_info['b_address'];
    $customer_info['address']['B']['city']    = $customer_info['b_city'];
    $customer_info['address']['B']['state']   = $customer_info['b_state'];
    $customer_info['address']['B']['zipcode'] = $customer_info['b_zipcode'];
    $customer_info['address']['B']['phone']   = $customer_info['b_phone'];

    if (!empty($data['name'])) {
        $customer_info['address']['B']['firstname'] = $data['name'];
        $customer_info['firstname'] = $data['name'];
        $customer_info['lastname'] = empty($customer_info['lastname']) ? $data['name'] : $customer_info['lastname'];
    }

    $customer_info['address']['S'] = $customer_info['address']['B'];
    return $customer_info;
}//}}}

function func_pilibaba_products_in_cart($cart) {//{{{
    global $user_account;

    return func_products_in_cart($cart, (!empty($user_account['membershipid']) ? $user_account['membershipid'] : ''), func_pilibaba_get_tax_options());
}//}}}

function func_pilibaba_price_format($price) {//{{{
    return intval($price * 100);
}//}}}

function func_pilibaba_submit_encoded_cart($fields) {//{{{
    global $smarty, $config, $HTTPS;

    // Lock cart for all operations
    func_cart_lock('by_Pilibaba');
    $_params = XCPilibaba::getSettings();

    echo func_display('modules/Pilibaba/waiting.tpl', $smarty, false);
    $url = "$_params[pilibaba_host]/pilipay/payreq";
    func_pilibaba_checkout_debug("\t+ URL $url");
    if ($_params['is_test_mode'] && $HTTPS) {
        x_load('http');
        $fields['notifyType'] = 'json';

        list($a, $return) = func_http_post_request(str_replace('http://', '', $_params['pilibaba_host']), '/pilipay/payreq', func_http_build_query($fields));
        func_pilibaba_checkout_debug("\t+ response_headers", $a);
        $headers = preg_split("/[\n\r]/", $a);
        foreach ($headers as $header) {
            if (
                preg_match('/^Location: (.*)/', $header, $match)
                && is_url($match[1])
            ) {
                func_pilibaba_checkout_debug("\t+ redirect to $match[1]");
                func_header_location($match[1]);
            }
        }
        func_pilibaba_checkout_debug("\t+ cannot redirect. URL cannot be parsed", $return);
        return false;
    } else {
        func_create_payment_form($url, $fields, 'Pilibaba', 'post');
    }
    return true;
}//}}}

function func_pilibaba_Cart_Items($cart) {//{{{
    $items = array();
    $items = func_array_merge($items, func_pilibaba_Cart_Items_products($cart));
    $items = func_array_merge($items, func_pilibaba_Cart_Items_giftcerts($cart));

    return json_encode($items);
}//}}}

function func_pilibaba_Cart_Items_products($cart) {//{{{
    global $config, $shop_language;

    $products = func_pilibaba_products_in_cart($cart);

    if (empty($products)) {
        func_pilibaba_checkout_debug("\t+ products array is empty");
        return array();
    } else {
        func_pilibaba_checkout_debug("\t+ " . count($products) . " products sending");
    }

    x_load('clean_urls');

    $items = array();
    // Generate products list
    foreach ($products as $product) {
        $Description    = func_payment_product_description($product);

        $URL = htmlspecialchars(func_get_resource_url("product", $product['productid']));

        $image_ids = array('P' => $product['productid'] , 'T' => $product['productid']);
        $image_data = func_get_image_url_by_types($image_ids, 'P');
        $Image_URL = htmlspecialchars($image_data['image_url']);
        if (!is_url($Image_URL)) {
            $Image_URL = func_get_default_image('T', 'get_absolute_link');
        }

        $items[] = array(
            'name' => func_pilibaba_encode($product['product'], 255),
            'pictureUrl' => $Image_URL,
            'price' => !empty($product['taxed_price']) ? func_pilibaba_price_format($product['taxed_price']) : 0,
            'productUrl' => $URL,
            'productId' => substr($product['productcode'],0 , 50),
            'quantity' => $product['amount'],
            'weight' => func_pilibaba_Item_Weight($product['weight']),
            'attr' => func_pilibaba_encode($Description, 2000),
        );
    }

    return $items;
}//}}}

function func_pilibaba_Cart_Items_giftcerts($cart) {//{{{
    global $config, $smarty, $xcart_catalogs;

    if (empty($cart['giftcerts']))
        return array();

    func_pilibaba_checkout_debug("\t+ " . count($cart['giftcerts']) . " giftcerts sending");

    $Image_URL = $smarty->getTemplateVars('ImagesDir') . '/gift.gif';

    foreach ($cart['giftcerts'] as $gcindex => $_giftcert) {

        $_descr = func_pilibaba_encode(func_get_langvar_by_name('lbl_recipient', '', false, true) . ': ' . $_giftcert['recipient'], 200);
        $_title = func_pilibaba_encode(func_get_langvar_by_name('lbl_gift_certificate', '', false, true), 255);
        $SKU = md5(implode($_giftcert)) . '|' . $gcindex . 'gc';

        $items[] = array(
            'attr' => $_descr,
            'name' => $_title,
            'pictureURL' => $Image_URL,
            'price' => func_pilibaba_price_format($_giftcert['amount']),
            'productURL' => $xcart_catalogs['admin'] . '/giftcerts.php',
            'productId' => substr($SKU,0 , 50),
            'quantity' => 1,
            'weight' => 0,
        );

    }

    return $items;
}//}}}

function func_pilibaba_Item_Weight($product_weight) {//{{{
    return intval(func_weight_in_grams($product_weight));
}//}}}

function func_pilibaba_Order($userinfo) {//{{{
    global $login, $logged_userid, $xcart_catalogs, $https_location, $http_location, $acheckout_saved_ips, $CLIENT_IP, $PROXY_IP, $cart, $config, $sql_tbl, $XCARTSESSID, $xcart_http_host;

    $unique_id = func_generate_n_save_uniqueid('txt_pilibaba_checkout_impossible_error');
    $orderNo = XCPilibaba::generateOrderNo($unique_id);
    $params = XCPilibaba::getSettings();

    func_pilibaba_checkout_debug("\t+ skey: $unique_id");
    func_pilibaba_checkout_debug("\t+ orderNo: $orderNo");
    func_pilibaba_checkout_debug("\t+ login: $login, logged_userid: $logged_userid");

    x_session_register('acheckout_saved_ips');
    $acheckout_saved_ips = array('ip' => $CLIENT_IP, 'proxy_ip' => $PROXY_IP);


    $xcart_cart_obj = new XCPilibabaCart();
    $cart = $xcart_cart_obj->regenerateCart($params);

    $_redirect_location_return = $_redirect_location_callback = $params['is_test_mode'] ? $http_location : $https_location;
    if (defined('XC_NGROK_PROXY')) {
        $_redirect_location_callback = str_replace($xcart_http_host, XC_NGROK_PROXY, $_redirect_location_callback);
    }
    $fields = array();
    $fields['version'] = $params['version'];
    $fields['merchantNo'] = $params['merchantNo'];
    $fields['currencyType'] = $params['currencyType'];
    $fields['orderNo'] = $orderNo;
    $fields['orderAmount'] = func_pilibaba_price_format($cart['total_cost']);
    $fields['orderTime'] = date("Y-m-d H:i:s", XC_TIME);
    $fields['sendTime'] = date("Y-m-d H:i:s", XC_TIME);
    $fields['pageUrl'] = $xcart_catalogs['customer'] . "/cart.php?mode=checkout";
    $fields['serverUrl'] = "$_redirect_location_callback/payment/ps_pilibaba.php?skey=$unique_id&mode=callback";
    $fields['redirectUrl'] = "$_redirect_location_return/payment/ps_pilibaba.php?skey=$unique_id&mode=return";
    $fields['notifyType'] = 'html';
    $fields['shipper'] = func_pilibaba_price_format($cart['shipping_cost']);
    $fields['tax'] = func_pilibaba_price_format($cart['tax_cost']);
    $fields['signType'] = 'MD5';
    $fields['signMsg'] = XCPilibaba::getSignMsg($fields);
    $goodsList = func_pilibaba_Cart_Items($cart);
    $fields['goodsList'] = urlencode($goodsList);
    func_pilibaba_checkout_debug("\t\t+ urldecoded goodsList", $goodsList);

    db_query("REPLACE INTO $sql_tbl[pilibaba_data] (ref,cart,sessid,expire) VALUES ('$unique_id','".addslashes(serialize($cart))."','$XCARTSESSID', '" . (XC_TIME + SECONDS_PER_DAY * 30) . "')");
    $xcart_cart_obj->restoreOld();

    return $fields;
}//}}}

/**
 * Check if Pilibaba can be used
 */
function func_is_pilibaba_checkout_enabled() {//{{{
    global $pilibaba_enabled;
    return isset($pilibaba_enabled) ? $pilibaba_enabled : false;
}//}}}

function func_pilibaba_log_raw_post_get_data() {//{{{
    global $var_dirs, $is_pilibaba_checkout_log_detailed, $PROXY_IP, $CLIENT_IP;

    if (defined('XC_PILIBABA_DEBUG') && $is_pilibaba_checkout_log_detailed) {
        $postdata = func_get_raw_post_data();
        // Save received data to the unique log file
        $filename = $var_dirs['log'] . "/pilibaba_checkout-incoming-" . date("Ymd-His") . "-" . uniqid(mt_rand()) . '.log.php';
        if ($fd = @fopen($filename, "a+")) {

            $str[] = "REQUEST_URI: " . 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
            $str[] = "PROXY_IP: $PROXY_IP";
            $str[] = "CLIENT_IP: $CLIENT_IP";

            ob_start();
            echo "\n_GET:\n";
            print_r($_GET);
            echo "\n_POST:\n";
            print_r($_POST);
            echo "\nHTTP_RAW_POST_DATA:\n";
            print_r($postdata);
            $str[] = ob_get_contents();
            ob_end_clean();
            fwrite($fd, "<" . "?php die(); ?" . ">\n\n" . implode("\n\n", $str));
            fclose($fd);
            func_chmod_file($filename);
        }
    }
}//}}}

function func_pilibaba_checkout_init() {//{{{

    global $config, $smarty, $pilibaba_enabled, $PHP_SELF;
    global $is_pilibaba_checkout_log_detailed, $pilibaba_checkout_log, $pilibaba_checkout_full_log, $xcart_dir;

    $area = (defined('AREA_TYPE')) ? AREA_TYPE : '';
    if (in_array($area, array('A','P'))) {
        if (
            basename($PHP_SELF) == 'configuration.php'
            && isset($_GET['option']) && $_GET['option'] == 'Pilibaba'
        ) {
            $smarty->assign('additional_config', 'modules/Pilibaba/config.tpl');
        }
    }

    if (defined('QUICK_START')) {
        return;
    }

    if ($area != 'C') {
        return;
    }

    if (version_compare($config['version'], XC_PILIBABA_WITH_ENTRY_POINTS) < 0 && !defined('XC_PILIBABA_IS_IN_CORE')) {
        require $xcart_dir . XC_DS . 'modules' . XC_DS . 'Pilibaba' . XC_DS . 'lib' . XC_DS . 'dynamic_tpl_patcher.php';//pilibaba_compatible; conflict with xcart/modules/XAuth/ext.core.php <=4.7.3

        modules\Pilibaba\lib\x_tpl_add_callback_patch('customer/main/cart.tpl', 'func_pilibaba_tpl_insertButton', modules\Pilibaba\lib\X_TPL_PREFILTER);
        modules\Pilibaba\lib\x_tpl_add_callback_patch('customer/minicart.tpl', 'func_pilibaba_tpl_insertButton', modules\Pilibaba\lib\X_TPL_PREFILTER);
        modules\Pilibaba\lib\x_tpl_add_callback_patch('modules/Add_to_cart_popup/product_added.tpl', 'func_pilibaba_tpl_insertButton', modules\Pilibaba\lib\X_TPL_PREFILTER);
    }

    $is_pilibaba_checkout_log_detailed = false;
    if (defined('XC_PILIBABA_DEBUG')) {
        // Logging enabled
        if (XC_PILIBABA_DEBUG == 1) {
            $is_pilibaba_checkout_log_detailed = true;
        }

        $pilibaba_checkout_log = '';
        $pilibaba_checkout_full_log = '';

        register_shutdown_function('func_pilibaba_checkout_save_log');
    }

} //}}}

function func_pilibaba_orders_exists() {//{{{
    return true;
}//}}}
