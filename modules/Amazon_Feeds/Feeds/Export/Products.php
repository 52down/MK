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
 * Classes
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Michael Bugrov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    d64b9edd8b1b9c64b9fe8c8756002b5bae68c892, v9 (xcart_4_7_8), 2017-05-12 19:55:55, Products.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

namespace XCart\Modules\AmazonFeeds\Feeds\Export;

/**
 * Products feed
 * 
 * @see https://sellercentral.amazon.com/gp/help/200386810
 */
class Products extends \XCart\Modules\AmazonFeeds\Feeds\Export\Feed {

    const className = __CLASS__;
    protected $standardProductIDTypes = array('ISBN','UPC','EAN','ASIN','GTIN','GCID','PZN');

    protected function defineFeedName()
    { // {{{
        return self::MESSAGE_TYPE_PRODUCT;
    } // }}}

    protected function defineOperation()
    { // {{{
        return self::AMAZON_FEEDS_OPERATION_UPDATE;
    } // }}}

    protected function defineColumns()
    { // {{{
        /**
         * @see https://sellercentral.amazon.com/gp/help/200386810
         */
        $columns = array( // <editor-fold>
            'SKU' => array(),
            'StandardProductID' => array(),
            'ProductTaxCode' => array(),
            'LaunchDate' => array(),
            'ReleaseDate' => array(),
            'Condition' => array(),
            'Rebate' => array(),
            'ItemPackageQuantity' => array(),
            'NumberOfItems' => array(),
            'DescriptionData' => array(
                'Title' => array(),
                'Description' => array(),
                'Brand' => array(),
                'BulletPoint' => array(),
                'ItemDimensions' => array(
                    'Weight' => array()
                ),
                'PackageDimensions' => array(
                    'Length' => array(),
                    'Width' => array(),
                    'Height' => array()
                ),
                'PackageWeight' => array(),
                'ShippingWeight' => array(),
                'Manufacturer' => array(),
                'LegalDisclaimer' => array(),
                'SearchTerms' => array(),
                'Memorabilia' => array(),
                'Autographed' => array(),
                'UsedFor' => array(),
                'ItemType' => array(),
                'OtherItemAttributes' => array(),
                'TargetAudience' => array(),
                'SubjectContent' => array(),
                'IsGiftWrapAvailable' => array(),
                'IsGiftMessageAvailable' => array(),
                'IsDiscontinuedByManufacturer' => array(),
                'MaxAggregateShipQuantity' => array(),
                'TSDAgeWarning' => array(),
                'TSDWarning' => array(),
                'TSDLanguage' => array(),
            ),
            'ProductData' => array()
        ); // </editor-fold>

        return $columns;
    } // }}}

    protected function defineDataset()
    { // {{{
        global $sql_tbl;

        $dataset = parent::defineDataset();

        $dataset[self::DATA_FILTER] =
            " $sql_tbl[amazon_feeds_exports].exported = '" . self::DATASET_STATUS_PENDING . "'";

        return $dataset;
    } // }}}

    // {{{ Getters and formatters

    /**
     * Get column value for 'StandardProductID' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     */
    protected function getStandardProductIDColumnValue(array $dataset, $name, $info)
    { // {{{

        $extra_fields = $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $this->standardProductIDTypes);

