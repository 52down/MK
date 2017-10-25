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
 * Module configuration
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v29 (xcart_4_7_7), 2017-01-24 09:29:34, config.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */
if (!defined('XCART_START')) {
    header('Location: ../../');
    die('Access denied');
}

global $config, $smarty, $xcart_dir, $php_url;
global $fb_shop_config, $shop_language, $sql_tbl;

define('IS_MULTILANGUAGE', true);

/**
 * Global definitions for fCommerce Go fields module
 */
if (strnatcmp($config['version'], '4.4') >= 0) {
    define('IS_XCART_44', true);
    $smarty->assign('IS_XCART_44', constant('IS_XCART_44'));
}
if (strnatcmp($config['version'], '4.3') >= 0) {
    define('IS_XCART_43', true);
    $smarty->assign('IS_XCART_43', constant('IS_XCART_43'));
}
if (strnatcmp($config['version'], '4.2') >= 0) {
    define('IS_XCART_42', true);
    $smarty->assign('IS_XCART_42', constant('IS_XCART_42'));
}

/*
  For include/version.php
 */
$addons['fCommerce_Go'] = true;

/*
  Load module functions
 */
$_module_dir = $xcart_dir . XC_DS . 'modules' . XC_DS . 'fCommerce_Go';

if (!empty($include_func))
    require_once $_module_dir . XC_DS . 'func.php';

/**
 * Some necessary functions
 */
/*
  Wrapper for php constant function
 */
if (!function_exists('func_fb_shop_constant')) {

    function func_fb_shop_constant($constant) {
        if (defined($constant))
            return constant($constant);
        else
            return false;
    }

}

if (!function_exists('func_fb_shop_prepare_categories')) {

    function func_fb_shop_prepare_categories($all_categories=array(), $categories=array(), $filter = false, $cat = 0) {

        global $config, $_has_sublevels;

        if (defined('IS_XCART_44')) {

            if (empty($categories)) {
                $categories = func_get_categories_list($cat, false);
            }

            $all_categories = func_get_categories_list($cat, false, true);
        }

        if (
                is_array($all_categories)
                && !empty($all_categories)
        ) {

            if (func_fb_shop_constant('AREA_TYPE') == 'C') {
                array_walk($all_categories, 'func_fb_shop_prepare_products', 'C');
                array_walk($categories, 'func_fb_shop_prepare_products', 'C');

                if ($filter) {
                    foreach ($categories as $k => $v) {
                        if (!in_array($v['categoryid'], $filter)) {
                            unset($categories[$k]);
                        }
                    }
                }
            }

            foreach ($all_categories as $k => $v) {

                if (($filter && !in_array($v['categoryid'], $filter))) {
                    continue;
                }

                if (empty($v['parentid'])) {
                    continue;
                }

                if (
                        isset($all_categories[$v['parentid']]['childs'])
                        && !is_array($all_categories[$v['parentid']]['childs'])
                ) {
                    $all_categories[$v['parentid']]['childs'] = array(
                        $k => &$all_categories[$k],
                    );
                } else {

                    $all_categories[$v['parentid']]['childs'][$k] = &$all_categories[$k];
                }


                if (isset($categories[$v['parentid']])) {
                    $_has_sublevels = true;
                    $categories[$v['parentid']]['childs'] = $all_categories[$v['parentid']]['childs'];
                }
            }
        }

        return $categories;
    }

}
/**
 * Installation: skip fingerprint generating
 */
if (
        strstr($php_url['url'], 'install-fcommerce.php')
        && strnatcmp($config['version'], '4.2') >= 0
        && $_POST['params']['install_type'] == 1
        && $_POST['current'] == 3
) {
    $_POST['current'] = 4;
}

/**
 * Admin side
 */
