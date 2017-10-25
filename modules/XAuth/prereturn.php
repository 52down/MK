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
 * Pre-return script
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Customer interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v11 (xcart_4_7_7), 2017-01-24 09:29:34, prereturn.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

global $remember_data;

$url = NULL;
if ($xauth_last_url_previous) {
    $url = $xauth_last_url_previous;
    $_regex = '/\/(?:login|secure_login)\.php.*$/Ss';
    if (preg_match($_regex, $url)) {
        x_session_register('remember_data');
        if (
            !empty($remember_data['URL'])
            && !empty($is_standalone_login_page)
        ) {
            $url = $remember_data['URL'];
        }
        $url = preg_replace($_regex, '/home.php', $url);
    }

    $area_catalogs = array(
        'A' => $xcart_catalogs['admin'],
        'P' => $xcart_catalogs['provider'],
        'B' => $xcart_catalogs['partner'],
        'C' => $xcart_catalogs['customer']
    );

    // Check URL area
    $area = 'C';
    if (preg_match('/^' . preg_quote($xcart_catalogs['admin'], '/') . '/Ss', $url)) {
        $area = 'A';

    } elseif (preg_match('/^' . preg_quote($xcart_catalogs['provider'], '/') . '/Ss', $url)) {
        $area = 'P';

    } elseif (preg_match('/^' . preg_quote($xcart_catalogs['partner'], '/') . '/Ss', $url)) {
        $area = 'B';
    }

    if (x_get_area_type() != $area) {

        $url = str_replace($area_catalogs[$area], $area_catalogs[x_get_area_type()], $url);
    }
}

if (empty($url)) {

    x_session_register('remember_data');
    if (
        !empty($remember_data['URL'])
        && !empty($is_standalone_login_page)
    ) {
        $url = $remember_data['URL'];
    }

    $url = ($HTTPS ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . urldecode($_SERVER['REQUEST_URI']);
    $url = preg_replace('/xauth_return_[\w\d_]+\.php/Ss', 'home.php', $url);
}
