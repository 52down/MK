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
 * Functions related to the XMultiCurrency module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v26 (xcart_4_7_7), 2017-01-23 20:12:10, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }


/**
 * Get the list of allowed for selection currencies or only list of its codes (if $onlyCodes == TRUE)
 * 
 * @param boolean $onlyCodes If true then returns list of currency codes
 *  
 * @return array
 */
function func_mc_get_currencies($onlyCodes = FALSE, $all = FALSE)
{
    global $sql_tbl;

    static $mcCurrenciesList;

    $key = ($onlyCodes ? 'codes' : 'all') . ($all ? '-1' : '-0');

    if (!isset($mcCurrenciesList[$key])) {

        $cnd = '';

        if ($onlyCodes) {

            if (!$all) {
                $cnd = 'WHERE enabled = 1';
            }

            $currencies = func_query_column("SELECT code FROM $sql_tbl[mc_currencies] $cnd ORDER BY pos");

        } else {

            if (!$all) {
                $cnd = 'WHERE mc.enabled = 1';
            }

            $currencies = func_query("SELECT mc.*, c.*, IF(STRCMP(mc.symbol,''), mc.symbol, c.symbol) as symbol FROM $sql_tbl[mc_currencies] as mc INNER JOIN $sql_tbl[currencies] as c ON mc.code = c.code $cnd ORDER BY mc.pos");
        }

        $mcCurrenciesList[$key] = $currencies;
    }

    return $mcCurrenciesList[$key];
}

/**
 * Get the list of stored currency rates
 * 
 * @return array
 */
function func_mc_get_currency_rates()
{
    global $sql_tbl;

    static $mcCurrencyRates;

    if (!isset($mcCurrencyRates)) {
        $mcCurrencyRates = func_query_hash("SELECT code, rate FROM $sql_tbl[mc_currencies]", 'code', FALSE, TRUE);
    }

    return $mcCurrencyRates;
}

/**
 * Get storefront default currency code
 *
 * @return string
 */
function func_mc_get_default_currency()
{
    global $config;

    $defaultCurrencyCode = (!empty($config['mc_default_currency'])) ? $config['mc_default_currency'] : '';

    if (!func_mc_valid_currency($defaultCurrencyCode)) {
        $defaultCurrencyCode = func_mc_get_primary_currency();
    }

    return $defaultCurrencyCode;
}

/**
 * Get the primary currency code
 * 
 * @return string
 */
function func_mc_get_primary_currency()
{
    global $sql_tbl;

    static $mcPrimaryCode;

    if (!isset($mcPrimaryCode)) {
        $mcPrimaryCode = func_query_first_cell("SELECT code FROM $sql_tbl[mc_currencies] WHERE is_default = 1 LIMIT 1");
    }

    return $mcPrimaryCode;
}

/**
 * Get the currency data
 * 
 * @param string $code Code of currency
 *  
 * @return array
 */
function func_mc_get_currency($code)
{
    $currency = NULL;

    if (func_mc_need_rate_update()) {
        if (func_mc_update_rates()) {
            func_mc_update_config('mc_autoupdate_last_time', XC_TIME);
        }
    }

    $currencies = func_mc_get_currencies();

    foreach ($currencies as $k => $v) {
        if ($v['code'] == $code) {
            $currency = $v;
            break;
        }
    }

    return $currency;
}

/**
 * Return TRUE if currency code is valid
 * 
 * @param string $code Code of currency
 *  
 * @return array
 */
function func_mc_valid_currency($code)
{
    $currencies = func_mc_get_currencies(TRUE);

    return in_array($code, $currencies);
}

/**
 * Get the stored array of last updated rates 
 * Format:
 *  array(<currency_code> => array(
 *          'date'    => (integer)Timestamp,
 *          'service' => (string)Service name
 *      )
 *  )
 *
 * @return array
 */
function func_mc_get_updated_rates_option()
{
    global $config;

    if (!empty($config['mc_updated_rates'])) {
        $updatedRates = unserialize($config['mc_updated_rates']);
    }

    if (!isset($updatedRates) || !is_array($updatedRates)) {
        $updatedRates = array();
    }

    return $updatedRates;
}

/**
 * Performs updatee of currency rates by specified online service.
 * Returns true on successfull and false otherwise.
 *
 * @param boolean $checkTTL If true then TTL must be checked before updating of rate
 * @param string  $service  Online service name
 *
 * @return boolean
 */
