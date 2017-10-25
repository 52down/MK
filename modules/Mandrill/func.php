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
 * Functions of the 'Mandrill' module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ildar Amankulov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    1a6cd45805022f5fdf03361c73b08471854193f4, v1 (xcart_4_7_8), 2017-04-18 15:01:06, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */
if (!defined('XCART_START')) { header('Location: ../../'); die('Access denied'); }

function func_mandrill_init($is_configured = false) { // {{{
    global $smarty, $PHP_SELF, $config, $g_modules_configuration_post;

    $area = (defined('AREA_TYPE')) ? AREA_TYPE : '';
        // Overwrite some email notification options for pos session for customer area
    $options_map = array(
        'use_smtp' => 'Y',
        'smtp_server' => 'smtp.mandrillapp.com',
        'smtp_protocol' => '',//'tls' produce Connection failed. Error #2: stream_socket_client(): SSL operation failed with code 1. OpenSSL Error messages: error:1408F10B:SSL routines:SSL3_GET_RECORD:wrong version number [include/lib/phpmailer/class.smtp.php line 292] /Failed to enable crypto [include/lib/phpmailer/class.smtp.php line 292]
        'smtp_port' => '587',
        'smtp_mail_from' => $config['Mandrill']['mandrill_smtp_mail_from'],
        'smtp_user' => $config['Mandrill']['mandrill_smtp_username'],
        'smtp_password' => $config['Mandrill']['mandrill_apikey'],
        'smtp_auth_method' => '',
    );

    if (empty($is_configured)) {
        return false;
    }

    foreach ($options_map as $default_option => $module_option) {
        if (
            defined('ADMIN_CONFIGURATION_CONTROLLER')
            && !empty($_GET['option']) && $_GET['option'] == 'Email'
        ) {
            if (!empty($module_option)) {
                $g_modules_configuration_post['Email'][$default_option]['raw_note'] = "Actual <a href='configuration.php?option=Mandrill'>'$module_option'</a>";
            }
        } elseif (isset($config['Email'][$default_option])) {
            //Override default Email values for all pages besides configuration.php?option=Email
            $config['Email'][$default_option] = $module_option;
        }
    }
} //}}}
