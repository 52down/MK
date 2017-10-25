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
 * Classes
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ildar Amankulov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    b9a961c6317b90d622f25632988d6315367d1ddf, v3 (xcart_4_7_8), 2017-05-31 18:46:50, classes.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */
namespace XC\FacebookEcommerce\Backend;

abstract class Defs { // {{{
    const
        SESSION_CURRENCY_PARAM = 'fe_currency',
        SESSION_LANGUAGE_PARAM = 'fe_language',
        SESSION_AGE_GROUP_PARAM = 'fe_age_group',
        SESSION_FEED_ID_PARAM = 'fe_feed_id',


        //used before
        CONTROLLER_SETTINGS = 'Settings',


        YES = 'Y',
        NO = 'N',
        CLASS_PREFIX = 'Controller',



        CONFIG_VAR_AWS_ID = 'access_key_id',
        CONFIG_VAR_AWS_SECRET = 'secret_access_key',
        CONFIG_VAR_MERCHANT_ID = 'merchant_id',

        CONFIG_VAR_ENCODING = 'encoding',

        CONFIG_VAR_CURRENCY = 'currency',
        CONFIG_VAR_CONVERSION_RATE = 'conversion_rate',

        CONFIG_VAR_APP_NAME = 'application_name',
        CONFIG_VAR_APP_VERSION = 'application_version',

        FEED_PROCESSING_STEP = 'facebook_ecomm_processing_step',
        FEED_PROCESSING_FEED = 'facebook_ecomm_processing_feed',

        FEED_PROCESSING_STEP_PREPARE_XML = 'Prepare XML',
        FEED_PROCESSING_STEP_SUBMIT_XML = 'Submit XML',

        FEED_PRODUCT_TYPE = 'facebook_ecomm_product_type',
        FEED_PATH_DELIMITER = '/',

        SESSION_VAR_PRODUCT     = XC\FacebookEcommerce\Feeds\Feed::FEED_TYPE_PRODUCT,
        SESSION_VAR_INVENTORY   = XC\FacebookEcommerce\Feeds\Feed::FEED_TYPE_INVENTORY,
        SESSION_VAR_PRICING     = XC\FacebookEcommerce\Feeds\Feed::FEED_TYPE_PRICING,
        SESSION_VAR_IMAGE       = XC\FacebookEcommerce\Feeds\Feed::FEED_TYPE_IMAGE,
        SESSION_VAR_RELATIONSHIP    = XC\FacebookEcommerce\Feeds\Feed::FEED_TYPE_RELATIONSHIP,

        SESSION_VAR_FULL = 'differential',


        DISPLAY_TYPE_SELF = 'self',
        DISPLAY_TYPE_CUST = 'custom_template',

        PRODUCT_SECTION = 'feeds_details', // value used in templates as plain text

        RESULTS_FILE_SUFFIX = '.result',

        FEED_RESULT_ERROR_CODE = 1,
        FEED_RESULT_WARNING_CODE = 2,

        CONTROLLER = 'controller',

        CONTROLLER_GET_MARKETPLACES = 'GetMarketplaces',
        CONTROLLER_FEEDS_CHECK = 'FeedsCheck',
        CONTROLLER_FEEDS_PROGRESS = 'FeedsProgress',
        CONTROLLER_FEEDS_RESULTS = 'FeedsResults';
} // }}}


class FeedsFe extends \XC\Module\Backend\RequestProcessor {

    protected $displayTemplate = 'modules/Facebook_Ecommerce/feeds.tpl';
    protected $sessionVars = array(Defs::SESSION_CURRENCY_PARAM, Defs::SESSION_LANGUAGE_PARAM, Defs::SESSION_AGE_GROUP_PARAM);
    protected $smartyVars = array();
    protected $globalVars = array(Defs::SESSION_FEED_ID_PARAM, 'mode');

    protected function navigation($items_count) { // {{{
        global $page, $total_items, $objects_per_page, $first_page;

        $total_items = $items_count;

        if ($total_items > 0) {
            global $xcart_dir;
            include $xcart_dir . '/include/navigation.php';
        }

        return array(
            'first_page' => !empty($first_page) ? $first_page : 0,
            'objects_per_page' => !empty($objects_per_page) ? $objects_per_page : 0
        );
    } // }}}

