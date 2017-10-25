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
 * VAT number checking functions
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v23 (xcart_4_7_7), 2017-01-23 20:12:10, class.VatNumberChecker.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../"); die("Access denied"); }

x_load('soap');

/**
 * Tax number checker interface
 */
interface AXCTaxNumberChecker { // {{{

    const VALID_TAX_NUMBER = 'valid';
    const INVALID_TAX_NUMBER = 'invalid';

    const NO_VALID_RESPONSE = 'no_response';

    public function getAllowedCountries();
    public function getCountryAliases();

    /**
     * Check if country allowed
     *
     * @param string $code
     *
     * @return boolean
     */
    public function isCountryAllowed($code);

    /**
     * Check if vat number is valid
     *
     * @param string $countryCode Country code
     * @param string $vatNumber   VAT number
     *
     * @return string (one of AXCTaxNumberChecker::VALID_TAX_NUMBER,
     *                        AXCTaxNumberChecker::INVALID_TAX_NUMBER,
     *                        AXCTaxNumberChecker::NO_VALID_RESPONSE)
     */
    public function isValid($countryCode, $vatNumber);

} // }}}

/**
 * The VIES VAT checker service
 *
 * @see http://ec.europa.eu/taxation_customs/vies/technicalInformation.html
 */
class XCViesVATChecker extends XC_SOAP_Service implements AXCTaxNumberChecker { // {{{

    protected function defineExceptionCodePath() { return 'faultcode'; }
    protected function defineExceptionDescriptionPath() { return 'faultstring'; }
    protected function defineProductionServer() {}
    protected function defineTestServer() {}
    protected function defineResponseCodePath() { return 'valid'; }
    protected function defineResponseDescriptionPath() { return 'countryCode'; }

    protected function defineValidResponseCodes() { // {{{
        return array();
    } // }}}

    protected function defineWsdlFile() { // {{{
        return 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';
    } // }}}

    public static function getInstance() { // {{{
        // Call parent getter
        return parent::getClassInstance(__CLASS__);
    } // }}}

    /**
     * @see AXCTaxNumberChecker::getAllowedCountries()
     */
    public function getAllowedCountries() { // {{{
        return array(
            'AT', 'BE', 'BG', 'CZ', 'CY',
            'DE', 'DK', 'EE', 'GR', 'ES',
            'FI', 'FR', 'GB', 'HR', 'HU',
            'IE', 'IT', 'LT', 'LU', 'LV',
            'MT', 'NL', 'PL', 'PT', 'RO',
            'SE', 'SI', 'SK',
        );
    } // }}}

    /**
     * @see AXCTaxNumberChecker::getCountryAliases()
     */
    public function getCountryAliases() { // {{{
        return array(
            'GR' => 'EL',
        );
    } // }}}

    /**
     * @see AXCTaxNumberChecker::isCountryAllowed()
     */
    public function isCountryAllowed($code) { // {{{
        if (
            in_array($code, $this->getAllowedCountries())
            || in_array($code, array_values($this->getCountryAliases()))
        ) {
            return true;
        }
        return false;
    } // }}}

    /**
     * @see AXCTaxNumberChecker::isValid()
     */
    public function isValid($countryCode, $vatNumber) { // {{{

        $result = AXCTaxNumberChecker::NO_VALID_RESPONSE;

        if ($countryCode && $vatNumber) {
            //
            // Constants to emulate valid response are not defined
            //
            if (
                defined('XC_VAT_NUMBER_CHECKER_DEBUG')
                && !defined('XC_SOAP_DEBUG')
            ) {
                // Enable SOAP debug if checker debug enabled
                define('XC_SOAP_DEBUG', true);
            }

            $aliases = $this->getCountryAliases();

            if (isset($aliases[$countryCode])) {
                $countryCode = $aliases[$countryCode];
            }

            $response = $this->processRequest(
                'checkVat',
                array(
                    'countryCode' => $countryCode,
                    'vatNumber' => $vatNumber,
                )
            );

            if (
                $response
                && is_object($response)
                && property_exists($response, 'valid')
            ) {
                switch ($response->valid) {
                    case true:
                        $result = AXCTaxNumberChecker::VALID_TAX_NUMBER;
                        break;
                    case false:
                        $result = AXCTaxNumberChecker::INVALID_TAX_NUMBER;
                        break;
                }
            }
        }

        return $result;
    } // }}}

} // }}}

/**
 * Check VAT number
 */
class XCVatNumberChecker extends XC_Singleton { // {{{

    protected function __construct() { // {{{
        // Call parent constructor
        parent::__construct();
        // Enable caching for checkVATnumber function
        func_register_cache_function('checkVATnumber',
            array(
                'class' => __CLASS__,
                'dir'   => 'vat_number_cache',
                'hashedDirectoryLevel' => 2,
            )
        );
    } // }}}

    protected function getValidationService() { // {{{
        // get validation service instance
        return XCViesVATChecker::getInstance();
    } // }}}

    public static function getInstance() { // {{{
        // Call parent getter
        return parent::getClassInstance(__CLASS__);
    } // }}}

    /**
     * Check if VAT has a country code with a number or not
     *
     * @param string $vatNumber
     *
     * @return mixed Returns false or array with parsed VAT data
     */
    public function hasCountryCodeInVAT($vatNumber) { // {{{

        $vatInfo = array();

        $_vatNumber = trim($vatNumber);

        // Check supplied VAT number format
        if (
            !is_numeric(substr($_vatNumber, 0, 1))  // check first symbol
            && !is_numeric(substr($_vatNumber, 1, 2))   // check second symbol
        ) {
            // Country code was supplied inside the VAT Number
            // Use country code from VAT Number
            $vatInfo['countryCode'] = trim(substr($_vatNumber, 0, 2));
            $vatInfo['vatNumber'] = trim(substr($_vatNumber, 2));
        }

        return !empty($vatInfo) ? $vatInfo : false;
    } // }}}

