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
 * Templater extension
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Smarty class descendant
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    87ace7fac4d3c8e48c5d9155177725199e8d51e5, v84 (xcart_4_7_8), 2017-05-19 17:24:14, templater.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!defined('XCART_START')) { header("Location: ../../"); die("Access denied"); }

require_once SMARTY_DIR . 'SmartyBC.class.php';

class XCTemplater extends SmartyBC {
    /**
     * Use this const for ->register_*filter for browser output only, not email notifications
     */
    const NOT_FOR_MAIL='NOT_FOR_MAIL';

    /**
     * show if webmaster mode is started
     */
    public $webmaster_mode;

    /**
     * keep all included tpls
     */
    public $already_included_tpls = array();

    /**
     * Current level of template inclusion. Changed in {include } smarty tag
     */
    public $inclusion_depth = 0;

    /**
     * Save or not all include tpls in already_included_tpls var
     */
    public $track_included_tpls = false;

    /**
     * http://www.smarty.net/docs/en/variable.use.sub.dirs.tpl
     * MUST BE true if compile_id_based_on_filters is true
     */
    public $use_sub_dirs = true;

    /**
     * Global flag is set in Include_cache is read in Load_defer
     */
    public $called_from_include_cache = false;

    /**
     * Use compile_id based on pre/post filter sets
     */
    public $compile_id_based_on_filters = true;

    /**
     * Keep filters to unregister before Func_send_mail call and restore after the call
     */
    protected $not_mail_filters = array();

    public function __construct()
    { //{{{
        parent::__construct();

        $this->addPluginsDir(array(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'plugins'));

        $exec_mode = func_get_php_execution_mode();
        if ($exec_mode == 'privileged') {
            $this->_dir_perms  = 0711;
            $this->_file_perms = 0600;
        }

        $this->error_reporting = E_ALL & ~E_NOTICE;
        if (defined('DEVELOPMENT_MODE')) {
            $this->enableSecurity('XC_Dev_Smarty_Security');
        } else {
            $this->enableSecurity('XC_Smarty_Security');
        }
        $this->direct_access_security = true;
        $this->unregisterPlugin('block', 'php');

        /**
         * name of class used for templates
         */
        if (!defined('DEVELOPMENT_MODE')) {
            $this->template_class = 'XC_Smarty_Internal_Template';
        } else {
            $this->template_class = 'XC_Dev_Smarty_Internal_Template';
        }
    } // }}}

    /**
     * Get current compileId based on the current pre/post filter sets and current skin
     */
    public function getCompileId()
    {//{{{
        global $config;

        if (empty($this->compile_id_based_on_filters)) {
            return $this->compile_id;
        }

        $key = '';
        $key .= (!empty($this->registered_filters['post']) ? serialize($this->registered_filters['post']) : '');
        $key .= (!empty($this->registered_filters['pre']) ? serialize($this->registered_filters['pre']) : '');
        $key .= $config['alt_skin'];
        $key .= (defined('DEVELOPMENT_MODE') ? 'dev' : '');

        return md5($key);
    }//}}}

    // use X-Cart internal function instead of the default one
    public function clear_cache($tpl_file = null, $cache_id = null, $compile_id = null, $exp_time = null)
    {//{{{
        assert('func_has_caller_function("func_remove_xcart_caches") /* '.__METHOD__.' check if func_remove_xcart_caches function should be used*/');

        return func_rm_dir($this->getCacheDir(), TRUE);
    }//}}}

    // use X-Cart internal function instead of the default one
    public function clear_compiled_tpl($tpl_file = null, $compile_id = null, $exp_time = null)
    {//{{{
        if (empty($tpl_file)) {
            assert('func_has_caller_function("func_remove_xcart_caches") /* '.__METHOD__.' check if func_remove_xcart_caches function should be used*/');
            return func_rm_dir($this->getCompileDir(), TRUE);
        } else {
            return parent::clearCompiledTemplate($tpl_file, $compile_id, $exp_time);
        }
    }//}}}


    /**
     * Registers a prefilter function to apply
     * to a template before compiling
     *
     * @param string $function
     * @param string $target
     */
    public function register_prefilter($function, $target = 'ALL')
    {//{{{
        if ($target == self::NOT_FOR_MAIL) {
            $this->not_mail_filters['pre'][$function] = 1;
        }
        $this->registerFilter('pre', $function);
    }//}}}


