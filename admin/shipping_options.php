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
 * Shipping options
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v129 (xcart_4_7_7), 2017-01-23 20:12:10, shipping_options.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require __DIR__.'/auth.php';
require $xcart_dir.'/include/security.php';

x_session_register('saved_user_data');

$location[] = array(func_get_langvar_by_name('lbl_shipping_options'), '');

$carriers = func_get_carriers();

$carrier_valid = false;

foreach ($carriers as $k => $v) {
    if ($v[0] == $carrier) {
        $carrier_valid = true;
        break;
    }
}

$carrier = $carrier_valid ? $carrier : '';

if ($carrier_valid && $REQUEST_METHOD == 'POST') {
/**
 * Update the shipping options
 */
    $topMessage = '';
    $suffix = '';
    $shippingOptions = array();

    if ($carrier == 'FDX') {

    // FEDEX options update

        if (isset($update_options)) {

            // Update the FedEx options
            $carrier_codes = isset($carrier_codes) && !empty($carrier_codes) ? implode('|', $carrier_codes) : '';

            $rate_request_types = isset($rate_request_types) ? $rate_request_types : 'ACCOUNT';

            $fedex_options = array(
                'carrier_codes' => $carrier_codes,
                'packaging' => $packaging,
                'dropoff_type' => $dropoff_type,
                'ship_date' => intval($ship_date),
                'dim_length' => sprintf("%.2f", $dim_length),
                'dim_width' => sprintf("%.2f", $dim_width),
                'dim_height' => sprintf("%.2f", $dim_height),
                'max_weight' => abs(doubleval($max_weight)),
                'cod_value' => sprintf("%.2f", $cod_value),
                'cod_type' => $cod_type,
                'alcohol' => (empty($alcohol) ? 'N' : 'Y'),
                'hold_at_location' => (empty($hold_at_location) ? 'N' : 'Y'),
                'dry_ice' => (empty($dry_ice) ? 'N' : 'Y'),
                'nonstandard_container' => (empty($nonstandard_container) ? 'N' : 'Y'),
                'inside_pickup' => (empty($inside_pickup) ? 'N' : 'Y'),
                'inside_delivery' => (empty($inside_delivery) ? 'N' : 'Y'),
                'saturday_pickup' => (empty($saturday_pickup) ? 'N' : 'Y'),
                'saturday_delivery' => (empty($saturday_delivery) ? 'N' : 'Y'),
                'residential_delivery' => (empty($residential_delivery) ? 'N' : 'Y'),
                'dg_accessibility' => $dg_accessibility,
                'signature' => $signature,
                'handling_charges_amount' => sprintf("%.2f", $handling_charges_amount),
                'handling_charges_type' => $handling_charges_type,
                'currency_code' => $currency_code,
                'purpose_type' => @$purpose_type,
                'param01' => @$param01,
                'param02' => @$param02,
                'add_smartpost_detail' => @$add_smartpost_detail,
                'smartpost_indicia' => $smartpost_indicia,
                'smartpost_ancillaryendorsement' => $smartpost_ancillaryendorsement,
                'smartpost_hubid' => $smartpost_hubid,
                'send_insured_value' => @$send_insured_value,
                'rate_request_types' => $rate_request_types,
            );

            $shippingOptions['param00'] = addslashes(serialize($fedex_options));

        }

    } elseif ($carrier == 'USPS') {

    // USPS options update

        $dim = abs(doubleval($dim_length)) . ':' . abs(doubleval($dim_width)) . ':' . abs(doubleval($dim_height)) . ':' . abs(doubleval($dim_girth));

        if ($value_of_content_type == 'fixed_value')
            $value_of_content_type = abs(round($value_of_content_fixed, 2));

        settype($use_maximum_dimensions, 'string');
        settype($status_new_method, 'string');
        settype($param11, 'string');
        settype($selected_services, 'array');
        $_param00 = array(
            'mailtype' => $mailtype,
            'ground_only' => $ground_only,
            'selected_services' => $selected_services,
            'use_commercial_rate' => empty($use_commercial_rate) ? 'N' : $use_commercial_rate,
            'use_commercial_plus_rate' => empty($use_commercial_plus_rate) ? 'N' : $use_commercial_plus_rate,
        );
        $shippingOptions = array(
            'param00' => addslashes(serialize($_param00)),
            'param01' => $status_new_method,//common
            'param02' => $machinable,
            'param03' => $container_express,
            'param04' => $container_priority,
            'param05' => $firstclassmailtype,
            'param06' => $dim,//common
            'param07' => $value_of_content_type,
            'param08' => abs(doubleval($max_weight)),//common
            'param09' => ('Y' !== $use_maximum_dimensions) ? 'N' : $use_maximum_dimensions,//common
            'param10' => $container_intl,
            'param11' => empty($param11) ? 'N' : $param11,//common: Split the shipment into multiple packages if...
        );

    } elseif ($carrier == 'CPC') {

    // Canada Post options update

        $dim = abs(doubleval($dim_length)) . ':' . abs(doubleval($dim_width)) . ':' . abs(doubleval($dim_height));

        if ($coverage_type == 'fixed_value')
            $coverage_type = abs(round($coverage_fixed, 2));

        if ($cod_type == 'fixed_value')
            $cod_type = abs(round($cod_fixed, 2));

        settype($use_maximum_dimensions, 'string');
        settype($customer_number, 'string');
        settype($status_new_method, 'string');
        settype($param11, 'string');

        $customer_number = ltrim($customer_number, '0');
        $shippingOptions = array(
            'param00' => (!empty($options) ? implode('|', $options) : ''),
            'param01' => $status_new_method,//common
            'param02' => $cod_type,
            'param03' => $customer_number,
            'param04' => $contract_id,
            'param05' => $quote_type,
            'param06' => $dim,//common
            'param07' => $coverage_type,
            'param08' => abs(doubleval($max_weight)),// common
            'param09' => ('Y' !== $use_maximum_dimensions) ? 'N' : $use_maximum_dimensions,//common
            'param10' => '',
            'param11' => empty($param11) ? 'N' : $param11,//common: Split the shipment into multiple packages if...
        );

    } elseif ($carrier == 'Intershipper') {

    // INTERSHIPPER options update

        $shippingOptions = array(
            'param00' => $delivery,
            'param01' => $shipmethod,
            'param02' => abs(doubleval($length)),
            'param03' => abs(doubleval($width)),
            'param04' => abs(doubleval($height)),
            'param05' => is_array($options) ? implode('|', $options) : '',
            'param06' => $packaging,
            'param07' => $contents,
            'param08' => abs(doubleval($codvalue)),
            'param09' => abs(doubleval($weight)),
            'param10' => ('Y' !== $use_maximum_dimensions) ? 'N' : $use_maximum_dimensions,
        );

    } elseif ($carrier == 'DHL') {

    // DHL options update

        $dim = abs(doubleval($dim_length)) . ':' . abs(doubleval($dim_width)) . ':' . abs(doubleval($dim_height));

        settype($use_maximum_dimensions, 'string');// param09
        settype($status_new_method, 'string');// param01
        settype($param11, 'string');//param11

        if ($insured_type == 'fixed_value') {
            $insured_type = abs(round($insured_fixed, 2));
        }

        if ($declared_type == 'fixed_value') {
            $declared_type = abs(round($declared_fixed, 2));
        }

        if ($cod_type == 'fixed_value') {
            $cod_type = abs(round($cod_fixed, 2));
        }

        settype($param02, 'string');
        settype($param03, 'string');
        settype($param04, 'string');
        settype($param05, 'string');
        settype($param07, 'string');
        settype($param10, 'string');

        $_param00 = array(
            'pkg_type' => $pkg_type,
            'currency' => $currency,

            'insured_type' => $insured_type,
            'declared_type' => $declared_type,
            'cod_type' => $cod_type,
        );

        $shippingOptions = array(
            'param00' => addslashes(serialize($_param00)),
            'param01' => $status_new_method,//common
            'param02' => $param02,
            'param03' => $param03,
            'param04' => $param04,
            'param05' => $param05,
            'param06' => $dim,//common
            'param07' => $param07,
            'param08' => abs(doubleval($max_weight)),// common
            'param09' => ('Y' !== $use_maximum_dimensions) ? 'N' : $use_maximum_dimensions,//common
            'param10' => $param10,
            'param11' => empty($param11) ? 'N' : $param11,//common: Split the shipment into multiple packages if...
        );

    } elseif ($carrier == 'APOST') {

    // Australia Post options update

        $dim = abs(doubleval($dim_length)) . ':' . abs(doubleval($dim_width)) . ':' . abs(doubleval($dim_height));

        settype($use_maximum_dimensions, 'string');
        settype($status_new_method, 'string');
        settype($param11, 'string');
        $selected_apost_services = empty($selected_apost_services) ? array() : $selected_apost_services;

        $shippingOptions = array(
            'param00' => serialize($selected_apost_services),
            'param01' => $status_new_method,//common
            'param02' => '',
            'param03' => strval($param03),
            'param04' => empty($param04_checkbox) ? 0 : intval($param04),
            'param05' => '',
            'param06' => $dim,// common
            'param07' => '',
            'param08' => abs(doubleval($max_weight)),// common
            'param09' => ('Y' !== $use_maximum_dimensions) ? 'N' : $use_maximum_dimensions,//common
            'param10' => '',
            'param11' => empty($param11) ? 'N' : $param11,//common: Split the shipment into multiple packages if...
        );

    } elseif ($carrier == '1800C') {
        include $xcart_dir . '/include/1800C_registration.php';
        $topMessage = func_get_langvar_by_name('msg_1800c_info_sent');
    }

    // Check processors list
    if (!empty($shipping_options_processors)) {
        // Loop processors list
        foreach ($shipping_options_processors as $processor) {
            if (
                !empty($processor[$carrier])
                && is_readable($processor[$carrier])
            ) {
                // Processor was found
                include $processor[$carrier];
                break;
            }
        }
    }

    if (!empty($shippingOptions)) {

        $shippingOptions['currency_rate'] = isset($currency_rate) ? abs(doubleval($currency_rate)) : 1;
        $shippingOptions['carrier'] = $carrier;

        func_array2insert(
            'shipping_options',
            $shippingOptions,
            true
        );

    }

    $top_message['content'] = empty($topMessage)
        ? func_get_langvar_by_name('msg_adm_shipping_option_upd')
        : $topMessage;

    func_header_location('shipping_options.php?carrier=' . $carrier . $suffix);

} // /if ($REQUEST_METHOD == 'POST')