        if (!empty($extra_fields)) {
            foreach ($this->standardProductIDTypes as $field_name) {
                if (isset($extra_fields[$field_name])) {
                    $type = $field_name;
                    $value = $extra_fields[$field_name];
                    break;
                }
            }

        } elseif (
            ($type = $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name))
            && !empty($type)
            && ($value = $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $type))
            && $value !== false
        ) {
            //Do nothing
        } else {
            $type = 'EAN';
            $value = $this->getSKUColumnValue($dataset, $name, $info);
        }

        $this->_xmlWriter->startElement($name);
            $this->_xmlWriter->writeElement('Type', $type);
            $this->_xmlWriter->writeElement('Value', $value);
        $this->_xmlWriter->endElement();
    } // }}}

    /**
     * Get column value for 'ProductTaxCode' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getProductTaxCodeColumnValue(array $dataset, $name, $info)
    { // {{{
        $code = $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);

        return !empty($code) ? $code : 'A_GEN_NOTAX';
    } // }}}

    /**
     * Get column value for 'LaunchDate' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getLaunchDateColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'ReleaseDate' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getReleaseDateColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'Condition' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getConditionColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'Rebate' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getRebateColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'ItemPackageQuantity' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getItemPackageQuantityColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'NumberOfItems' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getNumberOfItemsColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'DescriptionData' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->_columns['DescriptionData'];
    } // }}}

    /**
     * Get column value for 'DescriptionData->Title' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataTitleColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->encode_xml_string($dataset['product_name']);
    } // }}}

    /**
     * Get column value for 'DescriptionData->Brand' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataBrandColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'DescriptionData->BulletPoint' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataBulletPointColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'DescriptionData->ItemDimensions' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataItemDimensionsColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->_columns['DescriptionData']['ItemDimensions'];
    } // }}}

    /**
     * Get column value for 'DescriptionData->ItemDimensions->Weight' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataItemDimensionsWeightColumnValue(array $dataset, $name, $info)
    { // {{{
        return $dataset['weight'];
    } // }}}

    /**
     * Get column value for 'DescriptionData->PackageDimensions' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataPackageDimensionsColumnValue(array $dataset, $name, $info)
    { // {{{
        return $dataset['small_item']
            ? $this->_columns['DescriptionData']['PackageDimensions']
            : null;
    } // }}}

    /**
     * Get column value for 'DescriptionData->PackageDimensions->Length' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataPackageDimensionsLengthColumnValue(array $dataset, $name, $info)
    { // {{{
        return $dataset['length'];
    } // }}}

    /**
     * Get column value for 'DescriptionData->PackageDimensions->Width' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataPackageDimensionsWidthColumnValue(array $dataset, $name, $info)
    { // {{{
        return $dataset['width'];
    } // }}}

    /**
     * Get column value for 'DescriptionData->PackageDimensions->Height' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataPackageDimensionsHeightColumnValue(array $dataset, $name, $info)
    { // {{{
        return $dataset['height'];
    } // }}}

    /**
     * Get column value for 'DescriptionData->Description' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataDescriptionColumnValue(array $dataset, $name, $info)
    { // {{{
        list($first_descr, $second_descr) = explode('-', $this->_config->product_feed_descr_type);//afds_product_feed_descr_type
        $first_descr = 'product_' . $first_descr;//'product_descr' or 'product_fulldescr'
        $second_descr = 'product_' . $second_descr;//'product_descr' or 'product_fulldescr'
        return mb_substr($this->encode_xml_string(!empty($dataset[$first_descr]) ? $dataset[$first_descr] : $dataset[$second_descr]), 0, 2000);
    } // }}}

    /**
     * Get column value for 'DescriptionData->Manufacturer' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataManufacturerColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->encode_xml_string($dataset['manufacturer']);
    } // }}}

    /**
     * Get column value for 'DescriptionData->SearchTerms' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataSearchTermsColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->encode_xml_string($dataset['product_keywords']);
    } // }}}

    /**
     * Get column value for 'DescriptionData->LegalDisclaimer' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataLegalDisclaimerColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'DescriptionData->Memorabilia' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataMemorabiliaColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'DescriptionData->Autographed' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataAutographedColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'DescriptionData->UsedFor' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataUsedForColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'DescriptionData->ItemType' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataItemTypeColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'DescriptionData->OtherItemAttributes' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataOtherItemAttributesColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'DescriptionData->TargetAudience' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataTargetAudienceColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'DescriptionData->SubjectContent' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataSubjectContentColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'DescriptionData->IsGiftWrapAvailable' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataIsGiftWrapAvailableColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'DescriptionData->IsGiftMessageAvailable' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataIsGiftMessageAvailableColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'DescriptionData->IsDiscontinuedByManufacturer' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataIsDiscontinuedByManufacturerColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'DescriptionData->MaxAggregateShipQuantity' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataMaxAggregateShipQuantityColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'DescriptionData->TSDAgeWarning' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataTSDAgeWarningColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'DescriptionData->TSDWarning' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataTSDWarningColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'DescriptionData->TSDLanguage' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getDescriptionDataTSDLanguageColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->getExtrafieldValue($dataset['productid'], $dataset['variantid'], $name);
    } // }}}

    /**
     * Get column value for 'ProductData' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     */
    protected function getProductDataColumnValue(array $dataset, $name, $info)
    { // {{{
        $elements_open = explode(\XCAmazonFeedsDefs::FEED_PATH_DELIMITER, $dataset[\XCAmazonFeedsDefs::FEED_PRODUCT_TYPE]);
        $value = array_pop($elements_open);
        $last = array_pop($elements_open);

        $elements_close = $elements_open;

        if (!empty($value)) {
            $this->_xmlWriter->startElement($name);

            while (($element = array_shift($elements_open)) && !empty($element)) {
                $this->_xmlWriter->startElement($element);
            }

            if ($last === 'ProductType') {
                $this->_xmlWriter->startElement($last);
                    $this->_xmlWriter->writeElement($value);
                $this->_xmlWriter->endElement();
            } else {
                if ($last === '_simple_string_ProductType') {
                    $last = 'ProductType';
                }
                $this->_xmlWriter->writeElement($last, $value);
            }

            while (($element = array_shift($elements_close)) && !empty($element)) {
                $this->_xmlWriter->endElement();
            }

            $this->_xmlWriter->endElement();
        }
    } // }}}

    // }}} Getters and formatters

    protected function generateUpdateSQL($dataCache)
    { // {{{
        // Generate SQL
        global $sql_tbl, $active_modules;
        // Get product SKUs
        $SKUs = "'" . implode("', '", array_column($dataCache, 'productcode')) . "'";
        // Get product IDs
        $productsData = func_query(
            "SELECT $sql_tbl[products].productid AS productid,"
            . (
                !empty($active_modules['Product_Options'])
                    ? \XCVariantsSQL::getVariantField('productcode') . ' AS productcode,'
                        . " $sql_tbl[variants].variantid" . ' AS variantid'
                    : " $sql_tbl[products].productcode AS productcode,"
                    . " 0 AS variantid"
            )
            . " FROM $sql_tbl[products]"
            . (
                !empty($active_modules['Product_Options'])
                    ? \XCVariantsSQL::getJoinQueryAllRows()
                    : ''
            )
            . " HAVING productcode IN ($SKUs)"
        );

        $replaceSQL = "REPLACE INTO $sql_tbl[amazon_feeds_exports] VALUES ";
        $deleteSQL = "DELETE FROM $sql_tbl[amazon_feeds_results] WHERE ";
        // Get last record
        $lastElement = end($productsData);

        // Loop through the product ID's list
        foreach ($productsData as $productData) {
            // Search the exported flag for the given SKU in $dataCache
            $filtered = array_filter(
                $dataCache,
                function($arr) use ($productData) {
                    return ($arr['productcode'] == $productData['productcode']);
                }
            );
            if (!empty($filtered)) {
                $result = array_pop($filtered);

                $replaceSQL .= "($productData[productid], $productData[variantid], $result[exported])";
                $deleteSQL .= "(productid = '$productData[productid]' AND variantid = '$productData[variantid]')";

                if ($lastElement !== $productData) {
                    $replaceSQL .= ", ";
                    $deleteSQL .= " OR ";
                }
            }
        }
        // Update records
        return db_query($deleteSQL)
            && db_query($replaceSQL);
    } // }}}

    /**
     * On export finish action
     * 
     * @return type
     */
    protected function onFinished()
    {//{{{
        $filename = $this->getRealPath();
        // Set step data
        $this->_step_progress = 0;
        $this->_step_name = self::STEP_NAME_FINALIZE;
        // Skip empty files
        if (filesize($filename) > 0 && $this->_count > 0) {
            $stepCounter = 1;
            $dataCache = array();

            $lineCounter = 1;
            $linesTotal = $this->getLinesCount($this->getRealPath());

            $this->_xmlReader->open($this->getRealPath());

            $continue = true;

            // read lines
            while ($continue) {

                if (
                    $this->_xmlReader->nodeType === \XMLReader::ELEMENT
                    && $this->_xmlReader->name === $this->_feedname
                ) {
                    $data = $this->_xmlReader->expandXpath('SKU');

                    // Add element to cache
                    $dataCache[] = array (
                        'productcode' => (string) $data[0],
                        'exported' => self::DATASET_STATUS_EXPORTED,
                    );

                    if ($stepCounter == self::RECORDS_PER_STEP) {
                        $this->generateUpdateSQL($dataCache);
                        // Clear buffer
                        $dataCache = array();
                        // Reset counter
                        $stepCounter = 0;
                    }

                    $this->_step_progress = ($lineCounter / $linesTotal) * 100;

                    $stepCounter++;
                    $lineCounter++;
                }

                $continue = $this->_xmlReader->read();
            }

            if (!empty($dataCache)) {
                // Flush the remaining part
                $this->generateUpdateSQL($dataCache);
                // Free memory
                $dataCache = array();
            }

        } else {
            // remove empty file
            unlink($filename);
        }
        // Finished
        $this->_step_progress = 100;
    }//}}}
}