if (
        (func_fb_shop_constant('AREA_TYPE') == 'A' || strstr($php_url['url'], DIR_ADMIN . '/configuration.php'))
        && !empty($_GET['option'])
        && $_GET['option'] == 'fCommerce_Go'
) {
//{{{
    define('IS_FCOMMERCE_GO_CONFIGURATION_PAGE', true);

    if (!empty($_POST)) {
        /*
          Header text save
         */
        func_array2insert('languages', array(
            'code' => $shop_language,
            'name' => 'txt_fb_shop_header_text',
            'value' => addslashes($_POST['gpg_key']['fb_shop_header_text']),
            'topic' => 'Text'), true
        );

        func_array2insert('languages', array(
            'code' => $shop_language,
            'name' => 'txt_fb_shop_header_text_liked',
            'value' => addslashes($_POST['gpg_key']['fb_shop_header_text_liked']),
            'topic' => 'Text'), true
        );

        unset($_POST['gpg_key']);
        x_load('backoffice');
        func_clear_language_vars_cache($shop_language, REGENERATE_CACHE);

        /*
          Module congiguration save
         */
        db_query("UPDATE $sql_tbl[config] SET value = '" . addslashes(serialize($fb_shop_config)) . "' WHERE name = 'fb_shop_admin_configuration'");

        func_header_location('configuration.php?option=fCommerce_Go');
    }

    $fb_shop_config = unserialize(stripslashes(func_query_first_cell("SELECT value FROM $sql_tbl[config] WHERE name = 'fb_shop_admin_configuration'")));

    if (empty($fb_shop_config)) {
        /*
          First run initialize
         */
        $fb_shop_config = array(
            'bestsellers' => ($active_modules['Bestsellers'] ? 'Y' : ''),
            'featured' => 'Y',
            'cat_icons' => 'Y',
            'cat_tmbn_width' => 90,
            'cat_tmbn_height' => 90,
            'prod_tmbn_width' => 120,
            'prod_tmbn_height' => 120,
            'prod_image_width' => 200,
            'prod_image_height' => 200,
            'header_text' => '',
            'header_text_liked' => '',
            'per_page' => 6,
            'show_cat_descr' => 'Y',
        );

        $smarty->assign('fb_config_is_empty', true);
    }

    /*
      Categories collect
     */
    x_load('category');
    $_has_sublevels = false;
    $fb_categories = func_fb_shop_prepare_categories();

    $smarty->assign('fb_categories', $fb_categories);

    // Define if we need to show the expand/collapse links
    $smarty->assign('has_sublevels', $_has_sublevels);

    /**
     * Adding content to the configuration page
     */
    $smarty->assign('xcart_dir', $xcart_dir);
    $smarty->assign('protocol', ($HTTPS ? 'https' : 'http'));
    $smarty->assign('fb_shop_config', $fb_shop_config);

    function func_fb_shop_admin_configuration($tpl_source, &$smarty)
    {//{{{
        if ($smarty->template_resource == 'admin/main/configuration.tpl') {
            $tpl_source = str_replace('{assign var="first_row" value=1}', '{assign var="first_row" value=1} {include file="modules/fCommerce_Go/admin/configuration.tpl"}', $tpl_source);
        }
        return $tpl_source;
    }//}}}

    $smarty->registerFilter('pre', 'func_fb_shop_admin_configuration');
}//}}}
/**
 * Orders search postprocessing
 */ elseif ((func_fb_shop_constant('AREA_TYPE') == 'A' || func_fb_shop_constant('AREA_TYPE') == 'P') && (strstr($_SERVER['PHP_SELF'], 'orders.php') || strstr($_SERVER['PHP_SELF'], 'order.php')) && !in_array($mode, array('export', 'export_found', 'export_all', 'export_continue', 'xpdf_invoice'))) {
 //{{{

    function func_fb_tpl_pre_shop_process_orders($tpl_source, &$smarty)
    {
        if ($smarty->template_resource == 'main/orders.tpl') {
            $tpl_source = str_replace('<option value="gc_applied"', '<option value="fb_added"{if $features.fb_added} selected="selected"{/if}>' . func_get_langvar_by_name('lbl_fb_orders_with_facebook_products', false, false, true) . '</option> <option value="gc_applied"', $tpl_source);
        }

        if ($smarty->template_resource == 'main/orders_list.tpl') {
            $tpl_source = str_replace('#{$orders[oid].orderid}', '#{$orders[oid].orderid}{if $orders[oid].has_fb_products}<img src="{$current_location}/fb_icon.gif" alt="F" title="' . func_get_langvar_by_name('lbl_fb_has_products_added_in_facebook', false, false, true) . '" style="vertical-align: top; margin-left: 5px;" />{/if}', $tpl_source);
        }

        return $tpl_source;
    }

    $smarty->registerFilter('pre', 'func_fb_tpl_pre_shop_process_orders');
}//}}}
/**
 * Customer side processing
 */ elseif (func_fb_shop_constant('AREA_TYPE') != 'A' && (defined('FB_TAB_START') || !empty($_GET['_c']) || (strstr($_SERVER['HTTP_USER_AGENT'], 'facebookexternalhit') && !$active_modules['Socialize']))) {//{{{

    /**
     * Errors handler
     */
    if (defined('FB_TAB_START')) {
        $fb_debug_info = array();


        if (!function_exists('func_fb_errors_handle')) {

            function func_fb_error_shutdown() {

                global $shop_configuration, $fb_debug_info;
                global $debug_mode, $fb_debug, $fb_skip_notice;

                if (defined('DEVELOPMENT_MODE') || $debug_mode == 3 || $fb_debug) {

                    $error = error_get_last();

                    $error_types_2skip = $fb_skip_notice ? array(E_NOTICE, E_USER_NOTICE, E_DEPRECATED, E_USER_DEPRECATED) : array();

                    if (!empty($error) && isset($error['type']) && !in_array($error['type'], $error_types_2skip)) {

                        $fb_debug_info['error_data'][] = '<b>Fatal error</b>: ' . $error['message'] . ' in <b>' . $error['file'] . '</b> on line <b>' . $error['line'] . '</b><br />';

                        $shop_configuration['debug'] = $fb_debug_info;

                        $fb_output = serialize($shop_configuration);

                        /*
                        * Comment on problem like ERR_CONTENT_DECODING_FAILED ( Content Encoding Error )
                        * Error: Something went wrong. Web-store server is not responding
                        */
                        if (extension_loaded('zlib') && strlen($fb_output) > 51200) {
                            header('Content-Encoding: gzip');
                            $fb_output = gzencode($fb_output);
                        }

                        echo $fb_output;
                        exit();
                    }
                }
            }

            function func_fb_errors_handle($errno, $errstr, $errfile, $errline) {

                global $fb_debug_info;

                error_reporting(E_ALL ^ E_NOTICE);
                ini_set('display_errors', 0);
                ini_set('display_startup_errors', 0);

                $errortypes = array(
                    E_ERROR => 'Error',
                    E_WARNING => 'Warning',
                    E_PARSE => 'Parsing Error',
                    E_NOTICE => 'Notice',
                    E_CORE_ERROR => 'Error',
                    E_CORE_WARNING => 'Warning',
                    E_COMPILE_ERROR => 'Error',
                    E_COMPILE_WARNING => 'Warning',
                    E_USER_ERROR => 'Error',
                    E_USER_WARNING => 'Warning',
                    E_USER_NOTICE => 'Notice',
                );

                $errortype = isset($errortypes[$errno]) ? $errortypes[$errno] : 'Unknown Error';

                if ($errno != E_NOTICE) {
                    $fb_debug_info['error_data'][] = '<b>' . $errortype . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b><br />';
                }

                return true;
            }

        }

        set_error_handler('func_fb_errors_handle');
    }

    /**
     * Currency format
     */
    if (!$config['General']['currency_format']) {
        $config['General']['currency_format'] = '$x';
    }

    if (!$config['General']['alter_currency_format']) {
        $config['General']['alter_currency_format'] = '$x';
    }


    /**
     * Customer side session capture
     */
    $smarty->assign('fb_sess', base64_encode($XCART_SESSION_NAME . '=' . $XCARTSESSID));

    if ($_GET['_c'] && $fb_sess = base64_decode($_GET['_c'])) {

        $php_url['query_string'] = str_replace('_c=' . $_GET['_c'], $fb_sess, $php_url['query_string']);

        $_fb_query_str = (!empty($php_url['query_string']) ? '?' . $php_url['query_string'] : '');

        header('Location: ' . $PHP_SELF . $_fb_query_str);
        exit();
    }

    /**
     * Like button action
     */
    if (strstr($_SERVER['HTTP_USER_AGENT'], 'facebookexternalhit') && !$active_modules['Socialize']) {

        function func_fb_add_og_meta_tags($tpl, &$smarty) {

            global $config, $current_location, $user_account;

            $_main = $smarty->getTemplateVars('main');

            if ($_main == 'product') {

                $smarty_product_info = $smarty->getTemplateVars('product');

                $product_info = func_fb_shop_select_product($smarty_product_info['productid'], @$user_account['membershipid']);
                $default_charset = $smarty->getTemplateVars('default_charset');

                $default_charset = empty($default_charset) ? 'iso-8859-1' : $default_charset;

                $_temp_meta = ('
    <meta property="og:title" content="' . htmlspecialchars($product_info['product'], ENT_QUOTES, $default_charset) . '" />
    <meta property="og:description" content="' . substr(htmlspecialchars(strip_tags($product_info['descr']), ENT_QUOTES, $default_charset), 0, 500) . '" />
    <meta property="og:url" content="' . $product_info['full_url'] . '" />
    <meta property="og:image" content="' . ($product_info['default_image'] ? $product_info['fb_like_image_url'] : $product_info['image_url']) . '" />
    <meta property="og:site_name" content="' . (($_lbl_site_title = func_get_langvar_by_name("lbl_site_title", "", false, true)) ? $_lbl_site_title : $config['Company']['company_name']) . '" />
    ');

                $tpl = preg_replace('/<\/title>/', '</title>' . $_temp_meta, $tpl);
                $tpl = preg_replace('/<head/', '<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#"', $tpl);
            }

            return $tpl;
        }

        $smarty->register_outputfilter('func_fb_add_og_meta_tags');
    }
}//}}}

?>
