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
 * Shipping tools dialog section
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    3b989966be1c29db68912ac95152501ee0a55508, v36 (xcart_4_7_8), 2017-04-04 16:52:35, shipping_tools.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../"); die("Access denied"); }

$is_realtime = (func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[shipping] WHERE code != ''") > 0);
/**
 * Define data for the navigation within section
 */
$dialog_tools_data = array();

if (!empty($active_modules['Pitney_Bowes']) && $carrier == 'PB') {
    $dialog_tools_data['left'][] = array('link' => 'configuration.php?option=Pitney_Bowes', 'title' => func_get_langvar_by_name('lbl_X_module_options', array('service' => 'Pitney Bowes')));
}

$dialog_tools_data['left'][] = array('link' => 'shipping.php', 'title' => func_get_langvar_by_name('lbl_shipping_methods'));

if ($is_realtime && $config['Shipping']['realtime_shipping'] == 'Y' and ( empty($active_modules['UPS_OnLine_Tools']) or $config['Shipping']['use_intershipper'] == 'Y')) {
    if ($config['Shipping']['use_intershipper'] != 'Y') {
        $dialog_tools_data['left'][] = array('link' => 'shipping_options.php', 'title' => func_get_langvar_by_name('lbl_shipping_options'));
    } else {
        $dialog_tools_data['left'][] = array('link' => 'shipping_options.php', 'title' => func_get_langvar_by_name('lbl_X_shipping_options', array('service' => 'InterShipper')));
    }
}

$dialog_tools_data['right'][] = array('link' => "configuration.php?option=Shipping", 'title' => func_get_langvar_by_name('option_title_Shipping'));

if ($is_realtime) {
    if ($config['Shipping']['realtime_shipping'] == 'Y' and ! empty($active_modules['UPS_OnLine_Tools']) and $config['Shipping']['use_intershipper'] != 'Y') {
        $dialog_tools_data['right'][] = array('link' => 'ups.php', 'title' => func_get_langvar_by_name('lbl_ups_online_tools_configure'));
    }

    $dialog_tools_data['right'][] = array('link' => 'test_realtime_shipping.php', 'title' => func_get_langvar_by_name('lbl_test_realtime_calculation'), 'target' => 'testrt');
}

?>
