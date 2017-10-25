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
 * X-Cart test functions
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    1c9e00344b62e98f150b1059e8f13d7576f1e11f, v137 (xcart_4_7_8), 2017-05-22 15:43:41, func.dev.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../"); die("Access denied"); }

function func_dev_generate_test_data($func, $params = array(), $remove_test_file = FALSE) { // {{{
    global $xcart_dir;

    if (empty($params)) {
        $params = array (
            array(),
        );
    }
    $test_filename = $xcart_dir . "/tests/functest.$func";

    if ($remove_test_file)
        @unlink($test_filename);

    if (is_readable($test_filename)) {
        require_once $test_filename;
        $is_new_file = false;
    } else {
        `touch $test_filename`;
        $is_new_file = true;
    }

    $func = preg_replace("/\..*/s", '', $func);

    if (!empty($INIT_PHP_CODE)) eval($INIT_PHP_CODE);
    if (!empty($FILE)) require_once $xcart_dir.'/'.$FILE;

    $start = func_microtime();

    $out = "\$TESTS = array (\n";
    foreach ($params as $k_sub => $param) {
        if (!is_array($param))
            $param = array($param);
        $out.="\tarray (\n";
        $out .= "\t\t'INPUT' => " . var_export($param, true) . ",\n";
        $res = print_r(call_user_func_array($func, $param), true);
        $res = str_replace('$','\$', $res);
        $res = str_replace('"','\"', $res);
        $out.="\t\t'EXPECT' => \"$res\"\n";
        $out.="\t),\n";
    }

    print_r("<br />\n Time elapsed:" . (func_microtime() - $start) . "<br />\n");

    if (!empty($FINISH_PHP_CODE)) eval($FINISH_PHP_CODE);

    $out.=');';

    if ($is_new_file) {
        file_put_contents($test_filename, "<?php /* vim: set ts=4 sw=4 sts=4 filetype=php et: */\n" . $out . "\n");
        p($test_filename);
    }

    @unlink($xcart_dir . '/output'); pf($out); p($out);die;
} // }}}

/**
 * Calculate md5 without $ Id $ value
 */
function func_dev_md5_file($filename, $before_grep='') { // {{{
    global $file_temp_dir;

    $content = file_get_contents($filename);
    if (empty($content)) {
        return 'empty file: '  . $filename;
    }

    // Apply before_grep to filename and store result in a new tmpfile_last
    if (!empty($before_grep)) {
        exec('which grep', $out);
        $bin_grep = $out[0];
        $tmpfile = func_temp_store($content);
        $tmpfile_last = tempnam($file_temp_dir, 'xctmp_test');
        exec($bin_grep . " $before_grep $tmpfile > $tmpfile_last", $tpl_calls);
        $content = file_get_contents($tmpfile_last);
    }
    $content = preg_replace('/[a-z0-9]{40}, v[0-9]+ \(.*' . basename($filename) . ', [^ ]+$/Sm', '$' . 'Id'. '$', $content);
    return md5($content);
} // }}}

function func_dev_minify_array($arr) { // {{{
    $test_clear_val_func = create_function('$b', 'return 1;');
    sort($arr);
    $arr = array_unique($arr);
    $arr = array_flip($arr);
    $arr = array_map($test_clear_val_func, $arr);
    return $arr;
} // }}}

/**
 * Function to test changes in https://sd.x-cart.com/view.php?id=145401 in Func_generate_sku func.The res must be PASSED on any DB
 */
function func_dev_test_sql_query() { // {{{
    global $sql_tbl;

    $max_len = func_query_first_cell("SELECT MAX(LENGTH(productcode)) FROM $sql_tbl[products]") + 1;
    for ($x = 1; $x <= $max_len; $x++) {
        $productcodes = func_query_column("SELECT DISTINCT SUBSTRING(productcode, 1, $x) FROM $sql_tbl[products]");
        foreach ($productcodes as $prefix) {
            $len = strlen($prefix);
            $old = func_query_column("SELECT productcode FROM $sql_tbl[products] WHERE SUBSTRING(productcode, 1, $len) = '".addslashes($prefix)."'");
            $new = func_query_column("SELECT productcode FROM $sql_tbl[products] WHERE productcode LIKE '" . addslashes(str_replace(array('_', '%'), array('\_', '\%'), $prefix)) . "%'");
            if ($old !== $new || array_diff($old, $new)) {
                return array($old, $new);
            }
        }
    }
    return 'PASSED';
} // }}}

function func_has_caller_function($func_name) { // {{{
    $traces = debug_backtrace();

    for ($x = 3; $x < count($traces); $x++) {
        if (
            isset($traces[$x]['function'])
            && $traces[$x]['function'] == $func_name
        ) {
            return true;
        }
    }

    return false;
} // }}}

/*
 Update related function on change [func_get_xcart_paid_modules..]
*/
function test_check_update_for_rss_xcart_paid_modules() { // {{{
    global $config;

    $url = parse_url($config['rss_xcart_paid_modules']);

    x_load('http','xml');
    list($header, $result) = func_http_get_request($url['host'], $url['path'], @$url['query']);
    $parse_error = false;
    $options = array(
        'XML_OPTION_CASE_FOLDING' => 1,
        'XML_OPTION_TARGET_ENCODING' => 'UTF-8'
    );

    $parsed = func_xml_parse($result, $parse_error, $options);

    $result = preg_match_all('%.*(<service_name>.*?</service_name>).*%', $result, $matches);
    $matches[1][] = 'number_of_all_items in rss_xcart_paid_modules feed:' . count(func_array_path($parsed, 'MODULES/#/ITEM', TRUE));

    return func_dev_minify_array($matches[1]);

} // }}}

/*
 Check if amazon feeds should be updated
    https://xcn.myjetbrains.com/youtrack/issue/XC4-148124#comment=73-33122
    Update amazon categories on change
    https://sellercentral.amazon.com/gp/help/1611/ref=id_1611_cont_200386810
    https://sellercentral.amazon.com/gp/help/200385010
*/
function test_check_update_amazon_feeds() { // {{{
    global $config, $xcart_dir;
    include $xcart_dir . '/modules/Amazon_Feeds/tests/test_check_update_amazon_feeds.php';
    return module_test_check_update_amazon_feeds(func_get_args());
} // }}}

/**
 * 0 empty value is not applicable for selector/multiselector xcart_config when string variant is used
 * https://sd.x-cart.com/view.php?id=136255#700164
 */
function test_check_zero_config_values() { // {{{
    global $sql_tbl;

    $selectors = func_query("SELECT * FROM $sql_tbl[config] WHERE type LIKE '%selector%'");
    $res = array();

    foreach($selectors as $k=>$v) {
        $variants = func_parse_str(trim($v['variants']), "\n", ":");
        foreach($variants as $val => $label) {
            // if has valid empty value
            if (empty($val)) {
                foreach($variants as $val_cast => $label) {
                    // if has another casted to empty value
                    if (
                        $val_cast == $val
                        && $val_cast !== $val
                    ) {
                        $selectors[$k]['variants'] = $variants;
                        $res[] = $selectors[$k];
                    }
                }
            }
        }
    }

    return $res;
} // }}}


function test_clear_val($var) { // {{{
    return 1;
} // }}}

function test_db_backup_is_field_num() { // {{{
    global $sql_tbl, $sql_obj, $xcart_dir, $login;
    $db_only_functions = true;
    require_once $xcart_dir . DIR_ADMIN . '/db_backup.php'; // For db_backup_is_field_num

    $res = array();
    if ($_tables = db_query('SHOW TABLES')) {
        while ($_table = db_fetch_row($_tables)) {
            $table = $_table[0];

            $local_query = "SELECT * FROM $table LIMIT 0";
            $real_columns = func_query_hash("SHOW COLUMNS FROM $table", 'Field', false);
            $result = db_query($local_query);
            if ($result != FALSE) {
                $fields_cnt = $sql_obj->num_fields($result);

                // Checks whether the field is an integer or not
                for ($j = 0; $j < $fields_cnt; $j++) {
                    $name = $sql_obj->field_name($result, $j);
                    $type = $sql_obj->field_type($result, $j);
                    $field_num[$j] = db_backup_is_field_num($type);
                    if ($field_num[$j]) {
                        $res[$table][$name . ' '. $real_columns[$name]['Type']] = (!empty($field_num[$j]) ? 'quote is skipped in db_backup.php': '');
                    }
                }
            }
            db_free_result($result);

        }
        db_free_result($_tables);
    }

    return $res;

} // }}}

