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
 * ShippingEasy export
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Alexey Zakharov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0559ca8bda5978a4247cd80d0c9c0635f06a7290, v1 (xcart_4_7_8), 2017-06-01 10:08:00, shippingeasy_export.php, Ildar
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require './auth.php';
require $xcart_dir . '/include/security.php';


if (empty($active_modules['ShippingEasy'])) {
    func_403(106);
}

x_load('order');

if (!empty($orderids)) {
    $orderids = array_keys($orderids);
    $sent = false;
    $need_to_export = false;
    foreach ($orderids as $oid) {
        if (!func_shippingeasy_is_already_exported($oid)) {
            $need_to_export = true;
            if (func_shippingeasy_create_order($oid, true)) {
                $sent = true;
            }
        }
    }

    if (!$need_to_export) {
        $top_message['content'] = func_get_langvar_by_name('txt_shippingeasy_orders_already_exported');
        $top_message['type']    = 'I';

        func_header_location($HTTP_REFERER);
    }

    if ($sent) {
        $top_message['content'] = func_get_langvar_by_name('txt_shippingeasy_orders_export');
        $top_message['type']    = 'I';
    } else {
        $top_message['content'] = func_get_langvar_by_name('err_shippingeasy_orders_export');
        $top_message['type']    = 'E';
    }
}

if ($orderid) {
    if (func_shippingeasy_is_already_exported($orderid)) {
        $top_message['content'] = func_get_langvar_by_name('txt_shippingeasy_order_already_exported');
        $top_message['type']    = 'I';

        func_header_location($HTTP_REFERER);
    }

    if (func_shippingeasy_create_order($orderid, true)) {
        $top_message['content'] = func_get_langvar_by_name('txt_shippingeasy_order_export');
        $top_message['type']    = 'I';
    } else {
        $top_message['content'] = func_get_langvar_by_name('err_shippingeasy_order_export');
        $top_message['type']    = 'E';
    }
}

func_header_location($HTTP_REFERER);