    /**
     * Registers a postfilter function to apply
     * to a compiled template after compilation
     *
     * @param string $function
     * @param string $target
     */
    public function register_postfilter($function, $target = 'ALL')
    {//{{{
        if ($target == self::NOT_FOR_MAIL) {
            $this->not_mail_filters['post'][$function] = 1;
        }
        $this->registerFilter('post', $function);
    }//}}}

    /**
     * Registers an output filter function to apply
     * to a template output
     *
     * @param string $function
     * @param string $target
     */
    public function register_outputfilter($function, $target = 'ALL')
    {//{{{
        if ($target == self::NOT_FOR_MAIL) {
            $this->not_mail_filters['output'][$function] = 1;
        }
        $this->registerFilter('output', $function);
    }//}}}

    public function unregisterNotMailFilters()
    {//{{{
        if (empty($this->not_mail_filters)) {
            return false;
        }

        foreach($this->not_mail_filters as $type=>$filters) {
            foreach($filters as $function => $k) {
                $this->unregisterFilter($type, $function);
            }
        }

        return true;
    }//}}}

    public function restoreNotMailFilters()
    {//{{{
        if (empty($this->not_mail_filters)) {
            return false;
        }

        foreach($this->not_mail_filters as $type=>$filters) {
            foreach($filters as $function => $k) {
                $this->registerFilter($type, $function);
            }
        }

        return true;
    }//}}}

    public function getRegisterPlugins()
    {//{{{
        return $this->registered_plugins;
    }//}}}

    public function changeSecurity($params)
    {// {{{
        if (
            !empty($params['php_modifiers'])
            && is_array($params['php_modifiers'])
        ) {
            $this->security_policy->php_modifiers = array_merge($this->security_policy->php_modifiers, $params['php_modifiers']);
        }

        if (
            !empty($params['php_functions'])
            && is_array($params['php_functions'])
        ) {
            $this->security_policy->php_functions = array_merge($this->security_policy->php_functions, $params['php_functions']);
        }

        if (
            !empty($params['static_classes'])
            && is_array($params['static_classes'])
        ) {
            $this->security_policy->static_classes = array_merge(
                // if access to all static classes is disabled
                is_null($this->security_policy->static_classes)
                    ? array() // use empty array as a source
                    : $this->security_policy->static_classes,
                $params['static_classes']
            );
        }
    } // }}}

    public function isEvalTemplate($tpl_file)
    {// {{{
        return strpos($tpl_file, 'eval:') === 0 || strpos($tpl_file, 'string:') === 0;
    } // }}}

    public function apply_configuration_settings($config)
    {//{{{
        $this->compile_check = empty($config['General']['skip_check_compile']) || $config['General']['skip_check_compile'] != 'Y';
    }//}}}

    // Wrapper for smarty {alter_currency } plugin to call from PHP
    public function formatAlterCurrency($params, $oTemplate = null)
    { // {{{
        global $xcart_dir;

        require_once $xcart_dir . '/include/templater/plugins/function.alter_currency.php';
        $oTemplate = $oTemplate ?: $this;
        return smarty_function_alter_currency($params, $oTemplate);
    } // }}}

    // Wrapper for smarty {currency } plugin to call from PHP
    public function formatCurrency($params, $oTemplate = null)
    { // {{{
        global $xcart_dir;

        require_once $xcart_dir . '/include/templater/plugins/function.currency.php';
        $oTemplate = $oTemplate ?: $this;
        return smarty_function_currency($params, $oTemplate);
    } // }}}
}

/**
 * Overwrite parent to support _include_once feature and track_included_tpls by request from modules
 */
class XC_Smarty_Internal_Template extends Smarty_Internal_Template {
    public function getSubTemplate($template, $cache_id, $compile_id, $caching, $cache_lifetime, $data, $parent_scope)
    {//{{{

        if (
            !empty($data['_include_once'])
            && isset($this->smarty->already_included_tpls[$template])
        ) {
            return '';
        }

        if (
            !empty($this->smarty->track_included_tpls)
            || !empty($data['_include_once'])
            || $this->smarty->debugging
        ) {
            $this->smarty->already_included_tpls[$template] = ++$this->smarty->inclusion_depth;
        }


        $res = parent::getSubTemplate($template, $cache_id, $compile_id, $caching, $cache_lifetime, $data, $parent_scope);

        if ($this->smarty->debugging) {
            $this->smarty->inclusion_depth--;
        }
        return $res;
    }//}}}
}

