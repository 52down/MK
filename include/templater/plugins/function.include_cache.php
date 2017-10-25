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
 * Smarty {include_cache} function plugin
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v42 (xcart_4_7_7), 2017-01-24 09:29:34, function.include_cache.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

/**
 * Smarty {include_cache} function plugin
 *
 * Type:     function
 * Name:     include_cache
 * Purpose:  Use cached include if possible instead real include
 * @param array parameters
 * @param Smarty
 * @return null
 */

if (!defined('XCART_START')) { header("Location: ../../../"); die("Access denied"); }

function smarty_function_include_cache($params, &$smarty)
{
    global $config;

    static $result = array();

	$file = $params['file'];
    $use_static_var = isset($params['use_static_var']);

	if (empty($file)) {
		trigger_error("Smarty error:include_cache include_cache: missing 'file' parameter");
		return;
	}

    $_data_cache_ttl = SECONDS_PER_WEEK * 4; // use_sub_dirs is used to avoid FS overflow
	$cache_lifetime = isset($params['cache_lifetime']) ? $params['cache_lifetime'] : $_data_cache_ttl;

	func_unset($params, 'file', 'cache_lifetime', 'use_static_var');
    $orig_params = $params;

    $params['config'] = $smarty->getTemplateVars('config');
    $params['_is_ajax'] = func_is_ajax_request();

    $cache_id = func_get_template_key($file, $params, $smarty);

    $md5_key = $cache_id . $file;
    if (
        $use_static_var
        && isset($result[$md5_key])
    ) {
        return $result[$md5_key];
    }

    $caching = ($config['General']['use_cached_templates'] == 'Y') ? Smarty::CACHING_LIFETIME_SAVED : Smarty::CACHING_OFF;
    $old_use_sub_dirs = $smarty->smarty->use_sub_dirs;
    $smarty->smarty->use_sub_dirs = true;
    $smarty->smarty->called_from_include_cache = true;

    $content = $smarty->getSubTemplate($file, $cache_id, $smarty->compile_id, $caching, $cache_lifetime, $orig_params, 0);
    $smarty->smarty->use_sub_dirs = $old_use_sub_dirs;
    $smarty->smarty->called_from_include_cache = false;

    if ($use_static_var) {
        $result[$md5_key] = $content;
    }

    return $content;
}


