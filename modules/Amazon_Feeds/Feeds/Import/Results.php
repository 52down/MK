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
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v4 (xcart_4_7_7), 2017-01-24 09:29:34, Results.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

namespace XCart\Modules\AmazonFeeds\Feeds\Import;

/**
 * @see 
 */
class Results extends Feed { // {{{

    const
        className = __CLASS__,

        FEED_RESULT_ERROR_CODE = 'Error',
        FEED_RESULT_WARNING_CODE = 'Warning';

    protected function defineFeedName()
    { // {{{
        return self::FEED_SUBMIT_RESULT;
    } // }}}

    protected function defineOperation()
    { // {{{
        return self::AMAZON_FEEDS_OPERATION_RESULT;
    } // }}}

    protected function defineColumns()
    { // {{{
        $columns = array(
            'MessageID' => array(),
            'ResultCode' => array(),
            'ResultMessageCode' => array(),
            'ResultDescription' => array(),
            'AdditionalInfo' => array(
                'SKU' => array(),
            ),
        );

        return $columns;
    } // }}}

    protected function defineDataset()
    { // {{{
        return array (
            self::DATA_SOURCE =>
                'amazon_feeds_results',
        );
    } // }}}

    // {{{ Setters and formatters

    /**
     * Set column value for 'ResultCode' column
     *
     * @param array   $record  Record
     * @param \SimpleXMLElement   $xml    Result
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function setResultCodeColumnValue(array &$record, \SimpleXMLElement $xml, $name, $info)
    { // {{{
        $record['result'] = (
            ($code = $xml->xpath('ResultCode'))
                && !empty($code[0])
                && $code[0] === self::FEED_RESULT_ERROR_CODE
            ? \XCAmazonFeedsDefs::FEED_RESULT_ERROR_CODE
            : \XCAmazonFeedsDefs::FEED_RESULT_WARNING_CODE
        );

        return !empty($record['result']);
    } // }}}

    /**
     * Set column value for 'ResultMessageCode' column
     *
     * @param array   $record  Record
     * @param \SimpleXMLElement   $xml    Result
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function setResultMessageCodeColumnValue(array &$record, \SimpleXMLElement $xml, $name, $info)
    { // {{{
        $record['code'] = (
            ($code = $xml->xpath('ResultMessageCode'))
                && !empty($code[0])
            ? (string) $code[0]
            : ''
        );

        return !empty($record['code']);
    } // }}}

    /**
     * Set column value for 'ResultDescription' column
     *
     * @param array   $record  Record
     * @param \SimpleXMLElement   $xml    Result
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function setResultDescriptionColumnValue(array &$record, \SimpleXMLElement $xml, $name, $info)
    { // {{{
        $record['message'] = (
            ($message = $xml->xpath('ResultDescription'))
                && !empty($message[0])
            ? (string) $message[0]
            : ''
        );

        return !empty($record['message']);
    } // }}}

    /**
     * Set column value for 'AdditionalInfo' column
     *
     * @param array   $record  Record
     * @param \SimpleXMLElement   $xml    Result
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function setAdditionalInfoColumnValue(array &$record, \SimpleXMLElement $xml, $name, $info)
    { // {{{
        $sku = ($sku = $xml->xpath('AdditionalInfo/SKU'))
                && !empty($sku[0])
            ? (string) $sku[0]
            : '';

        $data = func_amazon_feeds_get_productid_by_productcode($sku);

        if (empty($sku) || empty($data)) {
            return false;
        }

        $record['productid'] = $data['productid'];
        $record['variantid'] = $data['variantid'];

        return !empty($record['productid']);
    } // }}}

    // }}} Getters and formatters

} // }}}