    protected function display() { // {{{
        global $smarty, $sql_tbl, $active_modules, $current_location, $config;

        $current_currency = empty($config['facebook_ecomm_currency']) ? 'USD' : $config['facebook_ecomm_currency'];
        if (!empty($active_modules['XMultiCurrency'])) {
            $availCurrencies =  func_mc_get_currencies();
            foreach ($availCurrencies as $p_key => $_p_value) {
                if ($_p_value['code'] == $current_currency) {
                    $availCurrencies[$p_key]['selected'] = 'Y';
                }
            }
            $smarty->assign('availCurrencies', $availCurrencies);
        } else {
            $smarty->assign('availCurrencies', func_query("SELECT code, CONCAT(name, ' (', code, ')') AS name, (IF(code='$current_currency','Y','N')) AS selected FROM $sql_tbl[currencies]", 'code', false, true));
        }

        $total_items = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[facebook_ecomm_feed_files]");

        if ($total_items > 0) {

            // Get navigation data array
            $navigation = $this->navigation($total_items);

            // Get export items list
            $feeds_list = func_query("SELECT * FROM $sql_tbl[facebook_ecomm_feed_files] ORDER BY $sql_tbl[facebook_ecomm_feed_files].update_date DESC" . ($navigation['objects_per_page'] > 0 ? " LIMIT $navigation[first_page], $navigation[objects_per_page]" : ''));

            // Pre-process Display values
            foreach ($feeds_list as $idx => $item) {
                $feeds_list[$idx]['url'] = $current_location . '/facebook_ecomm_get_file_feed.php?key=' . $item['hash_key'];
                $feeds_list[$idx]['in_data'] = implode('/', array($item['currency_code'], $item['language_code'], $item['age_group'], $item['rows_count']));
            }

            $smarty->assign('feeds_list', $feeds_list);

            $smarty->assign('navigation_script', $this->getNavigationScript());
            $smarty->assign('first_item',        $navigation['first_page'] + 1);
            $smarty->assign('last_item',         min($navigation['first_page'] + $navigation['objects_per_page'], $total_items));
        }

        parent::display();
    } // }}}

    protected function process() { // {{{
        global $top_message, $sql_tbl, $config;

        $count_items = ExporterFe::getCountMarkedProducts();

        if ($count_items > 0) {
            if (isset($this->fe_feed_id) && $this->fe_feed_id > 0 && isset($this->mode) && $this->mode == 'refresh') {
                // get export param from Db
                $this->fe_feed_id = intval($this->fe_feed_id);
                $res = func_query_first("SELECT * FROM $sql_tbl[facebook_ecomm_feed_files] WHERE id=" . $this->fe_feed_id);
                $feeds_params = array();
                $feeds_params[Defs::SESSION_LANGUAGE_PARAM] = $res['language_code'];
                $feeds_params[Defs::SESSION_CURRENCY_PARAM] = $res['currency_code'];
                $feeds_params[Defs::SESSION_AGE_GROUP_PARAM] = $res['age_group'];
                $feeds_params[Defs::SESSION_FEED_ID_PARAM] = $this->fe_feed_id;

                foreach ($feeds_params as $varName=>$value) {
                    static::setSessionVar($varName, $value, 'FeedsSubmitFe');
                }
            } else {
                foreach ($this->sessionVars as $varName) {
                    static::setSessionVar($varName, $this->{$varName}, 'FeedsSubmitFe');
                }
            }

            func_header_location("configuration.php?option=Facebook_Ecommerce&controller_g=FeedsSubmitFe");
        }


        $top_message['type'] = 'E';
        $force_get_sql_labels = $config['General']['use_cached_lng_vars'] != 'Y';
        $top_message['content'] = func_get_langvar_by_name('err_facebook_ecomm_no_catalog', null, false, $force_get_sql_labels);

        func_header_location("configuration.php?option=Facebook_Ecommerce&controller_g=FeedsFe");
    } // }}}

    protected function getModuleName() { // {{{
        return 'Facebook_Ecommerce';
    } //}}}

    protected function getConfig() { // {{{
        return ConfigFe::getInstance();
    } //}}}
}//COntrollerFeedsFe}}}


class FeedsSubmitFe extends \XC\Module\Backend\RequestProcessor {

    protected $sessionVars = array(Defs::SESSION_CURRENCY_PARAM, Defs::SESSION_LANGUAGE_PARAM, Defs::SESSION_AGE_GROUP_PARAM, Defs::SESSION_FEED_ID_PARAM);

