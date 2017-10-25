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
 * @version    8ec104f1ea845efda49851d4cc2f66268706f62e, v5 (xcart_4_7_8), 2017-03-30 14:07:23, Pricing.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

namespace XCart\Modules\AmazonFeeds\Feeds\Export;

/**
 * Pricing feed
 *
 * @see https://sellercentral.amazon.com/gp/help/200386830
 */
class Pricing extends \XCart\Modules\AmazonFeeds\Feeds\Export\Feed {

    const className = __CLASS__;

    protected function defineFeedName()
    { // {{{
        return self::MESSAGE_TYPE_PRICING;
    } // }}}

    protected function defineOperation()
    { // {{{
        return self::AMAZON_FEEDS_OPERATION_UPDATE;
    } // }}}

    protected function defineColumns()
    { // {{{
        /**
         * @see https://sellercentral.amazon.com/gp/help/200386830
         */
        $columns = array(
            'SKU' => array(),
            'StandardPrice' => array(),
            'MAP' => array(),
        );

        if ($this->_config->pricing_feed_startdate && $this->_config->pricing_feed_enddate) {
            $ts_startdate = func_prepare_search_date($this->_config->pricing_feed_startdate);
            $ts_enddate = func_prepare_search_date($this->_config->pricing_feed_enddate, true);

            $columns['Sale'] = array(
                'StartDate' => array(date('c', $ts_startdate)),
                'EndDate' => array(date('c', $ts_enddate)),
                'SalePrice' => array(),
            );
        }

        return $columns;
    } // }}}

    protected function defineDataset()
    { // {{{
        global $sql_tbl;

        $dataset = parent::defineDataset();

        $dataset[self::DATA_FILTER] =
            " $sql_tbl[amazon_feeds_exports].exported = '" . self::DATASET_STATUS_EXPORTED . "'";

        return $dataset;
    } // }}}

    /**
     * Get column value for 'StandardPrice' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     */
    protected function getStandardPriceColumnValue(array $dataset, $name, $info)
    { // {{{
        $this->_xmlWriter->startElement($name);
            $this->_xmlWriter->writeAttribute('Currency', $this->_config->{\XCAmazonFeedsDefs::CONFIG_VAR_CURRENCY});
            $this->_xmlWriter->text($dataset['price'] * $this->_config->{\XCAmazonFeedsDefs::CONFIG_VAR_CONVERSION_RATE});
        $this->_xmlWriter->endElement();
    } // }}}

    /**
     * Get column value for 'Sale' column if list price greater then usual price
     */
    protected function getSaleColumnValue(array $dataset, $name, $info)
    { // {{{
        $has_list_price = $dataset['list_price'] > 0 && $dataset['price'] <= $dataset['list_price'];

        return $has_list_price ? $this->_columns['Sale'] : null;
    } // }}}

    /**
     * Get column value for 'Sale'->StartDate column
     */
    protected function getSaleStartDateColumnValue(array $dataset, $name, $info)
    { // {{{
        return $info[0];
    } // }}}

    /**
     * Get column value for 'Sale'->EndDate column
     */
    protected function getSaleEndDateColumnValue(array $dataset, $name, $info)
    { // {{{
        return $info[0];
    } // }}}

    protected function getSaleSalePriceColumnValue(array $dataset, $name, $info)
    { // {{{
        $this->_xmlWriter->startElement($name);
            $this->_xmlWriter->writeAttribute('Currency', $this->_config->{\XCAmazonFeedsDefs::CONFIG_VAR_CURRENCY});
            $this->_xmlWriter->text($dataset['list_price'] * $this->_config->{\XCAmazonFeedsDefs::CONFIG_VAR_CONVERSION_RATE});
        $this->_xmlWriter->endElement();
    } // }}}
}// c-lass pricing
