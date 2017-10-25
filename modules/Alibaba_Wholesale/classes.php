<?php
/* vim: set ts=4 sw=4 sts=4 et: */
/* * ***************************************************************************\
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
  \**************************************************************************** */

/**
 * Classes
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Michael Bugrov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v16 (xcart_4_7_7), 2017-01-24 09:29:34, classes.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

interface XCWholesaleOpenResult { //{{{

    /**
     * Get results as an array
     *
     * @param AlibabaWholesale*Request $object
     *
     * @return array results
     */
    public static function getResultsAsArray($object);
} //}}}

class XCWholesaleClassConverter { //{{{

    /**
     * Prepare request object
     *
     * @param object $object
     *
     * @return string json
     */
    public static function prepareRequestObject($object)
    { //{{{
        global $xcart_dir;

        require_once "$xcart_dir/include/classes/class.XCStringUtils.php";

        foreach ($object as $property => $value) {
            $object->{XCStringUtils::convertFromCamelCase($property)} = $value;
        }

        return json_encode($object);
    } //}}}

    /**
     * Return unit and units from the API returned results string
     *
     * @param string $string
     *
     * @return array
     */
    public static function getUnitAndUnits($string)
    { //{{{
        return array(
            'unit' => ($unit = explode('/', $string)) && isset($unit[0]) ? $unit[0] : $string,
            'units' => isset($unit[1]) ? $unit[1] : $string,
        );
    } //}}}

} //}}}

class XCAlibabaWholesaleAPIerrors { //{{{

    const _20010000 = 'Call succeeds ';
    const _20020000 = 'System Error';
    const _20030000 = 'Unauthorized transfer request';
    const _20030010 = 'Required parameters';
    const _20030020 = 'Invalid protocol format';
    const _20030030 = 'API version input parameter error';
    const _20030040 = 'API name space input parameter error';
    const _20030050 = 'API name input parameter error';
    const _20030060 = 'Fields input parameter error';
    const _20030070 = 'Keyword input parameter error';
    const _20030080 = 'Category ID input parameter error';
    const _20030090 = 'Tracking ID input parameter error';
    const _20030100 = 'Commission rate input parameter error';
    const _20030120 = 'Discount input parameter error';
    const _20030130 = 'Volume input parameter error';
    const _20030140 = 'Page number input parameter error';
    const _20030150 = 'Page size input parameter error';
    const _20030160 = 'Sort input parameter error';
    const _20030201 = 'Product dose not exist';
    const _20030170 = 'Credit Score input parameter error';

    public static function getErrorDescription($code)
    { //{{{

        $reflection = new ReflectionClass(__CLASS__);
        $constName = "_$code";

        if ($reflection->hasConstant($constName)) {
            return constant(__CLASS__ . '::' . $constName);
        }

        return 'Unknown error';
    } //}}}

} //}}}

/**
 * @see http://open.taobao.com/apidoc/dataStruct.htm?spm=a219a.7386789.1998342880.6.dVJvfU&path=cid:3-dataStructId:21564-apiId:24365-invokePath:wholesale_category_result
 */
class XCWholesaleCategoryOpenResult extends WholesaleCategoryOpenResult implements XCWholesaleOpenResult { //{{{

    const PATH = 'wholesale_category_result';

    public static function getResultsAsArray($object)
    { //{{{
        $result = array();

        if (
            !empty($object) && is_object($object) && isset($object->{static::PATH}->result->node_map)
        ) {
            $decoded = json_decode($object->{static::PATH}->result->node_map);

            foreach ($decoded as $key => $value) {
                $result[$key] = array(
                    'id' => $value->id,
                    'name' => $value->name,
                    'parent' => XCAlibabaWholesaleDefs::ROOT
                );
            }

            // sort results by name
            usort($result, 'func_alibaba_wholesale_sort_by_name');
        }

        return $result;
    } //}}}

} //}}}

/**
 * @see http://open.taobao.com/apidoc/dataStruct.htm?spm=a219a.7386789.1998342880.8.H20UnQ&path=cid:4-dataStructId:21559-apiId:24366-invokePath:wholesale_goods_search_result
 */
class XCWholesaleSearchOpenResult extends WholesaleSearchOpenResult implements XCWholesaleOpenResult { //{{{

    const PATH = 'wholesale_goods_search_result';