function func_mc_update_rates($checkTTL = FALSE, $service = NULL)
{
    global $xcart_dir, $sql_tbl, $config, $mc_log_rates_update;

    $result = TRUE;

    // If service name is not specified then get it from stored option (last used)
    if (!isset($service)) {
        $service = $config['mc_online_service'];
    }

    // Prepare the module file name
    $moduleFileName = $xcart_dir . '/modules/XMultiCurrency/mod_' . strtolower($service) . '.php';

    if (!file_exists($moduleFileName)) {
        return FALSE;
    }
 
    include_once $moduleFileName;

    // Get an array of last updated rates
    $updatedRates = func_mc_get_updated_rates_option();

    // Calculate start time in microseconds
    $startTime = func_mc_gettime();

    // Create service module object
    $serviceObj = new OnlineCurrencyRates();

    // Get the list of allowed for selection currencies
    $currencies = func_mc_get_currencies(TRUE);

    // Get the primary currency code
    $primaryCurrency = func_mc_get_primary_currency();

    foreach ($currencies as $code) {

        if ($code == $primaryCurrency) {
            // Ignore primary currency (its rate is always = 1)
            continue;
        }

        if (!$checkTTL || empty($updatedRates[$code]) || func_mc_check_ttl($updatedRates[$code]['date'])) {

            // Get currency rate
            $rate = $serviceObj->getRate($primaryCurrency, $code);

            if (!empty($rate)) {

                // Update stored currency rate
                db_query("UPDATE $sql_tbl[mc_currencies] SET rate = $rate WHERE code = '$code'");

                // Update the record about this update
                $updatedRates[$code] = array(
                    'date'    => XC_TIME,
                    'service' => $service,
                );

                if ($mc_log_rates_update) {
                    // Log info about this update
                    x_log_add('CURRENCY', sprintf('%s: Currency successfully updated (%s/%s = %f)', $service, $primaryCurrency, $code, $rate));
                }

            } else {
                // Failure to update rate: log this event 
                x_log_add('CURRENCY', sprintf('%s: Failure to update currency %s/%s', $service, $primaryCurrency, $code) . ($serviceObj->getError() ? ' (' . $serviceObj->getError() . ')' : ''));
                $result = FALSE;
            }
        }
    }

    // Calculate the finish time
    $endTime = func_mc_gettime();

    // Save array of last updated rates
    func_mc_update_config('mc_updated_rates', serialize($updatedRates));

    // Save the time of update
    func_mc_update_config('mc_update_time', round($endTime - $startTime, 3));

    // Save the date of update
    func_mc_update_config('mc_rates_last_updated_date', XC_TIME);

    // Save the last used service
    func_mc_update_config('mc_rates_last_updated_metod', $service);

    return $result;
}

/**
 * Check TTL of rate and return true if TTL is expired and rate should be updated
 *
 * @param integer $lastUpdateTime Timestamp of the date when rate was updated last time
 *
 * @return boolean
 */
function func_mc_check_ttl($lastUpdateTime)
{
    global $config;

    $result = TRUE;

    if (!empty($config['mc_autoupdate_time']) && preg_match('/(\d\d):(\d\d)/', $config['mc_autoupdate_time'], $match)) {

        $lastUpdateTime = intval($lastUpdateTime);

        // Get scheduled update time for current day
        $scheduledUpdateTime = mktime(
            intval($match[1]),
            intval($match[2]),
            0
        );

        if (XC_TIME >= $scheduledUpdateTime) {
            // Return true if last update time is before scheduled update time 
            $result = ($lastUpdateTime < $scheduledUpdateTime);

        } else {
            // Return true if last update time is before previous scheduled update time
            $prevScheduledUpdateTime = mktime(
                intval($match[1]),
                intval($match[2]),
                0,
                date('n'),
                date('j') - 1
            );

            $result = ($lastUpdateTime < $prevScheduledUpdateTime);
        }
    }

    return $result;
}

/**
 * Update XMultiCurrency module option value
 *
 * @param string $optionName Option name
 * @param mixed  $value      Option value
 */
function func_mc_update_config($optionName, $value)
{
    global $sql_tbl, $config;

    func_array2insert(
        'config',
        array(
            'name'     => $optionName,
            'category' => '',
            'value'    => $value,
        ),
        TRUE
    );
}

/**
 * Get current microtime
 *
 * @return float
 */