    protected $smartyVars = array('controller_name');

    protected $controller_name = 'FeedsSubmit';

    protected function display() { // {{{
        global $top_message;
        x_session_register('top_message', array());

        // copy session vars to assoc array
        $_export_params = array_intersect_key(get_object_vars($this), array_flip($this->sessionVars));
        $_export_params = array_filter($_export_params);
        if (empty($_export_params)) {
            func_header_location("configuration.php?option=Facebook_Ecommerce&controller_g=FeedsFe");
        }

        $processor = new ExporterFe();
        $_export_params['module_name'] = $this->getModuleName();

        // do not delete the existent filename in the EXporterFe on second step
        static::setSessionVar(Defs::SESSION_FEED_ID_PARAM, 0, 'FeedsSubmitFe');

        $finish_result = $processor->exportFe($_export_params);

        if ($finish_result === ExporterFe::IN_PROGRESS) {
            func_header_location("configuration.php?option=Facebook_Ecommerce&controller_g=FeedsSubmitFe");
        } else {
            if ($finish_result === ExporterFe::FINISHED) {
                $top_message['content'] = func_get_langvar_by_name('lbl_export_success');
            } else {
                $top_message['content'] = $finish_result;
                $top_message['type'] = 'E';
            }

            $this->unregisterSelfSessionVars();
            func_header_location("configuration.php?option=Facebook_Ecommerce&controller_g=FeedsFe");
        }
    } // }}}

    protected function getModuleName() { // {{{
        return 'Facebook_Ecommerce';
    } //}}}

    protected function process() {}
}

abstract class ExportImportProcessorFe {

    const IMPORT_DIR_NAME = 'import';

    protected $_config, $_workingDir, $_workingFiles, $_currentFeed;#nolint

    protected abstract function defineDir();

    public function __construct() { // {{{
        set_time_limit(86400);

        func_set_memory_limit('96M');

        $this->_config = ConfigFe::getInstance()->getConfigAsObject();

        $this->defineDir();
    } // }}}

    public function getConfig() { // {{{
        return $this->_config;
    } // }}}

    public function getWorkingDir() { // {{{
        return $this->_workingDir;
    } // }}}

    /**
     * Delete all files in working dir
     */
    public function deleteAllFiles() { // {{{
        func_rm_dir($this->_workingDir, true);
    } // }}}

    /**
     * Check working dir
     */
    protected function checkDir() { // {{{
        global $top_message, $export_dir;

        $export_dir = $this->_workingDir;

        // Create directory if it does not exist
        if (!is_dir($export_dir)) {
            func_mkdir($export_dir);
        }

        // Check if it is writable
        x_load('export');
        if (!func_export_dir_is_writable()) {//global $export_dir is needed

            x_session_register('top_message');

            $top_message['content'] = func_get_langvar_by_name('err_facebook_ecomm_dir_permission_denied',  array('path' => $export_dir));
            $top_message['type'] = 'E';

            return false;
        }

        return true;
    } // }}}
}


class ExporterFe extends ExportImportProcessorFe {
    const
        PRODUCTS_PER_RAW = 100,
        IN_PROGRESS = 'IN_PROGRESS',
        FINISHED = 'FINISHED';

    protected $sess_filename, $init_sess_total;//session variables

    public static function getCountMarkedProducts() {//{{{
        global $sql_tbl;
        return func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[facebook_ecomm_marked_products]");
    }//}}}