    public static function getResultsAsArray($object)
    { //{{{
        $result = array(
            'categories' => array(),
            'goods' => array()
        );

        if (
            !empty($object) && is_object($object) && isset($object->{static::PATH}->result->category->node_map)
        ) {
            $cats_decoded = json_decode($object->{static::PATH}->result->category->node_map);
            $cats_paths = array_map('json_decode', $object->{static::PATH}->result->category->paths->json);

            foreach ($cats_decoded as $key => $value) {
                $result['categories'][$key] = array(
                    'id' => $value->id,
                    'name' => $value->name,
                    'parent' => func_alibaba_wholesale_search_parent($value->id, $cats_paths)
                );
                $result['categories'][$key]['level'] = func_alibaba_wholesale_cat_level(
                    $result['categories'][$key]['parent'],
                    $cats_paths
                );
            }

            // sort results by name
            usort($result['categories'], 'func_alibaba_wholesale_sort_by_name');

            $goods_list = $object->{static::PATH}->result->items->goods_summary;

            foreach ($goods_list as $key => $value) {
                $result['goods'][$key] = array(
                    'id' => $value->id,
                    'name' => ucfirst($value->subject),
                    'thumb_url' => $value->thumb_url,
                    'currency' => $value->currency,
                    'moq' => $value->moq,
                    'min_price' => $value->min_price_cent / 100,
                    'max_price' => $value->max_price_cent / 100,
                );
                // add units
                $result['goods'][$key] = array_merge(
                    $result['goods'][$key], XCWholesaleClassConverter::getUnitAndUnits($value->unit)
                );
            }
        }

        return $result;
    } //}}}

} //}}}

/**
 * @see http://open.taobao.com/apidoc/dataStruct.htm?spm=a219a.7386789.1998342880.6.2dJAMH&path=cid:4-dataStructId:21563-apiId:24358-invokePath:wholesale_goods_result
 */
class XCWholesaleGoodsOpenResult extends WholesaleGoodsOpenResult implements XCWholesaleOpenResult { //{{{

    const PATH = 'wholesale_goods_result';

    const ATTRIBUTE = 'wholesale_goods_attribute';

    const FREIGHT_INFO_LIST = 'freight_info_list';
    const IMAGE_URLS = 'image_urls';
    const PROPERTY_LIST = 'property_list';
    const SUPPLIER_INFO = 'supplier_info';
    const THUMB_URLS = 'thumb_urls';

    public static function getResultsAsArray($object)
    { //{{{
        $result = array();

        if (
            !empty($object) && is_object($object) && isset($object->{static::PATH}->result)
        ) {
            $product = $object->{static::PATH}->result;

            if (!empty($product->id)) {

                $result['id'] = $product->id;
                $result['name'] = ucfirst($product->subject);
                $result['description'] = ucfirst($product->description);
                $result['keyword'] = $product->keyword;

                $result['moq'] = $product->moq;

                $result['weight'] = $product->weight;

                $result['currency'] = $product->currency;
                $result['max_price'] = $product->max_price_cent / 100;
                $result['min_price'] = $product->min_price_cent / 100;

                $result['detail_url'] = $product->detail_url;
                $result['buy_now_url'] = $product->buy_now_url;

                $result['package_method'] = isset($product->package_method) ? $product->package_method : '';
                $result['package_size'] = isset($product->package_size) ? $product->package_size : '';
                $result['shipping_date'] = isset($product->shipping_date) ? $product->shipping_date : '';

                $result['batch_sale'] = $product->batch_sale;

                // add units
                $result = array_merge(
                    $result, XCWholesaleClassConverter::getUnitAndUnits($product->unit)
                );
            }

            // add tumbnails
            if (isset($product->{self::THUMB_URLS}->string)) {
                $result[self::THUMB_URLS] = $product->{self::THUMB_URLS}->string;
            }
            // add images
            if (isset($product->{self::IMAGE_URLS}->string)) {
                $result[self::IMAGE_URLS] = $product->{self::IMAGE_URLS}->string;
            }
            // add properties
            if (isset($product->{self::PROPERTY_LIST}->{self::ATTRIBUTE})) {
                // convert to array
                foreach ($product->{self::PROPERTY_LIST}->{self::ATTRIBUTE} as $attribute) {

                    $property = array();

                    if (isset($attribute->id)) {
                        $property['id'] = $attribute->id;
                    }

                    if (isset($attribute->property_name)) {
                        $property['property_name'] = $attribute->property_name;
                    }

                    if (isset($attribute->property_value)) {
                        $property['property_name'] = $attribute->property_value;
                    }

                    $result[self::PROPERTY_LIST][] = $property;
                }
            }
            // add supplier info
            if (isset($product->{self::SUPPLIER_INFO})) {

                $result[self::SUPPLIER_INFO] = array();

                if (isset($product->{self::SUPPLIER_INFO}->comp_city)) {
                    $result[self::SUPPLIER_INFO]['comp_city'] = $product->{self::SUPPLIER_INFO}->comp_city;
                }
                if (isset($product->{self::SUPPLIER_INFO}->comp_country)) {
                    $result[self::SUPPLIER_INFO]['comp_country'] = func_get_country($product->{self::SUPPLIER_INFO}->comp_country);
                }
                if (isset($product->{self::SUPPLIER_INFO}->comp_province)) {
                    $result[self::SUPPLIER_INFO]['comp_province'] = $product->{self::SUPPLIER_INFO}->comp_province;
                }
                if (isset($product->{self::SUPPLIER_INFO}->company_name)) {
                    $result[self::SUPPLIER_INFO]['company_name'] = $product->{self::SUPPLIER_INFO}->company_name;
                }
                if (isset($product->{self::SUPPLIER_INFO}->golden_supplier_years)) {
                    $result[self::SUPPLIER_INFO]['golden_supplier_years'] = $product->{self::SUPPLIER_INFO}->golden_supplier_years;
                }
                if (isset($product->{self::SUPPLIER_INFO}->id)) {
                    $result[self::SUPPLIER_INFO]['id'] = $product->{self::SUPPLIER_INFO}->id;
                }
                if (isset($product->{self::SUPPLIER_INFO}->logo_url)) {
                    $result[self::SUPPLIER_INFO]['logo_url'] = $product->{self::SUPPLIER_INFO}->logo_url;
                }
            }
            // add freight info
            if (isset($product->{self::FREIGHT_INFO_LIST})) {
                $result[self::FREIGHT_INFO_LIST] = array();
            }
        }

        return $result;
    } //}}}

} //}}}

