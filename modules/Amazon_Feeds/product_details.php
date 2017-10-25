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
 * Product country restrictions
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage
 * @author     Michael Bugrov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    5a3bb4dd1fb27e8b32d3a81a9ca5283dee6f9945, v9 (xcart_4_7_8), 2017-04-24 18:24:39, product_details.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined("XCART_SESSION_START") ) { header("Location: ../"); die("Access denied"); }

if ( !func_amazon_feeds_is_available() ) {
    // Skip initialization if not available
    return;
}

if ($REQUEST_METHOD == 'POST') {
    if (!empty($product[XCAmazonFeedsDefs::FEED_PRODUCT_TYPE])) {

        $_amazon_feeds_product_type = $product[XCAmazonFeedsDefs::FEED_PRODUCT_TYPE];

        if ($_amazon_feeds_product_type != XCAmazonFeedsDefs::SEARCH_FORM_EMPTY_CAT_VALUE) {
            func_array2insert($sql_tbl['amazon_feeds_catalog'], array(
                'productid' => intval($productid),
                'product_type' => $_amazon_feeds_product_type
            ), true);
        }
        $pids2update = array($productid);

        if($geid && !empty($fields) && $fields[XCAmazonFeedsDefs::FEED_PRODUCT_TYPE] == 'Y') {
            $amazon_feeds_delim = '(';
            while ($pids = func_ge_each($geid, 100, $productid)) {

                $amazon_feeds_cat_values = '';
                while (($pid = array_shift($pids)) && !empty($pid)) {
                    $pids2update[] = $pid;
                    $amazon_feeds_cat_values
                        .= "$amazon_feeds_delim'{$pid}', '{$_amazon_feeds_product_type}')";

                    $amazon_feeds_delim = ', (';
                }

                if ($_amazon_feeds_product_type != XCAmazonFeedsDefs::SEARCH_FORM_EMPTY_CAT_VALUE) {
                    db_query("REPLACE INTO $sql_tbl[amazon_feeds_catalog] VALUES $amazon_feeds_cat_values");
                }
            }
        }

        if ($_amazon_feeds_product_type == XCAmazonFeedsDefs::SEARCH_FORM_EMPTY_CAT_VALUE) {
            $pids2update = func_amazon_feeds_reset_exported_flag($pids2update, 'delete_flag');
            db_query("DELETE FROM $sql_tbl[amazon_feeds_catalog] WHERE productid IN ('" . implode("', '", $pids2update) . "')");
        } else {
            func_amazon_feeds_reset_exported_flag($pids2update);
        }

        $top_message['content'] = func_get_langvar_by_name('msg_adm_amazon_feeds_applied');
        $top_message['type']    = 'I';

    } else {

        $top_message['content'] = func_get_langvar_by_name('err_amazon_feeds_type_required');
        $top_message['type']    = 'E';
    }

    func_refresh(XCAmazonFeedsDefs::PRODUCT_SECTION);
}

if ($section == XCAmazonFeedsDefs::PRODUCT_SECTION) {
    $product_info['amazon_feeds_product_type'] = func_amazon_feeds_get_product_type($productid);
    $product_info['amazon_feeds_results'] = func_amazon_feeds_get_feeds_results($productid);

    $smarty->assign('amazon_feeds_catalog', XCAmazonFeedsConfig::getInstance()->getProductTypes());
}
