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
 * Feeds downloader
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ildar Amankulov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    141c878b03b2b0cdd5d2b31c952f4e1031962148, v1 (xcart_4_7_8), 2017-05-18 15:44:49, facebook_ecomm_get_file_feed.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require __DIR__.'/top.inc.php';

define('DO_NOT_START_SESSION', 1);
define('QUICK_START', true);
define('SKIP_CHECK_REQUIREMENTS.PHP', true);
define('USE_SIMPLE_DB_INTERFACE', true);

require __DIR__.'/init.php';

if (
    empty($key)
    || func_query_first_cell("SELECT active FROM $sql_tbl[modules] WHERE module_name='Facebook_Ecommerce'") != 'Y'
) {
    exit;
}

include $xcart_dir . '/modules/Facebook_Ecommerce/config.php';

$file = func_query_first("SELECT path, filename FROM $sql_tbl[facebook_ecomm_feed_files] WHERE hash_key='$key'");

if (empty($file['filename'])) {
    exit;
}
db_query("UPDATE $sql_tbl[facebook_ecomm_feed_files] SET fetch_date='" .  XC_TIME . "' WHERE hash_key='$key'");

$file_path = $file['path'] . $file['filename'];
$filename = str_replace('.csv.php', '.csv', $file['filename']);
$fp = @fopen($file_path, 'rb');
if ($fp === false) {
    exit;
}

//header('Content-Type: text/tab-separated-values; name="' . $filename . '"');
header('Content-Type: text/csv; name="' . $filename . '"');
header('Content-Disposition: attachment; filename=' . $filename);
header('Content-Length: ' . (func_filesize($file_path) - strlen(X_LOG_SIGNATURE)));

fseek($fp, strlen(X_LOG_SIGNATURE), SEEK_SET);
fpassthru($fp);
fclose($fp);
