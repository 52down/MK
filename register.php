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
 * Registration (profile update) page interface
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Customer interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v44 (xcart_4_7_7), 2017-01-24 09:29:34, register.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

define('USE_TRUSTED_POST_VARIABLES', 1);
define('USE_TRUSTED_SCRIPT_VARS', 1);
$trusted_post_variables = array('passwd1', 'passwd2');

require __DIR__.'/auth.php';

include $xcart_dir . '/include/common.php';

x_session_register('cart');
x_session_register('current_carrier');

$newbie = 'Y';

if (
    !empty($action)
    && $action == 'cart'
) {
    $smarty->assign('action',    $action);
    $smarty->assign('paymentid', $paymentid);
}

/**
 * Where to forward <form action
 */
$smarty->assign(
    'register_script_name',
    (
        $config['Security']['use_https_login'] == 'Y'
            ? $xcart_catalogs_secure['customer'] . "/"
            : ''
    )
    . 'register.php');

if (
    empty($mode)
    && !empty($login)
) {
    $mode = 'update';
}

$display_antibot = ($mode !== 'update');

require $xcart_dir . '/include/register.php';

if (
    $REQUEST_METHOD == 'POST'
    && $action == 'cart'
    && empty($errors)
) {
    func_header_location("cart.php?mode=checkout&paymentid=$paymentid");
}

$smarty->assign('newbie',   $newbie);
$smarty->assign('mode',     $mode);

if (
    $action == 'cart'
    && $config['General']['checkout_module'] == 'Fast_Lane_Checkout'
) {
    require $xcart_dir . '/modules/Fast_Lane_Checkout/checkout.php';
}

// Assign the current location line
$smarty->assign('location',         $location);
$smarty->assign('display_captcha',  true);

func_display('customer/home.tpl', $smarty);

?>