/**
 * Collect options for current carrier
 */

$lower_carrier = strtolower($carrier);

$shipping_options = array ();
$shipping_options [$lower_carrier] = func_query_first("SELECT * FROM $sql_tbl[shipping_options] WHERE carrier='$carrier'");

$carriers_cache_dirs = array(
    'CPC' => 'shipping_CPC_cache',
    'APOST' => 'shipping_AP_cache',
    'DHL' => 'shipping_DHL_cache',
);

if (!empty($carriers_cache_dirs[$carrier])) {
    $_dir = $carriers_cache_dirs[$carrier];
    func_restore_var_dir($_dir, $var_dirs['cache'] . "/$_dir");
}

if ($carrier == '1800C') {
    $default_seller_address = XCShipFrom::getAddressArray();
    $default_seller_address['phone'] = $config['Company']['company_phone'];

    if (!$single_mode && $current_area == 'P') {
        $seller_address = func_query_first("SELECT * FROM $sql_tbl[seller_addresses] WHERE userid='$userinfo[id]'");
    }
    if (empty($seller_address)) {
        $seller_address = $default_seller_address;
    }
    $seller_address['company_name'] = $config['Company']['company_name'];
    $seller_address['username'] = $config['Shipping']['1800c_username'];
    $seller_address['readytime'] = $config['Shipping']['1800c_readytime'];
    $seller_address['subsidize'] = $config['Shipping']['1800c_subsidize'];
    $seller_address['business_hours'] = $config['Shipping']['1800c_business_hours'];
    $seller_address['operation_days'] = $config['Shipping']['1800c_operation_days'];

    if (file_exists($xcart_dir . '/shipping/mod_1800C.php')) {
        include_once $xcart_dir . '/shipping/mod_1800C.php';
    }

    if (function_exists('func_get_warehouse_info')) {
        $seller_address = func_get_warehouse_info($seller_address);
    }

    $smarty->assign('seller_address', $seller_address);
    $smarty->assign('send_is_avail', (!empty($config['Shipping']['1800c_username']) && !empty($config['Shipping']['1800c_password'])));

}

