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
 * Functions for Extra fields module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v37 (xcart_4_7_7), 2017-01-24 09:29:34, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

class XCExtraFieldsSQL {
    public static function joinProductValues($join_type, $product_ids)
    {// {{{
        global $sql_tbl;
        $product_ids = $product_ids ?: 0;
        $product_ids = is_array($product_ids) ? $product_ids : array(intval($product_ids));
        return " $join_type JOIN $sql_tbl[extra_field_values] ON $sql_tbl[extra_field_values].productid IN ('" . implode("','", $product_ids) . "') AND $sql_tbl[extra_field_values].variantid = 0 AND $sql_tbl[extra_fields].fieldid = $sql_tbl[extra_field_values].fieldid ";

    } // }}}

    public static function joinVariantValues($join_type, $product_ids)
    {// {{{
        global $sql_tbl;
        $product_ids = $product_ids ?: 0;
        $product_ids = is_array($product_ids) ? $product_ids : array(intval($product_ids));
        return " $join_type JOIN $sql_tbl[extra_field_values] ON $sql_tbl[extra_field_values].productid IN ('" . implode("','", $product_ids) . "') AND $sql_tbl[extra_field_values].variantid > 0 AND $sql_tbl[extra_fields].fieldid = $sql_tbl[extra_field_values].fieldid ";

    } // }}}

    public static function joinAllValues($join_type, $product_ids)
    {// {{{
        global $sql_tbl;
        $product_ids = $product_ids ?: 0;
        $product_ids = is_array($product_ids) ? $product_ids : array(intval($product_ids));
        return " $join_type JOIN $sql_tbl[extra_field_values] ON $sql_tbl[extra_field_values].productid IN ('" . implode("','", $product_ids) . "') AND $sql_tbl[extra_fields].fieldid = $sql_tbl[extra_field_values].fieldid ";

    } // }}}

    public static function getVariantValuesCond($product_ids)
    {// {{{
        global $sql_tbl;
        $product_ids = is_array($product_ids) ? $product_ids : array(intval($product_ids));
        return "  $sql_tbl[extra_field_values].productid IN ('" . implode("','", $product_ids) . "') AND $sql_tbl[extra_field_values].variantid > 0 ";

    } // }}}

    public static function getProductValuesCond()
    {// {{{
        global $sql_tbl;
        return " AND $sql_tbl[extra_field_values].variantid = 0 ";

    } // }}}

    public static function getAllVariantValues($productid, $use_cache = SKIP_CACHE)
    {// {{{
        global $sql_tbl;
        static $static_res;

        if (
            $use_cache === USE_CACHE
            && isset($static_res[$productid])
        ) {
            return $static_res[$productid];
        }

        $_res = func_query_hash("SELECT variantid, $sql_tbl[extra_field_values].* FROM $sql_tbl[extra_field_values] WHERE " . self::getVariantValuesCond($productid), 'variantid');
        if ($use_cache === USE_CACHE) {
            $static_res[$productid] = $_res;
        }
        return $_res;

    } // }}}

}//XCExtraFieldsSQL

class XCExtraFieldsChange {
    public static function deleteVariantValues($product_ids, $use_cache = SKIP_CACHE)
    {// {{{
        global $sql_tbl;
        static $static_res;
        ($use_cache === USE_CACHE) && ($md5_key = md5(serialize($product_ids)));

        if (
            $use_cache === USE_CACHE
            && isset($static_res[$md5_key])
        ) {
            return $static_res[$md5_key];
        }

        if (!empty($product_ids)) {
            $_res = db_query("DELETE FROM $sql_tbl[extra_field_values] WHERE " . XCExtraFieldsSQL::getVariantValuesCond($product_ids));
        } else {
            $_res = db_query("DELETE FROM $sql_tbl[extra_field_values] WHERE $sql_tbl[extra_field_values].variantid > 0");
        }
        if ($use_cache === USE_CACHE) {
            $static_res[$md5_key] = $_res;
        }
        return $_res;

    } // }}}

    public static function generateMultipleInserts($extra_fields, $productid, $variantid, $current_query = '')
    {// {{{
        global $sql_tbl, $sql_max_allowed_packet;
        $prefix_query = "REPLACE INTO $sql_tbl[extra_field_values] (productid,variantid,fieldid,value) VALUES ";

        foreach ($extra_fields as $_variant_ef) {
            $_variant_ef = func_addslashes($_variant_ef);
            $_next_query = "('$productid', '$variantid', '$_variant_ef[fieldid]','$_variant_ef[value]'),";

            if (strlen($prefix_query . $current_query . $_next_query) >= $sql_max_allowed_packet) {
                // Next values is bigger the Sql_max_allowed_packet, flush current values to DB
                self::runMultipleInserts($current_query);
                $current_query = '';
            }
            $current_query .= $_next_query;
        }

        return $current_query;

    } // }}}

