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
 * Module functions
 *
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @category   X-Cart
 * @package    Modules
 * @subpackage Products Map
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v41 (xcart_4_7_7), 2017-01-24 09:29:34, func.php, aim
 * @since      4.4.0
 */
if (!defined('XCART_START')) { header('Location: ../../'); die('Access denied');}

x_load('product');

class XCProductsMap {

    const NUM_VALUE='0';
    const NUM_VALUES_REGEX='0-9';
    const GREY='grey';
    const NORMAL='normal';

    public static function addMissedSymbol($symb) { // {{{
        global $sql_tbl, $config, $shop_language;
        if (
            empty($symb)
            || $config['Products_Map']['pmap_grey_missed_symbols'] != 'Y'
        ) {
            return false;
        }

        $symb = self::NUM_VALUES_REGEX === $symb ? self::NUM_VALUE : addslashes($symb);
        return db_query("INSERT INTO $sql_tbl[pmap_missed_symbols] (symbol, code, update_time) VALUES ('$symb', '$shop_language', '" . XC_TIME . "') ON DUPLICATE KEY UPDATE update_time=" . XC_TIME);
    } // }}}

    public static function removeMissedSymbol($symb) { // {{{
        global $sql_tbl, $config, $shop_language;
        if (
            empty($symb)
            || $config['Products_Map']['pmap_grey_missed_symbols'] != 'Y'
        ) {
            return false;
        }

        $symb = self::NUM_VALUES_REGEX === $symb ? self::NUM_VALUE : addslashes($symb);
        return db_query("DELETE FROM $sql_tbl[pmap_missed_symbols] WHERE symbol='$symb' AND code='$shop_language'");
    } // }}}

    public static function removeExpiredMissedSymbols() { // {{{
        global $sql_tbl, $config;
        if ($config['Products_Map']['pmap_grey_missed_symbols'] != 'Y') {
            return false;
        }

        if (!mt_rand(0, 200)) {
            return db_query("DELETE FROM $sql_tbl[pmap_missed_symbols] WHERE update_time < '" . (XC_TIME - SECONDS_PER_DAY) . "'");
        }
    } // }}}

    public static function getMissedSymbols($lng) { // {{{
        global $sql_tbl, $config, $shop_language;

        if ($config['Products_Map']['pmap_grey_missed_symbols'] != 'Y') {
            return array();
        }

        $lng = $lng ?: $shop_language;

        return func_query_column("SELECT symbol FROM $sql_tbl[pmap_missed_symbols] WHERE code='$lng'");
    } // }}}
}

/**
 * Generate necessary data for pmap
 *
 * @return array
 */
function pmap_generate_map()
{
    $map['symbols']    = pmap_get_symbols();
    $map['current']    = pamp_get_current_symbol($map['symbols']);
    $map['products']   = pmap_get_products($map['current'], $map['symbols']);
    $map['navigation'] = 'products_map.php?symb';

    return $map;
}

/**
 * Return all avalable symbols
 *
 * @return array
 */
function pmap_get_symbols($lng = '')
{
    global $sql_tbl, $default_charset;
    static $res = array();

    if (!empty($res[$lng])) {
        return $res[$lng];
    }

    $_lng = strtolower($lng);
    $lng_tbl = !empty($lng) && !empty($sql_tbl['products_lng_' . $_lng]) ? $sql_tbl['products_lng_' . $_lng] : "$sql_tbl[products_lng_current]"; 
    // create array of all available symbols from products
    $all_symbols = func_query_column("SELECT DISTINCT LEFT(product,1) AS letter FROM " . $lng_tbl);

    // uppercase
    if (function_exists('mb_strtoupper')) {
        mb_internal_encoding($default_charset);
        $all_symbols = array_map('mb_strtoupper', $all_symbols);
    } else {
        $all_symbols = array_map('strtoupper', $all_symbols);
    }

    XCProductsMap::removeExpiredMissedSymbols();
    $missed_symbols = XCProductsMap::getMissedSymbols($lng);
    $all = array();
    foreach($all_symbols as $symb) {
        if (is_numeric($symb)) {
            $has_numeric = true;
        } else {
            $all[$symb] = XCProductsMap::NORMAL;
        }

        if (in_array($symb, $missed_symbols, true)) {
            $all[$symb] = XCProductsMap::GREY;
        }
    }

    if (!empty($has_numeric)) {
        if (in_array(XCProductsMap::NUM_VALUE, $missed_symbols, true)) {
            $all[XCProductsMap::NUM_VALUES_REGEX] = XCProductsMap::GREY;
        } else {
            $all[XCProductsMap::NUM_VALUES_REGEX] = XCProductsMap::NORMAL;
        }
    }

    $res[$lng] = $all;
    return $all;
}

