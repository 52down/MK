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
 * Collect necessary options and variants data for the product page
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v67 (xcart_4_7_7), 2017-01-24 09:29:34, customer_options.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../../"); die("Access denied"); }

if (empty($err)) $err = '';

$product_options    = func_get_product_classes($productid, !empty($product_info['is_taxes']));
$product_options_ex = func_get_product_exceptions($productid);
$product_options_js = ($product_info['allow_active_content'])
    ? func_get_product_js_code($productid)
    : '';
$variants           = func_get_product_variants($productid, $user_account['membershipid']);

$membershipid = ($current_area == 'C')
    ? $user_account['membershipid']
    : $userinfo['membershipid'];

if (empty($options))
    $options = func_get_default_options($productid, $product_info['min_amount'], $user_account['membershipid']);

if (
    !empty($product_options)
    && !empty($options)
    && is_array($options)
) {

    // Define pre-selected options
    foreach ($product_options as $k => $v) {

        if (preg_match("/^\d+$/S", $options[$v['classid']])) {

            if (
                $v['is_modifier'] == 'T'
                || $v['is_modifier'] == 'A'
            ) {

                $product_options[$k]['default'] = $options[$v['classid']];

            } else {

                if (!isset($v['options'][$options[$v['classid']]])) // Correction for X-AOM
                    continue;

                $product_options[$k]['options'][$options[$v['classid']]]['selected'] = 'Y';

            }

        } else {

            $product_options[$k]['default'] = $options[$v['classid']];

        }

    }

}

if (!empty($product_options))
    $smarty->assign('product_options', $product_options);

if (!empty($product_options_ex)) {
    $smarty->assign('product_options_ex', $product_options_ex);

    $exceptions2hide = array();
    foreach ($product_options_ex as $_exception_ind => $_exception) {
        foreach ($_exception as $_exception_option_ind => $_exception_option) {
            if ($_exception_option['hide_on_frontpage'] == 'Y') {
                $exceptions2hide[$_exception_ind][$_exception_option_ind] = $_exception_option;
            }
        }
    }

    $smarty->assign('product_options_ex2hide', $exceptions2hide);
}

if (!empty($variants)) {

    foreach ($variants as $v) {
        if ($v['taxed_price'] != 0) {
            $smarty->assign('variant_price_no_empty', true);
            break;
        }
    }

    if ($config['Product_Options']['po_use_list_price_variants'] == 'Y') {
        foreach ($variants as $k=>$v) {
            $variants[$k]['list_price'] = XCProductListPrice::applyTax($v['list_price'], $v['taxed_price'], $v['price']);
        }

        if ($config['Product_Options']['dynamic_save_money_enabled'] == 'Y') {
            foreach ($variants as $v) {
                if (!empty($v['list_price']) && $v['list_price'] > $v['taxed_price']) {
                    $smarty->assign('variant_list_price_no_empty', true);
                    break;
                }
            }
        }
    }

    $smarty->assign('variants', $variants);
}

$smarty->assign('err',                   $err);
$smarty->assign('product_options_count', is_array($product_options) ? count($product_options) : 0);
$smarty->assign('product_options_js',    @trim($product_options_js));

?>