    public static function runMultipleInserts($query)
    {// {{{
        global $sql_tbl;
        $prefix_query = "REPLACE INTO $sql_tbl[extra_field_values] (productid,variantid,fieldid,value) VALUES ";
        return db_query($prefix_query . rtrim($query, ' ,'));
    } // }}}

    public static function sortByOrderby($extra_fields)
    {// {{{
        // PHP sort is used to avoid mysql file sorting
        usort($extra_fields,
            function($a, $b) {#nolint
                return intval($a['orderby'] . $a['fieldid']) > intval($b['orderby'] . $b['fieldid']);#nolint
            }
        );
        return $extra_fields;
    } // }}}

}//XCExtraFieldsChange

/**
 * Check service name format
 */
function func_ef_check_service_name($sname, $user, $fieldid = 0)
{
    global $single_mode, $sql_tbl, $froogle_additional_attributes, $active_modules;

    $condition = '';
    if (!$single_mode)
        $condition .= " AND provider = '$user'";
    if ($fieldid > 0)
        $condition .= " AND fieldid != '$fieldid'";

    if (zerolen($sname) || empty($sname))
        return 'empty';

    if (
        !empty($active_modules['Froogle'])
        && in_array(strtolower($sname), $froogle_additional_attributes)
    ) {
        // Allow custom attributes names to work with froogle 
        return true;
    } 

    if (!preg_match("/^[\d\w_]+$/S", $sname))
        return 'format';
        
    if (in_array(strtoupper($sname), array('PRODUCTID', 'PRODUCTCODE', 'PRODUCT')))
        return 'name';

    if (func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[extra_fields] WHERE service_name = '$sname'".$condition) > 0)
        return 'duplicate';

    return true;
}

/**
 * Regenerate PRODUCTS_EXTRA_FIELD_VALUES import section structure
 * before read section columns names
 */
function func_ef_before_import($section, &$section_data)
{
    global $sql_tbl, $import_file, $import_data_provider, $single_mode;

    if (strtolower($section) != 'products_extra_field_values')
        return false;

    $fields = array();
    if (empty($import_file['drop'][strtolower($section)])) {

        $provider_condition = ($single_mode ? '' : " AND provider = '".$import_data_provider."'");
        $fields = func_query_column("SELECT service_name FROM $sql_tbl[extra_fields] WHERE 1".$provider_condition);
    }

    while (list($sname, $id) = func_import_read_cache('EN')) {
        if (!is_null($id)) {
            $fields[] = $sname;
        }
    }

    if (empty($fields))
        return false;

    foreach ($fields as $f) {
        $section_data['columns'][strtolower($f)] = array();
    }

    return true;
}

/**
 * Regenerate PRODUCTS_EXTRA_FIELD_VALUES import section structure
 * before initialize export procedure
 */
function func_ef_init_export($section, &$section_data)
{
    global $sql_tbl, $export_data, $current_area, $active_modules, $logged_userid;

    if (strtolower($section) != 'products_extra_field_values')
        return false;

    if ($current_area == 'P' && empty($active_modules['Simple_Mode'])) {
        $provider = $logged_userid;
    } elseif (!empty($export_data['provider'])) {
        $provider = $export_data['provider'];
    }

    $provider_condition = (empty($provider) ? '' : " AND provider = '$provider'");
    $fields = func_query_column("SELECT service_name FROM $sql_tbl[extra_fields] WHERE 1".$provider_condition);

    if (empty($fields))
        return false;

    foreach ($fields as $f) {
        $section_data['columns'][strtolower($f)] = array();
    }

    return true;
}

/**
 * Regenerate PRODUCTS_EXTRA_FIELD_VALUES import section structure
 * before initialize import procedure
 */
function func_ef_init_import($section, &$section_data)
{
    global $sql_tbl, $import_file, $import_data_provider, $single_mode;

    if (strtolower($section) != 'products_extra_field_values')
        return false;

    $provider_condition = ($single_mode ? '' : " AND provider = '".addslashes($import_data_provider)."'");
    $fields = func_query_column("SELECT service_name FROM $sql_tbl[extra_fields] WHERE 1".$provider_condition);

    if (empty($fields))
        return true;

    foreach ($fields as $f) {
        $section_data['columns'][strtolower($f)] = array();
    }

    return true;
}

/**
 * Get extra fields list for the product and its variants
 */
function func_ef_get_product_variant_fields($productid, $provider_condition, $_is_variants, $variants=false)
{//{{{
    global $sql_tbl, $config, $shop_language, $single_mode, $active_modules;
    // LEFT JOIN is needed to obtain default value from xcart_extra_fields table
    $_join_type = $config['Extra_Fields']['display_default_extra_fields'] == 'Y' ? 'LEFT' : 'INNER';

    $join_extra_field_values = !empty($variants) && !empty($active_modules['Product_Options']) && in_array($_is_variants, array('Y','E'))
        ? XCExtraFieldsSQL::joinAllValues($_join_type, $productid)
        : XCExtraFieldsSQL::joinProductValues($_join_type, $productid);

    $extra_fields = func_query("SELECT $sql_tbl[extra_fields].*, $sql_tbl[extra_field_values].value as field_value, IF($sql_tbl[extra_fields_lng].field != '', $sql_tbl[extra_fields_lng].field, $sql_tbl[extra_fields].field) as field, $sql_tbl[extra_field_values].variantid FROM $sql_tbl[extra_fields] $join_extra_field_values LEFT JOIN $sql_tbl[extra_fields_lng] ON $sql_tbl[extra_fields].fieldid = $sql_tbl[extra_fields_lng].fieldid AND $sql_tbl[extra_fields_lng].code = '$shop_language' WHERE 1 $provider_condition");

    $extra_fields = $extra_fields ?: array();
    $_def_variant_values = array();
    foreach ($extra_fields as $k => $v) {
        if (!empty($v['variantid'])) {
            // Collect all variant fieldids
            $_def_variant_values[$v['fieldid']] = isset($_def_variant_values[$v['fieldid']]) ? $_def_variant_values[$v['fieldid']] : $v;

            // Modify $variants from Customer_options.php
            if (!empty($variants[$v['variantid']])) {
                $variants[$v['variantid']]['variant_extra_fields'][$v['fieldid']] = $v;
            }
            unset($extra_fields[$k]);
        } else {
            unset($extra_fields[$k]['variantid']);
        }
    }

    // Add absent product extra fieldid from default variant variant_extra_fields
    if (!empty($_def_variant_values)) {
        $extra_fields = array_values($extra_fields);
        $product_fieldid_array = $extra_fields;
        array_walk($product_fieldid_array, create_function('&$val, $key', '$val = $val["fieldid"];'));#nolint
        foreach ($_def_variant_values as $_fieldid => $v) {
            if (!in_array($_fieldid, $product_fieldid_array)) {
                $v['field_value'] = '&nbsp;';
                $extra_fields[] = $v;
            }
        }
    }

    $extra_fields = XCExtraFieldsChange::sortByOrderby($extra_fields);

    return array($extra_fields, $variants);
}//Func_ef_get_product_variant_fields}}}

/**
 * Get extra fields list
 *
 * @param integer $provider_id Provider ID (optional)
 *
 * @return array
 */
function func_ef_get_fields_list($provider_id = false)
{//{{{
    global $sql_tbl, $shop_language, $single_mode, $logged_userid;

    $provider_id = $provider_id ?: $logged_userid;
    $_provider_condition = ($single_mode ? '' : " AND $sql_tbl[extra_fields].provider = '" . intval($provider_id) . "'");

    $extra_fields = func_query(
        "SELECT $sql_tbl[extra_fields].*, IF($sql_tbl[extra_fields_lng].field != '', $sql_tbl[extra_fields_lng].field, $sql_tbl[extra_fields].field) AS field"
        . " FROM $sql_tbl[extra_fields]"
        . " LEFT JOIN $sql_tbl[extra_fields_lng] ON $sql_tbl[extra_fields].fieldid = $sql_tbl[extra_fields_lng].fieldid AND $sql_tbl[extra_fields_lng].code = '$shop_language'"
        . " WHERE 1 $_provider_condition"
        . " ORDER BY $sql_tbl[extra_fields].orderby"
    );

    return $extra_fields;
}//Func_ef_get_fields_list}}}

/**
 * Update product extra field value
 *
 * @param integer productid  Product ID
 * @param integer $variantid Variant ID (optional)
 * @param integer $fieldid   Extra field ID
 * @param string  $value     Field value
 *
 * @return boolean
 */
function func_ef_update_field_value($productid, $variantid, $fieldid, $value)
{//{{{
    global $sql_tbl;

    $productid = intval($productid);
    $variantid = intval($variantid);
    $fieldid = intval($fieldid);

    if (trim($value) != "") {

        $query_data = array(
            'productid' => $productid,
            'variantid' => $variantid,
            'fieldid'   => $fieldid,
            'value'     => $value,
        );

        func_array2insert('extra_field_values', $query_data, true);

    } else {

        db_query(
            "DELETE FROM $sql_tbl[extra_field_values]"
            . " WHERE productid = '$productid' AND variantid = '$variantid' AND fieldid = '$fieldid'"
        );

    }

    return true;
}//Func_ef_update_field_value}}}

?>
