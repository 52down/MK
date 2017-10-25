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
 * @version    81dfaf9ff6d8b3fecb9f96779dab38823056bfa6, v5 (xcart_4_7_8), 2017-04-14 19:26:52, Images.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

namespace XCart\Modules\AmazonFeeds\Feeds\Export;

/**
 * Images feed
 *
 * @see https://sellercentral.amazon.com/gp/help/200386840
 */
class Images extends \XCart\Modules\AmazonFeeds\Feeds\Export\Feed {

    const className = __CLASS__;

    const
        /**
         * Main image for the product
         */
        IMAGE_TYPE_MAIN = 'Main',
        /**
         * Other views of the product
         */
        IMAGE_TYPE_ALTERNATE = 'Alternate',
        /**
         * Color or fabric (Note: Swatch images will be scaled down to 30 x 30 pixels
         * so they should only be used for displaying the color of your product's fabric, for
         * example, not for displaying your whole product.)
         */
        IMAGE_TYPE_SWATCH = 'Swatch';

    protected function defineFeedName()
    { // {{{
        return self::MESSAGE_TYPE_IMAGE;
    } // }}}

    protected function defineOperation()
    { // {{{
        return self::AMAZON_FEEDS_OPERATION_UPDATE;
    } // }}}

    protected function defineColumns()
    { // {{{
        /**
         * @see https://sellercentral.amazon.com/gp/help/200386840
         */
        $columns = array(
            'SKU' => array(),
            'ImageType' => array(),
            'ImageLocation' => array()
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
     * Get column value for 'ImageType' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getImageTypeColumnValue(array $dataset, $name, $info)
    { // {{{
        return self::IMAGE_TYPE_MAIN;
    } // }}}

    /**
     * Get column value for 'ImageLocation' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getImageLocationColumnValue(array $dataset, $name, $info)
    { // {{{
        global $active_modules, $xcart_http_host;

        // Detect product thumbnail and image
        $image_ids = array();

        $prefered_image_type = 'P';
        if (
            !empty($dataset['variantid'])
            && !empty($active_modules['Product_Options'])
        ) {
            $prefered_image_type = 'W';
            $image_ids['W'] = $dataset['variantid'];
        }

        $image_ids['P'] = $dataset['productid'];
        $image_ids['T'] = $dataset['productid'];

        $images = func_get_image_url_by_types($image_ids, $prefered_image_type);
        $image_url = $images['image_url'];

        if (defined('XC_NGROK_PROXY')) {
            $image_url = str_replace($xcart_http_host, XC_NGROK_PROXY, $image_url);
        }

        return $image_url;
    } // }}}

    // }}} Getters and formatters

}