function func_mc_gettime()
{
    list($usec, $sec) = explode(' ', microtime());

    return ((float)$usec + (float)$sec);
}

/**
 * Returns true if alter currency value shoud be displayed on the requested page
 *
 * @return boolean
 */
function func_mc_is_alter_currency_display()
{
    $result = FALSE;

    $uri = $_SERVER['REQUEST_URI'];

    $allowedURIs = array(
        'cart.php',
        'cart.php?mode=checkout',
        'cart.php?mode=order_message',
        'get_block.php?block=opc_totals',
    );

    foreach ($allowedURIs as $pattern) {
        if (preg_match('/' . preg_quote($pattern) . '/', $uri)) {
            $result = TRUE;
            break;
        }
    }

    return $result;
}

/**
 * Get list of available countries
 *
 * @return array
 */
function func_mc_get_countries($forceCurrencyDependance = FALSE)
{
    global $xcart_dir, $sql_tbl, $config, $shop_language, $smarty;

    static $mcCountriesList;

    $key = ($forceCurrencyDependance || $config['mc_use_custom_countries_list'] == 'Y') ? 'All' : 'Custom';

    if (!isset($mcCountriesList[$key])) {

        $result = array();

        if (file_exists($xcart_dir . '/include/countries.php')) {
            include_once $xcart_dir . '/include/countries.php';
        } else {
            return FALSE;
        }

        
        $excludedCountries = FALSE;

        if ($forceCurrencyDependance || $config['mc_use_custom_countries_list'] == 'Y') {

            $excludedCountries = unserialize($config['mc_excluded_countries_list']);

            if (!is_array($excludedCountries)) {
                $excludedCountries = array();
            }
        }

        if (!empty($countries)) {

            // Get all available currencies and related countries
            $availCurrencyCodes = func_query_hash("SELECT cc.country_code, mc.code as currency_code FROM $sql_tbl[country_currencies] as cc, $sql_tbl[mc_currencies] as mc WHERE mc.code = cc.code", 'country_code', FALSE, TRUE);

            foreach ($countries as $country) {

                if (($forceCurrencyDependance || $config['mc_use_custom_countries_list'] == 'Y') && !in_array($country['country_code'], array_keys($availCurrencyCodes))) {
                    continue;
                }

                // Set up currency code and language code related to the country code
                if (isset($availCurrencyCodes[$country['country_code']])) {
                    $country['currency_code'] = $availCurrencyCodes[$country['country_code']];
                }
                $country['language_code'] = func_mc_get_country_language($country['country_code']);

                if ($excludedCountries) {
                    // Set up 'excluded' flag
                    $country['excluded'] = (FALSE !== array_search($country['country_code'], $excludedCountries));
                }

                $result[] = $country;
            }
        }

        $mcCountriesList[$key] = $result;
    }

    return $mcCountriesList[$key];
}

/**
 * Check if specified country code is in the allowed countries list
 *
 * @param string $countryCode Country code
 *
 * @return boolean
 */
function func_mc_valid_country($countryCode)
{
    $result = FALSE;

    $countries = func_mc_get_countries();

    foreach ($countries as $country) {
        if ($countryCode == $country['country_code'])  {
            $result = TRUE;
            break;
        }
    }

    return $result;
}

/**
 * Detect current visitor's country by IP address
 * Returns array of country code, currency code and language code which are linked to the detected country
 *
 * @return array
 */
function func_mc_get_country_by_ip()
{
    global $sql_tbl, $config, $CLIENT_IP;

    $address = array('country_code' => '');

    if ($config['mc_geoip_service'] == 'freegeoip') {
        $address = func_get_address_by_ip($CLIENT_IP);
    } elseif ($config['mc_geoip_service'] == 'maxmind_free') {
        $address['country_code'] = func_mc_maxmind_get_country_by_ip($CLIENT_IP);
    }

    // Validate country code
    if (
        empty($address['country_code']) 
        || !func_mc_valid_country($address['country_code'])
    ) {
        // If country is not detected initialize it with the default country value
        $countryCode = $config['General']['default_country'];    
    } else {
        $countryCode = $address['country_code'];
    }

    return array(
        $countryCode,
        func_mc_get_currency_by_country($countryCode),
        func_mc_get_language_by_country($countryCode)
    );
}

/**
 * Get currency code by country code
 *
 * @param string $countryCode Country code
 *
 * @return string
 */