if ($carrier == 'FDX') {

    // Prepare FedEx (API) information
    if (!empty($error)) {
        $smarty->assign('fill_error', 'Y');
    }

    $prepared_user_data = $saved_user_data;

    if (empty($prepared_user_data)) {
        $prepared_user_data = array();
        $prepared_user_data['person_name'] = $user_account['firstname'] . ' ' . $user_account['lastname'];
        $prepared_user_data['company_name'] = $config['Company']['company_name'];
        $prepared_user_data['phone_number'] = preg_replace("/[^\d]/", "", $config['Company']['company_phone']);
        $prepared_user_data['email'] = $config['Company']['site_administrator'];
        $prepared_user_data = func_array_merge($prepared_user_data, XCShipFrom::getAddressArray());
        $prepared_user_data['address_1'] = $prepared_user_data['address'];
    }

    $smarty->assign('prepared_user_data', $prepared_user_data);

    include_once $xcart_dir.'/include/countries.php';
    include_once $xcart_dir.'/include/states.php';

    $fedex_options = $shipping_options['fdx']['param00'];
    $shipping_options['fdx'] = @unserialize($fedex_options);
}
#####################################

if ($carrier == 'Intershipper') {
/**
 * Get the shipping options for Intershipper service
 */
    $options = explode('|',$shipping_options["intershipper"]["param05"]);
    foreach($options as $option) {
        $shipping_options['intershipper']['options'][$option] = 'Y';
    }

    $smarty->assign('max_intershipper_weight', round(150 * XCPhysics::GRAMS_PER_1LB / $config['General']['weight_symbol_grams'], 4));
}

