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
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v4 (xcart_4_7_7), 2017-01-24 09:29:34, Processor.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

namespace XCart\Modules\AmazonFeeds\Feeds\XMLExchange;

/**
 * Feeds processor
 * 
 * @see http://docs.developer.amazonservices.com/en_US/feeds/Feeds_SubmitFeed.html
 */
class Processor { // {{{

    /**
     * @var object API config
     */
    protected $config;

    /**
     * Constructor
     */
    public function __construct()
    { // {{{
        $this->config = \XCAmazonFeedsConfig::getInstance()->getConfigAsObject();
    } // }}}

    /**
     * Submit generated XML to Amazon WMS
     *
     * @return boolean
     */
    public function submitFeed($files)
    { // {{{
        global $sql_tbl;

        $feedResult = false;
        if (is_array($files) && count($files) > 0) {
            ob_start();

            foreach ($files as $filename => $realpath) {
                $fileHandler = fopen($realpath, 'r');

                if (!$fileHandler) {
                    func_amazon_feeds_debug_log("Failed to open Feed file: $realpath");
                    continue;
                }

                $export = array (
                    'filename' => $filename,
                    'submit_date' => XC_TIME,
                    'status' => \XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_STATUS_UNCONFIRMED,
                    'status_date' => XC_TIME,
                    'response' => '',
                );

                $id = func_array2insert($sql_tbl['amazon_feeds'], $export);

                $feedType = func_amazon_feeds_get_type_from_filename($filename);

                if ($id) {

                    $response = \XCAmazonFeedsFeedsAPI::getInstance()->submitFeed(
                        $fileHandler,
                        \XCart\Modules\AmazonFeeds\Feeds\Feed::$messageFeed[$feedType]
                    );

                    if (
                        $response->isSetSubmitFeedResult()
                        && ($feedResult = $response->getSubmitFeedResult())
                        && $feedResult->isSetFeedSubmissionInfo()
                        && ($submissionInfo = $feedResult->getFeedSubmissionInfo())
                        && $submissionInfo->isSetFeedSubmissionId()
                    ) {

                        func_amazon_feeds_set_processing_feed($feedType);

                        func_array2update(
                            'amazon_feeds',
                            array(
                                'feedid' => $submissionInfo->getFeedSubmissionId(),
                                'response' => $response->toXML()
                            ),
                            "id = '$id'"
                        );

                    } else {

                        func_amazon_feeds_debug_log("Submit Feed failed: $filename, ". var_export($response, true));
                    }

                } else {

                    func_amazon_feeds_debug_log("Failed to save Feed data in DB: $export");
                }
            }

            $feedResult = true;

            $buffer = ob_get_contents();
            ob_end_clean();

            func_amazon_feeds_debug_log($buffer);
        }

        return $feedResult;
    } // }}}

    /**
     * Check Amazon WMS for results
     *
     * @return boolean
     */
    public function checkStatus($processor)
    { // {{{
        global $sql_tbl;

        $status_done = \XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_STATUS_DONE;

        $done_condition = "WHERE status = '$status_done'";
        $not_done_condition = "WHERE status <> '$status_done'";

        $feeds = func_query_first_cell(
            "SELECT count(*)"
            . " FROM $sql_tbl[amazon_feeds] $not_done_condition");

        $checkResult = false;
        if ($feeds > 0) {
            ob_start();

            $start_date = func_query_first_cell(
                "SELECT min(submit_date)"
                . " FROM $sql_tbl[amazon_feeds] $not_done_condition");

            $startDateTime = new \DateTime();
            $startDateTime->setTimestamp($start_date);

            $response = \XCAmazonFeedsFeedsAPI::getInstance()->getFeedSubmissionList(null, null, null, null, $startDateTime);

            if (
                $response->isSetGetFeedSubmissionListResult()
                && ($submissionResult = $response->getGetFeedSubmissionListResult())
                && $submissionResult->isSetFeedSubmissionInfo()
                && ($submissionInfoList = $submissionResult->getFeedSubmissionInfoList())
                && !empty($submissionInfoList)
            ) {
                foreach ($submissionInfoList as $submissionInfo) {

                    if (
                        !$submissionInfo->isSetFeedSubmissionId()
                        || !$submissionInfo->isSetFeedProcessingStatus()
                    ) {
                        continue;
                    }

                    $status_date = XC_TIME;

                    if ($submissionInfo->isSetCompletedProcessingDate()) {
                        $status_date = $submissionInfo->getCompletedProcessingDate()->getTimestamp();
                    }

                    db_query(
                        "UPDATE $sql_tbl[amazon_feeds]"
                        . " SET status = '{$submissionInfo->getFeedProcessingStatus()}',"
                            . " status_date = '{$status_date}'"
                        . " WHERE feedid = '{$submissionInfo->getFeedSubmissionId()}'"
                    );
                }
            }

            $feeds = func_query(
                "SELECT * "
                . " FROM $sql_tbl[amazon_feeds] $done_condition");

            if (!empty($feeds)) {

                foreach ($feeds as $feed) {

                    $filename = $processor->getImportDir() . XC_DS . $feed['filename'] . \XCAmazonFeedsDefs::RESULTS_FILE_SUFFIX;

                    if (
                        file_exists($filename) && filesize($filename) > 0
                    ) {
                        continue;
                    }

                    $fileHandler = fopen($filename, 'w+');

                    $response = \XCAmazonFeedsFeedsAPI::getInstance()->getFeedSubmissionResult($feed['feedid'], $fileHandler);

                    $checkResult = true;
                }
            }

            $buffer = ob_get_contents();
            ob_end_clean();

            func_amazon_feeds_debug_log($buffer);
        }

        return $checkResult;
    } // }}}

} // }}}
