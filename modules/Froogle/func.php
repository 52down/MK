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
 * Functions for Froogle module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v22 (xcart_4_7_7), 2017-01-23 20:12:10, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }


/**
 * Translation string to frogle-compatibility-string
 */
function func_froogle_convert($str, $max_len = false)
{
    static $tbl = false;

    if ($tbl === false) {
        $tbl = array_flip(get_html_translation_table(HTML_ENTITIES, ENT_COMPAT | ENT_HTML401, 'UTF-8'));
    }

    $str = str_replace(array("\n","\r","\t"), array(" ", '', " "), $str);
    $str = strip_tags($str);
    $str = strtr($str, $tbl);

    if ($max_len > 0 && strlen($str) > $max_len) {
        $str = preg_replace("/\s+?\S+.{".intval(strlen($str)-$max_len-1+FROOGLE_TAIL_LEN)."}$/Ss", '', $str).FROOGLE_TAIL;
        if (strlen($str) > $max_len)
            $str = substr($str, 0, $max_len-FROOGLE_TAIL_LEN).FROOGLE_TAIL;
    }

    if (empty($str)) {
        $str = 'Not specified';
    }

    return $str;
}

/**
 * Get additional attributes from special named extra fields
 */
function func_froogle_get_additional_attributes($get_mode = '')
{//{{{
    global $active_modules, $sql_tbl, $froogle_additional_attributes, $single_mode, $logged_userid, $current_area;
    static $result = array();

    $md5_args = $get_mode;
    if (isset($result[$md5_args])) {
        return $result[$md5_args];
    }

    $additional_attributes = array();

    if (!empty($active_modules['Extra_Fields'])) {
        $provider_condition = ($single_mode || $current_area == 'A' ? '' : " AND $sql_tbl[extra_fields].provider='$logged_userid' ");

        if ($get_mode == 'get_ids') {
            $additional_attributes = func_query_hash("
                SELECT fieldid, service_name 
                FROM $sql_tbl[extra_fields] WHERE service_name IN ('" . implode("','", $froogle_additional_attributes) . "') $provider_condition
                ", "fieldid", false, true);
        } else {
            $additional_attributes = func_query_hash("
                SELECT service_name, value 
                FROM $sql_tbl[extra_fields] WHERE service_name IN ('" . implode("','", $froogle_additional_attributes) . "') $provider_condition
                ORDER BY orderby", "service_name", false, true);
        }
        $additional_attributes = $additional_attributes ?: array();
    }

    $result[$md5_args] = $additional_attributes;
    assert('is_array($additional_attributes) /*return '.__FUNCTION__.'*/');
    return $additional_attributes;
}//}}}

/**
 * Get additional attributes for product
 */
function func_froogle_get_product_additional_attributes($pid, $in_variantid = 0)
{//{{{
    global $sql_tbl, $active_modules, $config;
    static $product_variant_ef_values = array();

    if (empty($pid)) {
        return array();
    }

    $additional_attributes = func_froogle_get_additional_attributes();
    $product_additional_attributes = array();
    if (!empty($active_modules["Extra_Fields"]) && !empty($additional_attributes)) {

        $in_variantid = intval($in_variantid);

        $additional_attributes_ids = func_froogle_get_additional_attributes('get_ids');

        if (!isset($product_variant_ef_values[$pid])) {
            $product_variant_ef_values = array();// free memory from previous product
            $_condition = empty($in_variantid) ? XCExtraFieldsSQL::getProductValuesCond() : '';
            $product_variant_ef_values[$pid] = func_query("
                SELECT variantid, fieldid, value
                  FROM $sql_tbl[extra_field_values]
                WHERE
                   productid = '$pid' $_condition
                   AND fieldid IN ('" . implode("','", array_keys($additional_attributes_ids)) . "')
               ") ?: array();
        }

        $product_values = $variant_values = array();

        foreach($product_variant_ef_values[$pid] as $_field) {
            $_fieldid = $_field['fieldid'];
            $_service_name = $additional_attributes_ids[$_fieldid];

            if (empty($_field['variantid'])) {
                // This is the product
                $product_values[$_service_name] = $_field['value'];
            } elseif($in_variantid == $_field['variantid']) {
                // This is a variant
                $variant_values[$_service_name] = $_field['value'];
            }
        }

        // The merge order is 1)extra_fields 2)extra_field_values_products(optional) 3)extra_field_values_variants(optional)
        if (
            $config['Froogle']['froogle_use_product_fields_bydef'] == 'Y'
            || empty($in_variantid)
        ) {
            $product_additional_attributes = array_merge($additional_attributes, $product_values, $variant_values);
        } else {
            $product_additional_attributes = array_merge($additional_attributes, $variant_values);
        }

        assert('count($additional_attributes) == count($product_additional_attributes)');
    }

    return $product_additional_attributes;
}//}}}

/**
 * Override xcart_taxes.price_includes_tax display_including_tax tax options for each tax from Froogle module settings
 */
function func_froogle_get_tax_options() { //{{{
    global $config;

    return func_tax_get_override_display_including_tax($config['Froogle']['froogle_display_including_tax']);
} //}}}

?>
