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
 * Webmaster mode interface
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v53 (xcart_4_7_7), 2017-01-24 09:29:34, editor_mode.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require __DIR__.'/auth.php';
require $xcart_dir.'/include/security.php';

if (
    (isset($_POST['editor_mode']) && $_POST['editor_mode'])
    || (isset($_GET['editor_mode']) && $_GET['editor_mode'])
    || (isset($_COOKIE['editor_mode']) && $_COOKIE['editor_mode'] == 'editor'))
{
    func_403(3);
}

if (isset($editor_mode))
    unset($editor_mode);

x_session_register('editor_mode');

if (empty($login) && $editor_mode!='editor') {
    func_403(2);
}

$location[] = array(func_get_langvar_by_name('lbl_webmaster_mode'), '');

if ($REQUEST_METHOD == 'POST') {

    if ($mode == 'start_mode') {
        $editor_mode = 'editor';
    } elseif ($mode == 'quit_mode') {
        $editor_mode = '';
        if (empty($smarty->compile_id_based_on_filters)) {
            register_shutdown_function('func_remove_xcart_caches');
        }
    }

    func_header_location('editor_mode.php');

}

$smarty->assign('editor_mode_enabled', ($editor_mode?'editor_mode':''));
$smarty->assign('site_edit', $http_location);
$smarty->assign('main', 'editor_mode');

// Assign the current location line
$smarty->assign('location', $location);

// Assign the section navigation data
$dialog_tools_data = array('help' => true);
$smarty->assign('dialog_tools_data', $dialog_tools_data);

if (is_readable($xcart_dir.'/modules/gold_display.php')) {
    include $xcart_dir.'/modules/gold_display.php';
}
func_display('admin/home.tpl',$smarty);
?>
