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
 * Functions for Detailed product images module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v35 (xcart_4_7_7), 2017-01-24 09:29:34, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

function func_ic_is_valid_dpicon()
{
    global $active_modules;

    return !empty($active_modules['Detailed_Product_Images']);
}

function func_ic_get_size_dpicon($width, $height)
{
    global $config;

    return array(
        'width' => max(intval($config['Detailed_Product_Images']['det_image_max_width_icon']), 30),
        'height' => max(intval($config['Detailed_Product_Images']['det_image_max_height_icon']), 30)
    );
}

function func_ic_is_crop_dpicon()
{
    return false;
}

function func_ic_is_valid_dpthmbn()
{
    global $active_modules, $config;

    return !empty($active_modules['Detailed_Product_Images']) && $config['Detailed_Product_Images']['det_image_icons_box'] == 'Y';
}

function func_ic_get_size_dpthmbn($width, $height)
{
    global $config;

    return array(
        'width' => min(intval($config['Appearance']['image_width']), $width),
        'height' => min(intval($config['Appearance']['image_height']), $height)
    );
}

function func_ic_is_crop_dpthmbn()
{
    return false;
}

/*
* Check which widget should be used to display detailed product images (false, colorbox, cloudzoom). Called from templates.
*/
function func_tpl_get_det_images_widget()
{
    global $smarty;
    $tpl_vars = $smarty->getTemplateVars();
    
    $result = false;

    if (
        $tpl_vars['main'] == 'product'
        && !empty($tpl_vars['active_modules']['Detailed_Product_Images'])
        && !empty($tpl_vars['images'])
        && empty($tpl_vars['printable'])
        && $tpl_vars['config']['Detailed_Product_Images']['det_image_popup'] == 'Y' 
    ) {

        if (
            $tpl_vars['config']['Detailed_Product_Images']['det_image_box_plugin'] == 'C' 
            && $tpl_vars['config']['setup_images']['D']['location'] != 'DB'
        ) {
            $result = 'colorbox';
        } elseif ($tpl_vars['config']['Detailed_Product_Images']['det_image_box_plugin'] == 'Z') {
            $result = 'cloudzoom';
        } else {
            $result = 'default';
        }

    } 

    return $result;
}

?>