function func_mc_get_currency_by_country($countryCode)
{
    global $sql_tbl;

    $currencyCode = NULL;
    
    $availableCurrencies = func_mc_get_currencies(TRUE);

    if (!empty($availableCurrencies) && 1 < count($availableCurrencies)) {
        $currencyCnd = 'AND code IN ("' . implode('","', $availableCurrencies) . '")';

    } elseif (1 == count($availableCurrencies)) {
        $currencyCnd = 'AND code = "' . array_pop($availableCurrencies) . '"';

    } else {
        $currencyCnd = '';
    }

    $currencies = func_query_column("SELECT code FROM $sql_tbl[country_currencies] WHERE country_code='$countryCode' $currencyCnd");

    if (!empty($currencies)) {
        if (in_array('EUR', $currencies))
            $currencyCode = 'EUR';
        elseif (in_array('USD', $currencies))
            $currencyCode = 'USD';
        else
            $currencyCode = array_pop($currencies);
    }

    return $currencyCode;
}

/**
 * Get language code by country code
 *
 * @param string $countryCode Country code
 *
 * @return string
 */
function func_mc_get_language_by_country($countryCode)
{
    global $sql_tbl;

    $languageCode = NULL;

    $availableLanguages = func_query_column("SELECT code FROM $sql_tbl[languages] GROUP BY code ORDER BY NULL");

    if (!empty($availableLanguages) && 1 < count($availableLanguages)) {
        $languageCnd = 'AND code IN ("' . implode('","', $availableLanguages) . '")';

    } elseif (1 == count($availableLanguages)) {
        $languageCnd = 'AND code = "' . array_pop($availableLanguages) . '"';

    } else {
        $languageCnd = '';
    }

    $languages = func_query_column("SELECT code FROM $sql_tbl[language_codes] WHERE country_code='$countryCode' AND disabled != 'Y' $languageCnd");

    if (!empty($languages)) {
        $languageCode = array_pop($languages);
    }

    return $languageCode;
}

/**
 * Smarty prefilter to replace standard language selector to the new one
 *
 * @param string $tpl_source The source of template
 * @param Smarty &$smarty    Reference to the Smarty object
 *
 * return string
 */
function x_mc_replace_languages_block($tpl_source, &$smarty)
{
    return (!defined('AREA_TYPE') || 'C' == constant('AREA_TYPE'))
        ? str_replace(
            '{include file="customer/language_selector.tpl"}',
            '{include file="modules/XMultiCurrency/customer/complex_selector.tpl"}',
            $tpl_source
        )
        : $tpl_source;
}

/**
 * Smarty prefilter to extend {currency...} functions with order's currency and rate and add a multicurrency note
 *
 * @param string $tpl_source The source of template
 * @param Smarty &$smarty    Reference to the Smarty object
 *
 * return string
 */
function x_mc_replace_order_total_block($tpl_source, &$smarty)
{
    if ('mail/html/order_data.tpl' == $smarty->template_resource) {

        $_addSmartyCode = <<<OUT
{if \$order.extra.mc_store_currency ne ""}
  {assign var="_mc_currency" value=\$order.extra.mc_store_currency}
  {if \$order.extra.mc_store_currency ne \$order.extra.mc_primary_currency}
    {assign var="_mc_currency_rate" value=\$order.extra.mc_store_currency_rate}
    {assign var="_mc_display_note" value=1}
  {else}
    {assign var="_mc_currency_rate" value=1}
  {/if}
{else}
{assign var="_mc_currency" value=\$primary_currency}
{assign var="_mc_currency_rate" value=1}
{/if}
OUT;
        $tpl_source = $_addSmartyCode . $tpl_source;

        $tpl_source = preg_replace(
            '/(\{currency value=)([^}]+)(\})/USsm',
            '\\1\\2 currency=\$_mc_currency currency_rate=\$_mc_currency_rate\\3',
            $tpl_source
        );

        $tpl_source = preg_replace(
            '/(' . preg_quote('{if $_userinfo.tax_exempt ne "Y"}') . ')/USs',
            '{if $order.extra.mc_store_currency ne "" and $order.extra.mc_store_currency ne $order.extra.mc_primary_currency}{include file="modules/XMultiCurrency/customer/order_total.tpl"}{/if}\\1',
            $tpl_source
        );

        $tpl_source .= '{include file="modules/XMultiCurrency/customer/currency_note_order.tpl"}';
    }

    return $tpl_source;
}

