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
 * Classes for "Canada Post" shipping module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Michael Bugrov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v6 (xcart_4_7_7), 2017-01-24 09:29:34, class.CPC.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

namespace XCart\Shipping\CPC;

if ( !defined('XCART_START') ) { header("Location: ../"); die("Access denied"); }

/**
 * Require utils
 */
require_once $xcart_dir . '/include/classes/class.XCStringUtils.php';

/**
 * Canada Post config
 */
class Config { // {{{

    public $contract_id;
    public $customer_number;
    public $debug_enabled;
    public $developer_mode;
    public $password;
    public $quote_type;
    public $user;
    public $wizard_enabled;
    public $wizard_hash;

    public function __construct()
    { // {{{
        $this->load();
    } // }}}

    public function load()
    { // {{{
        global $config, $sql_tbl;

        $this->developer_mode = $config['CPC_testmode'] == 'Y';
        $this->password = $config['CPC_password'];
        $this->user = $config['CPC_username'];
        $this->wizard_enabled = $config['CPC_wizard_enabled'];
        $this->wizard_hash = $config['CPC_wizard_hash'];

        $params = func_query_first("SELECT * FROM $sql_tbl[shipping_options] WHERE carrier='CPC'");

        $this->contract_id = $params['param04'];
        $this->customer_number = $params['param03'];
        $this->quote_type = $params['param05'];

        $this->debug_enabled = defined('XC_CPC_DEBUG');
    } // }}}

    public function save()
    { // {{{
        global $sql_tbl;

        $developer_mode = $this->developer_mode ? 'Y' : 'N';

        db_query("UPDATE $sql_tbl[config] SET value = '{$developer_mode}' WHERE name='CPC_testmode'");
        db_query("UPDATE $sql_tbl[config] SET value = '{$this->password}' WHERE name='CPC_password'");
        db_query("UPDATE $sql_tbl[config] SET value = '{$this->user}' WHERE name='CPC_username'");
        db_query("UPDATE $sql_tbl[config] SET value = '{$this->wizard_enabled}' WHERE name='CPC_wizard_enabled'");
        db_query("UPDATE $sql_tbl[config] SET value = '{$this->wizard_hash}' WHERE name='CPC_wizard_hash'");

        db_query("UPDATE $sql_tbl[shipping_options]"
            . " SET param03 = '{$this->customer_number}',"
                . " param04 = '{$this->contract_id}',"
                . " param05 = '{$this->quote_type}'"
            . " WHERE carrier='CPC'");
    } // }}}

    public function getOptions()
    { // {{{
        return array_keys(get_object_vars($this));
    } // }}}

} // }}}

/**
 * Canada Post settings
 */
class Settings { // {{{

    /**
     * Token TTL is 10 minutes
     */
    const TOKEN_TTL = 600;

    /**
     * Check - is merchant registration wizard enabled or not
     *
     * @return boolean
     */
    public function isWizardEnabled()
    { // {{{
        global $config;

        return $config['CPC_wizard_enabled'] == 'Y';
    } // }}}

    /**
     * Get Canada Post merchant registration token
     *
     * @return string
     */
    public function getTokenId()
    { // {{{
        global $config;
        global $capost_token_id, $capost_token_ts, $capost_developer_mode;

        $token = null;

        x_session_register('capost_token_id');
        x_session_register('capost_token_ts');
        x_session_register('capost_developer_mode');

        if (!$this->isTokenValid()) {

            // Send request to Canada Post server to retrieve token
            $data = Platforms::getInstance()->callGetMerchantRegistrationToken();

            if (isset($data->token)) {

                $token = $data->token->tokenId;

                $capost_token_id = $token;
                $capost_token_ts = XC_TIME;
                $capost_developer_mode = $config['CPC_testmode'];

            } else {

                global $top_message;

                $top_message = array(
                    'type' => 'E',
                    'content' => func_get_langvar_by_name('err_cpc_failed_to_get_token_id')
                );
            }

        } else {

            // Get token from the session
            $token = $capost_token_id;
        }

        return $token;
    } // }}}

    /**
     * Returns true if token initialized and is not expired
     *
     * @return boolean
     */
    protected function isTokenValid()
    { // {{{
        global $config;
        global $capost_token_id, $capost_token_ts, $capost_developer_mode;

        x_session_register('capost_token_id');
        x_session_register('capost_token_ts');
        x_session_register('capost_developer_mode');

        return (
            !empty($capost_token_id)
            && static::TOKEN_TTL > XC_TIME - $capost_token_ts
            && $capost_developer_mode == $config['CPC_testmode']
        );
    } // }}}

