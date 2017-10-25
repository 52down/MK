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
 * Checkout by Pilibaba
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v6 (xcart_4_7_7), 2017-01-23 20:12:10, checkout.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 *
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../../"); die("Access denied"); }

set_time_limit(86400);

if (!defined('ALL_CARRIERS')) {
    define('ALL_CARRIERS', 1);
}

if (defined('CHECKOUT_STARTED'))
{//{{{
// Start Pilibaba

    if ($func_is_cart_empty)
        return;

    func_pilibaba_checkout_debug('*** SUBMIT ORDER REQUEST SENDING');
    $post_Order = func_pilibaba_Order($userinfo);
    func_pilibaba_checkout_debug("*** REQUEST fields", $post_Order);

    //Save session data
    x_session_register('pilibaba_checkout_saved_ips');
    $pilibaba_checkout_saved_ips = array('ip' => $CLIENT_IP, 'proxy_ip' => $PROXY_IP);

    $form_created = func_pilibaba_submit_encoded_cart($post_Order);
    if (!$form_created) {
        $top_message['content'] = func_get_langvar_by_name('txt_err_place_order_');
        func_header_location($xcart_catalogs['customer'] . '/cart.php');
    }
    exit;//}}}
} elseif (defined('IS_STANDALONE'))
{//{{{ Handle callbacks from Pilibaba

    if (empty($active_modules['Pilibaba'])) {
        func_header_location($xcart_catalogs['customer'] . '/cart.php');
    }

    func_pilibaba_log_raw_post_get_data();

    if ($mode == 'cancel' || $mode == 'pageUrl') {
        // Customer canceled the checkout by pilibaba
        func_pilibaba_handle_cancel(@$skey);
    } elseif ($mode == 'return') {
        // Customer returned to store from Pilibaba
        func_pilibaba_handle_return(@$skey);
    } elseif ($mode == 'callback'){

        if (!func_pilibaba_is_validated_callback($_GET)) {
            func_pilibaba_checkout_debug("\t+ Signature test for callback is not passed");
            func_pilibaba_header_exit(403);
        }

        define('PILIBABA_CHECKOUT_CALLBACK', 1);

        func_pilibaba_checkout_debug('*** CALLBACK RECEIVED');
        func_pilibaba_checkout_debug("\t+ Message received: order/payment is successfully paid");
        include_once $xcart_dir . '/modules/Pilibaba/order_notifications.php';
    }
}//}}}

exit;

?>
