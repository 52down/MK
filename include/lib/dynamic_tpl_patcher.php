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
 * Ext.core
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    $Id$
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */
//namespace modules\Pilibaba\lib;
$xc_module_prefix = '';
//use XCTemplater;//module_compatible from 4.7.0

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

global $x_defer_resources, $smarty;

$x_defer_resources = array();

const X_TPL_PATCH_REGEXP = 'regexp';
const X_TPL_PATCH_XPATH = 'xpath';
const X_TPL_PATCH_CALLBACK = 'callback';

const X_XPATH_INSERT_AFTER = 'after';//only for x_tpl_add_xpath_patch calls (X_TPL_PATCH_XPATH)
const X_XPATH_INSERT_BEFORE = 'before';//only for x_tpl_add_xpath_patch calls (X_TPL_PATCH_XPATH)
const X_XPATH_INSERT_REPLACE = 'replace';//only for x_tpl_add_xpath_patch calls (X_TPL_PATCH_XPATH)

const X_HTML_OUTPUT = 'html_output';
const X_TPL_PREFILTER = 'tpl_prefilter';

const X_TPL_VERSION = '2.0';

$smarty->assign('x_core_started', $xc_module_prefix ?: 'yes');


/**
 * Common functions
 */
function x_local_storage($keys = array(), $value = NULL) {//{{{
    static $storage = array();

    $result = NULL;

    if (2 > func_num_args()) {

        // Getter
        $result = $storage;
        foreach ($keys as $key) {
            if (isset($result[$key])) {
                $result = $result[$key];

            } else {
                $result = NULL;
                break;
            }
        }

    } elseif (isset($value)) {

        $cell =& $storage;#nolint
        $i = count($keys);
        foreach ($keys as $key) {
            if (!is_array($cell) || !isset($cell[$key])) {#nolint
                $cell[$key] = array();
            }

            if (1 == $i) {
                $cell[$key] = $value;

            } else {
                $cell =& $cell[$key];
                $i--;
            }
        }

    } else {

        $cell =& $storage;
        $i = count($keys);
        foreach ($keys as $key) {
            if (!is_array($cell) || !isset($cell[$key])) {
                break;
            }

            if (!is_array($cell[$key]) || 1 == $i) {
                unset($cell[$key]);
                break;
            }

            $i--;
        }

    }

    return $result;
}//}}}

function x_get_callback_id($callback) {//{{{
    $callbackId = NULL;

    if (is_array($callback) && 2 == count($callback)) {
        $callbackId = (is_string($callback[0]) ? $callback[0] : get_class($callback[0]))
            . ':' . $callback[1];

    } elseif (is_object($callback) && 'Closure' == get_class($callback)) {
        $callbackId = spl_object_hash($callback);

    } elseif (is_string($callback)) {
        $callbackId = $callback;
    }

    return $callbackId;
}//}}}

/**
 * Template events functions
 */
// MUST be not conditional calls in order to correct compilation! x_tpl_prefilter changes tpls based on before_events/after_events vars
// assignGlobal must be used instead of assign in listeners
function x_tpl_add_listener($tpl, $event, $callback) {//{{{
    $prefix = str_replace('\\', '', str_replace('x_tpl_add_listener', '', __FUNCTION__));
    x_local_storage(array('tpl_event' . $prefix, $tpl, $event, x_get_callback_id($callback)), $callback);
}//}}}

function x_tpl_remove_listener($tpl, $event, $callback) {//{{{
    $prefix = str_replace('\\', '', str_replace('x_tpl_remove_listener', '', __FUNCTION__));
    x_local_storage(array('tpl_event' . $prefix, $tpl, $event, x_get_callback_id($callback)), NULL);
}//}}}

// add event calls to templates
function x_tpl_prefilter($source, $smarty) {//{{{
    if ($smarty->smarty->isEvalTemplate($smarty->template_resource)) {
        return $source;
    }

    $prefix = str_replace('\\', '', str_replace('x_tpl_prefilter', '', __FUNCTION__));
    $condition = empty($prefix) ? 'yes' : $prefix;

    $before_events = x_local_storage(array('tpl_event' . $prefix, $smarty->template_resource, 'before'));
    $after_events = x_local_storage(array('tpl_event' . $prefix, $smarty->template_resource, 'after'));

    return
        (empty($before_events) ? '' : ("{if \$x_core_started eq '$condition'}{xevent$prefix" . ' name="before" tpl="' . $smarty->template_resource . '"}{/if}' . "\n"))#nolint
        . $source
        .(empty($after_events) ? '' : ("{if \$x_core_started eq '$condition'}{xevent$prefix" . ' name="after" tpl="' . $smarty->template_resource . '"}{/if}'));#nolint
}//}}}
$smarty->register_prefilter(__NAMESPACE__ . '\\' . 'x_tpl_prefilter', XCTemplater::NOT_FOR_MAIL);//module_compatible from 4.7.0

