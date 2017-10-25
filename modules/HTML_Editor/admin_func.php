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
 * HTML_Editor ckeditor
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v6 (xcart_4_7_7), 2017-01-24 09:29:34, admin_func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!defined('XCART_SESSION_START')) { header("Location: ../../"); die("Access denied"); }

class XC_Editor {
    const UPLOADED_IMAGE_TYPE = 'CKEDIT';

    public static function uploadImage($upload, $upload_size, $upload_type, $image_parent_id, $parent_type) {//{{{
        global $xcart_dir, $config, $ckedit_added_entities;

        $type = self::UPLOADED_IMAGE_TYPE;
        $source = 'L';
        $userfile = $upload;
        $userfile_size = $upload_size;
        $userfile_type = $upload_type;
        $_FILES['userfile'] = $_FILES['upload'];
        unset($upload, $_FILES['upload']);
        $run_as_function = true;
        $image_parent_id = empty($image_parent_id) ? 0 : intval($image_parent_id);
        $id = $image_parent_id;
        $is_error = $ret = $error = $file_upload_data = $top_message = null;

        $config['setup_images'][self::UPLOADED_IMAGE_TYPE] = array (
            'itype'         => self::UPLOADED_IMAGE_TYPE,
            'location'      => 'FS',
            'save_url'      => '',
            'size_limit'    => 0,
            'md5_check'     => '',
            'default_image' => './default_image.gif',
            'image_x'       => 124,
            'image_y'       => 74
        );

        require $xcart_dir . '/include/image_selection.php';

        if (!empty($error) || empty($file_upload_data[self::UPLOADED_IMAGE_TYPE])) {
            $is_error = true;
            $ret = empty($top_message['content']) ? 'Unknown error' : $top_message['content'];
        } else {
            if (func_check_image_posted($file_upload_data, self::UPLOADED_IMAGE_TYPE)) {
                $added_data = array(
                    'orderby' => 10,
                    'parent_type' => empty($parent_type) ? 'custom_parent_field' : $parent_type,
                );
                if (empty($image_parent_id)) {
                    $image_parent_id = -1;
                    $added_data['id'] = 0; // overwrite -1 above
                    if (
                        strpos($parent_type, 'category') !== false
                        || strpos($parent_type, 'product') !== false
                        || strpos($parent_type, 'manufacturer') !== false
                        || strpos($parent_type, 'news_message_body') !== false
                        || strpos($parent_type, 'pagecontent') !== false
                    ) {
                        x_session_register('ckedit_added_entities');
                        $ckedit_added_entities = true;
                        x_session_save();
                    }
                }
                if ($insert_id = func_save_image($file_upload_data, self::UPLOADED_IMAGE_TYPE, $image_parent_id, $added_data)) {
                    $res = self::getFileNamesById($insert_id);

                    $ret = array('uploaded' => 1, 'fileName' => $res['filename'], 'url' => $res['url']);
                } else {
                    $ret = func_get_langvar_by_name('lbl_no_image_uploaded');
                }
            }
        }

        return array('data' => $ret, 'is_error' => $is_error);
    }//}}}

    public static function getFileNamesById($img_id) {//{{{
        global $sql_tbl, $xcart_web_dir;

        $res = func_query_first("SELECT image_path, filename FROM " . $sql_tbl['images_' . self::UPLOADED_IMAGE_TYPE] . " WHERE imageid = " . intval($img_id));
        return $res ? array(
            'filename' => $res['filename'],
            'url' => func_get_image_url_relative($img_id, self::UPLOADED_IMAGE_TYPE, $res['image_path']
        )) : array();
    }//}}}

    public static function prepareErrorMsg($msg) {//{{{
        global $smarty;
        $match = null;
        if (preg_match("/~~~~\|(.+)\|~~~~/S", $msg, $match)) {
            x_load('templater');
            $msg = func_convert_lang_var($msg, $smarty);
        }

        return $msg;
    }//}}}

} // xc_Editor

class XC_EditorProduct {

    public static function removeLink2parent($productid, $data) {//{{{
        global $sql_tbl, $config;
        if (
            $config['HTML_Editor']['editor'] != 'ckeditor'
            || empty($productid)
        ) {
            return false;
        }

        $entities = array();
        foreach (array('descr', 'fulldescr') as $v) {
            if (isset($data[$v])) {
                $entities[] = 'product_' . $v;
            }
        }

        if (empty($entities)) {
            return false;
        }

        db_query("UPDATE $sql_tbl[images_CKEDIT] SET id=0, parent_type='product_gedited' WHERE parent_type IN ('" . implode("','", $entities) . "') AND id=" . intval($productid));
    }//}}}

} // xc_EditorProduct

class XC_EditorEntity {

    public static function updateZeroParents($parentid, $data2parse, $parent_type) {//{{{
        global $sql_tbl, $config, $ckedit_added_entities;

        x_session_register('ckedit_added_entities');

        if (
            $config['HTML_Editor']['editor'] != 'ckeditor'
            || empty($ckedit_added_entities)
        ) {
            return false;
        }

        $type = XC_Editor::UPLOADED_IMAGE_TYPE;

        $data2parse = print_r($data2parse, true);

        if (strpos($data2parse, '/images/' . $type . '/') !== false) {
            $value = $key = $all_matches = null;
            preg_match_all("%(/images/$type/[^'\"]+)['\"]%", $data2parse, $all_matches);

            if (!empty($all_matches[1])) {
                $parent_condition = is_string($parent_type)
                    ? "LIKE '$parent_type%'"
                    : "IN ('" . implode("','", $parent_type) . "')";
                array_walk($all_matches[1], function (&$value, $key) {
                   $value = '.' . addslashes(urldecode(rtrim($value, '\\')));
                });
                db_query("UPDATE $sql_tbl[images_CKEDIT] SET id='$parentid' WHERE parent_type $parent_condition AND id=0 AND image_path IN ('" . implode("','", $all_matches[1]) . "') AND date>=" . (XC_TIME - 2 * SECONDS_PER_HOUR));
            }
        }
        $ckedit_added_entities = false;
    }//}}}

} // xc_EditorEntity