    /**
     * Get Canada Post merchant registration URL
     *
     * @return string
     */
    public function getMerchantRegUrl()
    { // {{{
        return API::getInstance()->getMerchantRegUrl();
    } // }}}

    /**
     * Get X-Cart platform ID
     *
     * @return string
     */
    public function getPlatformId()
    { // {{{
        return API::getInstance()->getPlatformId();
    } // }}}

    /**
     * Get merchant registration wizard return URL
     *
     * @return string
     */
    public function getWizardReturnUrl()
    { // {{{
        global $xcart_catalogs;

        return $xcart_catalogs['admin'] . '/configuration.php';
    } // }}}

} // }}}

class Request { // {{{

    protected $endpoint;
    protected $headers = array();

    public $verb = 'POST';
    public $body = '';
    public $timeout = 100;

    public function __construct($endpoint)
    { // {{{

        if (!function_exists('func_https_request')) {
            x_load('http');
        }

        $this->endpoint = $endpoint;
    } // }}}

    public function setHeader($name, $value)
    { // {{{
        $this->headers[$name] = $value;
    } // }}}

    public function sendRequest()
    { // {{{

        $contentType = $this->headers['Content-Type'];

        $requestHeaders = $this->headers;
        unset($requestHeaders['Content-Type']);

        list($headers, $body) = func_https_request(
            $this->verb,
            $this->endpoint,
            $this->body,
            '&',    // join
            '',     // cookie
            $contentType,
            '',     // referer
            '',     // cert
            '',     // kcert
            $requestHeaders,
            $this->timeout
        );

        return (object) array(
                'headers' => $headers,
                'body' => $body
            );
    } // }}}

} // }}}

/**
 * XML converter
 */
class XML { // {{{

    /**
     * Convert parsed XML document
     *
     * @param string $parsedXml Parsed XMl document
     *
     * @return object
     */
    public static function convertParsedXmlDocument($parsedXml)
    { // {{{
        $elements = (object) array();

        foreach ($parsedXml['#'] as $field => $value) {

            $field = static::convertXmlFieldNameToCamelCase($field);

            if (static::isSingleXmlElem($value)) {

                // Simple element (final)
                $elements->{$field} = static::convertSingleXmlElem($value);

            } else if (static::isSimpleXmlElemsContainer($value)) {

                // Simple elements container
                $elements->{$field} = static::convertParsedXmlDocument($value[0]);

            } else if (static::isMultipleXmlElemsContainer($value)) {

                // Multiple elements container (list)
                $commonElemName = array_shift(array_keys($value[0]['#']));

                $subElements = array();

                foreach ($value[0]['#'][$commonElemName] as $subField => $subValue) {
                    $subElements[] = static::convertParsedXmlDocument($subValue);
                }

                $elements->{$field} = $subElements;
            }
        }

        return $elements;
    } // }}}

    /**
     * Convert single XML element into an object
     *
     * @param array $parsedXmlElem Parsed XML element data
     *
     * @return mixed
     */
    public static function convertSingleXmlElem($parsedXmlElem)
    { // {{{
        if (static::hasXmlElemAttrs($parsedXmlElem)) {

            $field = (object) array();

            $field->attrs = static::convertXmlElemAttrs($parsedXmlElem);
            $field->value = static::convertXmlElemValue($parsedXmlElem[0]['#']);

        } else {

            $field = static::convertXmlElemValue($parsedXmlElem[0]['#']);
        }

        return $field;
    } // }}}

    /**
     * Check - has a XML element attributes or not
     *
     * @param array $parsedXmlElem Parsed XML element data
     *
     * @return boolean
     */
    public static function hasXmlElemAttrs($parsedXmlElem)
    { // {{{
        return (
            isset($parsedXmlElem[0]['@'])
            && !empty($parsedXmlElem[0]['@'])
        );
    } // }}}

    /**
     * Convert XML element attributes to an object
     *
     * @param array $parsedXmlElem Parsed XML element data
     *
     * @return object
     */
    public static function convertXmlElemAttrs($parsedXmlElem)
    { // {{{
        $attrs = (object) array();

        foreach ($parsedXmlElem[0]['@'] as $attr => $value) {
            $attrs->{static::convertXmlFieldNameToCamelCase($attr)} = trim($value);
        }

        return $attrs;
    } // }}}

