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
 * Import/export products interbational descriptions
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v52 (xcart_4_7_7), 2017-01-23 20:12:10, import_products_lng.php, aim
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
Deleted product data:
    data_type:    DP
    key:        <Product ID>
    value:        <Flags>

Note: RESERVED is used if ID is unknown
******************************************************************************/

if ( !defined('XCART_SESSION_START') ) { header("Location: ../"); die("Access denied"); }

if (!defined('IMPORT_PRODUCTS_LNG')) {
/**
 * Make default definitions (only on first inclusion!)
 */
    define('IMPORT_PRODUCTS_LNG', 1);
    $modules_import_specification['MULTILANGUAGE_PRODUCTS'] = array(
        'script'        => '/include/import_products_lng.php',
        'permissions'   => 'AP',
        'need_provider' => true,
        'is_language'   => true,
        'export_sql'    => 'SELECT productid FROM ' . XC_TBL_PREFIX . 'products_lng_{{code}}',
        'table'         => 'products_lng_{{code}}',
        'key_field'     => 'productid',
        'parent'        => 'PRODUCTS',
        'finalize'      => true,
        'columns'       => array(
            'productid'     => array(
                'type'      => 'N',
                'is_key'    => true,
                'default'   => 0),
            'productcode'   => array(
                'is_key'    => true),
            'product'       => array(
                'is_key'    => true),
            'code'          => array(
                'array'     => true,
                'type'      =>    'C',
                'required'  => true),
            'product_name'  => array(
                'array'     => true),
            'descr'         => array(
                'eol_safe'  => true,
                'array'     => true),
            'fulldescr'     => array(
                'eol_safe'  => true,
                'array'     => true),
            'keywords'      => array(
                'array'     => true)
        )
    );
}

if ($import_step == 'process_row') {
/**
 * PROCESS ROW from import file
 */

    // Check productid / productcode / product
    list($_productid, $_variantid) = func_import_detect_product($values);
    if (is_null($_productid) || ($action == 'do' && empty($_productid))) {
        func_import_module_error('msg_err_import_log_message_14');
        return false;
    }

    $all_languages = $all_languages ?: func_data_cache_get('languages', array($shop_language));
    $values['productid'] = $_productid;
    $values['lbls'] = array();
    foreach ($values['code'] as $k => $v) {
        if (empty($values['product_name'][$k]) && empty($values['descr'][$k]) && empty($values['fulldescr'][$k]) && empty($values['keywords'][$k])) {
            continue;
        }

        if (!isset($all_languages[$v])) {
            continue;
        }

        $values['lbls'][$v] = array(
            'product'    => isset($values['product_name'][$k]) ? $values['product_name'][$k] : null,
            'descr'      => isset($values['descr'][$k]) ? $values['descr'][$k] : null,
            'keywords'   => isset($values['keywords'][$k]) ? $values['keywords'][$k] : null,
            'fulldescr'  => isset($values['fulldescr'][$k]) ? $values['fulldescr'][$k] : null,
        );
        $values['lbls'][$v] = array_filter($values['lbls'][$v], function ($val){
            return !is_null($val);
        });

    }
    unset($values['code']);

    $data_row[] = $values;

}
elseif ($import_step == 'finalize') {
/**
 * FINALIZE rows processing: update database
 */

    if (!empty($import_file['drop'][strtolower($section)])) {
        if ($provider_condition) {
            // Search for products created by provider...
            $products_to_delete = db_query($s = "SELECT productid FROM $sql_tbl[products] WHERE 1 ".$provider_condition);
            func_call_pre_post_event('products.lng.delete', array('query' => $s));
            if ($products_to_delete) {
                while ($value = db_fetch_array($products_to_delete)) {
                    func_delete_entity_from_lng_tables('products_lng_', $value['productid'], 'productid');
                }
            }
        }
        else {
            // Delete all products and related information...
            func_call_pre_post_event('products.lng.delete');
            func_delete_entity_from_lng_tables('products_lng_');
        }

        $import_file['drop'][strtolower($section)] = '';
    }

    // Do not use postponed listeners here to avoid sessions overflow
    $data_row = func_call_pre_post_event('products.lng.import', $data_row) ?: $data_row;

    foreach ($data_row as $row) {

        // Import multilanguage product labels
        foreach ($row['lbls'] as $k => $v) {
            if (empty($v)) {
                continue;
            }

            $data = $v;
            $data['productid'] = $row['productid'];
            if (!$user_account['allow_active_content']) {
                foreach ($data as $key => $item)
                    $v = $data[$key] = func_xss_free($data[$key]);
            }

            $data = func_addslashes($data);
            db_query(rtrim("INSERT INTO " . $sql_tbl['products_lng_' . $k] . " (productid, product, descr, fulldescr, keywords) VALUES ('$data[productid]', " .
                    "'" . (!empty($data['product']) ? "$data[product]" : '') . "'," .
                    "'" . (!empty($data['descr']) ? "$data[descr]" : '') . "'," .
                    "'" . (!empty($data['fulldescr']) ? "$data[fulldescr]" : '') . "'," .
                    "'" . (!empty($data['keywords']) ? "$data[keywords]" : '') . "')" .
                " ON DUPLICATE KEY UPDATE " .
                    (isset($data['product'])    ? "product='$data[product]'," : '') .
                    (isset($data['descr'])      ? "descr='$data[descr]'," : '') .
                    (isset($data['fulldescr'])  ? "fulldescr='$data[fulldescr]'," : '') .
                    (isset($data['keywords'])   ? "keywords='$data[keywords]'," : '')
            , ','));

            // For existent rows ON DUPLICATE KEY returns 2
            if (db_affected_rows() == 1) {
                $result[strtolower($section)]['added']++;
            } else {
                $result[strtolower($section)]['updated']++;
            }
        }

        func_flush(". ");

    }

} elseif ($import_step == 'complete') {
    // Post-import step

    //Repair one-to-one relationship between xcart_products and xcart_products_lng_.. tables
    func_repair_lng_integrity('products_lng_', $sql_tbl['products'], 'productid', "'restored_product' AS product, 'restored_product' AS descr, 'restored_product' AS fulldescr, '' AS keywords");    

} elseif ($import_step == 'export') {

    $current_code = func_validate_language_code($current_code);
    while ($productid = func_export_get_row($data)) {
        if (empty($productid))
            continue;

        // Get product signature
        $p_row = func_export_get_product($productid);
        if (empty($p_row))
            continue;

        $row = func_query_first("SELECT * FROM {$sql_tbl['products_lng_' .$current_code]} WHERE productid = '$productid'");
        if (empty($row))
            continue;

        $row['code'] = $current_code;
        $row['product_name'] = $row['product'];
        $row['productcode'] = $p_row['productcode'];

        func_unset($row, 'product');

        if (!func_export_write_row($row))
            break;
    }
}

?>
