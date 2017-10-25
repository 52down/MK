<?php
/* vim: set ts=4 sw=4 sts=4 et: */
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| X-Cart Software license agreement                                           |
| Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>         |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
| PLEASE READ THE FULL TEXT OF SOFTWARE LICENSE AGREEMENT IN THE "COPYRIGHT"  |
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
 * Banner system
 *
 * @category X-Cart
 * @package X-Cart
 * @subpackage Modules
 * @author Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version cf9e608d41c40f761c6416f642a1d0094a6af214, v9 (xcart_4_7_7), 2017-01-24 09:29:34, banner_content.php, aim
 * @link http://www.x-cart.com/
 * @see ____file_see____
 */ 

if (!defined('XCART_SESSION_START')) {
    header('Location: ../../');
    die('Access denied');
}

$bannerid = intval($bannerid);
$bs_current_banner = func_query_first("SELECT * FROM $sql_tbl[banners] WHERE bannerid='$bannerid'");

if (empty($bs_current_banner)) {
    #
    # Invalid bannerid
    #
    func_page_not_found();
} else {
    $smarty->assign('bs_current_banner', $bs_current_banner);
}

#
# Collect images
#

$banner_images = func_query("SELECT * FROM $sql_tbl[images_A] WHERE id='$bannerid' ORDER BY orderby, imageid");

$smarty->assign('banner_images', $banner_images);

#
# Collect html code
#

$html_banners = func_query(
    "
    SELECT $sql_tbl[banners_html].id,
            IF(($sql_tbl[banners_html_lng].code IS NOT NULL AND $sql_tbl[banners_html_lng].lng != ''), $sql_tbl[banners_html_lng].code, $sql_tbl[banners_html].code) as code,
            $sql_tbl[banners_html].avail,
            $sql_tbl[banners_html].order_by
    FROM $sql_tbl[banners_html]
    LEFT JOIN $sql_tbl[banners_html_lng]
    ON $sql_tbl[banners_html_lng].id = $sql_tbl[banners_html].id AND $sql_tbl[banners_html_lng].lng = '$shop_language'
    WHERE $sql_tbl[banners_html].bannerid = '$bannerid'
    ORDER BY $sql_tbl[banners_html].order_by, $sql_tbl[banners_html].id
    ");

$smarty->assign('html_banners', $html_banners);
$smarty->assign('bannerid', $bannerid);

?>