/**
 * Get current symbol
 *
 * @param  array $avail_symbols
 * @return string
 */
function pamp_get_current_symbol($avail_symbols)
{
    if (
        isset($_GET['symb']) 
        && !empty($_GET['symb'])
    ) {
        $symb = stripslashes($_GET['symb']);

        if ($symb == XCProductsMap::NUM_VALUES_REGEX) {

            return XCProductsMap::NUM_VALUES_REGEX;

        }    

        if (isset($avail_symbols[$symb])) {

            return $symb;

        }

	}

    return key($avail_symbols);
}

/**
 * Get product for passed symbol
 *
 * @param  string $symb
 * @return array
 */
function pmap_get_products($symb, $l_avail_symbols)
{
    global $sql_tbl, $user_account, $smarty, $config, $xcart_dir, $total_items, $objects_per_page;
    global $active_modules, $smarty;

    assert('!empty($symb) && strlen($symb) <=3 /*param Pmap_get_products*/');

    if (empty($symb))
        return false;
    
    if ($symb == XCProductsMap::NUM_VALUES_REGEX) {
        $query['query'] = " AND $sql_tbl[products_lng_current].product REGEXP '^[{$symb}]'";
    } else {
        $query['query'] = " AND $sql_tbl[products_lng_current].product LIKE '" . addslashes($symb) . "%'";
    }

    $membershipid = $user_account['membershipid'];

    $orderby = "$sql_tbl[products_lng_current].product";

    $query['skip_tables'] = XCSearchProducts::getSkipTablesByTemplate(XCSearchProducts::SHOW_PRODUCTNAME);

    $products_short = func_search_products($query, $membershipid, $orderby, '', TRUE);

    if (is_array($products_short)) {

        // prepare navigation
        $total_items = count($products_short);
        $objects_per_page = $config['Appearance']['products_per_page'];
        $page = isset($_GET['page']) ? intval($_GET['page']) : 0;

        include $xcart_dir . '/include/navigation.php';

        // assign navigation data to smarty
        $smarty->assign('navigation_script', 'products_map.php?symb=' . $symb);
        $smarty->assign('first_item', $first_page + 1);
        $smarty->assign('last_item', min($first_page + $objects_per_page, $total_items));

        // limit products array
        $products_short = array_slice($products_short, $first_page, $objects_per_page);

        $_limit_width = $config['Appearance']['thumbnail_width'];
        $_limit_height = $config['Appearance']['thumbnail_height'];
        foreach ($products_short as $id => $product) {

            $product = func_select_product($product['productid'], $membershipid);

            if (!isset($product['page_url'])) {
                $product['page_url'] = 'product.php?productid=' . $product['productid'];
            }

            // Force use T type for products map
            if ($product['image_type'] == 'P') {
                $product['image_x'] = $product['images']['T']['x'];
                $product['image_y'] = $product['images']['T']['y'];
                $product['image_id'] = @$product['images']['T']['id'];
                $product['image_url'] =$product['images']['T']['url'];
                $product['image_type'] = 'T';
            } 
            $product['tmbn_url'] = $product['image_url'];

            $product = func_get_product_tmbn_dims($product, $_limit_width, $_limit_height);

            $products[] = $product;

            if (
                !empty($active_modules['Feature_Comparison'])
                && !empty($product['fclassid'])
            ) {
                $smarty->assign('products_has_fclasses', true);
            }

        }

        if ($l_avail_symbols[$symb] == XCProductsMap::GREY) {
            XCProductsMap::removeMissedSymbol($symb);
        }
        return $products;
    
    } else {
        XCProductsMap::addMissedSymbol($symb);
        return false;

    }

}

