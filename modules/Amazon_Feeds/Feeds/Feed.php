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
 * @version    8ec104f1ea845efda49851d4cc2f66268706f62e, v5 (xcart_4_7_8), 2017-03-30 14:07:23, Feed.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

namespace XCart\Modules\AmazonFeeds\Feeds;

/**
 * @see 
 */
abstract class Feed { // {{{

    // <editor-fold defaultstate="collapsed" desc="Constants">
    const
        /**
         * Feed types
         *
         * @see http://docs.developer.amazonservices.com/en_US/feeds/Feeds_FeedType.html
         */
        FEED_TYPE_PRODUCT       = '_POST_PRODUCT_DATA_',
        FEED_TYPE_INVENTORY     = '_POST_INVENTORY_AVAILABILITY_DATA_',
        FEED_TYPE_PRICING       = '_POST_PRODUCT_PRICING_DATA_',
        FEED_TYPE_IMAGE         = '_POST_PRODUCT_IMAGE_DATA_',
        FEED_TYPE_RELATIONSHIP  = '_POST_PRODUCT_RELATIONSHIP_DATA_',

        FEED_SUBMIT_RESULT  = 'Result',

        /**
         *  The request is being processed, but is waiting for external information before it can complete.
         *
         *  @see http://docs.developer.amazonservices.com/en_US/feeds/Feeds_FeedProcessingStatus.html
         */
        FEED_STATUS_AWAITING_ASYNCHRONOUS_REPLY = '_AWAITING_ASYNCHRONOUS_REPLY_',
        /**
         *  The request has been aborted due to a fatal error.
         */
        FEED_STATUS_CANCELLED = '_CANCELLED_',
        /**
         *  The request has been processed. You can call the GetFeedSubmissionResult operation to receive a processing report that describes which records in the feed were successful and which records generated errors.
         */
        FEED_STATUS_DONE = '_DONE_',
        /**
         *  The request is being processed.
         */
        FEED_STATUS_IN_PROGRESS = '_IN_PROGRESS_',
        /**
         *  The request is being processed, but the system has determined that there is a potential error with the feed (for example, the request will remove all inventory from a seller's account.) An Amazon seller support associate will contact the seller to confirm whether the feed should be processed.
         */
        FEED_STATUS_IN_SAFETY_NET = '_IN_SAFETY_NET_',
        /**
         *  The request has been received, but has not yet started processing.
         */
        FEED_STATUS_SUBMITTED = '_SUBMITTED_',
        /**
         *  The request is pending.
         */
        FEED_STATUS_UNCONFIRMED = '_UNCONFIRMED_',

        MESSAGE_TYPE_PRODUCT       = 'Product',
        MESSAGE_TYPE_INVENTORY     = 'Inventory',
        MESSAGE_TYPE_PRICING       = 'Price',
        MESSAGE_TYPE_IMAGE         = 'Image',
        MESSAGE_TYPE_RELATIONSHIP  = 'Relationship',

        AMAZON_FEEDS_OPERATION_UPDATE = 'Update',
        AMAZON_FEEDS_OPERATION_PARTIAL_UPDATE = 'PartialUpdate', // for products feed only
        AMAZON_FEEDS_OPERATION_RESULT = 'Result',
        AMAZON_FEEDS_OPERATION_DELETE = 'Delete',

        FEED_RESULTS_PENDING = 0,
        FEED_RESULTS_PROCESSED = 1,

        DATASET_STATUS_PENDING = 0,
        DATASET_STATUS_EXPORTED = 1,
        DATASET_STATUS_ACCEPTED = 2,

        DATA_SOURCE = 'Source',
        DATA_FILTER = 'Filter',

        FILE_STATUS_NEW = 'New',
        FILE_STATUS_WORKING = 'Working',
        FILE_STATUS_FINISHED = 'Finished',

        STEP_NAME_EXPORT = 'Export',
        STEP_NAME_IMPORT = 'Import',
        STEP_NAME_FINALIZE = 'Finalize',

        RECORDS_PER_STEP = 10;
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Variables">
    protected $_config;
    /**
     * @var \XCAmazonFeedsExportImportProcessor
     */
    protected $_processor;

    protected $_feedname;
    protected $_operation;
    protected $_columns;

    protected $_filename;
    protected $_filepath;
    protected $_filePointer;

    protected $_state = self::FILE_STATUS_NEW;

