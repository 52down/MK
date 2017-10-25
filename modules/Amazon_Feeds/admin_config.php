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
 * @author     Michael Bugrov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v4 (xcart_4_7_7), 2017-01-24 09:29:34, admin_config.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

// default controller
${XCAmazonFeedsDefs::CONTROLLER} = !empty(${XCAmazonFeedsDefs::CONTROLLER})
    ? ${XCAmazonFeedsDefs::CONTROLLER}
    : XCAmazonFeedsDefs::CONTROLLER_SETTINGS;

if (
    !in_array(
        ${XCAmazonFeedsDefs::CONTROLLER}
        , array (
            XCAmazonFeedsDefs::CONTROLLER_FEEDS_SUBMIT,
            XCAmazonFeedsDefs::CONTROLLER_FEEDS_RESULTS
        )
    )
) {

    // configuration tabs
    $configuration_tabs = array (
        XCAmazonFeedsDefs::CONTROLLER_SETTINGS => array (
            'title' => func_get_langvar_by_name('lbl_settings'),
            'link'  => 'configuration.php?option=Amazon_Feeds&amp;'
                            . XCAmazonFeedsDefs::CONTROLLER
                            . '='
                            . XCAmazonFeedsDefs::CONTROLLER_SETTINGS,
            'style' => '',
            'current' => ${XCAmazonFeedsDefs::CONTROLLER}
                            == XCAmazonFeedsDefs::CONTROLLER_SETTINGS ? 'Y' : 'N',
        ),
        XCAmazonFeedsDefs::CONTROLLER_FEEDS => array (
            'title' => func_get_langvar_by_name('lbl_amazon_feeds_feeds_submission'),
            'link'  => 'configuration.php?option=Amazon_Feeds&amp;'
                            . XCAmazonFeedsDefs::CONTROLLER
                            . '='
                            . XCAmazonFeedsDefs::CONTROLLER_FEEDS,
            'style' => '',
            'current' => ${XCAmazonFeedsDefs::CONTROLLER}
                            == XCAmazonFeedsDefs::CONTROLLER_FEEDS ? 'Y' : 'N',
        ),
    );

    $configuration_buttons = array(
        'additional' => array(
            array (
                'title' => func_get_langvar_by_name('lbl_amazon_feeds_get_available_marketplaces'),
                'style' => 'afds-get-marketplaces',
            ),
        ),
        'controller' => 'modules/Amazon_Feeds/controller.js',
    );
    $smarty->assign('configuration_buttons', $configuration_buttons);

    $smarty->assign('configuration_tabs', $configuration_tabs);
}

XCAmazonFeedsAdminRequestProcessor::processRequest();
