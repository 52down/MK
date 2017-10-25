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
 * Cart totals calculation step
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    e336eafabe416ef67275b1af16eca3f3bba17dd1, v48 (xcart_4_7_8), 2017-04-26 11:13:21, cart_calculate_totals.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header('Location: ../../'); die('Access denied'); }

if (!func_is_cart_empty($cart)) {

    if ($checkout_module == 'One_Page_Checkout') {
        $paymentid = func_cart_get_paymentid($cart, 'One_Page_Checkout');
        $cart = func_cart_set_paymentid($cart, $paymentid);

        if (isset($cart['shippingid'])) {
            $shippingid = $cart['shippingid'];
        }
    }
    // Make md5 of the totals
    $totals_checksum_fields = array(
        'subtotal',
        'total_cost',
        'shipping_cost',
        'payment_surcharge',
        'giftwrap_cost',
        'coupon_discount',
        'discount',
        'tax_cost',
    );

    $totals_checksum_init = func_generate_checksum($cart, $totals_checksum_fields);

    // Check if the products array in the cart accords to the store

    if (
        !empty($cart['products'])
        && is_array($products)
        && count($products) != count($cart['products'])
    ) {
        foreach ($products as $k => $v) {

            $prodids[] = $v['cartid'];

        }

        if (is_array($prodids)) {

            foreach ($cart['products'] as $k => $v) {

                if (in_array($v['cartid'], $prodids)) {

                    $cart_prods[$k] = $v;

                }
            }

            $cart['products'] = $cart_prods;

        } else {

            $cart = '';

        }

        func_header_location('cart.php?' . $QUERY_STRING);
    }

    // Use default address for not logged customer
    if (
        empty($userinfo)
        && $config['General']['apply_default_country'] == 'Y'
    ) {
        $userinfo['b_country']     = $userinfo['s_country']     = $config['General']['default_country'];
        $userinfo['b_state']       = $userinfo['s_state']       = $config['General']['default_state'];
        $userinfo['b_zipcode']     = $userinfo['s_zipcode']     = $config['General']['default_zipcode'];
        $userinfo['b_city']        = $userinfo['s_city']        = $config['General']['default_city'];
        $userinfo['b_countryname'] = $userinfo['s_countryname'] = func_get_country($userinfo['s_country']);
        $userinfo['b_statename']   = $userinfo['s_statename']   = func_get_state($userinfo['s_state'], $userinfo['s_country']);
    }

    // Init free_shipping_used key bt:0066433    
    foreach ($products as $pKey => $product) {
        if (!empty($active_modules["Special_Offers"])) {
            $products[$pKey]["free_shipping_used"] = false;
        }
    }
    
    // Check if shipping cost needs to be calculated
    $need_shipping = func_cart_is_need_shipping($cart, $products, $userinfo);

    // Get the allowed shipping methods list
    if ($need_shipping) {

        $_current_carrier = $current_carrier;

        if (
            !empty($active_modules['Bongo_International'])
            && func_bongo_isCheckoutAvailable()
        ) {
            if (
                $userinfo['s_country'] != XCShipFrom::getCountry()
                && $config['Bongo_International']['bongo_free_domestic_shipping'] != 'Y'
            ) {
                $_old_userinfo = $userinfo;
                $userinfo = array_merge($userinfo, func_bongo_getBongoLocation());
            }
        }

        $shipping = func_get_shipping_methods_list($cart, $products, $userinfo);

        if (empty($shipping) && !defined('ALL_CARRIERS')) {

            if (
                $_current_carrier == 'UPS'
                && $empty_other_carriers != 'Y'
            ) {

                $current_carrier         = '';
                $intershipper_recalc     = 'Y';
                $shipping                 = func_get_shipping_methods_list($cart, $products, $userinfo);

            } elseif (
                !empty($active_modules['UPS_OnLine_Tools'])
                && $_current_carrier == ''
                && $empty_ups_carrier != 'Y'
            ) {

                $current_carrier         = 'UPS';
                $intershipper_recalc     = 'Y';
                $shipping                 = func_get_shipping_methods_list($cart, $products, $userinfo);

            }

        }

        $original_shippingid = $current_shippingid = !empty($cart['shippingid'])
            ? $cart['shippingid']
            : 0;

        // If current shipping is empty set it to default (first in shipping array)
        $shipping_matched = false;

        if (!empty($shipping) && is_array($shipping)) {
            foreach ($shipping as $shipping_method) {
                if ($current_shippingid == $shipping_method['shippingid']) {
                    $shipping_matched = true;
                }
            }
        }

        if (!$shipping_matched && !empty($shipping)) {
            $cart = func_cart_set_shippingid($cart, $shipping[0]['shippingid']);
        }

        $current_shippingid = !empty($cart['shippingid'])
            ? $cart['shippingid']
            : 0;

        if (
            !empty($active_modules['Bongo_International'])
            && func_bongo_isCheckoutAvailable()
            && func_bongo_isAvailableForCustomer($userinfo)
        ) {
            if (isset($_old_userinfo)) {
                $userinfo = $_old_userinfo;
            }

            if (!empty($shipping)) {
                $shippingid = func_bongo_getCheapestShipping($shipping);
                $cart = func_cart_set_shippingid($cart, $shippingid);
            }
        }

        if (!empty($shipping)) {
            foreach ($shipping as $shipping_method) {
                if ($current_shippingid == $shipping_method['shippingid']) {
                    $cart['shipping_warning'] = !empty($shipping_method['warning'])
                        ? $shipping_method['warning']
                        : '';
                }
            }
        }

        if (
            !empty($active_modules['Pitney_Bowes'])
            && (
                !empty($mode)
                && $mode == 'checkout'
            )
            && $original_shippingid != $current_shippingid
            && func_pitney_bowes_is_selected_on_checkout($userinfo)
        ) {
            func_header_location($xcart_catalogs['customer'] . '/cart.php?mode=checkout');
        }

        $cart['delivery'] = func_query_first_cell("SELECT shipping FROM $sql_tbl[shipping] WHERE shippingid='$current_shippingid'");

        $smarty->assign('current_carrier', $current_carrier);

    } else { // if ($need_shipping)

        $shipping = '';
        $cart['delivery'] = '';
        $cart = func_cart_set_shippingid($cart, 0);

    } // if ($need_shipping)

    if (
        !empty($active_modules['Special_Offers'])
        && !empty($action)
        && $action == 'apply_free_offers'
    ) {
        include $xcart_dir . '/modules/Special_Offers/apply_free_offers.php';
    }

    if (
        !empty($active_modules['Bongo_International'])
        && !func_bongo_isCheckoutAvailable()
        && isset($cart['bongo_landedCost'])
    ) {
        unset($cart['bongo_landedCost']);
    }

    // Calculate all prices

    $cart = func_array_merge(
        $cart,
        func_calculate(
            $cart,
            $products,
            $logged_userid,
            $current_area,
            !empty($paymentid) ? intval($paymentid) : 0
        )
    );

    if (
        !empty($active_modules['Special_Offers'])
        && !empty($cart['free_offers'])
    ) {
        $_bonus = func_get_customer_bonus($logged_userid);
        $smarty->assign('bonus', $_bonus);
        // must be after Func_calculate to calculate $Cart['Blocked_points']
        $cart['remained_points'] = $_bonus['points'] - $cart['blocked_points'];
    }

    if (func_is_cart_empty($cart)) {

        $cart = '';

        $top_message = array(
            'content' => func_get_langvar_by_name('err_product_in_cart_expired_msg'),
            'type' => 'E'
        );

        func_header_location($xcart_catalogs['customer'] . '/cart.php');

    } else {

        $products = func_products_in_cart($cart, @$userinfo['membershipid']);

        // Correct displayed tax_value (changed by Special_Offers) bt:#93897
        if (
            !empty($active_modules['Special_Offers'])
            && func_is_display_including_tax($cart['taxes'])
        ) {
            $products = func_merge_cart_products_taxes($products, $cart['products']);
        }

    }

    if (!empty($active_modules['Klarna_Payments'])) {
        $cart['monthly_cost'] = func_klarna_get_monthly_cost($cart['total_cost'], KLARNA_CHECKOUT_PAGE);
    }

    // For special offers that give free shipping to specified membership.

    if (
        !empty($products)
        && !empty($need_shipping)
        && !empty($cart['have_offers'])
    ) {
        $need_shipping = false;

        foreach ($products as $product) {
            if (
                (
                    $product['free_shipping'] == 'Y'
                    || $product['free_shipping_used']
                )
                && $config['Shipping']['do_not_require_shipping'] == 'Y'
            ) {
                continue;
            }

            $need_shipping = true;
            break;
        }

        if (empty($need_shipping)) {

            $cart['delivery']     = '';
            $cart = func_cart_set_shippingid($cart, 0);

            $shipping             = '';

        }

    }

    // Check if the Gift wrapping section is needed

    if (
        !empty($products)
        && $config['General']['enable_gift_wrapping'] == 'Y'
    ) {
        $whole_cart_esd = func_esd_in_cart($cart, true);

        if (!$whole_cart_esd) {

            $smarty->assign('display_giftwrap_section', true);

        } else {

            $cart['need_giftwrap'] = 'N';

        }

    }

    if (!empty($cart['split_query'])) {

        $cart['split_query']['paid_amount'] = func_calculate_paid_amount($cart);

    }

    if (
        isset($cart['split_query']['paid_amount'])
        && $cart['split_query']['paid_amount'] > 0
    ) {

        $smarty->assign('transaction_query', $cart['split_query']['transaction_query']);
        $smarty->assign('paid_amount', $cart['split_query']['paid_amount']);

    }

    $smarty->assign('shipping',      $shipping);
    $smarty->assign('need_shipping', $need_shipping);
    $smarty->assign('cart',          $cart);

    $totals_checksum = func_generate_checksum($cart, $totals_checksum_fields);

    if (!empty($active_modules['Klarna_Payments'])) {
        func_klarna_calculate_pclasses_monthly_cost($cart, $smarty, (isset($selected_pclass) ? $selected_pclass : false));
    }

}
