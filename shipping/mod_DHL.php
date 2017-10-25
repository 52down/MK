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
 * DHL shipping library
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Michael Bugrov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v29 (xcart_4_7_7), 2017-01-23 20:12:10, mod_DHL.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../"); die("Access denied"); }

x_load('dhl','xml','http');

function func_shipper_DHL($items, $userinfo, $orig_address, $debug, $cart)
{ // {{{
    global $config;
    global $allowed_shipping_methods;
    global $intershipper_rates;

    if (
        empty($config['Shipping']['DHL_id'])
        || empty($config['Shipping']['DHL_password'])
        || empty($config['Shipping']['DHL_account'])
    ) {
        return;
    }

    // Set print debug option
    XC_DHL_DiscoverServices::getInstance()->setPrintDebug($debug == 'Y');
    XC_DHL_GetRates::getInstance()->setPrintDebug($debug == 'Y');

    $shipping_data = $dhl_methods = $rates = array();
    foreach ($allowed_shipping_methods as $v) {
        if ($v['code'] == 'DHL') {
            $dhl_methods[] = $v;
        }
    }

    if (empty($dhl_methods)) {
        return;
    }

    // Destination address info
    $shipping_data['dest_address'] = array(
        'country' => $userinfo['s_country'],
    );

    // Source address info
    $shipping_data['orig_address'] = array(
        'country' => $orig_address['country'],
    );

    // Check if delivery available to the destination country
    if (!XC_DHL_DiscoverServices::getInstance()->isDeliveryAvailable($shipping_data['dest_address']['country'])) {
        return;
    }

    if (($country_info = XCDHLReferenceData::getCountryInfo($shipping_data['dest_address']['country']))) {
        if (strpos($country_info['location_type'], 'City') !== false) {
            $shipping_data['dest_address']['city'] = $userinfo['s_city'];
        }
        if (strpos($country_info['location_type'], 'Postcode') !== false) {
            $shipping_data['dest_address']['zipcode'] = $userinfo['s_zipcode'];
        }
        if (strpos($country_info['location_type'], 'Suburb') !== false) {
            $shipping_data['dest_address']['suburb'] = $userinfo['s_city'];
        }
    }

    if (($country_info = XCDHLReferenceData::getCountryInfo($shipping_data['orig_address']['country']))) {
        if (strpos($country_info['location_type'], 'City') !== false) {
            $shipping_data['orig_address']['city'] = $orig_address['city'];
        }
        if (strpos($country_info['location_type'], 'Postcode') !== false) {
            $shipping_data['orig_address']['zipcode'] = $orig_address['zipcode'];
        }
        if (strpos($country_info['location_type'], 'Suburb') !== false) {
            $shipping_data['orig_address']['suburb'] = $orig_address['city'];
        }
    }

    if (
        $config['General']['zip4_support'] == 'Y'
        && !empty($userinfo['s_zip4'])
    ) {
        $shipping_data['dest_address']['zip4'] = $userinfo['s_zip4'];
    }

    // Get DHL options
    $oDHLOptions = XC_DHL_Options::getInstance();

    // Get specified_dims
    $specified_dims = $oDHLOptions->getSpecifiedDims();
    // Get package limits
    $package_limits = func_get_package_limits_DHL($shipping_data['dest_address']['country'], $debug);

    // Get rates instance
    $objGetRates = XC_DHL_GetRates::getInstance();

    $used_packs = array();

    foreach ($package_limits as $package_limit) {

        $dhl_rates = array();

        // Get packages
        $packages = func_get_packages($items, $package_limit, ($oDHLOptions->useMultiplePackages() == 'Y') ? 100 : 1);

        if (empty($packages) || !is_array($packages)) {
            continue;
        }

        foreach ($packages as $pack_num => $pack) {
            $_pack = $pack;

            $pack_key = md5(serialize($_pack));

            if (isset($used_packs[$pack_key])) {
                $dhl_rates[$pack_num] = $used_packs[$pack_key];
                continue;
            }

            if ($oDHLOptions->useMaximumDimensions() == 'Y') {
                $pack = func_array_merge($pack, $specified_dims);
            }

            $shipping_data['pack'] = $pack;

            list($parsed_rates, $new_methods) = func_DHL_find_methods($objGetRates->getRates($shipping_data), $dhl_methods);

            if (!empty($new_methods)) {
                $intl_use = ($shipping_data['dest_address']['country'] != $shipping_data['orig_address']['country']);
                func_DHL_add_new_methods($new_methods, $intl_use);
            }

            if (empty($parsed_rates)) {
                // Do not calculate all other packs from pack_set if any Pack from the pack_set cannot be calculated
                $dhl_rates = array();
                break;
            }

            $dhl_rates[$pack_num] = $parsed_rates;
            $dhl_rates[$pack_num] = func_normalize_shipping_rates($dhl_rates[$pack_num], 'DHL');

            $used_packs[$pack_key] = $dhl_rates[$pack_num];
        } // foreach $packages

        $_rates = func_array_merge($rates, func_intersect_rates($dhl_rates));
        $rates = func_shipping_min_rates($_rates);
    } // foreach $package_limits

    $intershipper_rates = func_array_merge($intershipper_rates, $rates);
} // }}}