/*
* isEvalTemplate should discover {eval} tag
* https://sd.x-cart.com/view.php?id=144880#753997
*/
function test_smarty_eval($source='', $smarty_tpl=null) { // {{{
    global $smarty;

    if (empty($smarty_tpl)) {
        // usual call
        $page_content = 'About our site {$smarty.now} This is just a simple text using "quotes"';

        $tpl = $smarty->createTemplate('string:{eval var=$page_content}');
        $tpl->assign('page_content', $page_content);
        $tpl->registerFilter('output', 'test_smarty_eval');
        $res = $tpl->fetch();
        return $res;
    } else {
        // act as smarty filter
        // wait for fix https://github.com/smarty-php/smarty/issues/59 to use a closure
        if ($smarty_tpl->smarty->isEvalTemplate($smarty_tpl->template_resource)) {
            // call the filter only for evailed template, not for skin/common_files/customer/main/pages.tpl
            $smarty_tpl->unregisterFilter('output', 'test_smarty_eval');
            return 'Test is passed.';
        } else {
            return 'Test is failed. Fix strpos in isEvalTemplate() method related to "eval:" string https://sd.x-cart.com/view.php?id=144880#753997';
        }
    }
} // }}}

/*
* {php}/{include_php} tags should be disabled
* https://sd.x-cart.com/view.php?id=145357#756907
*/
function test_smarty_php_tag($source='', $smarty_tpl=null) { // {{{
    global $smarty;
    $res = '';

    try {
        $tpl = $smarty->createTemplate('string:{php}echo "Run php code from tpl";{/php} {*The expected result is syntax error*}');
        $res = $tpl->fetch();
    } catch (Exception $e) {
        $txt_err = $e->getMessage();
        $txt_err = preg_replace('/Syntax error in template.*on line 1/s', 'Syntax error in template on line 1', $txt_err);
        $res .= "\n" . $txt_err;
    }

    try {
        $tpl = $smarty->createTemplate('string:{include_php file="check_requirements.php"} {*The expected result is syntax error*}');
        $res = $res . "\n" . ($tpl->fetch());
    } catch (Exception $e) {
        $txt_err = $e->getMessage();
        $txt_err = preg_replace('/Syntax error in template.*on line 1/s', 'Syntax error in template on line 1', $txt_err);
        $res .= "\n" . $txt_err;
    }

    return $res;
} // }}}

function test_func_check_worldwide_currencies() { // {{{
    global $sql_tbl;

    //$xcart_currencies = func_query_hash("SELECT code,code_int,name FROM $sql_tbl[currencies] ORDER BY code", 'code', FALSE);
    // select * from xcart_country_currencies cc left join xcart_currencies c on cc.code=c.code where c.code IS NULL;
    //$iso_url = parse_url('http://www.currency-iso.org/dam/downloads/lists/list_one.xml');
    $iso_url = ('https://www.currency-iso.org/dam/downloads/lists/list_one.xml');

    x_load('http','xml');
//    list($header, $result) = func_http_get_request($iso_url['host'], $iso_url['path'], @$iso_url['query']);
    $result = file_get_contents($iso_url);

    $parse_error = false;
    $options = array(
        'XML_OPTION_TARGET_ENCODING' => 'UTF-8',
        'XML_OPTION_CASE_FOLDING' => TRUE
    );
    $parsed = func_xml_parse($result, $parse_error, $options);

    //$iso_currencies = func_array_path($parsed, 'ISO_CCY_CODES/#/ISO_CURRENCY');
    $iso_currencies = func_array_path($parsed, 'ISO_4217/#/CCYTBL/0/#/CCYNTRY');
    /*
    Old codes
    $arr_iso_currencies[ func_array_path($v2, '#/ALPHABETIC_CODE/0/#') ] = array (
       'code_int' => func_array_path($v2, '#/NUMERIC_CODE/0/#'),
       'name' => func_array_path($v2, '#/CURRENCY/0/#'),
    */

    $arr_iso_currencies = array();
    $str = '';
    foreach ($iso_currencies as $k2=>$v2) {
        $arr_iso_currencies[ func_array_path($v2, '#/CCY/0/#') ] = array (
           'code_int' => func_array_path($v2, '#/CCYNBR/0/#'),
           'name' => func_array_path($v2, '#/CCYNM/0/#'),
        );


    }
    ksort($arr_iso_currencies);
    foreach ($arr_iso_currencies as $k2=>$v2) {
        if (empty($k2) || $k2 == 'XXX' || $k2 == 'XTS')
            continue;

        $str .= "INSERT INTO xcart_currencies VALUES ('$k2',".intval($v2['code_int']).",'$v2[name]','');\n";
    }

    return $str;

} // }}}

/*
 *    Disable on the demo on error
 *    https://sd.x-cart.com/view.php?id=135952
 *    INSERT INTO xcart_config VALUES ('soc_pin_enabled','\"Pin it\" button','N','Socialize',36,'checkbox','N','','','');
*/
function test_func_check_pinterest_url_availability() { // {{{
    if (func_url_get("http://assets.pinterest.com/pinit.html?url=http%3A%2F%2Fdemo.x-cart.com%2Fdemo_goldplus%2FBinary-Mom.html&media=http%3A%2F%2Fdemo.x-cart.com%2Fdemo_goldplus%2Fimages%2FP%2Fbinary2.jpg&description=Show%20mom%20how%20much%20you%20love%20her%20by%20giving%20her%20a%20little%20bit%20of%20geek.%20Or%2C%20if%20you%27re%20a%20mom%2C%20show%20off%20your%20penchant%20for%20math%20or%20science%21%20Zeros%20and%20ones%20spell%20%22MOM%22%20and%20confuse%20other%20people%2C%20which%20is%20always%20fun.&layout=horizontal", " 200 OK") !== FALSE) {
        return "http://assets.pinterest.com/pinit.html URL IS OK";
    } else {
        return "Disable pinterest on the demo server. INSERT INTO xcart_config VALUES ('soc_pin_enabled'";
    }
} // }}}

function test_func_check_vat_numbers() { // {{{
    global $xcart_dir;

    // http://formvalidation.io/validators/vat/
    $vats = array(//{{{
        'U13585626' =>     'AT',
        'U13585627' =>     'AT',
        '0428759497' =>     'BE',
        '431150351' =>     'BE',
        '175074752' =>     'BG',
        '175074753' =>     'BG',
        '7111042922' =>     'BG',
        '7111042925' =>     'BG',
        '7523169263' =>     'BG',
        '7542011030' =>     'BG',
        '7552A10004' =>     'BG',
        '8032056031' =>     'BG',
        '10259033P' =>     'CY',
        '10259033Z' =>     'CY',
        '1103492745' =>     'CZ',
        '25123890' =>     'CZ',
        '25123891' =>     'CZ',
        '590312123' =>     'CZ',
        '640903926' =>     'CZ',
        '7103192745' =>     'CZ',
        '991231123' =>     'CZ',
        '136695976' =>     'DE',
        '136695978' =>     'DE',
        '13585627' =>     'DK',
        '13585628' =>     'DK',
        '100594102' =>     'EE',
        '100594103' =>     'EE',
        '100931558' =>     'EE',
        '094259216' =>     'EL',
        '123456781' =>     'EL',
        '54362315K' =>     'ES',
        '54362315Z' =>     'ES',
        'B58378431' =>     'ES',
        'B64717838' =>     'ES',
        'J99216582' =>     'ES',
        'J99216583' =>     'ES',
        'M1234567L' =>     'ES',
        'X2482300A' =>     'ES',
        'X2482300W' =>     'ES',
        'X5253868R' =>     'ES',
        '20774740' =>     'FI',
        '20774741' =>     'FI',
        '23334175221' =>     'FR',
        '40303265045' =>     'FR',
        '4Z123456782' =>     'FR',
        '84323140391' =>     'FR',
        'K7399859412' =>     'FR',
        '802311781' =>     'GB',
        '980780684' =>     'GB',
        '023456780' =>     'GR',
        '33392005961' =>     'HR',
        '33392005962' =>     'HR',
        '12892312' =>     'HU',
        '12892313' =>     'HU',
        '6433435F' =>     'IE',
        '6433435OA' =>     'IE',
        '8D79738J' =>     'IE',
        '8D79739I' =>     'IE',
        '12345' =>     'IS',
        '123456' =>     'IS',
        '1234567' =>     'IS',
        '00743110157' =>     'IT',
        '00743110158' =>     'IT',
        '100001919017' =>     'LT',
        '100001919018' =>     'LT',
        '100004801610' =>     'LT',
        '119511515' =>     'LT',
        '15027442' =>     'LU',
        '15027443' =>     'LU',
        '16117519997' =>     'LV',
        '16137519997' =>     'LV',
        '40003521600' =>     'LV',
        '40003521601' =>     'LV',
        '11679112' =>     'MT',
        '11679113' =>     'MT',
        '004495445B01' =>     'NL',
        '123456789B90' =>     'NL',
        '8567346215' =>     'PL',
        '8567346216' =>     'PL',
        '501964842' =>     'PT',
        '501964843' =>     'PT',
        '18547290' =>     'RO',
        '18547291' =>     'RO',
        '123456789101' =>     'SE',
        '123456789701' =>     'SE',
        '50223054' =>     'SI',
        '50223055' =>     'SI',
        '2022749618' =>     'SK',
        '2022749619' =>     'SK',
        'J000126518' =>     'VE',
        'J000458323' =>     'VE',
        'J309272292' =>     'VE',
        'J309272293' =>     'VE',
        'V242818101' =>     'VE',
        '3012345678' =>     'ZA',
        '4012345678' =>     'ZA',
        '40123456789' =>     'ZA',
    );//}}}

    require_once $xcart_dir . '/include/classes/class.VatNumberChecker.php';

    $res = array();
    foreach ($vats as $vat => $country) {
        $res[$country . '|' . $vat] = XCVatNumberChecker::getInstance()->checkVATnumber($country, $vat);
    }
    $res['COUNTRY_IN_VATS'] = '****************************************';
    foreach ($vats as $vat => $country) {
        usleep(500000);//0.5 sec
        $res[$country . $vat] = XCVatNumberChecker::getInstance()->checkVATnumber('GB', $country . $vat);
    }
    return $res;
} // }}}

