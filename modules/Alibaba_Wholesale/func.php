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
 * Functions
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Michael Bugrov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v24 (xcart_4_7_7), 2017-01-23 20:12:10, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

abstract class XCAlibabaWholesaleDefs { //{{{
    const JSON = 'json';
    const XML = 'xml';

    const ROOT = 'root';

    const TYPE_REDIRECT = 'redirect';
    const TYPE_IMPORT = 'import';
} //}}}

/**
 * Initialize module
 */
function func_alibaba_wholesale_init()
{ //{{{
    global $PHP_SELF;

    $area = (defined('AREA_TYPE')) ? AREA_TYPE : '';
    if (in_array($area, array('A','P'))) {
        // For product modify page
        if (basename($PHP_SELF) == 'product_modify.php') {
            func_alibaba_wholesale_load_classes();
            XCAlibabaWholesaleTpl::registerSmartyFunctions();
        }
    }
} //}}}

/**
 * Load classes.php and include/lib/taobaoSDK/TopSdk.php
 *
 * @global string $xcart_dir - used to load classes.php
 * @global array $var_dirs - used in taobaoSDK initializer
 */
function func_alibaba_wholesale_load_classes()
{ //{{{
    global $xcart_dir, $var_dirs;
    // $var_dirs - used in taobaoSDK initializer

    require_once $xcart_dir . '/include/lib/taobaoSDK/TopSdk.php';
    require_once $xcart_dir . '/modules/Alibaba_Wholesale/classes.php';

    return true;
} //}}}

function func_alibaba_wholesale_get_app_config()
{ //{{{
    static $APP_CONFIG = null;

    if ($APP_CONFIG == null) {

        global $xcart_dir, $blowfish, $encryption_types, $config;

        if ($blowfish == null) {
            # (due to QUICK_START) [[[
            # Initialize encryption subsystem
            #
            require_once($xcart_dir . '/include/blowfish.php');
            #
            # Start Blowfish class (due to QUICK_START in Ajax)
            #
            $blowfish = new ctBlowfish();
            # (due to QUICK_START) ]]]
        }

        x_load('crypt');

        $APP_CONFIG = array(
            'appKey' => text_decrypt($config['alibaba_wholesale_AppKey']),
            'secretKey' => text_decrypt($config['alibaba_wholesale_SecretKey']),
        );
    }

    return $APP_CONFIG;
} //}}}

function func_alibaba_wholesale_get_cat_variants()
{ //{{{
    global $shop_language, $user_account;

    // Categories list
    $aw_categories = array(
        '0' => func_get_langvar_by_name('lbl_aw_not_specified')
    );

    // All categories list
    $categories = func_data_cache_get('get_categories_tree', array(0, false, $shop_language, $user_account['membershipid']));

    foreach ($categories as $id => $category) {
        $aw_categories[$id] = $category['category'];
    }

    return $aw_categories;
} //}}}

function func_alibaba_wholesale_sort_by_name($a, $b)
{ //{{{
    if (isset($a['level'])
            && isset($b['level'])
    ) {
        if ($a['level'] !== $b['level']) {
            if ($a['level'] < $b['level']) {
                return -1;
            }
            if ($a['level'] > $b['level']) {
                return 1;
            }
            return 0;
        } else {
            return strcmp($a['name'], $b['name']);
        }
    } else {
        return strcmp($a['name'], $b['name']);
    }
} //}}}

function func_alibaba_wholesale_search_parent($cid, $cpaths)
{ //{{{
    foreach ($cpaths as $k => $v) {
        if (
            ($index = array_search($cid, $v)) !== false
            && $index > 0
        ) {
            return $cpaths[$k][$index-1];
        }
    }
    return XCAlibabaWholesaleDefs::ROOT;
} //}}}

function func_alibaba_wholesale_cat_level($cid, $cpaths)
{ //{{{
    foreach ($cpaths as $v) {
        if (
            ($index = array_search($cid, $v)) !== false
        ) {
            return $index + 1;
        }
    }
    return 0;
} //}}}

function func_alibaba_wholesale_add_search_conditions($data, &$fields, &$inner_joins, &$left_joins)
{ //{{{
    global $sql_tbl;

    // Search conditions
    if (AREA_TYPE != 'C') {

        $fields[] = 'AW_IDS.alibaba_wholesale_id';

        if (!empty($data['alibaba_wholesale_flag'])) {

            $inner_joins['AW_IDS'] = array(
                'tblname' => 'product_alibaba_wholesale_ids',
                'on' => $sql_tbl['products'] . '.productid = AW_IDS.productid'
            );

        } else {

            $left_joins['AW_IDS'] = array(
                'tblname' => 'product_alibaba_wholesale_ids',
                'on' => $sql_tbl['products'] . '.productid = AW_IDS.productid'
            );
        }
    }
} //}}}