    /**
     * Convert XML element value
     *
     * @param string $value XML element value
     *
     * @return mixed
     */
    public static function convertXmlElemValue($value)
    { // {{{
        $_value = trim($value);

        if (
            is_string($_value)
            && ('true' === $_value || 'false' === $_value)
        ) {
            $_value = ('true' === $_value) ? true : false;
        }

        return $_value;
    } // }}}

    /**
     * Check - is XML element is multiple (similar) elements container or not
     *
     * @param array $parsedXmlElem Parsed XML element data
     *
     * @return bool
     */
    public function isMultipleXmlElemsContainer($parsedXmlElem)
    { // {{{
        return (
            is_array($parsedXmlElem[0]['#'])
            && 1 == count($parsedXmlElem[0]['#'])
        );
    } // }}}

    /**
     * Check - is XMl element is simple container or not
     *
     * @param array $parsedXmlElem Parsed XML element data
     *
     * @return boolean
     */
    public static function isSimpleXmlElemsContainer($parsedXmlElem)
    { // {{{
        return (
            is_array($parsedXmlElem[0]['#'])
            && 1 < count($parsedXmlElem[0]['#'])
        );
    } // }}}

    /**
     * Check - is XML element is single (final) element
     *
     * @param array $parsedXmlElem Parsed XML element data
     *
     * @return boolean
     */
    public static function isSingleXmlElem($parsedXmlElem)
    { // {{{
        return (
            is_string($parsedXmlElem[0]['#'])
            || !is_array($parsedXmlElem[0]['#'])
        );
    } // }}}

    /**
     * Convert XML fields and/or attributes names to camel case
     *
     * @param string $field XML field/attribute name
     *
     * @return string
     */
    public static function convertXmlFieldNameToCamelCase($field)
    { // {{{
        return lcfirst(\XCStringUtils::convertToCamelCase(str_replace('-', '_', $field)));
    } // }}}

} // }}}

/**
 * Canada Post API requests
 */
class API extends \XC_Singleton { // {{{

    public static function getInstance()
    { // {{{
        return parent::getClassInstance(__CLASS__);
    } // }}}

    /**
     * Quote types
     */
    const QUOTE_TYPE_CONTRACTED     = 'commercial';
    const QUOTE_TYPE_NON_CONTRACTED = 'counter';

    /**
     * Accept-language header possible values
     */
    const ACCEPT_LANGUAGE_EN = 'en-CA';
    const ACCEPT_LANGUAGE_FR = 'fr-CA';

    /**
     * Current configuration
     *
     * @var Config
     */
    protected static $configuration;

    /**
     * X-Cart Platform ID (PRODUCTION)
     *
     * @var string
     */
    protected $platformId = '8153498';

    /**
     * X-Cart Platform API Key (PRODUCTION)
     *
     * @var string
     */
    protected $platformAPIKey = '9ca7be0e2a7fabce:b6a0674e10c87e1071efef';

    /**
     * X-Cart Platform API Key (DEVELOPMENT)
     *
     * @var string
     */
    protected $platformAPIKeyDev = 'b708fc1055ebe56f:2586c599f43b8de0c07728';

    /**
     * Merchant registration URL (PRODUCTION)
     *
     * @var string
     */
    protected $merchantRegUrl = 'https://www.canadapost.ca/cpotools/apps/drc/merchant';

    /**
     * Merchant registration URL (DEVELOPMENT)
     *
     * @var string
     */
    protected $merchantRegUrlDev = 'https://www.canadapost.ca/cpotools/apps/drc/testMerchant';

    /**
     * Canada Post development host
     *
     * @var string
     */
    protected $developmentHost = 'ct.soa-gw.canadapost.ca';

    /**
     * Canada Post production host
     *
     * @var string
     */
    protected $productionHost = 'soa-gw.canadapost.ca';

    /**
     * Canada Post API Constructor
     */
    public function __construct()
    { // {{{
        if (!function_exists('func_xml_format')) {
            x_load('xml');
        }

        parent::__construct();
    } // }}}

    /**
     * Get Canada Post settings
     *
     * @return Config
     */
    public static function getCanadaPostConfig()
    { // {{{
        if (null === static::$configuration) {
            static::$configuration = new Config();
        }

        return static::$configuration;
    } // }}}