/**
 * Return package limits for DHL package
 */
function func_get_package_limits_DHL($country = '', $debug = 'N')
{ // {{{
    global $config;

    // Enable caching for func_get_package_limits_DHL function
    func_register_cache_function(
        'func_get_package_limits_DHL',
        array (
            'dir'   => 'shipping_DHL_cache',
            'hashedDirectoryLevel' => 2,
        )
    );

    $save_result_in_cache = true;

    $oDHLOptions = XC_DHL_Options::getInstance();

    $md5_args = $country . md5(serialize(array(
        $oDHLOptions->getAllParams(),
        $config['General']['dimensions_symbol_cm'], // From func_correct_dimensions
        $config['General']['weight_symbol_grams'], // From func_correct_dimensions
    )));

    if (($cacheData = func_get_cache_func($md5_args, 'func_get_package_limits_DHL'))) {
        return $cacheData['data'];
    }

    $dim = array();
    list($dim['length'], $dim['width'], $dim['height'], $dim['girth']) = $oDHLOptions->getDims();

    $dimensions_array = array();
    foreach (array('width', 'height', 'length', 'girth') as $_dim) {
        if (!empty($dim[$_dim])) {
            // Must be in inch to work with func_correct_dimensions
            $dimensions_array[$_dim] = func_units_convert(func_dim_in_centimeters($dim[$_dim]), 'cm', 'in', 64);
        }
    }

    $max_weight = $oDHLOptions->getMaxWeight();
    if ($max_weight > 0) {
        // Must be lbs to work with func_correct_dimensions
        $dimensions_array['weight'] = func_units_convert(func_weight_in_grams($max_weight), 'g', 'lbs', 64);
    }

    $avalaible_packages = $oDHLOptions->getAvailablePackages();
    if (empty($avalaible_packages)) {
        $avalaible_packages = array();
        $save_result_in_cache = false;
    }

    $package_limits = $uniq_limit_hashes = array();

    foreach ($avalaible_packages as $package) {

        // DHL results are in kg and cm
        $packing_limits = $oDHLOptions->getPackageLimits($package);
        if (empty($packing_limits)) {
            $save_result_in_cache = false;
            continue;
        }

        // Convert from DHL (cm) to (inch)
        foreach (array('width', 'height', 'length', 'girth') as $_dim) {
            if (!empty($packing_limits[$_dim])) {
                $packing_limits[$_dim] = func_units_convert($packing_limits[$_dim], 'cm', 'in', 64);
            }
        }

        // Convert from DHL (kg) to (lbs)
        if (!empty($packing_limits['weight'])) {
            $packing_limits['weight'] = func_units_convert($packing_limits['weight'], 'kg', 'lbs', 64);
        }

        // Overwrite limits from DHL settings in admin area
        foreach (array('width', 'height', 'length', 'weight', 'girth') as $_dim) {
            if (
                !empty($dimensions_array[$_dim])
                && !empty($packing_limits[$_dim])
            ) {
                $packing_limits[$_dim] = min($packing_limits[$_dim], $dimensions_array[$_dim]);
            } elseif (!empty($dimensions_array[$_dim])) {
                $packing_limits[$_dim] = $dimensions_array[$_dim];
            }
        }

        $hash = serialize($packing_limits);

        if (empty($uniq_limit_hashes[$hash])) {
            $package_limits[] = $packing_limits;
        }

        $uniq_limit_hashes[$hash] = 1;
    }

    foreach ($package_limits as $k => $v) {
        $package_limits[$k] = func_correct_dimensions($v);
    }

    if ($save_result_in_cache) {
        func_save_cache_func($package_limits, $md5_args, 'func_get_package_limits_DHL');
    }

    return $package_limits;
} // }}}