    protected $_count = 0;
    protected $_position = 0;
    protected $_step = self::RECORDS_PER_STEP;

    protected $_start_time = XC_TIME;
    protected $_step_time = 0;

    protected $_pid;

    protected $_step_name = self::STEP_NAME_EXPORT;
    protected $_step_feed;
    protected $_step_progress = 0;

    protected $_dataset = array (
        self::DATA_SOURCE => false,
        self::DATA_FILTER => false
    );

    protected $_fieldset = '*';

    // <editor-fold defaultstate="collapsed" desc="$messageFeed">
    public static $messageFeed = array (
        \XCart\Modules\AmazonFeeds\Feeds\Feed::MESSAGE_TYPE_IMAGE
            => \XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_IMAGE,
        \XCart\Modules\AmazonFeeds\Feeds\Feed::MESSAGE_TYPE_INVENTORY
            => \XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_INVENTORY,
        \XCart\Modules\AmazonFeeds\Feeds\Feed::MESSAGE_TYPE_PRICING
            => \XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_PRICING,
        \XCart\Modules\AmazonFeeds\Feeds\Feed::MESSAGE_TYPE_PRODUCT
            => \XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_PRODUCT,
        \XCart\Modules\AmazonFeeds\Feeds\Feed::MESSAGE_TYPE_RELATIONSHIP
            => \XCart\Modules\AmazonFeeds\Feeds\Feed::FEED_TYPE_RELATIONSHIP,
    );
    // </editor-fold>

    protected $_xmlWriter;
    protected $_xmlReader;

    // </editor-fold>

    public function __construct(\XCAmazonFeedsExportImportProcessor $processor)
    { // {{{
        $this->_processor   = $processor;
        $this->_config      = $processor->getConfig();

        $this->_filepath    = $processor->getWorkingDir();

        $this->_feedname    = $this->defineFeedName();
        $this->_operation   = $this->defineOperation();
        $this->_columns     = $this->defineColumns();

        $this->_step_feed   = $this->_feedname;

        $this->_dataset     = $this->defineDataset();
        $this->_fieldset    = $this->defineFieldset();

        // Register cache function
        func_register_cache_function(
            'getAmazonFeedsFileCacheClassState',
            array(
                'class' => get_class($this),
                'force_restore' => true // to force cache dir creation via ajax
            )
        );

        // Get cache data
        $this->getAmazonFeedsFileCacheClassState();

        // Create XML writer
        $this->_xmlWriter = new \XMLWriter();
        // Create XML reader
        $this->_xmlReader = new \XCXMLReader();
    } // }}}

    public function save()
    { // {{{
        func_amazon_feeds_set_processing_feed($this->_step_feed);

        $this->_filePointer = fopen($this->getRealPath(), 'a');

        $this->_xmlWriter->openMemory();

        $this->_xmlWriter->setIndent(true);

        if (!$this->_filePointer) {
            func_amazon_feeds_debug_log(func_get_langvar_by_name('err_amazon_feeds_cannot_open_export_file', array('file' => $this->getRealPath())));
            return false;
        }

        if ($this->_state == self::FILE_STATUS_NEW) {
            $this->_count = $this->getRecordsCount();
            $this->_pid = $this->getPid();
        }

        $loop_guard = 0;
        while (
            $this->_position < $this->_count
            && $loop_guard < $this->_count
        ) {

            if ($this->_position == 0) {
                $this->_state = self::FILE_STATUS_WORKING;
                $this->wrightExportHeader();
            }

            $records = $this->getRecords();

            if (!empty($records)) {
                foreach ($records as $record) {
                    $this->wrightExportLine($record);
                    $this->_position++;
                }
            }
            $loop_guard += max(1, count($records));

            if ($this->_step_time === 0) {
                $this->_step_time = time() - $this->_start_time;
            }

            $this->setCacheClassState();

            $this->_step_progress = ($this->_position / $this->_count) * 100;

            func_flush('.');
        }

        if ($this->_position == $this->_count) {
            $this->wrightExportFooter();

            $this->_state = self::FILE_STATUS_FINISHED;
            $this->setCacheClassState();

            if (method_exists($this, 'onFinished')) {
                $this->onFinished();
            }
        }

        fclose($this->_filePointer);

    } // }}}

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    { // {{{

        if (empty($this->_filename)) {
            $parts = array(
                'Merchant_ID'       => $this->_config->{\XCAmazonFeedsDefs::CONFIG_VAR_MERCHANT_ID},
                'Data_Feed_Name'    => $this->_feedname,
                'Operation'         => $this->_operation,
                'Marketplace'       => $this->_config->{\XCAmazonFeedsDefs::CONFIG_VAR_MARKETPLACE_CODE},
                'UTC_Date_Time'     => date('Ymd_His')
            );
            $this->_filename = implode('_', $parts) . '.xml';
        }

        return $this->_filename;
    } // }}}

