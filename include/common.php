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
 * Includes common scripts for specified area
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v27 (xcart_4_7_7), 2017-01-24 09:29:34, common.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header('Location: ../'); die('Access denied'); }

if (!isset($current_area)) {

    return;

}

switch ($current_area) {

    case 'C':

        x_load('category');

        // Build categories tree for the Flyout menus module

        if (
            empty($active_modules['Flyout_Menus'])
            || !func_fc_use_cache()
            || !func_fc_has_cache()
            || strpos($config['alt_skin'], 'artistictunes') !== false //Display Horizontal menu categories, when cache is used
        ) {

            if (
                !isset($cat)
                || $config['Appearance']['root_categories'] == 'Y'
            ) {

                $categories = func_get_categories_list(0, false);

            } else {

                $categories = func_get_categories_list($cat, false);
        
            }
        }

        if (!empty($active_modules['Flyout_Menus'])) {

            include $xcart_dir . '/modules/Flyout_Menus/fancy_categories.php';

        }

        // Get categories menu data
        if (!empty($categories)) {
            $smarty->assign('categories_menu_list', $categories);
        }

				// roostercreatives
				$categories_1 = func_get_categories_list(1, false);
				$categories_4 = func_get_categories_list(4, false);
				$categories_5 = func_get_categories_list(5, false);
				
				$smarty->assign('categories_1', $categories_1);
				$smarty->assign('half_1', ceil(count($categories_1)/2));
				$smarty->assign('categories_4', $categories_4);
				$smarty->assign('categories_5', $categories_5);
				
				$categories_2 = func_get_categories_list(2, false);
				$categories_3 = func_get_categories_list(3, false);
				foreach($categories_2 as $k=>$c_2){
					$categories_2[$k]['sub'] = func_get_categories_list($c_2['categoryid'], false);
				}
				foreach($categories_3 as $k=>$c_3){
					$categories_3[$k]['sub'] = func_get_categories_list($c_3['categoryid'], false);
				}
				
				$smarty->assign('categories_2', $categories_2);
				$smarty->assign('categories_3', $categories_3);
				// end
				
				
        if (!empty($active_modules['Manufacturers'])) {

            include $xcart_dir . '/modules/Manufacturers/customer_manufacturers.php';

        }

        if (!empty($active_modules['New_Arrivals'])) {

            include $xcart_dir . '/modules/New_Arrivals/customer_new_arrivals.php';

        }

        if (!empty($active_modules['Banner_System']) && func_banner_system_check_parameters()) {

            func_banner_system_get_banner();

        }

        if (!empty($active_modules['POS_System'])) {
            $smarty->assign('user_is_pos_operator', func_user_is_pos_operator($logged_userid));
        }

        break;

    case 'A':
        break;

    case 'P':
        break;

    case 'B':
        break;
}

?>
