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
 * Checkout by Amazon
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    66e89d0c1e8c45e8c34326414f7b388164d03414, v33 (xcart_4_7_8), 2017-04-18 12:52:27, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 *
 */

if ( !defined('XCART_SESSION_START') ) { header('Location: ../../'); die('Access denied'); }

func_amazon_pa_load_classes();

class XCPayWithAmazonClientDebug extends PayWithAmazon\Client {
    protected function setParametersAndPost($parameters, $fieldMappings, $requestParameters)
    {//{{{
        static $logged_data = array();
        if (defined('X_PHP540_COMPAT')) {
            $backtrace = debug_backtrace(!DEBUG_BACKTRACE_PROVIDE_OBJECT | DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        } else {
            $backtrace = debug_backtrace(!DEBUG_BACKTRACE_PROVIDE_OBJECT | DEBUG_BACKTRACE_IGNORE_ARGS);
        }
        $caller = $backtrace[1]['function'];
        $res = parent::setParametersAndPost($parameters, $fieldMappings, $requestParameters);

        $result = print_r($res->toArray(), true);
        $result = XCAmazonUtils::highlightWords($result);

        $str = $caller . ':' . print_r($requestParameters, true) . "\n" . 'RESULT:' . $result;
        if (empty($logged_data[md5($str)])) {
            x_log_add('amazon_pa_full', $str, true);
            $logged_data[md5($str)] = 1;
        }

        return $res;
    }//}}}
}

class XCAmazonUtils {
    public static function getPrefixByIds($prefix, $orderids, $count_attempts=0) {//{{{
        // to support multiple orders
        $count_attempts = intval($count_attempts) + 10;
        return $count_attempts . $prefix . str_replace(',', '_', urldecode($orderids));
    }//}}}

    public static function parseOrderIds($prefix, $transaction_id) {//{{{
        // to support multiple orders
        $transaction_id = substr($transaction_id, 2);// remove count of attempts
        $_oid = str_replace($prefix, '', $transaction_id);
        return explode('_', $_oid);
    }//}}}

    public static function highlightWords($str) {//{{{
        foreach (array('NotificationType', 'State', 'AmazonOrderReferenceId', 'ReasonCode') as $word) {
            $str = str_replace("[$word]", "[<>$word]", $str);
        }
        return $str;
    }//}}}
}

class XCAmazonIPNOrderNotification {
    public static function sendMail2Buyer($OrderReference)
    {//{{{
        global $mail_smarty, $config;

        x_load('mail');
        $AmazonAuthorizationId = $OrderReference['AmazonOrderReferenceId'];

        $profile_info = func_amazon_pa_get_aorefid_profile_info($AmazonAuthorizationId, '');
        if (empty($profile_info['email'])) {
            return false;
        }

        $region = $config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_region'];
        $domains = array(
            'uk' => 'https://payments.amazon.co.uk',
            'us' => 'https://payments.amazon.com',
            'de' => 'https://payments.amazon.de',
            'jp' => 'https://payments.amazon.co.jp',
        );
        $domains['gb'] = $domains['uk'];
        $domain = isset($domains[$region]) ? $domains[$region] : $domains['us'];
        $url = $domain . '/mn/your-account/apa?action=renderOrderDetails&contractId=' . $AmazonAuthorizationId;

        $orderid = $OrderReference['SellerOrderAttributes']['SellerOrderId'];
        $mail_smarty->assign('profile', $profile_info);
        $mail_smarty->assign('url2update_pm', $url);
        $mail_smarty->assign('orderid', $orderid);
        $mail_templates_dir = 'modules/Amazon_Payments_Advanced/';

        func_send_mail(
            $profile_info['email'],
            $mail_templates_dir . 'mail/invalid_payment_method_subj.tpl',
            $mail_templates_dir . 'mail/invalid_payment_method.tpl',
            $config['Company']['orders_department'],
            false
        );

    }//}}}