class XCAlibabaWholesaleTopClient extends TopClient { //{{{

    public $format = XCAlibabaWholesaleDefs::JSON;

    /**
     * Constructor
     *
     * @global array $config - X-Cart Configuration Data
     */
    public function __construct()
    { //{{{
        // Get app config data
        $appConfig = func_alibaba_wholesale_get_app_config();

        // Application key
        $this->appkey = $appConfig['appKey'];
        // Application secret
        $this->secretKey = $appConfig['secretKey'];

        // Get class methods
        $class_methods  = get_class_methods(__CLASS__);

        // Enable caching for supported requests
        foreach ($class_methods as $method) {
            // Find cache methods
            if (preg_match("/cache(.*)Execute/", $method)) {
                // Register cache function
                func_register_cache_function(
                    $method,
                    array(
                        'class' => __CLASS__,
                        'dir'   => 'alibaba_wholesale_cache',
                        'hashedDirectoryLevel' => 2,
                        'ttl' => $this->{$method}()
                    )
                );
            }
        }
    } //}}}

    /**
     * Execute the request (modified version)
     *
     * @param object $request
     * @param string $session ONLY FOR COMPABILITY (NOT USED)
     *
     * @global string $XCARTSESSID
     * @global string $xcart_http_host
     *
     * @see TopClient::execute for more info
     *
     * @return \ResultSet
     */
    public function execute($request, $session = NULL)
    { //{{{
        global $XCARTSESSID, $xcart_http_host;

        $result = new ResultSet();
        if ($this->checkRequest) {
            try {
                $request->check();
            } catch (Exception $e) {

                $result->code = $e->getCode();
                $result->msg = $e->getMessage();
                return $result;
            }
        }

        // API params
        $sysParams['app_key'] = $this->appkey;
        $sysParams['v'] = $this->apiVersion;
        $sysParams['format'] = $this->format;
        $sysParams['sign_method'] = $this->signMethod;
        $sysParams['method'] = $request->getApiMethodName();
        $sysParams['timestamp'] = date('Y-m-d H:i:s');
        $sysParams['partner_id'] = 'xcart';
        // Unique session ID
        $sysParams['session'] = $session = md5($xcart_http_host . '|' . $XCARTSESSID);

        $apiParams = $request->getApiParas();

        // Define params list
        $cachekey_params_list = array_merge($apiParams, $sysParams);
        unset($cachekey_params_list['timestamp']);

        // Get request method name
        $cache_method_name = $this->getCachedExecuteMethodName($request);

        // Generate cache key
        $cache_key = $cache_method_name . '|' . $this->generateSign($cachekey_params_list);

        if (
            method_exists($this, $cache_method_name) // check cache method
            && ($cacheData = func_get_cache_func($cache_key, $cache_method_name))
        ) {
            return $cacheData['data'];
        }

        $sysParams['sign'] = $this->generateSign(array_merge($apiParams, $sysParams));

        $requestUrl = $this->gatewayUrl . '?';
        foreach ($sysParams as $sysParamKey => $sysParamValue) {
            $requestUrl .= "$sysParamKey=" . urlencode($sysParamValue) . '&';
        }
        $requestUrl = substr($requestUrl, 0, -1);

        try {
            $resp = $this->curl($requestUrl, $apiParams);
        } catch (Exception $e) {
            $this->logCommunicationError($sysParams['method'], $requestUrl, 'HTTP_ERROR_' . $e->getCode(), $e->getMessage());
            $result->code = $e->getCode();
            $result->msg = $e->getMessage();
            return $result;
        }

        $respWellFormed = false;
        if (XCAlibabaWholesaleDefs::JSON == $this->format) {
            $respObject = json_decode($resp);
            if (null !== $respObject) {
                $respWellFormed = true;
                foreach ($respObject as $propValue) {
                    $respObject = $propValue;
                }
            }
        } else if (XCAlibabaWholesaleDefs::XML == $this->format) {
            $respObject = simplexml_load_string($resp);
            if (false !== $respObject) {
                $respWellFormed = true;
            }
        }

        if (!$respWellFormed) {
            $this->logCommunicationError($sysParams["method"], $requestUrl, "HTTP_RESPONSE_NOT_WELL_FORMED", $resp);
            $result->code = 0;
            $result->msg = "HTTP_RESPONSE_NOT_WELL_FORMED";
            return $result;
        }

        if (defined('ALIBABA_WHOLESALE_DEBUG')) {
            $logData = array(
                'requestUrl' => $requestUrl,
                'apiParams' => $apiParams,
                'result' => $resp
            );

            x_log_add('alibaba_wholesale', $logData);
        }

        if (
            method_exists($this, $cache_method_name) // check cache method
            && !empty($respObject) // save only not empty results
        ) {
            // Save data in cache
            func_save_cache_func($respObject, $cache_key, $cache_method_name);
        }

        return $respObject;
    } //}}}

