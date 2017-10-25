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
 * Special offers page interface
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Customer interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v34 (xcart_4_7_7), 2017-01-24 09:29:34, offers.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

define('OFFERS_DONT_CHECK', 1);

require __DIR__.'/auth.php';

if (empty($active_modules['Special_Offers'])) {

    func_header_location('home.php');

}

include $xcart_dir . '/include/common.php';

$location[] = array(func_get_langvar_by_name('lbl_special_offers'), 'offers.php');

include $xcart_dir . '/modules/Special_Offers/customer_offers.php';

$smarty->assign('main', 'customer_offers');

// Assign the current location line
$smarty->assign('location', $location);

if (
    !empty($action)
    && $action == 'popup'
) {

    $template_name = 'modules/Special_Offers/customer/offers.tpl';

    $smarty->assign('template_name',     $template_name);
    $smarty->assign('action',             $action);

    func_display('help/popup_info.tpl', $smarty);

} else {

    func_display('customer/home.tpl',$smarty);

}

?>