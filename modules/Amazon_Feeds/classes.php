<?php
/* vim: set ts=4 sw=4 sts=4 et: */
/* * ***************************************************************************\
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
  \**************************************************************************** */

/**
 * Classes
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Michael Bugrov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    9a4057f3128631bbb70470d97d21ad1121dc9968, v9 (xcart_4_7_8), 2017-04-26 13:06:47, classes.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

abstract class XCAmazonFeedsDefs { // {{{

    // <editor-fold desc="CONSTANTS" defaultstate="collapsed">
    const
        YES = 'Y',
        NO = 'N',

        CONFIG_VAR_AWS_ID = 'access_key_id',
        CONFIG_VAR_AWS_SECRET = 'secret_access_key',
        CONFIG_VAR_MERCHANT_ID = 'merchant_id',
        CONFIG_VAR_MARKETPLACE_ID = 'marketplace_id',

        CONFIG_VAR_MARKETPLACE_CODE = 'marketplace_code',
        CONFIG_VAR_ENCODING = 'encoding',

        CONFIG_VAR_CURRENCY = 'currency',
        CONFIG_VAR_CONVERSION_RATE = 'conversion_rate',

        CONFIG_VAR_APP_NAME = 'application_name',
        CONFIG_VAR_APP_VERSION = 'application_version',

        FEED_PROCESSING_STEP = 'afds_processing_step',
        FEED_PROCESSING_FEED = 'afds_processing_feed',

        FEED_PROCESSING_STEP_PREPARE_XML = 'Prepare XML',
        FEED_PROCESSING_STEP_SUBMIT_XML = 'Submit XML',

        FEED_PRODUCT_TYPE = 'amazon_feeds_product_type',
        FEED_PATH_DELIMITER = '/',

        SEARCH_FORM_EMPTY_CAT_VALUE = -1,

        SESSION_VAR_PRODUCT     = XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_PRODUCT,
        SESSION_VAR_INVENTORY   = XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_INVENTORY,
        SESSION_VAR_PRICING     = XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_PRICING,
        SESSION_VAR_IMAGE       = XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_IMAGE,
        SESSION_VAR_RELATIONSHIP    = XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_RELATIONSHIP,

        SESSION_VAR_FULL = 'differential',

        CLASS_PREFIX = 'XCAmazonFeedsController',

        DISPLAY_TYPE_SELF = 'self',
        DISPLAY_TYPE_CUST = 'custom_template',

        PRODUCT_SECTION = 'feeds_details', // value used in templates as plain text

        RESULTS_FILE_SUFFIX = '.result',

        FEED_RESULT_ERROR_CODE = 1,
        FEED_RESULT_WARNING_CODE = 2,

        CONTROLLER = 'controller',
        CONTROLLER_NAME = 'controller_name',

        CONTROLLER_SETTINGS = 'Settings',
        CONTROLLER_GET_MARKETPLACES = 'GetMarketplaces',
        CONTROLLER_FEEDS = 'Feeds',
        CONTROLLER_FEEDS_SUBMIT = 'FeedsSubmit',
        CONTROLLER_FEEDS_CHECK = 'FeedsCheck',
        CONTROLLER_FEEDS_PROGRESS = 'FeedsProgress',
        CONTROLLER_FEEDS_RESULTS = 'FeedsResults';
    // </editor-fold>

} // }}}

abstract class XCAmazonFeedsAdminRequestProcessor { // {{{

    protected $displayTemplate = '';
    protected $displayType = XCAmazonFeedsDefs::DISPLAY_TYPE_CUST;

    protected $sessionVars = array();
    protected $globalVars = array();
    protected $smartyVars = array();

    protected $requiredConfigVars = array();

    public static function processRequest()
    { // {{{
        global $smarty, $REQUEST_METHOD, ${XCAmazonFeedsDefs::CONTROLLER};

        $controllerClass = XCAmazonFeedsDefs::CLASS_PREFIX . XCStringUtils::convertToCamelCase(${XCAmazonFeedsDefs::CONTROLLER});

        if (class_exists($controllerClass)) {

            $controllerInstance = new $controllerClass();

            $controllerInstance->registerGlobalVars();
            $controllerInstance->registerSessionVars();

            $smarty->assign(XCAmazonFeedsDefs::CONTROLLER, ${XCAmazonFeedsDefs::CONTROLLER});

            switch ($REQUEST_METHOD) {
                case 'GET':
                    $controllerInstance->display(func_get_args());
                    break;
                case 'POST':
                    if (($opt_code = $controllerInstance->isConfigured()) !== true) {
                        // not all required options were configured
                        global $top_message;
                        x_session_register('top_message');

                        $top_message['content']
                            = func_get_langvar_by_name (
                                'msg_err_amazon_feeds_not_configured',
                                array(
                                    'oname' => func_get_langvar_by_name('opt_afds_' . $opt_code),
                                    'ocode' => $opt_code
                                )
                            );
                        $top_message['type'] = 'E';

                    } else {
                        // process request
                        $controllerInstance->process(func_get_args());
                    }
                    // redirect to controller page in case of post request
                    func_header_location($controllerInstance->getNavigationScript());
                    break;
            }
        }

    } // }}}

    public static function registerSessionVar($varName, $className = null)
    { // {{{
        if (is_null($className)) {
            $className = get_called_class();
        }

        $classVarName = $className . "_$varName";
        global ${$classVarName};
        x_session_register($classVarName);

        return $classVarName;
    } // }}}

    public static function setSessionVar($varName, $varValue, $className = null)
    { // {{{
        $classVarName = static::registerSessionVar($varName, $className);
        global ${$classVarName};
        ${$classVarName} = $varValue;
    } // }}}

    public static function getSessionVar($varName, $className = null)
    { // {{{
        $classVarName = static::registerSessionVar($varName, $className);
        global ${$classVarName};
        return ${$classVarName};
    } // }}}

    protected function getControllerName()
    { // {{{
        return str_replace(XCAmazonFeedsDefs::CLASS_PREFIX, '', get_class($this));
    } // }}}

    protected function getDisplayControllerName()
    { // {{{
        return $this->getControllerName();
    } // }}}

    protected function getNavigationScript()
    { // {{{
        $option = AMAZON_FEEDS;
        $controller = $this->getDisplayControllerName();

        return "configuration.php?option=$option&controller=$controller";
    } // }}}

    protected function registerGlobalVars()
    { // {{{
        if (!empty($this->globalVars)) {
            foreach ($this->globalVars as $varName) {
                global ${$varName};
                $this->$varName = ${$varName};
            }
        }
    } // }}}

    protected function registerSessionVars()
    { // {{{
        if (!empty($this->sessionVars)) {
            foreach ($this->sessionVars as $varName) {
                $classVarName = static::registerSessionVar($varName, get_class($this));

                global ${$varName}, ${$classVarName};

                if (isset(${$varName})) {
                    ${$classVarName} = ${$varName};
                }

                $this->$varName = ${$classVarName};
            }
        }
    } // }}}

    protected function registerSmartyVars()
    { // {{{
        global $smarty;

        if (!empty($this->smartyVars)) {
            foreach ($this->smartyVars as $varName) {
                if (property_exists($this, $varName)) {
                    $smarty->assign($varName, $this->$varName);
                }
            }
        }
    } // }}}

    /**
     * Check if controller is configured
     *
     * @return mixed true on success and option code on fail
     */
    protected function isConfigured()
    { // {{{
        $result = true;

        $config = \XCAmazonFeedsConfig::getInstance()->getConfigAsObject();

        foreach ($this->requiredConfigVars as $varname) {
            if (
                !property_exists($config, $varname)
                || empty($config->$varname)
            ) {
                $result = $varname;
            }
        }

        return $result;
    } // }}}

    protected function display()
    { // {{{
        global $smarty;

        $this->registerSmartyVars();

        $smarty->assign('navigation_script', $this->getNavigationScript());

        if ($this->displayType === XCAmazonFeedsDefs::DISPLAY_TYPE_SELF) {

            func_display($this->displayTemplate, $smarty);

            exit();
        }
        else {
            $smarty->assign('custom_admin_module_config_tpl_file', $this->displayTemplate);
        }
    } // }}}

    abstract protected function process();

} // }}}