    /**
     * Check - is request should be made on behalf of a merchant
     *
     * @return boolean
     */
    public static function isOnBehalfOfAMerchant()
    { // {{{
        $wizardHash = static::getCanadaPostConfig()->wizard_hash;

        $result = false;

        if (!empty($wizardHash)
            && $wizardHash == md5(static::getCanadaPostConfig()->user . ':' . static::getCanadaPostConfig()->password)
        ) {
            $result = true;
        }

        return $result;
    } // }}}

    /**
     * Get Canada Post X-Cart Platform ID
     *
     * @return string
     */
    public function getPlatformId()
    { // {{{
        return $this->platformId;
    } // }}}

    /**
     * Get Canada Post API key
     *
     * @param boolean $isDevelopment Flag - is development mode or not (OPTIONAL)
     *
     * @return object
     */
    public function getCapostAPIkey($isDevelopment = false)
    { // {{{
        $capostAPIKey = ($isDevelopment) ? $this->platformAPIKeyDev : $this->platformAPIKey;

        $tmp = explode(':', $capostAPIKey);

        return (object) array(
            'user' => $tmp[0],
            'password' => $tmp[1],
        );
    } // }}}

    /**
     * Get accept language
     *
     * @return string
     */
    public function getAcceptLanguage()
    { // {{{
        return static::ACCEPT_LANGUAGE_EN;
    } // }}}

    // {{{ Canada Post API endpoints and hosts

    /**
     * Get Canada Post merchant registration URL
     *
     * @param boolean $isDevelopment Flag - is development mode or not
     *
     * @return string
     */
    public function getMerchantRegUrl($isDevelopment = null)
    { // {{{
        if (!isset($isDevelopment)) {
            $isDevelopment = static::getCanadaPostConfig()->developer_mode;
        }

        return ($isDevelopment) ? $this->merchantRegUrlDev : $this->merchantRegUrl;
    } // }}}

    /**
     * Get Canada Post API host
     *
     * @param boolean $isDevelopment Flag - is development mode or not
     *
     * @return string
     */
    public function getApiHost($isDevelopment = false)
    { // {{{
        return ($isDevelopment) ? $this->developmentHost : $this->productionHost;
    } // }}}

    // }}}

    /**
     * Prepare endpoint (add common data)
     *
     * @param string $endpoint URL template
     *
     * @return string
     */
    protected function prepareEndpoint($endpoint)
    { // {{{
        $mailedByCustomer = static::getCanadaPostConfig()->customer_number;

        if (static::isOnBehalfOfAMerchant()) {
            $mailedByCustomer .= '-' . $this->getPlatformId();
        }

        return str_replace(
            array(
                'XX',
                '{mailed by customer}',
                '{mobo}'
            ),
            array(
                $this->getApiHost(static::getCanadaPostConfig()->developer_mode),
                $mailedByCustomer,
                static::getCanadaPostConfig()->customer_number
            ),
            $endpoint
        );
    } // }}}

    /**
     * Check parsed XML document for API error messages
     *
     * @param array $parsedXml Parsed XML document
     *
     * @return array
     */
    protected function parseResponseErrors($parsedXml)
    { // {{{
        $errors = array();

        if (isset($parsedXml['messages'])) {
            // Collect error messages and codes
            $messages = func_array_path($parsedXml, 'messages/message');

            if (is_array($messages)
                && !empty($messages)
            ) {
                // Get errors from XML data
                foreach ($messages as $k => $v) {
                    $errors[] = $this->createErrorMessage(
                        func_array_path($v, 'code/0/#'),
                        func_array_path($v, 'description/0/#')
                    );
                }

            } else {
                // Unexpected error (when 'messages' element exists, but no 'message' elements were found)
                $errors[] = $this->createErrorMessage('UNEXP', 'An unexpected error occurred');
            }
        }

        return $errors;
    } // }}}

    /**
     * Create error message object
     *
     * @param string $code        Error code
     * @param string $description Error description
     *
     * @return object
     */
    protected function createErrorMessage($code, $description)
    { // {{{
        $message = (object) array();

        $message->code = (string) $code;
        $message->description = (string) $description;

        return $message;
    } // }}}

