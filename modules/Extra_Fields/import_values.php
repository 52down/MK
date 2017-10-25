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
 * Import/export proucts extra fields values
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v36 (xcart_4_7_7), 2017-01-24 09:29:34, import_values.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

/******************************************************************************
Used cache format:
Products (by Product ID):
    data_type:     PI
    key:        <Product ID>
    value:        [<Product code> | RESERVED]
Products (by Product code):
    data_type:     PR
    key:        <Product code>
    value:        [<Product ID> | RESERVED]
Products (by Product name):
    data_type:  PN
    key:        <Product name>
    value:        [<Product ID> | RESERVED]

Extra fields (by Service names):
    data_type:  EN
    key:        <Service name>
    value:        [<Field ID> | RESERVED]

Note: RESERVED is used if ID is unknown
******************************************************************************/

if ( !defined('XCART_SESSION_START') ) { header("Location: ../"); die("Access denied"); }

$provider_condition = ($single_mode ? '' : " AND provider = '".$import_data_provider."'");

if ($import_step == 'process_row') {
/**
 * PROCESS ROW from import file
 */

    // Check productid / productcode / product
    list($_productid, $_variantid) = func_import_detect_product($values);
    if (is_null($_productid) || ($action == 'do' && empty($_productid))) {
        func_import_error('msg_err_import_log_message_14');
        return false;
    }

    if (!empty($values['variantcode']) && !empty($active_modules['Product_Options'])) {
        $_variantid = func_import_get_cache('VC', $values['variantcode']);
        if (is_null($_variantid) && empty($import_file['drop']['product_options']) && empty($import_file['drop']['product_variants'])) {
            if (!empty($_productid)) {
                $_variantid = XCVariantsSQL::getVariantBySKU(addslashes($values['variantcode']), $_productid);

                if (empty($_variantid)) {
                    $_variantid = NULL;

                } elseif ($action == 'do') {
                    func_import_save_cache('VC', $values['variantcode'], $_variantid);
                }
            }
        }

        if (is_null($_variantid) || ($action == 'do' && empty($_variantid))) {
            func_import_module_error('msg_err_import_log_message_48', array('sku' => $values['variantcode']));
        }
    } else {
        $_variantid = 0;
    }

    foreach ($values as $n => $v) {
        if (in_array($n, array('productid', 'productcode', 'product', 'variantcode')) || zerolen($n))
            continue;

        // Check column name as service name of extra field
        $_fieldid = func_import_get_cache('EN', $n);
        if (is_null($_fieldid)) {
            $_fieldid = func_query_first_cell("SELECT fieldid FROM $sql_tbl[extra_fields] WHERE service_name = '".addslashes($n)."'".$provider_condition);
            if (empty($_fieldid)) {
                $_fieldid = NULL;
            } elseif ($action == 'do') {
                func_import_save_cache('EN', $n, $_fieldid);
            }
            if (is_null($_fieldid) || ($action == 'do' && empty($_fieldid))) {
                func_import_error('msg_err_import_log_message_41', array('sname' => $n));
                return false;
            }
        }
    }

    $values['productid'] = intval($_productid);
    $values['variantid'] = intval($_variantid);

    $data_row[] = $values;

}
elseif ($import_step == 'finalize') {
/**
 * FINALIZE rows processing: update database
 */

    if (!empty($import_file['drop'][strtolower($section)])) {
        if ($provider_condition) {

            // Delete data by provider
            $select_ids = "SELECT fieldid FROM $sql_tbl[extra_fields] WHERE 1 " . $provider_condition;
            db_query("DELETE FROM $sql_tbl[extra_field_values] WHERE fieldid IN ($select_ids)");
        }
        else {

            // Delete all data
            db_query("DELETE FROM $sql_tbl[extra_field_values]");
        }

        $import_file['drop'][strtolower($section)] = '';
    }

    foreach ($data_row as $row) {

        // Import data...

        foreach ($row as $n => $v) {
            if (in_array($n, array('productid', 'productcode', 'product', 'variantcode', 'variantid')) || zerolen($n))
                continue;

            // Get field ID
            $_fieldid = func_import_get_cache('EN', $n);
            if (empty($_fieldid) || empty($v)) {
                continue;
            }

            if (!$user_account['allow_active_content'])
                $v = func_xss_free($v);

            $data = array(
                'productid'    => $row['productid'],
                'variantid' => $row['variantid'],
                'fieldid'    => $_fieldid,
                'value'        => addslashes($v),
            );

            $is_new = (func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[extra_field_values] WHERE productid = '$row[productid]' AND variantid = '$row[variantid]' AND fieldid = '$_fieldid'") == 0);
            func_array2insert('extra_field_values', $data, true);

            if ($is_new) {
                $result[strtolower($section)]['added']++;
            } else {
                $result[strtolower($section)]['updated']++;
            }
        }

        func_flush(". ");

    }

// Export data
} elseif ($import_step == 'export') {

    while ($id = func_export_get_row($data)) {
        if (empty($id))
            continue;

        $join_values_condition = empty($active_modules['Product_Options'])
            ? XCExtraFieldsSQL::joinProductValues('INNER', $id)
            : XCExtraFieldsSQL::joinAllValues('INNER', $id);

        // Get data
        $variant_rows = func_query_hash("SELECT $sql_tbl[extra_field_values].variantid, $sql_tbl[extra_fields].service_name, $sql_tbl[extra_field_values].value, $sql_tbl[extra_field_values].fieldid FROM $sql_tbl[extra_fields] $join_values_condition WHERE 1 " . (empty($provider_sql) ? '' : " AND $sql_tbl[extra_fields].provider = '$provider_sql' "), 'variantid');

        if (empty($variant_rows))
            continue;

        // Get product signature
        $p_row = func_export_get_product($id);
        if (empty($p_row)) {
            continue;
        }

        $variant_productcodes = array();
        if (!empty($active_modules['Product_Options'])) {
            $variant_ids = array_filter(array_keys($variant_rows));
            if (!empty($variant_ids)) {
                $variant_productcodes = func_query_hash("SELECT variantid, productcode FROM $sql_tbl[variants] WHERE variantid IN ('" . implode("','", $variant_ids) . "')", 'variantid', false, true);
            }
        }

        foreach ($variant_rows as $_variantid => $variant_extra_fields) {
            $_extra_fields = array();
            foreach ($variant_extra_fields as $sn => $ef) {
                $_extra_fields[strtolower($ef['service_name'])] = $ef['value'];
            }
            if (!empty($active_modules['Product_Options'])) {
                $_variantcode = isset($variant_productcodes[$_variantid]) ? $variant_productcodes[$_variantid] : '';
                $_merge_variantcode = array('variantcode' => $_variantcode);
            } else {
                $_merge_variantcode = array();
            }
            // Write row
            if (!func_export_write_row(array_merge($p_row, $_extra_fields, $_merge_variantcode))) {
                break;
            }
        }
    }

}

?>
