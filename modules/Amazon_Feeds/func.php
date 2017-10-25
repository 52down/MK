<?php
/* vim: set ts=4 sw=4 sts=4 et: */
/* ****************************************************************************\
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
 * Functions
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Michael Bugrov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    5a3bb4dd1fb27e8b32d3a81a9ca5283dee6f9945, v14 (xcart_4_7_8), 2017-04-24 18:24:39, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */
if (!defined('XCART_START')) {
    header("Location: ../../");
    die("Access denied");
}

/**
 * Initialize module
 */
function func_amazon_feeds_init()
{ // {{{

    if ( !func_amazon_feeds_is_available() ) {
        // Skip initialization if not available
        return;
    }

    // load classes
    func_amazon_feeds_load_classes();

    if (defined('ADMIN_MODULES_CONTROLLER')) {
        // Register module toggle handler
        if (function_exists('func_add_event_listener')) {
            func_add_event_listener('module.ajax.toggle', 'func_amazon_feeds_on_module_toggle');
        }
    }

    if (defined('ADMIN_CONFIGURATION_CONTROLLER')) {
        // Register module config update handler
        if (function_exists('func_add_event_listener')) {
            func_add_event_listener('module.config.update', 'XCAmazonFeedsAdminRequestProcessor::processRequest');
        }
    }

    global $smarty;

    // allow static class const access in smarty
    $smarty->changeSecurity(array('static_classes' => array('XCAmazonFeedsDefs')));
} // }}}

function func_amazon_feeds_is_available()
{ // {{{
    global $single_mode, $active_modules;

    $area_type = func_constant('AREA_TYPE');

    if (
        $area_type === 'A'
        || (
            (
                $single_mode
                || !empty($active_modules['Simple_Mode'])
            )
            && $area_type === 'P'
        )
    ) {
        return true;
    }

    return false;
} // }}}