/*
* Do not decrease methods with Intershipper_code!='' to work intershipper properly
* http://www.intershipper.com/Shipping/Intershipper/XML/v2.0/api/Intershipper%20v2.3.0%20-%20XML%20via%20HTTP%20Interface%20API.pdf
* https://xcn.myjetbrains.com/youtrack/issue/XC4-148273#comment=73-30942
*/
function test_func_check_intershipper_methods() { // {{{
    global $sql_tbl;

    $methods = func_query_hash("SELECT shippingid,code,intershipper_code,shipping,destination FROM $sql_tbl[shipping] WHERE intershipper_code!='' ORDER BY code,intershipper_code,shippingid", 'shippingid', false, false);
    return $methods;
} // }}}

/*
* Do not forget add msg_err_import_log_message_ to sql/xcart_languages.sql
* https://sd.x-cart.com/view.php?id=106826#647045
*/
function test_func_grep_msg_err_import_log_message() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec($bin_grep . " -hro --include='*.php' --exclude='*func.dev.php*' --include='*.tpl' \"msg_err_import_log_message_[^']*\" $xcart_dir", $php_calls);
    $php_calls = func_dev_minify_array($php_calls);

    exec($bin_grep . " -hro --include='*.sql' \"msg_err_import_log_message_[^']*\" $xcart_dir/sql", $sql_labels);
    $sql_labels = func_dev_minify_array($sql_labels);

    return array(array_diff_key($php_calls, $sql_labels), array_diff_key($sql_labels, $php_calls));
} // }}}

/*
* Do not forget rule from
* https://sd.x-cart.com/view.php?id=128243#654208
*/
function test_func_grep_smarty_vars1() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec($bin_grep . " -r --exclude='switcher.tpl' --exclude='*pconf_slot_modify.tpl*' --exclude='*pconf_wizard_modify.tpl*' \"\(smarty.server.[a-zA-Z_0-9-]*\|php_url\.\)\" $xcart_dir/skin/", $tpl_calls);
    $tpl_calls = preg_replace("%^$xcart_dir/%", '', $tpl_calls);
    $tpl_calls = func_dev_minify_array($tpl_calls);

    return $tpl_calls;
} // }}}

/*
* Do not use src param with product_thumbnail.tpl
* https://sd.x-cart.com/view.php?id=129738
*/
function test_func_grep_src_in_product_thumbnail_tpl() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec($bin_grep . " -r --include='*.tpl' 'product_thumbnail.*src' $xcart_dir/skin/", $tpl_calls);
    $tpl_calls = preg_replace("%^$xcart_dir/%", '', $tpl_calls);
    $tpl_calls = func_dev_minify_array($tpl_calls);

    return $tpl_calls;
} // }}}

function test_func_get_category_parents() { // {{{
    global $sql_tbl;

    $ids = func_query_column("SELECT categoryid FROM $sql_tbl[categories]");
    $cats_array = $arr = array();

    foreach ($ids as $v1) {
        $cats_array[] = $v1;
        $arr[implode('|', $cats_array)] = func_get_category_parents($cats_array);
    }

    foreach ($ids as $v2) {
        $arr[$v2] = func_get_category_parents($v2);
    }

    return $arr;
} // }}}

/**
 * Please check 'Core options' tab on admin/configuration.php?option= page
 * https://sd.x-cart.com/view.php?id=126760
 */
function test_func_get_configuration_options() { // {{{

    $test_clear_val_func = create_function('$b', 'return 1;');

    $options = func_get_configuration_options();
    sort($options);
    $options = array_flip($options);
    $options = array_map($test_clear_val_func, $options);

    return $options;
} // }}}

function test_func_get_default_options_markup_list() { // {{{
    global $sql_tbl;
    $_prices = func_query_hash("SELECT p.productid,p.price FROM $sql_tbl[classes] c INNER JOIN $sql_tbl[pricing] p ON c.productid=p.productid WHERE p.quantity=1 AND p.variantid=0 AND p.membershipid=0 GROUP BY c.productid", 'productid', false, true);

    func_backup_table_in_service_table($sql_tbl['class_options']);
    db_query("UPDATE $sql_tbl[class_options] SET avail=''");

    $markups = array();
    $markups[] = func_get_default_options_markup_list($_prices);

    $conditions = array(
        'price_modifier>0',
        'optionid % 2 = 1',
        'price_modifier<=0',
        'optionid % 2 = 1 AND price_modifier>0',
        'optionid % 2 = 1 AND price_modifier<=0',
    );

    $order_by_values = array(
        false, 0, -9999, 9999, 'orderby+1' , 'orderby+10', 'orderby+1'
    );

    $price_modifiers = array(
        false, 0.00, 0.01, -0.01, 1, -1, 2.22, 50.02, 92.09
    );

    $modifier_types = array(
        '$', '%'
    );

    foreach($conditions as $condition) {
        foreach($order_by_values as $order_by_value) {
            foreach($modifier_types as $modifier_type) {
                foreach($price_modifiers as $price_modifier) {
                    $_modifier_type = 'modifier_type="' . $modifier_type . '"';
                    $orderby = $order_by_value === false ? '' : ',orderby=' . $order_by_value;
                    $price_modifier = $price_modifier === false ? '' : ',price_modifier=' . $price_modifier;
                    db_query("UPDATE $sql_tbl[class_options] SET $_modifier_type $orderby $price_modifier WHERE $condition");
                    $markups[] = func_get_default_options_markup_list($_prices);
                    func_restore_table_from_service_table($sql_tbl['class_options'], 'dont_drop_copy');
                }
            }
        }
    }


    db_query("UPDATE $sql_tbl[class_options] SET orderby=-9999 WHERE price_modifier>0");
    $markups[] = func_get_default_options_markup_list($_prices);
    func_restore_table_from_service_table($sql_tbl['class_options'], 'dont_drop_copy');

    db_query("UPDATE $sql_tbl[class_options] SET orderby=0 WHERE price_modifier>0");
    $markups[] = func_get_default_options_markup_list($_prices);
    func_restore_table_from_service_table($sql_tbl['class_options'], 'dont_drop_copy');

    db_query("UPDATE $sql_tbl[class_options] SET orderby=9999 WHERE price_modifier>0");
    $markups[] = func_get_default_options_markup_list($_prices);
    func_restore_table_from_service_table($sql_tbl['class_options'], 'dont_drop_copy');

    db_query("UPDATE $sql_tbl[class_options] SET orderby=orderby+1 WHERE price_modifier>0");
    $markups[] = func_get_default_options_markup_list($_prices);
    func_restore_table_from_service_table($sql_tbl['class_options'], 'dont_drop_copy');

    db_query("UPDATE $sql_tbl[class_options] SET orderby=orderby+10 WHERE price_modifier<=0");
    $markups[] = func_get_default_options_markup_list($_prices);
    func_restore_table_from_service_table($sql_tbl['class_options'], 'dont_drop_copy');

    db_query("UPDATE $sql_tbl[class_options] SET orderby=orderby+10 WHERE optionid % 2 = 1");
    $markups[] = func_get_default_options_markup_list($_prices);
    func_restore_table_from_service_table($sql_tbl['class_options'], 'dont_drop_copy');

    db_query("UPDATE $sql_tbl[class_options] SET orderby=orderby=9999 WHERE optionid % 2 = 1 AND price_modifier>0");
    $markups[] = func_get_default_options_markup_list($_prices);
    func_restore_table_from_service_table($sql_tbl['class_options'], 'dont_drop_copy');

    func_restore_table_from_service_table($sql_tbl['class_options']);

    foreach ($markups as $k=>$markup) {
        ksort($markup);
        $markups[$k] = $markup;
    }
    return $markups;
} // }}}