if ($carrier == 'DHL') {
    $_dim = explode(':', $shipping_options[$lower_carrier]['param06']);

    if (func_array_empty($_dim)) {
        $_dim = array_fill(0, 3, 0);
    }

    $shipping_options[$lower_carrier]['dim_length'] = $_dim[0];
    $shipping_options[$lower_carrier]['dim_width'] = $_dim[1];
    $shipping_options[$lower_carrier]['dim_height'] = $_dim[2];

    $_params = @unserialize($shipping_options[$lower_carrier]['param00']);
    if (!empty($_params)) {
        $shipping_options[$lower_carrier]['pkg_type'] = $_params['pkg_type'];
        $shipping_options[$lower_carrier]['currency'] = $_params['currency'];

        $shipping_options[$lower_carrier]['insured_type'] = $_params['insured_type'];
        if (is_numeric($shipping_options[$lower_carrier]['insured_type'])) {
            $shipping_options[$lower_carrier]['insured_fixed_value'] = 'Y';
        }

        $shipping_options[$lower_carrier]['declared_type'] = $_params['declared_type'];
        if (is_numeric($shipping_options[$lower_carrier]['declared_type'])) {
            $shipping_options[$lower_carrier]['declared_fixed_value'] = 'Y';
        }

        $shipping_options[$lower_carrier]['cod_type'] = $_params['cod_type'];
        if (is_numeric($shipping_options[$lower_carrier]['cod_type'])) {
            $shipping_options[$lower_carrier]['cod_fixed_value'] = 'Y';
        }
    }

    x_load('dhl');

    $smarty->assign('dhl_currencies', XCDHLReferenceData::getAllCurrencies());
}

