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
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v4 (xcart_4_7_7), 2017-01-24 09:29:34, Feed.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

namespace XCart\Modules\AmazonFeeds\Feeds\Import;

/**
 * @see 
 */
abstract class Feed extends \XCart\Modules\AmazonFeeds\Feeds\Feed { // {{{

    protected $_step_name = self::STEP_NAME_IMPORT;

    protected function rewindToLine($lineNumber)
    {
        $count = 0;

        $continue = true;
        while ($continue && $count < $lineNumber) {

            if (
                $this->_xmlReader->name === $this->_feedname
                && $this->_xmlReader->nodeType === \XMLReader::ELEMENT
            ) {
                $count++;
            }

            $continue = $this->_xmlReader->read();
        }

        return $count;
    }

    public function load($filename)
    { // {{{
        $this->_filename = pathinfo($filename, PATHINFO_BASENAME);

        $this->_filePointer = $this->_xmlReader->open($this->getRealPath());

        if (!$this->_filePointer) {
            func_amazon_feeds_debug_log(func_get_langvar_by_name('err_amazon_feeds_cannot_open_import_file', array('file' => $this->getRealPath())));
            return false;
        }

        if ($this->_state == self::FILE_STATUS_NEW) {
            $this->_count = $this->getLinesCount($this->getRealPath());
            $this->_pid = $this->getPid();
        }

        if (
            $this->_position < $this->_count
            && $this->_position > 0
        ) {
            $this->rewindToLine($this->_position);
        }

        $loop_guard = 0;
        while (
            $this->_position < $this->_count
            && $loop_guard < $this->_count
        ) {

            if ($this->_position == 0) {
                $this->_state = self::FILE_STATUS_WORKING;
                $this->readImportHeader();
            }

            for (
                $count = 1;
                $count <= $this->_step
                    && $this->_position < $this->_count;
                $count++
            ) {
                $this->readImportLine();
                $this->_position++;
            }
            $loop_guard += max(1, $count);

            if ($this->_step_time === 0) {
                $this->_step_time = time() - $this->_start_time;
            }

            $this->setCacheClassState();

            $this->_step_progress = ($this->_position / $this->_count) * 100;

            func_flush('.');
        }

        $this->_xmlReader->close();

        if ($this->_position == $this->_count) {
            $this->_state = self::FILE_STATUS_FINISHED;
            $this->setCacheClassState();

            if (method_exists($this, 'onFinished')) {
                $this->onFinished();
            }
        }
    } // }}}

    /**
     * Read HEADER from file
     *
     * @return mixed
     */
    protected function readImportHeader()
    { // {{{
        $result = false;

        $continue = true;
        while ($continue) {

            if (
                $this->_xmlReader->name === $this->_feedname
                && $this->_xmlReader->nodeType === \XMLReader::ELEMENT
            ) {
                $result = true;
                break;
            }

            $continue = $this->_xmlReader->read();
        }

        return $result;
    } // }}}

    /**
     * Read import LINE from file
     *
     * @return mixed
     */
    protected function readImportLine()
    { // {{{
        $result = false;

        if (
            $this->_xmlReader->name === $this->_feedname
            && $this->_xmlReader->nodeType === \XMLReader::ELEMENT
        ) {
            $xml = $this->_xmlReader->expandSimpleXml();

            // Empty record
            $record = array();

            $accepted = true;

            // Process columns
            foreach ($this->_columns as $column => $info) {
                $method_name = "set{$column}ColumnValue";

                if (method_exists($this, $method_name)) {
                    if (false === ($accepted = $this->{$method_name}($record, $xml, $column, $info))) {
                        break;
                    }
                }
            }

            // Process dataset
            if ($accepted && !empty($record)) {
                $record['feed_type'] = func_amazon_feeds_get_type_from_filename($this->_filename);
                $result = func_array2insert(
                    $this->_dataset[self::DATA_SOURCE],
                    $record, true
                );
            }
        }

        $this->_xmlReader->next($this->_feedname);

        return $result;
    } // }}}

} // }}}
