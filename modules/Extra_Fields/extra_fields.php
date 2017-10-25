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
 * Gets extra-fields related data
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v49 (xcart_4_7_7), 2017-01-24 09:29:34, extra_fields.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../../"); die("Access denied"); }

global $variants, $smarty, $single_mode;
#IN $Variants, $Productid, $Product_info, $Single_mode
#OUT $Extra_fields, $Variants

$_provider_condition = ($single_mode ? '' : " AND $sql_tbl[extra_fields].provider='$extra_fields_provider' ");
if (!empty($productid) && in_array(AREA_TYPE, array('C', 'B'))) {
    // Have to be included after customer_options.php to obtain variant extra_fields
    assert('empty($active_modules["Product_Options"]) || isset($variants) /* The Extra_fields.php have to be included after Customer_options.php to obtain variant extra_fields */');
    assert('!empty($product_info) /* product_info is needed for the Func_ef_get_product_variant_fields func*/');
    list($extra_fields, $variants) = func_ef_get_product_variant_fields(
        $productid,
        $_provider_condition,
        empty($product_info['is_variants']) ? '': $product_info['is_variants'],
        empty($variants) ? array() : $variants
    );
    if (!empty($variants)) {
        $smarty->assign('variants', $variants);
    }
} else {
    if ($productid) {
        $extra_fields = func_query("SELECT $sql_tbl[extra_fields].*, $sql_tbl[extra_field_values].value as field_value, IF($sql_tbl[extra_fields_lng].field != '', $sql_tbl[extra_fields_lng].field, $sql_tbl[extra_fields].field) as field FROM $sql_tbl[extra_fields] " . XCExtraFieldsSQL::joinProductValues('LEFT', $productid) . " LEFT JOIN $sql_tbl[extra_fields_lng] ON $sql_tbl[extra_fields].fieldid = $sql_tbl[extra_fields_lng].fieldid AND $sql_tbl[extra_fields_lng].code = '$shop_language' WHERE 1 $_provider_condition ORDER BY $sql_tbl[extra_fields].orderby");
    } else {
        $extra_fields = func_query("SELECT $sql_tbl[extra_fields].*, IF($sql_tbl[extra_fields_lng].field != '', $sql_tbl[extra_fields_lng].field, $sql_tbl[extra_fields].field) as field FROM $sql_tbl[extra_fields] LEFT JOIN $sql_tbl[extra_fields_lng] ON $sql_tbl[extra_fields].fieldid = $sql_tbl[extra_fields_lng].fieldid AND $sql_tbl[extra_fields_lng].code = '$shop_language' WHERE 1 $_provider_condition ORDER BY $sql_tbl[extra_fields].orderby");
    }
}

if (!empty($extra_fields)) {

 
    if ($productid) {
        foreach($extra_fields as $_rf_index => $_ef) {
            $extra_fields[$_rf_index]['is_value'] = trim($_ef['field_value']) == '' ? '' : 'Y';
        }
    }

    if (in_array(AREA_TYPE, array('C', 'B')) && $config["Extra_Fields"]["display_default_extra_fields"] == 'Y') {
        foreach ($extra_fields as $ef_k=>$ef_v) {
            $_def_is_value = trim($ef_v['value']) == '' ? '' : 'Y';
            if (empty($ef_v['field_value']) && $ef_v['is_value'] != 'Y' && $_def_is_value == 'Y') {
                $extra_fields[$ef_k]['is_value'] = 'Y';
                $extra_fields[$ef_k]['field_value'] = $ef_v['value'];
            }
        }
    }

    if (in_array(AREA_TYPE, array('C', 'B')) && !$product_info["allow_active_content"]) {
        foreach ($extra_fields as $k => $v) {
            $extra_fields[$k]['field_value'] = func_xss_free($v['field_value']);
        }
    }

    $smarty->assign('extra_fields', $extra_fields);
}

?>