function func_alibaba_wholesale_import_product($product_info)
{ //{{{
    global $sql_tbl, $logged_userid, $all_languages, $active_modules, $config, $top_message;

    x_load('backoffice','category','image','product');

    $alibaba_wholesale_id = addslashes($product_info['id']);

    if (!empty($alibaba_wholesale_id)) {
        $productid = func_query_first_cell("SELECT productid FROM $sql_tbl[product_alibaba_wholesale_ids] AS p WHERE p.alibaba_wholesale_id = '$alibaba_wholesale_id'");
    }

    if (empty($productid)) {

        if (!empty($alibaba_wholesale_id)) { //{{{

            $provider = $logged_userid;

            $product = addslashes($product_info['name']);
            $productcode = func_generate_sku($provider);
            $descr = addslashes($product_info['name']);
            $fulldescr = addslashes($product_info['description']);
            $keywords = addslashes($product_info['keyword']);

            $min_amount = floatval($product_info['moq']);

            $weight = floatval($product_info['weight']);

            $avail = $config['Alibaba_Wholesale']['alibaba_wholesale_avail2import'];

            list($length, $width, $height) = explode('X', $product_info['package_size']);

            $length = floatval($length);
            $width = floatval($width);
            $height = floatval($height);

            db_query("INSERT INTO $sql_tbl[products] (productcode, provider, add_date, meta_description, meta_keywords, title_tag, avail, weight, length, width, height, min_amount) VALUES ('$productcode', '$provider', '" . XC_TIME . "', '', '', '', '$avail', '$weight', '$length', '$width', '$height', '$min_amount')");

            $productid = db_insert_id();

            db_query("INSERT INTO $sql_tbl[product_alibaba_wholesale_ids] (productid, alibaba_wholesale_id) VALUES ('$productid', '$alibaba_wholesale_id')");

            $price = floatval($product_info['min_price']);

            // Insert price and image
            db_query("INSERT INTO $sql_tbl[pricing] (productid, quantity, price) VALUES ('$productid', '1', '" . $price . "')");

            // Insert 0 sales_stats for the product
            XCProductSalesStats::insertNewRow($productid);

            // Fill all languages by default
            $int_descr_data = array(
                'productid' => $productid,
                'product' => $product,
                'descr' => $descr,
                'fulldescr' => $fulldescr,
                'keywords' => $keywords
            );

            $_languages = array_keys($all_languages);

            $int_descr_data = func_call_pre_post_event('products.lng.insert',
                array('productid' => $int_descr_data['productid'], 'codes' => $_languages),
                $int_descr_data
            ) ?: $int_descr_data;

            foreach ($_languages as $_code) {
                func_array2insert('products_lng_' . $_code, $int_descr_data, true);
            }

            $categoryid = $config['Alibaba_Wholesale']['alibaba_wholesale_cat2import'];

            // Prepare and update categories associated with product...
            $query_data_cat = array(
                'categoryid' => $categoryid,
                'productid' => $productid,
                'main' => 'Y'
            );

            if (!func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[products_categories] WHERE categoryid = '$categoryid' AND productid = '$productid' AND main = 'Y'")) {
                db_query("DELETE FROM $sql_tbl[products_categories] WHERE productid = '$productid' AND (main = 'Y' OR categoryid = '$categoryid')");
                func_array2insert('products_categories', $query_data_cat);
                XCProducts_CategoriesChange::repairIntegrity($query_data_cat['categoryid'], $query_data_cat['productid']);
            }

            func_alibaba_wholesale_load_classes();
            // Add product thumbnail
            if (!empty($product_info[XCWholesaleGoodsOpenResult::THUMB_URLS][0])) { //{{{

                $_image_data = array();

                $_image_data['file_path'] = $product_info[XCWholesaleGoodsOpenResult::THUMB_URLS][0];
                $_image_data['id'] = $productid;
                $_image_data['source'] = 'U';
                $_image_data['type'] = 'T';
                $_image_data['date'] = XC_TIME;

                $_image_data['is_copied'] = false;
                $_image_data['is_redirect'] = true;

                list(
                    $_image_data['file_size'],
                    $_image_data['image_x'],
                    $_image_data['image_y'],
                    $_image_data['image_type']) = func_get_image_size($_image_data['file_path']);

                $image_data = array('T' => $_image_data);

                $image_perms = func_check_image_storage_perms($image_data, 'T');

                if ($image_perms) {
                    func_save_image($image_data, 'T', $productid);
                }
            } //}}}

            // Add product image
            if (($has_images = !empty($product_info[XCWholesaleGoodsOpenResult::IMAGE_URLS][0]))) { //{{{

                $_image_data = array();

                $_image_data['file_path'] = $product_info[XCWholesaleGoodsOpenResult::IMAGE_URLS][0];
                $_image_data['id'] = $productid;
                $_image_data['source'] = 'U';
                $_image_data['type'] = 'P';
                $_image_data['date'] = XC_TIME;

                $_image_data['is_copied'] = false;
                $_image_data['is_redirect'] = true;

                list(
                    $_image_data['file_size'],
                    $_image_data['image_x'],
                    $_image_data['image_y'],
                    $_image_data['image_type']) = func_get_image_size($_image_data['file_path']);

                $image_data = array('P' => $_image_data);

                $image_perms = func_check_image_storage_perms($image_data, 'P');

                if ($image_perms) {
                    func_save_image($image_data, 'P', $productid);
                }
            } //}}}

            // Add detailed images
            if (!empty($active_modules['Detailed_Product_Images']) && $has_images) { //{{{

                foreach ($product_info[XCWholesaleGoodsOpenResult::IMAGE_URLS] as $image) { //{{{

                    $_image_data = array();

                    $_image_data['file_path'] = $image;
                    $_image_data['id'] = $productid;
                    $_image_data['source'] = 'U';
                    $_image_data['type'] = 'D';
                    $_image_data['date'] = XC_TIME;

                    $_image_data['is_copied'] = false;
                    $_image_data['is_redirect'] = true;

                    list(
                        $_image_data['file_size'],
                        $_image_data['image_x'],
                        $_image_data['image_y'],
                        $_image_data['image_type']) = func_get_image_size($_image_data['file_path']);

                    $image_data = array('D' => $_image_data);

                    $image_perms = func_check_image_storage_perms($image_data, 'D');

                    if ($image_perms) {
                        func_save_image($image_data, 'D', $productid);
                    }
                } //}}}
            } //}}}

            // Add Pitney Bowes export flag
            if (!empty($active_modules['Pitney_Bowes'])) { //{{{

                db_query("INSERT INTO $sql_tbl[product_pb_exports] (productid, exported) VALUES ('$productid', '0')");

            } // }}}

            $_categoryids = array($categoryid);
            $categoryids = func_array_merge($_categoryids, func_get_category_parents($_categoryids));

            func_recalc_product_count($categoryids);

            // Update categories data cache
            // Must be run after func_recalc_product_count/func_cat_tree_rebuild/func_recalc_subcat_count
            if (!empty($active_modules['Flyout_Menus']) && func_fc_use_cache()) {
                func_fc_build_categories(1);
            }

            func_build_quick_flags($productid);
            func_build_quick_prices($productid);

            $top_message = array(
                'type' => 'I',
                'content' => func_get_langvar_by_name('msg_data_import_success'),
            );

        } else {

            $top_message = array(
                'type'    => 'I',
                'content' => func_get_langvar_by_name('msg_data_import_no_data'),
            );

        } //}}}
    }

    func_header_location("product_modify.php?productid=$productid");
} //}}}

