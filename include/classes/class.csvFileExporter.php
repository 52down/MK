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
 * Froogle/facebook export module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ildar Amankulov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    c9cb6a57aea3fbb8662e6fca3d3239db94c934e3, v3 (xcart_4_7_8), 2017-06-04 15:44:01, class.csvFileExporter.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

namespace XC;

if ( !defined('XCART_SESSION_START') ) { header("Location: ../../"); die("Access denied"); }

class csvFileExporter {

    const
    ALWAYS_SET_GROUP_ID = true,//set false for froogle
    USE_PRODUCTID_AS_GROUP = true,//set false for froogle
    PRODUCTID_GROUP_PREFIX = '_pid',//sync with tpl, main_productcode cannot be used in tpl as there is not in templates
    EXPIRATION_DAYS = 30,
    MAX_ADDITIONAL_IMAGES_COUNT = 10,
    MAX_DESCRIPTION_LENGTH = 5000,
    MAX_TITLE_LENGTH = 100,
    MAX_BRAND_LENGTH = 70,
    MAX_PRODUCT_TYPE_LENGTH = 750,//https://developers.facebook.com/docs/marketing-api/dynamic-product-ads/product-catalog/v2.9#feed-format
    MAX_GOOGLE_PRODUCT_CATEGORY_LENGTH = 250,//https://developers.facebook.com/docs/marketing-api/dynamic-product-ads/product-catalog/v2.9#feed-format
    STR_TAIL = '...',
    DELIM = "\t",
    EMPTY_PRODUCTS = 'EMPTY_PRODUCTS',
    DONE = 'DONE',
    GET_IDS = 'GET_IDS',
    FILE_OPEN_ERROR = 'FILE_OPEN_ERROR'
    ;
    protected $redefined_fields = array('age_group','brand');

    protected $moduleName, $full_filename, $firstStepExport, $filePointer, $startText, $exportParams;

    public function __construct($full_filename, $start_text, $export_params) {//{{{
        $this->full_filename = $full_filename;
        $this->moduleName = $export_params['module_name'];
        $this->startText = $start_text;

        $this->exportParams['currency'] = isset($export_params['currency']) ? $export_params['currency'] : '';
        $this->exportParams['language'] = isset($export_params['language']) ? $export_params['language'] : '';
        $this->exportParams['age_group'] = isset($export_params['age_group']) ? $export_params['age_group'] : '';

        $this->exportParams['expiration_date'] = isset($export_params['expiration_date']) ? $export_params['expiration_date'] : static::EXPIRATION_DAYS;
        $this->exportParams['weight_unit'] = isset($export_params['weight_unit']) ? $export_params['weight_unit'] : 'lb';
    }//}}}

