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
 * Antibot image generator
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    a650792bc005e1bce8e8522b6f1a5660f4bb88bc, v30 (xcart_4_7_8), 2017-06-05 20:08:24, antibot_image.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!defined('XCART_START')) { header("Location: ../../"); die("Access denied"); }

x_session_register('antibot_validation_val', array());

if (defined('XC_NGINX_OPTIMIZATION')) {
    if (!empty($antibot_validation_val[$section]['code'])) {
        XCImageVerificationNginxCache::addCookie($antibot_validation_val[$section], $section);
    } elseif(isset($antibot_validation_val[$section])) {
        XCImageVerificationNginxCache::deleteCookie($section);
    }
}

// Func_antibot_str_generator is defined here!
include_once $xcart_dir
    . '/modules/Image_Verification/'
    . $config['Image_Verification']['spambot_arrest_str_generator']
    . '.php';

if (
    !function_exists('func_antibot_str_generator')
    || !func_check_antibot_section($section)
) {
    exit;
}

if (
    (
        isset($regenerate)
        && $regenerate == 'Y'
    )
    || !isset($antibot_validation_val[$section])
    || $antibot_validation_val[$section]['used'] == 'Y'
) {

    $antibot_validation_val[$section]['code'] = func_antibot_str_generator(max(1, intval($config['Image_Verification']['spambot_arrest_image_length'])));

    $antibot_validation_val[$section]['used'] = "N";

}

$generation_str = $antibot_validation_val[$section]['code'];

include_once $xcart_dir
    . '/modules/Image_Verification/img_generators/'
    . $config['Image_Verification']['spambot_arrest_img_generator']
    . '/'
    . $config['Image_Verification']['spambot_arrest_img_generator']
    . '.php';

?>