function func_amazon_feeds_load_classes()
{ // {{{
    global $xcart_dir;

    if (!function_exists('func_amazon_feeds_load_class')) {

        function func_amazon_feeds_load_class($class_name)
        {
            global $xcart_dir;

            static $classesIncludeLib = array( // {{{
                'XCStringUtils' => 'include/classes/class.XCStringUtils'
            ); // }}}

            if (
                isset($classesIncludeLib[$class_name])
            ) {
                include $xcart_dir . XC_DS . $classesIncludeLib[$class_name] . '.php';
                return;
            }

            static $classesLibAmazonFeeds = array( // {{{
                // root
                'MarketplaceWebService_Client' => 'Client',
                'MarketplaceWebService_Exception' => 'Exception',
                'MarketplaceWebService_Interface' => 'Interface',
                'MarketplaceWebService_Mock' => 'Mock',
                'MarketplaceWebService_Model' => 'Model',
                'RequestType' => 'RequestType',
                // model
                'MarketplaceWebService_Model_CancelFeedSubmissionsRequest' => 'Model/CancelFeedSubmissionsRequest',
                'MarketplaceWebService_Model_CancelFeedSubmissionsResponse' => 'Model/CancelFeedSubmissionsResponse',
                'MarketplaceWebService_Model_CancelFeedSubmissionsResult' => 'Model/CancelFeedSubmissionsResult',
                'MarketplaceWebService_Model_CancelReportRequestsRequest' => 'Model/CancelReportRequestsRequest',
                'MarketplaceWebService_Model_CancelReportRequestsResponse' => 'Model/CancelReportRequestsResponse',
                'MarketplaceWebService_Model_CancelReportRequestsResult' => 'Model/CancelReportRequestsResult',
                'MarketplaceWebService_Model_ContentType' => 'Model/ContentType',
                'MarketplaceWebService_Model_Error' => 'Model/Error',
                'MarketplaceWebService_Model_ErrorResponse' => 'Model/ErrorResponse',
                'MarketplaceWebService_Model_FeedSubmissionInfo' => 'Model/FeedSubmissionInfo',
                'MarketplaceWebService_Model_GetFeedSubmissionCountRequest' => 'Model/GetFeedSubmissionCountRequest',
                'MarketplaceWebService_Model_GetFeedSubmissionCountResponse' => 'Model/GetFeedSubmissionCountResponse',
                'MarketplaceWebService_Model_GetFeedSubmissionCountResult' => 'Model/GetFeedSubmissionCountResult',
                'MarketplaceWebService_Model_GetFeedSubmissionListByNextTokenRequest' => 'Model/GetFeedSubmissionListByNextTokenRequest',
                'MarketplaceWebService_Model_GetFeedSubmissionListByNextTokenResponse' => 'Model/GetFeedSubmissionListByNextTokenResponse',
                'MarketplaceWebService_Model_GetFeedSubmissionListByNextTokenResult' => 'Model/GetFeedSubmissionListByNextTokenResult',
                'MarketplaceWebService_Model_GetFeedSubmissionListRequest' => 'Model/GetFeedSubmissionListRequest',
                'MarketplaceWebService_Model_GetFeedSubmissionListResponse' => 'Model/GetFeedSubmissionListResponse',
                'MarketplaceWebService_Model_GetFeedSubmissionListResult' => 'Model/GetFeedSubmissionListResult',
                'MarketplaceWebService_Model_GetFeedSubmissionResultRequest' => 'Model/GetFeedSubmissionResultRequest',
                'MarketplaceWebService_Model_GetFeedSubmissionResultResponse' => 'Model/GetFeedSubmissionResultResponse',
                'MarketplaceWebService_Model_GetFeedSubmissionResultResult' => 'Model/GetFeedSubmissionResultResult',
                'MarketplaceWebService_Model_GetReportCountRequest' => 'Model/GetReportCountRequest',
                'MarketplaceWebService_Model_GetReportCountResponse' => 'Model/GetReportCountResponse',
                'MarketplaceWebService_Model_GetReportCountResult' => 'Model/GetReportCountResult',
                'MarketplaceWebService_Model_GetReportListByNextTokenRequest' => 'Model/GetReportListByNextTokenRequest',
                'MarketplaceWebService_Model_GetReportListByNextTokenResponse' => 'Model/GetReportListByNextTokenResponse',
                'MarketplaceWebService_Model_GetReportListByNextTokenResult' => 'Model/GetReportListByNextTokenResult',
                'MarketplaceWebService_Model_GetReportListRequest' => 'Model/GetReportListRequest',
                'MarketplaceWebService_Model_GetReportListResponse' => 'Model/GetReportListResponse',
                'MarketplaceWebService_Model_GetReportListResult' => 'Model/GetReportListResult',
                'MarketplaceWebService_Model_GetReportRequestCountRequest' => 'Model/GetReportRequestCountRequest',
                'MarketplaceWebService_Model_GetReportRequestCountResponse' => 'Model/GetReportRequestCountResponse',
                'MarketplaceWebService_Model_GetReportRequestCountResult' => 'Model/GetReportRequestCountResult',
                'MarketplaceWebService_Model_GetReportRequestListByNextTokenRequest' => 'Model/GetReportRequestListByNextTokenRequest',
                'MarketplaceWebService_Model_GetReportRequestListByNextTokenResponse' => 'Model/GetReportRequestListByNextTokenResponse',
                'MarketplaceWebService_Model_GetReportRequestListByNextTokenResult' => 'Model/GetReportRequestListByNextTokenResult',
                'MarketplaceWebService_Model_GetReportRequestListRequest' => 'Model/GetReportRequestListRequest',
                'MarketplaceWebService_Model_GetReportRequestListResponse' => 'Model/GetReportRequestListResponse',
                'MarketplaceWebService_Model_GetReportRequestListResult' => 'Model/GetReportRequestListResult',
                'MarketplaceWebService_Model_GetReportRequest' => 'Model/GetReportRequest',
                'MarketplaceWebService_Model_GetReportResponse' => 'Model/GetReportResponse',
                'MarketplaceWebService_Model_GetReportResult' => 'Model/GetReportResult',
                'MarketplaceWebService_Model_GetReportScheduleCountRequest' => 'Model/GetReportScheduleCountRequest',
                'MarketplaceWebService_Model_GetReportScheduleCountResponse' => 'Model/GetReportScheduleCountResponse',
                'MarketplaceWebService_Model_GetReportScheduleCountResult' => 'Model/GetReportScheduleCountResult',
                'MarketplaceWebService_Model_GetReportScheduleListByNextTokenRequest' => 'Model/GetReportScheduleListByNextTokenRequest',
                'MarketplaceWebService_Model_GetReportScheduleListByNextTokenResponse' => 'Model/GetReportScheduleListByNextTokenResponse',
                'MarketplaceWebService_Model_GetReportScheduleListByNextTokenResult' => 'Model/GetReportScheduleListByNextTokenResult',
                'MarketplaceWebService_Model_GetReportScheduleListRequest' => 'Model/GetReportScheduleListRequest',
                'MarketplaceWebService_Model_GetReportScheduleListResponse' => 'Model/GetReportScheduleListResponse',
                'MarketplaceWebService_Model_GetReportScheduleListResult' => 'Model/GetReportScheduleListResult',
                'MarketplaceWebService_Model_IdList' => 'Model/IdList',
                'MarketplaceWebService_Model_ManageReportScheduleRequest' => 'Model/ManageReportScheduleRequest',
                'MarketplaceWebService_Model_ManageReportScheduleResponse' => 'Model/ManageReportScheduleResponse',
                'MarketplaceWebService_Model_ManageReportScheduleResult' => 'Model/ManageReportScheduleResult',
                'MarketplaceWebService_Model_ReportInfo' => 'Model/ReportInfo',
                'MarketplaceWebService_Model_ReportRequestInfo' => 'Model/ReportRequestInfo',
                'MarketplaceWebService_Model_ReportSchedule' => 'Model/ReportSchedule',
                'MarketplaceWebService_Model_RequestReportRequest' => 'Model/RequestReportRequest',
                'MarketplaceWebService_Model_RequestReportResponse' => 'Model/RequestReportResponse',
                'MarketplaceWebService_Model_RequestReportResult' => 'Model/RequestReportResult',
                'MarketplaceWebService_Model_ResponseHeaderMetadata' => 'Model/ResponseHeaderMetadata',
                'MarketplaceWebService_Model_ResponseMetadata' => 'Model/ResponseMetadata',
                'MarketplaceWebService_Model_StatusList' => 'Model/StatusList',
                'MarketplaceWebService_Model_SubmitFeedRequest' => 'Model/SubmitFeedRequest',
                'MarketplaceWebService_Model_SubmitFeedResponse' => 'Model/SubmitFeedResponse',
                'MarketplaceWebService_Model_SubmitFeedResult' => 'Model/SubmitFeedResult',
                'MarketplaceWebService_Model_TypeList' => 'Model/TypeList',
                'MarketplaceWebService_Model_UpdateReportAcknowledgementsRequest' => 'Model/UpdateReportAcknowledgementsRequest',
                'MarketplaceWebService_Model_UpdateReportAcknowledgementsResponse' => 'Model/UpdateReportAcknowledgementsResponse',
                'MarketplaceWebService_Model_UpdateReportAcknowledgementsResult' => 'Model/UpdateReportAcknowledgementsResult',
            ); // }}}

            if (
                isset($classesLibAmazonFeeds[$class_name])
            ) {
                include $xcart_dir . XC_DS . 'include' . XC_DS . 'lib' . XC_DS . 'amazonMWS' . XC_DS . 'Feeds' . XC_DS . 'src' . XC_DS . 'MarketplaceWebService' . XC_DS . $classesLibAmazonFeeds[$class_name] . '.php';
                return;
            }

            static $classesLibAmazonSellers = array( // {{{
                // root
                'MarketplaceWebServiceSellers_Client' => 'Client',
                'MarketplaceWebServiceSellers_Exception' => 'Exception',
                'MarketplaceWebServiceSellers_Interface' => 'Interface',
                'MarketplaceWebServiceSellers_Mock' => 'Mock',
                'MarketplaceWebServiceSellers_Model' => 'Model',
                // model
                'MarketplaceWebServiceSellers_Model_GetServiceStatusRequest' => 'Model/GetServiceStatusRequest',
                'MarketplaceWebServiceSellers_Model_GetServiceStatusResponse' => 'Model/GetServiceStatusResponse',
                'MarketplaceWebServiceSellers_Model_GetServiceStatusResult' => 'Model/GetServiceStatusResult',
                'MarketplaceWebServiceSellers_Model_ListMarketplaceParticipationsByNextTokenRequest' => 'Model/ListMarketplaceParticipationsByNextTokenRequest',
                'MarketplaceWebServiceSellers_Model_ListMarketplaceParticipationsByNextTokenResponse' => 'Model/ListMarketplaceParticipationsByNextTokenResponse',
                'MarketplaceWebServiceSellers_Model_ListMarketplaceParticipationsByNextTokenResult' => 'Model/ListMarketplaceParticipationsByNextTokenResult',
                'MarketplaceWebServiceSellers_Model_ListMarketplaceParticipationsRequest' => 'Model/ListMarketplaceParticipationsRequest',
                'MarketplaceWebServiceSellers_Model_ListMarketplaceParticipationsResponse' => 'Model/ListMarketplaceParticipationsResponse',
                'MarketplaceWebServiceSellers_Model_ListMarketplaceParticipationsResult' => 'Model/ListMarketplaceParticipationsResult',
                'MarketplaceWebServiceSellers_Model_ListMarketplaces' => 'Model/ListMarketplaces',
                'MarketplaceWebServiceSellers_Model_ListParticipations' => 'Model/ListParticipations',
                'MarketplaceWebServiceSellers_Model_Marketplace' => 'Model/Marketplace',
                'MarketplaceWebServiceSellers_Model_Message' => 'Model/Message',
                'MarketplaceWebServiceSellers_Model_MessageList' => 'Model/MessageList',
                'MarketplaceWebServiceSellers_Model_Participation' => 'Model/Participation',
                'MarketplaceWebServiceSellers_Model_ResponseHeaderMetadata' => 'Model/ResponseHeaderMetadata',
                'MarketplaceWebServiceSellers_Model_ResponseMetadata' => 'Model/ResponseMetadata'
            ); // }}}

            if (
                isset($classesLibAmazonSellers[$class_name])
            ) {
                include $xcart_dir . XC_DS . 'include' . XC_DS . 'lib' . XC_DS . 'amazonMWS' . XC_DS . 'Sellers' . XC_DS . 'src' . XC_DS . 'MarketplaceWebServiceSellers' . XC_DS . $classesLibAmazonSellers[$class_name] . '.php';
                return;
            }

            static $classesModuleAmazonFeeds = array( // {{{
                'XCart\Modules\AmazonFeeds\Feeds\Catalog\Categories' => 'Feeds/Catalog/Categories',
                'XCart\Modules\AmazonFeeds\Feeds\Export\Feed' => 'Feeds/Export/Feed',
                'XCart\Modules\AmazonFeeds\Feeds\Export\Products' => 'Feeds/Export/Products',
                'XCart\Modules\AmazonFeeds\Feeds\Export\Inventory' => 'Feeds/Export/Inventory',
                'XCart\Modules\AmazonFeeds\Feeds\Export\Pricing' => 'Feeds/Export/Pricing',
                'XCart\Modules\AmazonFeeds\Feeds\Export\Images' => 'Feeds/Export/Images',
                'XCart\Modules\AmazonFeeds\Feeds\Export\Relationships' => 'Feeds/Export/Relationships',
                'XCart\Modules\AmazonFeeds\Feeds\XMLExchange\Processor' => 'Feeds/XMLExchange/Processor',
                'XCart\Modules\AmazonFeeds\Feeds\Import\Feed' => 'Feeds/Import/Feed',
                'XCart\Modules\AmazonFeeds\Feeds\Import\Results' => 'Feeds/Import/Results',
                'XCart\Modules\AmazonFeeds\Feeds\Feed' => 'Feeds/Feed'
            ); // }}}

            if (
                isset($classesModuleAmazonFeeds[$class_name])
            ) {
                include $xcart_dir . XC_DS . 'modules' . XC_DS . AMAZON_FEEDS . XC_DS . $classesModuleAmazonFeeds[$class_name] . '.php';
                return;
            }
        }

        // register class loader
        spl_autoload_register('func_amazon_feeds_load_class');
    }

    // load basic classes
    require_once $xcart_dir . XC_DS . 'modules' . XC_DS . AMAZON_FEEDS . XC_DS . 'classes.php';
} // }}}

