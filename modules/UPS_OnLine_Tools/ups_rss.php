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
 * Check and update UPS configuration
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v47 (xcart_4_7_7), 2017-01-24 09:29:34, ups_rss.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../"); die("Access denied"); }

if (
    empty($config['UPS_OnLine_Tools']['UPS_username'])
    || empty($config['UPS_OnLine_Tools']['UPS_password'])
    || empty($config['UPS_OnLine_Tools']['UPS_accesskey'])
) {
    func_header_location('ups.php');
}

require $xcart_dir.'/include/countries.php';

// Check and update UPS configuration
###################################

$ups_title .= ' ' . func_get_langvar_by_name('lbl_ups_rss');

$location[] = array($ups_title, "ups.php?mode=rss");

$smarty->assign('location', $location);
$smarty->assign('ups_reg_step', $ups_reg_step);
$smarty->assign('title', $ups_title);

$smarty->assign('mode', 'rss');

$ups_reg_data = unserialize($config['UPS_reginfo']);

$orig_country = (!is_array($ups_reg_data) && !empty($ups_reg_data['country']) ? $ups_reg_data['country'] : XCShipFrom::getCountry());

$params = func_query_first_cell("SELECT param00 FROM $sql_tbl[shipping_options] WHERE carrier='UPS'");

/**
 * UPS options update
 */
if ($REQUEST_METHOD == 'POST') {

    if ($mode == 'rss') {

        $check = func_query_first("SELECT * FROM $sql_tbl[shipping_options] WHERE carrier='UPS'");
        if (!$check)
            db_query("INSERT INTO $sql_tbl[shipping_options] (carrier) VALUES ('UPS')");

        if (is_array($tmp_var = unserialize($check['param00'])))
            $ups_currency_code = $tmp_var['currency_code'];

        $ups_parameters = unserialize($params);

        $_ups_parameters = array(
//            'account_type' => $account_type,
//            'customer_classification_code' => $customer_classification_code,
            'pickup_type' => $pickup_type,
            'packaging_type' => $packaging_type,
            'upsoptions' => implode("|", ($upsoptions?$upsoptions:array())),
            'delivery_conf' => (in_array($delivery_conf, array(0,1,2,3)) ? $delivery_conf : 0),
            'conversion_rate' => (is_numeric($conversion_rate) ? $conversion_rate : 1),
            'av_status' => $av_status,
            'av_quality' => $av_quality,
            'lbs_countries' => $lbs_countries,
            'currency_code' => $ups_currency_code,
            'shipper_number' => stripslashes($shipper_number),
            'residential' => $residential,
            'handling_charge_flat' => sprintf("%.2f", $handling_charge_flat),
            'handling_charge_percent' => intval($handling_charge_percent),
            'handling_charge_currency' => $handling_charge_currency,
            'negotiated_rates' => $negotiated_rates
        );

        $_ups_parameters['length'] = abs(doubleval($dim_length));
        $_ups_parameters['width']  = abs(doubleval($dim_width));
        $_ups_parameters['height'] = abs(doubleval($dim_height));
        $_ups_parameters['weight'] = abs(doubleval($max_weight));

        $_ups_parameters['split_into_multiple_packages'] = ($param11 == 'Y') ? 'Y' : 'N';
        $_ups_parameters['use_maximum_dimensions'] = ($use_maximum_dimensions == 'Y') ? 'Y' : 'N';

        $ups_parameters = func_array_merge($ups_parameters, $_ups_parameters);

        db_query("UPDATE $sql_tbl[shipping_options] SET param00='" . addslashes(serialize($ups_parameters)) . "' WHERE carrier='UPS'");

    }

    func_header_location('ups.php?mode=rss');
}

/**
 * Prepare the configuration page displaying
 */

$ups_parameters['rss'] = unserialize($params);

if (is_array($ups_parameters['rss'])) {

    $service_options = explode("|",$ups_parameters['rss']['upsoptions']);

    if (is_array($service_options)) {
        foreach ($service_options as $opt) {
            if (!empty($opt)) {
                $ups_parameters['rss'][$opt] = true;
            }
        }
    }
}

if ($ups_parameters['rss']['packaging_type'] != '02') {
    $smarty->assign('disable_dimensions', 'Y');
}

if ($countries) {

    if (
        !empty($ups_parameters['rss']['lbs_countries'])
        && !is_array($ups_parameters['rss']['lbs_countries'])
    ) {
        $ups_parameters['rss']['lbs_countries'] = explode(";", $ups_parameters['rss']['lbs_countries']);
        array_pop($ups_parameters['rss']['lbs_countries']);
    }
    else {

        // The first launch time detection

        if (!isset($ups_parameters['rss']['pickup_type'])) {
            $ups_parameters['rss']['lbs_countries'] = array('DO','PR','US','CA');
        } else {
            $ups_parameters['rss']['lbs_countries'] = array();
        }
    }

    $lbs_countries = array();
    $rest_countries = array();

    foreach($countries as $c) {

        if (
            is_array($ups_parameters['rss']['lbs_countries'])
            && in_array($c['country_code'], $ups_parameters['rss']['lbs_countries'])
        ) {
            $lbs_countries[] = $c;
        } else {
            $rest_countries[] = $c;
        }
    }

    $smarty->assign('lbs_countries',$lbs_countries);
    $smarty->assign('rest_countries',$rest_countries);
}

$ups_parameters['rss']['dim_units'] = 'cm';
$ups_parameters['rss']['weight_units'] = 'kg';

foreach($lbs_countries as $country) {

    if($orig_country==$country['country_code']) {
        $ups_parameters['rss']['dim_units'] = 'inches';
        $ups_parameters['rss']['weight_units'] = 'lbs';
        break;
    }
}

// Overwrite some fields to use common admin/main/shipping_package_limits.tpl template
$renames_array = array(
    'param08' => 'weight',
    'param09' => 'use_maximum_dimensions',
    'param11' => 'split_into_multiple_packages',
    'dim_length' => 'length',
    'dim_width' => 'width',
    'dim_height' => 'height',
);

foreach ($renames_array as $tpl_compatible_name => $name_from_db) {
    assert('!isset($ups_parameters["rss"][$tpl_compatible_name]) /*ups_parameters["rss"][' .$tpl_compatible_name. '] param is overwritten on Main page :: UPS Developer Kit Rates & Service Selection :: UPS Developer Kit page*/');
    if (isset($ups_parameters['rss'][$name_from_db])) {
        $ups_parameters['rss'][$tpl_compatible_name] = $ups_parameters['rss'][$name_from_db];
    }
}

$smarty->assign('orig_country',      $orig_country);
$smarty->assign('ups_packages',      $ups_packages);
$smarty->assign ('shipping_options', $ups_parameters);
?>
