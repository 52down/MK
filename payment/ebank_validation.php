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
 * Validation script for the "ProxyPay3" payment module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Payment interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v42 (xcart_4_7_7), 2017-01-24 09:29:34, ebank_validation.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require __DIR__.'/auth.php';

$Ref = $Ref ? $Ref : $ref;
if (empty($Ref))
    $Ref = $merchantref;

$amount = (isset($amount)) ? $amount : $Amount;
$purchaseamount = (isset($purchaseamount)) ? $purchaseamount : $Purchaseamount;
$currency = (isset($currency)) ? $currency : $Currency;
if (empty($currency)) {
	$currency = '978';
}

if ($Ref) {
    $res = func_query_first("SELECT param1,param2 FROM $sql_tbl[cc_pp3_data] WHERE ref = '".$Ref."'");
    if (empty($res)) {
        print "[TOOBAD]";
        exit;
    }

    if (
        (
            preg_replace('/\D/', '', $res['param1']) == preg_replace('/\D/', '', $amount)
            || $purchaseamount == $res['param1']*100
        )
        && intval($res['param2']) == intval($currency) 
        && $Ref 
        && $amount 
        && $currency
    ) {
        db_query("UPDATE $sql_tbl[cc_pp3_data] SET param3 = 'V' WHERE Ref = '".$Ref."'");
        print "[OK]";

    } else {
        db_query("UPDATE $sql_tbl[cc_pp3_data] SET param3 = 'F' WHERE Ref = '".$Ref."'");
        print "[BAD]";
    }

} else {
    print "[TOOBAD]";
}
exit;
?>