/**
 * Smarty prefilter to add currency notes on the cart, checkout and wish list pages
 *
 * @param string $tpl_source The source of template
 * @param Smarty &$smarty    Reference to the Smarty object
 *
 * return string
 */
function x_mc_replace_cart_subtotal_block($tpl_source, &$smarty)
{
    if (!defined('AREA_TYPE') || 'C' == constant('AREA_TYPE')) {

        if ('modules/Wishlist/wl_products.tpl' == $smarty->template_resource) {

            $tpl_source .= '{if $wl_products ne "" or ($active_modules.Gift_Certificates ne "" and $wl_giftcerts ne "")}{include file="modules/XMultiCurrency/customer/currency_note_wishlist.tpl"}{/if}';

        } elseif ('modules/One_Page_Checkout/opc_summary.tpl' == $smarty->template_resource) {

            $tpl_source = preg_replace(
                '/(\{include file="modules\/One_Page_Checkout\/summary\/cart_totals.tpl"\})/USs',
                '\\1{include file="modules/XMultiCurrency/customer/opc_currency_note.tpl"}',
                $tpl_source
            );

        } elseif ('customer/main/cart_totals.tpl' == $smarty->template_resource) {

            $tpl_source = preg_replace(
                '/(\{if \$not_logged_message eq "1"\})/USs',
                '{include file="modules/XMultiCurrency/customer/currency_note.tpl"}\\1',
                $tpl_source
            );

        } elseif ('customer/main/cart_subtotal.tpl' == $smarty->template_resource) {

            $tpl_source .= '{include file="modules/XMultiCurrency/customer/currency_note.tpl"}';
        }
    }

    return $tpl_source;
}

/**
 * Smarty prefilter to remove some options from General settings page
 *
 * @param string $tpl_source The source of template
 * @param Smarty &$smarty    Reference to the Smarty object
 *
 * return string
 */
function x_mc_remove_currency_options($tpl_source, &$smarty)
{
    if ('admin/main/configuration.tpl' == $smarty->template_resource) {
        $excludeOptions = array(
            'currency_symbol',
            'currency_format',
            'alter_currency_symbol',
            'alter_currency_format',
            'alter_currency_rate',
        );

        $_tmp = array();
        foreach ($excludeOptions as $optionName) {
            $_tmp[] = '$configuration[cat_num].name eq "' . $optionName . '"';
        }

        $tpl_source = preg_replace(
            '/(<tr id="tr_\{\$configuration\[cat_num\]\.name\}")>/USs',
            '\\1 {if ' . implode(' or ', $_tmp) . '}style="display: none;"{/if}>',
            $tpl_source
        );
    }

    return $tpl_source;
}


/**
 * Smarty plugin 'currency': converts an input number value to a currency value
 * Usage example: {currency value=10 currency="USD" currency_rate=1.35 precision=1 plain_text_message="Y" display_sign="Y" assign="varname"}
 * where
 *   value:              currency value
 *   currency:           currency code to force displaying
 *   currency_rate:      currency exchange rate
 *   precision:          ignore number format and display full value
 *   plain_text_message: strip tags
 *   display_sign:       display sign (+/-) of value
 *   assign:             variable name to assign result string
 *   ignore_format:      ignore format and display only converted value (without currency symbol)
 *
 * @param array $params   Array of input parameters
 * @param Smarty &$smarty Smarty object reference
 *
 * return string
 */