function func_alibaba_wholesale_getClient()
{ //{{{
    static $TopClient = null;

    if (!isset($TopClient)) {
        func_alibaba_wholesale_load_classes();
        $TopClient = new XCAlibabaWholesaleTopClient();
    }

    return $TopClient;
} //}}}

function func_alibaba_wholesale_getCategories()
{ //{{{
    global $aw_category_id, $smarty;

    $aw_client = func_alibaba_wholesale_getClient();

    if ($aw_category_id == XCAlibabaWholesaleDefs::ROOT) {

        func_alibaba_wholesale_load_classes();
        $cat_request = new AlibabaWholesaleCategoryGetRequest();
        $cat_result = $aw_client->execute($cat_request);

        $aw_categories = XCWholesaleCategoryOpenResult::getResultsAsArray($cat_result);

    } else {

        $aw_products = func_alibaba_wholesale_getProducts();

        $aw_categories = isset($aw_products[0]['categories']) ? $aw_products[0]['categories'] : array();
    }

    $smarty->assign('aw_current_category', $aw_category_id);

    return $aw_categories;
} //}}}

function func_alibaba_wholesale_getParentCategory($aw_categories)
{ //{{{
    global $aw_category_id;

    if ($aw_category_id !== XCAlibabaWholesaleDefs::ROOT) {
        foreach ($aw_categories as $awcat) {
            if ($awcat['id'] === $aw_category_id) {
                return $awcat['parent'];
            }
        }
    }

    return false;
} //}}}