/**
 * Check if DHL allows box
 */
function func_check_limits_DHL($box)
{ // {{{
    $box['weight'] = isset($box['weight']) ? $box['weight'] : 0;

    $pack_limit = func_get_package_limits_DHL();
    $avail = (func_check_box_dimensions($box, $pack_limit) && $pack_limit['weight'] > $box['weight']);

    return $avail;
} // }}}

/**
 * Add new shipping methods
 *
 * @staticvar array $added_methods
 *
 * @param array $new_methods
 * @param string $intl_use (I / L)
 *
 * @return boolean
 */
function func_DHL_add_new_methods($new_methods, $intl_use)
{ // {{{
    static $added_methods = array();

    if (empty($new_methods)) {
        return false;
    }

    $oDHLOptions = XC_DHL_Options::getInstance();

    foreach ($new_methods as $m) {
        $method_key = md5(serialize($m));
        if (isset($added_methods[$method_key])) {
            continue;
        }
        else {
            $added_methods[$method_key] = 1;
        }

        // Add new shipping method
        $_params = array();
        $_params['destination'] = ($intl_use ? 'I' : 'L');
        $_params['subcode'] = $m['service-code'];

        if (!empty($m['expected-transit-time'])) {
            $_params['shipping_time'] = $m['expected-transit-time'];
        }

        if ($oDHLOptions->isNewMethodEnabled()) {
            $_params['active'] = 'Y';
        }

        func_add_new_smethod('DHL ' . ucwords(strtolower($m['service-name'])), 'DHL', $_params);
    }

    return true;
} // }}}

/**
 * Find shipping methods
 *
 * @param array $rates
 * @param array $dhl_methods
 *
 * @return array
 */
function func_DHL_find_methods($rates, $dhl_methods)
{ // {{{
    if (empty($rates) || empty($dhl_methods)) {
        return array(array(), array());
    }

    $founded_rates = $new_methods = array();
    foreach ($rates as $rate) {
        $is_found = false;

        // Try to find known method
        foreach ($dhl_methods as $sm) {
            if ($rate['service-code'] == $sm['subcode']) {
                $is_found = true;

                $founded_rate = array(
                    'methodid'           => $sm['subcode'],
                    'rate'               => $rate['price'],
                );

                if (!empty($rate['expected-transit-time'])) {
                    $founded_rate['shipping_time'] = $rate['expected-transit-time'];
                }

                $founded_rates[] = $founded_rate;

                break;
            }
        }

        if (!$is_found) {
            $new_methods[] = $rate;
        }

    }

    return array($founded_rates, $new_methods);
} // }}}

class XC_DHL_Options extends XC_Singleton { // {{{

    const ENABLE_NEW_METHODS = 'new_method_is_enabled';

    const DHL_TEST_MODE    = 'DHL_TEST_MODE';
    const DHL_PRODUCTION_MODE = 'DHL_PRODUCTION_MODE';

    const DHL_OPTION_DISABLED = 'disabled';

    const DHL_CAPABILITY_REQUEST = 'GetCapability';
    const DHL_QUOTE_REQUEST = 'GetQuote';

    private $params;

    // Packing limits (in kg and cm)
    protected $packing_limits = array (
        'COY' => array('weight' => 31.5, 'width' => 60, 'length' => 60, 'height' => 120),
        'PAL' => array('weight' => 1000),
        'DBL' => array('weight' => 1000),
        'BOX' => array('weight' => 70),
    );

    protected function getQualifier($value, $price)
    { // {{{
        if ($value == self::DHL_OPTION_DISABLED) {
            return $value;
        }

        if (strpos($value, '%') === false) {
            $value_of_content = $value;
        } else {
            $value_of_content = $price * intval($value) / 100;
        }

        return $value_of_content;
    } // }}}

    protected function __construct()
    { // {{{
        // Call parent constructor
        parent::__construct();
        // Load params
        $this->params = $this->getAllParams();
    } // }}}

    public static function getInstance()
    { // {{{
        // Call parent getter
        return parent::getClassInstance(__CLASS__);
    } // }}}

