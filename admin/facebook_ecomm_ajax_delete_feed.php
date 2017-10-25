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
 * Delete Facebook_Ecommerce feed file
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ildar Amankulov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    141c878b03b2b0cdd5d2b31c952f4e1031962148, v1 (xcart_4_7_8), 2017-05-18 15:44:49, facebook_ecomm_ajax_delete_feed.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require '../top.inc.php';

define('QUICK_START', true);
define('SKIP_CHECK_REQUIREMENTS.PHP', true);
define('USE_SIMPLE_SESSION_INTERFACE', true);

if (!defined('DIR_CUSTOMER')) die("ERROR: Can not initiate application! Please check configuration.");

$is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';

if (
    !$is_ajax
    || empty($_POST['id'])
    || empty($_GET['posted_ajax_session_quick_key'])
) {
    echo 'Empty ids';
    exit;
}

require_once $xcart_dir . '/init.php';

if (!func_is_module_enabled('Facebook_Ecommerce')) {
    echo 'Facebook_Ecommerce is disabled';
    exit;
}

$ajax_session_quick_key = x_session_get_var('ajax_session_quick_key');

if (
    empty($ajax_session_quick_key)
    || $ajax_session_quick_key != $posted_ajax_session_quick_key
) {
    echo 'You have to login firstly';
    exit;
}

$include_func = true;
require_once $xcart_dir . "/modules/Facebook_Ecommerce/config.php";

$id = intval($id);

if (!empty($mode) && $mode == 'delete') {
    $exporter = new \XC\FacebookEcommerce\Backend\ExporterFe();
    $exporter->deleteFeed($id);
}