/**
 * Function to test func_get_builtin_modules function bt#0116777
 */
function test_func_get_builtin_modules() { // {{{
    global $sql_tbl;

    $current = func_query_hash("SELECT module_name, active FROM $sql_tbl[modules] WHERE module_name NOT IN ('Demo','Dev_Mode','Demo_Mode','Simple_Mode') ORDER BY module_name",'module_name', false, true);

    return $current;
} // }}}

/**
 * Function to test func_is_evaluation bt:0140533
 */
function test_func_is_evaluation() { // {{{
    global $http_location, $config;

    $http_locations = array(
        'http://yandex.ru/path',
        'http://www.yandex.ru/path',
        'http://yandex.ru/path/',
        'http://www.yandex.ru/path/',
        'http://yandex.ru',
        'http://www.yandex.ru',
        'http://yandex.ru/',
        'http://www.yandex.ru/',
        'http://yandex.ru/~path',
        'http://www.yandex.ru/~path',
        'http://yandex.ru/~path/',
        'http://www.yandex.ru/~path/',
    );
    $urls_from_xb = array(
        'http://username:password@yandex.ru:80/path',
        'http://username:password@www.yandex.ru:80/path',
        'http://username:password@yandex.ru/path',
        'http://username:password@www.yandex.ru/path',
        'http://yandex.ru/path',
        'http://www.yandex.ru/path',
        'http://yandex.ru/path/',
        'http://www.yandex.ru/path/',
        'http://yandex.ru/',
        'http://www.yandex.ru/',
        'http://yandex.ru',
        'http://www.yandex.ru',
        'http://yandex.ru/~path',
        'http://www.yandex.ru/~path',
        'http://yandex.ru/~path/',
        'http://www.yandex.ru/~path/',
    );
    $old_license_url = $config['license_url'];
    $old_http_location = $http_location;

    foreach ($urls_from_xb as $url_from_xb) {
        foreach ($http_locations as $http_location) {
            $config['license_url'] = $url_from_xb;
            $res[$url_from_xb . '       :URL_FROM_XB'][$http_location . '     http_location'] = func_is_evaluation();
        }
    }

    $config['license_url'] = $old_license_url;
    $http_location =  $old_http_location;

    return $res;
} // }}}

/**
 * Function to check absent modules descriptions to work webmaster mode properly
 * https://sd.x-cart.com/view.php?id=135136
 * CHANGE ALSO sql/x-<module>_remove.sql also on res failed
 */
function test_func_check_absent_modules_options_lng() { // {{{
    global $sql_tbl;

    $empty_module_descr = func_query_column("SELECT CONCAT(\"INSERT INTO $sql_tbl[languages] VALUES ('en','\", 'module_descr_', module_name, \"','\", module_descr,\"','Modules');\") FROM $sql_tbl[modules] m LEFT JOIN $sql_tbl[languages] lng ON lng.code='en' AND lng.name=CONCAT('module_descr_', module_name) WHERE lng.name IS NULL");

    $empty_module_name = func_query_column("SELECT CONCAT(\"INSERT INTO $sql_tbl[languages] VALUES ('en','\", 'module_name_', module_name, \"','\", module_descr,\"','Modules');\") FROM $sql_tbl[modules] m LEFT JOIN $sql_tbl[languages] lng ON lng.code='en' AND lng.name=CONCAT('module_name_', module_name) WHERE lng.name IS NULL");

    $empty_options_descr = func_query_column("SELECT CONCAT(\"INSERT INTO $sql_tbl[languages] VALUES ('en','\", 'opt_', c.name, \"','\", c.comment,\"','Options');\") FROM $sql_tbl[config] c LEFT JOIN $sql_tbl[languages] lng ON lng.code = 'en' AND lng.name = CONCAT('opt_', c.name) WHERE lng.name IS NULL AND c.type!='' AND c.category!='' AND c.comment!=''");

    return func_array_merge($empty_module_descr, $empty_options_descr, $empty_module_name);
} // }}}

function test_func_calculate_taxes_by_formula($shipping_cost, $product_taxes_array) { // {{{
    x_load('cart');
    $res = func_calculate_taxes_by_formula($shipping_cost, $product_taxes_array, 0, 0);

    foreach($product_taxes_array as $k => $product_tax) {
        foreach($res['taxes'] as $tax_name => $res_tax) {
            if (
                isset($res['taxes'][$tax_name])
                && isset($product_tax[$tax_name])
            ) {
                $res['taxes'][$tax_name] = array_diff_assoc($res['taxes'][$tax_name], $product_tax[$tax_name]);
            }
        }
    }

    return $res;

} // }}}

function test_func_cat_tree_rebuild() { // {{{
    global $sql_tbl;

    db_query("UPDATE $sql_tbl[categories] SET lpos=0, rpos=0");
    ob_start();
    func_cat_tree_rebuild();
    ob_end_flush();
    return func_query_hash("SELECT categoryid, lpos, rpos FROM $sql_tbl[categories] ORDER BY categoryid", 'categoryid', FALSE);
} // }}}

/*
 Function to test func_category_is_in_subcat_tree
*/
function test_func_category_is_in_subcat_tree() { // {{{
    global $shop_language, $user_account;
    x_load('category');

    $all_categories = func_data_cache_get("get_categories_tree", array(0, false, $shop_language, $user_account['membershipid']));

    $result = array();
    foreach ($all_categories as $k=>$v) {
        foreach ($all_categories as $k2=>$v2) {
            if (!func_category_is_in_subcat_tree($v, $v2)) {
                $result[] = "'" . $v['category_path'] . '\' can be moved to \'' . $v2['category_path'] . "'";
            }
        }
    }
    sort($result);
    return $result;
} // }}}

/*
 Test func_taxcloud_get_cached_response and func_taxcloud_get_cached_response functions
*/
function test_func_taxcloud_get_cached_response() { // {{{
    global $sql_tbl, $xcart_dir;
    global $taxcloud_module_dir;


    if (!isset($sql_tbl['taxcloud_cache'])) {
        $include_func = true;
        require_once $xcart_dir . "/modules/TaxCloud/config.php";
    }


    for ($x = 0; $x < 10; $x++)
        func_taxcloud_save_response_in_cache("key$x",(object)"value$x");

    $res = array();
    for ($x = 0; $x < 10; $x++)
        $res[] = func_taxcloud_get_cached_response("key$x");

    return $res;

} // }}}

function test_func_usps_check_shippingid() { // {{{
    global $sql_tbl, $xcart_dir;
    require_once $xcart_dir . '/modules/Shipping_Label_Generator/func.php';

    $shipping = func_query_column("SELECT shipping FROM xcart_shipping WHERE code='USPS' ORDER BY shipping");

    $res = array();
    foreach ($shipping as $v) {
        $res[$v] = func_usps_check_shippingid(0, $v);
    }

    return $res;
} // }}}