    public function getRealPath()
    { // {{{
        return $this->_filepath . XC_DS . $this->getFilename();
    } // }}}

    protected function getLinesCount($filepath)
    { // {{{
        $count = 0;

        $xmlReader = new \XMLReader();
        if ($xmlReader->open($filepath)) {
            $continue = true;

            while ($continue) {

                if (
                    $xmlReader->name === $this->_feedname
                    && $xmlReader->nodeType === \XMLReader::ELEMENT
                ) {
                    $count++;
                }

                $continue = $xmlReader->read();
            }

            $xmlReader->close();
        }

        return $count;
    } // }}}

    public function isWorking()
    { // {{{
        return $this->_state == self::FILE_STATUS_WORKING
                && (function_exists('posix_getpgid') ? posix_getpgid($this->_pid) : true);
    } // }}}

    public function isFinished()
    { // {{{
        return $this->_state == self::FILE_STATUS_FINISHED;
    } // }}}

    public function isEmpty()
    { // {{{
        return !file_exists($this->getRealPath()) || filesize($this->getRealPath()) == 0;
    } // }}}

    protected function getPid()
    { // {{{
        return function_exists('posix_getpid') ? posix_getpid() : null;
    } // }}}

    protected function getCacheKey()
    { // {{{
        return get_class($this);
    } // }}}

    /**
     * Get cache class state
     */
    protected function getAmazonFeedsFileCacheClassState()
    { // {{{
        $cacheKey = $this->getCacheKey();

        if (($cacheData = func_get_cache_func($cacheKey, 'getAmazonFeedsFileCacheClassState'))) {
            if ($this->_state == self::FILE_STATUS_WORKING) {
                // restore object properties
                foreach ($cacheData['data'] as $property => $value) {
                    $this->$property = $value;
                }
            }
            return;
        }

        $this->setCacheClassState();
    } // }}}

    protected function setCacheClassState()
    { // {{{
        $cacheKey = $this->getCacheKey();

        $classState = array (
            '_filename'         => $this->_filename,
            '_filepath'         => $this->_filepath,
            '_count'            => $this->_count,
            '_position'         => $this->_position,
            '_step'             => $this->_step,
            '_state'            => $this->_state,
            '_start_time'       => $this->_start_time,
            '_step_time'        => $this->_step_time,
            '_pid'              => $this->_pid,
            '_step_name'        => $this->_step_name,
            '_step_feed'        => $this->_step_feed,
            '_step_progress'    => $this->_step_progress,
        );

        func_save_cache_func($classState, $cacheKey, 'getAmazonFeedsFileCacheClassState');
    } // }}}

    /**
     * Define feed name
     *
     * @return string
     */
    abstract protected function defineFeedName();

    /**
     * Define operation
     *
     * @return string
     */
    abstract protected function defineOperation();

    /**
     * Define columns
     *
     * @return array
     *
     * @see https://wiki.ecommerce.pb.com/display/TECH4/Catalog+Specifications
     */
    abstract protected function defineColumns();

    /**
     * Define dataset
     *
     * @return string
     */
    abstract protected function defineDataset();

    /**
     * Define fieldset
     *
     * @return string
     */
    protected function defineFieldset()
    { // {{{
        return '*';
    } // }}}

    /**
     * Get from SQL query
     *
     * @return string
     */
    protected function getFromQuery()
    { // {{{
        $query = false;

        if (!empty($this->_dataset[self::DATA_SOURCE])) {
            $query = ' FROM ' . $this->_dataset[self::DATA_SOURCE];
        }

        if (!empty($this->_dataset[self::DATA_FILTER])) {
            $query .= ' WHERE ' . $this->_dataset[self::DATA_FILTER];
        }

        return $query;
    } // }}}