    public function getDims()
    { // param06 {{{

        $tmp_dim = array();
        list($tmp_dim['length'], $tmp_dim['width'], $tmp_dim['height']) = explode(':', $this->params['param06']);
        $dim = array_map('doubleval', $tmp_dim);

        if (count(array_filter($dim)) == 3) {
            $dim['girth'] = func_girth($dim);
        } else {
            $dim['girth'] = 0;
        }

        return array($dim['length'], $dim['width'], $dim['height'], $dim['girth']); //common
    } // }}}

    public function getSpecifiedDims()
    { // {{{
        $specified_dims = array();
        list($specified_dims['length'], $specified_dims['width'], $specified_dims['height'], $specified_dims['girth']) = $this->getDims();

        return array_filter($specified_dims);
    } // }}}

    public function getMode()
    { // {{{
        global $config;
        // One of XC_DHL_Options::DHL_TEST_MODE, XC_DHL_Options::DHL_TEST_MODE
        return $config['Shipping']['DHL_testmode'] == 'Y'
               ? XC_DHL_Options::DHL_TEST_MODE
               : XC_DHL_Options::DHL_PRODUCTION_MODE;
    } // }}}

    public function getMaxWeight()
    { // param08 {{{
        return doubleval($this->params['param08']);// common
    } // }}}

    public function getPkgType()
    { // pkg_type {{{
        return $this->params['pkg_type'];
    } // }}}

    public function getCurrency()
    { // currency {{{
        return $this->params['currency'];
    } // }}}

    public function getCODValue($value)
    { // cod_value {{{
        return $this->getQualifier($this->params['cod_type'], $value);
    } // }}}

    public function getCODCurrency()
    { // cod_currency {{{
        return $this->getCurrency();
    } // }}}

    public function getInsuredValue($value)
    { // insured_value {{{
        return $this->getQualifier($this->params['insured_type'], $value);
    } // }}}

    public function getInsuredCurrency()
    { // insured_currency {{{
        return $this->getCurrency();
    } // }}}

    public function getDeclaredValue($value)
    { // insured_value {{{
        return $this->getQualifier($this->params['declared_type'], $value);
    } // }}}

    public function getDeclaredCurrency()
    { // insured_currency {{{
        return $this->getCurrency();
    } // }}}

    public function getAvailablePackages()
    { // {{{
        return array_keys($this->packing_limits);
    } // }}}

    public function getPackageLimits($package)
    { // {{{
        if (!empty($this->packing_limits[$package])) {
            return $this->packing_limits[$package];
        }
        return array();
    } // }}}

    public function getAllParams()
    { // $sql_tbl[shipping_options] {{{nolint
        global $config, $sql_tbl;
        static $all_params = array();

        if (empty($all_params)) {
            $all_params = func_query_first("SELECT * FROM $sql_tbl[shipping_options] WHERE carrier='DHL'");
            $all_params['ID'] = $config['Shipping']['DHL_id'];
            $all_params['ACCOUNT'] = $config['Shipping']['DHL_account'];
            $all_params['PASSWORD'] = $config['Shipping']['DHL_password'];
            $all_params['MODE'] = $this->getMode();

            $_params = @unserialize($all_params['param00']);
            if (!empty($_params)) {
                $all_params = array_merge($all_params, $_params);
            }
        }

        return $all_params;
    } // }}}

    public function isNewMethodEnabled()
    { // param01 {{{
        return $this->params['param01'] == XC_DHL_Options::ENABLE_NEW_METHODS;// common
    } // }}}

    public function useMaximumDimensions()
    { // param09 {{{
        return $this->params['param09'];// common
    } // }}}

    public function useMultiplePackages()
    { // param11 {{{
        return $this->params['param11'];// common
    } // }}}

    public function isConfigured()
    { // {{{
        $all_params = $this->getAllParams();

        return !empty($all_params['ID'])
               && !empty($all_params['ACCOUNT'])
               && !empty($all_params['PASSWORD']);
    } // }}}
} // }}}

class XC_DHL_Request extends XC_Singleton { // {{{

    const SHIPPING_PROVIDER_NAME = 'DHL';

    protected $baseUrl;
    protected $data;
    protected $httpMethod = 'POST';
    protected $ContentType = '';

    protected $printDebug;

    protected $baseCacheKey;
    protected $workCacheKey;

    protected $shippingOptions;

    protected $requestType;

    protected $mode;