function x_mc_currency($params, $smarty)
{
    global $config, $store_currency; 

    if (!isset($params['value']))
        return '';


    if (defined('AREA_TYPE') && constant('AREA_TYPE') != 'C' && !defined('ADMIN_INVOICE')) {
        return $smarty->smarty->formatCurrency($params, $smarty);
    }

    $value = $params['value'];
    settype($value, 'float');

    $currency_code = !empty($params['currency']) ? $params['currency'] : $store_currency;

    $currency = func_mc_get_currency($currency_code);

    if (!isset($currency)) {
        $currency = array(
            'symbol' => $currency_code,
        );
        $currency['is_default'] = ($currency_code === $store_currency);
    }

    if (isset($params['currency_rate'])) {
        $currency['rate'] = $params['currency_rate'];
    }

    $value = $value * (isset($currency['rate']) && $currency['is_default'] < 1 && 0 < doubleval($currency['rate']) ? $currency['rate'] : 1);

    $currency_symbol = (!empty($currency['symbol']) ? $currency['symbol'] : $currency_code);
    $currency_format = (!empty($currency['format']) ? $currency['format'] : $config['General']['currency_format']);
    $number_format = (!empty($currency['number_format']) ? $currency['number_format'] : $config['Appearance']['number_format']);

    $precision = intval(substr($number_format, 0, 1));
    $thousand_delim = substr($number_format, 2, 1);
    $decimal_delim = substr($number_format, 1, 1);

    if (isset($params['ignore_format'])) {
        $params['plain_text_message'] = 'Y';
        $params['precision'] = 1;
        $currency_symbol = '';
        $currency_format = 'x';
    }

    $result = '';
    if (!isset($params['plain_text_message'])) {
        $result .= '<span class="currency">';
    }

    if (isset($params['display_sign'])) {
        if ($value >= 0 )
            $result .= '+';
        else    
            $result .= '-';
    }

    $cf_value = isset($params['precision']) ? $value : func_format_number(abs($value), $thousand_delim, $decimal_delim, $precision);

    if (
        isset($params['tag_id'])
        && !isset($params['plain_text_message'])
    ) {
        $cf_value = "<span id=\"$params[tag_id]\">$cf_value</span>";
    }

    $result .= str_replace('$', $currency_symbol , str_replace('x', $cf_value, $currency_format));

    if (!isset($params['plain_text_message'])) {
        $result .= '</span>';
    }

    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $result);
        $result = '';
    }

    return $result;
}

/**
 * Smarty plugin 'alter_currency': converts an input number value to a currency value
 * Usage example: {alter_currency value=10 currency="USD" no_brackets=1 plain_text_message="Y" display_sign="Y" assign="varname"}
 * where
 *   value:              currency value
 *   currency:           currency code to force displaying
 *   no_brackets:        do not add brackets around value
 *   plain_text_message: strip tags
 *   display_sign:       display sign (+/-) of value
 *   assign:             variable name to assign result string
 *
 * @param array $params   Array of input parameters
 * @param Smarty &$smarty Smarty object reference
 *
 * return string
 */
function x_mc_alter_currency($params, $smarty)
{
    global $config;

    if (!isset($params['value']))
        return '';

    if (defined('AREA_TYPE') && constant('AREA_TYPE') != 'C' && !defined('ADMIN_INVOICE')) {
        return $smarty->smarty->formatAlterCurrency($params, $smarty);
    }

    settype($params['value'], 'float');
    $value = $params['value'];

    $currency_code = isset($params['currency']) ? $params['currency'] : $config['General']['alter_currency_symbol'];

    if (empty($currency_code))
        return '';

    $currency = func_mc_get_currency($currency_code);

    if (!isset($currency)) {
        $currency = array(
            'symbol' => $currency_code,
        );
    }

    $currency_symbol = (!empty($currency['symbol']) ? $currency['symbol'] : $config['General']['alter_currency_symbol']);
    $currency_format = (!empty($currency['format']) ? $currency['format'] : $config['General']['alter_currency_format']);
    $number_format = (!empty($currency['number_format']) ? $currency['number_format'] : $config['Appearance']['number_format']);

    $precision = intval(substr($number_format, 0, 1));
    $thousand_delim = substr($number_format, 2, 1);
    $decimal_delim = substr($number_format, 1, 1);

    $result = '';

    if (!isset($params['plain_text_message'])) {
        $result .= '<span class="nowrap">';
    }
    
    if (isset($params['display_sign'])) {
        if ($value >= 0 )
            $result .= '+';
        else
            $result .= '-';
    }

    $cf_value = func_format_number(abs($value), $thousand_delim, $decimal_delim, $precision);

    if (
        isset($params['tag_id'])
        && !isset($params['plain_text_message'])
    ) {
        $cf_value = "<span id=\"$params[tag_id]\">$cf_value</span>";
    }

    $result .= str_replace('$', $currency_symbol , str_replace('x', $cf_value, $currency_format));

    if (!isset($params['plain_text_message'])) {
        $result .= '</span>';
    }

    if (!isset($params['no_brackets'])) {
        $result = '(' . $result . ')';
    }

    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $result);
        $result = '';
    }

    return $result;
}

/**
 * Cron task function: launches currencies rates update
 */
function x_mc_periodic_rates_update()
{
    func_mc_update_rates(TRUE);
}