function func_amazon_feeds_debug_log($message)
{ // {{{
    if (
        (defined('XC_AMAZON_FEEDS_DEBUG') || defined('DEVELOPMENT_MODE'))
        && !empty($message)
    ) {
        if ($message instanceof \Exception) {
            $message = <<<MSG
    Caught Exception: {$message->getMessage()}
    Response Status Code: {$message->getCode()}
MSG;
        }

        x_log_add(AMAZON_FEEDS, $message);
    }
} // }}}

function func_amazon_feeds_on_module_toggle($module_name, $module_new_state)
{ // {{{
    if ($module_name == AMAZON_FEEDS) {
        switch ($module_new_state) {
            case true:
                func_amazon_feeds_prepare_records();
        }
    }
} // }}}

function func_amazon_feeds_prepare_records()
{ // {{{
    global $sql_tbl, $active_modules;

    $count_products = func_query_first_cell(
        "SELECT COUNT(*)"
        . " FROM $sql_tbl[products]"
        . (
            !empty($active_modules['Product_Options'])
                ? \XCVariantsSQL::getJoinQueryAllRows()
                : ''
        )
    );

    $count_flags = func_query_first_cell(
        "SELECT COUNT(*)"
        . " FROM $sql_tbl[amazon_feeds_exports]"
    );

    // make sure tables are sync
    if (intval($count_products) != intval($count_flags)) {
        func_amazon_feeds_mark_all_products_pending();
    }

} // }}}

