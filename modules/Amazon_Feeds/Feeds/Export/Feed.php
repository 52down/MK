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
 * @version    df31bcc94430bb1c39b92c45954affa41ffb4320, v6 (xcart_4_7_8), 2017-04-17 18:46:18, Feed.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

namespace XCart\Modules\AmazonFeeds\Feeds\Export;

/**
 * @see
 */
abstract class Feed extends \XCart\Modules\AmazonFeeds\Feeds\Feed { // {{{

    protected $_step_name = self::STEP_NAME_EXPORT;

    protected function defineDataset()
    { // {{{
        global $sql_tbl, $active_modules, $shop_language;

        return array (
            self::DATA_SOURCE => // <editor-fold>
                "$sql_tbl[products]"
                . " INNER JOIN $sql_tbl[amazon_feeds_catalog]"
                    . " ON $sql_tbl[products].productid = $sql_tbl[amazon_feeds_catalog].productid"
                . " INNER JOIN $sql_tbl[products_lng_current]"
                    . " ON $sql_tbl[products].productid = $sql_tbl[products_lng_current].productid"
                . (
                    !empty($active_modules['Product_Options'])
                        ? \XCVariantsSQL::getJoinQueryAllRows()
                        : ''
                )
                . " INNER JOIN $sql_tbl[pricing]"
                    . " ON " . (
                        !empty($active_modules['Product_Options'])
                            ? \XCVariantsSQL::getPricingPVQMCondition()
                            : " $sql_tbl[products].productid = $sql_tbl[pricing].productid"
                                . " AND $sql_tbl[pricing].quantity = '1'"
                                . " AND $sql_tbl[pricing].variantid = '0'"
                    )
                . (
                    !empty($active_modules['Manufacturers'])
                        ? " LEFT JOIN $sql_tbl[manufacturers]"
                            . " ON $sql_tbl[products].manufacturerid = $sql_tbl[manufacturers].manufacturerid"
                            . " LEFT JOIN $sql_tbl[manufacturers_lng]"
                                . " ON $sql_tbl[manufacturers].manufacturerid = $sql_tbl[manufacturers_lng].manufacturerid"
                                . " AND $sql_tbl[manufacturers_lng].code = '$shop_language'"
                        : ''
                )
                . " INNER JOIN $sql_tbl[amazon_feeds_exports]"
                    . " ON $sql_tbl[products].productid = $sql_tbl[amazon_feeds_exports].productid"
                    . (
                        !empty($active_modules['Product_Options'])
                        ? " AND $sql_tbl[variants].variantid = $sql_tbl[amazon_feeds_exports].variantid"
                        : " AND $sql_tbl[amazon_feeds_exports].variantid = '0'"
                    ),
            // </editor-fold>
            self::DATA_FILTER => // <editor-fold>
                " $sql_tbl[amazon_feeds_exports].exported = '" . self::DATASET_STATUS_PENDING . "'"
            // </editor-fold>
        );
    } // }}}

    protected function defineFieldset()
    { // {{{
        global $sql_tbl, $active_modules, $config;

        return // <editor-fold desc="Fields">
            "$sql_tbl[products].*,"
            . " $sql_tbl[amazon_feeds_catalog].product_type AS amazon_feeds_product_type,"
            . " $sql_tbl[products_lng_current].product AS product_name,"
            . " $sql_tbl[products_lng_current].descr AS product_descr,"
            . " $sql_tbl[products_lng_current].fulldescr AS product_fulldescr,"
            . " $sql_tbl[products_lng_current].keywords AS product_keywords,"
            . (
                !empty($active_modules['Product_Options'])
                    ? \XCVariantsSQL::getVariantField('productcode') . ' AS productcode,'
                        . \XCVariantsSQL::getVariantField('avail') . ' AS avail,'
                        . ($config['Product_Options']['po_use_list_price_variants'] == 'Y' ? (\XCVariantsSQL::getVariantField('list_price') . ' AS list_price,') : '')
                        . \XCVariantsSQL::getVariantField('weight') . ' AS weight,'
                        . \XCVariantsSQL::getVariantField('is_product_row') . ' AS is_product,'
                    : " $sql_tbl[products].productcode AS productcode,"
                        . " $sql_tbl[products].avail AS avail,"
                        . " 1 AS is_product,"
            )
            . (
                !empty($active_modules['Manufacturers'])
                    ? "IFNULL($sql_tbl[manufacturers_lng].manufacturer, $sql_tbl[manufacturers].manufacturer) AS manufacturer,"
                    : ''
            )
            . " $sql_tbl[pricing].*"; // </editor-fold>
    } // }}}

    // {{{ Getters and formatters

    /**
     * Get column value for 'SKU' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $info    Column info
     *
     * @return string
     */
    protected function getSKUColumnValue(array $dataset, $name, $info)
    { // {{{
        return $this->encode_xml_string($dataset['productcode']);
    } // }}}

    // }}} Getters and formatters

    protected function getExtrafieldValue($productid, $variantid, $service_names)
    { // {{{
        global $active_modules, $sql_tbl;

        if (
            empty($active_modules['Extra_Fields'])
            || empty($service_names)
        ) {
            return false;
        }

        if (!is_array($service_names)) {
            $query = "SELECT FIELDVALUES.value"
                . " FROM $sql_tbl[extra_fields] AS FIELDS"
                . " INNER JOIN $sql_tbl[extra_field_values] AS FIELDVALUES"
                    . " ON FIELDS.fieldid = FIELDVALUES.fieldid"
                    . " AND FIELDS.service_name = '$service_names'"
                    . " AND FIELDVALUES.productid = '$productid'"
                    . " AND FIELDVALUES.variantid = '$variantid'";
            $result = func_query_first_cell($query);
            $result = empty($result) ? $result : $this->encode_xml_string($result);
        } else {
            $query = "SELECT FIELDS.service_name, FIELDVALUES.value"
                . " FROM $sql_tbl[extra_fields] AS FIELDS"
                . " INNER JOIN $sql_tbl[extra_field_values] AS FIELDVALUES"
                    . " ON FIELDS.fieldid = FIELDVALUES.fieldid"
                    . " AND FIELDS.service_name IN ('" . implode("','", $service_names) . "')"
                    . " AND FIELDVALUES.productid = '$productid'"
                    . " AND FIELDVALUES.variantid = '$variantid'";

            $result = func_query_hash($query, 'service_name', false, true);
            if (!empty($result)) {
                foreach ($result as $k=>$field) {
                    $result[$k] = $this->encode_xml_string($field);
                }
            } else {
                $result = false;
            }
        }


        return $result;
    } // }}}

} // }}}
