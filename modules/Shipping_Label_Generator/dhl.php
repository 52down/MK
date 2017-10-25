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
 * DHL shipping labels module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v30 (xcart_4_7_7), 2017-01-24 09:29:34, dhl.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

// Include shipping mod script
require_once $xcart_dir.'/shipping/mod_DHL.php';

class XC_DHL_GetLabels extends XC_DHL_Request { // {{{

    protected function __construct()
    { // {{{
        // Call parent constructor
        parent::__construct();
    } // }}}

    protected function prepareRequestData($orderData)
    { // {{{
        global $config;

        $siteID = $this->shippingOptions['ID'];
        $password = $this->shippingOptions['PASSWORD'];

        $account  =$this->shippingOptions['ACCOUNT'];

        $messageTime = date('Y-m-d\TH:i:sP');
        $messageReference = md5($messageTime);

        $items = $orderData['products'];

        // Load DHL functions
        x_load('dhl', 'pack');

        $regionCode = XCDHLReferenceData::getRegionByCountry(XCShipFrom::getCountry());

        $consignee = array();
        $consigneeCountryInfo = XCDHLReferenceData::getCountryInfo($orderData['order']['s_country']);

        $consignee['CompanyName'] = func_slg_cut_value($orderData['order']['company'], 25);
        $consignee['AddressLine1'] = $orderData['order']['s_address'];
        $consignee['AddressLine2'] = $orderData['order']['s_address_2'];
        $consignee['City'] = $orderData['order']['s_city'];
        $consignee['PostalCode'] = $orderData['order']['s_zipcode'];
        $consignee['CountryCode'] = $consigneeCountryInfo['country_code'];
        $consignee['CountryName'] = $consigneeCountryInfo['country'];
        $consignee['Contact'] = array (
            'PersonName' => "{$orderData['order']['s_firstname']} {$orderData['order']['s_lastname']}",
            'PhoneNumber' => $orderData['order']['s_phone']
        );

        $shipper = array();
        $shipperCountryInfo = XCDHLReferenceData::getCountryInfo(XCShipFrom::getCountry());

        $shipper['CompanyName'] = func_slg_cut_value($config['Company']['company_name'], 25);
        $shipper['AddressLine'] = $config['Company']['location_address'];
        $shipper['City'] = $config['Company']['location_city'];
        $shipper['PostalCode'] = $config['Company']['location_zipcode'];
        $shipper['CountryCode'] = $shipperCountryInfo['country_code'];
        $shipper['CountryName'] = $shipperCountryInfo['country'];
        $shipper['Contact'] = array (
            'PersonName' => $config['Company']['store_name'],
            'PhoneNumber' => $config['Company']['company_phone']
        );

        // Get DHL options
        $oDHLOptions = XC_DHL_Options::getInstance();

        // Get specified_dims
        $specified_dims = $oDHLOptions->getSpecifiedDims();
        // Get package limits
        $package_limits = func_get_package_limits_DHL($consignee['CountryCode']);

        $packageList = array();

        foreach ($package_limits as $package_limit) {
            // Get packages
            $packages = func_get_packages($items, $package_limit, ($oDHLOptions->useMultiplePackages() == 'Y') ? 100 : 1);

            if (empty($packages) || !is_array($packages)) {
                continue;
            }

            foreach ($packages as $pack) {
                $pack_key = md5(serialize($pack));

                if (isset($packageList[$pack_key])) {
                    continue;
                }

                if ($oDHLOptions->useMaximumDimensions() == 'Y') {
                    $pack = func_array_merge($pack, $specified_dims);
                }

                $packageList[$pack_key] = $pack;
            }
        }

        $pieces = ''; // pieces XML holder
        $id = $totalWeight = 0;

        foreach ($packageList as $package) {
            $id++;

            $length = max(1, func_units_convert(func_dim_in_centimeters($package['length']), 'cm', 'in', 0));
            $width = max(1, func_units_convert(func_dim_in_centimeters($package['width']), 'cm', 'in', 0));
            $height = max(1, func_units_convert(func_dim_in_centimeters($package['height']), 'cm', 'in', 0));

            $weight = max(1, func_units_convert(func_weight_in_grams($package['weight']), 'g', 'lbs', 0));

            $pieces .= <<<PIECES
<Piece>
  <PieceID>{$id}</PieceID>
  <Weight>{$weight}</Weight>
  <Width>{$width}</Width>
  <Height>{$height}</Height>
  <Depth>{$length}</Depth>
</Piece>
PIECES;
            $totalWeight += $weight;
        }

        $numberOfPieces = count($packageList);

        $declaredValue = $oDHLOptions->getDeclaredValue($orderData['order']['total']);
        $declaredCurrency = $oDHLOptions->getDeclaredCurrency();

        $isDutiable = $declaredValue !== XC_DHL_Options::DHL_OPTION_DISABLED ? 'Y' : 'N';

        if ($isDutiable === 'Y') {
            $dutiable =
                '<Dutiable>' .
                    "<DeclaredValue>{$declaredValue}</DeclaredValue>" .
                    "<DeclaredCurrency>{$declaredCurrency}</DeclaredCurrency>" .
                '</Dutiable>';
        }

        $currency = $oDHLOptions->getCurrency();

        $shippingProductInfo = XCDHLReferenceData::getProductInfo(func_dhl_check_shippingid($orderData['order']['shippingid']));

        $globalProductCode = $shippingProductInfo['global_product_code'];
        $localProductCode = $shippingProductInfo['global_product_code'];

        $date = date('Y-m-d', $orderData['order']['date'] + SECONDS_PER_DAY + $config['Appearance']['timezone_offset']);

        $xmlRequest = // Prepare XML request
<<<XML_REQUEST
<?xml version="1.0" encoding="utf-8"?>
<req:ShipmentRequest xmlns:req="http://www.dhl.com" schemaVersion="1.0">
  <Request>
    <ServiceHeader>
      <MessageTime>{$messageTime}</MessageTime>
      <MessageReference>{$messageReference}</MessageReference>
      <SiteID>{$siteID}</SiteID>
      <Password>{$password}</Password>
    </ServiceHeader>
  </Request>
  <RegionCode>{$regionCode}</RegionCode>
  <RequestedPickupTime>Y</RequestedPickupTime>
  <NewShipper>Y</NewShipper>
  <LanguageCode>en</LanguageCode>
  <PiecesEnabled>Y</PiecesEnabled>
  <Billing>
    <ShipperAccountNumber>{$account}</ShipperAccountNumber>
    <ShippingPaymentType>S</ShippingPaymentType>
    <BillingAccountNumber>{$account}</BillingAccountNumber>
    <DutyPaymentType>R</DutyPaymentType>
  </Billing>
  <Consignee>
    <CompanyName>{$consignee['CompanyName']}</CompanyName>
    <AddressLine>{$consignee['AddressLine1']}</AddressLine>
    <AddressLine>{$consignee['AddressLine2']}</AddressLine>
    <City>{$consignee['City']}</City>
    <PostalCode>{$consignee['PostalCode']}</PostalCode>
    <CountryCode>{$consignee['CountryCode']}</CountryCode>
    <CountryName>{$consignee['CountryName']}</CountryName>
    <Contact>
      <PersonName>{$consignee['Contact']['PersonName']}</PersonName>
      <PhoneNumber>{$consignee['Contact']['PhoneNumber']}</PhoneNumber>
    </Contact>
  </Consignee>
  {$dutiable}
  <Reference>
    <ReferenceID>Order#{$orderData['order']['orderid']}</ReferenceID>
  </Reference>
  <ShipmentDetails>
    <NumberOfPieces>{$numberOfPieces}</NumberOfPieces>
    <Pieces>
      {$pieces}
    </Pieces>
    <Weight>{$totalWeight}</Weight>
    <WeightUnit>L</WeightUnit>
    <GlobalProductCode>{$globalProductCode}</GlobalProductCode>
    <LocalProductCode>{$localProductCode}</LocalProductCode>
    <Date>{$date}</Date>
    <Contents>Order#{$orderData['order']['orderid']}</Contents>
    <DimensionUnit>I</DimensionUnit>
    <IsDutiable>{$isDutiable}</IsDutiable>
    <CurrencyCode>{$currency}</CurrencyCode>
  </ShipmentDetails>
  <Shipper>
    <ShipperID>{$account}</ShipperID>
    <CompanyName>{$shipper['CompanyName']}</CompanyName>
    <RegisteredAccount>{$account}</RegisteredAccount>
    <AddressLine>{$shipper['AddressLine']}</AddressLine>
    <City>{$shipper['City']}</City>
    <PostalCode>{$shipper['PostalCode']}</PostalCode>
    <CountryCode>{$shipper['CountryCode']}</CountryCode>
    <CountryName>{$shipper['CountryName']}</CountryName>
    <Contact>
      <PersonName>{$shipper['Contact']['PersonName']}</PersonName>
      <PhoneNumber>{$shipper['Contact']['PhoneNumber']}</PhoneNumber>
    </Contact>
  </Shipper>
  <LabelImageFormat>PDF</LabelImageFormat>
</req:ShipmentRequest>
XML_REQUEST;
        return $xmlRequest;
    } // }}}