function test_func_parse_user_agent() { // {{{
    global $sql_tbl, $xcart_dir;

    require_once "$xcart_dir/include/classes/class.xc_cache_lite.php";
    $cache_lite = XC_Cache_Lite::get_instance();
    $cache_lite->setLifeTime(SECONDS_PER_MIN * 120);
    $user_agents = $cache_lite->get('', 'useragentswitcher.xml');
    $user_agents = $user_agents ? $user_agents['data'] : $user_agents;
    if (!$user_agents) {
        $user_agents = file_get_contents('http://techpatterns.com/downloads/firefox/useragentswitcher.xml');
        $cache_lite->save($user_agents, '', 'useragentswitcher.xml');
    }

    require_once $xcart_dir . '/include/adaptives.php';

    x_load('http','xml');
    $parse_error = false;
    $options = array(
        'XML_OPTION_CASE_FOLDING' => 1,
        'XML_OPTION_TARGET_ENCODING' => 'UTF-8'
    );

    $parsed = func_xml_parse($user_agents, $parse_error, $options);
    $Browsers_Windows = func_array_path($parsed, 'USERAGENTSWITCHER/#/FOLDER/0/USERAGENT');
    $Browsers_Mac = func_array_path($parsed, 'USERAGENTSWITCHER/#/FOLDER/1/USERAGENT');
    $Browsers_Linux = func_array_path($parsed, 'USERAGENTSWITCHER/#/FOLDER/2/USERAGENT');
    $Browsers_Unix = func_array_path($parsed, 'USERAGENTSWITCHER/#/FOLDER/3/USERAGENT');
    $Browsers = array_merge($Browsers_Windows, $Browsers_Mac, $Browsers_Linux, $Browsers_Unix);
    $user_agents = array();
    foreach ($Browsers as $Browser) {
        $key = $Browser['@']['DESCRIPTION'];
        $value = $Browser['@']['USERAGENT'];
        $user_agents[$value] = $key;
    }

    $res = array();
    $user_agents['Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; MALNJS; rv:11.0) like Gecko'] = 'MSIE 11.0 - (Win 8.1 64)';
    // To avoid error array_merge(): Argument #2 is not an array in include/func/func.dev.php on line 505
    unset($user_agents['Uzbl (Webkit 1.3) (Linux i686 [i686])']);
    ksort($user_agents);

    // UA ignore list
    $ua_ignore_list = array(
        'Arora',
        'Avant',
        'Beamrise',
        'Camino',
        'Dillo',
        'Epiphany',
        'Galeon',
        'Iceape',
        'Iceweasel',
        'Konqueror',
        'Maxthon',
        'Namoroka',
        'Omniweb',
        'QupZilla',
        'SeaMonkey',
        'Seamonkey',
        'Shadowfox',
        'Silk',
        'Swiftfox'
    );

    foreach ($user_agents as $user_agent=>$browser) {
        if (empty($user_agent))
            continue;

        $ua[' EXPECT'] = $browser;
        $ua = array_merge($ua, func_parse_user_agent($user_agent));
        $short_browser = preg_replace('/[ \/].*/S', '', $browser);
        if ($short_browser != $ua['browser'] && !in_array($short_browser, $ua_ignore_list)) {
            $res[$user_agent] = array(
                'expected' => $browser,
                'detected' => $ua['browser'],
            );
        }
    }

    return $res;
} // }}}

function test_func_slg_handler_USPS() { // {{{
    global $sql_tbl, $xcart_dir;
    require_once $xcart_dir . '/modules/Shipping_Label_Generator/usps.php';

    $order = array (
      'order' =>
      array (
        'orderid' => '1033',
        'userid' => '5',
        'membership' => '',
        'total' => '36.71',
        'giftcert_discount' => '0.00',
        'giftcert_ids' => '',
        'subtotal' => 19.98,
        'discount' => '0.00',
        'coupon' => '',
        'coupon_discount' => '0.00',
        'shippingid' => '51',
        'shipping' => 'USPS Retail Ground##TM##',
        'tracking' => '',
        'shipping_cost' => '6.73',
        'tax' => '0.00',
        'date' => '1390556486',
        'status' => 'Q',
        'payment_method' => 'Phone Ordering',
        'flag' => 'N',
        'notes' => '',
        'details' => '',
        'customer_notes' => '',
        'customer' => '',
        'title' => 'Mr.',
        'firstname' => 'John',
        'lastname' => 'Smith',
        'company' => 'IQ testing',
        'b_title' => '',
        'b_firstname' => 'John',
        'b_lastname' => 'Smith',
        'b_address' => '10 Main street',
        'b_city' => 'Fillmore',
        'b_county' => '',
        'b_state' => 'UT',
        'b_country' => 'US',
        'b_zipcode' => '84631',
        'b_zip4' => '',
        'b_phone' => '927348572',
        'b_fax' => '',
        's_title' => '',
        's_firstname' => 'John',
        's_lastname' => 'Smith',
        's_address' => '10 Main street',
        's_city' => 'Fillmore',
        's_county' => '',
        's_state' => 'UT',
        's_country' => 'US',
        's_zipcode' => '84631',
        's_phone' => '927348572',
        's_fax' => '',
        's_zip4' => '',
        'url' => '',
        'email' => 'demo-customer@x-cart.com',
        'language' => 'en',
        'clickid' => '0',
        'membershipid' => '0',
        'paymentid' => '4',
        'payment_surcharge' => '10.00',
        'tax_number' => '',
        'tax_exempt' => 'N',
        'init_total' => '36.71',
        'access_key' => '',
        'review_reminder' => 'N',
        'klarna_order_status' => '',
        'titleid' => '1',
        'b_titleid' => false,
        's_titleid' => false,
        'discounted_subtotal' => '19.98',
        'shipping_exists' => true,
        'display_subtotal' => '19.98',
        'display_discounted_subtotal' => 19.98,
        'display_shipping_cost' => '6.73',
        'b_address_2' => '',
        'b_statename' => 'Utah',
        'b_countryname' => 'United States',
        's_address_2' => '',
        's_statename' => 'Utah',
        's_countryname' => 'United States',
        'is_returns' => false,
        'need_giftwrap' => NULL,
        'giftwrap_cost' => 0,
        'giftwrap_message' => NULL,
        'capture_enable' => false,
        'can_get_info' => false,
      ),
      'products' =>
      array (
        0 =>
        array (
          'weight' => 0,
          'length' => '5',
          'width' => '5',
          'height' => '5',
          'price' => 19.98,
          'package_descr' => '~~~~|lbl_pack|  ||~~~~(0) 5x5x5 ~~~~|lbl_price|  ||~~~~ $19.98',
          'amount' => 1,
          'packages_number' => 1,
        ),
      ),
      'userinfo' =>
      array (
        'id' => '5',
        'login' => 'demo-customer@x-cart.com',
        'username' => 'customer',
        'usertype' => 'C',
        'signature' => '18e66508bf2ed9d3a1c0f011aebac9ced7b817dc',
        'invalid_login_attempts' => '0',
        'email' => 'demo-customer@x-cart.com',
        'last_login' => '1390554486',
        'first_login' => '1087990373',
        'status' => 'Q',
        'activation_key' => '',
        'autolock' => '',
        'suspend_date' => '0',
        'referer' => '',
        'language' => 'en',
        'change_password' => 'N',
        'change_password_date' => '0',
        'parent' => '0',
        'pending_plan_id' => '0',
        'activity' => 'Y',
        'membershipid' => '0',
        'pending_membershipid' => '0',
        'tax_exempt' => 'N',
        'trusted_provider' => 'Y',
        'cookie_access' => '',
        'default_xpc_orderid' => '0',
        'membership' => '',
        'pending_membership' => NULL,
        'flag' => 'N',
        'titleid' => '1',
        'additional_fields' => false,
        'personal_firstname' => 'John',
        'personal_lastname' => 'Smith',
        's_firstname' => 'John',
        's_lastname' => 'Smith',
        's_address' => '10 Main street',
        's_city' => 'Fillmore',
        's_state' => 'UT',
        's_country' => 'US',
        's_zipcode' => '84631',
        's_phone' => '927348572',
        's_fax' => '',
        's_statename' => 'Utah',
        's_countryname' => 'United States',
        'b_firstname' => 'John',
        'b_lastname' => 'Smith',
        'b_address' => '10 Main street',
        'b_city' => 'Fillmore',
        'b_state' => 'UT',
        'b_country' => 'US',
        'b_zipcode' => '84631',
        'b_phone' => '927348572',
        'b_fax' => '',
        'b_statename' => 'Utah',
        'b_countryname' => 'United States',
        'phone' => '927348572',
        'fax' => '',
        'orderid' => '1033',
        'userid' => '5',
        'total' => '36.71',
        'giftcert_discount' => '0.00',
        'giftcert_ids' => '',
        'subtotal' => '19.98',
        'discount' => '0.00',
        'coupon' => '',
        'coupon_discount' => '0.00',
        'shippingid' => '51',
        'shipping' => 'USPS Retail Ground##TM##',
        'tracking' => '',
        'shipping_cost' => '6.73',
        'tax' => '0.00',
        'taxes_applied' => 'a:0:{}',
        'date' => '1390556486',
        'payment_method' => 'Phone Ordering',
        'notes' => '',
        'details' => '',
        'customer_notes' => '',
        'customer' => '',
        'title' => 'Mr.',
        'firstname' => 'John',
        'lastname' => 'Smith',
        'company' => 'IQ testing',
        'b_title' => '',
        'b_county' => '',
        'b_zip4' => '',
        's_title' => '',
        's_county' => '',
        's_zip4' => '',
        'url' => '',
        'clickid' => '0',
        'paymentid' => '4',
        'payment_surcharge' => '10.00',
        'tax_number' => '',
        'init_total' => '36.71',
        'access_key' => '',
        'review_reminder' => 'N',
        'klarna_order_status' => '',
        'b_titleid' => false,
        's_titleid' => false,
        'b_address_2' => '',
        's_address_2' => '',
        's_country_text' => 'United States',
        's_state_text' => 'Utah',
      ),
    );

    $shipping = func_query("SELECT shipping,shippingid FROM xcart_shipping WHERE code='USPS' and shippingid='50' ORDER BY shipping limit 1");

    $res = array();
    foreach ($shipping as $v) {
        $order['order']['shippingid'] = $v['shippingid'];
        $order['order']['shipping'] = $v['shipping'];
        $res[$v['shipping']] = func_slg_handler_USPS($order);
    }

    return $res;
} // }}}

