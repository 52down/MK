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
 * Upload Image ckeditor handler
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Administration
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v5 (xcart_4_7_7), 2017-01-24 09:29:34, ckedit_uploadimage.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

define('IS_IMAGE_SELECTION', true);
define('QUICK_START', true);
define('SKIP_CHECK_REQUIREMENTS.PHP', true);
define('USE_SIMPLE_SESSION_INTERFACE', true);

require __DIR__.'/auth.php';

if ($config['HTML_Editor']['editor'] != 'ckeditor') {
    exit;
}

func_define('XC_DISABLE_SESSION_SAVE', true);

$include_func = true;
include $xcart_dir . '/modules/HTML_Editor/config.php';


$_POST['_formid'] = $_GET['formid'];
require $xcart_dir . '/include/security.php';

if (
    !func_constant('FORMID_CHECKED')
    || (empty($identifiers['A']) && empty($identifiers['P']))
) {
    echo 'You should login firstly';
    exit;
}

$upload_result = XC_Editor::uploadImage($upload, $upload_size, $upload_type, $image_parent_id, $image_parent_type);

if (!empty($_GET['type']) && $_GET['type'] == 'dragdrop') {
    header('Content-type: application/json');
    $upload_result = $upload_result['data'];
    if (is_string($upload_result) || empty($upload_result['uploaded'])) {
        $upload_result = array('uploaded' => 0, 'error' => array('message' => XC_Editor::prepareErrorMsg($upload_result)));
    }
    echo json_encode($upload_result);
} elseif(empty($upload_result['is_error']) && !empty($upload_result['data']['url'])) {
    $fnum = (int)$_GET['CKEditorFuncNum'];
    $upload_result = $upload_result['data'];
    echo "<script>window.parent.CKEDITOR.tools.callFunction($fnum, '$upload_result[url]', '$upload_result[fileName] uploaded')</script>";
} else {
    echo XC_Editor::prepareErrorMsg($upload_result['data']);
}

exit;
