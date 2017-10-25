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
 * Modules configuration interface (adjustments)
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ildar Amankulov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    141c878b03b2b0cdd5d2b31c952f4e1031962148, v1 (xcart_4_7_8), 2017-05-18 15:44:49, admin_config.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

// default controller
$controller_g = !empty($controller_g) ? $controller_g : 'SettingsFe';

if (
    !in_array(
        $controller_g
        , array (
            'FeedsSubmitFe',
            'FeedsResultsFe',
        )
    )
) {
    // configuration tabs
    $configuration_tabs = array (
        'Settings' => array (
            'title' => func_get_langvar_by_name('lbl_settings'),
            'link'  => 'configuration.php?option=Facebook_Ecommerce&amp;' . 'controller_g' . '=' . 'SettingsFe',
            'style' => '',
            'current' => $controller_g == 'SettingsFe' ? 'Y' : 'N',
        ),
        'Feeds' => array (
            'title' => func_get_langvar_by_name('lbl_facebook_ecomm_feeds'),
            'link'  => 'configuration.php?option=Facebook_Ecommerce&amp;' . 'controller_g' . '=' . 'FeedsFe',
            'style' => '',
            'current' => $controller_g == 'FeedsFe' ? 'Y' : 'N',
        ),
    );

    $smarty->assign('configuration_tabs', $configuration_tabs);
}

\XC\Module\Backend\RequestProcessor::processRequest('Facebook_Ecommerce');