    /**
     * Get records from dataset
     *
     * @return integer
     */
    protected function getRecords()
    { // {{{
        $result = array();

        if (($fromQuery = $this->getFromQuery())) {

            $SQL = "SELECT {$this->_fieldset} {$fromQuery} LIMIT {$this->_position}, {$this->_step}";

            $result = func_query($SQL);
        }

        return $result;
    } // }}}

    /**
     * Get records count in dataset
     *
     * @return integer
     */
    protected function getRecordsCount()
    { // {{{
        $result = 0;

        if (($fromQuery = $this->getFromQuery())) {

            $SQL = "SELECT COUNT(*) {$fromQuery}";

            $result = func_query_first_cell($SQL);
        }

        return $result;
    } // }}}

    protected function writeColumnValue(array $dataset, $colname, $result)
    { // {{{
        if (is_null($result) || $result === false) { return; }

        if (!is_array($result)) {
            $this->_xmlWriter->writeElement($colname, (string) $result);
        } else {
            $this->_xmlWriter->startElement($colname);

            foreach ($result as $column => $info) {
                $method_name = "get{$colname}{$column}ColumnValue";

                if (method_exists($this, $method_name)) {
                    $method_result = $this->{$method_name}($dataset, $column, $info);
                } else {
                    $method_result = null;
                }

                $this->writeColumnValue($dataset, $column, $method_result);
            }

            $this->_xmlWriter->endElement();
        }
    } // }}}

    /**
     * Wright export HEADER to file
     *
     * @return boolean
     */
    protected function wrightExportHeader()
    { // {{{
        $result = false;

        $columns = array_keys($this->_columns);
        if (!empty($columns)) {
            $this->_xmlWriter->startDocument('1.0', $this->_config->{\XCAmazonFeedsDefs::CONFIG_VAR_ENCODING});
                $this->_xmlWriter->startElement('AmazonEnvelope');
                    $this->_xmlWriter->writeAttributeNs('xsi', 'noNamespaceSchemaLocation', 'http://www.w3.org/2001/XMLSchema-instance', 'amzn-envelope.xsd');
                    $this->_xmlWriter->startElement('Header');
                        $this->_xmlWriter->writeElement('DocumentVersion', '1.01');
                        $this->_xmlWriter->writeElement('MerchantIdentifier', $this->_config->{\XCAmazonFeedsDefs::CONFIG_VAR_MERCHANT_ID});
                    $this->_xmlWriter->endElement();
                    $this->_xmlWriter->writeElement('MessageType', $this->_feedname);

            $result = fwrite($this->_filePointer, $this->_xmlWriter->flush(true)) !== false;
        }

        return $result;
    } // }}}

    /**
     * Wright export LINE to file
     *
     * @return boolean
     */
    protected function wrightExportLine(array $dataset)
    { // {{{
        $result = false;

        if (!empty($this->_columns)) {
            $this->_xmlWriter->startElement('Message');
                // Should start from 1, position starts from 0
                $this->_xmlWriter->writeElement('MessageID', $this->_position + 1);
                $this->_xmlWriter->writeElement('OperationType', $this->_operation);
                // Start XML
                $this->_xmlWriter->startElement($this->_feedname); // {{{
                // Process columns
                foreach ($this->_columns as $column => $info) {
                    $method_name = "get{$column}ColumnValue";

                    if (method_exists($this, $method_name)) {
                        $method_result = $this->{$method_name}($dataset, $column, $info);
                    } else {
                        $method_result = null;
                    }

                    $this->writeColumnValue($dataset, $column, $method_result);
                }
                // End XML
                $this->_xmlWriter->endElement(); // }}}
            $this->_xmlWriter->endElement(); // Message
            // Save XML to file
            $result = fwrite($this->_filePointer, $this->_xmlWriter->flush(true)) !== false;
        }

        return $result;
    } // }}}

    /**
     * Wright export FOOTER to file
     *
     * @return boolean
     */
    protected function wrightExportFooter()
    { // {{{
        $result = false;

        $columns = array_keys($this->_columns);
        if (!empty($columns)) {
                $this->_xmlWriter->endElement(); // AmazonEnvelope
            $this->_xmlWriter->endDocument();

            $result = fwrite($this->_filePointer, $this->_xmlWriter->flush(true)) !== false;
        }

        return $result;
    } // }}}

    protected function encode_xml_string($str)
    { // {{{
        return mb_convert_encoding($str, $this->_config->{\XCAmazonFeedsDefs::CONFIG_VAR_ENCODING});
    } // }}}

} // }}}