    private $_baseTestUrl = 'https://xmlpitest-ea.dhl.com/XMLShippingServlet';
    private $_baseProductionUrl = 'https://xmlpi-ea.dhl.com/XMLShippingServlet';

    public static function getInstance()
    { // {{{
        // Call parent getter
        return parent::getClassInstance(__CLASS__);
    } // }}}

    /**
     * Set mode (XC_DHL_Options::DHL_TEST_MODE,
     *           XC_DHL_Options::DHL_PRODUCTION_MODE)
     *
     * @param const $mode
     */
    public function setMode($mode = XC_DHL_Options::DHL_TEST_MODE)
    { // {{{
        switch ($mode) {
            case XC_DHL_Options::DHL_TEST_MODE: $this->baseUrl = $this->_baseTestUrl;
                break;
            case XC_DHL_Options::DHL_PRODUCTION_MODE: $this->baseUrl = $this->_baseProductionUrl;
                break;
        }
        $this->mode = $mode;
    } // }}}

    /**
     * Set print debug flag
     *
     * @param boolean $boolean
     */
    public function setPrintDebug($boolean)
    { // {{{
        $this->printDebug = $boolean;
    } // }}}

    /**
     * Constructor
     */
    protected function __construct()
    { // {{{
        // Call parent constructor
        parent::__construct();
        // Load configuration options from DB
        $this->shippingOptions = XC_DHL_Options::getInstance()->getAllParams();
        // Set Cache Keys
        $this->workCacheKey = $this->baseCacheKey = md5(serialize($this->shippingOptions));
        // Set proper working mode
        $this->setMode(XC_DHL_Options::getInstance()->getMode());
        // Enable caching for func_make_request_DHL function
        func_register_cache_function('func_make_request_DHL', array('class' => __CLASS__, 'dir' => 'shipping_DHL_cache'));
    } // }}}

    protected function getBkgDetails($requestData, $isDutiable = 'N')
    { // {{{
        $dateXML = date('Y-m-d');

        $CODValue = XC_DHL_Options::getInstance()->getCODValue($requestData['pack']['price']);
        $CODCurrency = XC_DHL_Options::getInstance()->getCODCurrency();

        $CODXML = '';
        if ($CODValue !== XC_DHL_Options::DHL_OPTION_DISABLED && $this->requestType === XC_DHL_Options::DHL_QUOTE_REQUEST) {
            $CODXML .= "<CODAmount>{$CODValue}</CODAmount>\n";
            $CODXML .= "<CODCurrencyCode>{$CODCurrency}</CODCurrencyCode>";
        }

        $InsuredValue = XC_DHL_Options::getInstance()->getInsuredValue($requestData['pack']['price']);
        $InsuredCurrency = XC_DHL_Options::getInstance()->getInsuredCurrency();

        $InsuredXML = '';
        if ($InsuredValue !== XC_DHL_Options::DHL_OPTION_DISABLED) {
            $InsuredXML .= "<InsuredValue>{$InsuredValue}</InsuredValue>";
            $InsuredXML .= "<InsuredCurrency>{$InsuredCurrency}</InsuredCurrency>";
        }

        $BkgDetailsXML = // Prepare XML details
<<<BKGDETAILS
            <PaymentCountryCode>{$requestData['orig_address']['country']}</PaymentCountryCode>
            <Date>{$dateXML}</Date>
            <ReadyTime>PT9H</ReadyTime>
            <DimensionUnit>IN</DimensionUnit>
            <WeightUnit>LB</WeightUnit>
            <Pieces>
                <Piece>
                    <PieceID>1</PieceID>
                    <Height>{$requestData['pack']['height']}</Height>
                    <Depth>{$requestData['pack']['length']}</Depth>
                    <Width>{$requestData['pack']['width']}</Width>
                    <Weight>{$requestData['pack']['weight']}</Weight>
                </Piece>
            </Pieces>
            <PaymentAccountNumber>{$this->shippingOptions['ACCOUNT']}</PaymentAccountNumber>
            <IsDutiable>{$isDutiable}</IsDutiable>
            {$CODXML}
            {$InsuredXML}
BKGDETAILS;

        return $BkgDetailsXML;
    } // }}}