function func_amazon_feeds_mark_all_products_pending()
{ // {{{
    global $sql_tbl, $active_modules;

    // Mark all products
    db_query("REPLACE INTO $sql_tbl[amazon_feeds_exports]"
            . " ("
                . "SELECT "
                    . (
                        !empty($active_modules['Product_Options'])
                            ? \XCVariantsSQL::getVariantField('productid') . ' AS productid,'
                                . " $sql_tbl[variants].variantid" . ' AS variantid,'
                            : " $sql_tbl[products].productid AS productid,"
                                . " 0 AS variantid,"
                    )
                    . XCart\Modules\AmazonFeeds\Feeds\Feed::DATASET_STATUS_PENDING
                . " FROM $sql_tbl[products]"
                . (
                    !empty($active_modules['Product_Options'])
                        ? \XCVariantsSQL::getJoinQueryAllRows()
                        : ''
                )
            . ") "
    );
} // }}}

function func_amazon_feeds_set_processing_step($code, $name)
{ // {{{
    func_array2update('config', array(
        'value' => serialize(
            array(
                'code' => $code
                , 'name' => $name)
            )
        )
        , "name = '" . \XCAmazonFeedsDefs::FEED_PROCESSING_STEP . "'");
} // }}}

function func_amazon_feeds_get_processing_step()
{ // {{{
    global $sql_tbl;

    $step = func_query_first_cell(
        "SELECT value FROM $sql_tbl[config] WHERE name = '" . \XCAmazonFeedsDefs::FEED_PROCESSING_STEP . "'");

    return @unserialize($step);
} // }}}