    public function cacheAlibabaWholesaleCategoryGetRequestExecute()
    { //{{{
        return 14 * SECONDS_PER_DAY; // cache for 2 weeks
    } //}}}

    public function cacheAlibabaWholesaleGoodsSearchRequestExecute()
    { //{{{
        return 1440 * SECONDS_PER_MIN; // cache for 15 mins
    } //}}}

    public function cacheAlibabaWholesaleGoodsGetRequestExecute()
    { //{{{
        return 5 * SECONDS_PER_DAY; // cache for 2 days
    } //}}}

    protected function getCachedExecuteMethodName($request)
    { //{{{
        if (is_object($request)) {
            return $this->getCachedExecuteMethodName(get_class($request));
        }

        return 'cache' . $request . 'Execute';
    } //}}}

    protected function logCommunicationError($apiName, $requestUrl, $errorCode, $responseTxt)
    { //{{{
        $SERVER_ADDR = filter_input(INPUT_SERVER, 'SERVER_ADDR');

        if (defined('ALIBABA_WHOLESALE_DEBUG')) {
            $localIp = !empty($SERVER_ADDR) ? $SERVER_ADDR : 'CLI';

            $logData = array(
                date("Y-m-d H:i:s"),
                $apiName,
                $this->appkey,
                $localIp,
                PHP_OS,
                $this->sdkVersion,
                $requestUrl,
                $errorCode,
                str_replace("\n", '', $responseTxt)
            );

            x_log_add('alibaba_wholesale', $logData);
        }
    } //}}}

}

class XCAlibabaWholesaleTpl { //{{{

    public static function getAlibabaWholesaleId($params, $template)
    { //{{{
        global $sql_tbl;

        if (!isset($params['assign'])) {
            return '';
        }

        $productid = isset($params['productid']) ? intval($params['productid']) : 0;
        if (!empty($productid)) {
            $_alibaba_wholesale_id = func_query_first_cell("SELECT alibaba_wholesale_id FROM $sql_tbl[product_alibaba_wholesale_ids] WHERE productid = $productid");
        } else {
            $_alibaba_wholesale_id = '';
        }

        $template->assign($params['assign'], $_alibaba_wholesale_id);
        return '';
    } //}}}

    public static function registerSmartyFunctions()
    { //{{{
        global $smarty;
        $smarty->registerPlugin('function', 'aw_get_alibaba_wholesale_id', array('XCAlibabaWholesaleTpl','getAlibabaWholesaleId'));
        return true;
    } //}}}

} //}}}