/*
* Find broken language variables missing in xcart_languages_US.sql
*/
function test_grep_broken_labels() { // {{{
    global $xcart_dir;

    $out = array();exec('which grep', $out); $bin_grep = $out[0];

    $out = array();exec('which sed', $out); $bin_sed = $out[0];

    $out = array();exec('which sort', $out); $bin_sort = $out[0];

    $out = array();exec('which uniq', $out); $bin_uniq = $out[0];

    $matches_tpl = $matches_php = $errors = array();
    exec($bin_grep . " -orh '\$lng\.[a-zA-Z0-9_]*' $xcart_dir/skin|$bin_sort|$bin_uniq|$bin_sed  's/^\$lng\.//'", $matches);
    $matches_tpl = func_dev_minify_array($matches);
    unset($matches_tpl['']);

    exec($bin_grep . " -orh --include='*.php' --exclude='*.tpl.php' \"func_get_langvar_by_name(['\\\"][a-zA-Z0-9_]*['\\\"])\" $xcart_dir|$bin_sort|$bin_uniq|$bin_sed 's/^func_get_langvar_by_name..//'|$bin_sed 's/.)$//'", $matches);
    $matches_php = func_dev_minify_array($matches);
    unset($matches_php['']);

    $all_lbs =  array_merge($matches_tpl, $matches_php);

    foreach ($all_lbs as $lbl => $v) {
        $sql_labels = array();
        exec($bin_grep . " -hro  -w \"$lbl\" $xcart_dir/sql/xcart_language_US.sql $xcart_dir/sql/x-*_lng_US.sql", $sql_labels);
        if (empty($sql_labels)) {
            $errors[] = $lbl;
        }
    }
    return func_dev_minify_array($errors);
} // }}}

/*
* Do not use // in css comments
* https://xcn.myjetbrains.com/youtrack/issue/XC4-148116
*/
function test_grep_invalid_css_comments() { // {{{
    global $xcart_dir;

    $out = array();exec('which grep', $out); $bin_grep = $out[0];

    $out = array();exec('which find', $out); $bin_find = $out[0];

    $matches_tpl = $matches_php = $errors = array();
    exec("$bin_grep '[^:/]\/\/[^/]' $($bin_find $xcart_dir/skin -type f -iname '*.css')", $matches);
    $matches_tpl = func_dev_minify_array($matches);
    unset($matches_tpl['']);

    return $matches_tpl;
} // }}}

/*
* Correct $bf_crypted_tables variable when names in xcart_data.sql is changed
*/
function test_grep_bf_crypted_tables_related_data() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec($bin_grep . " -i 'AuthorizeNet\|UPS_username\|UPS_password\|UPS_accesskey\|xpc_shopping_cart_id\|xpc_xpayments_url\|xpc_public_key\|xpc_private' $xcart_dir/sql/xcart_data.sql", $tpl_calls);
    $tpl_calls = preg_replace("%^$xcart_dir/%", '', $tpl_calls);
    $tpl_calls = func_dev_minify_array($tpl_calls);

    return $tpl_calls;
} // }}}

/*
* Do not use escape modificator for product name in HTML (must be used in attr
*/
function test_grep_escaped_product_name() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec($bin_grep . " -r 'product|escape[^<]<' $xcart_dir/skin/", $tpl_calls);
    $tpl_calls = preg_replace("%^$xcart_dir/%", '', $tpl_calls);
    $tpl_calls = func_dev_minify_array($tpl_calls);

    return $tpl_calls;
} // }}}

/*
* grep {include file="...file.tpl} constructions
* https://sd.x-cart.com/view.php?id=135426
*/
function test_grep_incorrect_include_tpl() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec($bin_grep . " -r 'file[^\$]*\.tpl}' $xcart_dir/skin/", $tpl_calls);
    $tpl_calls = preg_replace("%^$xcart_dir/%", '', $tpl_calls);
    $tpl_calls = func_dev_minify_array($tpl_calls);

    exec($bin_grep . " -r 'include file=\"[^\"]* ' $xcart_dir/skin/", $tpl_calls2);
    $tpl_calls2 = preg_replace("%^$xcart_dir/%", '', $tpl_calls2);
    $tpl_calls2 = func_dev_minify_array($tpl_calls2);

    return array_merge($tpl_calls, $tpl_calls2);
} // }}}

/*
* grep {if $usertype eq "A" or $usertype eq "P"} constructions
* Do not use these constructions in email notifications
* use {if $email_to_admin}
* https://sd.x-cart.com/view.php?id=135619
*/
function test_grep_usertype_in_mail_tpl() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec($bin_grep . " -rw '\$usertype' $xcart_dir/skin/common_files/mail/", $tpl_calls);
    $tpl_calls = preg_replace("%^$xcart_dir/%", '', $tpl_calls);
    $tpl_calls = func_dev_minify_array($tpl_calls);

    return $tpl_calls;
} // }}}

/*
* Do not forget rule from
* https://xcn.myjetbrains.com/youtrack/issue/XC4-148401#comment=73-34693
* $config['UA']['screen_x']
*/
function test_grep_UA_screen() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec($bin_grep . " -r --exclude-dir='.git' --exclude='tiny_mce.js' --exclude='backup_for_functest.sql' --exclude='backup_for_btest.sql' --exclude='seltest.paypal_standard.bt48.0.html' --exclude='tiny_mce.js' --exclude='*func.dev.php*' --exclude='*.tpl.php' --exclude='functest.test_grep_UA_screen' --exclude='x-errors_php-*' 'UA.*screen' $xcart_dir", $tpl_calls);
    $tpl_calls = preg_replace("%^$xcart_dir/%", '', $tpl_calls);
    $tpl_calls = func_dev_minify_array($tpl_calls);

    return $tpl_calls;
} // }}}

/*
* Do not forget rule from
* https://sd.x-cart.com/view.php?id=129737#666915
* Never use isset($logged_userid) or isset($login)
*/
function test_grep_isset_logged_userid() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec($bin_grep . " -ri --include='*.php' --exclude='*func.dev.php*' --exclude='*.tpl.php' --exclude='x-errors_php-*' 'isset.*logged' $xcart_dir", $tpl_calls);
    $tpl_calls = preg_replace("%^$xcart_dir/%", '', $tpl_calls);
    $tpl_calls = func_dev_minify_array($tpl_calls);

    exec($bin_grep . " -ri --include='*.php' --exclude='*func.dev.php*' --exclude='*.tpl.php' --exclude='x-errors_php-*' 'isset[^\[]*login\>' $xcart_dir", $tpl_calls_login);
    $tpl_calls_login = preg_replace("%^$xcart_dir/%", '', $tpl_calls_login);
    $tpl_calls_login = func_dev_minify_array($tpl_calls_login);

    return func_array_merge($tpl_calls, $tpl_calls_login);
} // }}}

/*
* Do not forget rule from
* do not use $sql_tbl[customers].userid condition / correct is $sql_tbl[customers].id
*/
function test_grep_customers_userid() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec($bin_grep . " -Eri --include='*.php' --exclude='*func.dev.php*' --exclude='x-errors_php-*' 'sql_tbl\[.{0,1}customers.{0,1}].userid' $xcart_dir", $tpl_calls);
    $tpl_calls = preg_replace("%^$xcart_dir/%", '', $tpl_calls);
    $tpl_calls = func_dev_minify_array($tpl_calls);

    return $tpl_calls;
} // }}}