    public function saveProducts($in_condition) {//{{{
        global $https_location, $http_location;

        if (!$this->openExportFile()) {
            return array('code' => static::FILE_OPEN_ERROR);
        }
        $export_lng = $this->exportParams['language'];

        $query = $this->getQuery($export_lng, $in_condition);

        db_query("SET SESSION group_concat_max_len = 32");
        $products = db_query($query);
        if (db_num_rows($products) == 0) {
            return array('code' => static::EMPTY_PRODUCTS);
        }

        if ($this->startText && !defined('X_INTERNAL_CRON')) {
            func_display_service_header($this->startText, true);
        }

        x_load('category','product');

        $cnt = 0;
        $preffered_location = false ? $https_location : $http_location;//$Config['Froogle']['froogle_used_https_links'] = = 'Y'

        while ($product = db_fetch_array($products)) {
            $product['variantid'] = $variantid = intval($product['variantid']);
            $productid = $product['productid'];

            // Define product additional attributes
            $product_additional_attributes = $this->getProductExtraFields($productid, $variantid);
            foreach ($this->redefined_fields as $redefined_name) {
                if (isset($product_additional_attributes[$redefined_name])) {
                    $product[$redefined_name] = $product_additional_attributes[$redefined_name];
                    unset($product_additional_attributes[$redefined_name]);
                }
            }
            if (!empty($product_additional_attributes)) {
                $product_additional_attributes = static::DELIM . implode(static::DELIM, $product_additional_attributes);
            } else {
                $product_additional_attributes = '';
            }

            $product['descr'] = strlen($product['descr']) < 7 ? $product['fulldescr'] : $product['descr'];

            $product_price = $product['taxed_price'] = $this->getProductPrice($productid, $product['price']);

            $tmbn = $this->getProductImage($productid, $variantid, $preffered_location);
            $additional_images = $this->getProductAdditionalImages($productid, $preffered_location);

            // Define product category path
            // truncate GROUP_CONCAT to first main category
            $cats = $this->getCategories(intval($product['categoryid']), $export_lng);

            // Post string
            $post = //
                // unique identifier for all products (including variant products) - Productcode, not productid
                $product['productcode'] . static::DELIM .
                // do not include any data into item_group_id attribute if not variant product
                $this->getGroupId($product) . static::DELIM .
                $this->convertText($product['product'], static::MAX_TITLE_LENGTH) . static::DELIM .
                $this->convertText($product['descr'], static::MAX_DESCRIPTION_LENGTH) . static::DELIM .
                $this->convertText((!empty($cats) ? $cats : ''), static::MAX_PRODUCT_TYPE_LENGTH) . static::DELIM .
                $this->convertText((!empty($cats) ? $cats : ''), static::MAX_GOOGLE_PRODUCT_CATEGORY_LENGTH) . static::DELIM .
                $this->getProductUrl($productid) . static::DELIM .
                $tmbn . static::DELIM .
                $additional_images . static::DELIM .
                "new" . static::DELIM.
                $this->getAvailability($product) . static::DELIM .
                // currency is combined with price
                number_format(round($product_price, 2), 2, ".", "")." ".  (!isset($this->exportParams['currency']) ? 'USD' : $this->exportParams['currency']) . static::DELIM.
                $product['weight'] . ' '. $this->exportParams['weight_unit'] . static::DELIM.
                date("Y-m-d", XC_TIME + $this->exportParams['expiration_date']*86400) . static::DELIM .
                (empty($product['age_group']) ? $this->exportParams['age_group'] : $product['age_group']) . static::DELIM.
                $this->convertText(empty($product['brand']) ? $product['manufacturer'] : $product['brand'], static::MAX_BRAND_LENGTH).
                $product_additional_attributes
            ;

            $file_header = $this->getHeaders();
            assert('count(explode("' . static::DELIM . '", $post)) == count(explode("' . static::DELIM . '" , $file_header))  /*return '.__METHOD__.'*/');

            fputs($this->filePointer, $post."\n");
            $cnt++;
            if ($cnt % 100 == 0) {
                echo '.';
                if($cnt % 5000 == 0) {
                    echo "<br />\n";
                }

                !defined('X_INTERNAL_CRON') && func_flush();
            }
        }

        $this->closeExportFile();

        return array('code' => static::DONE, 'is_first_step' => $this->firstStepExport, 'real_exported_count_ids' => $cnt);

    }//}}}

    protected function openExportFile() {//{{{
        $full_filename = $this->full_filename;
        $this->filePointer = @fopen($full_filename, 'a+', true);

        if ($this->filePointer !== false) {
            if (func_filesize($full_filename) == 0) {
                $this->firstStepExport = true;

                fwrite($this->filePointer, X_LOG_SIGNATURE);
                fwrite($this->filePointer, $this->getHeaders() . "\n");
            } else {
                $this->firstStepExport = false;
            }
        }

        return $this->filePointer;
    }//}}}

    protected function closeExportFile() {//{{{
        fclose($this->filePointer);
        if ($this->firstStepExport) {
            func_chmod_file($this->full_filename);
        }
    }//}}}

