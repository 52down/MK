<?php
/* vim: set ts=4 sw=4 sts=4 et: */
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| X-Cart Software license agreement                                           |
| Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>         |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
| PLEASE READ THE FULL TEXT OF SOFTWARE LICENSE AGREEMENT IN THE "COPYRIGHT"  |
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
 * Banner system
 *
 * @category X-Cart
 * @package X-Cart
 * @subpackage Modules
 * @author Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version cf9e608d41c40f761c6416f642a1d0094a6af214, v9 (xcart_4_7_7), 2017-01-24 09:29:34, banner_system.php, aim
 * @link http://www.x-cart.com/
 * @see ____file_see____
 */ 

require __DIR__.'/auth.php';

require $xcart_dir . '/include/security.php';

x_load('category');
if ($config['Banner_System']['bs_display_cat_selector_in_list'] == 'Y') {
    $all_categories = func_get_categories_tree(0, false, $shop_language, @$user_account['membershipid']);
    func_banner_system_get_banner(XC_BS::GET_CATS);
} else {
    func_banner_system_get_banner(XC_BS::SKIP_CATS);
}

include $xcart_dir . '/modules/Banner_System/banner_system_modify.php'; 

$smarty->assign('main', 'banner_system');

$location[] = array(func_get_langvar_by_name('lbl_banner_system'), 'banner_system.php'); 

if ($type == 'T') {
    $page_title = func_get_langvar_by_name('lbl_bs_top_banners');
} elseif ($type == 'B') {
    $page_title = func_get_langvar_by_name('lbl_bs_bottom_banners');
} elseif ($type == 'R') {
    $page_title = func_get_langvar_by_name('lbl_bs_right_column_banners');
} elseif ($type == 'L') {
    $page_title = func_get_langvar_by_name('lbl_bs_left_column_banners');
}

# Assign the current location line
if (!empty($page_title)) {
    $location[] = array($page_title, '');
    $smarty->assign('page_title', $page_title);
}

$smarty->assign('location', $location);
$smarty->assign('type', $type);
$smarty->assign('allcategories', $all_categories);

@include $xcart_dir . '/modules/gold_display.php';
func_display('admin/home.tpl', $smarty);

?>
