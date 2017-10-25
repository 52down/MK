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
 * Configuration script
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v22 (xcart_4_7_7), 2017-01-24 09:29:34, config.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

if (defined('DO_NOT_START_SESSION')) {
    // XAuth did not work without sessions
    unset($active_modules['XAuth']);
    $smarty->assign('active_modules', $active_modules);
    return;
}

require_once $xcart_dir . XC_DS . 'include' . XC_DS . 'lib' . XC_DS . 'dynamic_tpl_patcher.php';

/**
 * This option enables/disables logging of results of requests to
 * Google/Facebook/Twitter to var/log/x-errors_xauth_debug* files. These files
 * may contain some sensitive data, so be sure to remove them when you no
 * longer need them. 
 * It is highly recommended to keep the option $xauth_debug disabled.
*/
$xauth_debug = FALSE;

// RPX is hardcoded
$config['XAuth']['xauth_service'] = 'rpx';

// Services list
$xauth_services = array(
    'rpx' => TRUE,
);

$addons['XAuth'] = TRUE;

if (
    $xauth_services
    && (!isset($xauth_services[$config['XAuth']['xauth_service']]) || !$xauth_services[$config['XAuth']['xauth_service']])
) {
    foreach ($xauth_services as $k => $v) {
        if ($v) {
            $config['XAuth']['xauth_service'] = $k;
            break;
        }
    }
}

if (
    $xauth_services
    && isset($xauth_services[$config['XAuth']['xauth_service']])
    && $xauth_services[$config['XAuth']['xauth_service']]
) {

    x_register_css('modules/XAuth/main.css');
    x_register_css('modules/XAuth/altskin.css');

    if (is_array($xauth_services[$config['XAuth']['xauth_service']])) {
        $providers = array();
        foreach ($xauth_services[$config['XAuth']['xauth_service']] as $v) {
            $providers[$v] = TRUE;
        }
        $smarty->assign('xauth_providers', $providers);
    }
    
    $smarty->assign('xauth_include_js', 'Y');
}

$sql_tbl['xauth_user_ids'] = XC_TBL_PREFIX . 'xauth_user_ids';

//Get application name from application domain
$config['XAuth']['xauth_rpx_app_name'] = '';

if (!empty($config['XAuth']['xauth_rpx_app_domain'])) {

    $rpx_domain = parse_url($config['XAuth']['xauth_rpx_app_domain']);

    if (
        isset($rpx_domain['host'])
        && !empty($rpx_domain['host'])
        && 0 < preg_match('/([a-zA-Z0-9-]*)?\.rpxnow\.com/s', $rpx_domain['host'], $match)
    ) {
        $config['XAuth']['xauth_rpx_app_name'] = $match[1];
    }
}

// Load module functions
if (!empty($include_func)) {
    require_once $_module_dir . XC_DS . 'func.php';
}

// Module initialization
if (!empty($include_init)) {
    include $_module_dir . XC_DS . 'init.php';
}

if ($config['XAuth']['xauth_ss_providers'] != 'N') {
    $smarty->assign('xauth_social_sharing_enabled_providers', explode(';', $config['XAuth']['xauth_ss_providers']));
}