    /**
     * Save API call to the log file
     *
     * @param string $url          API endpoint
     * @param string $callName     Call name
     * @param string $requestData  Request XML
     * @param string $responseData Response XML
     *
     * @return void
     */
    public static function logApiCall($url, $callName, $requestData, $responseData)
    { // {{{
        x_log_add(
            'CPC',
            var_export(
                array(
                    'Request URL' => $url,
                    'Request XML (' . $callName . ')' => $requestData,
                    'Response XML' => func_xml_format($responseData),
                ),
                true
            )
        );
    } // }}}

} // }}}

/**
 * Implementation of the Canada Post's "E-commerce Platforms" service
 *
 * @see https://www.canadapost.ca/cpo/mc/business/productsservices/developers/services/ecomplatforms/default.jsf
 *
 */
class Platforms extends API { // {{{

    public static function getInstance()
    { // {{{
        return parent::getClassInstance(__CLASS__);
    } // }}}

    /**
     * Merchant registration statuses
     */
    const REG_STATUS_SUCCESS             = 'SUCCESS';
    const REG_STATUS_CANCELLED           = 'CANCELLED';
    const REG_STATUS_BAD_REQUEST         = 'BAD_REQUEST';
    const REG_STATUS_UNEXPECTED_ERROR    = 'UNEXPECTED_ERROR';
    const REG_STATUS_UNAUTHORIZED        = 'UNAUTHORIZED';
    const REG_STATUS_SERVICE_UNAVAILABLE = 'SERVICE_UNAVAILABLE';

    // {{{ Endpoints

    /**
     * Canada Post "Get Merchant Registration Token" URL template
     *
     * @var string
     */
    protected $getMerchantRegTokenEndpoint = 'https://XX/ot/token';

    /**
     * Canada Post "Get Merchant Registration Info" URL template
     *
     * @var string
     */
    protected $getMerchantRegInfoEndpoint = 'https://XX/ot/token/{token-id}';

    /**
     * Get "Get Merchant Registration Token" request endpoint
     *
     * @return string
     */
    public function getGetMerchantRegTokenEndpoint()
    { // {{{
        return $this->prepareEndpoint($this->getMerchantRegTokenEndpoint);
    } // }}}

    /**
     * Get "Get Merchant Registration Info" request endpoint
     *
     * @param string $token Token
     *
     * @return string
     */
    public function getGetMerchantRegInfoEndpoint($token)
    { // {{{
        $endpoint = $this->prepareEndpoint($this->getMerchantRegInfoEndpoint);

        return str_replace('{token-id}', $token, $endpoint);
    } // }}}

    // }}}

    // {{{ "Get Merchant Registration Token" call

    /**
     * Call "Get Merchant Registration Token" request
     *
     * Reason to Call:
     * To get a unique registration token that is used to launch a merchant into the Canada Post sign-up process.
     *
     * @return object
     */
    public function callGetMerchantRegistrationToken()
    { // {{{
        $endpoint = $this->getGetMerchantRegTokenEndpoint();

        $capostAPIKey = $this->getCapostAPIkey(static::getCanadaPostConfig()->developer_mode);

        $result = (object) array();

        try {

            $request = new Request($endpoint);
            $request->verb = 'POST';
            $request->body = ' ';
            $request->setHeader('Authorization', 'Basic ' . base64_encode($capostAPIKey->user . ':' . $capostAPIKey->password));
            $request->setHeader('Accept', 'application/vnd.cpc.registration+xml');
            $request->setHeader('Content-Type', 'application/vnd.cpc.registration+xml');
            $request->setHeader('Accept-language', $this->getAcceptLanguage());

            if (static::isOnBehalfOfAMerchant()) {
                $request->setHeader('Platform-id', $this->getPlatformId());
            }

            $response = $request->sendRequest();

            if (
                isset($response->body)
                && !empty($response->body)
            ) {
                // Parse response to object
                $result = $this->parseResponseGetMerchantRegistrationToken($response->body);

            } else {

                // Register request error
                $errorMessage = $this->createErrorMessage(
                    'INTERNAL',
                    sprintf(
                        'Error while connecting to the Canada Post host (%s) during "Get Merchant Registration Token" request',
                        $endpoint
                    )
                );

                $result->errors = array($errorMessage);
            }

            if (static::getCanadaPostConfig()->debug_enabled) {
                // Save debug log
                static::logApiCall($endpoint, 'Get Merchant Registration Token', '', $response->body);
            }

        } catch (\Exception $e) {

            // Register exception error
            $errorMessage = $this->createErrorMessage($this->getCode(), $this->getMessage());

            $result->errors = array_merge((array) $result->errors, array($errorMessage));
        }

        return $result;
    } // }}}