function func_mc_set_order_extra(&$_extra) {

    global $store_currency, $primary_currency;

    // Get current store currency data
    $store_currency_data = func_mc_get_currency($store_currency);

    // Get primary currency data
    $primary_currency_data = func_mc_get_currency($primary_currency);

    // Save currencies data into the order extra data
    $_extra['mc_primary_currency'] = $primary_currency;
    $_extra['mc_primary_currency_symbol'] = $primary_currency_data['symbol'];
    $_extra['mc_primary_currency_name'] = $primary_currency_data['name'];

    $_extra['mc_store_currency'] = $store_currency;
    $_extra['mc_store_currency_rate'] = $store_currency_data['rate'];
    $_extra['mc_store_currency_symbol'] = $store_currency_data['symbol'];
    $_extra['mc_store_currency_name'] = $store_currency_data['name'];
}

function func_mc_redirect($l_redirect, $_mc_redirect = FALSE) {
    
    if ($_mc_redirect) {
        func_header_location($l_redirect);
    }
}

function func_mc_switch_number_format()
{
    global $config, $store_currency, $smarty;

    if (empty($store_currency)) {

        return false;
    }

    $currency = func_mc_get_currency($store_currency);

    if (empty($currency)) {

        return false;
    }

    $config['Appearance']['number_format'] = $currency['number_format'];

    $smarty->assign('config', $config);

    $smarty->assign('number_format_dec', $config['Appearance']['number_format']{1});
    $smarty->assign('number_format_th', isset($config['Appearance']['number_format']{2}) ? $config['Appearance']['number_format']{2} : "");
    $smarty->assign('number_format_point', intval($config['Appearance']['number_format']{0}));

    $smarty->assign('zero', func_format_number(0));

    return true;
}

function func_mc_get_country_language($code)
{
    global $sql_tbl, $mcCountryLanguageData, $mcAvailableLanguages;

    // Get all available in the store languages
    if (is_null($mcAvailableLanguages)) {
        $mcAvailableLanguages = func_query_column("SELECT code FROM $sql_tbl[languages] GROUP BY code ORDER BY NULL");
    }

    return (!empty($mcCountryLanguageData[$code]) && in_array($mcCountryLanguageData[$code], $mcAvailableLanguages))
         ? $mcCountryLanguageData[$code] : '';
}

function func_mc_balance_currencies_rates($currencies, $old_default, $new_default)
{
    $return = $currencies;

    if ($old_default != $new_default) {
        $currencies[$old_default]['rate'] = 1;
        $conversion_rate = round($currencies[$old_default]['rate'] / $currencies[$new_default]['rate'], 4);

        foreach ($currencies as $code => $currency) {
            $currencies[$code]['rate'] = round($currency['rate'] * $conversion_rate, 4);
        }

        $currencies[$new_default]['rate'] = 1;

        $return = $currencies;
    }

    return $return;
}

function func_mc_check_geolite_networks()
{
    global $sql_tbl;

    $count = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[mc_geolite_networks]");

    return $count > 0;
}

function func_mc_check_geolite_locations()
{
    global $sql_tbl;

    $count = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[mc_geolite_locations]");

    return $count > 0;
}

function func_mc_get_ip_protocol($address)
{
    $proto = 0;

    if (false !== strpos($address, '.')) {
        $proto = 4;
    } elseif (false !== strpos($address, ':')) {
        $proto = 6;
    }

    return $proto;
}

function func_mc_ip4_to_ip6($ip)
{
    $ip6 = array(
        ':',
        'ffff'
    );

    $cidr = '';
    if (false !== strpos($ip, '/')) {
        $ip = explode('/', $ip);
        $cidr = $ip[1];
        $ip = $ip[0];
    }

    $ip = explode('.', $ip);

    $i = 1;
    $prev_part = '';
    foreach ($ip as $part)
    {
        $part = dechex($part);

        if (1 == strlen($part)) {
            $part = '0' . $part;
        }

        if ($i % 2 == 0) {
            $ip6[] = $prev_part . $part;
            $prev_part = '';
        } else {
            $prev_part = $part;
        }

        $i++;
    }

    $ip6 = implode(':', $ip6);

    if (!empty($cidr)) {
        $ip6 .= '/' . (96 + $cidr);
    }

    return $ip6;
}