/**
 * Fill an array with values, specifying keys
 *
 * @link http://php.net/manual/en/function.array-fill-keys.php
 * @param keys array <p>
 * Array of values that will be used as keys. Illegal values
 * for key will be converted to string.
 * </p>
 * @param value mixed <p>
 * Value to use for filling
 * </p>
 * @return array the filled array
 * </p>
 */
function pmap_array_fill_keys($array, $values) 
{

    if (function_exists('array_fill_keys')) {

        $arraydisplay = array_fill_keys($array, $values);

    } else {

        if(is_array($array)) {

            foreach($array as $key => $value) {

                $arraydisplay[$array[$key]] = $values;

            }

        }

    }

    return $arraydisplay;
}

/**
 * Generate page filename for html catalog
 *
 * @param  string $name
 * @return string
 */
function pmap_filename($name)
{

    if (empty($name)) {

        return __FUNCTION__;

    } else {

        return $name;

    }

}

/**
 * Modify url to point to HTML pages of the catalog
 *
 * @param  array  $data current $additional_hc_data spec
 * @param  string $src  page content
 * @return string
 */
function pmap_process_page($data, $src)
{
    global $current_lng;
    // replacement for general page
    $pattern = '/(<a[^<>]+href[ ]*=[ ]*["\']?)([^"\']*' . $data['page_url'] . ')((#[^"\'>]+)?["\'>])/iUS';

    // define first avaliable letter
    $symbol = array_search(
        XCProductsMap::NORMAL,
        pmap_get_symbols($current_lng), 
        true
    );

    // creates an url of first page of the first avaliable symbol
    // and replace a php url by it
    $GLOBALS['pmap_page_name'] = sprintf($data['name_func_params'][0], $symbol, 1);

    $src = preg_replace_callback($pattern, 'pmap_process_page_callback_general', $src);

    unset($GLOBALS['pmap_page_name']);

    // replacment for urls on the pmap page only
    if (isset($GLOBALS['pmap_generation_flag'])) {

        $GLOBALS['pmap_page_name'] = $data['name_func_params'][0];

        $pattern = '/(<a[^<>]+href[ ]*=[ ]*["\']?)([^"\']*' . $data['page_url'] . ')\?(symb=[^"\'>]+)((#[^"\'>]+)?["\'>])/iUS';

        $src = preg_replace_callback($pattern, 'pmap_process_page_callback_pmap', $src);

        unset($GLOBALS['pmap_page_name']);

    }

    return $src;
}

/**
 * Callback function for pmap_process_page
 *
 * @param  array $found generated by preg_replace_callback
 * @return strnig
 */
function pmap_process_page_callback_general($found)
{
    if (!func_is_current_shop($found[2])) {

        return $found[1] . $found[2] . '?' . $found[3];

    }

    global $hc_state;

    $url = $found[1] . $hc_state['catalog']['webpath'] . $GLOBALS['pmap_page_name'] . $found[3];

    return $url;
}

/**
 * Callback function for pmap_process_page
 *
 * @param  array $found generated by preg_replace_callback
 * @return string
 */
function pmap_process_page_callback_pmap($found)
{
    global $hc_state, $current_lng;;

    if (!func_is_current_shop($found[2])) {

        return $found[1] . $found[2] . '?' . $found[3];

    }

    if (preg_match('/page=([0-9]{1})/S', $found[3], $m)) {

        $page = $m[1];

    } else {

        $page = 1;

    }

    if (preg_match('/symb=([A-z]{1})/S', $found[3], $m)) {

        $symbol = $m[1];

    } else {
        // define first avaliable letter
        $symbol = array_search(
            XCProductsMap::NORMAL, 
            pmap_get_symbols($current_lng), 
            true
        );
    }

    $url = sprintf($GLOBALS['pmap_page_name'], $symbol, $page);

    $url = $found[1] . $hc_state['catalog']['webpath'] . $url . $found[4];
    
    return $url;
}

?>
