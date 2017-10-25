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
|                                                                             |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

/**
 * Functions of the Cost_Pricing module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ildar Amankulov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v9 (xcart_4_7_7), 2017-01-24 09:29:34, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header('Location: ../'); die('Access denied'); }

class XCCost {
    public static function getCostByProductId($productid)
    { // {{{
        global $sql_tbl;
        static $result = array();

        $md5_args = md5(serialize(array($productid)));
        if (isset($result[$md5_args])) {
            return $result[$md5_args];
        }

        $productid = intval($productid);

        $res = func_query_first_cell("SELECT cost_price FROM $sql_tbl[cp_product_costs] WHERE productid='$productid'");
        $result[$md5_args] = $res;
        return $res;
    } // }}}

    public static function getProductFields()
    { // {{{
        global $sql_tbl;
        return "$sql_tbl[cp_product_costs].cost_price";
    } // }}}

    public static function getProductJoin($product_expr = 0)
    { // {{{
        global $sql_tbl;
        $prod_cond = empty($product_expr) ? '' : "AND $sql_tbl[cp_product_costs].productid = " . $product_expr;
        return "INNER JOIN $sql_tbl[cp_product_costs] ON $sql_tbl[cp_product_costs].productid = $sql_tbl[products].productid $prod_cond";
    } // }}}
}

class XCCostOrder {
    public static function getGrossProfitByQuery($gross_total, $date_condition)
    { // {{{
        global $sql_tbl;
        if (empty($gross_total)) {
            return 0;
        }
        return func_query_first_cell("SELECT $gross_total-SUM(costs_total) FROM $sql_tbl[cp_order_costs] INNER JOIN $sql_tbl[orders] USING(orderid) WHERE 1 $date_condition");
    } // }}}

    public static function setField($in_orders)
    { // {{{
        global $sql_tbl;
        if (empty($in_orders)) {
            return $in_orders;
        }

        $orders = $in_orders;
        array_walk($orders, function(&$val, $key) {
            if ($val['status'] == 'P' || $val['status'] == 'C')
                $val = $val['orderid'];
            else
                $val = 0;
        });#nolint
        $orders = array_filter($orders);

        if (!empty($orders)) {
            $costs_totals = func_query_hash("SELECT orderid, costs_total FROM $sql_tbl[cp_order_costs] WHERE orderid IN ('" . implode("','", $orders) . "')", 'orderid', false, true);

            foreach ($in_orders as $id=>$order) {
                $in_orders[$id]['costs_total'] = isset($costs_totals[$order['orderid']]) ? $costs_totals[$order['orderid']] : 0;
            }
        }
        return $in_orders;
    } // }}}

}

class XCCostOrderChange {
    const DELETE_OLD='DELETE_OLD';

    public static function insert($orderid, $products, $provider, $delete_old = false)
    { // {{{
        global $sql_tbl, $single_mode;
        static $_cp_product_costs;

        if (!is_array($products)) {
            return false;
        }

        foreach ($products as $product) {
            if (!isset($product['cost_price'])) {
                $select_db_needed = true;
            } else {
                $select_db_needed = false;
            }
            break;
        }

        if (
            $select_db_needed
            && empty($_cp_product_costs)
        ) {
            $ids = $products;
            array_walk($ids, function(&$val, $key) {$val = $val['productid'];});#nolint
            $_cp_product_costs = func_query_hash("SELECT productid, cost_price FROM $sql_tbl[cp_product_costs] WHERE productid IN ('" . implode("','", $ids) . "') AND cost_price != 0", 'productid', false, true);
        }

        $cost_sum = 0;
        foreach ($products as $key=>$product) {
            if (!empty($product['deleted'])) {
                continue;
            }

            if ($single_mode || $product['provider'] == $provider) {
                if ($select_db_needed) {
                    $cost_sum += isset($_cp_product_costs[$product['productid']]) ? ($_cp_product_costs[$product['productid']] * $product['amount']) : 0;
                } else {
                    $cost_sum += $product['cost_price'] * $product['amount'];
                }
            }
        }

        if ($delete_old === self::DELETE_OLD) {
            db_query("DELETE FROM $sql_tbl[cp_order_costs] WHERE orderid='$orderid'");
        }

        if (!empty($cost_sum)) { // condition must be deleted when orders INNER JOIN cp_order_costs' will be used
            return db_query("INSERT INTO $sql_tbl[cp_order_costs] (orderid, costs_total) VALUES ('$orderid', '$cost_sum')");
        }
    } // }}}

    public static function deleteOrder($orderid = 0)
    {// {{{
        global $sql_tbl;
        if (empty($orderid)) {
            db_query("DELETE FROM $sql_tbl[cp_order_costs]");
        } else {
            db_query("DELETE FROM $sql_tbl[cp_order_costs] WHERE orderid = " . intval($orderid));
        }

        return true;
    } // }}}
}


class XCCostChange {
    const BOTH='BOTH';
    const VARIANTS='VARIANTS';
    const PRODUCTS='PRODUCTS';

    public static function deleteProduct($productid = 0)
    {// {{{
        global $sql_tbl;
        if (empty($productid)) {
            db_query("DELETE FROM $sql_tbl[cp_product_costs]");
        } else {
            db_query("DELETE FROM $sql_tbl[cp_product_costs] WHERE productid = " . intval($productid));
        }

        return true;
    } // }}}

    public static function repairIntegrity($productids_in = array(), $mode = XCCostChange::BOTH)
    { // {{{
        global $sql_tbl;
        static $result = array();

        $md5_args = md5(serialize(array($productids_in, $mode)));
        if (isset($result[$md5_args])) {
            return $result[$md5_args];
        }

        if (empty($productids_in)) {
            if (in_array($mode, array(XCCostChange::BOTH, XCCostChange::PRODUCTS))) {
                db_query("DELETE FROM $sql_tbl[cp_product_costs] WHERE productid NOT IN (SELECT productid FROM $sql_tbl[products])");
                db_query("INSERT INTO $sql_tbl[cp_product_costs] (productid) (SELECT productid FROM $sql_tbl[products] WHERE productid NOT IN (SELECT productid FROM $sql_tbl[cp_product_costs]))");
            }

        } else {
            $ids = is_array($productids_in) ? $productids_in : array($productids_in);

            if (in_array($mode, array(XCCostChange::BOTH, XCCostChange::PRODUCTS))) {
                db_query("INSERT INTO $sql_tbl[cp_product_costs] (productid) (SELECT productid FROM $sql_tbl[products] WHERE productid IN ('" . implode("','", $ids) . "') AND productid NOT IN (SELECT productid FROM $sql_tbl[cp_product_costs]))");
            }
        }
        $result[$md5_args] = true;
        return true;
    } // }}}

    public static function replace($cost_price, $productids_in)
    {// {{{
        global $sql_tbl;
        $ids = is_array($productids_in) ? $productids_in : array($productids_in);

        $insert_str = '';
        foreach ($ids as $_productid) {
            if (empty($_productid)) {
                continue;
            }
            $insert_str .= "('$_productid','$cost_price'), ";
        }

        if (!empty($insert_str)) {
            $insert_str = rtrim($insert_str, ', ');
            db_query("REPLACE INTO $sql_tbl[cp_product_costs] (productid, cost_price) VALUES $insert_str");
        }

        return true;
    } // }}}
}

class XCCostTpl {

    public static function getCost($params)
    {// {{{
        $productid = isset($params['productid']) ? intval($params['productid']) : 0;
        if (!empty($productid)) {
            $cost_price = XCCost::getCostByProductId($productid);
        } else {
            $cost_price = '';
        }
        $cost_price = isset($params['default']) && empty($cost_price) ? $params['default'] : $cost_price;
        return func_format_number($cost_price);
    } // }}}

    public static function registerSmartyFunctions()
    {// {{{
        global $smarty;
        $smarty->register_function('costp_get_price', array('XCCostTpl','getCost'));
        return true;
    } // }}}
}

function func_costp_system_init()
{ // {{{
    global $smarty, $PHP_SELF, $config;

    $area = (defined('AREA_TYPE')) ? AREA_TYPE : '';
    if (in_array($area, array('A','P'))) {

        // For product modify page
        if (basename($PHP_SELF) == 'product_modify.php') {
            XCCostTpl::registerSmartyFunctions();
        }

        if (defined('ADMIN_MODULES_CONTROLLER')) {
            func_add_event_listener('module.ajax.toggle', 'func_cost_pricing_on_module_toggle');
        }
    }
} //}}}


function func_cost_pricing_on_module_toggle($module_name, $module_new_state)
{ // {{{
    if ($module_name == 'Cost_Pricing' && $module_new_state == true) {
        /*Not used as 'products INNER JOIN cp_product_costs' is used in export_Products.php only
        XCCostChange::repairIntegrity();
        */
    }
} // }}}

function func_costp_product_modify($productid, $cost_price, $geid, $costp_ge_checked)
{//{{{
    global $sql_tbl;
    $cost_price = $cost_price ?: 0;
    if ($geid && $costp_ge_checked) {
        db_query("REPLACE INTO $sql_tbl[cp_product_costs] (productid, cost_price) " . func_ge_query($geid, array('cost_price' => $cost_price)));
    } else {
        XCCostChange::replace($cost_price, $productid);
    }

}//}}}

function func_costp_repair_integrity($mode)
{//{{{
    global $sql_tbl;

    switch ($mode) {
        case 'cost_pricing_repair_orders':
            db_query("DELETE FROM $sql_tbl[cp_order_costs] WHERE orderid NOT IN (SELECT orderid FROM $sql_tbl[orders])");
            break;
        case 'cost_pricing_repair_products':
            XCCostChange::repairIntegrity();
            break;
    }
}//}}}

?>