function func_get_template_key($file, $params, $smarty)
{
    global $active_modules;
    global $shop_language, $alt_skin_dir, $config, $HTTPS;

    $params['_global_keys'] = '';

    $vars_used_in_templates = array (
        'customer/main/buy_now.tpl' => array (
            '_global_keys'=>1,
            'cat'=> 1,
            'featured'=> 1,
            'is_matrix_view'=> 1,
            'is_a2c_popup'=>1,
            'login'=> 'non_empty_login_value',
            'smarty_get_cat'=> 1,
            'smarty_get_page'=> 1,
            'smarty_get_quantity'=> 1,
            'product' => array (
                'productid'=> 1,
                'add_date'=> 1,
                'avail'=> 1,
                'distribution'=> 1,
                'min_amount'=> 1,
                'monthly_cost'=> 'float',
                'price'=> 1,
                'special_price'=> 1,
                'use_special_price'=> 1,
                'variantid'=> 1,
                'list_price'=> 1,
                'taxed_price'=> 1,
                'taxes'=> 1,
                'appearance' => array (
                    'buy_now_enabled'=> 1,
                    'is_auction'=> 1,
                    'buy_now_buttons_enabled'=> 1,
                    'buy_now_cart_enabled'=> 1,
                    'buy_now_form_enabled'=> 1,
                    'dropout_actions'=> 1,
                    'empty_stock'=> 1,
                    'force_1_amount'=> 1,
                    'loop_quantity'=> 1,
                    'min_quantity'=> 1,
                    'quantity_input_box_enabled'=> 1,
                    'has_market_price'=> 1,
                    'has_price'=> 1,
                    'market_price_discount'=> 1,
                    'added_to_cart'=> 1,
                ),
            ), // 'product' => array (
        ),
    );
    $addon['customer/main/buy_now.tpl'] = array();

    if (
        !empty($active_modules['Socialize'])
        && $file == 'customer/main/buy_now.tpl'
    ) {
        if ($config['Socialize']['soc_pin_enabled'] == 'Y') {
            $_prod_array = array (
                'descr' => function($str) {return substr($str, 0, XC_SOC_PIN_MAX_DESCR);},#nolint
                'tmbn_url' => 1,
                'image_url' => 1,
            );
        } else {
            $_prod_array = array();
        }
        $addon[$file] = array_merge_recursive($addon[$file], array (
            'product' => $_prod_array,
            'active_modules' => array (
                'Socialize' => 1
            ),
            'config' => array (
                'Socialize' => array (
                    'soc_fb_appid' => 1,
                    'soc_fb_like_enabled' => 1,
                    'soc_fb_send_enabled' => 1,
                    'soc_ggl_plus_enabled' => 1,
                    'soc_pin_enabled' => 1,
                    'soc_plist_matrix' => 1,
                    'soc_plist_plain' => 1,
                    'soc_tw_enabled' => 1,
                    'soc_tw_user_name' => 1,
                ),
            ),
            'smarty' => array (
                'get' => array (
                  'block' => 1,
                ),
            ),
            'lng' => array (
                'lbl_soc_tweet' => 1,
            ),
            'ajax_result' => 1,
            'detailed' => 1,
            'href' => 1,
            'ie_ver' => 1,
            'matrix' => 1,
        ));

        // Socialize 3rd-party libs loaded by http or https
        $params['_global_keys'] .= $HTTPS;
    }

    if (
        !empty($active_modules['Add_to_cart_popup'])
        && $file == 'customer/main/buy_now.tpl'
    ) {
        // Add To Cart Popup module
        $addon[$file] = array_merge_recursive($addon[$file], array (
            'active_modules' => array (
                'Add_to_cart_popup' => 1
            ),
        ));
    }

    if (
        !empty($active_modules['New_Arrivals'])
        && $file == 'customer/main/buy_now.tpl'
    ) {
        $addon[$file] = array_merge_recursive($addon[$file], array (
            'active_modules' => array (
                'New_Arrivals' => 1
            ),
            'is_new_arrivals_products' => 1,
        ));

        $params['is_new_arrivals_products'] = $smarty->getTemplateVars('is_new_arrivals_products');
    }

    if (
        !empty($active_modules['On_Sale'])
        && $file == 'customer/main/buy_now.tpl'
    ) {
        $addon[$file] = array_merge_recursive($addon[$file], array (
            'active_modules' => array (
                'On_Sale' => 1
            ),
            'is_on_sale_products' => 1,
        ));

        $params['is_on_sale_products'] = $smarty->getTemplateVars('is_on_sale_products');
    }

    if (
        !empty($active_modules['Pitney_Bowes'])
        && $file == 'customer/main/buy_now.tpl'
    ) {//{{{
        $addon[$file] = array_merge_recursive($addon[$file], array (
            'active_modules' => array (
                'Pitney_Bowes' => 1
            ),
            'product' => array (
                'restriction_code' => function($product_restriction_code) {return !empty($product_restriction_code);},#nolint
                'country' => 1,
            )
        ));
    }//}}}

    if (
        !empty($active_modules['Product_Notifications'])
        && $file == 'customer/main/buy_now.tpl'
    ) {
        $addon[$file] = array_merge_recursive($addon[$file], array (
            'active_modules' => array (
                'Product_Notifications' => 1
            ),
            // 'prod_notif_prefilled_email' => 1, # Commented to prevent cache dir overflow
        ));

        // $params['prod_notif_prefilled_email'] = $smarty->getTemplateVars('prod_notif_prefilled_email'); # Commented to prevent cache dir overflow

    }

    // Add keys from addons
    if (!empty($addon[$file]))
        $vars_used_in_templates[$file] = array_merge_recursive($vars_used_in_templates[$file], $addon[$file]);

    // Generate cache_id according to keys and actual values from $params
    $tpl_product_key = function_exists('func_tpl_get_product_key') ?
        func_tpl_get_product_key($params['product'], $params['featured'])
        : '';

    $params['_global_keys'] .= ($shop_language . $alt_skin_dir . $tpl_product_key);
    $params['active_modules'] = $active_modules;
    if (isset($vars_used_in_templates[$file])) {
        $params = func_array_intersect_key_recursive($params, $vars_used_in_templates[$file]);

        if (!empty($params['product']['productid']))
            $cache_id = 'smarty_|' . $params['product']['productid'] . '|' . md5(serialize($params));
        else
            $cache_id = 'smarty_|' . md5(serialize($params));

    } else {
        $cache_id = 'smarty_|' . md5(serialize($params));
    }

    if (defined('XC_INCLUDE_CACHE_DEBUG')) {
        x_load('logging');
        x_log_add('INCLUDE_CACHE_DEBUG' . (isset($params['product']['productid']) ? $params['product']['productid'] : $tpl_product_key), $params, true);
    }

    return $cache_id;
}

function func_array_intersect_key_recursive($main_array, $mask)
{
    if (!is_array($main_array)) { return $main_array; }

    foreach ($main_array as $k=>$v) {
        if (!isset($mask[$k])) {
            unset($main_array[$k]);
            continue;
        }

        if (
            is_array($mask[$k])
            && !is_numeric(key($mask[$k])) // Do not run the function for duplicated keys like $featured = array(1,1)
        ) {
            $main_array[$k] = func_array_intersect_key_recursive($main_array[$k], $mask[$k]);
        }

/*        if (
            is_string($mask[$k])
            && is_string($main_array[$k])
            && !empty($main_array[$k])
        ) {
            // cast some values like login to default value to avoid cache dir overflow
            $main_array[$k] = $mask[$k];
        }*/
        if (
            is_string($main_array[$k])
            && !empty($main_array[$k])
            && is_callable($mask[$k])
        ) {
            // truncate some value according to template rules
            $main_array[$k] = $mask[$k]($main_array[$k]);
        }
    }
    return $main_array;
}
?>