class XCAmazonFeedsControllerGetMarketplaces extends XCAmazonFeedsAdminRequestProcessor { // {{{

    protected $requiredConfigVars = array(
        XCAmazonFeedsDefs::CONFIG_VAR_AWS_ID,
        XCAmazonFeedsDefs::CONFIG_VAR_AWS_SECRET,
        XCAmazonFeedsDefs::CONFIG_VAR_MERCHANT_ID
    );

    protected function process()
    {
        global $sql_tbl, $top_message;

        $option = AMAZON_FEEDS;

        $result = XCAmazonFeedsSellerAPI::getInstance()->listMarketplaceParticipations();

        if (!$result) {

            $top_message = array (
                'type' => 'E',
                'content' => func_get_langvar_by_name('err_amazon_feeds_no_result_api', false, false, true)
            );

            func_header_location("configuration.php?option=$option");
        }

        try {
            $marketplaces = $result->getListMarketplaceParticipationsResult()->getListMarketplaces()->getMarketplace();

            $variants = ":lbl_amazon_feeds_select_market\n";

            $vars = array();
            foreach ($marketplaces as $marketplace) {
                $variant_name = func_get_langvar_by_name(addslashes('country_' . strtoupper($marketplace->getDefaultCountryCode())), NULL, false, true) . ' (' . ($marketplace->getMarketplaceId()) . ' ' . ($marketplace->getName()) . ")";
                $variant_name = str_replace('(Great Britain)', '', $variant_name);
                $variant_key = $marketplace->getMarketplaceId();
                $vars[$variant_name . $variant_key] = $variant_key . ':' . $variant_name;
            }
            ksort($vars);
            $variants .= implode("\n", $vars);

            db_query("UPDATE $sql_tbl[config] SET variants = '$variants' WHERE name = 'afds_" . XCAmazonFeedsDefs::CONFIG_VAR_MARKETPLACE_ID . "'");

        } catch (Exception $ex) {

            db_query("UPDATE $sql_tbl[config] SET variants = ':lbl_amazon_feeds_no_marketplace' WHERE name = 'afds_" . XCAmazonFeedsDefs::CONFIG_VAR_MARKETPLACE_ID . "'");

            func_amazon_feeds_debug_log($ex->getMessage());

            $top_message = array (
                'type' => 'E',
                'content' => func_get_langvar_by_name('err_amazon_feeds_no_result_api', false, false, true)
            );

            func_header_location("configuration.php?option=$option");
        }

        $top_message = array (
            'type' => 'I',
            'content' => func_get_langvar_by_name('txt_amazon_feeds_operation_success', false, false, true)
        );

        func_header_location("configuration.php?option=$option");
    }

} // }}}

class XCAmazonFeedsControllerFeeds extends XCAmazonFeedsAdminRequestProcessor { // {{{

    protected $displayTemplate = 'modules/Amazon_Feeds/feeds.tpl';

    protected $requiredConfigVars = array(
        XCAmazonFeedsDefs::CONFIG_VAR_AWS_ID,
        XCAmazonFeedsDefs::CONFIG_VAR_AWS_SECRET,
        XCAmazonFeedsDefs::CONFIG_VAR_MERCHANT_ID,
        XCAmazonFeedsDefs::CONFIG_VAR_MARKETPLACE_ID,
    );

    protected $sessionVars = array(
        XCAmazonFeedsDefs::SESSION_VAR_PRODUCT,
        XCAmazonFeedsDefs::SESSION_VAR_INVENTORY,
        XCAmazonFeedsDefs::SESSION_VAR_PRICING,
        XCAmazonFeedsDefs::SESSION_VAR_IMAGE,
        XCAmazonFeedsDefs::SESSION_VAR_RELATIONSHIP,
        XCAmazonFeedsDefs::SESSION_VAR_FULL,
    );

