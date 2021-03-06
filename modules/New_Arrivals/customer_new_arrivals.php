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
|                                                                             |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

#
# 7b07e1e50ab43887097733b1f1ab6d88c17417c3, v10 (xcart_4_7_7), 2017-01-24 09:23:57, customer_new_arrivals.php, aim
#

if ( !defined("XCART_SESSION_START") ) { header("Location: ../"); die("Access denied"); }

if (
    (!isset($is_new_arrivals_page) || !$is_new_arrivals_page)
    && strpos($PHP_SELF, 'cart.php') === FALSE
) {
    x_load('cart');
    settype($cat, 'int');

    $new_arrivals = func_get_new_arrivals($cat, $user_account['membershipid']);

    $smarty->assign('new_arrivals', $new_arrivals);

    if (!empty($active_modules['Customer_Reviews']) && $config['Customer_Reviews']['customer_voting'] == 'Y') {
        $smarty->assign('stars', func_get_vote_stars());

        if (!empty($new_arrivals)) {
            foreach ($new_arrivals as $k => $v) {
                if ($v['rating_data']) {
                    $smarty->assign('rating_data_exists', true);
                    break;
                }
            }
        }
    }

    if (
        !empty($new_arrivals)
        && empty($products)
        && (
            !func_is_cart_empty($cart)
            || !isset($func_is_cart_empty)
        )
    ) {
        // fake for loading js/check_quantity.js file
        $smarty->assign('products', array(1));
    }
}

?>
