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
 * Stores params about offers applied to certain products
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    252d8fd2f69d9bf074050dea1c7f5243890be5fc, v27 (xcart_4_7_8), 2017-04-03 09:15:17, product_modify.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!defined('XCART_START')) { header("Location: ../../"); die("Access denied"); }

if ($REQUEST_METHOD == 'POST' && $productid) {

    $sp_data['sp_discount_avail'] = empty($sp_data['sp_discount_avail']) ? 'N' : 'Y';
    $sp_data['bonus_points'] = abs(intval($sp_data['bonus_points']));

    $_query_data = array(
        'productid'            => $productid,
        'sp_discount_avail'    => $sp_data['sp_discount_avail'],
        'bonus_points'        => $sp_data['bonus_points'],
    );

    func_array2insert('offer_product_params', $_query_data, true);

    if ($geid && !empty($fields['sp_data'])) {

        while ($pid = func_ge_each($geid, 1, $productid)) {

            $is_exists = func_query_first_cell("SELECT COUNT(productid) FROM $sql_tbl[offer_product_params] WHERE productid = '".$pid."'");

            $_query_data = array(
                'productid'    => $pid,
            );

            foreach ($fields['sp_data'] as $k => $v) {
                $_query_data[$k] = $sp_data[$k];
            }

            if ($is_exists) {
                func_array2update('offer_product_params', $_query_data, "productid = '".$pid."'");
            } else {
                func_array2insert('offer_product_params', $_query_data);
            }
        }
    }

    if (!mt_rand(0, 60)) {
        db_query("DELETE FROM $sql_tbl[offer_product_params] WHERE productid NOT IN (SELECT productid FROM $sql_tbl[products])");
    }
}