if ($carrier == 'USPS') {
    $_dim = explode(':', $shipping_options[$lower_carrier]['param06']);

    if (func_array_empty($_dim)) {
        $_dim = array_fill(0, 4, 0);
    }

    $shipping_options[$lower_carrier]['dim_length'] = $_dim[0];
    $shipping_options[$lower_carrier]['dim_width'] = $_dim[1];
    $shipping_options[$lower_carrier]['dim_height'] = $_dim[2];
    $shipping_options[$lower_carrier]['dim_girth'] = $_dim[3];

    if (is_numeric($shipping_options[$lower_carrier]['param07'])) {
        $shipping_options[$lower_carrier]['fixed_value'] = 'Y';
    }

    $all_usps_services = array(
        'FIRST CLASS',
        'FIRST CLASS METERED',
        'FIRST CLASS COMMERCIAL',
        'FIRST CLASS HFP COMMERCIAL',
        'PARCEL SELECT GROUND',
        'PRIORITY',
        'PRIORITY COMMERCIAL',
        'PRIORITY CPP',
        'PRIORITY HFP COMMERCIAL',
        'PRIORITY HFP CPP',
        'PRIORITY MAIL EXPRESS',
        'PRIORITY MAIL EXPRESS COMMERCIAL',
        'PRIORITY MAIL EXPRESS CPP',
        'PRIORITY MAIL EXPRESS SH',
        'PRIORITY MAIL EXPRESS SH COMMERCIAL',
        'PRIORITY MAIL EXPRESS HFP',
        'PRIORITY MAIL EXPRESS HFP COMMERCIAL',
        'PRIORITY MAIL EXPRESS HFP CPP',
        'RETAIL GROUND',
        'MEDIA',
        'LIBRARY',
//        'PLUS',
    );
    $smarty->assignByRef('all_usps_services', $all_usps_services);

    $_params = @unserialize($shipping_options[$lower_carrier]['param00']);
    if (!empty($_params)) {
        $shipping_options[$lower_carrier]['mailtype'] = $_params['mailtype'];
        $shipping_options[$lower_carrier]['ground_only'] = $_params['ground_only'];
        $shipping_options[$lower_carrier]['use_commercial_plus_rate'] = $_params['use_commercial_plus_rate'];
        $shipping_options[$lower_carrier]['use_commercial_rate'] = $_params['use_commercial_rate'];

        if (!empty($_params['selected_services'])) {
            $shipping_options[$lower_carrier]['selected_services'] = array_combine($_params['selected_services'], array_fill(0, count($_params['selected_services']), TRUE));
        }
    } else {
        $shipping_options[$lower_carrier]['selected_services'] = array();
    }
}

if ($carrier == 'CPC') {
    $_dim = explode(':', $shipping_options[$lower_carrier]["param06"]);

    if (func_array_empty($_dim)) {
        $_dim = array_fill(0, 3, 0);
    }

    $shipping_options[$lower_carrier]['dim_length'] = $_dim[0];
    $shipping_options[$lower_carrier]['dim_width'] = $_dim[1];
    $shipping_options[$lower_carrier]['dim_height'] = $_dim[2];

    $shipping_options['cpc']['options'] = array();
    if (!empty($shipping_options['cpc']['param00'])) {
        $ccodes = explode('|', $shipping_options["cpc"]["param00"]);
        foreach ($ccodes as $code) {
            $shipping_options['cpc']['options'][$code] = 1;
        }
    }

    if (is_numeric($shipping_options[$lower_carrier]["param07"])) {
        $shipping_options[$lower_carrier]['coverage_fixed_value'] = 'Y';
    }

    if (is_numeric($shipping_options[$lower_carrier]["param02"])) {
        $shipping_options[$lower_carrier]['cod_fixed_value'] = 'Y';
    }

    require_once $xcart_dir . '/include/classes/class.CPC.php';

    $isOnBehalfOfAMerchant = XCart\Shipping\CPC\API::isOnBehalfOfAMerchant();

    $smarty->assign('isOnBehalfOfAMerchant', $isOnBehalfOfAMerchant ? 'Y' : 'N');
}