    /**
     * Parse response of the "Get Merchant Registration Token" call
     *
     * @param string $responseXml Response XML data
     *
     * @return object
     */
    protected function parseResponseGetMerchantRegistrationToken($responseXml)
    { // {{{
        $result = (object) array();
        $err = null;

        // Parse XML document
        $xmlParsed = func_xml_parse($responseXml, $err);

        if (isset($xmlParsed['messages'])) {

            // Collect API error messages (using common method)
            $result->errors = $this->parseResponseErrors($xmlParsed);

        } else if (isset($xmlParsed['token'])) {

            // Collect returned data from "Get Merchant Registration Token" call
            $result->token = XML::convertParsedXmlDocument($xmlParsed['token']);
        }

        return $result;
    } // }}}

    // }}}

    // {{{ "Get Merchant Registration Info" call

    /**
     * Call "Get Merchant Registration Info" request by the token ID
     *
     * @param string $token Token ID
     *
     * @return object
     */
    public function callGetMerchantRegistrationInfoByToken($token)
    { // {{{
        $endpoint = $this->getGetMerchantRegInfoEndpoint($token);

        return $this->callGetMerchantRegistrationInfo($endpoint);
    } // }}}

    /**
     * Call "Get Merchant Registration Info" request
     *
     * Reason to Call:
     * Called by the e-commerce platform after the merchant has completed the Canada Post sign-up process
     *
     * @param string $endpoint Service endpoint (URL)
     *
     * @return object
     */
    protected function callGetMerchantRegistrationInfo($endpoint)
    { // {{{
        $capostAPIKey = $this->getCapostAPIkey(static::getCanadaPostConfig()->developer_mode);

        $result = (object) array();

        try {

            $request = new Request($endpoint);
            $request->verb = 'GET';
            $request->setHeader('Authorization', 'Basic ' . base64_encode($capostAPIKey->user . ':' . $capostAPIKey->password));
            $request->setHeader('Accept', 'application/vnd.cpc.registration+xml');
            $request->setHeader('Content-Type', 'application/vnd.cpc.registration+xml');
            $request->setHeader('Accept-language', $this->getAcceptLanguage());

            if (static::isOnBehalfOfAMerchant()) {
                $request->setHeader('Platform-id', $this->getPlatformId());
            }

            $response = $request->sendRequest();

            if (
                isset($response->body)
                && !empty($response->body)
            ) {
                // Parse response to object
                $result = $this->parseResponseGetMerchantRegistrationInfo($response->body);

            } else {

                // Register request error
                $errorMessage = $this->createErrorMessage(
                    'INTERNAL',
                    sprintf(
                        'Error while connecting to the Canada Post host (%s) during "Get Merchant Registration Info" request',
                        $endpoint
                    )
                );

                $result->errors = array($errorMessage);
            }

            if (static::getCanadaPostConfig()->debug_enabled) {
                // Save debug log
                static::logApiCall($endpoint, 'Get Merchant Registration Info', '', $response->body);
            }

        } catch (\Exception $e) {

            // Register exception error
            $errorMessage = $this->createErrorMessage($this->getCode(), $this->getMessage());

            $result->errors = array_merge((array) $result->errors, array($errorMessage));
        }

        return $result;
    } // }}}

    /**
     * Parse response of the "Get Merchant Registration Info" call
     *
     * @param string $responseXml Response XML data
     *
     * @return object
     */
    protected function parseResponseGetMerchantRegistrationInfo($responseXml)
    { // {{{
        $result = (object) array();
        $err = null;

        // Parse XML document
        $xmlParsed = func_xml_parse($responseXml, $err);

        if (isset($xmlParsed['messages'])) {

            // Collect API error messages (using common method)
            $result->errors = $this->parseResponseErrors($xmlParsed);

        } else if (isset($xmlParsed['merchant-info'])) {

            // Collect returned data from "Get Merchant Registration Info" call
            $result->merchantInfo = XML::convertParsedXmlDocument($xmlParsed['merchant-info']);
        }

        return $result;
    } // }}}

    // }}}

} // }}}

class Controller extends \XC_Singleton { // {{{

    public static function getInstance()
    { // {{{
        return parent::getClassInstance(__CLASS__);
    } // }}}

