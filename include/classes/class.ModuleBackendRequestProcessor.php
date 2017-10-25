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
 * @author     Ildar Amankulov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    141c878b03b2b0cdd5d2b31c952f4e1031962148, v1 (xcart_4_7_8), 2017-05-18 15:44:49, class.ModuleBackendRequestProcessor.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

namespace XC\Module\Backend;

abstract class Defs {

    // <editor-fold desc="CONSTANTS" defaultstate="collapsed">
    const

        DISPLAY_TYPE_SELF = 'self',
        DISPLAY_TYPE_CUST = 'custom_template';
    // </editor-fold>

} //DEfs

abstract class RequestProcessor {

    protected $displayTemplate = '';
    protected $displayType = Defs::DISPLAY_TYPE_CUST;

    protected $sessionVars = array();
    protected $globalVars = array();
    protected $smartyVars = array();

    protected $requiredConfigVars = array();

    public static function processRequest($option='')
    { // {{{
        global $smarty, $REQUEST_METHOD, $controller_g, $module_namespaces_g;

        $namespace = isset($module_namespaces_g[$option]) ? $module_namespaces_g[$option] : '';
        $controllerClass = $namespace . \XCStringUtils::convertToCamelCase($controller_g);

        if (class_exists($controllerClass)) {

            $controllerInstance = new $controllerClass();

            $controllerInstance->mapGlobalVarsToProperties();
            $controllerInstance->mapSessionVarsToProperties();

            $smarty->assign('controller_g', $controller_g);

            switch ($REQUEST_METHOD) {
                case 'GET':
                    $controllerInstance->display(func_get_args());
                    break;
                case 'POST':
                    if (($opt_code = $controllerInstance->isConfigured()) !== true) {
                        // not all required options were configured
                        $controllerInstance->assignTopMessage($opt_code);
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
        return get_class($this);
    } // }}}

    protected function getShortControllerName()
    { // {{{
        return substr(strrchr($this->getControllerName(), '\\'), 1);
    } // }}}

    protected function getNavigationScript()
    { // {{{
        $option = $this->getModuleName();
        $controller = $this->getShortControllerName();
        return "configuration.php?option=$option&controller_g=$controller";
    } // }}}

    protected function mapGlobalVarsToProperties()
    { // {{{
        if (!empty($this->globalVars)) {
            foreach ($this->globalVars as $varName) {
                global ${$varName};
                $this->$varName = ${$varName};
            }
        }
    } // }}}

    protected function mapSessionVarsToProperties()
    { // {{{
        if (!empty($this->sessionVars)) {
            $class_name_wo_namespace = $this->getShortControllerName();
            foreach ($this->sessionVars as $varName) {
                $classVarName = static::registerSessionVar($varName, $class_name_wo_namespace);

                global ${$varName}, ${$classVarName};

                if (isset(${$varName})) {
                    ${$classVarName} = ${$varName};
                }

                $this->$varName = ${$classVarName};
            }
        }
    } // }}}

    protected function unregisterSelfSessionVars($className = null)
    { // {{{
        if (empty($this->sessionVars)) {
            return false;
        }
        $class_name_wo_namespace = is_null($className) ? $this->getShortControllerName() : $className;
        foreach ($this->sessionVars as $varName) {
            $classVarName = $class_name_wo_namespace . "_$varName";
            global ${$classVarName};
            x_session_unregister($classVarName);
        }

        return true;
    } // }}}

    protected function assignSmartyVars()
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

        $config = $this->getConfig()->getConfigAsObject();

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

    protected function assignTopMessage($_opt_code)
    { // {{{
        global $top_message;
        x_session_register('top_message');

        $top_message['content']
            = func_get_langvar_by_name (
                'msg_err_amazon_feeds_not_configured',
                array(
                    'oname' => func_get_langvar_by_name('opt_afds_' . $_opt_code),
                    'ocode' => $_opt_code
                )
            );
        $top_message['type'] = 'E';
    } // }}}

    protected function display()
    { // {{{
        global $smarty;

        $this->assignSmartyVars();

        $smarty->assign('navigation_script', $this->getNavigationScript());

        if ($this->displayType === Defs::DISPLAY_TYPE_SELF) {

            func_display($this->displayTemplate, $smarty);

            exit();
        }
        else {
            $smarty->assign('custom_admin_module_config_tpl_file', $this->displayTemplate);
        }
    } // }}}

    abstract protected function process();
    abstract protected function getModuleName();
}//REquestProcessor
