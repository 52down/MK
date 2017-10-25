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
 * Customer's address book interface
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Customer interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v27 (xcart_4_7_7), 2017-01-24 09:29:34, address_book.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require __DIR__.'/auth.php';

require $xcart_dir . '/include/remember_user.php';
require $xcart_dir . '/include/security.php';

include $xcart_dir . '/include/common.php';

x_load('user');

// Process deletion of the address in the storefront
if (
    $mode == 'delete'
    && !empty($id)
    && func_check_address_owner($logged_userid, $id)
) {
    $res = func_delete_address($id);

    if ($res) {
        $top_message = array(
            'type'    => 'I',
            'content' => func_get_langvar_by_name('txt_address_' . $mode . '_success')
        );
    }

    func_header_location('address_book.php');
}


$addresses = func_get_address_book($logged_userid);
$smarty->assign('addresses', $addresses);

$address_additional_fields = func_get_additional_fields('C', '', 'B');
if (!empty($address_additional_fields)) {
    $address_book_additional_fields = func_get_address_book_additional_fields($addresses, $address_additional_fields);
    $smarty->assign('address_book_additional_fields', $address_book_additional_fields);
}

$address_fields = func_get_default_fields('C', 'address_book', true, true);
$smarty->assign('default_fields', $address_fields);

$smarty->assign('main', 'address_book');

// Assign the current location line
$location[] = array(func_get_langvar_by_name('lbl_address_book'), '');
$smarty->assign('location', $location);

func_display('customer/home.tpl', $smarty);
?>
