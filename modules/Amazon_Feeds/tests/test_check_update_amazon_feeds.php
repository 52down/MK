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
 * X-Cart test functions
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    442247067db63ddbfaaef7de30c2fd9530d4b850, v3 (xcart_4_7_8), 2017-06-06 16:31:36, test_check_update_amazon_feeds.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../"); die("Access denied"); }

/*
 Check if amazon feeds should be updated
    https://xcn.myjetbrains.com/youtrack/issue/XC4-148124#comment=73-33122
    Update amazon categories on change
    https://sellercentral.amazon.com/gp/help/1611/ref=id_1611_cont_200386810
    https://sellercentral.amazon.com/gp/help/200385010
*/
function module_test_check_update_amazon_feeds() { // {{{
    global $config, $xcart_dir;

    // from https://sellercentral.amazon.com/gp/help/1611?ie=UTF8&ref_=id_1611_cont_200386810&
    x_load('http','xml');
    $parse_error = false;
    $options = array(
        'XML_OPTION_CASE_FOLDING' => 1,
        'XML_OPTION_TARGET_ENCODING' => 'UTF-8'
    );
    $base_url_old = 'https://images-na.ssl-images-amazon.com/images/G/01/rainier/help/xsd/release_4_1/';
    $base_url_new = 'https://images-na.ssl-images-amazon.com/images/G/01/rainier/help/xsd/release_1_9/';

/*    $base_url_old = $xcart_dir . '/release_4_1/';
    $base_url_new = $xcart_dir . '/release_1_9/';*/

    $result = file_get_contents($base_url_new . 'Product.xsd');

    $parsed = func_xml_parse($result, $parse_error, $options);
    $cats = func_array_path($parsed, 'XSD:SCHEMA/XSD:INCLUDE');


    $harcoded_arr = $res = array();

    $xsds = array();
    foreach ($cats as $cat) {
        $url = func_array_path($cat, '@/SCHEMALOCATION');
        $xsds[] = $url;
    }
    sort($xsds);

    foreach ($xsds as $url) {
        if ($url == 'amzn-base.xsd') {
            continue;
        }
        if ($url !== 'Books.xsd' && 0)
            continue;

        if ($content = file_get_contents($base_url_new . $url)) {
            $url = basename($base_url_new) . '/' . $url;
        } elseif($content = file_get_contents($base_url_old . $url)) {
            $url = basename($base_url_old) . '/' . $url;
        } else {
            $res[] = 'Not readable ' . $url;
            continue;
        }

        if (strpos($content, 'ProductType') === false && strpos($content, 'ClothingType') === false) {
            $res[] = 'Skipped ' . $url;
            continue;
        }
        $res[] = $url;

        $type_parsed = func_xml_parse($content, $parse_error, $options);
        $elem = func_array_path($type_parsed, 'XSD:SCHEMA/XSD:ELEMENT/0');
        $name = func_array_path($elem, '@/NAME');
        $type = func_array_path($elem, 'XSD:COMPLEXTYPE/XSD:SEQUENCE/XSD:ELEMENT/0/@');
        $BindingTypes = func_array_path($type_parsed, 'XSD:SCHEMA/XSD:SIMPLETYPE');

        if (!empty($type['TYPE']) && $type['NAME'] == 'ProductType' && $type['TYPE'] == 'MiscType') {
            $simple_types = func_array_path($type_parsed, 'XSD:SCHEMA/XSD:SIMPLETYPE/XSD:RESTRICTION/XSD:ENUMERATION');
            foreach ($simple_types as $simple_type) {
                $harcoded_arr[$name]['_simple_string_ProductType'][] = func_array_path($simple_type, '@/VALUE');
            }
        } elseif(is_array(func_array_path($elem, 'XSD:COMPLEXTYPE/XSD:SEQUENCE/XSD:ELEMENT/XSD:SIMPLETYPE/XSD:RESTRICTION/XSD:ENUMERATION'))) {
            $type = empty($type['NAME']) ? 'ProductType' : $type['NAME'];
            $simple_types = func_array_path($elem, 'XSD:COMPLEXTYPE/XSD:SEQUENCE/XSD:ELEMENT/XSD:SIMPLETYPE/XSD:RESTRICTION/XSD:ENUMERATION');
            foreach ($simple_types as $simple_type) {
                $harcoded_arr[$name][$type][] = func_array_path($simple_type, '@/VALUE');
            }
        } else {

            $type = empty($type['NAME']) ? 'ProductType' : $type['NAME'];

            if (func_array_path($elem, 'XSD:COMPLEXTYPE/XSD:SEQUENCE/XSD:ELEMENT/1/@/NAME') == 'ProductType') {
                $type = 'ProductType';
            }
            $complex_types = func_array_path($elem, 'XSD:COMPLEXTYPE/XSD:SEQUENCE/XSD:ELEMENT/XSD:COMPLEXTYPE/XSD:CHOICE/XSD:ELEMENT');
            if (!is_array($complex_types)) {
                $complex_types = func_array_path($elem, 'XSD:COMPLEXTYPE/XSD:SEQUENCE/XSD:ELEMENT/1/XSD:COMPLEXTYPE/XSD:CHOICE/XSD:ELEMENT');
            }

            if (!is_array($complex_types)) {
                $res[] = 'Skipped not array' . $url;
                continue;
            }
            if (func_array_path($BindingTypes, '0/@/NAME') == 'BindingTypes') {
                //for Books.xsd
                $simple_types = func_array_path($BindingTypes, 'XSD:RESTRICTION/XSD:ENUMERATION');
                foreach ($simple_types as $simple_type) {
                    $Binding[] = func_array_path($simple_type, '@/VALUE');
                }
            } else {
                $Binding = array();
            }
            foreach ($complex_types as $complex_type) {
                $sub_name =  func_array_path($complex_type, '@/REF');
                if (!empty($Binding)) {
                    $harcoded_arr[$name][$type][$sub_name]['Binding']  = $Binding;
                } else {
                    $harcoded_arr[$name][$type][]  = empty($sub_name) ? func_array_path($complex_type, '@/NAME') : $sub_name;
                }

            }
        }
    }
    ksort($harcoded_arr);
    array_unshift($harcoded_arr, $res);
    return var_export($harcoded_arr, true);
} // }}}