function func_amazon_feeds_set_processing_feed($name)
{ // {{{
    func_array2update('config', array('value' => $name), "name = '" . \XCAmazonFeedsDefs::FEED_PROCESSING_FEED . "'");
} // }}}

function func_amazon_feeds_get_processing_feed()
{ // {{{
    global $sql_tbl;

    return func_query_first_cell(
        "SELECT value FROM $sql_tbl[config] WHERE name = '" . \XCAmazonFeedsDefs::FEED_PROCESSING_FEED . "'");
} // }}}

function func_amazon_feeds_get_marketplaces()
{ // {{{
    global $sql_tbl;

    $marketplaces = array();

    $variants_string = func_query_first_cell(
        "SELECT variants FROM $sql_tbl[config] WHERE name='afds_marketplace_id'");
    $variants_array = explode("\n", $variants_string);

    if (!empty($variants_array)) {
        foreach ($variants_array as $variant) {
            $elements = explode(':', $variant);
            if (
                !empty($elements[0])
                && !empty($elements[1])
            ) {
                $marketplaces[$elements[0]] = ucfirst($elements[1]);
            }
        }
    }

    return $marketplaces;
} // }}}

function func_amazon_feeds_get_productcode_by_variantid($variantid)
{ // {{{
    global $sql_tbl, $active_modules;

    if (!empty($active_modules['Product_Options'])) {

        $join_type = XCVariantsSQL::isVariantsExist() ? 'INNER' : 'LEFT';

        return func_query_first_cell("SELECT $sql_tbl[products].productcode"
            . " FROM $sql_tbl[products]"
                . " $join_type JOIN $sql_tbl[variants]"
                    . " ON $sql_tbl[variants].productid = $sql_tbl[products].productid"
                    . " AND $sql_tbl[variants].variantid = '" . intval($variantid) ."'"
        , true);
    }

    return '';
} // }}}