    protected function prepareRequestData($requestData)
    { // {{{
        $messageTime = date('Y-m-d\TH:i:sP');
        $messageReference = md5($messageTime);

        $siteID = $this->shippingOptions['ID'];
        $password = $this->shippingOptions['PASSWORD'];

        $DeclaredValue = XC_DHL_Options::getInstance()->getDeclaredValue($requestData['pack']['price']);
        $DeclaredCurrency = XC_DHL_Options::getInstance()->getDeclaredCurrency();

        $isDutiable = $DeclaredValue !== XC_DHL_Options::DHL_OPTION_DISABLED ? 'Y' : 'N';

        $FromXML = "<CountryCode>{$requestData['orig_address']['country']}</CountryCode>\n";

        if (!empty($requestData['orig_address']['zipcode'])) {
            $FromXML .= "<Postalcode>{$requestData['orig_address']['zipcode']}</Postalcode>\n";
        }
        if (!empty($requestData['orig_address']['city'])) {
            $FromXML .= "<City>{$requestData['orig_address']['city']}</City>\n";
        }

        // Convert pack values to inches and lbs used in request
        foreach (array('width', 'height', 'length', 'girth') as $_dim) {
            if (!empty($requestData['pack'][$_dim])) {
                $requestData['pack'][$_dim] = func_units_convert(func_dim_in_centimeters($requestData['pack'][$_dim]), 'cm', 'in', 3);
            }
        }
        if ($requestData['pack']['weight'] > 0) {
            $requestData['pack']['weight'] = func_units_convert(func_weight_in_grams($requestData['pack']['weight']), 'g', 'lbs', 3);
        }

        $BkgDetailsXML = $this->getBkgDetails($requestData, $isDutiable);

        $ToXML = "\n<CountryCode>{$requestData['dest_address']['country']}</CountryCode>";
        if (!empty($requestData['dest_address']['zipcode'])) {
            $ToXML .= "\n<Postalcode>{$requestData['dest_address']['zipcode']}</Postalcode>";
        }
        if (!empty($requestData['dest_address']['city'])) {
            $ToXML .= "\n<City>{$requestData['dest_address']['city']}</City>";
        }

        $dutiableXML = '';
        if ($isDutiable === 'Y') {
            $dutiableXML =
                '<Dutiable>' .
                    "<DeclaredCurrency>{$DeclaredCurrency}</DeclaredCurrency>" .
                    "<DeclaredValue>{$DeclaredValue}</DeclaredValue>" .
                '</Dutiable>';
        }

        $xmlRequest = // Prepare XML request
<<<XML_REQUEST
<?xml version="1.0" encoding="utf-8"?>
<req:DCTRequest xmlns:req="http://www.dhl.com">
  <{$this->requestType}>
    <Request>
      <ServiceHeader>
        <MessageTime>{$messageTime}</MessageTime>
        <MessageReference>{$messageReference}</MessageReference>
        <SiteID>{$siteID}</SiteID>
        <Password>{$password}</Password>
      </ServiceHeader>
    </Request>
    <From>
        {$FromXML}
    </From>
    <BkgDetails>
        {$BkgDetailsXML}
    </BkgDetails>
    <To>
        {$ToXML}
    </To>
    {$dutiableXML}
  </{$this->requestType}>
</req:DCTRequest>
XML_REQUEST;
        return $xmlRequest;
    } // }}}

    protected function prepareDataFromPackageInfo($shippingData)
    { // {{{
        return $shippingData;
    } // }}}

    protected function preProcessXML($xml)
    {
        $result1 = preg_replace('/(<SiteID>)(.*)(<\/SiteID>)/', '$1xxxxx$3', $xml);
        $result = preg_replace('/(<Password>)(.*)(<\/Password>)/', '$1xxxxx$3', $result1);

        return $result;
    }