    protected $smartyVars = array(
        XCAmazonFeedsDefs::SESSION_VAR_PRODUCT,
        XCAmazonFeedsDefs::SESSION_VAR_INVENTORY,
        XCAmazonFeedsDefs::SESSION_VAR_PRICING,
        XCAmazonFeedsDefs::SESSION_VAR_IMAGE,
        XCAmazonFeedsDefs::SESSION_VAR_RELATIONSHIP,
        XCAmazonFeedsDefs::SESSION_VAR_FULL,
    );

    protected function navigation($items_count)
    { // {{{
        global $page, $total_items, $objects_per_page, $first_page; // Navigation globals

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

    protected function display()
    { // {{{
        global $smarty, $sql_tbl, $active_modules;

        $feed_types = array(
            XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_PRODUCT    => 'lbl_amazon_feeds_product_feed',
            XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_INVENTORY  => 'lbl_amazon_feeds_inventory_feed',
            XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_PRICING    => 'lbl_amazon_feeds_pricing_feed',
            XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_IMAGE      => 'lbl_amazon_feeds_image_feed'
        );

        if ($active_modules['Product_Options'] || $active_modules ['Upselling_Products']) {
            $feed_types[XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_RELATIONSHIP] = 'lbl_amazon_feeds_relationship_feed';
        }

        $smarty->assign('feed_types', $feed_types);

        $total_items = func_query_first_cell ("SELECT COUNT(*) FROM $sql_tbl[amazon_feeds]");

        if ($total_items > 0) { // {{{

            // Get navigation data array
            $navigation = $this->navigation($total_items);

            // Get export items list
            $feeds_list = func_query("SELECT * FROM $sql_tbl[amazon_feeds] ORDER BY $sql_tbl[amazon_feeds].submit_date" . ($navigation['objects_per_page'] > 0 ? " LIMIT $navigation[first_page], $navigation[objects_per_page]" : ''));

            // Pre-process display values
            foreach ($feeds_list as $idx => $item) {
                // type
                $feedType = func_amazon_feeds_get_type_from_filename($item['filename']);
                $feeds_list[$idx]['type'] = ucfirst($feedType) ?: func_get_langvar_by_name('lbl_unknown');
                // status
                $status_code = func_get_langvar_by_name('lbl_unknown');
                $status_descr = func_get_langvar_by_name('lbl_unknown');

                switch ($feeds_list[$idx]['status']) {
                    case XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_STATUS_AWAITING_ASYNCHRONOUS_REPLY:
                        $status_code = func_get_langvar_by_name('lbl_amazon_feeds_status_awaiting_reply');
                        $status_descr = func_get_langvar_by_name('txt_amazon_feeds_status_awaiting_reply');
                        break;
                    case XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_STATUS_CANCELLED:
                        $status_code = func_get_langvar_by_name('lbl_amazon_feeds_status_cancelled');
                        $status_descr = func_get_langvar_by_name('txt_amazon_feeds_status_cancelled');
                        break;
                    case XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_STATUS_DONE:
                        $status_code = func_get_langvar_by_name('lbl_amazon_feeds_status_done');
                        $status_descr = func_get_langvar_by_name('txt_amazon_feeds_status_done');
                        break;
                    case XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_STATUS_IN_PROGRESS:
                        $status_code = func_get_langvar_by_name('lbl_amazon_feeds_status_in_progress');
                        $status_descr = func_get_langvar_by_name('txt_amazon_feeds_status_in_progress');
                        break;
                    case XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_STATUS_IN_SAFETY_NET:
                        $status_code = func_get_langvar_by_name('lbl_amazon_feeds_status_in_safety_net');
                        $status_descr = func_get_langvar_by_name('txt_amazon_feeds_status_in_safety_net');
                        break;
                    case XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_STATUS_SUBMITTED:
                        $status_code = func_get_langvar_by_name('lbl_amazon_feeds_status_submitted');
                        $status_descr = func_get_langvar_by_name('txt_amazon_feeds_status_submitted');
                        break;
                    case XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_STATUS_UNCONFIRMED:
                        $status_code = func_get_langvar_by_name('lbl_amazon_feeds_status_unconfirmed');
                        $status_descr = func_get_langvar_by_name('txt_amazon_feeds_status_unconfirmed');
                        break;
                }

                $feeds_list[$idx]['status'] = array (
                    'code' => $status_code,
                    'descr' => $status_descr
                );

            } // }}}

            $smarty->assign('feeds_list', $feeds_list);

            $smarty->assign('navigation_script', $this->getNavigationScript());
            $smarty->assign('first_item',        $navigation['first_page'] + 1);
            $smarty->assign('last_item',         min($navigation['first_page'] + $navigation['objects_per_page'], $total_items));
        }

        parent::display();
    } // }}}

    protected function process()
    { // {{{
        global $top_message;

        $option = AMAZON_FEEDS;
        $submit_controller = XCAmazonFeedsDefs::CONTROLLER_FEEDS_SUBMIT;
        $feeds_controller = XCAmazonFeedsDefs::CONTROLLER_FEEDS;

        $count = 0;
        $first_run = true;
        foreach ($this->sessionVars as $varName) {
            if ($this->{$varName} && $varName !== XCAmazonFeedsDefs::SESSION_VAR_FULL) {
                $count++;
            }
            if (
                $this->{XCAmazonFeedsDefs::SESSION_VAR_PRODUCT}
                && $this->{XCAmazonFeedsDefs::SESSION_VAR_FULL}
                && $first_run
            ) {
                func_amazon_feeds_mark_all_products_pending();
                $first_run = false;
            }
            self::setSessionVar($varName, $this->{$varName}, 'XCAmazonFeedsControllerFeedsSubmit');
        }

        $count_items = func_amazon_feeds_get_catalog_items();

        if ($count > 0 && $count_items > 0) {
            func_header_location("configuration.php?option=$option&controller=$submit_controller");
        }

        if ($count == 0) {

            $top_message['type'] = 'E';
            $top_message['content'] = func_get_langvar_by_name('txt_amazon_feeds_not_selected');

        } else {

            $top_message['type'] = 'E';
            $top_message['content'] = func_get_langvar_by_name('err_amazon_feeds_no_catalog');
        }

        func_header_location("configuration.php?option=$option&controller=$feeds_controller");
    } // }}}

} // }}}

class XCAmazonFeedsControllerFeedsSubmit extends XCAmazonFeedsAdminRequestProcessor { // {{{