//call event listeners from templates
function x_tpl_fire_event($params, $smarty) {//{{{
    $result = '';

    if (
        isset($params['name']) && $params['name']
        && isset($params['tpl']) && $params['tpl']
    ) {
        $events = x_local_storage(array('tpl_event', $params['tpl'], $params['name']));

        if (
            is_array($events)
            && $events
        ) {
            foreach ($events as $listener) {

                if (is_callable($listener)) {

                    $r = call_user_func($listener, $params, $smarty);

                } else {

                    $r = $smarty->fetch($listener);
                }

                if (FALSE === $r) {

                    break;

                } elseif (
                    $r
                    && is_string($r)
                ) {

                    if ('before' == $params['name']) {

                        $result = $r . $result;

                    } else {

                        $result .= $r;
                    }
                }
            }
        }
    }

    return $result;
}//}}}
$smarty->register_function('xevent' . $xc_module_prefix, __NAMESPACE__ . '\\' . 'x_tpl_fire_event');

/**
 * Template prefilter patcher
 */
function x_tpl_prefilter_patcher($tpl_source, $smarty) {//{{{

    $storage = x_local_storage(array(X_TPL_PREFILTER));
    if (
        !is_array($storage)
        || $smarty->smarty->isEvalTemplate($smarty->template_resource)//module_compatible from 4.7.3
    ) {
        return $tpl_source;
    }

    $tpl = $smarty->template_resource;
    if (!isset($storage[$tpl])) {
        return $tpl_source;
    }

    $patches = $storage[$tpl];
    // Apply patchers

    foreach ($patches as $patch) {

        if (X_TPL_PATCH_REGEXP == $patch['type'] && preg_match($patch['pattern'], $tpl_source)) {

            $tpl_source = preg_replace(
                $patch['pattern'],
                $patch['replace'],
                $tpl_source
            );

        } elseif (X_TPL_PATCH_CALLBACK == $patch['type']) {
            // By callback
            $tpl_source = $patch['callback']($tpl, $tpl_source);
        }
    }

    return $tpl_source;
}//}}}
$smarty->register_prefilter(__NAMESPACE__ . '\\' . 'x_tpl_prefilter_patcher');

/**
 * Template patches register functions
 */
function x_tpl_add_regexp_patch($patch, $pattern, $replace = null, $patch_type = X_HTML_OUTPUT) {//{{{
    $data = x_local_storage(array($patch_type));

    if (!isset($data[$patch])) {
        $data[$patch] = array();
    }

    $data[$patch][] = array(
        'type'    => X_TPL_PATCH_REGEXP,
        'pattern' => $pattern,
        'replace' => $replace,// for X_HTML_OUTPUT $patch treat as tpl-file. It is fetched and used in replace params
    );

    x_local_storage(array($patch_type), $data);

    return TRUE;
}//}}}

function x_tpl_add_xpath_patch($patch, $xpath, $insert_type = X_XPATH_INSERT_BEFORE, $patch_type = X_HTML_OUTPUT) {//{{{
    if (
        !class_exists('DOMDocument', FALSE)
        || !is_string($patch)
        || $patch_type == X_TPL_PREFILTER
    ) {
        return FALSE;
    }

    $data = x_local_storage(array($patch_type));

    if (!isset($data[$patch])) {
        $data[$patch] = array();
    }

    $data[$patch][] = array(
        'type'        => X_TPL_PATCH_XPATH,
        'xpath'       => $xpath,
        'insert_type' => $insert_type,
    );

    x_local_storage(array($patch_type), $data);

    return TRUE;
}//}}}

function x_tpl_add_callback_patch($patch, $callback, $patch_type = X_HTML_OUTPUT) {//{{{
    if (!is_callable($callback)) {
        return FALSE;
    }

    $data = x_local_storage(array($patch_type));

    if (!isset($data[$patch])) {
        $data[$patch] = array();
    }

    $data[$patch][] = array(
        'type'     => X_TPL_PATCH_CALLBACK,
        'callback' => $callback,
    );

    x_local_storage(array($patch_type), $data);

    return TRUE;
}//}}}

