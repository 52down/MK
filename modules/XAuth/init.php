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
 * Initialization
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v16 (xcart_4_7_7), 2017-01-24 09:29:34, init.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

if (defined('QUICK_START')) {
    // skip module in case of quickstart or XP use iframe option
    return;
}

if (!func_xauth_is_configured()) {

    $smarty->assign('xauth_not_configured', 'Y');
    // Current service is not configured
    return;
}

// Identifiers list on Register / User modify page
if (
    x_check_controller_condition(NULL, array('register', 'user_modify'))
    || x_check_controller_condition('C', 'cart', 'checkout')
) {
    x_tpl_add_regexp_patch(
        'modules/XAuth/register.tpl',
        '/(<form [^>]*name="registerform"[^>]*>.+<label [^>]*for="email"[^>]*>.+<\/tr>)/USs',
        '\1%%<tr></tr>'
    );
}

if (
    'C' != x_get_area_type()
    && x_check_controller_condition(NULL, array('register', 'user_modify'))
) {
    x_tpl_add_regexp_patch(
        'modules/XAuth/linked_accounts_admin.tpl',
        '/(<form [^>]*name="registerform"[^>]*>.+)(<tr>.+<\/tr>)/USs',
        '\1%%\2<tr></tr>'
    );
}
x_tpl_add_listener('modules/XAuth/register.tpl', 'before', 'func_xauth_prepare_register');
x_tpl_add_listener('modules/One_Page_Checkout/profile/account_info.tpl', 'before', 'func_xauth_prepare_register');

// Link/Button to Fill popup
if (x_check_controller_condition('C', 'cart', 'checkout')) {

    func_xauth_prepare_checkout_link();

}

if (
    x_check_controller_condition('C', 'register')
    || (x_check_controller_condition('C', 'cart', 'checkout') && 'Fast_Lane_Checkout' == $config['General']['checkout_module'])
) {

    func_xauth_prepare_register_link();
}

// Save last active URL
x_session_register('xauth_last_url', FALSE);

if (!is_array($xauth_last_url)) {

    $xauth_last_url = array();
}

$forbidPatterns = array(
    'antibot_image\.php',
);

if (
    !empty($_SERVER['REQUEST_METHOD'])
    && 'GET' == $_SERVER['REQUEST_METHOD']
    && (!isset($open_in_layer) || 'Y' != $open_in_layer)
    && !defined('QUICK_START')
) {
    $url = ($HTTPS ? 'https://' . $xcart_https_host : 'http://' . $xcart_http_host)
        . $_SERVER['REQUEST_URI'];

    $found = FALSE;
    foreach ($forbidPatterns as $pattern) {
        if (preg_match('/' . $pattern . '/Ss', $url)) {
            $found = TRUE;
            break;
        }
    }

    if (!$found && preg_match('/(?:\.php|\.html)(?:$|\?)/Ss', $url)) {
        $xauth_last_url[x_get_area_type()] = $url;
    }
}

if (isset($xauth_last_url[x_get_area_type()])) {

    $xauth_last_url_previous = $xauth_last_url[x_get_area_type()];
}

// Check removed identifiers
mt_srand();
if (10 == mt_rand(1, 10)) {
    $auth_id_remove = func_query_column('SELECT x.auth_id FROM ' . $sql_tbl['xauth_user_ids'] . ' as x LEFT JOIN ' . $sql_tbl['customers'] . ' as c ON c.id = x.id WHERE c.id IS NULL');
    if ($auth_id_remove) {
        db_query('DELETE FROM ' . $sql_tbl['xauth_user_ids'] . ' WHERE auth_id IN (\'' . implode('\',\'', $auth_id_remove) . '\')');
    }
}

// Popup template assign
$xauth_popup_tpl = 'modules/XAuth/register.' . $config['XAuth']['xauth_service'] . '.tpl';
$smarty->assign('xauth_popup_tpl', $xauth_popup_tpl);

$smarty->assign('xauth_http_protocol', $HTTPS ? 'https' : 'http');

$_path = $xcart_dir . '/modules/XAuth/services/' . $config['XAuth']['xauth_service'] . '/init.php';
if (file_exists($_path)) {
    require_once $_path;
}

func_add_event_listener('user.register.aftersave', 'func_xauth_link_identifier');
func_add_event_listener('user.register.filluserinfo', 'func_xauth_unload_saved_xcauth_data');