    protected function convertText($str, $max_len=0) {//{{{//
        //Func_froogle_convert
        static $tbl = false;

        if ($tbl === false) {
            $tbl = array_flip(get_html_translation_table(HTML_ENTITIES, ENT_COMPAT | ENT_HTML401, 'UTF-8'));
        }

        $str = str_replace(array("\n","\r","\t"), array(" ", '', " "), $str);
        if (static::DELIM === ',') {
            $str = str_replace(array(","), array('&#44;'), $str);
        }
        $str = strip_tags($str);
        $str = strtr($str, $tbl);

        if (
            $max_len > 0
            && strlen($str) > $max_len
        ) {
            $tail_length = strlen(static::STR_TAIL);
            $str = preg_replace("/\s+?\S+.{" . intval(strlen($str) - $max_len-1+$tail_length) . "}$/Ss", '', $str) . static::STR_TAIL;
            if (strlen($str) > $max_len) {
                $str = substr($str, 0, $max_len-$tail_length) . static::STR_TAIL;
            }
        }

        return $str;
    }//}}}
    /**
     * Get additional attributes from special named extra Fields
     */
    protected function getExtraFieldsHeaders($get_mode = '') {//{{{
        global $active_modules, $sql_tbl, $export_product_extrafields_headers_g, $single_mode, $logged_userid, $current_area;
        static $result = array();

        $md5_args = $get_mode;
        if (isset($result[$md5_args])) {
            return $result[$md5_args];
        }

        $additional_attributes = array();

        if (!empty($active_modules['Extra_Fields'])) {
            $extrafields_headers = $export_product_extrafields_headers_g[$this->moduleName];

            $provider_condition = ($single_mode || $current_area == 'A' ? '' : " AND $sql_tbl[extra_fields].provider='$logged_userid' ");

            if ($get_mode === static::GET_IDS) {
                $additional_attributes = func_query_hash("
                    SELECT fieldid, service_name
                    FROM $sql_tbl[extra_fields] WHERE service_name IN ('" . implode("','", $extrafields_headers) . "') $provider_condition
                    ", "fieldid", false, true);
            } else {
                $additional_attributes = func_query_hash("
                    SELECT service_name, value
                    FROM $sql_tbl[extra_fields] WHERE service_name IN ('" . implode("','", $extrafields_headers) . "') $provider_condition
                    ORDER BY orderby", "service_name", false, true);
            }
            $additional_attributes = $additional_attributes ?: array();
        }

        $result[$md5_args] = $additional_attributes;
        assert('is_array($additional_attributes) /*return '.__METHOD__.'*/');
        return $additional_attributes;
    }//}}}

    /**
     * Get additional attributes for product
     */
    protected function getProductExtraFields($pid, $in_variantid = 0, $in_use_product_fields_bydef = true) {//{{{
        global $sql_tbl, $active_modules;
        static $product_variant_ef_values = array();

        if (empty($pid)) {
            return array();
        }

        $additional_attributes = $this->getExtraFieldsHeaders();
        $_product_additional_attributes = array();
        if (!empty($active_modules["Extra_Fields"]) && !empty($additional_attributes)) {

            $in_variantid = intval($in_variantid);

            $additional_attributes_ids = $this->getExtraFieldsHeaders(static::GET_IDS);

            if (!isset($product_variant_ef_values[$pid])) {
                $product_variant_ef_values = array();// free memory from previous product
                $_condition = empty($in_variantid) ? \XCExtraFieldsSQL::getProductValuesCond() : '';
                $product_variant_ef_values[$pid] = func_query("
                    SELECT variantid, fieldid, value
                      FROM $sql_tbl[extra_field_values]
                    WHERE
                       productid = '$pid' $_condition
                       AND fieldid IN ('" . implode("','", array_keys($additional_attributes_ids)) . "')
                   ") ?: array();
            }

            $product_values = $variant_values = array();

            foreach($product_variant_ef_values[$pid] as $_field) {
                $_fieldid = $_field['fieldid'];
                $_service_name = $additional_attributes_ids[$_fieldid];

                if (empty($_field['variantid'])) {
                    // This is the product
                    $product_values[$_service_name] = $_field['value'];
                } elseif($in_variantid == $_field['variantid']) {
                    // This is a variant
                    $variant_values[$_service_name] = $_field['value'];
                }
            }

            // The merge order is 1)extra_fields 2)extra_field_values_products(optional) 3)extra_field_values_variants(optional)
            if (
                $in_use_product_fields_bydef // $Config['FrOogle']['fRoogle_use_product_fields_bydef'] = = 'Y'
                || empty($in_variantid)
            ) {
                $_product_additional_attributes = array_merge($additional_attributes, $product_values, $variant_values);
            } else {
                $_product_additional_attributes = array_merge($additional_attributes, $variant_values);
            }

            assert('count($additional_attributes) == count($_product_additional_attributes)');
        }

        return $_product_additional_attributes;
    }//}}}

    protected function getHeaders() {//{{{
        static $res;
        if (isset($res)) {
            return $res;
        }
        // Full header:
        // title\tdescription\tlink\timage_link\tid\texpiration_date\tlabel\tprice\tprice_type\tcurrency\tpayment_accepted\tpayment_notes\tquantity\tbrand\tupc\tisbn\tmemory\tprocessor_speed\tmodel_number\tsize\tweight\tcondition\tcolor\tactor\tartist\tauthor\tformat\tproduct_type\tlocation

        /*
        $_file_header = "title\tdescription\tlink\timage_link\tid\tprice\tcurrency\tavailability\tshipping_weight\texpiration_date\tbrand\tcondition\tproduct_type";
        */
        // Define header for basic attributes
        $_file_header =
            /* Basic Product Information */
            "id" . static::DELIM .
            "item_group_id" . static::DELIM .             // for Variant Products only
            "title" . static::DELIM .
            "description" . static::DELIM .
            "product_type" . static::DELIM .
            "google_product_category" . static::DELIM .
            "link" . static::DELIM .
            "image_link" . static::DELIM .
            "additional_image_link" . static::DELIM .   // Additional URLs of images of the item
            "condition" . static::DELIM .
            /* Availability & Price */
            "availability" . static::DELIM .
            "price" . static::DELIM .
            //"currency" . static::DELIM .                // combined with price. retired?
            /* Tax & Shipping */
            //"shipping" . static::DELIM .                // provided in Google Merchant Center
            //"tax" . static::DELIM .                     // provided in Google Merchant Center
            "shipping_weight" . static::DELIM .
            /* Additional attributes - recommended */
            "expiration_date" . static::DELIM .
            "age_group" . static::DELIM .
            /* Unique Product Identifiers */
            "brand"
        ;

        // Define header for additional attributes
        $additional_attributes = array_keys($this->getExtraFieldsHeaders());
        foreach ($additional_attributes as $v) {
            if (!in_array($v, $this->redefined_fields)) {
                $_file_header .= static::DELIM . $v;
            }
        }

        $res = $_file_header;
        return $_file_header;
    }//}}}

    protected function getQuery($in_lng, $in_condition) {//{{{
        global $sql_tbl, $active_modules, $config, $logged_userid, $current_area, $single_mode;

        $where = '';
        $fields = '';
        $joins = '';

        if ($config['General']['show_outofstock_products'] != 'Y') {
            if (!empty($active_modules['Product_Options'])) {
                $where .= " AND " . \XCVariantsSQL::getVariantField('avail') . ' > 0 ';
            } else {
                $where .= " AND $sql_tbl[products].avail > '0'";
            }
        }
        $provider_condition = ($single_mode || $current_area == 'A' ? '' : " AND $sql_tbl[extra_fields].provider='$logged_userid' ");
        $where .= $provider_condition;
        if (!empty($in_condition['ids'])) {
            $where .= " AND $sql_tbl[products].productid IN ('" . implode("','", $in_condition['ids']) . "')";
        } elseif (!empty($in_condition['join'])) {
            $joins .= " $in_condition[join]";
        }

        $joins .= "
            INNER JOIN $sql_tbl[pricing]
                ON $sql_tbl[pricing].productid = $sql_tbl[products].productid AND $sql_tbl[pricing].membershipid = '0'";


        $group_by = "GROUP BY $sql_tbl[products].productid";
        if (!empty($active_modules['Product_Options'])) {
            $variant_sql_str = "$sql_tbl[variants].variantid,";

            $joins .= \XCVariantsSQL::getJoinQueryAllRows() . " AND $sql_tbl[pricing].variantid = $sql_tbl[variants].variantid";

            $fields .= ',' .
                \XCVariantsSQL::getVariantField('productcode') . ' as productcode,' .
                \XCVariantsSQL::getVariantField('avail') . ' as avail,' .
                \XCVariantsSQL::getVariantField('weight') . ' as weight';
            // select SKU for variant
            $group_by .= ','.
                \XCVariantsSQL::getVariantField('productcode');
        } else {
            $variant_sql_str = '"variantid",';
        }

        $in_lng = func_validate_language_code($in_lng);
        $joins .= " INNER JOIN {$sql_tbl['products_lng_' . $in_lng]} ON $sql_tbl[products].productid = {$sql_tbl['products_lng_' . $in_lng]}.productid";
        $fields .= ", {$sql_tbl['products_lng_' . $in_lng]}.* ";

        if (!empty($active_modules['Manufacturers'])) {
            $fields .= ",
                IF ($sql_tbl[manufacturers_lng].manufacturer != '', $sql_tbl[manufacturers_lng].manufacturer, $sql_tbl[manufacturers].manufacturer) as manufacturer";
            $joins .= "
                LEFT JOIN $sql_tbl[manufacturers]
                    ON $sql_tbl[products].manufacturerid = $sql_tbl[manufacturers].manufacturerid
                LEFT JOIN $sql_tbl[manufacturers_lng]
                    ON $sql_tbl[products].manufacturerid = $sql_tbl[manufacturers_lng].manufacturerid AND $sql_tbl[manufacturers_lng].code = '$in_lng'";
        } else {
            $fields .= ",'' AS manufacturer";
        }

        // add product's membership condition
        $joins .= " LEFT JOIN $sql_tbl[product_memberships]
                ON $sql_tbl[products].productid = $sql_tbl[product_memberships].productid";
        $where .= " AND $sql_tbl[product_memberships].membershipid IS NULL";

        $query = "
            SELECT
                $variant_sql_str
                $sql_tbl[products].productcode as main_productcode,
                $sql_tbl[products].*,
                GROUP_CONCAT($sql_tbl[products_categories].categoryid ORDER BY $sql_tbl[products_categories].main DESC) AS categoryid,
                $sql_tbl[pricing].price
                $fields
            FROM
                $sql_tbl[products_categories]
                INNER JOIN $sql_tbl[quick_prices]
                INNER JOIN $sql_tbl[products]
            $joins
            WHERE
                $sql_tbl[products].productid = $sql_tbl[products_categories].productid
                AND $sql_tbl[quick_prices].productid = $sql_tbl[products].productid
                AND $sql_tbl[products].forsale = 'Y'
                AND $sql_tbl[products_categories].avail = 'Y'
                AND $sql_tbl[pricing].quantity = 1
                $where
            $group_by
            HAVING (
                /* limit to 1 product for testing */
                /*xcart_products.productid = '16129' AND*/
                $sql_tbl[pricing].price > '0'
                OR $sql_tbl[products].product_type = 'C'
             )
        ";
         //ORDER BY {$sql_tbl['products_lng_' . $in_lng]}.product

        return $query;
    }//}}}

    protected function getCategories($in_product_catid, $in_lng) {//{{{
        global $sql_tbl;
        $_cats = '';
        $catids = func_get_category_path(intval($in_product_catid));
        if (!empty($catids)) {
            $_cats = func_query("SELECT main_tbl.categoryid, IF(lng_tbl.categoryid IS NOT NULL AND lng_tbl.category != '', lng_tbl.category, main_tbl.category) AS category FROM $sql_tbl[categories] AS main_tbl LEFT JOIN $sql_tbl[categories_lng] AS lng_tbl ON lng_tbl.code='$in_lng' AND lng_tbl.categoryid=main_tbl.categoryid WHERE main_tbl.categoryid IN ('".implode("','", $catids)."') AND main_tbl.avail = 'Y'");
            $catids = array_flip($catids);
            if (!empty($_cats)) {
                foreach ($_cats as $v) {
                    if (isset($catids[$v['categoryid']])) {
                        $catids[$v['categoryid']] = $v['category'];
                    }
                }

                $_cats = str_replace(static::DELIM, " ", implode(" > ", $catids));
            }
        }

        return $_cats;
    }//}}}

    protected function getAvailability($in_product) {//{{{
        $appearence = func_get_appearance_data($in_product);
        if ($appearence['buy_now_buttons_enabled'] || $in_product['product_type'] == 'C') {
            $_availability = 'in stock';
        } else {
            $_availability = 'out of stock';
        }

        return $_availability;
    }//}}}

    protected function getGroupId($in_product) {//{{{

        $in_product['productid'] = static::PRODUCTID_GROUP_PREFIX . $in_product['productid'];
        if (static::ALWAYS_SET_GROUP_ID || $in_product['productcode'] != $in_product['main_productcode']) {
            $group_id = static::USE_PRODUCTID_AS_GROUP ? $in_product['productid'] : $in_product['main_productcode'];
        } else {
            $group_id = '';
        }

        return $group_id;
    }//}}}

    protected function getProductPrice($in_productid, $in_product_price) {//{{{
        global $config, $active_modules;

        $config['General']['apply_default_country'] = 'Y';
        $customer_info = array(
            'city' => $config['General']['default_city'],
            'state' => $config['General']['default_state'],
            'country' => $config['General']['default_country'],
            'zipcode' => $config['General']['default_zipcode'],
            'id' => 0
        );

        if (!empty($active_modules['Product_Options'])) {
            $in_product_price += func_get_default_options_markup($in_productid, $in_product_price);
        }

        $product_taxed_price = func_tax_price($in_product_price, $in_productid, false, NULL, $customer_info['id'], '', false, 1, func_tax_get_override_display_including_tax('N'));//$config['FRoogle']['Froogle_display_including_tax']
        $_product_price = $product_taxed_price['taxed_price'];

        return $_product_price;
    }//}}}

    protected function getProductUrl($in_productid, $use_https = false) {//{{{
        global $https_location, $http_location, $xcart_http_host;

        if (!empty($use_https)) {//$Config['FRoogle']['frOogle_used_https_links'] = = 'Y'
            $_product_url = $https_location.constant('DIR_CUSTOMER')."/product.php?productid=" . $in_productid;
        } else {
            $_product_url = $http_location.constant('DIR_CUSTOMER').'/'.func_get_resource_url('product', $in_productid, '', false);
        }
        if (defined('XC_NGROK_PROXY')) {
            $_product_url = str_replace($xcart_http_host, XC_NGROK_PROXY, $_product_url);
        }
        return $_product_url;
    }//}}}

    protected function getProductImage($in_productid, $in_variantid, $preffered_location) {//{{{
        global $https_location, $active_modules, $xcart_http_host;

        // Define product image
        $image_ids = array();

        // Use the largest, full-size image according to https://support.google.com/merchants/answer/188494
        $prefered_image_type = 'P';
        if (
            !empty($in_variantid)
            && !empty($active_modules['Product_Options'])
        ) {
            $image_ids['W'] = $in_variantid;
            $prefered_image_type = 'W';
        }

        $image_ids['P'] = $in_productid;
        $image_ids['T'] = $in_productid;

        $image_data = func_get_image_url_by_types($image_ids, $prefered_image_type);

        if (!empty($image_data['image_url'])) {
            $_tmbn = $image_data['image_url'];

            if (strpos($_tmbn, $https_location) !== false) {
                $_tmbn = str_replace($https_location, $preffered_location, $_tmbn);
            }
        } else {
            $_tmbn = '';
        }

        if (defined('XC_NGROK_PROXY')) {
            $_tmbn = str_replace($xcart_http_host, XC_NGROK_PROXY, $_tmbn);
        }

        return $_tmbn;
    }//}}}

    protected function getProductAdditionalImages($in_productid, $preffered_location) {//{{{
        global $https_location, $active_modules, $xcart_http_host, $sql_tbl;

        if (empty($active_modules['Detailed_Product_Images'])) {
            return '';
        }

        $images = func_query("SELECT imageid, id, image_path, image_type, image_x, image_y, alt FROM $sql_tbl[images_D] WHERE id = '$in_productid' AND avail = 'Y' ORDER BY orderby, imageid LIMIT " . static::MAX_ADDITIONAL_IMAGES_COUNT);

        if (empty($images)) {
            return '';
        }
        $urls = array();
        foreach ($images as $k => $v) {
            $url = func_get_image_url($v['imageid'], 'D', $v['image_path']);

            if (strpos($url, $https_location) !== false) {
                $url = str_replace($https_location, $preffered_location, $url);
            }

            if (defined('XC_NGROK_PROXY')) {
                $url = str_replace($xcart_http_host, XC_NGROK_PROXY, $url);
            }
            $urls[] = $url;
        }

        return implode(',', $urls);
    }//}}}
}//c-lass PRoductsExporter