function func_amazon_feeds_get_productid_by_productcode($productcode)
{ // {{{
    global $sql_tbl, $active_modules;

    if (!empty($active_modules['Product_Options'])) {

        $join_type = XCVariantsSQL::isVariantsExist() ? 'INNER' : 'LEFT';

        return func_query_first("SELECT $sql_tbl[products].productid, $sql_tbl[variants].variantid"
            . " FROM $sql_tbl[products]"
            . " $join_type JOIN $sql_tbl[variants]"
                . " ON $sql_tbl[variants].productid = $sql_tbl[products].productid"
                . " AND $sql_tbl[variants].productcode = '" . addslashes($productcode) ."'"
        , true);
    }

    return func_query_first("SELECT $sql_tbl[products].productid, 0 AS variantid"
        . " FROM $sql_tbl[products]"
        . " WHERE $sql_tbl[products].productcode = '" . addslashes($productcode) . "'"
        , true);
} // }}}

function func_amazon_feeds_reset_exported_flag($productids, $mode = '')
{ // {{{
    global $active_modules, $sql_tbl;

    if (!is_array($productids)) {
        $productids = array($productids);
    }

    $productids = array_filter(array_unique($productids));
    $productids = func_array_map('intval', $productids);

    if (empty($productids)) {
        return false;
    }

    if ($mode === 'delete_flag') {
        db_query("DELETE FROM $sql_tbl[amazon_feeds_exports] WHERE productid IN ('" . implode("', '", $productids) . "')");
        return $productids;
    }

    if (
        !empty($active_modules['Product_Options'])
        && XCVariantsSQL::isVariantsExist()
    ) {
        if (!mt_rand(0,100)) {
            // integrity fix
            db_query("DELETE FROM $sql_tbl[amazon_feeds_exports] WHERE variantid NOT IN (SELECT variantid FROM $sql_tbl[variants] WHERE " . XCVariantsSQL::isVariantRow() . ") AND variantid>0");
            db_query("DELETE FROM $sql_tbl[amazon_feeds_results] WHERE variantid NOT IN (SELECT variantid FROM $sql_tbl[variants] WHERE " . XCVariantsSQL::isVariantRow() . ") AND variantid>0");
        }

        db_query("REPLACE INTO $sql_tbl[amazon_feeds_exports] SELECT productid, variantid, '" . (XCart\Modules\AmazonFeeds\Feeds\Feed::DATASET_STATUS_PENDING) . "' AS exported FROM $sql_tbl[variants] WHERE productid IN ('" . implode("', '", $productids) . "')");
    } else {
        db_query("REPLACE INTO $sql_tbl[amazon_feeds_exports] SELECT productid, variantid, '" . (XCart\Modules\AmazonFeeds\Feeds\Feed::DATASET_STATUS_PENDING) . "' AS exported FROM $sql_tbl[products] WHERE productid IN ('" . implode("', '", $productids) . "')");
    }
} // }}}

function func_amazon_feeds_add_avail_sections($avail_sections) { // {{{

    if ( !func_amazon_feeds_is_available() ) {
        // Skip initialization if not available
        return $avail_sections;
    }

    $avail_sections[] = XCAmazonFeedsDefs::PRODUCT_SECTION;

    return $avail_sections;
} //}}}

function func_amazon_feeds_add_dialog_tools_data($dialog_tools_data, $pm_link) { // {{{

    if ( !func_amazon_feeds_is_available() ) {
        // Skip initialization if not available
        return $dialog_tools_data;
    }

    $dialog_tools_data['left'][] = array(
        'link'  => $pm_link . '&section=' . XCAmazonFeedsDefs::PRODUCT_SECTION,
        'title' => func_get_langvar_by_name('lbl_amazon_feeds_details', null, false, true, false)
    );

    return $dialog_tools_data;
} //}}}

function func_amazon_feeds_get_product_type($productid)
{ // {{{
    global $sql_tbl;

    return func_query_first_cell(
        "SELECT $sql_tbl[amazon_feeds_catalog].product_type"
        . " FROM $sql_tbl[amazon_feeds_catalog]"
        . " WHERE $sql_tbl[amazon_feeds_catalog].productid = '" . intval($productid). "'"
    );
} // }}}