    protected function func_make_request_DHL($request_params = array())
    { // {{{
        global $intershipper_error, $shipping_calc_service;

        $request_url = $url = $this->baseUrl; // Make request URL

        $this->workCacheKey = $this->baseCacheKey . md5($url . '|' . $this->requestType . '|' . serialize($request_params));

        if (($cacheData = func_get_cache_func($this->workCacheKey, 'func_make_request_DHL'))) {
            return $cacheData['data'];
        }

        $request_data = !empty($request_params) ? $this->prepareRequestData($request_params) : '';

        list($a, $result) = func_https_request(
            $this->httpMethod,
            $request_url,
            $request_data, // data
            '', // join
            '', // cookie
            $this->ContentType,
            '', // referer
            '', // cert
            '', // kcert
            ''  // headers
        );

        if (defined('XC_DHL_DEBUG') || $this->printDebug) {
            // Format request
            $formattedRequest = func_xml_format($this->preProcessXML($request_data));

            if ($this->printDebug) {
                // Display debug info
                $class = defined('X_PHP530_COMPAT') ? get_called_class().' ' : '';

                print "<h2>{$class}{$this->httpMethod} Request to $url &nbsp;&nbsp;&nbsp;&nbsp;{$this->ContentType}</h2>";
                print "<pre>".htmlspecialchars($formattedRequest)."</pre>";
                print "<h2>DHL Response</h2>";
                $result1 = preg_replace("/(>)(<[^\/])/", "\\1\n\\2", $result);
                $result2 = preg_replace("/(<\/[^>]+>)([^\n])/", "\\1\n\\2", $result1);

                // Format result
                $formattedResult = func_xml_format($this->preProcessXML($result2));

                print "<pre>".htmlspecialchars($formattedResult)."</pre>";
            }

            if (defined('XC_DHL_DEBUG')) {
                // Formatted results
                $formattedResult = func_xml_format($this->preProcessXML($result));
                // Save in logs
                x_log_add('dhl_requests', $this->httpMethod . "\n" . $url . "\n" . $formattedRequest . "\n" . $this->ContentType . "\n" . $a . "\n" . $formattedResult);
            }
        }

        assert('!empty($result) && preg_match("/HTTP\/.*\s*200\s*OK/i", $a) /* '.__METHOD__.': Some errors with HTTP request to DHL */');

        $is_success =  preg_match("/HTTP\/.*\s*200\s*OK/i", $a);

        // Parse XML reply
        $parse_error = false;
        $options = array(
            'XML_OPTION_CASE_FOLDING' => 1,
            'XML_OPTION_TARGET_ENCODING' => 'UTF-8'
        );

        $parsed = func_xml_parse($result, $parse_error, $options);

        $error_note = func_array_path($parsed, 'RES:DCTRESPONSE/#/' . strtoupper($this->requestType) . 'RESPONSE/0/NOTE/0/#/CONDITION/0/#');

        if (
            !$is_success
            || empty($parsed)
            || !empty($error_note)
        ) {
            if (!empty($parsed)) {

                if (!empty($error_note)) {
                    $dhl_error_code = func_array_path($error_note, 'CONDITIONCODE/0/#');
                    $dhl_error_note = func_array_path($error_note, 'CONDITIONDATA/0/#');
                    $error_message = $dhl_error_note . " (Error code: $dhl_error_code)";
                    // DHL returned an error
                    $intershipper_error = $error_message;
                    $shipping_calc_service = XC_DHL_Request::SHIPPING_PROVIDER_NAME;

                    x_log_flag('log_shipping_errors', 'SHIPPING', "DHL module error: " . $error_message . "\n", true);
                }

            } else {
                x_log_flag('log_shipping_errors', 'SHIPPING', "Unknown DHL module error: " . print_r($a, true) . print_r($result, true), true);
            }

            $parsed = '';
        }

        if ($is_success && !empty($parsed) && empty($error_note)) {
            func_save_cache_func($parsed, $this->workCacheKey, 'func_make_request_DHL');
        }

        return $parsed;
    } // }}}
} // }}}

class XC_DHL_DiscoverServices extends XC_DHL_Request { // {{{

    protected $requestType = XC_DHL_Options::DHL_CAPABILITY_REQUEST;

    protected function __construct()
    { // {{{
        // Call parent constructor
        parent::__construct();
    } // }}}

    public static function getInstance()
    { // {{{
        // Call parent getter
        return parent::getClassInstance(__CLASS__);
    } // }}}

    public function isDeliveryAvailable($countryCode)
    { // {{{
        static $countries_list = array();

        if (empty($countries_list)) {
            // X_PHP550_COMPAT {{{
            global $xcart_dir;
            require_once $xcart_dir . '/include/lib/Compability/array_column/array_column.php';
            // X_PHP550_COMPAT }}}

            // Get all countries
            $countries_list = array_column(XCDHLReferenceData::getAllCountries(), 'country_code');
        }

        // Check if the provided country is in the list
        return in_array($countryCode, $countries_list);
    } // }}}