    public function exportFe($in_export_params) { // {{{
        global $XCARTSESSID, $sql_tbl, $config;

        if (
            !empty($in_export_params[Defs::SESSION_FEED_ID_PARAM])
            && ($_filename = func_query_first_cell("SELECT filename FROM $sql_tbl[facebook_ecomm_feed_files] WHERE id=" . $in_export_params[Defs::SESSION_FEED_ID_PARAM]))
        ) {
            $this->deleteFeed($in_export_params[Defs::SESSION_FEED_ID_PARAM], 'delete_only_file');// update mode ON DUPLICATE KEY will work
        } else {
            $_filename = '';
        }
        $this->initExportVariables($_filename);

        $left_total_count = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[facebook_ecomm_pending_export] WHERE sessid='$XCARTSESSID'");
        if (empty($left_total_count)) {
            $this->removeSessionPendingData();
            return static::FINISHED;
        }

        $force_get_sql_labels = $config['General']['use_cached_lng_vars'] != 'Y';
        $start_text = func_get_langvar_by_name('lbl_exporting_data_pass_', array('pass' => (100-round($left_total_count / $this->init_sess_total, 2) * 100) . '%'), false, $force_get_sql_labels);

        $in_export_params['weight_unit'] = $this->_config->facebook_ecomm_weight_unit;
        $_export_params = $in_export_params;
        foreach($_export_params as $k=>$v) {
            $new_key = str_replace('fe_', '', $k);
            unset($_export_params[$k]);
            $_export_params[$new_key] = $v;
        }
        $fileExporter = new \XC\csvFileExporter($this->sess_filename, $start_text, $_export_params);

        $ids2export = func_query_column("SELECT productid" . $this->getCondPackedIds(static::PRODUCTS_PER_RAW));
        $res = $fileExporter->saveProducts(array('ids' => $ids2export));

        switch ($res['code']) {
            case \XC\csvFileExporter::FILE_OPEN_ERROR :
                $this->removeSessionPendingData();
                return func_get_langvar_by_name('msg_adm_incorrect_store_n_files_perms', array('path' => $this->getWorkingDir()));

            case \XC\csvFileExporter::EMPTY_PRODUCTS :
                db_query("DELETE" . $this->getCondPackedIds(static::PRODUCTS_PER_RAW));
                return static::IN_PROGRESS;
            break;
        }

        $this->changeFileStatistic($res['real_exported_count_ids'], $in_export_params, $res['is_first_step']);

        if (count($ids2export) >= $left_total_count) {
            $this->removeSessionPendingData();
            return static::FINISHED;
        } else {
            db_query("DELETE" . $this->getCondPackedIds(static::PRODUCTS_PER_RAW));
            return static::IN_PROGRESS;
        }

    } // }}}

    public function deleteFeed($id, $mode = 'delete_all') {//{{{
        global $sql_tbl;

        $filename = func_query_first_cell("SELECT filename FROM $sql_tbl[facebook_ecomm_feed_files] WHERE id = '$id'");
        if (empty($filename)) {
            return false;
        }
        @unlink($this->getWorkingDir() . XC_DS . $filename);
        if ($mode == 'delete_all') {
            db_query("DELETE FROM $sql_tbl[facebook_ecomm_feed_files] WHERE id='$id'");
        }

    }//}}}

    protected function initExportVariables($filename) { // {{{
        global $sessionStateExporterFe, $XCARTSESSID, $sql_tbl;

        x_session_register('sessionStateExporterFe', array());

         if (empty($sessionStateExporterFe)) {
             // First step
            $this->markProductsPending();
            $sessionStateExporterFe['init_sess_total'] = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[facebook_ecomm_pending_export] WHERE sessid='$XCARTSESSID'");
            $filename = $filename ?: $this->generateFilename();
            $sessionStateExporterFe['sess_filename'] = $this->getWorkingDir() . XC_DS . $filename;
        }

        foreach ($sessionStateExporterFe as $varName=>$value) {
            $this->{$varName} = $value;
        }

    }//}}}

    protected function markProductsPending() {//{{{
        global $sql_tbl, $active_modules, $XCARTSESSID;

        !mt_rand(0, 50) && db_query("DELETE FROM $sql_tbl[facebook_ecomm_pending_export] WHERE sessid NOT IN (SELECT sessid FROM $sql_tbl[sessions_data])");

        db_query("REPLACE INTO $sql_tbl[facebook_ecomm_pending_export]"
                . " (SELECT  p.productid AS productid,'$XCARTSESSID' AS sessid FROM $sql_tbl[facebook_ecomm_marked_products] AS p) "
        );

    }//}}}

    protected function defineDir() { // {{{
        global $var_dirs;

        x_load('backoffice');
        $this->_workingDir = func_get_files_location() . '/' . 'facebook_feeds';//cron has write perms to 'files/' dir according to XCart_Fs_permissions_map

        if (!$this->checkDir()) {
            Logger::debug_log(func_get_langvar_by_name('msg_adm_incorrect_store_perms', array('path' => $this->_workingDir)));
            return false;
        }
    } // }}}

    protected function getCondPackedIds($limit) {//{{{
        global $XCARTSESSID, $sql_tbl;

        return " FROM $sql_tbl[facebook_ecomm_pending_export] WHERE sessid='$XCARTSESSID' ORDER BY productid LIMIT $limit";
    }//}}}

