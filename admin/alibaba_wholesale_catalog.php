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
 * Alibaba Wholesale Catalog page
 *
 * @category   X-Cart
 * @package    Modules
 * @subpackage Admin interface
 * @author     Michael Bugrov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v7 (xcart_4_7_7), 2017-01-24 09:29:34, alibaba_wholesale_catalog.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require __DIR__.'/auth.php';
require $xcart_dir . '/include/security.php';

if (empty($active_modules['Alibaba_Wholesale'])) {
    func_403();
}

require $xcart_dir . '/include/safe_mode.php';

switch ($action) {
    case XCAlibabaWholesaleDefs::TYPE_REDIRECT:
        // get product info
        $product = func_alibaba_wholesale_getProduct();

        if (!empty($product['detail_url'])) {
            func_header_location($product['detail_url']);
        }
        break;
    case XCAlibabaWholesaleDefs::TYPE_IMPORT:
        // check module configuration required for import
        if (empty($config['Alibaba_Wholesale']['alibaba_wholesale_cat2import'])) {

            $top_message = array(
                'type'    => 'E',
                'content' => func_get_langvar_by_name('txt_aw_msg_module_not_configured'),
            );

            func_header_location('configuration.php?option=Alibaba_Wholesale#tr_alibaba_wholesale_cat2import');
        }
        // get product info
        $product = func_alibaba_wholesale_getProduct();

        if (!empty($product['detail_url'])) {
            func_alibaba_wholesale_import_product($product);
        }
        break;
}

// Assign the main condition
$smarty->assign('main', 'alibaba_wholesale_catalog');

$location[] = array(func_get_langvar_by_name('lbl_aw_catalog'), 'alibaba_wholesale_catalog.php');

// Assign the current location line
$smarty->assign('location', $location);

if (is_readable($xcart_dir . '/modules/gold_display.php')) {
    include $xcart_dir . '/modules/gold_display.php';
}

func_display('admin/home.tpl', $smarty);

?>
