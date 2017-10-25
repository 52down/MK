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
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v4 (xcart_4_7_7), 2017-01-24 09:29:34, Relationships.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

namespace XCart\Modules\AmazonFeeds\Feeds\Export;

/**
 * Relationships feed
 *
 * @see https://sellercentral.amazon.com/gp/help/200386850
 */
class Relationships extends \XCart\Modules\AmazonFeeds\Feeds\Export\Feed { // {{{

    const className = __CLASS__;

    const
        /**
         * Variation
         */
        RELATION_TYPE_VARIATION = 'Variation',
        /**
         * Accessory
         */
        RELATION_TYPE_ALTERNATE = 'Alternate';

    protected function defineFeedName()
    { // {{{
        return self::MESSAGE_TYPE_RELATIONSHIP;
    } // }}}

    protected function defineOperation()
    { // {{{
        return self::AMAZON_FEEDS_OPERATION_UPDATE;
    } // }}}

    protected function defineColumns()
    { // {{{
        /**
         * @see https://sellercentral.amazon.com/gp/help/200386850
         */
        $columns = array(
            'ParentSKU' => array(),
            'Relation' => array(
                'SKU' => array(),
                'Type' => array(),
            )
        );

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

    // {{{ Getters and formatters

    /**
     * Get column value for 'Relation' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getParentSKUColumnValue(array $dataset, $name, $info)
    { // {{{
        if (!empty($dataset['variantid'])) {
            return func_amazon_feeds_get_productcode_by_variantid($dataset['variantid']);
        }
    } // }}}

    /**
     * Get column value for 'Relation' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     */
    protected function getRelationColumnValue(array $dataset, $name, $info)
    { // {{{
        if (!empty($dataset['variantid'])) {
            $this->_xmlWriter->startElement($name);
                $this->_xmlWriter->writeElement('SKU', $dataset['productcode']);
                $this->_xmlWriter->writeElement('Type', self::RELATION_TYPE_VARIATION);
            $this->_xmlWriter->endElement();
        }
    } // }}}

    // }}} Getters and formatters

} // }}}