function x_tpl_outputfilter($output, &$smarty) {//{{{
    static $isRun = FALSE;

    $patch_type = X_HTML_OUTPUT;

    if ($isRun || !is_array(x_local_storage(array($patch_type)))) {
        return $output;
    }

    $isRun = TRUE;
    $DOMPApplyed = FALSE;

    // Apply patchers
    $dom = NULL;

    foreach (x_local_storage(array($patch_type)) as $tpl => $patches) {

        if (isset($smarty->smarty->already_included_tpls[$tpl])) {
            continue;
        }

        $text = NULL;
        $isPatched = FALSE;

        foreach ($patches as $patch) {

            if (X_TPL_PATCH_REGEXP == $patch['type'] && preg_match($patch['pattern'], $output)) {

                // By regular expression
                if (!isset($text)) {
                    $text = $smarty->fetch($tpl);
                }

                $replace = $patch['replace'] ? str_replace('%%', $text, $patch['replace']) : $text;

                $output = preg_replace(
                    $patch['pattern'],
                    $replace,
                    $output
                );
                $dom = NULL;
                $isPatched = TRUE;

            } elseif (X_TPL_PATCH_XPATH == $patch['type'] && FALSE !== $dom) {

                // By XPath
                if (!isset($dom)) {
                    $dom = new DOMDocument();

                    // Load source and patch to DOMDocument
                    if (!@$dom->loadHTML($output)) {
                        $dom = FALSE;
                        continue;
                    }
                }

                $xpath = new DOMXPath($dom);

                // Iterate patch nodes
                $places = $xpath->query($patch['xpath']);

                if (0 < $places->length) {
                    if (!isset($text)) {
                        $text = $smarty->fetch($tpl);
                    }

                    $domPatch = new DOMDocument();

                    if ($domPatch->loadHTML($text)) {
                        $n = $dom->importNode($domPatch->documentElement->childNodes->item(0), TRUE);
                        $nodes = $n->childNodes;
                        if (0 < $nodes->length) {
                            x_tpl_apply_xpath_patches($places, $nodes, $patch['insert_type']);

                            // Save changed source
                            $output = $dom->saveHTML();
                            $DOMPApplyed = TRUE;
                            $isPatched = TRUE;
                        }
                    }
                }

            } elseif (X_TPL_PATCH_CALLBACK == $patch['type']) {

                // By callback
                if ($patch['callback']($tpl, $output)) {
                    $isPatched = TRUE;
                }
            }

            if ($isPatched) {
                break;
            }
        }
    }

    if ($DOMPApplyed) {
        $output = x_dom_html_postprocess($output);
    }

    // Add defer resurces
    global $x_defer_resources;

    if ($x_defer_resources) {
        $output = preg_replace(
            '/<\/head>/Ss',
            implode("\n", $x_defer_resources) . "\n" . '</head>',
            $output
        );
    }

    $isRun = FALSE;

    return $output;
}//}}}

$smarty->track_included_tpls = true;
$smarty->register_outputfilter(__NAMESPACE__ . '\\' . 'x_tpl_outputfilter', XCTemplater::NOT_FOR_MAIL);//module_compatible from 4.7.0

function x_tpl_apply_xpath_patches($places, $patches, $baseInsertType) {//{{{
    foreach ($places as $place) {

        $insertType = $baseInsertType;
        foreach ($patches as $node) {
            $node = $node->cloneNode(TRUE);

            if (X_XPATH_INSERT_BEFORE == $insertType) {

                // Insert patch node before XPath result node
                $place->parentNode->insertBefore($node, $place);

            } elseif (X_XPATH_INSERT_AFTER == $insertType) {

                // Insert patch node after XPath result node
                if ($place->nextSibling) {
                    $place->parentNode->insertBefore($node, $place->nextSibling);
                    $insertType = X_XPATH_INSERT__BEFORE;
                    $place = $place->nextSibling;

                } else {
                    $place->parentNode->appendChild($node);
                }

            } elseif (X_XPATH_INSERT_REPLACE == $insertType) {

                // Replace XPath result node to patch node
                $place->parentNode->replaceChild($node, $place);

                if ($node->nextSibling) {
                    $place = $node->nextSibling;
                    $insertType = X_XPATH_INSERT_BEFORE;

                } else {
                    $place = $node;
                    $insertType = X_XPATH_INSERT_AFTER;
                }
            }
        }
    }
}//}}}

