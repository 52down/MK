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
 * Service tools
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    87ace7fac4d3c8e48c5d9155177725199e8d51e5, v31 (xcart_4_7_8), 2017-05-19 17:24:14, check_tpl_syntax.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!empty($_GET['standalone'])) {
    require __DIR__.'/auth.php';
    require "$xcart_dir/include/security.php";
}

$ignore_tpl_files = array (
	"common_files/debug.tpl",
	"common_files/debug_templates.tpl",
	"common_files/modules/XAuth/auth.rpx.horizontal.tpl",
	"ideal_responsive/modules/XAuth/auth.rpx.responsive.tpl",
);

if (!empty($_GET['standalone'])) { XCTplSyntaxChecker::run_n_redirect($ignore_tpl_files); exit(); }


if ( !defined('XCART_START') ) { header('Location: ../'); die('Access denied'); }
/**
 * Called from admin/tools.php
 */
class XCTplSyntaxChecker {

public static function run_n_redirect($ignore_tpl_files = array(), $files_per_step = 100) {//{{{
    global $xcart_dir, $smarty, $active_modules, $smarty_skin_root_dir, $tpl_checker_first_run;

    require $xcart_dir . '/include/safe_mode.php';

    if (!defined('TESTER_SEPARATOR')) {
        // Do not remove templates_c for night tester
        x_session_register('tpl_checker_first_run', true);
        if (!empty($tpl_checker_first_run)) {
            x_load('backoffice');
            func_remove_xcart_caches(false, array('templates_c'));
            $tpl_checker_first_run = false;
        }
    }


    // for insert_gate function to avoid error like "{insert} no function or plugin found for 'gate'"
    x_load(
        'templater',
        'taxes' // For XCTaxesDefs static class. The call is like {if $config.Taxes.tax_operation_scheme eq XCTaxesDefs::TAX_SCHEME_GENERAL} nolint
    );
    $registered_plugins = $smarty->getRegisterPlugins();

    // To avoid problem (secure mode) modifier 'substr' is not allowed
    if (is_readable("$xcart_dir/modules/XMonitoring/config.php")) {
        @require_once "$xcart_dir/modules/XMonitoring/config.php";
    }

    // To avoid PHP error was found: Fatal error: Smarty error: [in skin/common_files/modules/Product_Options/product_variants.tpl line 135]: syntax error: unrecognized tag 'pos_get_html_field' (Smarty_Compiler.class.php, line 590) in /u/xcart/eshop_tools/build/output/20140505-120108/4.6.x/install/gold/xcart/include/lib/smarty/Smarty.class.php on line 1094
    $smarty->registerPlugin('function', 'pos_get_upc', 'trim');
    $smarty->registerPlugin('function', 'pos_get_html_field', 'trim');

    // 'Alibaba_Wholesale' module defines these modifier only for product_modify page
    $smarty->registerPlugin('function', 'aw_get_alibaba_wholesale_id', 'trim');

    // Cost_Pricing module defines these modifier only for product_modify page
    $smarty->registerPlugin('function', 'costp_get_price', 'trim');

    $smarty->setTemplateDir($xcart_dir . $smarty_skin_root_dir);
    /**
        **Never use syntax like
        {if $active_modules.Socialize}
            {func_soc_tpl_is_fb_plugins_enabled assign=_is_fb_plugins_enabled}
            ....
            {$order.orderid|func_soc_tpl_orderid} nolint
            ....
        in non-modules templates like skin/ideal_comfort/customer/home.tpl

        **The possible solution is
        {if $active_modules.Socialize}
          {getvar func=func_soc_tpl_is_fb_plugins_enabled var=_is_fb_plugins_enabled}
          ....
          ....

        {func_soc_tpl_is_fb_plugins_enabled assign=_is_fb_plugins_enabled}{$order.orderid|func_soc_tpl_orderid} can be used only module's templates like nolint
        skin/common_files/modules/Socialize/buttons_row.tpl

        **to avoid fatal errors like this when the module is disabled
         Fatal error: Uncaught --> Smarty Compiler: Syntax error in template "/home/aim/public_html/xcart_4_6_x/skin/ideal_comfort/customer/home.tpl" on line 25 "{func_soc_tpl_is_fb_plugins_enabled assign=_is_fb_plugins_enabled}" unknown tag "func_soc_tpl_is_fb_plugins_enabled"
     */

    if (empty($active_modules['XOrder_Statuses'])) {
        $smarty->registerPlugin('function', 'order_status_desc', 'trim');
        $smarty->registerPlugin('function', 'tpl_order_statuses', 'trim');
        $smarty->registerPlugin('function', 'xostat_embedd_css_content', 'trim');
    }

    if (empty($active_modules['XAffiliate'])) {
        $smarty->registerPlugin('modifier', 'mrb_prepare', 'trim');
    }

    if (empty($active_modules['XAuth'])) {
        $smarty->registerPlugin('function', 'xauth_rpx_get_language', 'trim');
    }

    if (empty($active_modules['Socialize'])) {
        $smarty->registerPlugin('function', 'func_soc_tpl_get_canonical_url', 'trim');
        $smarty->registerPlugin('function', 'func_soc_tpl_get_og_image', 'trim');
        $smarty->registerPlugin('function', 'func_soc_tpl_is_fb_plugins_enabled', 'trim');
        $smarty->registerPlugin('modifier', 'func_get_facebook_lang_code', 'trim');
    }

    if (
        empty($active_modules['Pitney_Bowes'])
        && is_readable("$xcart_dir/modules/Pitney_Bowes/classes.php")
    ) {
        // To avoid problem (secure mode) static class not defined
        @require_once "$xcart_dir/modules/Pitney_Bowes/classes.php";
        // Register functions
        $smarty->registerPlugin('function', 'pb_transportation_part', 'trim');
        $smarty->registerPlugin('function', 'pb_importation_part', 'trim');
        $smarty->registerPlugin('function', 'pb_track_url', 'trim');
        // allow static class const access in smarty
        $smarty->changeSecurity(array('static_classes' => array('XCPitneyBowesDefs')));
    }

    if (empty($active_modules['Products_Map'])) {
        require_once "$xcart_dir/modules/Products_Map/func.php";
    }
    $smarty->changeSecurity(array('static_classes' => array('XCProductsMap')));

    if (empty($active_modules['Amazon_Feeds'])) {
        require_once "$xcart_dir/modules/Amazon_Feeds/classes.php";
        $smarty->changeSecurity(array('static_classes' => array('XCAmazonFeedsDefs')));
    }

    if (empty($registered_plugins['function']['get_add_to_facebook_feed'])) {//For Facebook_Ecommerce
        $smarty->registerPlugin('function', 'get_add_to_facebook_feed', 'trim');
    }

    $smarty->assign('skin_config','skin1.conf');

    $counts = self::compileAllTemplates('.tpl', false, 0, 10, $smarty, $ignore_tpl_files, $files_per_step);

    if (!empty($counts['compiled_err'])) {
        if (!defined('TESTER_SEPARATOR')) {
            echo '<br><br>' , func_get_langvar_by_name('msg_adm_err_in_tpl_syntax', null, false, true);
        } else {
            echo '<br><br>' , 'The test has been stopped because of errors.<br />Fix the errors or add the affected files to the $ignore_tpl_files variable in admin/check_tpl_syntax.php and run the test again.<br /><a href="check_tpl_syntax.php?standalone=1">Run the test again</a>';
        }
        if (!empty($files_per_step)) {
            exit();
        } else {
            return false;
        }
    } elseif (!defined('TESTER_SEPARATOR')) {
        func_remove_xcart_caches(false, array('templates_c'));
        echo '<br><br>Test is passed!';
    }

    return true;
}//}}}

protected static function status($var) {//{{{
    if ($var === 'skipped')
        return "<br /><font color=\"blue\">[SKIPPED]</font> ";

    if ($var === 'ok')
        return "<br /><font color=\"green\">[OK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]</font> ";

    if ($var === 'error')
        return "<br /><br /><font color=\"red\">[ERROR]</font> ";
}//}}}

/**
 * Compile all template files. This is the  copy from CompileAllTemplates function
 */
protected static function compileAllTemplates($extension, $force_compile, $time_limit, $max_errors, Smarty $smarty, $ignore_tpl_files = array(), $files_per_step = 0 ) {//{{{

	// switch off time limit
	if (function_exists('set_time_limit')) {
		@set_time_limit($time_limit);
	}
	$smarty->force_compile = $force_compile;
	$_count = 0;
	$_error_count = 0;
	// loop over array of template directories
	foreach ($smarty->getTemplateDir() as $_dir) {
		$_compileDirs = new RecursiveDirectoryIterator($_dir);
		$_compile = new RecursiveIteratorIterator($_compileDirs);
		foreach ($_compile as $_fileinfo) {
			$_file = $_fileinfo->getFilename();
			if (substr(basename($_fileinfo->getPathname()), 0, 1) == '.' || strpos($_file, '.svn') !== false) {
				continue;
			}
			if (!substr_compare($_file, $extension, - strlen($extension)) == 0) {
				continue;
			}


			if ($_fileinfo->getPath() == substr($_dir, 0, - 1)) {
				$_template_file = $_file;
			} else {
				$_template_file = substr($_fileinfo->getPath(), strlen($_dir)) . DS . $_file;
			}

			if (in_array($_template_file, $ignore_tpl_files)) {
				echo self::status('skipped'), $_template_file;
                continue;
			}

			$_start_time = microtime(true);
			try {
				$_tpl = $smarty->createTemplate($_template_file, null, null, null, false);
				if ($_tpl->mustCompile()) {
					$_tpl->compileTemplateSource();

                    echo  self::status('ok') , $_template_file;
                    echo ' compiled in  ', microtime(true) - $_start_time, ' seconds';
                    func_flush();

                    $_count ++;
				}
			}
			catch (Exception $e) {
                $_tpl->clearCompiledTemplate($_template_file);
				echo self::status('error'), htmlspecialchars($e->getMessage()), '<br />';
				$_error_count ++;
			}
			// free memory
			$smarty->template_objects = array();
			$_tpl->smarty->template_objects = array();
			$_tpl = null;

            if (!empty($files_per_step)) {
                if ($_count >= $files_per_step) {
                    if (!empty($_error_count)) {
                        // Fix or ignore the error before continue
                        return array('compiled_count' => $_count, 'compiled_err' => $_error_count);
                    } else {
                        func_header_location('check_tpl_syntax.php?standalone=1');
                    }
                }

            } else {
                if ($max_errors !== null && $_error_count == $max_errors) {
                    return array('compiled_count' => $_count, 'compiled_err' => $_error_count);
                }
            }
		}
	}

	return array('compiled_count' => $_count, 'compiled_err' => $_error_count);
}//}}}

}