    protected $displayTemplate = 'modules/Amazon_Feeds/progress.tpl';

    protected $sessionVars = array(
        XCAmazonFeedsDefs::SESSION_VAR_PRODUCT,
        XCAmazonFeedsDefs::SESSION_VAR_INVENTORY,
        XCAmazonFeedsDefs::SESSION_VAR_PRICING,
        XCAmazonFeedsDefs::SESSION_VAR_IMAGE,
        XCAmazonFeedsDefs::SESSION_VAR_RELATIONSHIP,
    );

    protected $smartyVars = array(
        XCAmazonFeedsDefs::CONTROLLER_NAME
    );

    protected $controller_name = 'FeedsSubmit';

    protected function process()
    { // {{{
        $feedNames = array();

        foreach ($this->sessionVars as $varName) {

            if ($this->{$varName}) {

                $feedNames[] = $varName;
            }
        }

        $this->export($feedNames);
    } // }}}

    protected function export($feedNames)
    { // {{{
        $processor = new XCAmazonFeedsExporter();
        $processor->export($feedNames);
    } // }}}

} // }}}

class XCAmazonFeedsControllerFeedsCheck extends XCAmazonFeedsAdminRequestProcessor { // {{{

    protected $requiredConfigVars = array(
        XCAmazonFeedsDefs::CONFIG_VAR_AWS_ID,
        XCAmazonFeedsDefs::CONFIG_VAR_AWS_SECRET,
        XCAmazonFeedsDefs::CONFIG_VAR_MERCHANT_ID,
        XCAmazonFeedsDefs::CONFIG_VAR_MARKETPLACE_ID
    );

    protected function getDisplayControllerName()
    { // {{{
        return XCAmazonFeedsDefs::CONTROLLER_FEEDS;
    } // }}}

    protected function process()
    { // {{{
        $processor = new XCAmazonFeedsImporter();

        $xmlExchange = new XCart\Modules\AmazonFeeds\Feeds\XMLExchange\Processor();
        $result = $xmlExchange->checkStatus($processor);

        $option = AMAZON_FEEDS;
        $feedsController = XCAmazonFeedsDefs::CONTROLLER_FEEDS;
        $resultsController = XCAmazonFeedsDefs::CONTROLLER_FEEDS_RESULTS;

        $controller = $result ? $resultsController : $feedsController;

        func_header_location("configuration.php?option=$option&controller=$controller");
    } // }}}

} // }}}

class XCAmazonFeedsControllerFeedsResults extends XCAmazonFeedsAdminRequestProcessor { // {{{

    protected $displayTemplate = 'modules/Amazon_Feeds/progress.tpl';

    protected $smartyVars = array(
        XCAmazonFeedsDefs::CONTROLLER_NAME
    );

    protected $controller_name = 'FeedsResults';

    protected function process()
    { // {{{
        global $sql_tbl;

        $status_done = \XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_STATUS_DONE;
        $results_pending = \XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_RESULTS_PENDING;

        $not_processed_condition
            = "WHERE status = '$status_done'"
                . " AND is_processed = '$results_pending'";

        $results = func_query(
            "SELECT *"
            . " FROM $sql_tbl[amazon_feeds] $not_processed_condition");


        if (!empty($results)) {
            $this->import($results);
        }
    } // }}}

    protected function import($results)
    { // {{{
        $processor = new XCAmazonFeedsImporter();
        $processor->import($results);

    } // }}}

} // }}}

class XCAmazonFeedsControllerFeedsProgress extends XCAmazonFeedsAdminRequestProcessor { // {{{

    protected function display()
    { // {{{
        $typeClasses = XCAmazonFeedsConfig::getInstance()->getTypeExportClasses();

        $stepInfo = func_amazon_feeds_get_processing_step();
        $feedName = func_amazon_feeds_get_processing_feed();

        switch ($feedName) {
            case '::begin':
                echo json_encode(array(
                    'step' => $stepInfo,
                    'feed' => $feedName,
                    'progress' => 0
                ));
                exit;
                break;
            case '::end':
                echo json_encode(array(
                    'step' => $stepInfo,
                    'feed' => $feedName,
                    'progress' => 100
                ));
                exit;
                break;
        }

        switch ($stepInfo['code']) {
            case '::building':
                if (
                    !empty($typeClasses[$feedName])
                    && class_exists($typeClasses[$feedName])
                ) {

                    // Register cache function
                    func_register_cache_function(
                        'getAmazonFeedsFileCacheClassState',
                        array(
                            'class' => $typeClasses[$feedName]
                        )
                    );

                    if (
                        ($cacheData = func_get_cache_func($typeClasses[$feedName], 'getAmazonFeedsFileCacheClassState'))
                        && !empty($cacheData['data']['_step_progress'])
                    ) {

                        echo json_encode(array(
                            'step' => $stepInfo,
                            'feed' => $cacheData['data']['_step_feed'],
                            'progress' => round($cacheData['data']['_step_progress'])
                        ));

                        exit;
                    }

                }
                break;
            case '::submitting':
                echo json_encode(array(
                    'step' => $stepInfo,
                    'feed' => $feedName,
                    'progress' => 50
                ));
                break;
            case '::loading':
                if (
                    !empty($typeClasses[$feedName])
                    && class_exists($typeClasses[$feedName])
                ) {

                    // Register cache function
                    func_register_cache_function(
                        'getAmazonFeedsFileCacheClassState',
                        array(
                            'class' => $typeClasses[$feedName]
                        )
                    );

                    if (
                        ($cacheData = func_get_cache_func($typeClasses[$feedName], 'getAmazonFeedsFileCacheClassState'))
                        && !empty($cacheData['data']['_step_progress'])
                    ) {

                        echo json_encode(array(
                            'step' => $stepInfo,
                            'feed' => $cacheData['data']['_step_feed'],
                            'progress' => round($cacheData['data']['_step_progress'])
                        ));

                        exit;
                    }

                }
                break;
            case '::processing':
                echo json_encode(array(
                    'step' => $stepInfo,
                    'feed' => $feedName,
                    'progress' => 50
                ));
                break;
        }

        exit;
    } // }}}

