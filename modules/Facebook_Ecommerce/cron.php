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
 * Module configuration update by cron
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ildar Amankulov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    6c63806b2654732df812bfe1dd496de111c2a9d3, v1 (xcart_4_7_8), 2017-05-23 12:51:22, cron.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

function func_facebook_ecomm_update_all_feeds() {
    global $sql_tbl, $config, $xcart_dir;

    $res = 'Facebook_Ecommerce: ';
    switch ($config['Facebook_Ecommerce']['facebook_ecomm_frequency_feed']) {
        case 'hourly':
            $delta = SECONDS_PER_HOUR;
            break;
        case 'daily':
            $delta = SECONDS_PER_DAY;
            break;
        case 'weekly':
            $delta = SECONDS_PER_WEEK;
            break;
        default:
            return $res . '"Frequency of product feeds renewal" is not defined';
    }

    $feeds2update = func_query("SELECT * FROM $sql_tbl[facebook_ecomm_feed_files] WHERE update_date < " . (XC_TIME - $delta));
    if (empty($feeds2update)) {
        return $res . 'None of feeds have been updated';
    }

    $ids2export_count = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[facebook_ecomm_marked_products]");
    if ($ids2export_count == 0) {
        return $res . 'None of products are selected for export';
    }

    include_once $xcart_dir . XC_DS . 'include/classes/class.csvFileExporter.php';
    $start_text = '';
    $export_params = array(
        'weight_unit' => $config['Facebook_Ecommerce']['facebook_ecomm_weight_unit'],
        'module_name' => 'Facebook_Ecommerce',

    );

    $i = 0;
    foreach ($feeds2update as $feed) {
        $export_params['currency'] = $feed['currency_code'];
        $export_params['language'] = $feed['language_code'];
        $export_params['age_group'] = $feed['age_group'];
        $full_filename = $feed['path'] . $feed['filename'];

        @unlink($full_filename);// update mode ON DUPLICATE KEY will work for the existent filename
        $fileExporter = new \XC\csvFileExporter($full_filename, $start_text, $export_params);

        defined('X_INTERNAL_CRON') && ob_start();
        $save_result = $fileExporter->saveProducts(array('join' => "INNER JOIN $sql_tbl[facebook_ecomm_marked_products] ON $sql_tbl[facebook_ecomm_marked_products].productid=$sql_tbl[products].productid"));
        defined('X_INTERNAL_CRON') && ob_end_clean();

        db_query("UPDATE $sql_tbl[facebook_ecomm_feed_files] SET update_date='" . XC_TIME . "',rows_count=" . intval($save_result['real_exported_count_ids']) . " WHERE id=" . intval($feed['id']));
        $i++;
    }

    return $res . $i . ' feeds have been updated';
}