function func_mc_ip6_get_network_range($ip6, $as_array = false)
{
    $in = $ip6;
    list($ip6, $cidr) = explode('/', $ip6);

    $ip6 = func_mc_ip6_convert_short_to_long($ip6, true);

    $mod = $cidr % 16;
    $part = (int) (($cidr - $mod) / 16);

    $ip6_low = $ip6;
    $ip6_high = $ip6;

    if ($part < 8) {
        $high = dechex(hexdec($ip6[$part]) + pow(2, 16 - $mod) - 1);

        $high = func_mc_ip6_format_part_length($high);

        $ip6_high[$part] = $high;

        for ($i = $part + 1; $i < 8; $i++) {
            $ip6_high[$i] = 'ffff';
        }
    }

    if ($as_array) {
        $ip6_low = implode(':', $ip6_low);
        $ip6_high = implode(':', $ip6_high);
    }

    return array(
        'low'   => $ip6_low,
        'high'  => $ip6_high
    );
}

function func_mc_ip6_convert_short_to_long($ip6, $as_array = false)
{
    $address = array();
    $tail = false;

    if (false !== strpos($ip6, '::')) {
        if (0 === strpos($ip6, '::')) {
            $tail = true;
        }

        $ip6 = str_replace('::', '', $ip6);
    }

    $ip6 = explode(':', $ip6);

    $len = count($ip6);

    if ($len < 8) {
        if ($tail) {
            for ($i = 8; $i > $len; $i--) {
                $address[] = '0000';
            }
        }

        for ($i = 0; $i < $len; $i++) {
            $ip6[$i] = func_mc_ip6_format_part_length($ip6[$i]);

            $address[] = $ip6[$i];
        }

        if (!$tail) {
            for ($i = 8; $i > $len; $i--) {
                $address[] = '0000';
            }
        }
    } else {
        $address = $ip6;
    }

    if (!$as_array) {
        $address = implode(':', $address);
    }

    return $address;
}

function func_mc_ip6_format_part_length($part)
{
    $len = strlen($part);
    if ($len < 4) {
        for ($i = 4; $i > $len; $i--) {
            $part = '0' . $part;
        }
    }

    return $part;
}

function func_mc_ip6_get_hex_representation($ip)
{//{{{
    if (!is_array($ip)) {
        $ip = func_mc_ip6_convert_short_to_long($ip, true);
    }

    $res = array(
        'subnet'    => $ip[0] . $ip[1] .$ip[2] . $ip[3],
        'interface' => $ip[4] . $ip[5] .$ip[6] . $ip[7]
    );

    //https://dev.mysql.com/doc/refman/5.7/en/hexadecimal-literals.html
    //values written using X'val' notation must contain an even number of digits or a syntax error occurs. To correct the problem, pad the value with a leading zero:
    $res['subnet'] = (strlen($res['subnet']) % 2 == 0)//if is even ?
        ? $res['subnet']
        : '0' . $res['subnet'];

    $res['interface'] = (strlen($res['interface']) % 2 == 0)//if is even ?
        ? $res['interface']
        : '0' . $res['interface'];

    return $res;
}//Func_mc_ip6_get_hex_representation}}}

function func_mc_maxmind_get_country_by_ip($ip)
{
    global $sql_tbl;

    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        return false;
    }

    if (4 == func_mc_get_ip_protocol($ip)) {
        $ip = func_mc_ip4_to_ip6($ip);
    }

    $ip = func_mc_ip6_convert_short_to_long($ip);

    $range = func_mc_ip6_get_hex_representation($ip);

    $code = func_query_first_cell("SELECT gl.country_code FROM $sql_tbl[mc_geolite_networks] AS gn
INNER JOIN $sql_tbl[mc_geolite_locations] AS gl ON gl.geoname_id = gn.geoname_id
WHERE low_subnet <= x'" . $range['subnet'] . "'
  AND low_interface <= x'" . $range['interface'] . "'
  AND high_subnet >= x'" . $range['subnet'] . "'
  AND high_interface >= x'" . $range['interface'] . "'");

    return $code;
}

function func_mc_need_rate_update()
{
    global $config;

    $return = false;

    if ('Y' == $config['mc_autoupdate_enabled']) {
        $time = (int)str_replace(':', '', $config['mc_autoupdate_time']);
        $mark = (int) strftime('%H%M');

        $return = ($config['mc_autoupdate_last_time'] + 24 * 3600) < XC_TIME && $time <= $mark;
    }

    return $return;
}
