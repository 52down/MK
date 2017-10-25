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
 * Recommends list
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Customer interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v68 (xcart_4_7_7), 2017-01-24 09:29:34, recommends.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: home.php"); die("Access denied"); }

$config['Recommended_Products']['number_of_recommends'] = max(intval($config['Recommended_Products']['number_of_recommends']), 0);

$_obj = new XCUpsellingProducts(
    $config['Recommended_Products']['rp_upselling_type'], 
    $config['Recommended_Products']['rp_period_for_also_bought'],
    $config['Recommended_Products']['number_of_recommends']
);
$query_ids = $_obj->getUpsellingProducts($productid);

if (
    !empty($query_ids)
    && !empty($config['Recommended_Products']['number_of_recommends'])
) {
    $_query = array();
    $_query['skip_tables'] = XCSearchProducts::getSkipTablesByTemplate('modules/Recommended_Products/recommends.tpl');

    // Get products data, do not check products availability using these tables
    $_query['skip_tables'] = array_merge($_query['skip_tables'], XCSearchProducts::$tblsToCheckAvailability);
    $_query['query'] = " AND $sql_tbl[products].productid IN ('" . implode("','", $query_ids) . "')";
    $recommends = func_search_products(
        $_query,
        (isset($user_account) && isset($user_account['membershipid']))
            ? max(intval($user_account['membershipid']), 0)
            : 0,
        'skip_orderby',
        $config['Recommended_Products']['number_of_recommends']
    );
}

if (!empty($recommends)) {
    // Used also in "include/product_tabs.php:92:if (!empty($active_modules['Recommended_Products']) && !empty($recommends))"
    $smarty->assignByRef('recommends', $recommends);
}

?>