/**
 * Overwrite parent to catch all calls to Smarty_Internal_Template::__get()/__call methods. Works only in DEVELOPMENT_MODE
 */
class XC_Dev_Smarty_Internal_Template extends XC_Smarty_Internal_Template {
    public function __call($name, $args)
    {//{{{
        static $methods;

        // https://sd.x-cart.com/view.php?id=143308#744356
        if (!isset($methods)) {
            $f = new ReflectionClass('XCTemplater');
            $methods = array();
            foreach ($f->getMethods() as $m) {
                if (in_array($m->class, array('XCTemplater', 'SmartyBC'))) {
                    $methods[$m->class][] = $m->name;
                }
            }
        }

        assert('!in_array($name, $methods["XCTemplater"]) && !in_array($name, $methods["SmartyBC"]) /* '.__METHOD__.' :SHORT_BACKTRACE: https://sd.x-cart.com/view.php?id=143308#744356 Use the call like $smarty->smarty->' . $name . '(*/');#nolint
        return parent::__call($name, $args);
    }//}}}

    public function __get($property_name)
    {//{{{
        assert('in_array($property_name, array("source","compiled","cached","compiler")) /* '.__METHOD__.' :SHORT_BACKTRACE: Use the call like $smarty->smarty->' . $property_name . '*/');#nolint
        return parent::__get($property_name);
    }//}}}
}


class XC_Smarty_Security extends Smarty_Security {
    public function __construct($smarty)
    {//{{{
        global $xcart_http_host, $xcart_https_host;

        parent::__construct($smarty);

        // http://www.smarty.net/docs/en/advanced.features.tpl#advanced.features.security
        $trusted_urls = ($xcart_http_host == $xcart_https_host ? array($xcart_http_host) : array($xcart_http_host, $xcart_https_host));
        foreach($trusted_urls as $url) {
            $this->trusted_uri[] = '#https?://.*' . $url . '$#i';
        }

        // To disable access to all static classes set $static_classes = null.
        $this->static_classes = array(
            'XCTaxesDefs'
        );

        $this->php_functions = array(
            'array', 'list',
            'isset', 'empty',
            'count', 'sizeof',
            'in_array', 'is_array',
            'true', 'false', 'null',
        );

        $this->php_modifiers = array(
            'count',
            'doubleval',
            'trim',
            'stripslashes',
            'mt_rand',
            'urlencode',
            'is_array','nl2br',
        );

        if (defined('DEVELOPMENT_MODE')) {
            array_push($this->php_modifiers, 'print_r');
            array_push($this->php_modifiers, 'func_print_r');
        }

        $this->allow_php_tag = false;
        $this->php_handling = Smarty::PHP_PASSTHRU;

        // For $smarty.cookies.robot
        $this->allow_super_globals = true;

        $this->allow_constants = true;
    }//}}}
}

class XC_Dev_Smarty_Security extends XC_Smarty_Security {
    public function isTrustedStaticClass($class_name, $compiler)
    {
        if (!class_exists($class_name)) {
            $compiler->trigger_template_error("access to undefined static class '{$class_name}' not allowed by security setting");
            return false;
        }

        return parent::isTrustedStaticClass($class_name, $compiler);
    }
}

class XCTplFilters {
    public static function addDeferResources($output, $smarty) {//{{{

        if ($defer_resources = XCTplDeferResource::getInstance()->getAll()) {
            $output = preg_replace(
                '/<\/head>/Ss',
                implode("\n", $defer_resources) . "\n" . '</head>',
                $output
            );
        }

        return $output;

    }//}}}
}

class XCTplDeferResource extends XC_Singleton {
    protected $deferResources;

    public static function getInstance() { // {{{
        return parent::getClassInstance(__CLASS__);
    } // }}}

    public function registerCss($file) {//{{{
        global $smarty, $xcart_dir;

        is_callable('smarty_function_load_defer') || (include $xcart_dir . '/include/templater/plugins/function.load_defer.php');

        $result = smarty_function_load_defer(
            array(
                'file' => $file,
                'type' => 'css',
            ),
            $smarty
        );

        if ($result) {
            $this->deferResources[] = $result;
        }

    }//}}}

    public function getAll() {//{{{
        return $this->deferResources;
    }//}}}
}

?>