    protected function process() {}

} // }}}

class XCAmazonFeedsConfig extends XC_Singleton { // {{{

    private $_params = array();

    // <editor-fold desc="Type-Export-Classe" defaultstate="collapsed">
    private $_typeExportClasses = array(
            XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_PRODUCT
            => XCart\Modules\AmazonFeeds\Feeds\Export\Products::className,

            XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_INVENTORY
            => XCart\Modules\AmazonFeeds\Feeds\Export\Inventory::className,

            XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_PRICING
            => XCart\Modules\AmazonFeeds\Feeds\Export\Pricing::className,

            XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_IMAGE
            => XCart\Modules\AmazonFeeds\Feeds\Export\Images::className,

            XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_RELATIONSHIP
            => XCart\Modules\AmazonFeeds\Feeds\Export\Relationships::className
        );
    // </editor-fold>

    // <editor-fold desc="Type-Import-Classes" defaultstate="collapsed">
    private $_typeImportClasses = array(
            XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_PRODUCT
            => XCart\Modules\AmazonFeeds\Feeds\Import\Results::className,

            XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_INVENTORY
            => XCart\Modules\AmazonFeeds\Feeds\Import\Results::className,

            XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_PRICING
            => XCart\Modules\AmazonFeeds\Feeds\Import\Results::className,

            XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_IMAGE
            => XCart\Modules\AmazonFeeds\Feeds\Import\Results::className,

            XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_RELATIONSHIP
            => XCart\Modules\AmazonFeeds\Feeds\Import\Results::className
        );
    // </editor-fold>

    public static function getInstance()
    { // {{{
        // Call parent getter
        return parent::getClassInstance(__CLASS__);
    } // }}}

    public static function getProductTypes()
    { // {{{
        return \XCart\Modules\AmazonFeeds\Feeds\Catalog\Categories::getInstance()->getFlattenCategories();
    } // }}}

    public function getHash()
    { // {{{
        return md5(serialize($this->getConfigAsArray()));
    } // }}}

    public function getConfigAsArray()
    { // {{{
        return $this->_params;
    } // }}}

    public function getConfigAsObject()
    { // {{{
        static $configObject = null;

        if (is_null($configObject)) {
            $configObject = new stdClass();

            foreach ($this->_params as $key => $value) {
                $configObject->$key = $value;
            }
        }

        return $configObject;
    } // }}}

    public function getTypeExportClasses()
    { // {{{
        return $this->_typeExportClasses;
    } // }}}

    public function getTypeImportClasses()
    { // {{{
        return $this->_typeImportClasses;
    } // }}}

    protected function __construct()
    { // {{{

        // Call parent constructor
        parent::__construct();

        // Globals
        global $config, $sql_tbl;

        // Get module config params
        if (!empty($config[AMAZON_FEEDS])) {
            foreach ($config[AMAZON_FEEDS] as $p_key => $_p_value) {
                if (strrpos($p_key, 'afds_', -strlen($p_key)) !== FALSE) {
                    $this->_params[substr($p_key, 5)] = $_p_value;
                }
            }
        }

        // Get marketplace list
        $marketplaces = func_amazon_feeds_get_marketplaces();

        // Marketplace name
        $this->_params[XCAmazonFeedsDefs::CONFIG_VAR_MARKETPLACE_CODE]
            = !empty($marketplaces[$this->_params[XCAmazonFeedsDefs::CONFIG_VAR_MARKETPLACE_ID]])
                ? $marketplaces[$this->_params[XCAmazonFeedsDefs::CONFIG_VAR_MARKETPLACE_ID]]
                : '';

        // Encoding
        switch ($this->_params[XCAmazonFeedsDefs::CONFIG_VAR_MARKETPLACE_CODE]) {
            case 'country_CH':
                $this->_params[XCAmazonFeedsDefs::CONFIG_VAR_ENCODING] = 'UTF-8';
                break;
            case 'country_JP':
                $this->_params[XCAmazonFeedsDefs::CONFIG_VAR_ENCODING] = 'Shift-JIS';
                break;
            default:
                $this->_params[XCAmazonFeedsDefs::CONFIG_VAR_ENCODING] = 'ISO-8859-1';
        }

        // Set app params
        $this->_params[XCAmazonFeedsDefs::CONFIG_VAR_APP_NAME] = 'X-Cart';
        $this->_params[XCAmazonFeedsDefs::CONFIG_VAR_APP_VERSION]
            = func_query_first_cell("SELECT value FROM $sql_tbl[config] WHERE name='version'");

    } // }}}

} // }}}

class XCXMLReader extends XMLReader { // {{{

    public function expandXpath($path, $version = '1.0', $encoding = 'UTF-8')
    { // {{{
        return $this->expandSimpleXml($version, $encoding)->xpath($path);
    } // }}}

    public function expandString($version = '1.0', $encoding = 'UTF-8')
    { // {{{
        return $this->expandSimpleXml($version, $encoding)->asXML();
    } // }}}

    public function expandSimpleXml($version = '1.0', $encoding = 'UTF-8', $className = null)
    { // {{{
        $element = $this->expand();

        $document = new DomDocument($version, $encoding);
        $node = $document->importNode($element, true);
        $document->appendChild($node);

        return simplexml_import_dom($node, $className);
    } // }}}
} // }}}

abstract class XCAmazonFeedsExportImportProcessor { // {{{

