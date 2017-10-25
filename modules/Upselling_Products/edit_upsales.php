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
 * Module process adding and deleting upsales links
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v58 (xcart_4_7_7), 2017-01-24 09:29:34, edit_upsales.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../../"); die("Access denied"); }

x_load('product');

if ($REQUEST_METHOD == 'POST') {

    if ($mode == 'upselling_links') {

    // Insert upsales link into database

        $flag = false;

        if(!empty($upselling)) {

            foreach($upselling as $pid => $v) {

                func_array2update(
                    'product_links',
                    array(
                        'orderby' => $v,

                    ),
                    "productid2='$pid' AND productid1 = '$productid'"
                );

                if (
                    $geid
                    && $fields['u_product'][$pid]
                ) {

                    while($pid2 = func_ge_each($geid, 1, $productid)) {

                        if(func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[product_links] WHERE productid1 = '$pid2' AND productid2 = '$pid'")) {

                            func_array2update(
                                'product_links',
                                array(
                                    'orderby' => $v,
                                ),
                                "productid1 = '$pid2' AND productid2 = '$pid'"
                            );

                        } else {

                            func_array2insert(
                                'product_links',
                                array(
                                    'orderby'         => $v,
                                    'productid1'     => $pid2,
                                    'productid2'     => $pid,
                                ),
                                true
                            );

                        }

                    }

                }

                $flag = true;

            }

        }

        if (
            !empty($selected_productid)
            || !empty($selected_productid_ids)
        ) {// add new related product{{{
            $selected_productid_ids = !empty($selected_productid) ? array(intval($selected_productid)) : XCAjaxSearchProducts::extractIdsFromStr($selected_productid_ids);

            foreach($selected_productid_ids as $selected_productid) {
                if (
                    $selected_productid == $productid
                    || empty($selected_productid)
                ) {
                    continue;
                }

                if (!func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[product_links] WHERE productid1 = '$productid' AND productid2 = '$selected_productid'")) {

                    $orderby = func_query_first_cell("SELECT MAX(orderby) FROM $sql_tbl[product_links] WHERE productid1 = '$productid'") + 10;

                    func_array2insert(
                        'product_links',
                        array(
                            'productid1'     => $productid,
                            'productid2'    => $selected_productid,
                            'orderby'        => $orderby,
                        )
                    );

                }

                if (
                    !empty($bi_directional) && $bi_directional == 'on'
                    && !func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[product_links] WHERE productid1 = '$selected_productid' AND productid2 = '$productid'")
                ) {

                    $orderby4selected_productid = $orderby = func_query_first_cell("SELECT MAX(orderby) FROM $sql_tbl[product_links] WHERE productid1 = '$selected_productid'") + 10;

                    func_array2insert(
                        'product_links',
                        array(
                            'productid2'    => $productid,
                            'productid1'    => $selected_productid,
                            'orderby'       => $orderby,
                        )
                    );

                } else {
                    $orderby4selected_productid = 0;
                }

                if(
                    !empty($geid)
                    && $fields['new_u_product'] == 'Y'
                ) {

                    if (
                        !empty($bi_directional) && $bi_directional == 'on'
                        && empty($orderby4selected_productid)
                    ) {
                        $orderby4selected_productid = func_query_first_cell("SELECT MAX(orderby) FROM $sql_tbl[product_links] WHERE productid1 = '$selected_productid'");
                    }

                    while($pid = func_ge_each($geid, 1, $productid)) {

                        if(!func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[product_links] WHERE productid1 = '$pid' AND productid2 = '$selected_productid'")) {

                            $orderby = func_query_first_cell("SELECT MAX(orderby) FROM $sql_tbl[product_links] WHERE productid1 = '$pid'") + 10;

                            func_array2insert(
                                'product_links',
                                array(
                                    'productid1'    => $pid,
                                    'productid2'    => $selected_productid,
                                    'orderby'       => $orderby,
                                )
                            );

                        }

                        if (
                            !empty($bi_directional) && $bi_directional == 'on'
                            && !func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[product_links] WHERE productid2 = '$pid' AND productid1 = '$selected_productid'")
                        ) {


                            func_array2insert(
                                'product_links',
                                array(
                                    'productid2'    => $pid,
                                    'productid1'    => $selected_productid,
                                    'orderby'       => ($orderby4selected_productid + 10),
                                )
                            );

                        }

                    } // while($pid = func_ge_each($geid, 1, $productid))

                }

                $flag = true;
            }//foreach($selected_productid_ids as $selected_productid)
        }//}}}

        if ($flag) {

            $top_message['content'] = func_get_langvar_by_name('msg_adm_product_upselling_upd');
            $top_message['type']     = 'I';

        }

        func_refresh('upselling');

    } elseif ($mode == 'del_upsale_link') {

    // Deleting upsales link from database

        if (!empty($uids)) {

            foreach ($uids as $product_link => $tmp) {

                db_query("DELETE FROM $sql_tbl[product_links] WHERE productid1='$productid' AND productid2='$product_link'");

                if (
                    $geid
                    && $fields['u_product'][$product_link]
                ) {

                    while($pid = func_ge_each($geid, 1, $productid)) {

                        db_query("DELETE FROM $sql_tbl[product_links] WHERE productid1='$pid' AND productid2='$product_link'");

                    }

                }

            } // foreach ($uids as $product_link => $tmp)

            $top_message['content'] = func_get_langvar_by_name('msg_adm_product_upselling_del');
            $top_message['type']     = 'I';

        } // if (!empty($uids))

        func_refresh('upselling');

    }

} // if ($REQUEST_METHOD == 'POST')

/**
 * Select all linked products
 */
$product_links = func_query("SELECT $sql_tbl[product_links].orderby, $sql_tbl[products_lng_current].productid, $sql_tbl[products_lng_current].product, $sql_tbl[products].productcode, $sql_tbl[products].forsale FROM $sql_tbl[products] INNER JOIN $sql_tbl[products_lng_current] ON $sql_tbl[products_lng_current].productid=$sql_tbl[products].productid INNER JOIN $sql_tbl[product_links] WHERE ($sql_tbl[products].productid=$sql_tbl[product_links].productid2) AND ($sql_tbl[product_links].productid1='$productid') GROUP BY $sql_tbl[products_lng_current].productid ORDER BY $sql_tbl[product_links].orderby, $sql_tbl[products_lng_current].product");

$smarty->assign('product_links',$product_links);
$smarty->assign('forsale_labels', array('H' => 'lbl_hidden', 'N' => 'lbl_disabled', '' => 'lbl_disabled'));

?>