/*
* Find modules without init.php
* https://sd.x-cart.com/view.php?id=132532#685808
*/
function test_grep_modules_init_php() { // {{{
    global $xcart_dir;

    $out = array();exec('which grep', $out); $bin_grep = $out[0];

    $out = array();exec('which sed', $out); $bin_sed = $out[0];

    exec($bin_grep . " -rl --include='*.php' --exclude='*.tpl.php' -w 'include_init' $xcart_dir/modules|$bin_sed 's/.*\/modules\///'|$bin_sed 's/\/.*//'", $matches);
    $modules2check = $matches;
    $errors = array();

    foreach ($modules2check as $module) {

        if (!is_readable("$xcart_dir/modules/$module/init.php")) {
            $errors[] = "Add modules/$module/init.php file to work when 'Use_new_module_initialization' feature is disabled";
        }
    }
    return func_dev_minify_array($errors);
} // }}}

/*
* Do not forget rule against XSS attack
* https://sd.x-cart.com/view.php?id=133137#683813
* https://sd.x-cart.com/view.php?id=133137#683814
*/
function test_grep_navigation_script_xss() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec($bin_grep . " -ro --include='*.php' --exclude='*func.dev.php*' --exclude='*.tpl.php' 'assign.*navigation_script[^;]*' $xcart_dir", $tpl_calls);
    $tpl_calls = preg_replace("%^$xcart_dir/%", '', $tpl_calls);
    $tpl_calls = func_dev_minify_array($tpl_calls);

    return $tpl_calls;
} // }}}

/*
* Do not forget rule against XSS attack
* https://sd.x-cart.com/view.php?id=135923#697672
*/
function test_grep_location_xss() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec('which wc', $out2);
    $bin_wc = $out2[0];

    exec($bin_grep . " -hrow --include='*.php' --exclude='*func.dev.php*' --exclude='*.tpl.php' '\$location' $xcart_dir|$bin_wc", $tpl_calls);
    $tpl_calls = trim($tpl_calls[0]);
    $tpl_calls = preg_replace("%[ ].*%", '', $tpl_calls);

    return $tpl_calls . '-Number of $location variable changes.Check new variables for XSS on change https://sd.x-cart.com/view.php?id=135923#697672';
} // }}}

/*
* Do not use $mail_smarty = $smarty call
* https://sd.x-cart.com/view.php?id=138342
*
* Do not use $mail_smarty = clone $smarty call
* https://sd.x-cart.com/view.php?id=143217#743898
* Use call like Smarty->Register_prefilter('X_tpl_prefilter', XCTemplater::NOT_FOR_MAIL)
*/
function test_grep_mail_smarty_changes() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec('which wc', $out2);
    $bin_wc = $out2[0];

    exec($bin_grep . " -ro --include='*.php' --exclude='*func.dev.php*' 'mail_smarty.*=.*smarty' $xcart_dir", $tpl_calls);
    $tpl_calls = preg_replace("%^$xcart_dir/%", '', $tpl_calls);
    $tpl_calls = func_dev_minify_array($tpl_calls);

    return $tpl_calls;
} // }}}

/*
* Do not use call like {if $smarty.const.SOME_CONSTANT} as php if (defined('DEVELOPMENT_MODE'))
* https://sd.x-cart.com/view.php?id=136344#701333
*/
function test_grep_smarty_const() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec('which wc', $out2);
    $bin_wc = $out2[0];

    exec($bin_grep . " -hiro 'smarty\.const\.' $xcart_dir/skin|$bin_wc", $tpl_calls);
    $tpl_calls = trim($tpl_calls[0]);
    $tpl_calls = preg_replace("%[ ].*%", '', $tpl_calls);

    return $tpl_calls . '-Number of $smarty.const variables.Check new constants on change .Do not use call like {if $smarty.const.SOME_CONSTANT}';
} // }}}

/*
* Enclose smarty values via '/" when '-' symbol is used
* https://xcn.myjetbrains.com/youtrack/issue/XC4-148330#comment=73-33117
*/
function test_grep_smarty_params_2enclose_in_tpls() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec($bin_grep . " -hiro --include='*.tpl' --exclude='ps_paypal_express.tpl' '{[^}]*=[a-zA-Z0-9_]*[a-zA-Z0-9_]-' $xcart_dir/skin", $tpl_calls);
    $tpl_calls = func_dev_minify_array($tpl_calls);

    return $tpl_calls;
} // }}}

/*
* Do not forget rule against XSS attack
* https://sd.x-cart.com/view.php?id=136000#698074
*/
function test_grep_smarty_get_post_xss() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec('which wc', $out2);
    $bin_wc = $out2[0];

    exec($bin_grep . " -hiro 'smarty\.\(get\|post\|cookies\|server\|env\|session\|request\)\.[^|`} ]*' $xcart_dir/skin|$bin_wc", $tpl_calls);
    $tpl_calls = trim($tpl_calls[0]);
    $tpl_calls = preg_replace("%[ ].*%", '', $tpl_calls);

    return $tpl_calls . '-Number of $smarty.* variables.Check new variables for XSS on change';
} // }}}

// https://sd.x-cart.com/view.php?id=144880#753993
function test_grep_smarty_template_resource() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec('which wc', $out2); $bin_wc = $out2[0];

    exec($bin_grep . " -hro --include='*.php' --exclude-dir='smarty3/' '>template_resource' $xcart_dir|$bin_wc -l", $tpl_calls);

    return $tpl_calls[0] . ':Number of smarty->template_resource usage rule https://sd.x-cart.com/view.php?id=144880#753993';
} // }}}

/*
* Do not use empty() for decimal fields to avoid problem with 0.00 values
* https://sd.x-cart.com/view.php?id=147227#768719
*/
function test_grep_sql_decimal_fields() {
// {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec($bin_grep . " -hwr --include='*.sql' \"decimal\" $xcart_dir/sql", $sql_decimal);
    return func_dev_minify_array($sql_decimal);
} // }}}

/*
* Add a new menu to the $tagsTemplates in func_webmaster_filter
* https://sd.x-cart.com/view.php?id=134155#693355
*/
function test_grep_new_menu_in_menu_box_tpl() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec($bin_grep . " -r --include='*menu_box.tpl*' 'include' $xcart_dir/skin/common_files/", $tpl_calls);
    $tpl_calls = preg_replace("%^$xcart_dir/%", '', $tpl_calls);
    $tpl_calls = func_dev_minify_array($tpl_calls);

    return $tpl_calls;
} // }}}


/*
* Do not forget rule from
* https://sd.x-cart.com/view.php?id=128588#663055
*/
function test_grep_XCARTSESSID() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec($bin_grep . " -ri --exclude='functest.test_grep_XCARTSESSID' 'assign.*SESSID' $xcart_dir", $tpl_calls);
    $tpl_calls = preg_replace("%^$xcart_dir/%", '', $tpl_calls);
    $tpl_calls = func_dev_minify_array($tpl_calls);

    return $tpl_calls;
} // }}}

/*
* Do not use $order_data['userinfo']['id']
* the correct is $order_data['userinfo']['userid']
*/
function test_grep_order_data_userinfo_id() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec($bin_grep . " -ro --include='*.php' --exclude='*func.dev.php*' 'order[^=]*userinfo.*\<id' $xcart_dir", $tpl_calls);
    $tpl_calls = preg_replace("%^$xcart_dir/%", '', $tpl_calls);
    $tpl_calls = func_dev_minify_array($tpl_calls);

    return $tpl_calls;
} // }}}

/*
* Do not use inner join order_details in general cases
* the correct is left join https://xcn.myjetbrains.com/youtrack/issue/XC4-148344#comment=73-33023
*/
function test_grep_inner_join_order_details() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec($bin_grep . " -ro --include='*.php' --exclude='*func.dev.php*' -i --exclude='mpdf.php' 'inner.*order_details' $xcart_dir", $tpl_calls);
    $tpl_calls = preg_replace("%^$xcart_dir/%", '', $tpl_calls);
    $tpl_calls = func_dev_minify_array($tpl_calls);

    return $tpl_calls;
} // }}}

/*
* Use correct error handling via Class
* https://xcn.myjetbrains.com/youtrack/issue/XC4-148346#comment=73-33069
*/
function test_grep_func_place_order() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec($bin_grep . " -r --include='*.php' --exclude='*func.dev.php*' --exclude='mpdf.php' 'func_place_order' $xcart_dir", $tpl_calls);
    $tpl_calls = preg_replace("%^$xcart_dir/%", '', $tpl_calls);
    $tpl_calls = func_dev_minify_array($tpl_calls);

    return $tpl_calls;
} // }}}