    protected function generateFilename() {//{{{
        global $login;
        return 'feed_' . XC_TIME  . "_" . md5($login) . ".csv.php";
    }//}}}

    protected function changeFileStatistic($rows_count, $params, $in_is_first_step) {//{{{
        global $sql_tbl;

        $filename = basename($this->sess_filename);
        $rows_count = intval($rows_count);
        if (!empty($in_is_first_step)) {
            $language_code = addslashes(empty($params[Defs::SESSION_LANGUAGE_PARAM]) ? 'en' : $params[Defs::SESSION_LANGUAGE_PARAM]);
            $currency_code = addslashes(empty($params[Defs::SESSION_CURRENCY_PARAM]) ? 'USD' : $params[Defs::SESSION_CURRENCY_PARAM]);
            $age_group = addslashes(empty($params[Defs::SESSION_AGE_GROUP_PARAM]) ? 'adult' : $params[Defs::SESSION_AGE_GROUP_PARAM]);

            $hash_key = addslashes(func_get_secure_random_key(50, 'user_password'));
            $path = addslashes($this->getWorkingDir() . \XC_DS);
            db_query("INSERT INTO $sql_tbl[facebook_ecomm_feed_files] (filename,path,hash_key,update_date,language_code,currency_code,age_group,rows_count) VALUES ('$filename','$path','$hash_key','" . XC_TIME . "','$language_code','$currency_code','$age_group','$rows_count') ON DUPLICATE KEY UPDATE currency_code='$currency_code',language_code='$language_code',age_group='$age_group',update_date='" . XC_TIME . "',rows_count='$rows_count'");
            db_query("REPLACE INTO $sql_tbl[config] SET name='facebook_ecomm_currency', value='$currency_code', category='', type='text', variants='', validation='',defvalue='$currency_code'");
        } else {
            db_query("UPDATE $sql_tbl[facebook_ecomm_feed_files] SET update_date='" . XC_TIME . "',rows_count=rows_count+" . $rows_count . " WHERE filename='$filename'");
        }

    }//}}}

    protected function removeSessionPendingData() {//{{{
        global $sessionStateExporterFe, $XCARTSESSID, $sql_tbl;
        x_session_unregister('sessionStateExporterFe');
        db_query("DELETE FROM $sql_tbl[facebook_ecomm_pending_export] WHERE sessid='$XCARTSESSID'");
    }//}}}
}//EXporterFe


class ConfigFe extends \XC_Singleton {
    private $_params = array();
    private $_typeExportClasses = array();
    private $_typeImportClasses = array();

    public static function getInstance() { // {{{
        // Call parent getter
        return parent::getClassInstance(__CLASS__);
    } // }}}

    public function getHash() { // {{{
        return md5(serialize($this->getConfigAsArray()));
    } // }}}

    public function getConfigAsArray() { // {{{
        return $this->_params;
    } // }}}

    public function getConfigAsObject() { // {{{
        static $configObject = null;

        if (is_null($configObject)) {
            $configObject = new \stdClass();

            foreach ($this->_params as $key => $value) {
                $configObject->$key = $value;
            }
        }

        return $configObject;
    } // }}}

    public function getTypeExportClasses() { // {{{
        return $this->_typeExportClasses;
    } // }}}

    public function getTypeImportClasses() { // {{{
        return $this->_typeImportClasses;
    } // }}}

    protected function __construct() { // {{{

        // Call parent constructor
        parent::__construct();

        // Globals
        global $config, $sql_tbl;

        // Get module config params
        if (!empty($config['Facebook_Ecommerce'])) {
            foreach ($config['Facebook_Ecommerce'] as $p_key => $_p_value) {
                $this->_params[$p_key] = $_p_value;
            }
        }

    } // }}}
}//COnfigFe


class Logger {
    public static function debug_log($message) { // {{{
        if (
            (defined('XC_FACEBOOK_ECOMMERCE_DEBUG') || defined('DEVELOPMENT_MODE'))
            && !empty($message)
        ) {
            if ($message instanceof \Exception) {
                $message = <<<MSG
        Caught Exception: {$message->getMessage()}
        Response Status Code: {$message->getCode()}
MSG;
            }

            x_log_add('facebook_ecomm', $message);
        }
    } // }}}
}
