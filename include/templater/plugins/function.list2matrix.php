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
 * Smarty {list2matrix} function plugin
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v29 (xcart_4_7_7), 2017-01-24 09:29:34, function.list2matrix.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

/**
 * Smarty {list2matrix} function plugin
 *
 * Type:     function
 * Name:     list2matrix
 * Purpose:  convert list to matrix
 * @param array parameters
 * @param Smarty
 * @return null
 */

if (!defined('XCART_START')) { header("Location: ../../../"); die("Access denied"); }

function smarty_function_list2matrix($params, &$smarty)
{
    if (
        !isset($params['assign']) || !is_string($params['assign']) ||
        !isset($params['assign_width']) || !is_string($params['assign_width']) ||
        !isset($params['list']) || !is_array($params['list']) ||
        !isset($params['row_length'])
    ) {
        return;
    }

    $row_length = max(intval($params['row_length']), 1);

    $result = array();
    $i = 0;
    $n = 0;
    foreach ($params['list'] as $k => $v) {
        $i++;

        if (!isset($result[$n])) {
            $result[$n] = array();
        }

        $result[$n][$k] = $v;

        if ($i % $row_length == 0) {
            $n++;
        }
    }

    if (isset($params['full_matrix']) && $params['full_matrix'] && $i % $row_length != 0) {
        $end = $row_length - ($i % $row_length);
        for ($m = 0; $m < $end; $m++) {
            $result[$n][] = false;
        }
    }

    if (!empty($result)) {
        $smarty->assignByRef($params['assign'], $result);
    } else {
        $smarty->assign($params['assign'], array());
    }
    $smarty->assign($params['assign_width'], floor(100 / $row_length));

    return;
}

?>