    const EXPORT_DIR_NAME = 'export';
    const IMPORT_DIR_NAME = 'import';

    protected $_config;

    protected $_workingDir;
    protected $_workingFiles;

    /**
     * @var XCart\Modules\AmazonFeeds\Feeds\Feed
     */
    protected $_currentFeed;

    protected abstract function defineDir();
    protected abstract function defineFiles();

    public function __construct()
    { // {{{
        set_time_limit(86400);

        func_set_memory_limit('96M');

        x_load('category','product','files','export');

        $this->_config = \XCAmazonFeedsConfig::getInstance()->getConfigAsObject();

        $this->defineDir();
        $this->defineFiles();
    } // }}}

    public function getConfig()
    { // {{{
        return $this->_config;
    } // }}}

    public function getWorkingDir()
    { // {{{
        return $this->_workingDir;
    } // }}}

    /**
     * Delete all files in working dir
     *
     * @return void
     */
    public function deleteAllFiles()
    { // {{{
        func_rm_dir($this->_workingDir, true);
    } // }}}

    /**
     * Check working dir
     *
     * @global type $top_message
     * @global type $export_dir
     *
     * @return boolean
     */
    protected function checkDir()
    { // {{{
        global $top_message, $export_dir;

        $export_dir = $this->_workingDir;

        // Create directory if it does not exist
        if (!is_dir($export_dir)) {
            func_mkdir($export_dir);
        }

        // Check if it is writable
        if (!func_export_dir_is_writable()) {

            x_session_register('top_message');

            $top_message['content'] = func_get_langvar_by_name('err_amazon_feeds_dir_permission_denied',  array('path' => $export_dir));
            $top_message['type'] = 'E';

            return false;
        }

        return true;
    } // }}}

} // }}}

class XCAmazonFeedsExporter extends XCAmazonFeedsExportImportProcessor { // {{{

    protected function defineDir()
    { // {{{
        global $var_dirs;

        $this->_workingDir = $var_dirs['var'] . XC_DS . self::EXPORT_DIR_NAME;

        if (!$this->checkDir()) {
            func_amazon_feeds_debug_log(func_get_langvar_by_name('msg_adm_incorrect_store_perms', array('path' => $this->_workingDir)));
            return false;
        }
    } // }}}

    protected function defineFiles()
    { // {{{
        $this->_workingFiles = XCAmazonFeedsConfig::getInstance()->getTypeExportClasses();
    } // }}}

    public function export($feedNames)
    { // {{{

        func_amazon_feeds_set_processing_feed('::begin');

        func_amazon_feeds_set_processing_step('::building'
            , func_get_langvar_by_name('lbl_amazon_feeds_building_feed', false, false, true)
        );

        $readyFiles = array();

        foreach($feedNames as $feedName) {

            if (
                ($feed = $this->_workingFiles[$feedName])
                && !empty($feed)
            ) {
                $this->_currentFeed = new $feed($this);

                if (!$this->_currentFeed->isWorking()) {

                    $this->_currentFeed->save();
                }

                if (
                    $this->_currentFeed->isFinished()
                    && !$this->_currentFeed->isEmpty()
                ) {
                    $readyFiles[$this->_currentFeed->getFilename()] = $this->_currentFeed->getRealPath();
                }
            }
        }

        $xmlExchange = new XCart\Modules\AmazonFeeds\Feeds\XMLExchange\Processor();

        func_amazon_feeds_set_processing_step('::submitting'
            , func_get_langvar_by_name('lbl_amazon_feeds_submitting_feed', false, false, true)
        );

        if (!empty($readyFiles)) {
            $xmlExchange->submitFeed($readyFiles);
        }

        func_amazon_feeds_set_processing_feed('::end');
    } // }}}

} // }}}

class XCAmazonFeedsImporter extends XCAmazonFeedsExportImportProcessor { // {{{

    protected function defineDir()
    { // {{{
        global $var_dirs;

        $this->_workingDir = $var_dirs['var'] . XC_DS . self::IMPORT_DIR_NAME;

        if (!$this->checkDir()) {
            func_amazon_feeds_debug_log(func_get_langvar_by_name('msg_adm_incorrect_store_perms', array('path' => $this->_workingDir)));
            return false;
        }
    } // }}}

    protected function defineFiles()
    { // {{{
        $this->_workingFiles = XCAmazonFeedsConfig::getInstance()->getTypeImportClasses();
    } // }}}

    public function getImportDir()
    { // {{{
        return $this->_workingDir;
    } // }}}

    public function import($feeds)
    { // {{{

        func_amazon_feeds_set_processing_feed('::begin');

        func_amazon_feeds_set_processing_step('::loading'
            , func_get_langvar_by_name('lbl_amazon_feeds_loading_results', false, false, true)
        );

        foreach($feeds as $feedData) {

            $messageName = func_amazon_feeds_get_type_from_filename($feedData['filename']);

            if (
                !empty($messageName)
                && !empty(\XCart\Modules\AmazonFeeds\Feeds\Feed::$messageFeed[$messageName])
                && ($feedType = \XCart\Modules\AmazonFeeds\Feeds\Feed::$messageFeed[$messageName])
                && ($feed = $this->_workingFiles[$feedType])
                && !empty($feed)
            ) {
                $this->_currentFeed = new $feed($this);

                if (!$this->_currentFeed->isWorking()) {
                    func_amazon_feeds_set_processing_feed($messageName);

                    $this->_currentFeed->load($feedData['filename'] . XCAmazonFeedsDefs::RESULTS_FILE_SUFFIX);
                }

                if ($this->_currentFeed->isFinished()) {
                    //$this->_currentFile->delete();
                }
            }
        }

        func_amazon_feeds_set_processing_feed('::end');

    } // }}}

} // }}}

abstract class XCAmazonFeedsCommonAPI extends XC_Singleton { // {{{