if ($carrier == 'FDX') {
    if (!empty($shipping_options['fdx']['carrier_codes'])) {
        $ccodes = explode('|', $shipping_options["fdx"]["carrier_codes"]);
        $shipping_options['fdx']['carrier_codes'] = array();
        foreach ($ccodes as $code) {
            $shipping_options['fdx']['carrier_codes'][$code] = 1;
        }
    } else {
        if (empty($shipping_options['fdx'])) {
            $shipping_options['fdx'] = array();
        }
        $shipping_options['fdx']['carrier_codes'] = array();
    }
}

if ($carrier == 'APOST') {
    $_dim = explode(':', $shipping_options[$lower_carrier]['param06']);

    if (func_array_empty($_dim)) {
        $_dim = array_fill(0, 3, 0);
    }

    $shipping_options[$lower_carrier]['dim_length'] = $_dim[0];
    $shipping_options[$lower_carrier]['dim_width'] = $_dim[1];
    $shipping_options[$lower_carrier]['dim_height'] = $_dim[2];

    if (file_exists($xcart_dir . '/shipping/mod_AP.php')) {
        include_once $xcart_dir . '/shipping/mod_AP.php';
    }

    /* From
        https://developers.auspost.com.au/apis/pac/reference/postage-letter-domestic-service
        https://developers.auspost.com.au/apis/pac/reference/postage-parcel-domestic-service
        https://developers.auspost.com.au/apis/pac/reference/postage-letter-international-service
        https://developers.auspost.com.au/apis/pac/reference/postage-parcel-international-service
    */
    $shipping_options[$lower_carrier]['service_options'] = array(
        XC_AP_Options::AUS_SERVICE_OPTION_STANDARD => 'Standard Service',
        XC_AP_Options::AUS_SERVICE_OPTION_REGISTERED_POST => 'Registered Post',
        XC_AP_Options::AUS_SERVICE_OPTION_DELIVERY_CONFIRMATION => 'Delivery Confirmation',
        XC_AP_Options::AUS_SERVICE_OPTION_EXTRA_COVER => 'Extra Cover',
        XC_AP_Options::AUS_SERVICE_OPTION_PERSON_TO_PERSON => 'Person to Person',
        XC_AP_Options::AUS_SERVICE_OPTION_SIGNATURE_ON_DELIVERY => 'Signature on Delivery'
    );

    $selected_apost_services = empty($shipping_options[$lower_carrier]['param00']) ? array() : unserialize($shipping_options[$lower_carrier]['param00']);
    foreach ($shipping_options[$lower_carrier]['service_options'] as $key=>$service_option) {
       $shipping_options[$lower_carrier]['service_options'][$key]  = array(
            'name' => $service_option,
            'key' => $key,
            'selected' => in_array($key, $selected_apost_services)
        );
    }

    $available_package_sizes = XC_AP_GetSizes::getInstance()->func_get_available_sizes_AP();

    $shipping_options[$lower_carrier]['package_types'][XC_AP_Options::USER_DEFINED_BOX] = 'My own box';

    foreach ($available_package_sizes as $package_size) {
        if (!empty($package_size['code']) && !empty($package_size['name'])) {
            $shipping_options[$lower_carrier]['package_types'][$package_size['code']] = $package_size['name'];
        }
    }
}

// Check processors list
if (!empty($shipping_options_processors)) {
    // Loop processors list
    foreach ($shipping_options_processors as $processor) {
        if (
            !empty($processor[$carrier])
            && is_readable($processor[$carrier])
        ) {
            // Processor was found
            include $processor[$carrier];
            break;
        }
    }
}

$smarty->assign('carriers', $carriers);
$smarty->assign('carrier', $carrier);

$smarty->assign ('shipping_options', $shipping_options);

$smarty->assign('main','shipping_options');

// Assign the current location line
$smarty->assign('location', $location);

include $xcart_dir . DIR_ADMIN . '/shipping_tools.php';

// Assign the section navigation data
$smarty->assign('dialog_tools_data', $dialog_tools_data);

if (is_readable($xcart_dir.'/modules/gold_display.php')) {
    include $xcart_dir.'/modules/gold_display.php';
}
func_display('admin/home.tpl',$smarty);
?>
