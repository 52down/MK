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
 * Fallback for func_get_xp_processors
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v5 (xcart_4_7_7), 2017-01-23 20:12:10, xp_processors_offline_list.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header('Location: ../../'); die('Access denied'); }

$methods = array (
  'XPay_Module_ANZeGate' => 
  array (
    'name' => 'ANZ eGate',
    'class' => 'XPay_Module_ANZeGate',
    'countries' => 
    array (
      0 => 'AE',
      1 => 'AS',
      2 => 'AU',
      3 => 'CN',
      4 => 'DE',
      5 => 'FJ',
      6 => 'GB',
      7 => 'GU',
      8 => 'HK',
      9 => 'ID',
      10 => 'IN',
      11 => 'JP',
      12 => 'KH',
      13 => 'KP',
      14 => 'MY',
      15 => 'NZ',
      16 => 'PH',
      17 => 'SG',
      18 => 'TH',
      19 => 'TW',
      20 => 'US',
      21 => 'VN',
    ),
  ),
  'XPay_Module_Amex' => 
  array (
    'name' => 'American Express Web-Services API Integration',
    'class' => 'XPay_Module_Amex',
    'countries' => 
    array (
      0 => 'US',
    ),
  ),
  'XPay_Module_AuthorizeNetXML' => 
  array (
    'name' => 'Authorize.Net',
    'class' => 'XPay_Module_AuthorizeNetXML',
    'countries' => 
    array (
      0 => 'AU',
      1 => 'GB',
      2 => 'NZ',
      3 => 'US',
    ),
  ),
  'XPay_Module_Bean' => 
  array (
    'name' => 'Beanstream, a Digital River Company/FirstData Canada',
    'class' => 'XPay_Module_Bean',
    'countries' => 
    array (
      0 => 'CA',
      1 => 'CY',
      2 => 'CZ',
      3 => 'DE',
      4 => 'DK',
      5 => 'EE',
      6 => 'ES',
      7 => 'FI',
      8 => 'FR',
      9 => 'GB',
      10 => 'GR',
      11 => 'HR',
      12 => 'HU',
      13 => 'IE',
      14 => 'IT',
      15 => 'LT',
      16 => 'LU',
      17 => 'LV',
      18 => 'MT',
      19 => 'NL',
      20 => 'PL',
      21 => 'PT',
      22 => 'RO',
      23 => 'SE',
      24 => 'SI',
      25 => 'SK',
      26 => 'US',
    ),
  ),
  'XPay_Module_BendigoBank' => 
  array (
    'name' => 'Bendigo Bank',
    'class' => 'XPay_Module_BendigoBank',
    'countries' => false,
  ),
  'XPay_Module_BluePay' => 
  array (
    'name' => 'BluePay',
    'class' => 'XPay_Module_BluePay',
    'countries' => 
    array (
      0 => 'CA',
      1 => 'US',
    ),
  ),
  'XPay_Module_Braintree' => 
  array (
    'name' => 'Braintree, direct integration with CC storing',
    'class' => 'XPay_Module_Braintree',
    'countries' => 
    array (
      0 => 'AE',
      1 => 'AU',
      2 => 'BG',
      3 => 'CA',
      4 => 'CY',
      5 => 'CZ',
      6 => 'DE',
      7 => 'DK',
      8 => 'EE',
      9 => 'ES',
      10 => 'FI',
      11 => 'FR',
      12 => 'GR',
      13 => 'HR',
      14 => 'HU',
      15 => 'IE',
      16 => 'IT',
      17 => 'LK',
      18 => 'LT',
      19 => 'LU',
      20 => 'LV',
      21 => 'MM',
      22 => 'MN',
      23 => 'MT',
      24 => 'MV',
      25 => 'MY',
      26 => 'NL',
      27 => 'NP',
      28 => 'OM',
      29 => 'PG',
      30 => 'PH',
      31 => 'PK',
      32 => 'PL',
      33 => 'PS',
      34 => 'PT',
      35 => 'QA',
      36 => 'RO',
      37 => 'SA',
      38 => 'SE',
      39 => 'SG',
      40 => 'SI',
      41 => 'SK',
      42 => 'SY',
      43 => 'TH',
      44 => 'TJ',
      45 => 'TL',
      46 => 'TM',
      47 => 'TW',
      48 => 'US',
      49 => 'UZ',
      50 => 'VN',
      51 => 'YE',
    ),
  ),
  'XPay_Module_Caledon' => 
  array (
    'name' => 'BluePay Canada (Caledon)',
    'class' => 'XPay_Module_Caledon',
    'countries' => 
    array (
      0 => 'CA',
    ),
  ),
  'XPay_Module_CardinalCommerce' => 
  array (
    'name' => 'Cardinal Commerce Centinel',
    'class' => 'XPay_Module_CardinalCommerce',
    'countries' => 
    array (
      0 => 'BR',
      1 => 'US',
    ),
  ),
  'XPay_Module_Chase' => 
  array (
    'name' => 'Chase Paymentech',
    'class' => 'XPay_Module_Chase',
    'countries' => 
    array (
      0 => 'BG',
      1 => 'CA',
      2 => 'CY',
      3 => 'CZ',
      4 => 'DE',
      5 => 'DK',
      6 => 'EE',
      7 => 'ES',
      8 => 'FI',
      9 => 'FR',
      10 => 'GR',
      11 => 'HR',
      12 => 'HU',
      13 => 'IE',
      14 => 'IT',
      15 => 'LT',
      16 => 'LU',
      17 => 'LV',
      18 => 'MT',
      19 => 'NL',
      20 => 'PL',
      21 => 'PT',
      22 => 'RO',
      23 => 'SE',
      24 => 'SI',
      25 => 'SK',
      26 => 'US',
    ),
  ),
  'XPay_Module_CommWeb' => 
  array (
    'name' => 'CommWeb - Commonwealth Bank',
    'class' => 'XPay_Module_CommWeb',
    'countries' => false,
  ),
  'XPay_Module_CyberSourceSOAP' => 
  array (
    'name' => 'CyberSource - SOAP toolkit API',
    'class' => 'XPay_Module_CyberSourceSOAP',
    'countries' => 
    array (
      0 => 'CA',
      1 => 'US',
    ),
  ),
  'XPay_Module_Dibs' => 
  array (
    'name' => 'DIBS',
    'class' => 'XPay_Module_Dibs',
    'countries' => 
    array (
      0 => 'DK',
      1 => 'SE',
    ),
  ),
  'XPay_Module_DirectOne' => 
  array (
    'name' => 'DirectOne - Direct Interface',
    'class' => 'XPay_Module_DirectOne',
    'countries' => 
    array (
      0 => 'AU',
    ),
  ),
  'XPay_Module_EProcessingTDE' => 
  array (
    'name' => 'eProcessing Network - Transparent Database Engine',
    'class' => 'XPay_Module_EProcessingTDE',
    'countries' => 
    array (
      0 => 'US',
    ),
  ),
  'XPay_Module_ESec' => 
  array (
    'name' => 'SecurePay Australia',
    'class' => 'XPay_Module_ESec',
    'countries' => 
    array (
      0 => 'AU',
    ),
  ),
  'XPay_Module_ESelect' => 
  array (
    'name' => 'eSELECTplus',
    'class' => 'XPay_Module_ESelect',
    'countries' => 
    array (
      0 => 'CA',
    ),
  ),
  'XPay_Module_Echo' => 
  array (
    'name' => 'ECHO NVP',
    'class' => 'XPay_Module_Echo',
    'countries' => 
    array (
      0 => 'AE',
      1 => 'AU',
      2 => 'BR',
      3 => 'CA',
      4 => 'FR',
      5 => 'GB',
      6 => 'HK',
      7 => 'IE',
      8 => 'IN',
      9 => 'MY',
      10 => 'PH',
      11 => 'SG',
      12 => 'US',
      13 => 'ZA',
    ),
  ),
  'XPay_Module_Elavon' => 
  array (
    'name' => 'Elavon Converge',
    'class' => 'XPay_Module_Elavon',
    'countries' => 
    array (
      0 => 'CA',
      1 => 'US',
    ),
  ),
  'XPay_Module_EpdqXML' => 
  array (
    'name' => 'ePDQ MPI XML (Phased out)',
    'class' => 'XPay_Module_EpdqXML',
    'countries' => 
    array (
      0 => 'GB',
    ),
  ),
  'XPay_Module_EwayRapid' => 
  array (
    'name' => 'eWAY Rapid - Direct Connection',
    'class' => 'XPay_Module_EwayRapid',
    'countries' => false,
  ),
  'XPay_Module_EwayXML' => 
  array (
    'name' => 'eWay Realtime Payments XML',
    'class' => 'XPay_Module_EwayXML',
    'countries' => 
    array (
      0 => 'AU',
      1 => 'GB',
      2 => 'HK',
      3 => 'MY',
      4 => 'NZ',
      5 => 'SG',
    ),
  ),
  'XPay_Module_FifthDimensionGateway' => 
  array (
    'name' => 'Sparrow (5th Dimension Gateway)',
    'class' => 'XPay_Module_FifthDimensionGateway',
    'countries' => 
    array (
      0 => 'US',
    ),
  ),
  'XPay_Module_FirstDataE4' => 
  array (
    'name' => 'First Data Payeezy Gateway (ex- Global Gateway e4)',
    'class' => 'XPay_Module_FirstDataE4',
    'countries' => 
    array (
      0 => 'AN',
      1 => 'BE',
      2 => 'BG',
      3 => 'CD',
      4 => 'CY',
      5 => 'CZ',
      6 => 'DE',
      7 => 'DK',
      8 => 'EE',
      9 => 'EH',
      10 => 'ES',
      11 => 'FI',
      12 => 'FR',
      13 => 'GR',
      14 => 'HN',
      15 => 'HR',
      16 => 'HU',
      17 => 'IE',
      18 => 'IT',
      19 => 'JM',
      20 => 'KN',
      21 => 'LC',
      22 => 'LT',
      23 => 'LU',
      24 => 'LV',
      25 => 'MQ',
      26 => 'MS',
      27 => 'MT',
      28 => 'MX',
      29 => 'NI',
      30 => 'NL',
      31 => 'PA',
      32 => 'PE',
      33 => 'PL',
      34 => 'PR',
      35 => 'PT',
      36 => 'PY',
      37 => 'RO',
      38 => 'SD',
      39 => 'SE',
      40 => 'SI',
      41 => 'SK',
      42 => 'SR',
      43 => 'SZ',
      44 => 'TC',
      45 => 'TG',
      46 => 'TN',
      47 => 'TT',
      48 => 'TZ',
      49 => 'UG',
      50 => 'US',
      51 => 'UY',
      52 => 'VC',
      53 => 'VE',
      54 => 'VI',
      55 => 'ZM',
      56 => 'ZW',
    ),
  ),
  'XPay_Module_GlobalIris' => 
  array (
    'name' => 'Global Iris',
    'class' => 'XPay_Module_GlobalIris',
    'countries' => 
    array (
      0 => 'GB',
    ),
  ),
  'XPay_Module_GoEmerchant' => 
  array (
    'name' => 'GoEmerchant - XML Gateway API',
    'class' => 'XPay_Module_GoEmerchant',
    'countries' => 
    array (
      0 => 'US',
    ),
  ),
  'XPay_Module_HeidelPay' => 
  array (
    'name' => 'HeidelPay',
    'class' => 'XPay_Module_HeidelPay',
    'countries' => 
    array (
      0 => 'AT',
      1 => 'BE',
      2 => 'BG',
      3 => 'CY',
      4 => 'CZ',
      5 => 'DE',
      6 => 'DK',
      7 => 'EE',
      8 => 'ES',
      9 => 'FI',
      10 => 'FR',
      11 => 'GR',
      12 => 'HR',
      13 => 'HU',
      14 => 'IE',
      15 => 'IT',
      16 => 'LT',
      17 => 'LU',
      18 => 'LV',
      19 => 'MT',
      20 => 'NL',
      21 => 'PL',
      22 => 'PT',
      23 => 'RO',
      24 => 'SE',
      25 => 'SI',
      26 => 'SK',
    ),
  ),
  'XPay_Module_InnovativeGateway' => 
  array (
    'name' => 'Innovative Gateway',
    'class' => 'XPay_Module_InnovativeGateway',
    'countries' => 
    array (
      0 => 'US',
    ),
  ),
  'XPay_Module_Intuit' => 
  array (
    'name' => 'Intuit QuickBooks Payments',
    'class' => 'XPay_Module_Intuit',
    'countries' => 
    array (
      0 => 'AE',
      1 => 'AU',
      2 => 'BR',
      3 => 'CA',
      4 => 'FR',
      5 => 'GB',
      6 => 'HK',
      7 => 'IE',
      8 => 'IN',
      9 => 'MY',
      10 => 'PH',
      11 => 'SG',
      12 => 'US',
      13 => 'ZA',
    ),
  ),
  'XPay_Module_ItransactXML' => 
  array (
    'name' => 'iTransact XML',
    'class' => 'XPay_Module_ItransactXML',
    'countries' => 
    array (
      0 => 'US',
    ),
  ),
  'XPay_Module_Meritus' => 
  array (
    'name' => 'Meritus Web Host',
    'class' => 'XPay_Module_Meritus',
    'countries' => 
    array (
      0 => 'US',
    ),
  ),
  'XPay_Module_NAB' => 
  array (
    'name' => 'NAB - National Australia Bank',
    'class' => 'XPay_Module_NAB',
    'countries' => false,
  ),
  'XPay_Module_NMI' => 
  array (
    'name' => 'NMI (Network Merchants Inc.)',
    'class' => 'XPay_Module_NMI',
    'countries' => false,
  ),
  'XPay_Module_NetRegistry' => 
  array (
    'name' => 'NetRegistry',
    'class' => 'XPay_Module_NetRegistry',
    'countries' => 
    array (
      0 => 'AU',
    ),
  ),
  'XPay_Module_Netbilling' => 
  array (
    'name' => 'Netbilling - Direct Mode',
    'class' => 'XPay_Module_Netbilling',
    'countries' => 
    array (
      0 => 'US',
    ),
  ),
  'XPay_Module_Ogone' => 
  array (
    'name' => 'Ingenico ePayments (Ogone e-Commerce)',
    'class' => 'XPay_Module_Ogone',
    'countries' => 
    array (
      0 => 'AN',
      1 => 'CL',
      2 => 'CO',
      3 => 'CR',
      4 => 'CU',
      5 => 'DE',
      6 => 'DM',
      7 => 'DO',
      8 => 'EC',
      9 => 'ES',
      10 => 'FK',
      11 => 'FR',
      12 => 'GB',
      13 => 'GD',
      14 => 'GF',
      15 => 'GP',
      16 => 'GT',
      17 => 'GY',
      18 => 'HN',
      19 => 'HT',
      20 => 'HU',
      21 => 'IT',
      22 => 'JM',
      23 => 'KN',
      24 => 'KY',
      25 => 'LC',
      26 => 'MQ',
      27 => 'MS',
      28 => 'MX',
      29 => 'NI',
      30 => 'PA',
      31 => 'PE',
      32 => 'PL',
      33 => 'PR',
      34 => 'PT',
      35 => 'PY',
      36 => 'RU',
      37 => 'SR',
      38 => 'SV',
      39 => 'TC',
      40 => 'TR',
      41 => 'TT',
      42 => 'UY',
      43 => 'VC',
      44 => 'VE',
      45 => 'VG',
      46 => 'VI',
    ),
  ),
  'XPay_Module_PayGate' => 
  array (
    'name' => 'PayGate Korea',
    'class' => 'XPay_Module_PayGate',
    'countries' => 
    array (
      0 => 'CN',
      1 => 'JP',
      2 => 'KP',
    ),
  ),
  'XPay_Module_PayflowPro' => 
  array (
    'name' => 'Payflow Pro',
    'class' => 'XPay_Module_PayflowPro',
    'countries' => 
    array (
      0 => 'AU',
      1 => 'CA',
      2 => 'NZ',
      3 => 'US',
    ),
  ),
  'XPay_Module_PaypalWPPDirectPayment' => 
  array (
    'name' => 'PayPal Payments Pro (PayPal API)',
    'class' => 'XPay_Module_PaypalWPPDirectPayment',
    'countries' => 
    array (
      0 => 'AU',
      1 => 'CA',
      2 => 'NZ',
      3 => 'US',
    ),
  ),
  'XPay_Module_PaypalWPPPEDirectPayment' => 
  array (
    'name' => 'PayPal Payments Pro (Payflow API)',
    'class' => 'XPay_Module_PaypalWPPPEDirectPayment',
    'countries' => 
    array (
      0 => 'AU',
      1 => 'CA',
      2 => 'NZ',
      3 => 'US',
    ),
  ),
  'XPay_Module_PsiGateXML' => 
  array (
    'name' => 'PSiGate XML API',
    'class' => 'XPay_Module_PsiGateXML',
    'countries' => 
    array (
      0 => 'CA',
      1 => 'US',
    ),
  ),
  'XPay_Module_QuantumGateway' => 
  array (
    'name' => 'QuantumGateway - Transparent QGWdatabase Engine',
    'class' => 'XPay_Module_QuantumGateway',
    'countries' => 
    array (
      0 => 'US',
    ),
  ),
  'XPay_Module_QuantumGatewayXML' => 
  array (
    'name' => 'QuantumGateway - XML Requester',
    'class' => 'XPay_Module_QuantumGatewayXML',
    'countries' => 
    array (
      0 => 'US',
    ),
  ),
  'XPay_Module_RBSGlobalGatewayDirect' => 
  array (
    'name' => 'Worldpay Corporate Gateway - Direct Model',
    'class' => 'XPay_Module_RBSGlobalGatewayDirect',
    'countries' => 
    array (
      0 => 'BE',
      1 => 'BG',
      2 => 'CY',
      3 => 'CZ',
      4 => 'DE',
      5 => 'DK',
      6 => 'EE',
      7 => 'ES',
      8 => 'FI',
      9 => 'FR',
      10 => 'GB',
      11 => 'GR',
      12 => 'HR',
      13 => 'HU',
      14 => 'IE',
      15 => 'IT',
      16 => 'LT',
      17 => 'LU',
      18 => 'LV',
      19 => 'MT',
      20 => 'NL',
      21 => 'PL',
      22 => 'PT',
      23 => 'RO',
      24 => 'SE',
      25 => 'SI',
      26 => 'SK',
    ),
  ),
  'XPay_Module_Realex' => 
  array (
    'name' => 'Realex',
    'class' => 'XPay_Module_Realex',
    'countries' => 
    array (
      0 => 'BG',
      1 => 'CY',
      2 => 'CZ',
      3 => 'DE',
      4 => 'DK',
      5 => 'EE',
      6 => 'ES',
      7 => 'FI',
      8 => 'FR',
      9 => 'GB',
      10 => 'GR',
      11 => 'HR',
      12 => 'HU',
      13 => 'IE',
      14 => 'IT',
      15 => 'LT',
      16 => 'LU',
      17 => 'LV',
      18 => 'MT',
      19 => 'NL',
      20 => 'PL',
      21 => 'PT',
      22 => 'RO',
      23 => 'SE',
      24 => 'SI',
      25 => 'SK',
    ),
  ),
  'XPay_Module_SagePayDirect' => 
  array (
    'name' => 'Sage Pay Go - Direct Interface',
    'class' => 'XPay_Module_SagePayDirect',
    'countries' => 
    array (
      0 => 'AU',
      1 => 'GB',
      2 => 'US',
    ),
  ),
  'XPay_Module_SageUs' => 
  array (
    'name' => 'Sage Payment Solutions',
    'class' => 'XPay_Module_SageUs',
    'countries' => false,
  ),
  'XPay_Module_Securepay' => 
  array (
    'name' => 'SecurePay USA',
    'class' => 'XPay_Module_Securepay',
    'countries' => 
    array (
      0 => 'US',
    ),
  ),
  'XPay_Module_SimplifyCommerce' => 
  array (
    'name' => 'Simplify Commerce by MasterCard',
    'class' => 'XPay_Module_SimplifyCommerce',
    'countries' => 
    array (
      0 => 'IE',
      1 => 'US',
    ),
  ),
  'XPay_Module_SkipJack' => 
  array (
    'name' => 'SkipJack',
    'class' => 'XPay_Module_SkipJack',
    'countries' => 
    array (
      0 => 'CA',
      1 => 'US',
    ),
  ),
  'XPay_Module_Suncorp' => 
  array (
    'name' => 'Suncorp',
    'class' => 'XPay_Module_Suncorp',
    'countries' => false,
  ),
  'XPay_Module_USAePay' => 
  array (
    'name' => 'USA ePay - Transaction Gateway API',
    'class' => 'XPay_Module_USAePay',
    'countries' => 
    array (
      0 => 'US',
    ),
  ),
  'XPay_Module_VirtualMerchantMPF' => 
  array (
    'name' => 'Virtual Merchant - Merchant Provided Form',
    'class' => 'XPay_Module_VirtualMerchantMPF',
    'countries' => 
    array (
      0 => 'CA',
      1 => 'PR',
      2 => 'US',
    ),
  ),
  'XPay_Module_WebXpress' => 
  array (
    'name' => 'WebXpress',
    'class' => 'XPay_Module_WebXpress',
    'countries' => 
    array (
      0 => 'US',
    ),
  ),
  'XPay_Module_WorldpayUs' => 
  array (
    'name' => 'Worldpay US',
    'class' => 'XPay_Module_WorldpayUs',
    'countries' => 
    array (
      0 => 'US',
    ),
  ),
);
