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
 * Common functions for "Ogone" payment modules
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v11 (xcart_4_7_7), 2017-01-24 09:29:34, func.cc_ogone_common.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

/**
 * Common functions used in the Ogone payment modules
 */
// Related Integration manuals 

// Download User Guides and integration manuals.
// https://secure.ogone.com/ncol/test/download_docs.asp?CSRFSP=/ncol/test/help_menu.asp&CSRFKEY=A16B134F1B9673F137D1005393E8C71A431839A3&CSRFTS=20110203142538      

// e-Commerce Advanced Technical Integration Guide for e-Commerce v.5.0
// https://secure.ogone.com/ncol/Ogone_e-Com-ADV_EN.pdf     

// DirectLink Integration Guide for the Server-to-Server Solution ? Version 3.5 
// https://secure.ogone.com/ncol/Ogone_DirectLink_EN.pdf

// Ogone : Parameter Cookbook
// https://secure.ogone.com/ncol/param_cookbook.asp?CSRFSP=/ncol/test/download_docs.asp&CSRFKEY=475D735E36F453CC6D5AAE067A5D2A3EB02AC426&CSRFTS=20110203142542  

function func_ogone_generate_signature($post, $format, $pp_secret) {

    if ($format == 'simple_array') {

        $params = array();
        foreach ($post as $val) {
            list($k, $v) = explode('=', $val, 2);
            $params[$k] = $v;
        }

    } else {
        $params = $post;

    }


    $_post = array();
    foreach ($params as $k => $v) {
        if ($k != 'SHASIGN' && $v != '') 
            $_post[strtoupper($k)] = $v;
    }

    ksort($_post);
    $signature = '';
    foreach ($_post as $_k => $_v) {
        $signature .= $_k . '=' . $_v . $pp_secret;
    }

    return strtoupper(sha1($signature));
}

?>
