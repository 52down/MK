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
 * Anti-fraud interface
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    9ab4118de3a8659c0ef4e842dc70b369590911e4, v37 (xcart_4_7_8), 2017-04-10 13:24:12, anti_fraud.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require __DIR__.'/auth.php';
require $xcart_dir.'/include/security.php';

$template_name = 'modules/Anti_Fraud/lookup_window.tpl';
$smarty->assign('popup_title', func_get_langvar_by_name('lbl_antifraud_service'));

$address = false;
if (!empty($city)) $address['city'] = $city;
if (!empty($state)) $address['state'] = $state;
if (!empty($country)) $address['country'] = $country;
if (!empty($zipcode)) $address['zipcode'] = $zipcode;

if ($address === false) {
    $address = XCShipFrom::getAddressArray();
}

$result = '';

if (!isset($proxy_ip)) $proxy_ip = false;

if ($resolve=="address" && $ip) {
    $result = func_check_ip_at_af($ip,$proxy_ip);
}

if ($resolve=="distance" && $ip && $address) {
    $result = func_check_ip_at_af($ip,$proxy_ip, $address);
}

$default_msg = 'txt_antifraud_service_generror';

$msg_type = '';
if (!empty($result['status']['error'])) {
    $msg_type = 'E';
    switch ($result['status']['error']) {
        case 'EMPTY_SERVICE_KEY':
        case 'NOT_AVAILABLE_SERVICE':
            $msg = 'txt_antifraud_invalid_key';
            break;

        case 'NOT_ACTIVE_LICENSES':
        case 'NOT_ALLOWED_SHOP_IP':
            $msg = 'txt_antifraud_not_allowed';
            break;

        default:
            $msg = $default_msg;
    }
}

if (!empty($result['data']['check_error'])) {
    $msg_type = 'I';
    switch ($result['data']['check_error']) {
        case 'IP_NOT_FOUND':
            $msg = 'txt_antifraud_ip_not_found';
            break;
        case 'POSTAL_CODE_NOT_FOUND':
            if ($resolve=="distance") {
                $msg = 'txt_antifraud_postal_not_found';
            }
            else {
                $msg_type = '';
            }
            break;
        case 'COUNTRY_NOT_FOUND':
            if ($resolve=="distance") {
                $msg = 'txt_antifraud_country_not_found';
            }
            else {
                $msg_type = '';
            }
            break;
        case 'CITY_NOT_FOUND':
            if ($resolve=="distance") {
                $msg = 'txt_antifraud_city_not_found';
            }
            else {
                $msg_type = '';
            }
            break;
        case 'IP_REQUIRED':
            $msg = 'txt_antifraud_ip_required';
            $msg_type = 'E';
            break;
        case 'DOMAIN_REQUIRED':
            $msg_type = '';
            break;
        default:
            $msg = $default_msg;
    }
}

if ($msg_type != '') {
    $top_message['content'] = func_get_langvar_by_name($msg);
    $top_message['type'] = $msg_type;
    $smarty->assign('top_message', $top_message);
    $top_message = array();
}

if ($result != '' && ($msg_type=="" || $msg_type=="I" && @$result['data']['check_error'] != 'IP_NOT_FOUND')) {
    $smarty->assign('address_resolved', true);
    if ($resolve=="distance") {
        $smarty->assign('distance_resolved', true);
    }

    $smarty->assign('resolved', $result['data']);
}

$smarty->assign('ip', $ip);
$smarty->assign('proxy_ip', $proxy_ip);
$smarty->assign('address', func_stripslashes($address));

$smarty->assign('template_name', $template_name);
func_display('help/popup_info.tpl',$smarty);

?>