    /**
     * Validate return from Canada Post merchant registration process
     *
     * @return void
     */
    protected function validateMerchant()
    { // {{{
        global $top_message;
        global ${'token-id'}, ${'registration-status'};

        $token = ${'token-id'};
        $status = ${'registration-status'};

        if (Platforms::REG_STATUS_SUCCESS === $status) {
            // Registration is complete

            // Send request to Canada Post server to retrieve merchant details
            $data = Platforms::getInstance()->callGetMerchantRegistrationInfoByToken($token);

            if (isset($data->merchantInfo)) {
                // Update Canada Post settings
                $this->updateCapostMerchantSettings($data->merchantInfo);

                // Disable wizard
                $this->disableRegistrationWizard();

                $top_message = array(
                    'type' => 'I',
                    'content' => func_get_langvar_by_name('txt_cpc_registration_complete')
                );

            } else {
                $err = array_pop($data->errors);

                $top_message = array(
                    'type' => 'E',
                    'content' => 'ERROR: [' . $err->code . '] ' . $err->description
                );
            }

        } else {
            // An error occurred

            if (Platforms::REG_STATUS_CANCELLED === $status) {

                $top_message = array(
                    'type' => 'W',
                    'content' => func_get_langvar_by_name('txt_cpc_registration_canceled')
                );

            } else {

                $top_message = array(
                    'type' => 'E',
                    'content' => func_get_langvar_by_name('txt_cpc_registration_failed')
                );
            }
        }

        // Remove token from the session
        global $capost_token_id, $capost_token_ts;

        x_session_register('capost_token_id');
        x_session_register('capost_token_ts');

        $capost_token_id = null;
        $capost_token_ts = null;

        // Redirect back to the Canada Post settings page
        func_header_location('configuration.php?option=Shipping');
    } // }}}

    /**
     * Enable Canada Post merchant registration wizard
     *
     * @return void
     */
    protected function enableRegistrationWizard()
    { // {{{
        global $sql_tbl;

        db_query("UPDATE $sql_tbl[config] SET value = 'Y' WHERE name = 'CPC_wizard_enabled'");

        // Redirect back to the Canada Post settings page
        func_header_location('configuration.php?option=Shipping');
    } // }}}

    /**
     * Disable Canada Post merchant registration wizard
     *
     * @return void
     */
    protected function disableRegistrationWizard()
    { // {{{
        global $sql_tbl;

        db_query("UPDATE $sql_tbl[config] SET value = 'N' WHERE name = 'CPC_wizard_enabled'");
    } // }}}

    /**
     * Update Canada Post merchant settings
     *
     * @param object $data Merchant new data
     *
     * @return void
     */
    protected function updateCapostMerchantSettings($data)
    { // {{{

        if (
            !isset($data->merchantUsername)
            && !isset($data->merchantPassword)
        ) {
            return;
        }

        $dataMapper = array (
            'contract_id' => 'contractNumber',
            'customer_number' => 'customerNumber',
            'user' => 'merchantUsername',
            'password' => 'merchantPassword',
            'wizard_hash' => 'wizardHash',
            'quote_type' => 'quoteType',
        );

        $data->wizardHash = md5($data->merchantUsername . ':' . $data->merchantPassword);

        // Determine quote type
        $data->quoteType = isset($data->contractNumber)
            ? API::QUOTE_TYPE_CONTRACTED
            : API::QUOTE_TYPE_NON_CONTRACTED;

        $config = new Config();
        $options = $config->getOptions();

        foreach ($options as $k => $o) {
            $config->$o = ( isset($dataMapper[$o], $data->{$dataMapper[$o]}) ) ? $data->{$dataMapper[$o]} : '';
        }

        $config->save();

    } // }}}

    /**
     * Check if registration status action
     *
     * @return boolean
     */
    protected function isRegistrationStatusAction()
    { // {{{
        global ${'token-id'}, ${'registration-status'};

        return (!empty(${'token-id'}) && !empty(${'registration-status'}));
    } // }}}

    /**
     * Check if enable wizard action
     *
     * @return boolean
     */
    protected function isWizardStatusAction()
    { // {{{
        global $action;

        return $action == 'CPC_enable_wizard';
    } // }}}

    /**
     * Process return request
     */
    public function processRequest()
    { // {{{
        if ($this->isRegistrationStatusAction()) {
            $this->validateMerchant();
            return;
        }

        if ($this->isWizardStatusAction()) {
            $this->enableRegistrationWizard();
            return;
        }
    } // }}}

} // }}}

Controller::getInstance()->processRequest();