/*
* https://sd.x-cart.com/view.php?id=144230#751656 https://sd.x-cart.com/view.php?id=144230#750072
* 1)Do not use settype($val, 'float'); for fields formated by formatnumeric/formatprice
* 2)define('NUMBER_VARS'/func_convert_number should be used for fields formated by formatnumeric/formatprice
*/
function test_grep_formatnumeric_formatprice_settype() { // {{{
    global $xcart_dir;

    exec('which grep', $out); $bin_grep = $out[0];

    exec('which wc', $out2); $bin_wc = $out2[0];

    exec($bin_grep . " -ro --include='*.php' --exclude='*func.dev.php*' 'settype.*\<float\>' $xcart_dir", $tpl_calls);
    $tpl_calls = preg_replace("%^$xcart_dir/%", '', $tpl_calls);
    $tpl_calls = func_dev_minify_array($tpl_calls);

    exec($bin_grep . " -hrow 'formatprice\|formatnumeric' --exclude='*func.dev.php*' --exclude='*.tpl.php' $xcart_dir/skin/|$bin_wc", $tpl_calls2);
    $tpl_calls2 = preg_replace("%^$xcart_dir/%", '', $tpl_calls2);
    $tpl_calls2[0] .= ' formatprice\|formatnumeric counts in skins';
    $tpl_calls2 = func_dev_minify_array($tpl_calls2);

    return array_merge($tpl_calls, $tpl_calls2);
} // }}}

/*
* https://sd.x-cart.com/view.php?id=145892#760767
* consider using  escape:htmlcompat/escape:html when escape:javascript is used in html attributs like onlick
*/
function test_grep_escape_javascript() { // {{{
    global $xcart_dir;

    exec('which grep', $out); $bin_grep = $out[0];

    exec('which wc', $out2); $bin_wc = $out2[0];


    exec($bin_grep . " -hrow 'javascript.*escape.*javascript' --include='*.tpl' --exclude='*.tpl.php' $xcart_dir/skin/|$bin_wc -l", $tpl_calls2);
    $tpl_calls2 = preg_replace("%^$xcart_dir/%", '', $tpl_calls2);
    $tpl_calls2[0] .= ' javascript:escape counts in skins in html attrs';
    $tpl_calls2 = func_dev_minify_array($tpl_calls2);

    return $tpl_calls2;
} // }}}

/*
* https://xcn.myjetbrains.com/youtrack/issue/XC4-148340#comment=73-32908
* search absent semicolon var var obj = {} statement
*/
function test_grep_absent_semicolon_javascript() { // {{{
    global $xcart_dir;

    //multiline
    exec('which pcregrep', $out); $bin_grep = $out[0];

    exec($bin_grep . " -M -r --colour=auto --exclude-dir='edit_area' --exclude-dir='lib' --exclude-dir='tinymce' --exclude='barcodes_js.tpl' '(?iU)var\s{1,}[a-zA-Z].*{ldelim}(?iUs)(?:(?!ldelim).)*{rdelim}\s*$' $xcart_dir/skin/", $tpl_calls2);
    $tpl_calls2 = preg_replace("%^$xcart_dir/%", '', $tpl_calls2);

    return $tpl_calls2;
} // }}}

/*
 * Make sure all created tables have their corresponding drop statements
 *
 * https://sd.x-cart.com/view.php?id=138954
 */
function test_grep_create_drop_tables() {
    global $xcart_dir;

    $sql_create_files = glob($xcart_dir . '/sql/*.sql');

    foreach ($sql_create_files as $key => $file) {
        $fileinfo = pathinfo($file);

        if (!empty($fileinfo['filename'])
            && preg_match("/(.*)(dbclear|_drop_tables|_remove|_conf_|_language_|_lng_|states_)(.*)/", $fileinfo['filename']) !== 0
        ) {
            unset($sql_create_files[$key]);
        }
    }

    $tables = array();

    foreach ($sql_create_files as $filename) {
        $filecontent = file_get_contents($filename);
        if (
            preg_match_all("/CREATE TABLE ([Ii][Ff][ ][Nn][Oo][Tt][ ][Ee][Xx][Ii][Ss][Tt][Ss][ ])*[(`|'|\")]*([\w-_]{1,})[(`|'|\")]*.*\(.*/", $filecontent, $pm_results) !== 0
        ) {
            $tables = array_merge($tables, array_values($pm_results[2]));
        }
    }

    $tables = array_unique($tables);

    unset($sql_create_files);

    $sql_drop_files = glob($xcart_dir . '/sql/*_drop_tables.sql');
    $sql_drop_files[] = $xcart_dir . '/sql/dbclear.sql';

    exec('which grep', $out);
    $bin_grep = $out[0];

    $res = array();

    foreach ($tables as $tablename) {
        $tablename = str_replace('`', '', $tablename);

        $grep_result = exec($bin_grep . " -w '$tablename' " . implode(' ', $sql_drop_files));

        if (empty($grep_result)) {
            $res[] = array(
                'missing' => "DROP TABLE $tablename",
            );
        }
    }

    return $res;
}

/*
* Do not forget bug from
* https://sd.x-cart.com/view.php?id=131239
*/
function test_grep_typo_config1() { // {{{
    global $xcart_dir;

    exec('which grep', $out);
    $bin_grep = $out[0];

    exec($bin_grep . " -hro --include='*.php' --exclude='*func.dev.php*' --exclude='*PPPlatformServiceHandler.php*' --exclude='*PPMerchantServiceHandler.php*' --exclude='*PPOpenIdSession.php*' --exclude='*PPLoggingManager.php*' --exclude='*PPOpenIdHandler.php*' --exclude='*PPConnectionManager.php*' 'config\[.[a-zA-Z0-9_]*\.[a-zA-Z0-9_]*.\]' $xcart_dir", $tpl_calls);
    $tpl_calls = preg_replace("%^$xcart_dir/%", '', $tpl_calls);
    $tpl_calls = func_dev_minify_array($tpl_calls);

    return $tpl_calls;
} // }}}


/**
 * This is VERY slow function
 */
function test_text_hash_verify() { // {{{
    global $xcart_dir;

    x_load('crypt');

    $res = array();
    for ($x = 0; $x < 1000; $x++) {
        $str = md5(uniqid(md5($x) . rand(), true)) . md5($x + uniqid(rand(), true));
        $hash = text_hash($str);
        if (!text_verify($str, $hash))
            $res[] = array($str, $hash);

        $str = md5(uniqid(md5($x) . rand(), true));
        $hash = text_hash($str);
        if (!text_verify($str, $hash))
            $res[] = array($str, $hash);

        $str = substr(md5(uniqid(md5($x) .rand(), true)), 0, 16);
        $hash = text_hash($str);
        if (!text_verify($str, $hash))
            $res[] = array($str, $hash);
    }

    $files = array('func.core.php', 'func.user.php', 'func.perms.php');
    foreach ($files as $file) {
        $str = file_get_contents("$xcart_dir/include/func/$file");
        $hash = text_hash($str);
        if (!text_verify($str, $hash))
            $res[] = array($str, $hash);
    }

    return $res;
} // }}}


function test_xmlmap_get_url($type, $id) { // {{{
    global $http_location;
    $res = xmlmap_get_url($type, $id);
    $res = str_replace($http_location, '', $res);
    return $res;
} // }}}


function testclass_XCsignatureCustomers() { // {{{
    global $sql_tbl, $xcart_dir;

    $users = func_query("SELECT * FROM $sql_tbl[customers]");

    $res = array();

    require_once $xcart_dir . '/include/classes/class.XCSignature.php';
    foreach ($users as $user) {

        $obj_user = new XCUserSignature($user);
        if (!$obj_user->checkSignature())
            $res[] = implode('||', $user);

    }

    return $res;
} // }}}

/*
 Test func_is_defined_module_sql_tbl for all modules
*/
function ztest_func_is_defined_module_sql_tbl() { // {{{
    global $sql_tbl, $xcart_dir, $active_modules;

    $cannot_included_modules = array(
        'XAuth' => array('xauth_user_ids'),
    );

    $modules = func_query_column("SELECT module_name FROM $sql_tbl[modules] ORDER BY RAND() LIMIT 1");
    foreach ($modules as $module_name) {
        if (isset($cannot_included_modules[$module_name]))
            continue;

        if (is_readable($xcart_dir . "/modules/$module_name/config.php")) {
            include $xcart_dir . "/modules/$module_name/config.php";
        }
    }

    return TRUE;

} // }}}

?>
