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
 * Templater plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     getvar
 * Input:    value
 * -------------------------------------------------------------
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    1570ad059fc3dd81e1e3723f1770f61d5e2c6d59, v49 (xcart_4_7_8), 2017-06-01 15:37:47, function.getvar.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!defined('XCART_START')) { header("Location: ../../../"); die("Access denied"); }

function smarty_function_getvar($params, &$smarty)
{
    static $funcs, $skip_function_exists_test;
    global $active_modules;
    
    if (empty($funcs)) {
        $funcs = array(
            // 'Data func to call'                          => 'smarty var to assign'
            'func_CPC_get_wizard_config'                    => 'CPC_wizard_config',
            'func_amazon_get_checkout_data'                 => 'checkout_data',
            'func_amazon_get_merchant_URL'                  => 'amazon_merchant_URL',
            'func_cc_paypointft_get_htaccess_code'          => 'htaccess_code',
            'func_get_configuration_styles'                 => '',
            'func_get_offline_payment_methods'              => 'offline_payment_methods',
            'func_get_partners'                             => 'partners',
            'func_get_paypal_express_active'                => 'paypal_express_active',
            'func_get_paypal_express_incontext_available'   => 'paypal_express_incontext_available',
            'func_get_providers'                            => 'providers',
            'func_is_payment_section_visible'               => 'is_payment_section_visible',
            'func_paypal_get_redirect_payment_id'           => 'paypal_redirect_payment_id',
            'func_simplify_get_payment_id'                  => 'simplify_payment_id',
            'func_soc_tpl_is_fb_plugins_enabled'            => '_is_fb_plugins_enabled',
            'func_amazon_feeds_tpl_get_amazon_feeds_cats'   => 'amazon_feeds_catalog',
            'func_tpl_get_admin_top_news'                   => 'top_news',
            'func_tpl_get_bestsellers'                      => 'bestsellers',
            'func_tpl_get_det_images_widget'                => 'det_images_widget',
            'func_tpl_get_order_applied_offers'             => 'order_applied_offers',
            'func_tpl_get_order_tracking_numbers'           => 'tracking_numbers',
            'func_tpl_get_product_key'                      => 'product_key',
            'func_tpl_get_recently_viewed_products'         => 'recently_viewed_products',
            'func_tpl_get_user_field_cssclass'              => 'varname',
            'func_tpl_get_xcart_news'                       => 'xcart_news',
            'func_tpl_is_acheckout_button_enabled'          => 'is_acheckout_button_enabled',
            'func_tpl_is_address_book_empty'                => 'is_address_book_empty',
            'func_tpl_is_jcarousel_is_needed'               => 'is_jcarousel_is_needed',
        );

        if (!empty($active_modules['ShippingEasy'])) {
            $funcs['func_shippingeasy_tpl_get_se_export_status'] = 'shippingeasy_export_status';
        }

        $skip_function_exists_test = array(
        );
    }
    // Usage example {getvar var=offline_payment_methods}            {if $offline_payment_methods ne ''}.........
    //               {getvar func=func_tpl_use_colorbox_for_product} {elseif $func_tpl_use_colorbox_for_product} ...

    // Resolve function name by var/func params
    if (isset($funcs[$params['func']])) {
        $func_name = $params['func'];
        $var_name = $func_name;
    } elseif (
        isset($params['var'])
        && ($_name = array_search($params['var'], $funcs))
    ) {
        $func_name = $_name;
        $var_name = $params['var'];
    } else {
        assert('false /*func_name/var_name cannot be resolved in function.getvar.php*/');
        return '';
    }

    if (isset($params['var'])) {
        $var_name = $params['var'];
    }


    if (!isset($skip_function_exists_test[$func_name])) {
        if (!function_exists($func_name)) {
            return '';
        }
    }
    
    func_unset($params, 'var', 'func');

    $data = call_user_func_array($func_name, $params);

    if (empty($data)) {
        $data = '';
    }

    $smarty->assign($var_name, $data);

    return '';
}
?>