    /**
     * Check if VAT country is allowed or not
     *
     * @param string $countryCode
     *
     * @return boolean
     */
    public function isCountryAllowed($countryCode) { // {{{

        $service = $this->getValidationService(); // get service instance

        return $service && $service->isCountryAllowed($countryCode);

    } // }}}

    /**
     * Check if VAT number is valid
     *
     * @param string  $countryCode Country code
     * @param string  $vatNumber   VAT number
     *
     * @return string (one of AXCTaxNumberChecker::VALID_TAX_NUMBER,
     *                        AXCTaxNumberChecker::INVALID_TAX_NUMBER)
     */
    public function checkVATnumber($countryCode, $vatNumber) { // {{{
        global $check_vat_number_request_delay, $top_message, $config;

        $status = AXCTaxNumberChecker::INVALID_TAX_NUMBER; // initial value

        // Get VAT info
        $vatInfo = $this->hasCountryCodeInVAT($vatNumber);

        // Check if VAT has country code in it
        if (!empty($vatInfo)) {
            // Country code was supplied inside the VAT Number
            // Use country code from VAT Number
            $countryCode = $vatInfo['countryCode'];
            $vatNumber = $vatInfo['vatNumber'];
        }

        $cacheKey = md5($countryCode . $vatNumber); // cache key

        //
        // Define constants to emulate valid response
        // for debugging purpose
        //
        if (defined('XC_VAT_NUMBER_CHECKER_DEBUG')) {

            if (
                defined('XC_VAT_NUMBER_CHECKER_EMULATE_VALID')
                ||
                defined('XC_VAT_NUMBER_CHECKER_EMULATE_INVALID')
            ) {
                $status = defined('XC_VAT_NUMBER_CHECKER_EMULATE_VALID')
                    ? AXCTaxNumberChecker::VALID_TAX_NUMBER
                    : AXCTaxNumberChecker::INVALID_TAX_NUMBER;

                x_log_add(
                    'DEBUG',
                    'Service response emulation is enabled, defined constants:'
                    . "\n\t XC_VAT_NUMBER_CHECKER_DEBUG, XC_VAT_NUMBER_CHECKER_EMULATE_" . strtoupper($status)
                );

                return $status;
            }

            // Block cache update in debug mode
            if (!defined('BLOCK_DATA_CACHE_CHECKVATNUMBER')) {
                define('BLOCK_DATA_CACHE_CHECKVATNUMBER', true);
            }
        }

        $top_message['content'] = !empty($top_message['content']) ? $top_message['content'] : ''; // initial value

        x_session_register('check_vat_number_request_delay', 0);

        if ($check_vat_number_request_delay - XC_TIME > 0) {
            // Inform customer
            $top_message['content'] = func_get_langvar_by_name('txt_vat_number_checking_service_not_available', FALSE, FALSE, TRUE);
            $top_message['type']    = 'W';
            // Return default status
            switch ($config['Taxes']['tax_validation_exception']) {
                case XCTaxesDefs::TAX_SERVICE_DOWN_CONSIDER_TN_VALID:
                    $status = AXCTaxNumberChecker::VALID_TAX_NUMBER;
                    break;
                case XCTaxesDefs::TAX_SERVICE_DOWN_BLOCK_CHECKOUT:
                    $status = AXCTaxNumberChecker::VALID_TAX_NUMBER;
                    break;
                case XCTaxesDefs::TAX_SERVICE_DOWN_BLOCK_CHECKOUT:
                    $status = AXCTaxNumberChecker::NO_VALID_RESPONSE;
                    break;
            }
            return $status;
        }

        if (
            !defined('BLOCK_DATA_CACHE_CHECKVATNUMBER')
            && ($cacheData = func_get_cache_func($cacheKey, 'checkVATnumber'))
        ) {
            $cacheData = $cacheData['data'];
            // Inform customer
            $top_message['content'] = $cacheData !== AXCTaxNumberChecker::INVALID_TAX_NUMBER
                ? $top_message['content'] // keep original message
                : func_get_langvar_by_name('txt_vat_number_is_invalid', FALSE, FALSE, TRUE);

            // Return cached data
            return $cacheData;
        }

        if ($this->isCountryAllowed($countryCode)) {
            // get service instance
            $service = $this->getValidationService();
            // validate vat number
            $status = $service->isValid($countryCode, $vatNumber);

            if (
                !defined('BLOCK_DATA_CACHE_CHECKVATNUMBER')
                && $status == AXCTaxNumberChecker::NO_VALID_RESPONSE
            ) {
                // It seems service is dead, wait...
                $delay_in_min = 10;
                $check_vat_number_request_delay = XC_TIME + SECONDS_PER_MIN*$delay_in_min;
                // Inform customer
                $top_message['content'] = func_get_langvar_by_name('txt_vat_number_checking_service_not_available', FALSE, FALSE, TRUE);
            } else {
                // Valid response, cache the results
                $check_vat_number_request_delay = 0;
                // Save data in cache
                func_save_cache_func($status, $cacheKey, 'checkVATnumber');
                // Inform customer
                $top_message['content'] = $status !== AXCTaxNumberChecker::INVALID_TAX_NUMBER
                    ? $top_message['content'] // keep original message
                    : func_get_langvar_by_name('txt_vat_number_is_invalid', FALSE, FALSE, TRUE);
            }
        }

        return $status;
    } // }}}
} // }}}