function x_dom_html_postprocess($output) {//{{{
    $output = preg_replace(
        '/<\?xml.+\?'.'>/USs',
        '',
        $output
    );

    $output = preg_replace(
        '/(<(?:meta|link|br|img|input|hr)(?: [^>]+)?)>/Ss',
        '$1 />',
        $output
    );

   return $output;
}//}}}

/**
 * Register Javascript and CSS resources
 */

function x_register_js($file)
{
    global $smarty, $xcart_dir, $x_defer_resources;

    require_once $xcart_dir . '/include/templater/plugins/function.load_defer.php';

    $result = smarty_function_load_defer(
        array(
            'file' => $file,
            'type' => 'js',
        ),
        $smarty
    );

    if ($result) {
        $x_defer_resources[] = $result;
    }

}

function x_register_css($file)
{
    global $smarty, $xcart_dir, $x_defer_resources;

    require_once $xcart_dir . '/include/templater/plugins/function.load_defer.php';

    $result = smarty_function_load_defer(
        array(
            'file' => $file,
            'type' => 'css',
        ),
        $smarty
    );

    if ($result) {
        $x_defer_resources[] = $result;
    }
}

function x_display_popup_content($tpl)
{
    global $smarty;

    echo ("\n" . '<!-- MAIN -->' . "\n");
    func_display($tpl, $smarty);
    echo ("\n" . '<!-- /MAIN -->' . "\n");

}

function x_get_controller_id()
{
    global $mode;

    if (defined('DISPATCHED_REQUEST') && DISPATCHED_REQUEST) {
        global $clean_url_data;

        $hash = array(
            'C' => 'home',
            'P' => 'product',
            'M' => 'manufacturers',
            'S' => 'pages',
        );

        return array(
            'C',
            ($clean_url_data && isset($hash[$clean_url_data['resource_type']])) ? $hash[$clean_url_data['resource_type']] : 'home',
            NULL
        );

    } else {
        return array(
            x_get_area_type(),
            substr(basename($_SERVER['SCRIPT_FILENAME']), 0, -4),
            isset($mode) ? $mode : NULL
        );
    }

}

function x_check_controller_condition($area = NULL, $script = NULL, $mode = NULL)
{
    $tmp = x_get_controller_id();

    $result = TRUE;

    if ($area) {
        $result = $tmp[0] == $area;
    }

    if ($result && $script) {
        if (is_array($script)) {
            $result = in_array($tmp[1], $script);

        } else {
            $result = $tmp[1] == $script;
        }
    }

    if ($result && $mode) {
        if (is_array($mode)) {
            $result = in_array($tmp[2], $mode);

        } else {
            $result = $tmp[2] == $mode;
        }
    }

    return $result;
}

function x_get_area_type()
{
    return (defined('AREA_TYPE')) ? AREA_TYPE : '';
}

function &x_get_template_var_ref($name, $smarty)
{
    return $smarty->getTemplateVars($name);
}

function x_get_template_var($name, $smarty)
{
    return $smarty->getTemplateVars($name);
}

function x_set_template_var_by_path($path, $value, $smarty)
{
    $current_ref = NULL;

    $path = explode('.', $path);

    if (
        !empty($path)
        && is_array($path)
    ) {

        $current_ref =& x_get_template_var_ref($path[0], $smarty);

        for ($i = 1; $i < count($path); $i++) {

            if (
                is_array($current_ref)
                && isset($current_ref[$path[$i]])
            ) {
                $current_ref =& $current_ref[$path[$i]];

            } else {

                return FALSE;
            }
        }

        $current_ref = $value;
    }

    return TRUE;
}

function x_get_template_var_by_path($path, $smarty)
{
    $current_val = NULL;

    $path = explode('.', $path);

    if (!empty($path)) {

        $current_val = x_get_template_var($path[0], $smarty);

        if (1 < count($path)) {

            for ($i = 1; $i < count($path); $i++) {

                if (
                    is_array($current_val)
                    && isset($current_val[$path[$i]])
                ) {
                    $current_val = $current_val[$path[$i]];

                } else {

                    return NULL;
                }
            }
        }
    }

    return $current_val;
}
