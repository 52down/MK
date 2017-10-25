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
 * Product variants extra fields management
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v5 (xcart_4_7_7), 2017-01-24 09:29:34, product_variants_extra_fields_modify.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header('Location: ../../'); die('Access denied'); }


x_session_register('search_variants_ef');

if (
    $REQUEST_METHOD == 'POST'
    && $mode == 'product_variants_ef_filter'
) {
    // Save filter conditions
    $search_variants_ef[$productid] = (empty($search)) ? array() : $search;
    func_refresh('variants_extra_fields');
}

if (
    $REQUEST_METHOD == 'POST'
    && $mode == 'product_variants_ef_update'
) {
    // Update variants extra fields
    
    if (
        !empty($posted_data['extra_fields']) 
        && is_array($posted_data['extra_fields'])
    ) {
        foreach ($posted_data['extra_fields'] as $_variantid => $_extra_fields) {
            foreach ($_extra_fields as $_ef_id => $_ef_value) {
                func_ef_update_field_value($productid, $_variantid, $_ef_id, $_ef_value);
            }
        }
    }

    func_refresh('variants_extra_fields');
}


$filter_options = (isset($search_variants_ef[$productid])) ? $search_variants_ef[$productid] : array();


// Get the product options list
$product_options = func_get_product_classes($productid);

// Get products variants
$variants = func_get_product_variants($productid, 0, false, array('get_extra_fields'));

if (
    !empty($filter_options['options'])
    && !empty($variants)
) {
    // Filter variants
    $tmp = current($variants);
    $cnt = count($tmp['options']);
 
    unset($tmp);
 
    foreach ($variants as $k => $v) {
 
        $local_cnt = 0;
 
        foreach ($filter_options['options'] as $cid => $c) {
 
            foreach ($c as $oid) {
 
                if (
                    isset($v['options'][$oid])
                    && $v['options'][$oid]['classid'] == $cid
                ) {
                    $local_cnt++;
                }
 
            } // foreach ($c as $oid)
        
        } // foreach ($filter_options['options'] as $cid => $c)
 
        if ($local_cnt != $cnt) {
            unset($variants[$k]);
        }
 
    } // foreach ($variants as $k => $v)
 
} else if (!is_array($filter_options)) {
 
    $smarty->assign('is_search_all', 'Y');
 
}


// Get extra fields list
$extra_fields_provider = ($current_area == 'A' && !empty($product_info['provider']) ? $product_info['provider'] : $logged_userid );
$extra_fields = $extra_fields_filter = func_ef_get_fields_list($extra_fields_provider);

if (
    !empty($filter_options['extra_fields']) 
    && !empty($extra_fields)
) {
    // Filter extra fields
    foreach ($extra_fields as $k => $v) {
        
        if (!isset($filter_options['extra_fields'][$v['fieldid']])) {
            unset($extra_fields[$k]);
        }
    }
}


if (!empty($product_options)) {
    $smarty->assign('product_options', $product_options);
}

if (!empty($variants)) {
    $smarty->assign('variants', $variants);
}

if (!empty($extra_fields)) {
    $smarty->assign('extra_fields', $extra_fields);
}

if (!empty($extra_fields_filter)) {
    $smarty->assign('extra_fields_filter', $extra_fields_filter);
}

$smarty->assign('filter_options', $filter_options);

?>
