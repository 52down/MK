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
 * Inventory update interface
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Provder interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v72 (xcart_4_7_7), 2017-01-23 20:12:10, inv_update.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require __DIR__.'/auth.php';
require $xcart_dir.'/include/security.php';

x_load('files');

func_set_time_limit(1800);
x_session_register('inv_update_fields', array());

$location[] = array(func_get_langvar_by_name('lbl_update_inventory'), '');

if ($REQUEST_METHOD == 'POST') {
    foreach(array('what', 'first_column_type', 'delimiter') as $val) {
        $inv_update_fields[$val] = $$val;
    }

    $provider_condition = ($single_mode ? '' : " AND $sql_tbl[products].provider='$logged_userid'");

    // Check post_max_size exceeding

    func_check_uploaded_files_sizes('userfile', 522);

    $userfile = func_move_uploaded_file('userfile', 522);
    $pids = $err_rows = array();
    $updated = 0;

    if ($fp = func_fopen($userfile,'r',true)) {

        while ($columns = fgetcsv ($fp, 65536, $delimiter)) {

            if (empty($columns[0])) {
                continue;
            }

            $orig_row = strip_tags(htmlentities(implode($delimiter, $columns)));

            if (count($columns) < 2) {
                $err_rows[] = $orig_row;
                continue;
            }

            $vid = $pid = $productid_of_variant = 0;
            $columns[0] = addslashes($columns[0]);

            $product_cond = strpos($first_column_type, 'productid') !== false && is_numeric($columns[0]) ? " OR productid = '$columns[0]'" : '';
            $product_cond .= strpos($first_column_type, 'sku')        !== false ? " OR productcode = '$columns[0]'" : '';
            if (!empty($product_cond)) {
                $product_data = func_query_first("SELECT productid, avail FROM $sql_tbl[products] WHERE (0 $product_cond) $provider_condition");
                $pid = empty($product_data) ? 0 : $product_data['productid'];
            }

            if (
                !empty($active_modules['Product_Options'])
                && strpos($first_column_type, 'sku') !== false
            ) {
                if (!empty($provider_condition)) {
                    $join_product_query = " INNER JOIN $sql_tbl[products] ON $sql_tbl[products].productid=$sql_tbl[variants].productid";
                } else {
                    $join_product_query = '';
                }
                $variant_data = func_query_first("SELECT $sql_tbl[variants].variantid, $sql_tbl[variants].avail, $sql_tbl[variants].productid FROM $sql_tbl[variants] $join_product_query WHERE $sql_tbl[variants].productcode='$columns[0]' AND ".XCVariantsSQL::isVariantRow().$provider_condition);
                $vid = empty($variant_data) ? 0 : $variant_data['variantid'];
            }

            if (empty($pid) && empty($vid)) {
                continue;
            }

            if (!empty($pid)) {
                $pids[] = $pid;
            } else {
                $productid_of_variant = empty($variant_data['productid']) ? XCVariantsSQL::getProductidByVariantid($vid) : $variant_data['productid'];
                $pids[] = $productid_of_variant;
            }

            if ($what == 'p') {//update price
            //{{{

                // Check price value
                if (!func_is_price($columns[1])) {
                    $err_rows[] = $orig_row;
                    continue;
                } else {
                    $columns[1] = func_detect_price($columns[1]);
                }

                if (strlen($columns[2]) == 0 || $columns[2] < 1) {
                    $columns[2] = 1;
                }

                $membershipid = func_detect_membership(trim($columns[3]));
                if (!empty($pid)) {
                    db_query ("UPDATE $sql_tbl[pricing] SET price='".$columns[1]."' WHERE productid='$pid' AND quantity='".(int)$columns[2]."' AND membershipid = '$membershipid' AND variantid = '0'");
                }
                if (!empty($vid)) {
                    db_query ("UPDATE $sql_tbl[pricing] SET price='".$columns[1]."' WHERE quantity='".(int)$columns[2]."' AND membershipid = '$membershipid' AND variantid = '$vid'");
                }

                // Notify customers about a price drops if needed
                if (!empty($active_modules['Product_Notifications'])) {
                    func_product_notifications_trigger($pid, $vid, 'P');
                }
            //}}}
            } else {//update quantity
                //{{{
                $avail_str = trim($columns[1]);
                $sign = substr($avail_str, 0, 1);
                if (!is_numeric($sign) && in_array($sign, array('-', '+'))) {
                    $avail = abs(intval(trim(substr($avail_str, 1))));
                } else {
                    $avail = abs(intval($avail_str));
                    $sign = false;
                }

                if (empty($pid)) {
                    $_productid = $productid_of_variant;
                } else {
                    $_productid = $pid;
                }
                if (!empty($pid)) {
                    if (!empty($sign)) {
                        $avail = $sign === '-' && $product_data['avail'] < $avail ? $product_data['avail'] : $avail;
                        db_query ("UPDATE $sql_tbl[products] SET avail=avail $sign $avail WHERE productid='$pid' $provider_condition");
                    } else {
                        db_query ("UPDATE $sql_tbl[products] SET avail=$avail WHERE productid='$pid' $provider_condition");
                    }
                // Do not run XCVariantsChange::update in favour of RepairIntegrity below
                }
                if (!empty($vid)) {
                    if (!empty($sign)) {
                        $avail = $sign === '-' && $variant_data['avail'] < $avail ? $variant_data['avail'] : $avail;
                        $var_changes = array('avail' => "avail $sign '" . $avail . "'");
                    } else {
                        $var_changes = array('avail' => "'" . $avail . "'");
                    }
                    XCVariantsChange::update($_productid, $vid, $var_changes);
                }

                // Notify customers about a price drops if needed
                if (!empty($active_modules['Product_Notifications'])) {
                    func_product_notifications_trigger($pid, $vid, 'B');
                    func_product_notifications_trigger($pid, $vid, 'L');
                }
            //}}}
            }

            $updated++;
        }

        $smarty->assign('main', 'inv_updated');
        $smarty->assign('updated_items', $updated);

        // Display rows with invalid formats for provider (no more then 200 rows on page)

        if (!empty($err_rows)) {
            $smarty->assign('err_rows', array_slice($err_rows, 0, 200));
        }

        if (!empty($pids)) {
            $pids = array_values(array_unique($pids));
            func_build_quick_flags($pids);
            func_build_quick_prices($pids);
        }

        fclose($fp);

    } else {

        $smarty->assign('main', 'error_inv_update');
    }
    @unlink($userfile);

} else {

    $smarty->assign ('main', 'inv_update');
}

$smarty->assign('inv_update_fields', $inv_update_fields);

$smarty->assign('upload_max_filesize', func_convert_to_megabyte(func_upload_max_filesize()));

// Assign the current location line
$smarty->assign('location', $location);

// Assign the section navigation data
$dialog_tools_data = array('help' => true);
$smarty->assign('dialog_tools_data', $dialog_tools_data);

if (is_readable($xcart_dir.'/modules/gold_display.php')) {
    include $xcart_dir.'/modules/gold_display.php';
}
func_display('provider/home.tpl',$smarty);
?>
