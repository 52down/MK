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

/**
 * Admin functions of the Pilibaba module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ildar Amankulov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v10 (xcart_4_7_7), 2017-01-23 20:12:10, backend_func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header('Location: ../../'); die('Access denied'); }

class XCPilibabaOrders {

    public static function getJoinCondition() {//{{{
        global $sql_tbl;

        return $sql_tbl['order_extras'] . " ON $sql_tbl[order_extras].orderid = $sql_tbl[orders].orderid AND $sql_tbl[order_extras].khash = 'pilibaba_oid' ";
    }//}}}

}

/**
 * Get currencies list for the backend
 */
function func_pilibaba_get_currencies() {//{{{
    global $sql_tbl;

    $fallback_currencies = array (//{{{
        'XUA' => 'ADB Unit of Account',
        'AFN' => 'Afghani',
        'DZD' => 'Algerian Dinar',
        'ARS' => 'Argentine Peso',
        'AMD' => 'Armenian Dram',
        'AWG' => 'Aruban Florin',
        'AUD' => 'Australian Dollar',
        'AZN' => 'Azerbaijanian Manat',
        'BSD' => 'Bahamian Dollar',
        'BHD' => 'Bahraini Dinar',
        'THB' => 'Baht',
        'PAB' => 'Balboa',
        'BBD' => 'Barbados Dollar',
        'BZD' => 'Belize Dollar',
        'BMD' => 'Bermudian Dollar',
        'VEF' => 'Bolivar',
        'BOB' => 'Boliviano',
        'BRL' => 'Brazilian Real',
        'BND' => 'Brunei Dollar',
        'BGN' => 'Bulgarian Lev',
        'BIF' => 'Burundi Franc',
        'XOF' => 'CFA Franc BCEAO',
        'XAF' => 'CFA Franc BEAC',
        'XPF' => 'CFP Franc',
        'CVE' => 'Cabo Verde Escudo',
        'CAD' => 'Canadian Dollar',
        'KYD' => 'Cayman Islands Dollar',
        'CLP' => 'Chilean Peso',
        'COP' => 'Colombian Peso',
        'KMF' => 'Comoro Franc',
        'CDF' => 'Congolese Franc',
        'BAM' => 'Convertible Mark',
        'NIO' => 'Cordoba Oro',
        'CRC' => 'Costa Rican Colon',
        'CUP' => 'Cuban Peso',
        'CZK' => 'Czech Koruna',
        'GMD' => 'Dalasi',
        'DKK' => 'Danish Krone',
        'MKD' => 'Denar',
        'DJF' => 'Djibouti Franc',
        'STD' => 'Dobra',
        'DOP' => 'Dominican Peso',
        'VND' => 'Dong',
        'XCD' => 'East Caribbean Dollar',
        'EGP' => 'Egyptian Pound',
        'SVC' => 'El Salvador Colon',
        'ETB' => 'Ethiopian Birr',
        'EUR' => 'Euro',
        'FKP' => 'Falkland Islands Pound',
        'FJD' => 'Fiji Dollar',
        'HUF' => 'Forint',
        'GHS' => 'Ghana Cedi',
        'GIP' => 'Gibraltar Pound',
        'HTG' => 'Gourde',
        'PYG' => 'Guarani',
        'GNF' => 'Guinea Franc',
        'GYD' => 'Guyana Dollar',
        'HKD' => 'Hong Kong Dollar',
        'UAH' => 'Hryvnia',
        'ISK' => 'Iceland Krona',
        'INR' => 'Indian Rupee',
        'IRR' => 'Iranian Rial',
        'IQD' => 'Iraqi Dinar',
        'JMD' => 'Jamaican Dollar',
        'JOD' => 'Jordanian Dinar',
        'KES' => 'Kenyan Shilling',
        'PGK' => 'Kina',
        'LAK' => 'Kip',
        'HRK' => 'Kuna',
        'KWD' => 'Kuwaiti Dinar',
        'AOA' => 'Kwanza',
        'MMK' => 'Kyat',
        'GEL' => 'Lari',
        'LBP' => 'Lebanese Pound',
        'ALL' => 'Lek',
        'HNL' => 'Lempira',
        'SLL' => 'Leone',
        'LRD' => 'Liberian Dollar',
        'LYD' => 'Libyan Dinar',
        'SZL' => 'Lilangeni',
        'LSL' => 'Loti',
        'MGA' => 'Malagasy Ariary',
        'MWK' => 'Malawi Kwacha',
        'MYR' => 'Malaysian Ringgit',
        'MUR' => 'Mauritius Rupee',
        'MXN' => 'Mexican Peso',
        'MXV' => 'Mexican Unidad de Inversion (UDI)',
        'MDL' => 'Moldovan Leu',
        'MAD' => 'Moroccan Dirham',
        'MZN' => 'Mozambique Metical',
        'BOV' => 'Mvdol',
        'NGN' => 'Naira',
        'ERN' => 'Nakfa',
        'NAD' => 'Namibia Dollar',
        'NPR' => 'Nepalese Rupee',
        'ANG' => 'Netherlands Antillean Guilder',
        'BYN' => 'Belarusian Ruble',
        'ILS' => 'New Israeli Sheqel',
        'TWD' => 'New Taiwan Dollar',
        'NZD' => 'New Zealand Dollar',
        'BTN' => 'Ngultrum',
        'KPW' => 'North Korean Won',
        'NOK' => 'Norwegian Krone',
        'MRO' => 'Ouguiya',
        'TOP' => 'Pa\'anga',
        'PKR' => 'Pakistan Rupee',
        'MOP' => 'Pataca',
        'CUC' => 'Peso Convertible',
        'UYU' => 'Peso Uruguayo',
        'PHP' => 'Philippine Peso',
        'GBP' => 'Pound Sterling',
        'BWP' => 'Pula',
        'QAR' => 'Qatari Rial',
        'GTQ' => 'Quetzal',
        'ZAR' => 'Rand',
        'OMR' => 'Rial Omani',
        'KHR' => 'Riel',
        'RON' => 'Romanian Leu',
        'MVR' => 'Rufiyaa',
        'IDR' => 'Rupiah',
        'RUB' => 'Russian Ruble',
        'RWF' => 'Rwanda Franc',
        'XDR' => 'SDR (Special Drawing Right)',
        'SHP' => 'Saint Helena Pound',
        'SAR' => 'Saudi Riyal',
        'RSD' => 'Serbian Dinar',
        'SCR' => 'Seychelles Rupee',
        'SGD' => 'Singapore Dollar',
        'PEN' => 'Sol',
        'SBD' => 'Solomon Islands Dollar',
        'KGS' => 'Som',
        'SOS' => 'Somali Shilling',
        'TJS' => 'Somoni',
        'SSP' => 'South Sudanese Pound',
        'LKR' => 'Sri Lanka Rupee',
        'XSU' => 'Sucre',
        'SDG' => 'Sudanese Pound',
        'SRD' => 'Surinam Dollar',
        'SEK' => 'Swedish Krona',
        'CHF' => 'Swiss Franc',
        'SYP' => 'Syrian Pound',
        'BDT' => 'Taka',
        'WST' => 'Tala',
        'TZS' => 'Tanzanian Shilling',
        'KZT' => 'Tenge',
        'TTD' => 'Trinidad and Tobago Dollar',
        'MNT' => 'Tugrik',
        'TND' => 'Tunisian Dinar',
        'TRY' => 'Turkish Lira',
        'TMT' => 'Turkmenistan New Manat',
        'AED' => 'UAE Dirham',
        'USD' => 'US Dollar',
        'USN' => 'US Dollar (Next day)',
        'UGX' => 'Uganda Shilling',
        'CLF' => 'Unidad de Fomento',
        'COU' => 'Unidad de Valor Real',
        'UYI' => 'Uruguay Peso en Unidades Indexadas (URUIURUI)',
        'UZS' => 'Uzbekistan Sum',
        'VUV' => 'Vatu',
        'CHE' => 'WIR Euro',
        'CHW' => 'WIR Franc',
        'KRW' => 'Won',
        'YER' => 'Yemeni Rial',
        'JPY' => 'Yen',
        'CNY' => 'Yuan Renminbi',
        'ZMW' => 'Zambian Kwacha',
        'ZWL' => 'Zimbabwe Dollar',
        'PLN' => 'Zloty',
    );//}}}

    if (!function_exists('json_decode')) {
        return $fallback_currencies;
    }

    func_register_cache_function(__FUNCTION__, array ('dir' => 'pilibaba_addresses_currencies', 'ttl' => SECONDS_PER_DAY * 10, 'hashedDirectoryLevel' => 0));// pilibaba_compatible from xcart_4_6_6

    $md5_args = '';
    if (($cacheData = func_get_cache_func($md5_args, __FUNCTION__ ))) {
        return $cacheData['data'];
    }

    x_load('http');

    //$realtime_list = file_get_contents("http://www.pilibaba.com/pilipay/getCurrency");
    $realtime_list = func_http_get_request('www.pilibaba.com', '/pilipay/getCurrency', '');
    $currencies_array = empty($realtime_list[1]) ? array() : json_decode($realtime_list[1]);

    if (empty($currencies_array)) {
        assert('FALSE /* '.__FUNCTION__.' file_get_contents("http://www.pilibaba.com/pilipay/getCurrency") or json_decode error*/');
        func_save_cache_func($fallback_currencies, $md5_args, __FUNCTION__);
        return $fallback_currencies;
    }

    $currencies_names = func_query_hash("SELECT code, name FROM $sql_tbl[currencies] WHERE code IN ('" . implode("','", $currencies_array) . "')", 'code', false, true);

    if (!empty($currencies_names)) {
        asort($currencies_names);
        sort($currencies_array);
        foreach ($currencies_array as $from_site_currency) {
            if (!isset($currencies_names[$from_site_currency])) {
                $currencies_names[$from_site_currency] = $from_site_currency;
            }
        }
        func_save_cache_func($currencies_names, $md5_args, __FUNCTION__);
        return $currencies_names;
    }

    assert('FALSE /* '.__FUNCTION__.' empty($currencies_names) error*/');
    func_save_cache_func($fallback_currencies, $md5_args, __FUNCTION__);
    return $fallback_currencies;

}//}}}