    const SERVICE_URL = 'ABSTRACT_SERVICE_URL';

    protected $config = array(
        'ProxyHost' => null,
        'ProxyPort' => -1,
        'ProxyUsername' => null,
        'ProxyPassword' => null,
        'MaxErrorRetry' => 3,
    );

    protected $service;
    protected $settings;

    protected function __construct($serviceURL, $region = 'us')
    { // {{{
        parent::__construct();

        $domains = array(
            'uk' => 'co.uk',
            'gb' => 'co.uk',//the same as uk
            'us' => 'com',
            'de' => 'de',
            'jp' => 'co.jp',
        );

        $domain = isset($domains[$region]) ? $domains[$region] : $domains['us'];
        $serviceURL = str_replace('{domain}' ,$domain, $serviceURL);

        $this->config['ServiceURL'] = $serviceURL;
    } // }}}

    protected function callAPIfunction($function, $request)
    { // {{{
        $response = '';
        $debug_func_raw = function($request, $response) {
            x_log_add(AMAZON_FEEDS . '_raw', print_r($request, true) . print_r($response, true), true);#nolint
        };

        try {

            $response = $this->service->$function($request);

            if (!function_exists('func_xml_format')) {
                x_load('xml');
            }

            $resp = func_xml_format($response->toXML());
            func_amazon_feeds_debug_log($resp);
            defined('XC_AMAZON_FEEDS_DEBUG_RAW') && $debug_func_raw($request, $resp);

            return $response;

        } catch (MarketplaceWebService_Exception $ex) {

            $this->logException($ex);
            defined('XC_AMAZON_FEEDS_DEBUG_RAW') && $debug_func_raw($request, $response);

        } catch (MarketplaceWebServiceSellers_Exception $ex) {

            $this->logException($ex);
            defined('XC_AMAZON_FEEDS_DEBUG_RAW') && $debug_func_raw($request, $response);

        } catch (Exception $ex) {

            func_amazon_feeds_debug_log($ex);
            defined('XC_AMAZON_FEEDS_DEBUG_RAW') && $debug_func_raw($request, $response);
        }

    } // }}}

    protected function logException(Exception $ex)
    { // {{{
        global $top_message;

        $exception = <<<MSG
    Caught Exception: {$ex->getMessage()}
    Response Status Code: {$ex->getStatusCode()}
    Error Code: {$ex->getErrorCode()}
    Error Type: {$ex->getErrorType()}
    Request ID: {$ex->getRequestId()}
    XML: {$ex->getXML()}
    ResponseHeaderMetadata: {$ex->getResponseHeaderMetadata()}
MSG;

        $top_message['type'] = 'E';
        $top_message['content'] = $ex->getMessage();

        func_amazon_feeds_debug_log($exception);
    } // }}}

} // }}}

class XCAmazonFeedsSellerAPI extends XCAmazonFeedsCommonAPI { // {{{

    const SERVICE_URL = 'https://mws.amazonservices.{domain}/Sellers/2011-07-01';

    public static function getInstance()
    { // {{{
        return parent::getClassInstance(__CLASS__);
    } // }}}

    protected function __construct()
    { // {{{
        $this->settings = XCAmazonFeedsConfig::getInstance()->getConfigAsObject();

        parent::__construct(self::SERVICE_URL, $this->settings->account_region);//afds_account_region

        $this->service = new MarketplaceWebServiceSellers_Client(
            $this->settings->{XCAmazonFeedsDefs::CONFIG_VAR_AWS_ID}
            , $this->settings->{XCAmazonFeedsDefs::CONFIG_VAR_AWS_SECRET}
            , $this->settings->{XCAmazonFeedsDefs::CONFIG_VAR_APP_NAME}
            , $this->settings->{XCAmazonFeedsDefs::CONFIG_VAR_APP_VERSION}
            , $this->config
        );
    } // }}}

    /**
     * Get List Marketplace Participations
     *
     * @return MarketplaceWebServiceSellers_Model_ListMarketplaceParticipationsResponse
     *
     * @throws MarketplaceWebServiceSellers_Exception
     */
    public function listMarketplaceParticipations()
    { // {{{
        $request = new MarketplaceWebServiceSellers_Model_ListMarketplaceParticipationsRequest();
        $request->setSellerId($this->settings->{XCAmazonFeedsDefs::CONFIG_VAR_MERCHANT_ID});

        return $this->callAPIfunction(__FUNCTION__, $request);
    } // }}}

    /**
     * Get Service Status
     *
     * @return MarketplaceWebServiceSellers_Model_GetServiceStatusResponse
     *
     * @throws MarketplaceWebServiceSellers_Exception
     */
    public function GetServiceStatus()
    { // {{{
        $request = new MarketplaceWebServiceSellers_Model_GetServiceStatusResponse();

        return $this->callAPIfunction(__FUNCTION__, $request);
    } // }}}

} // }}}

class XCAmazonFeedsFeedsAPI extends XCAmazonFeedsCommonAPI { // {{{

    const SERVICE_URL = 'https://mws.amazonservices.{domain}';

    public static function getInstance()
    { // {{{
        return parent::getClassInstance(__CLASS__);
    } // }}}

    protected function __construct()
    { // {{{
        $this->settings = XCAmazonFeedsConfig::getInstance()->getConfigAsObject();

        parent::__construct(self::SERVICE_URL, $this->settings->account_region);//afds_account_region

        $this->service = new MarketplaceWebService_Client(
            $this->settings->{XCAmazonFeedsDefs::CONFIG_VAR_AWS_ID}
            , $this->settings->{XCAmazonFeedsDefs::CONFIG_VAR_AWS_SECRET}
            , $this->config
            , $this->settings->{XCAmazonFeedsDefs::CONFIG_VAR_APP_NAME}
            , $this->settings->{XCAmazonFeedsDefs::CONFIG_VAR_APP_VERSION}
        );
    } // }}}