function func_amazon_feeds_get_feeds_results($productid)
{ // {{{
    global $sql_tbl, $active_modules;

    $sql = "SELECT "
        . (
            !empty($active_modules['Product_Options'])
                ? \XCVariantsSQL::getVariantField('productcode') . ' AS productcode,'
                : " $sql_tbl[products].productcode AS productcode,"
        )
        . " $sql_tbl[amazon_feeds_results].*"
        . " FROM $sql_tbl[products]"
        . (
            !empty($active_modules['Product_Options'])
                ? \XCVariantsSQL::getJoinQueryAllRows()
                    . " AND $sql_tbl[products].productid = '" . intval($productid) . "'"
                : ''
        )
        . " INNER JOIN $sql_tbl[amazon_feeds_results]"
            . " ON $sql_tbl[amazon_feeds_results].productid = $sql_tbl[products].productid"
            . (
                !empty($active_modules['Product_Options'])
                    ? " AND $sql_tbl[amazon_feeds_results].variantid = $sql_tbl[variants].variantid"
                    : " AND $sql_tbl[amazon_feeds_results].variantid = '0'"
            );

    return func_query($sql);
} // }}}

function func_amazon_feeds_get_catalog_items()
{ // {{{
    global $sql_tbl;

    return func_query_first_cell ("SELECT COUNT(*) FROM $sql_tbl[amazon_feeds_catalog]");
} // }}}

function func_amazon_feeds_get_type_from_filename($filename)
{ // {{{
    $parts = explode('_', $filename);

    return !empty($parts[1]) ? $parts[1] : false;
} // }}}

function func_amazon_feeds_add_search_conditions($data, &$fields, &$inner_joins, &$left_joins, &$where)
{ //{{{
    global $sql_tbl, $active_modules;

    // Search conditions
    if (AREA_TYPE != 'C') {

        if (!empty($data['amazon_feeds_exported'])) {

            switch ($data['amazon_feeds_exported']) {
                case 'exported':
                    $inner_joins['AFDS_EXPORTS'] = array(
                        'tblname' => 'amazon_feeds_exports',
                        'on' => $sql_tbl['products'] . '.productid = AFDS_EXPORTS.productid'
                            . (
                                !empty($active_modules['Product_Options'])
                                ? " AND $sql_tbl[variants].variantid = AFDS_EXPORTS.variantid"
                                : " AFDS_EXPORTS.variantid = '0'"
                            )
                    );
                    $where[] = "AFDS_EXPORTS.exported = '" . \XCart\Modules\AmazonFeeds\Feeds\Feed::DATASET_STATUS_EXPORTED . "'";
                    break;
                case 'has_errors' || 'has_warnings':
                    $left_joins['AFDS_RESULTS'] = array(
                        'tblname' => 'amazon_feeds_results',
                        'on' => $sql_tbl['products'] . '.productid = AFDS_RESULTS.productid'
                            . (
                                !empty($active_modules['Product_Options'])
                                ? " AND $sql_tbl[variants].variantid = AFDS_RESULTS.variantid"
                                : " AFDS_RESULTS.variantid = '0'"
                            )
                    );
                    $result = $data['amazon_feeds_exported'] == 'has_errors'
                        ? XCAmazonFeedsDefs::FEED_RESULT_ERROR_CODE
                        : XCAmazonFeedsDefs::FEED_RESULT_WARNING_CODE;
                    $where[] = "AFDS_RESULTS.result = '$result'";
                    break;
            }

        }

        if (!empty($data['s_amazon_feeds_product_type']) && $data['s_amazon_feeds_product_type'] != XCAmazonFeedsDefs::SEARCH_FORM_EMPTY_CAT_VALUE) {
            $inner_joins['AFDS_CATS'] = array(
                'tblname' => 'amazon_feeds_catalog',
                'on' => $sql_tbl['products'] . '.productid = AFDS_CATS.productid' . " AND AFDS_CATS.product_type='$data[s_amazon_feeds_product_type]'",
            );
        }
    } // if (AREA_TYPE != 'C')

} //}}}

function func_amazon_feeds_change_advanced_options_products(&$advanced_options, &$advanced_options_default_values)
{ //{{{
    if (AREA_TYPE != 'C') {
        $advanced_options = array_merge($advanced_options, array('amazon_feeds_exported', 's_amazon_feeds_product_type'));
        $advanced_options_default_values['s_amazon_feeds_product_type'] = (string)XCAmazonFeedsDefs::SEARCH_FORM_EMPTY_CAT_VALUE;
    }

} //}}}

function func_amazon_feeds_tpl_get_amazon_feeds_cats()
{ //{{{
    return XCAmazonFeedsConfig::getInstance()->getProductTypes();
} //}}}