function func_alibaba_wholesale_getProducts()
{ //{{{
    global $aw_category_id, $aw_keyword, $aw_page, $aw_price_from, $aw_price_to;
    global $aw_order_from, $aw_order_to, $aw_sort_by, $config;

    // start price (in cents)
    $_aw_price_from = 100 * (isset($aw_price_from)
        ? $aw_price_from
        : $config['alibaba_wholesale_pricefrom']);

    // end price (in cents)
    $_aw_price_to = 100 * (isset($aw_price_to)
        ? $aw_price_to
        : $config['alibaba_wholesale_priceto']);

    // order quantity from
    $_aw_order_from = isset($aw_order_from)
        ? $aw_order_from
        : $config['alibaba_wholesale_orderfrom'];

    // order quantity to
    $_aw_order_to = isset($aw_order_to)
        ? $aw_order_to
        : $config['alibaba_wholesale_orderto'];

    // sort by type (bbPrice-asc / bbPrice-desc)
    $_aw_sort_by = isset($aw_sort_by)
        ? $aw_sort_by
        : $config['alibaba_wholesale_sortby'];

    // current page
    $_aw_page = isset($aw_page)
        ? $aw_page
        : 1;

    // products limit
    $_aw_plimit = $config['Appearance']['products_per_page_admin'];

    if ($aw_category_id == XCAlibabaWholesaleDefs::ROOT) {

        $_aw_plimit = 5; // products limit for root categories
        $aw_categories = func_alibaba_wholesale_getCategories();

    } else {

        $aw_categories = array(array('id' => $aw_category_id));
    }

    $aw_client = func_alibaba_wholesale_getClient();

    func_alibaba_wholesale_load_classes();
    $goods_request = new AlibabaWholesaleGoodsSearchRequest();

    $paramSearchGoodsOption = new SearchGoodsOption();

    $paramSearchGoodsOption->priceFromCent = $_aw_price_from;
    $paramSearchGoodsOption->priceToCent = $_aw_price_to;

    $paramSearchGoodsOption->minOrderFrom = $_aw_order_from;
    $paramSearchGoodsOption->minOrderTo = $_aw_order_to;

    $paramSearchGoodsOption->pageSize = $_aw_plimit;
    $paramSearchGoodsOption->pageNo = $_aw_page;

    $paramSearchGoodsOption->sortBy = $_aw_sort_by;

    foreach ($aw_categories as $key => $category) { //{{{

        // Regular category search
        $paramSearchGoodsOption->categoryId = $category['id'];

        if (!empty($aw_keyword)) {
            // Search by keyword
            $paramSearchGoodsOption->keyword = $aw_keyword;
        }

        $preparedGoodsOption = XCWholesaleClassConverter::prepareRequestObject($paramSearchGoodsOption);

        $goods_request->setParamSearchGoodsOption($preparedGoodsOption);
        $goods_result = $aw_client->execute($goods_request);

        $aw_goods = XCWholesaleSearchOpenResult::getResultsAsArray($goods_result);

        $aw_categories[$key] = array_merge($aw_categories[$key], $aw_goods);
    } //}}}

    return $aw_categories;
} //}}}

function func_alibaba_wholesale_getProduct()
{ //{{{
    global $aw_product_id;

    $aw_client = func_alibaba_wholesale_getClient();

    func_alibaba_wholesale_load_classes();
    $good_request = new AlibabaWholesaleGoodsGetRequest();
    $good_request->setId($aw_product_id);

    $good_result = $aw_client->execute($good_request);

    $aw_good = XCWholesaleGoodsOpenResult::getResultsAsArray($good_result);

    return $aw_good;
} //}}}

function func_ajax_block_alibaba_wholesale_categories()
{ //{{{
    global $smarty;

    $aw_categories = func_alibaba_wholesale_getCategories();

    $smarty->assign('aw_categories', $aw_categories);

    $aw_parent_category = func_alibaba_wholesale_getParentCategory($aw_categories);

    $smarty->assign('aw_parent_category', $aw_parent_category);

    $result = func_display('modules/Alibaba_Wholesale/aw_categories.tpl', $smarty, false);

    return $result;
} //}}}

function func_ajax_block_alibaba_wholesale_products()
{ //{{{
    global $smarty;

    $aw_categories = func_alibaba_wholesale_getProducts();

    $smarty->assign('aw_categories', $aw_categories);

    $result = func_display('modules/Alibaba_Wholesale/aw_products.tpl', $smarty, false);

    return $result;
} //}}}

function func_ajax_block_alibaba_wholesale_product()
{ //{{{
    global $smarty;

    $aw_product = func_alibaba_wholesale_getProduct();

    $smarty->assign('aw_product', $aw_product);

    $result = func_display('modules/Alibaba_Wholesale/aw_product.tpl', $smarty, false);

    return $result;
} //}}}

function func_ajax_block_alibaba_wholesale_search()
{ //{{{
    global $smarty;

    $smarty->assign('aw_add_container', true);

    $result1 = func_ajax_block_alibaba_wholesale_categories();
    $result2 = func_ajax_block_alibaba_wholesale_products();

    return $result1 . $result2;
} //}}}

?>