    public static function getInstance()
    { // {{{
        // Call parent getter
        return parent::getClassInstance(__CLASS__);
    } // }}}

    public function getShipmentInfo($shippingData)
    { // {{{
        // Get shipment info
        $shipmentInfo = $this->func_make_request_DHL($shippingData);
        return $shipmentInfo;
    } // }}}
} // }}}

/**
 * Fetch DHL shipping label
 */
function func_slg_handler_DHL($order)
{
    global $intershipper_error;

    $response = array('label' => '', 'mime_type' => '', 'error' => '');

    if (empty($order) || empty($order['products'])) {
        $response['error'] = func_get_langvar_by_name("lbl_slg_order_no_products", false, false, true);
        return $response;
    }

    if (!XC_DHL_Options::getInstance()->isConfigured()) {
        $response['error'] = 'Empty DHL credentials (please check General Settings &gt; Shipping options page.';
        return $response;
    }

    $shipmentInfo = XC_DHL_GetLabels::getInstance()->getShipmentInfo($order);

    $image = func_array_path($shipmentInfo, 'RES:SHIPMENTRESPONSE/#/LABELIMAGE/0/#/OUTPUTIMAGE/0/#');

    if (!empty($intershipper_error)) {
        // Collect information about DHL request error
        $response['error'] = $intershipper_error;
    } else {
        // Store label data
        $response['label'] = base64_decode(str_replace(array("\n"), array(""), $image));
        $response['mime_type'] = 'application/pdf';
    }

    return $response;
}

?>
