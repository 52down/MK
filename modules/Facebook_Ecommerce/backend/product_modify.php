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
 * @author     Ildar Amankulov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    141c878b03b2b0cdd5d2b31c952f4e1031962148, v1 (xcart_4_7_8), 2017-05-18 15:44:49, product_modify.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */
namespace XC\FacebookEcommerce\Backend;

class ProductModifyPage {

    public static function modify($productid, $add_to_facebook_feed, $geid, $add_to_facebook_feed_ge_checked)
    { // {{{
        global $sql_tbl;
        $add_to_facebook_feed = $add_to_facebook_feed ?: 'N';
        if ($geid && $add_to_facebook_feed_ge_checked) {
            if ($add_to_facebook_feed == 'N') {
                db_query("DELETE FROM $sql_tbl[facebook_ecomm_marked_products] WHERE productid IN (" . func_ge_query($geid) . ")");
            } else {
                db_query("REPLACE INTO $sql_tbl[facebook_ecomm_marked_products] (productid) " . func_ge_query($geid));
            }
        } else {
            if ($add_to_facebook_feed == 'N') {
                db_query("DELETE FROM $sql_tbl[facebook_ecomm_marked_products] WHERE productid IN ('$productid')");
            } else {
                db_query("REPLACE INTO $sql_tbl[facebook_ecomm_marked_products] (productid) VALUES ($productid)");
            }
        }
    } // }}}

    public static function registerSmartyFunc()
    { // {{{
        global $smarty;
        $smarty->registerPlugin('function', 'get_add_to_facebook_feed', array(__CLASS__, 'tplGetProductFacebookFeedFlag'));
    } // }}}

    public static function tplGetProductFacebookFeedFlag($params, $smarty)
    { // {{{
        global $sql_tbl;
        $add_to_facebook_feed = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[facebook_ecomm_marked_products] WHERE productid=" . intval($params['productid']));
        $smarty->assign($params['assign'], empty($add_to_facebook_feed) ? 'N' : 'Y');
        return '';
    } // }}}

}//}}}