/**
 * Get warehouse addresses list for the backend
 */
function func_pilibaba_get_warehouse_addresses() {//{{{
    global $sql_tbl;

    $fallback_warehouse_addresses = array (// {{{ base64_encoded
        '' => '',
        'YToxMjp7czoyOiJpZCI7aToxO3M6NzoiY291bnRyeSI7czozOiJVU0EiO3M6OToiZmlyc3ROYW1lIjtzOjU6IkpYUE5DIjtzOjg6Imxhc3ROYW1lIjtzOjg6IlBpbGliYWJhIjtzOjc6ImFkZHJlc3MiO3M6MjM6IjcwIE1jQ3VsbG91Z2ggRHIgI1owMzY3IjtzOjQ6ImNpdHkiO3M6MTA6Ik5ldyBDYXN0bGUiO3M6NToic3RhdGUiO3M6MTQ6IkRFIChERUxBV0FSRSApIjtzOjc6InppcGNvZGUiO3M6NToiMTk3MjAiO3M6MzoidGVsIjtzOjEyOiIzMDItNjA0LTUwMTAiO3M6MTE6ImNvdW50cnlDb2RlIjtzOjM6IlVTQSI7czoxNToiaXNvMkNvdW50cnlDb2RlIjtzOjI6IlVTIjtzOjEyOiJpc29TdGF0ZUNvZGUiO3M6MjoiREUiO30=' => 'USA-->DE (DELAWARE )-->New Castle-->19720-->70 McCullough Dr #Z0367',
        'YToxMjp7czoyOiJpZCI7aToyO3M6NzoiY291bnRyeSI7czo3OiJHZXJtYW55IjtzOjk6ImZpcnN0TmFtZSI7czoxNDoiUG9zdGZhY2ggSlhQTkMiO3M6ODoibGFzdE5hbWUiO3M6MjQ6ImMvbyBaZWJyYSBMb2dpc3RpY3MgR21iSCI7czo3OiJhZGRyZXNzIjtzOjIyOiJOb3JkZXJzYW5kIDHvvIwgI1owMzY3IjtzOjQ6ImNpdHkiO3M6NzoiSGFtYnVyZyI7czo1OiJzdGF0ZSI7czo3OiJIYW1idXJnIjtzOjc6InppcGNvZGUiO3M6NToiMjA0NTciO3M6MzoidGVsIjtzOjEyOiIwNDAtNTcxMzAzMzYiO3M6MTE6ImNvdW50cnlDb2RlIjtzOjM6IkRFVSI7czoxNToiaXNvMkNvdW50cnlDb2RlIjtzOjI6IkRFIjtzOjEyOiJpc29TdGF0ZUNvZGUiO3M6MjoiSEgiO30=' => 'Germany-->Hamburg-->Hamburg-->20457-->Nordersand 1， #Z0367',
        'YToxMjp7czoyOiJpZCI7aTozO3M6NzoiY291bnRyeSI7czo4OiJIb25nS29uZyI7czo5OiJmaXJzdE5hbWUiO3M6NToiSlhQTkMiO3M6ODoibGFzdE5hbWUiO3M6MTA6ImMvbyBBQUUtSEsiO3M6NzoiYWRkcmVzcyI7czoxMjE6IkZBQ1RPUlkgVU5JVCBBIE9OIDkvRiwgWU9VTkcgWUEgSU5EVVNUUklBTCBCVUlMRElORywgTk9TLiAzODEtMzg5LCBTSEEgVFNVSSBST0FELCBUU1VFTiBXQU4sIA0KTkVXIFRFUlJJVE9SSUVTLCBIT05HIEtPTkciO3M6NDoiY2l0eSI7czo5OiJIb25nIEtvbmciO3M6NToic3RhdGUiO3M6OToiSG9uZyBLb25nIjtzOjc6InppcGNvZGUiO047czozOiJ0ZWwiO3M6MTI6Ijg1Mi0zOTU2ODU0MiI7czoxMToiY291bnRyeUNvZGUiO3M6MzoiSEtHIjtzOjE1OiJpc28yQ291bnRyeUNvZGUiO3M6MjoiSEsiO3M6MTI6Imlzb1N0YXRlQ29kZSI7czoyOiJISyI7fQ==' => 'HongKong-->Hong Kong-->Hong Kong-->-->FACTORY UNIT A ON 9/F, YOUNG YA INDUSTRIAL BUILDING, NOS. 3...',
        'YToxMjp7czoyOiJpZCI7aTo0O3M6NzoiY291bnRyeSI7czo1OiJKYXBhbiI7czo5OiJmaXJzdE5hbWUiO3M6NToiSlhQTkMiO3M6ODoibGFzdE5hbWUiO3M6ODoiUGlsaWJhYmEiO3M6NzoiYWRkcmVzcyI7czo1Njoi5aSn6Ziq5bqc5ZKM5rOJ5biC44Gu44Ge44G/6YeOM+S4geebrjExODnnlarlnLAzNiAjWjAzNjciO3M6NDoiY2l0eSI7czo2OiLlpKfpmKoiO3M6NToic3RhdGUiO3M6OToi5aSn6Ziq5bqcIjtzOjc6InppcGNvZGUiO3M6ODoiNTk0LTExMDUiO3M6MzoidGVsIjtzOjEyOiIwNzItNTU4LTcxODgiO3M6MTE6ImNvdW50cnlDb2RlIjtzOjM6IkpQTiI7czoxNToiaXNvMkNvdW50cnlDb2RlIjtzOjI6IkpQIjtzOjEyOiJpc29TdGF0ZUNvZGUiO3M6MjoiMjciO30=' => 'Japan-->大阪府-->大阪-->594-1105-->大阪府和泉市のぞみ野3丁目1189番地36 #Z0367',
        'YToxMjp7czoyOiJpZCI7aTo1O3M6NzoiY291bnRyeSI7czo1OiJDaGluYSI7czo5OiJmaXJzdE5hbWUiO3M6ODoiUGlsaWJhYmEiO3M6ODoibGFzdE5hbWUiO3M6ODoiUGlsaWJhYmEiO3M6NzoiYWRkcmVzcyI7czozNjoiUm9vbSBJLCA5RiBOby4yODggU291dGggWmhvbmdTaGFuIFJkIjtzOjQ6ImNpdHkiO3M6NzoiTmFuamluZyI7czo1OiJzdGF0ZSI7czo3OiJKaWFuZ1N1IjtzOjc6InppcGNvZGUiO3M6NjoiMjEwMDA1IjtzOjM6InRlbCI7czoxNDoiODYtMjU4NTMtMjU4NTMiO3M6MTE6ImNvdW50cnlDb2RlIjtzOjM6IkNITiI7czoxNToiaXNvMkNvdW50cnlDb2RlIjtzOjI6IkNOIjtzOjEyOiJpc29TdGF0ZUNvZGUiO3M6MjoiMzIiO30=' => 'China-->JiangSu-->Nanjing-->210005-->Room I, 9F No.288 South ZhongShan Rd',
    );//}}}

    if (!function_exists('json_decode')) {
        return $fallback_warehouse_addresses;
    }

    func_register_cache_function(__FUNCTION__, array ( 'dir' => 'pilibaba_addresses_currencies', 'ttl' => SECONDS_PER_DAY * 10, 'hashedDirectoryLevel' => 0));// pilibaba_compatible from xcart_4_6_6

    $md5_args = '';
    if (($cacheData = func_get_cache_func($md5_args, __FUNCTION__ ))) {
        return $cacheData['data'];
    }

    x_load('http');

    //$realtime_list = file_get_contents("http://www.pilibaba.com/pilipay/getAddressList");
    $realtime_list = func_http_get_request('www.pilibaba.com', '/pilipay/getAddressList', '');
    $warehouse_addresses_array = empty($realtime_list[1]) ? array() : json_decode($realtime_list[1], true);

    if (empty($warehouse_addresses_array)) {
        assert('FALSE /* '.__FUNCTION__.' file_get_contents("http://www.pilibaba.com/pilipay/getAddressList") or json_decode error*/');
        func_save_cache_func($fallback_warehouse_addresses, $md5_args, __FUNCTION__);
        return $fallback_warehouse_addresses;
    }

    $warehouse_addresses_names = array('' => '');
    foreach ($warehouse_addresses_array as $address) {
        $str = $address['country'] . '-->' . $address['state'] . '-->' . $address['city'] . '-->' . $address['zipcode'] . '-->' . preg_replace("/[\n\r]/s", '', $address['address']);
        if (strlen($str) > 97) {
            $str = substr($str, 0, 97) . '...';
        }

        $warehouse_addresses_names[base64_encode(serialize($address))] = $str;
    }
    func_save_cache_func($warehouse_addresses_names, $md5_args, __FUNCTION__);
    return $warehouse_addresses_names;
}//}}}