    public function getAvailableServicesForPackage($packageInfo)
    { // {{{

        $available_services_list = array();

        // Get services
        $available_services = $this->func_make_request_DHL($packageInfo);

        $parced = func_array_path($available_services, 'RES:DCTRESPONSE/#/GETCAPABILITYRESPONSE/0/BKGDETAILS/0/#/QTDSHP');

        if (empty($available_services) || empty($parced)) {
            assert('FALSE /* '.__METHOD__.": Empty {$this->requestType}Response array for getAvailableServicesForPackage */");
            return array();
        }

        foreach ($parced as $available_service) { // {{{

            $code = func_array_path($available_service, '#/GLOBALPRODUCTCODE/0/#');
            $name = func_array_path($available_service, '#/PRODUCTSHORTNAME/0/#');

            if (!empty($code) && !empty($name)) { // {{{

                $array_keys = array_diff(
                    array_keys(func_array_path($available_service, '#')),
                    array(
                        'GLOBALPRODUCTCODE',
                        'PRODUCTSHORTNAME'
                    )
                );

                $available_services_list[$code] = array (
                    'code' => $code,
                    'name' => $name,
                );

                foreach ($array_keys as $key) {
                    $available_services_list[$code]['options'][$key] = func_array_path($available_service, '#/' . $key . '/0/#');
                }
            } // }}}
        } // }}}

        return $available_services_list;
    } // }}}

} // }}}

class XC_DHL_GetRates extends XC_DHL_Request { // {{{

    protected $requestType = XC_DHL_Options::DHL_QUOTE_REQUEST;

    protected function __construct()
    { // {{{
        // Call parent constructor
        parent::__construct();
    } // }}}

    protected function getBkgDetails($requestData, $isDutiable = 'N')
    { // {{{
        $BkgDetailsXML = parent::getBkgDetails($requestData, $isDutiable);

        $GlobalProductCode = $requestData['service_info']['code'];
        $LocalProductCode = $requestData['service_info']['options']['LOCALPRODUCTCODE'];

        $BkgDetailsXML .= // Prepare XML details
<<<BKGDETAILS
            <QtdShp>
                <GlobalProductCode>{$GlobalProductCode}</GlobalProductCode>
                <LocalProductCode>{$LocalProductCode}</LocalProductCode>
                <QtdShpExChrg>
                    <SpecialServiceType>DD</SpecialServiceType>
                </QtdShpExChrg>
            </QtdShp>
BKGDETAILS;

        return $BkgDetailsXML;
    } // }}}

    protected function getServiceRate($serviceInfo, $shippingInfo)
    { // {{{

        $service_rate_data = array();

        $shippingInfo['service_info'] = $serviceInfo;

        // Get services
        $rate_data = $this->func_make_request_DHL($shippingInfo);

        $parced = func_array_path($rate_data, "RES:DCTRESPONSE/#/GETQUOTERESPONSE/0/BKGDETAILS/0/#/QTDSHP/0");

        if (empty($rate_data) || empty($parced)) {
            assert('FALSE /* '.__METHOD__.": Empty {$this->requestType}Response array for getServiceRate */");
            return array();
        }

        $transit_time = intval(func_array_path($parced, '#/TOTALTRANSITDAYS/0/#'));

        $service_rate_data['service-code'] = func_array_path($parced, '#/GLOBALPRODUCTCODE/0/#');
        $service_rate_data['service-name'] = func_array_path($parced, '#/LOCALPRODUCTNAME/0/#');
        $service_rate_data['price'] = func_array_path($parced, '#/SHIPPINGCHARGE/0/#');

        $service_rate_data['expected-transit-time'] = $transit_time > 1 ? $transit_time . ' days' : $transit_time . ' day';

        return $service_rate_data;
    } // }}}

    public static function getInstance()
    { // {{{
        // Call parent getter
        return parent::getClassInstance(__CLASS__);
    } // }}}

    public function getRates($shippingData)
    { // {{{

        $available_rates = array();

        $available_services = XC_DHL_DiscoverServices::getInstance()->getAvailableServicesForPackage($shippingData);

        foreach($available_services as $serviceInfo) {

            $rateInfo = $this->getServiceRate($serviceInfo, $shippingData);

            if (!empty($rateInfo) && $rateInfo['price'] > 0) {
                $available_rates[] = $rateInfo;
            }
        }

        return $available_rates;

    } // }}}
} // }}}