    public static function authorize_2nd($AmazonOrderReferenceId)
    {//{{{
        global $sql_tbl;

        $function_res = array('authorized_oids' => false, 'order_status' => false, 'advinfo' => false);

        //request to get IdList
        $order_reference = func_amazon_pa_get_aorefid_details($AmazonOrderReferenceId, '');
        $order_reference = $order_reference['GetOrderReferenceDetailsResult']['OrderReferenceDetails'];

        // get amazon_authorization_id from BD
        $orderid = empty($order_reference['SellerOrderAttributes']['SellerOrderId']) ? 0 : explode(',', $order_reference['SellerOrderAttributes']['SellerOrderId']);

        if (empty($orderid[0])) {
            return $function_res;
        } else {
            $orderid = $orderid[0];
        }

        $amazonAPI = func_amazon_pa_get_client_API();
        $amazon_authorization_id = func_query_first_cell("SELECT value FROM $sql_tbl[order_extras] WHERE khash='amazon_pa_auth_id' AND orderid=" . intval($orderid));
        if (empty($amazon_authorization_id)) {
            return $function_res;
        }

        // get data of previous declined authorization
        $response = $amazonAPI->getAuthorizationDetails(array('amazon_authorization_id' => $amazon_authorization_id));

        if (
            ($result = $response->toArray())
            && !empty($result)
            && intval($result['ResponseStatus']) === 200
        ) {
            $declined_auth_details = $result['GetAuthorizationDetailsResult']['AuthorizationDetails'];
            $_reply_status = empty($declined_auth_details['AuthorizationStatus']['State']) ? '' : $declined_auth_details['AuthorizationStatus']['State'];
            $_reply_reason = empty($declined_auth_details['AuthorizationStatus']['ReasonCode']) ? '' : $declined_auth_details['AuthorizationStatus']['ReasonCode'];

            if (
                $_reply_status == 'Declined'
                && $_reply_reason == 'InvalidPaymentMethod'
            ) {
                // try to Authorize again
                $orderids = XCAmazonUtils::parseOrderIds(AMAZON_PA_AUTH_PREFIX, $declined_auth_details['AuthorizationReferenceId']);
                $orderids_url_ready = func_get_urlencoded_orderids($orderids);
                $prev_authorization_attempts = empty($order_reference['IdList']['member']) || !is_array($order_reference['IdList']['member']) ? array(1) : $order_reference['IdList']['member'];
                $count_of_authorization_attempts = count($prev_authorization_attempts);

                $requestParameters = array(
                    'authorization_reference_id'=> XCAmazonUtils::getPrefixByIds(AMAZON_PA_AUTH_PREFIX, $orderids_url_ready, $count_of_authorization_attempts),
                    'seller_authorization_note' => defined('AMAZON_PA_SIMULATE_CODE') || empty($declined_auth_details['SellerAuthorizationNote']) ? '' : $order_reference['SellerAuthorizationNote'],
                );

                $total_cost = $declined_auth_details['AuthorizationAmount']['Amount'];
                list($order_status, $advinfo, $amz_authorized) = XCAmazonOrder::authorize($order_reference['AmazonOrderReferenceId'], $total_cost, $orderids, $requestParameters);

                if (!empty($amz_authorized)) {
                    $function_res = array('authorized_oids' => $orderids, 'order_status' => $order_status, 'advinfo' => $advinfo);
                }

            }
        }

        return $function_res;
    }//}}}
}//XCAMazonIPNOrderNotification}}}

class XCAmazonOrder {
    public static function authorize($amazon_pa_order_ref_id, $total_cost, $orderids, $in_params = array())
    {//{{{
        global $config;

        $order_status = 'F';

        $amz_authorized = false;
        $amz_authorization_id = '';
        $amz_captured = false;
        $amz_capture_id = '';

        $advinfo = array("AmazonOrderReferenceId: $amazon_pa_order_ref_id");

        x_load('payment'); // payment is for Func_get_urlencoded_orderids
        $orderids_url_ready = func_get_urlencoded_orderids($orderids);
        $requestParameters = array(
            'amazon_order_reference_id' => $amazon_pa_order_ref_id,
            'authorization_amount'      => $total_cost,
            'currency_code'             => $config['Amazon_Payments_Advanced']['amazon_pa_currency'],
            'authorization_reference_id'=> XCAmazonUtils::getPrefixByIds(AMAZON_PA_AUTH_PREFIX, $orderids_url_ready),
            'capture_now'               => func_amazon_pa_is_API_capture_now(),
            'seller_authorization_note' => func_amazon_pa_get_API_seller_notes(),
            'transaction_timeout'       => func_amazon_pa_get_API_transaction_timeout(),
        );

        if (defined('AMAZON_PA_SIMULATE_CODE')) {
            $requestParameters['seller_authorization_note'] = AMAZON_PA_SIMULATE_CODE;
        }

        $requestParameters = array_merge($requestParameters, $in_params);

        $amazonAPI = func_amazon_pa_get_client_API();

        // response fields https://payments.amazon.co.uk/developer/documentation/apireference/201752450
        $response3 = $amazonAPI->authorize($requestParameters);
        if (
            ($result = $response3->toArray())
            && !empty($result)
            && intval($result['ResponseStatus']) === 200
        ) {
            if (
                isset($result['AuthorizeResult']['AuthorizationDetails'])
                && ($auth_details = $result['AuthorizeResult']['AuthorizationDetails'])
            ) {
                $amz_authorization_id = $auth_details['AmazonAuthorizationId'];
                $amz_authorization_status = $auth_details['AuthorizationStatus']['State'];

                $advinfo[] = "AmazonAuthorizationId: $amz_authorization_id";
                $advinfo[] = "AuthorizationStatus: $amz_authorization_status";

                func_amazon_pa_save_order_extra($orderids, 'amazon_pa_auth_id', $amz_authorization_id);
                func_amazon_pa_save_order_extra($orderids, 'amazon_pa_auth_status', $amz_authorization_status);
                func_amazon_pa_save_order_extra($orderids, 'amazon_pa_currency', $requestParameters['currency_code']);

                if ($amz_authorization_status == 'Declined') {
                    $order_status = 'D';
                }

                if ($amz_authorization_status == 'Pending') {
                    $order_status = 'Q'; // wait for IPN message
                }

                if ($amz_authorization_status == 'Open') {
                    $amz_authorized = true;
                }

                if ($amz_authorization_status == 'Closed') {

                    if (func_amazon_pa_is_API_capture_now()) {
                        // capture now mode
                        $amz_authorized = true;
                        $amz_captured = true;

                        $amz_authorization_capture_id = $auth_details['IdList']['member'];
                        func_amazon_pa_save_order_extra($orderids, 'amazon_pa_capture_id', $amz_authorization_capture_id);
                    }
                }
            } else {
                // log error
                func_amazon_pa_error('Unexpected authorize reply: $result=' . print_r($result, true));
            }
        }
        if ($amz_authorized) {
            if ($amz_captured) {
                // capture now mode, order is actually processed here
                $order_status = 'P';
            } else {
                // pre-auth
                $order_status = 'A';
            }
        }
        func_amazon_pa_debug('authorize:' . print_r($requestParameters, true));
        func_amazon_pa_debug('result:' . print_r($result, true));

        return array($order_status, $advinfo, $amz_authorized);
    }//}}}
}

function func_amazon_pa_debug($message, $suffix = '')
{ // {{{

    if (!defined('AMAZON_PA_DEBUG') || empty($message)) {
        return true;
    }
    $suffix = empty($suffix) ? '' : ('_' . $suffix);
    $message = XCAmazonUtils::highlightWords($message);
    x_log_add('amazon_pa' . $suffix, $message, true);
    return true;
} // }}}

function func_amazon_pa_error($message, $suffix = '')
{ // {{{
    $suffix = empty($suffix) ? '' : ('_' . $suffix);
    $message = XCAmazonUtils::highlightWords($message);
    x_log_add('amazon_pa' . $suffix, $message);
    return true;
} // }}}

/**
 * For PHP compability
 */
if (!function_exists('getallheaders')) { // {{{
    function getallheaders()
    { // {{{
        $headers = '';
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    } // }}}
} // }}}

/*
* dynamically add module patches to customer tpls
*/
function Smarty_prefilter_add_amazon_pa_entry_points($source, $smarty)
{//{{{
    global $xcart_dir;
    static $is_called ;

    if (!empty($is_called)) {
        return $source;
    }
    $is_called = 1;

    require $xcart_dir . XC_DS . 'modules' . XC_DS . 'Amazon_Payments_Advanced' . XC_DS . 'lib' . XC_DS . 'dynamic_tpl_patcher.php';//old_version_compatible; conflict with xcart/modules/XAuth/ext.core.php <=4.7.3
    modules\Amazon_Payments_Advanced\lib\x_tpl_add_callback_patch('modules/One_Page_Checkout/opc_payment.tpl', 'func_amazon_pa_patch_opc_payment_tpl', modules\Amazon_Payments_Advanced\lib\X_TPL_PREFILTER);

    return $source;
}//}}}

function func_amazon_pa_patch_opc_payment_tpl($tpl_name, $tpl_source)
{//{{{
    global $xcart_dir;

    if (strpos($tpl_source, '$payment_standalone}') !== false) {#lintoff
        return $tpl_source;
    }

    // add to the end od skin/common_files/modules/One_Page_Checkout/opc_payment.tpl
    $snippet =<<<EOT
        {if \$payment_standalone}
        {load_defer_code type="css"}
        {load_defer_code type="js"}
        {/if}\n
EOT;

    $tpl_source = preg_replace('%</div>\s*$%s', $snippet . '\\0', $tpl_source);
    #linton

    func_amazon_pa_tpl_debug($tpl_name, $tpl_source);

    return $tpl_source;
}//}}}

function func_amazon_pa_tpl_debug($tpl_name, $tpl_source)
{//{{{
    if (defined('AMAZON_PA_DEBUG')) {
       x_log_add('amazon_pa_patched_files', 'patched_file:' . $tpl_name . "\n" . $tpl_source);
    }
}//}}}

function func_amazon_pa_init()
{ // {{{
    global $smarty, $config;

    // check configuration compability issues
    if (
        func_constant('AREA_TYPE') == 'C'
        && (
            !func_amazon_pa_is_configured()
            || (
                ($amazon_pa_message = func_amazon_pa_has_compability_issues())
                && !empty($amazon_pa_message)
            )
        )
    ) {
        global $active_modules;

        // disable module for customers
        unset($active_modules[AMAZON_PAYMENTS_ADVANCED]);
        $smarty->assign('active_modules', $active_modules);

        return;
    }

    $smarty->assign('amazon_pa_enabled', true);

    if (defined('ADMIN_MODULES_CONTROLLER')) {
        if (function_exists('func_add_event_listener')) {
            func_add_event_listener('module.ajax.toggle', 'func_amazon_pa_on_module_toggle');
        }
    }

    if (defined('QUICK_START') || func_constant('AREA_TYPE') != 'C') {
        return;
    }

    if (version_compare($config['version'], XC_AMAZON_PA_WITH_ENTRY_POINTS) < 0 && !defined('XC_AMAZON_PA_IS_IN_CORE') && !empty($smarty)) {
        if (version_compare($config['version'], '4.7.0') >= 0) {
            // Smarty_prefilter_add_amazon_pa_entry_points is called here
            $smarty->addAutoloadFilters(array('add_amazon_pa_entry_points'), 'pre');
        } else {
            Smarty_prefilter_add_amazon_pa_entry_points('', null);
        }
    }

    return;
} // }}}

function func_amazon_pa_is_configured()
{ // {{{
    global $config;

    return (
        !empty($config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_sid'])
        && !empty($config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_access_key'])
        && !empty($config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_secret_key'])
        && !empty($config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_cid'])
    );
} // }}}

function func_amazon_pa_has_compability_issues()
{ // {{{
    global $config;

    if (empty($config['HTTPS_test_passed'])) {
        x_load('tests');
        list($https_check_success, $https_check_error) = test_https_availibility();
    } else {
        $https_check_success = $config['HTTPS_test_passed'] === 'Y';
    }

    return $https_check_success ? false : (!empty($https_check_error) ? $https_check_error : 'Unknown error');
} // }}}

function func_amazon_pa_on_module_toggle($module_name, $module_new_state)
{ // {{{

    global $sql_tbl, $active_modules;

    if (
        $module_name == AMAZON_PAYMENTS_ADVANCED
        && $module_new_state == true
        && !empty($active_modules['Amazon_Checkout'])
    ) {
        db_query("UPDATE $sql_tbl[modules] SET active = 'N' WHERE module_name = 'Amazon_Checkout'");
        return 'modules.php';
    }
} // }}}

function func_amazon_pa_load_classes()
{ // {{{
    if (!function_exists('func_amazon_pa_load_class')) {

        function func_amazon_pa_load_class($class_name)
        {
            global $xcart_dir;

            static $classesLibPayWithAmazon = array( // {{{
                'PayWithAmazon\Client' => 'Client',
                'PayWithAmazon\ClientInterface' => 'ClientInterface',
                'PayWithAmazon\HttpCurl' => 'HttpCurl',
                'PayWithAmazon\HttpCurlInterface' => 'HttpCurlInterface',
                'PayWithAmazon\IpnHandler' => 'IpnHandler',
                'PayWithAmazon\IpnHandlerInterface' => 'IpnHandlerInterface',
                'PayWithAmazon\Regions' => 'Regions',
                'PayWithAmazon\ResponseInterface' => 'ResponseInterface',
                'PayWithAmazon\ResponseParser' => 'ResponseParser',
            ); // }}}

            if (
                isset($classesLibPayWithAmazon[$class_name])
            ) {
                include $xcart_dir . XC_DS . 'modules' . XC_DS . AMAZON_PAYMENTS_ADVANCED . XC_DS . 'lib' . XC_DS . 'amazonLAP' . XC_DS . 'PayWithAmazon' . XC_DS . $classesLibPayWithAmazon[$class_name] . '.php';
                return;
            }
        }

        // register class loader
        spl_autoload_register('func_amazon_pa_load_class');
    }
} // }}}

function func_amazon_pa_is_API_in_test_mode()
{ // {{{
    global $config;

    return ($config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_mode'] === 'test');
} // }}}

function func_amazon_pa_get_client_API()
{ // {{{
    global $config;

    static $clientAPI = null;

    if (null === $clientAPI) {
        if (defined('AMAZON_PA_FULL_DEBUG')) {
            $clientAPI = new XCPayWithAmazonClientDebug(array(
                'merchant_id'   => $config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_sid'],
                'secret_key'    => $config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_secret_key'],
                'access_key'    => $config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_access_key'],
                'region'        => $config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_region'],
                'currency_code' => $config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_currency'],
                'sandbox'       => func_amazon_pa_is_API_in_test_mode(),
                'platform_id'   => AMAZON_PA_PLATFORM_ID,
                'application_name'    => 'X-Cart',
                'application_version' => $config['version'],
                'client_id'     => $config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_cid'],
            ));
        } else {
            $clientAPI = new PayWithAmazon\Client(array(
                'merchant_id'   => $config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_sid'],
                'secret_key'    => $config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_secret_key'],
                'access_key'    => $config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_access_key'],
                'region'        => $config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_region'],
                'currency_code' => $config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_currency'],
                'sandbox'       => func_amazon_pa_is_API_in_test_mode(),
                'platform_id'   => AMAZON_PA_PLATFORM_ID,
                'application_name'    => 'X-Cart',
                'application_version' => $config['version'],
                'client_id'     => $config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_cid'],
            ));
        }
    }

    return $clientAPI;
} // }}}

function func_amazon_pa_get_aorefid_details($aorefid, $aadct)
{ // {{{
    $details = array();

    $amazonAPI = func_amazon_pa_get_client_API();
    $response = $amazonAPI->getOrderReferenceDetails(array(
        'amazon_order_reference_id' => $aorefid,
        'address_consent_token' => $aadct,
    ));

    if (
        ($result = $response->toArray())
        && !empty($result)
        && intval($result['ResponseStatus']) === 200
    ) {
        $details = $result;
    }

    return $details;
} // }}}

function func_amazon_pa_detect_state($state, $country, $zipcode = '')
{ // {{{
    global $sql_tbl;

    $init_state = trim($state);

    if (($state_code = func_query_first_cell("SELECT code FROM $sql_tbl[states] WHERE country_code='$country' AND (state='$init_state' OR code='$init_state')"))) {

        return $state_code;

    } else {

        x_load('user');
        if (($state_code = func_detect_state_by_zipcode($country, $zipcode))) {
            return $state_code;
        }
    }

    return 'Other';
} // }}}

function func_amazon_pa_get_aorefid_billing_address($aorefid, $aadct)
{ // {{{
    $address = array();

    $result = func_amazon_pa_get_aorefid_details($aorefid, $aadct);

    if (!empty($result)) {
        if (
            isset($result['GetOrderReferenceDetailsResult']['OrderReferenceDetails']['BillingAddress'])
            && ($destination = $result['GetOrderReferenceDetailsResult']['OrderReferenceDetails']['BillingAddress'])
        ) {
            $address['zipcode'] = $destination['PostalCode'];
            $address['country'] = $destination['CountryCode'];
            $address['state'] = func_amazon_pa_detect_state($destination['StateOrRegion'], $destination['CountryCode'], $destination['PostalCode']);
            $address['city'] = $destination['City'];
            $address['phone'] = $destination['Phone'];
            $address['address'] = $destination['AddressLine1'];

            if (isset($destination['AddressLine2'])) {
                $address['address_2'] = $destination['AddressLine2'];
            }

            $list = explode(' ', $destination['Name'], 2);

            $address['firstname'] = isset($list[0]) ? $list[0] : '';
            $address['lastname'] = isset($list[1]) ? $list[1] : '';

            $address = func_prepare_address($address);
        }
    }

    return $address;
} // }}}

function func_amazon_pa_get_aorefid_shipping_address($aorefid, $aadct)
{ // {{{
    $address = array();

    $result = func_amazon_pa_get_aorefid_details($aorefid, $aadct);

    if (!empty($result)) {
        if (
            isset($result['GetOrderReferenceDetailsResult']['OrderReferenceDetails']['Destination']['PhysicalDestination'])
            && ($destination = $result['GetOrderReferenceDetailsResult']['OrderReferenceDetails']['Destination']['PhysicalDestination'])
        ) {
            $address['zipcode'] = $destination['PostalCode'];
            $address['country'] = $destination['CountryCode'];
            $address['state'] = func_amazon_pa_detect_state($destination['StateOrRegion'], $destination['CountryCode'], $destination['PostalCode']);
            $address['city'] = $destination['City'];
            $address['phone'] = $destination['Phone'];
            $address['address'] = $destination['AddressLine1'];

            if (isset($destination['AddressLine2'])) {
                $address['address_2'] = $destination['AddressLine2'];
            }

            $list = explode(' ', $destination['Name'], 2);

            $address['firstname'] = isset($list[0]) ? $list[0] : '';
            $address['lastname'] = isset($list[1]) ? $list[1] : '';

            $address = func_prepare_address($address);
        }
    }

    return $address;
} // }}}

function func_amazon_pa_get_aorefid_profile_info($aorefid, $aadct)
{ // {{{
    $profile = array();

    $result = func_amazon_pa_get_aorefid_details($aorefid, $aadct);

    if (!empty($result)) {
        if (
            isset($result['GetOrderReferenceDetailsResult']['OrderReferenceDetails']['Buyer'])
            && ($buyer = $result['GetOrderReferenceDetailsResult']['OrderReferenceDetails']['Buyer'])
        ) {
            $profile['email'] = $buyer['Email'];

            $list = explode(' ', $buyer['Name'], 2);

            $profile['firstname'] = isset($list[0]) ? $list[0] : '';
            $profile['lastname'] = isset($list[1]) ? $list[1] : '';
        }
    }

    return $profile;
} // }}}

function func_amazon_pa_get_API_seller_notes()
{ // {{{
    global $customer_notes;

    if (!func_amazon_pa_is_API_in_test_mode()) {
        return '';
    }

    return $customer_notes;
} // }}}

function func_amazon_pa_is_API_capture_now()
{ // {{{
    global $config;

    // capture immediate or not
    return ($config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_capture_mode'] == 'C');
} // }}}

function func_amazon_pa_is_API_sync_mode()
{ // {{{
    global $config;

    // sync request (returns only "open" or "declined" status, no "pending")
    return ($config[AMAZON_PAYMENTS_ADVANCED]['amazon_pa_sync_mode'] == 'S');
} // }}}

function func_amazon_pa_get_API_transaction_timeout()
{ // {{{
    $defaultTimeout = 1440;

    // sync request (returns only "open" or "declined" status, no "pending")
    return (func_amazon_pa_is_API_sync_mode() ? 0 : $defaultTimeout);
} // }}}

function func_ajax_block_amazon_pa_shipping()
{ // {{{
    global $smarty, $config, $sql_tbl, $active_modules, $xcart_dir;
    global $logged_userid, $login_type, $login, $cart, $userinfo, $is_anonymous, $user_account;
    global $xcart_catalogs, $xcart_catalogs_secure, $current_area;
    global $current_carrier, $shop_language;
    global $intershipper_rates, $intershipper_recalc, $dhl_ext_country_store, $checkout_module, $empty_other_carriers, $empty_ups_carrier, $amazon_enabled, $paymentid, $products;
    global $totals_checksum_init, $totals_checksum;

    if (!defined('ALL_CARRIERS')) {
        define('ALL_CARRIERS', 1);
    }

    x_load(
        'cart',
        'shipping',
        'product',
        'user'
    );

    x_session_register('cart');
    x_session_register('intershipper_rates');
    x_session_register('intershipper_recalc');
    x_session_register('current_carrier');
    x_session_register('dhl_ext_country_store');
    XCAjaxSessions::getInstance()->requestForSessionSave(__FUNCTION__);

    $userinfo = func_userinfo(0, $login_type, false, false, 'H');

    // Prepare the products data
    $products = func_products_in_cart($cart, @$userinfo['membershipid']);

    $intershipper_recalc = 'Y';

    $checkout_module = '';
    include $xcart_dir . '/include/cart_calculate_totals.php';

    $check_smarty_vars = array('dhl_account_used', 'checkout_module', 'is_other_carriers_empty', 'is_ups_carrier_empty', 'need_shipping', 'shipping_calc_error', 'shipping_calc_service', 'main', 'current_carrier', 'show_carriers_selector', 'dhl_ext_countries', 'has_active_dhl_smethods', 'dhl_ext_country');
    func_assign_smarty_vars($check_smarty_vars);
    $smarty->assign('main', 'checkout');
    $smarty->assign('userinfo', $userinfo);

    return func_ajax_trim_div(func_display('modules/One_Page_Checkout/opc_shipping.tpl', $smarty, false));
} // }}}

function func_ajax_block_amazon_pa_totals()
{ // {{{
    global $smarty, $config, $sql_tbl, $active_modules, $xcart_dir;
    global $logged_userid, $login_type, $login, $cart, $userinfo, $is_anonymous, $user_account;
    global $xcart_catalogs, $xcart_catalogs_secure;
    global $current_carrier, $shop_language, $current_area, $checkout_module;
    global $intershipper_rates, $intershipper_recalc, $dhl_ext_country_store, $products;
    global $totals_checksum_init, $totals_checksum;

    if (!defined('ALL_CARRIERS')) {
        define('ALL_CARRIERS', 1);
    }

    x_load(
        'cart',
        'shipping',
        'product',
        'user'
    );

    x_session_register('cart');
    x_session_register('intershipper_rates');
    x_session_register('intershipper_recalc');
    x_session_register('current_carrier');
    x_session_register('dhl_ext_country_store');
    XCAjaxSessions::getInstance()->requestForSessionSave(__FUNCTION__);

    $userinfo = func_userinfo(0, $login_type, false, false, 'H');

    // Prepare the products data
    $products = func_products_in_cart($cart, @$userinfo['membershipid']);

    $intershipper_recalc = 'Y';

    $checkout_module = '';
    include $xcart_dir . '/include/cart_calculate_totals.php';

    $check_smarty_vars = array('zero', 'transaction_query', 'shipping_cost', 'reg_error', 'paid_amount', 'need_shipping', 'minicart_total_items', 'force_change_address', 'paymentid', 'need_alt_currency');
    func_assign_smarty_vars($check_smarty_vars);
    $smarty->assign('main', 'checkout');

    $smarty->assign('userinfo',    $userinfo);
    $smarty->assign('products',    $products);
    $smarty->assign('cart_totals_standalone', true);

    return func_ajax_trim_div(func_display('modules/One_Page_Checkout/summary/cart_totals.tpl', $smarty, false));
} // }}}

function func_amazon_pa_get_payment_tab()
{ // {{{
    global $sql_tbl;

    // get config vars
    global $smarty;
    $configuration = func_query("SELECT * FROM $sql_tbl[config] WHERE category = '" . AMAZON_PAYMENTS_ADVANCED ."' ORDER BY orderby");
    foreach ($configuration as $k => $v) {
        if (in_array($v['type'], array('selector', 'multiselector'))) {
            $vars = func_parse_str(trim($v['variants']), "\n", ":");
            $vars = func_array_map('trim', $vars);
            $configuration[$k]['variants'] = array();

            foreach ($vars as $vk => $vv) {
                if (!empty($vv) && strpos($vv, "_") !== false && strpos($vv, " ") === false) {
                    $name = func_get_langvar_by_name(addslashes($vv), null, false, true);
                    if (!empty($name)) {
                        $vv = $name;
                    }
                }
                $configuration[$k]['variants'][$vk] = array("name" => $vv);
            }

            foreach ($configuration[$k]['variants'] as $vk => $vv) {
                $configuration[$k]['variants'][$vk]['selected'] = $configuration[$k]['type'] == "selector"
                    ? $configuration[$k]['value'] == $vk
                    : in_array($vk, $configuration[$k]['value']);

            }
        }
    }
    $smarty->assign('amazon_pa_configuration', $configuration);

    return  array(
        'title' => func_get_langvar_by_name('lbl_amazon_pa_amazon_advanced'),
        'tpl' => 'modules/Amazon_Payments_Advanced/payment_tab.tpl',
        'anchor' => 'payment-amazon-pa',
    );
} // }}}

function func_amazon_pa_save_order_extra($orderids, $key, $val)
{ // {{{

    if (!is_array($orderids)) {
        $orderids = array($orderids);
    }

    foreach ($orderids as $orderid) {
        func_array2insert(
            'order_extras',
            array(
                'orderid' => $orderid,
                'khash' => $key,
                'value' => $val
            ),
            true
        );
    }
} // }}}

function func_amazon_pa_on_change_order_status($order_data, $status)
{ // {{{

    $order = $order_data['order'];

    if ($status == $order['status']) {
        return;
    }

    if (empty($order['extra']['AmazonOrderReferenceId'])) {
        return; // not amazon order
    }

    $amazonAPI = func_amazon_pa_get_client_API();
    $requestParameters = array(
        'amazon_order_reference_id' => $order['extra']['AmazonOrderReferenceId'],
    );

    if ($status == 'D') {
        // cancel ORO if declined
        $amazonAPI->cancelOrderReference($requestParameters);
        $debug_call_type = 'cancelOrderReference';
    }

    if ($status == 'P') {
        // close ORO when captured
        $amazonAPI->closeOrderReference($requestParameters);
        $debug_call_type = 'closeOrderReference';
    }

    if (!empty($debug_call_type)) {
        func_amazon_pa_debug($debug_call_type . ':' . print_r($requestParameters, true));
    }
} // }}}