    /**
     * Get Feed Submission List
     *
     * @param string $feedSubmissionIdList
     * @param integer $maxCount
     * @param string $feedTypeList
     * @param string $feedProcessingStatusList
     * @param string $submittedFromDate
     * @param string $submittedToDate
     *
     * @return MarketplaceWebService_Model_GetFeedSubmissionListRequest
     *
     * @throws MarketplaceWebService_Exception
     */
    public function getFeedSubmissionList($feedSubmissionIdList = null, $maxCount = null, $feedTypeList = null, $feedProcessingStatusList = null, $submittedFromDate = null, $submittedToDate = null)
    { // {{{
        $request = new MarketplaceWebService_Model_GetFeedSubmissionListRequest();
        $request->setMerchant($this->settings->{XCAmazonFeedsDefs::CONFIG_VAR_MERCHANT_ID});

        if ($feedSubmissionIdList) {
            $request->setFeedSubmissionIdList($feedSubmissionIdList);
        }

        if ($maxCount) {
            $request->setMaxCount($maxCount);
        }

        if ($feedTypeList) {
            $request->setFeedTypeList($feedTypeList);
        }

        if ($feedProcessingStatusList) {
            $request->setFeedProcessingStatusList($feedProcessingStatusList);
        }

        if ($submittedFromDate) {
            $request->setSubmittedFromDate($submittedFromDate);
        }

        if ($submittedToDate) {
            $request->setSubmittedToDate($submittedToDate);
        }

        return $this->callAPIfunction(__FUNCTION__, $request);
    } // }}}

    /**
     * Get Feed Submission Count
     *
     * @param string $feedTypeList
     * @param string $feedProcessingStatusList
     * @param string $submittedFromDate
     * @param string $submittedToDate
     *
     * @return MarketplaceWebService_Model_GetFeedSubmissionCountRequest
     *
     * @throws MarketplaceWebService_Exception
     */
    public function getFeedSubmissionCount($feedTypeList = null, $feedProcessingStatusList = null, $submittedFromDate = null, $submittedToDate = null)
    { // {{{
        $request = new MarketplaceWebService_Model_GetFeedSubmissionCountRequest();
        $request->setMerchant($this->settings->{XCAmazonFeedsDefs::CONFIG_VAR_MERCHANT_ID});

        if ($feedTypeList) {
            $request->setFeedTypeList($feedTypeList);
        }

        if ($feedProcessingStatusList) {
            $request->setFeedProcessingStatusList($feedProcessingStatusList);
        }

        if ($submittedFromDate) {
            $request->setSubmittedFromDate($submittedFromDate);
        }

        if ($submittedToDate) {
            $request->setSubmittedToDate($submittedToDate);
        }

        return $this->callAPIfunction(__FUNCTION__, $request);
    } // }}}

    /**
     * Cancel Feed Submissions
     *
     * @param string $feedSubmissionIdList
     * @param string $feedTypeList
     * @param string $submittedFromDate
     * @param string $submittedToDate
     *
     * @return MarketplaceWebService_Model_CancelFeedSubmissionsRequest
     *
     * @throws MarketplaceWebService_Exception
     */
    public function cancelFeedSubmissions($feedSubmissionIdList = null, $feedTypeList = null, $submittedFromDate = null, $submittedToDate = null)
    { // {{{
        $request = new MarketplaceWebService_Model_CancelFeedSubmissionsRequest();
        $request->setMerchant($this->settings->{XCAmazonFeedsDefs::CONFIG_VAR_MERCHANT_ID});

        if ($feedSubmissionIdList) {
            $request->setFeedSubmissionIdList($feedSubmissionIdList);
        }

        if ($feedTypeList) {
            $request->setFeedTypeList($feedTypeList);
        }

        if ($submittedFromDate) {
            $request->setSubmittedFromDate($submittedFromDate);
        }

        if ($submittedToDate) {
            $request->setSubmittedToDate($submittedToDate);
        }

        return $this->callAPIfunction(__FUNCTION__, $request);
    } // }}}

    /**
     * Get Feed Submission Result
     *
     * @param string $feedSubmissionId
     * @param handler $feedSubmitionResult
     *
     * @return MarketplaceWebService_Model_GetFeedSubmissionResultRequest
     *
     * @throws MarketplaceWebService_Exception
     */
    public function getFeedSubmissionResult($feedSubmissionId, $feedSubmitionResult)
    { // {{{
        $request = new MarketplaceWebService_Model_GetFeedSubmissionResultRequest();
        $request->setMerchant($this->settings->{XCAmazonFeedsDefs::CONFIG_VAR_MERCHANT_ID});

        $request->setFeedSubmissionId($feedSubmissionId);
        
        $request->setFeedSubmissionResult($feedSubmitionResult);

        return $this->callAPIfunction(__FUNCTION__, $request);
    } // }}}

    /**
     * Submit Feed
     *
     * @param HTTP-BODY $feedContent
     * @param string $feedType
     * @param string $marketplaceIdList
     * @param boolean $purgeAndReplace
     *
     * @return MarketplaceWebService_Model_SubmitFeedRequest
     *
     * @throws MarketplaceWebService_Exception
     */
    public function SubmitFeed($feedContent, $feedType, $marketplaceIdList = '', $purgeAndReplace = false)
    { // {{{
        $request = new MarketplaceWebService_Model_SubmitFeedRequest();
        $request->setMerchant($this->settings->{XCAmazonFeedsDefs::CONFIG_VAR_MERCHANT_ID});

        $request->setFeedContent($feedContent);

        $request->setFeedType($feedType);

        $request->setContentMd5(base64_encode(md5(stream_get_contents($feedContent), true)));

        if ($marketplaceIdList) {
            $request->setMarketplaceIdList($marketplaceIdList);
        }

        if ($purgeAndReplace) {
            $request->setPurgeAndReplace($purgeAndReplace);
        }

        return $this->callAPIfunction(__FUNCTION__, $request);
    } // }}}

} // }}}
