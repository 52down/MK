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
|                                                                             |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

/**
 * Functions of the Segment module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ildar Amankulov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v10 (xcart_4_7_7), 2017-01-23 20:12:10, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header('Location: ../'); die('Access denied'); }

class XCSegmentTrack {

    public static function smartyAssignProductEvents()
    { // {{{
        global $smarty, $config;

        if ($config['Appearance']['display_product_tabs'] != 'Y' || empty($smarty)) {
            return false;
        }

        $config_names = array(
            'segment_t_product_xmagnifier' => array('event_name' => 'Magnifier More views jump', 'anchor_link'=>'xmagnifier'),
            'segment_t_product_special_offers' => array('event_name' => 'Special offers jump', 'anchor_link'=>'soffers'),
            'segment_t_product_send2friend' => array('event_name' => 'Send to friend jump', 'anchor_link'=>'send2friend'),
            'segment_t_product_dpimages' => array('event_name' => 'Detailed images jump', 'anchor_link'=>'dpimages'),
            'segment_t_product_relateds' => array('event_name' => 'Related products jump', 'anchor_link'=>'related'),
            'segment_t_product_recommends' => array('event_name' => 'Customers also bought jump', 'anchor_link'=>'recommends'),
            'segment_t_product_feedback' => array('event_name' => 'Customer feedback jump', 'anchor_link'=>'feedback')
        );

        foreach ($config_names as $name=>$item) {
            if ($config['Segment'][$name] != 'Y') {
                unset($config_names[$name]);
            }
        }

        $smarty->assign('segment_product_tabs2track', $config_names);
    } // }}}

    public static function isAddToCartEvent()
    { // {{{
        global $productid, $mode, $config;

        return
            $config['Segment']['segment_t_added_product'] == 'Y'
            && strpos($_SERVER['PHP_SELF'], 'cart.php') !== false
            && !empty($mode) && $mode == 'add'
            && !empty($productid)
            && !func_is_ajax_request();
    } // }}}

    public static function trackAddedProduct($productid, $amount)
    { // {{{
        global $sql_tbl, $config;

        if (!self::initSegmentLib()) {
            return false;
        }

        $tbl_products_lng = $sql_tbl['products_lng_' . $config['default_admin_language']];
        $data = func_query_first("SELECT lng.product, p.productcode FROM $tbl_products_lng lng INNER JOIN $sql_tbl[products] p USING(productid) WHERE p.productid= " . intval($productid));

        Analytics::track(array_merge(array(
          'event' => 'Added Product',
          'properties' => array(
            'id' => $productid,
            'sku' => $data['productcode'],
            'name' => $data['product'],
            'quantity' => $amount
          )
        ), self::getUserId()));

    } // }}}

    public static function isUpdatedInCartEvent()
    { // {{{
        global $action, $config, $productindexes;

        return
            $config['Segment']['segment_t_updated_product'] == 'Y'
            && strpos($_SERVER['PHP_SELF'], 'cart.php') !== false
            && !empty($action) && $action == 'update'
            && !empty($productindexes)
            && !func_is_ajax_request();
    } // }}}

    public static function trackUpdatedProduct($productindexes)
    { // {{{
        global $config, $cart;

        x_session_register('cart');
        if (
            empty($cart['products'])
            || !self::initSegmentLib()
        ) {
            return false;
        }

        foreach ($productindexes as $_cartid => $new_quantity) {

            foreach ($cart['products'] as $k => $v) {

                if ($v['cartid'] == $_cartid) {
                    $changed = $new_quantity - $v['amount'];
                    $data = array_merge(array(
                      'event' => $changed > 0 ? 'Increased Product' : (empty($new_quantity) ? 'Removed Product' : 'Descreased Product'),
                      'properties' => array(
                        'id' => $v['productid'],
                        'sku' => $v['productcode'],
                        'name' => $v['product'],
                        'quantity' => $changed
                      )
                    ), self::getUserId());

                    Analytics::track($data);
                    break;
                }

            }

        }


    } // }}}

    public static function isRemovedToCartEvent()
    { // {{{
        global $mode, $config, $productindex;

        return
            $config['Segment']['segment_t_removed_product'] == 'Y'
            && strpos($_SERVER['PHP_SELF'], 'cart.php') !== false
            && !empty($mode) && (
                $mode == 'delete' && !empty($productindex)
                || $mode == 'clear_cart'
            )
            && !func_is_ajax_request();
    } // }}}

    public static function trackRemovedProduct($mode, $productindex = null)
    { // {{{
        global $config, $cart;

        x_session_register('cart');
        if (
            empty($cart['products'])
            || !self::initSegmentLib()
        ) {
            return false;
        }

        $productindexes = array();
        if ($mode == 'clear_cart') {
            foreach ($cart['products'] as $k => $v) {
                $productindexes[$v['cartid']] = 1;
            }
        } elseif(!is_null($productindex)) {
            $productindexes[$productindex] = 1;
        }

        foreach ($productindexes as $_cartid => $new_quantity) {
            foreach ($cart['products'] as $k => $v) {
                if ($v['cartid'] == $_cartid) {
                    $data = array_merge(array(
                      'event' => 'Removed Product',
                      'properties' => array(
                        'id' => $v['productid'],
                        'sku' => $v['productcode'],
                        'name' => $v['product'],
                        'quantity' => -$v['amount']
                      )
                    ), self::getUserId());

                    Analytics::track($data);
                    break;
                }
            }
        }
    } // }}}

    public static function isLoggedInEvent()
    { // {{{
        global $password, $username, $mode, $config;

        return
            $config['Segment']['segment_t_logged_in'] == 'Y'
            && strpos($_SERVER['PHP_SELF'], 'login.php') !== false
            && !empty($mode) && $mode == 'login'
            && !empty($password)
            && !empty($username);
    } // }}}

    public static function trackLoggedIn($username)
    { // {{{
        global $active_modules, $sql_tbl;


        $current_area = defined('AREA_TYPE') ? AREA_TYPE : 'C';
        $usertype = ($current_area == 'A' && !empty($active_modules['Simple_Mode']))
            ? 'P'
            : $current_area;

        $usertype = $usertype ?: 'C';


        x_load('user');
        $user_data = func_query_first("SELECT id,email, firstname, lastname, usertype FROM $sql_tbl[customers] WHERE login='$username' AND usertype='$usertype' AND " . XCUserSql::getSqlRegisteredCond());//segment_compatible from xcart_4_6_4

        if (
            empty($user_data)
            || !self::initSegmentLib()
        ) {
            return false;
        }

        Analytics::track(array(
          'userId' => $user_data['id'],//segment_compatible
          'event' => 'Logged In',
          'properties' => array(
            'email' => $user_data['email'],
            'firstname' => $user_data['firstname'],
            'lastname' => $user_data['lastname'],
            'usertype' => $user_data['usertype']
          )
        ));

    } // }}}

    public static function isLoggedOffEvent()
    { // {{{
        global $mode, $config;

        return
            $config['Segment']['segment_t_logged_off'] == 'Y'
            && strpos($_SERVER['PHP_SELF'], 'login.php') !== false
            && !empty($mode) && $mode == 'logout';
    } // }}}

    public static function trackLoggedOff()
    { // {{{
        global $sql_tbl, $logged_userid;

        x_session_register('logged_userid');//segment_compatible

        $user_data = func_query_first("SELECT id,email, firstname, lastname, usertype FROM $sql_tbl[customers] WHERE id='$logged_userid'");//segment_compatible

        if (
            empty($user_data)
            || !self::initSegmentLib()
        ) {
            return false;
        }

        Analytics::track(array(
          'userId' => $logged_userid,
          'event' => 'Logged Off',
          'properties' => array(
            'email' => $user_data['email'],
            'firstname' => $user_data['firstname'],
            'lastname' => $user_data['lastname'],
            'usertype' => $user_data['usertype']
          )
        ));

    } // }}}

    protected static function initSegmentLib()
    {//{{{
        global $config, $xcart_dir;
        require $xcart_dir . '/modules/Segment/lib/Segment.php';
        class_alias('Segment', 'Analytics');
        try {
            Analytics::init($config['Segment']['segment_write_key']);
        } catch (Exception $exception) {

            $pretty_trace = array();
            $trace = $exception->getTrace();

            if (is_array($trace) && !empty($trace)) {
                foreach ($trace as $item) {
                    if (!empty($item['file']))
                        $pretty_trace[] = $item['file'].':'.$item['line'];
                }
            }

            func_error_handler($exception->getCode() ?: 1, $exception->getMessage(), $exception->getFile(), $exception->getLine(), '', $pretty_trace);
            return false;
        }

        return true;
    }//}}}

    protected static function getUserId()
    {//{{{
        global $logged_userid, $XCARTSESSID;
        x_session_register('logged_userid'); //segment_compatible

        if (empty($logged_userid)) {
            x_load('user');
            $data = func_get_anonymous_userinfo();
            $id = empty($data['email']) ? '' : $data['email'];
        } else {
            $id = $logged_userid;
        }

        if (empty($id)) {
            $res = array('anonymousId' => function_exists('hash') ? hash('sha512', $XCARTSESSID) : sha1(md5($XCARTSESSID)));
        } else {
            $res = array('userId' => $id);
        }

        return $res;
    }//}}}
}

/*
* dynamically add {include file="modules/Segment/analytics* calls to customer tpls
*/
function Smarty_prefilter_add_segment_entry_points($source, $smarty)
{//{{{
    global $xcart_dir;
    static $is_called ;

    if (!empty($is_called)) {
        return $source;
    }
    $is_called = 1;

    require $xcart_dir . XC_DS . 'modules' . XC_DS . 'Segment' . XC_DS . 'lib' . XC_DS . 'dynamic_tpl_patcher.php';//segment_compatible; conflict with xcart/modules/XAuth/ext.core.php <=4.7.3
    modules\Segment\lib\x_tpl_add_callback_patch('customer/service_js.tpl', 'func_segment_tpl_patch_service_js', modules\Segment\lib\X_TPL_PREFILTER);
    modules\Segment\lib\x_tpl_add_callback_patch('customer/service_head.tpl', 'func_segment_tpl_patch_service_head', modules\Segment\lib\X_TPL_PREFILTER);
    modules\Segment\lib\x_tpl_add_callback_patch('customer/service_body_js.tpl', 'func_segment_tpl_patch_service_body_js', modules\Segment\lib\X_TPL_PREFILTER);

    return $source;
}//}}}

function func_segment_tpl_patch_service_js($tpl_name, $tpl_source)
{//{{{
    global $xcart_dir;

    if (strpos($tpl_source, 'active_modules.Segment') !== false) {
        return $tpl_source;
    }

    // add call {include file="modules/Segment/analytics_js.tpl #lintoff
    $tpl_source .=<<<EOT
        {* Segment hunk start*}
        {if \$active_modules.Segment ne '' and \$smarty.cookies.is_robot ne 'Y'}
            {include file="modules/Segment/analytics_js.tpl"}
        {/if}
        {* Segment hunk end*}
EOT;
    #linton

    func_segment_tpl_debug($tpl_name, $tpl_source);

    return $tpl_source;
}//}}}

function func_segment_tpl_patch_service_head($tpl_name, $tpl_source)
{//{{{
    global $xcart_dir;

    if (strpos($tpl_source, 'active_modules.Segment') !== false) {
        return $tpl_source;
    }

    $tpl_source = str_replace('{if $config.SEO.canonical eq \'Y\'', '{if $config.SEO.canonical eq \'Y\' or $active_modules.Segment', $tpl_source);#nolint

    func_segment_tpl_debug($tpl_name, $tpl_source);

    return $tpl_source;
}//}}}

function func_segment_tpl_patch_service_body_js($tpl_name, $tpl_source)
{//{{{
    global $xcart_dir;

    if (strpos($tpl_source, 'active_modules.Segment') !== false) {
        return $tpl_source;
    }

    $content = file_get_contents($xcart_dir . '/skin/common_files/modules/Segment/analytics_body_js.tpl');

    // add call {include file="modules/Segment/analytics_body_js.tpl #lintoff
    $snippet =<<<EOT
        {* Segment hunk start*}
        {if \$active_modules.Segment ne '' and \$smarty.cookies.is_robot ne 'Y'}
            $content
        {/if}
        {* Segment hunk end*}
EOT;

    if (!empty($content)) {
        $tpl_source = $tpl_source . $snippet;
    } #linton

    func_segment_tpl_debug($tpl_name, $tpl_source);

    return $tpl_source;
}//}}}

function func_segment_tpl_debug($tpl_name, $tpl_source)
{//{{{
    if (defined('XC_SEGMENT_DEBUG')) {
       x_log_add('segment_patched_files', 'patched_file:' . $tpl_name . "\n" . $tpl_source);
    }
}//}}}

function func_segment_init()
{//{{{
    global $config, $xcart_dir;
    global $productid, $amount, $productindexes, $mode, $productindex, $username, $smarty;

    $area = (defined('AREA_TYPE')) ? AREA_TYPE : '';

    if ($area == 'C') {
        // TODO move to endpoint
        XCSegmentTrack::smartyAssignProductEvents();
    }

    if ($area == 'C' && XCSegmentTrack::isAddToCartEvent()) {
        XCSegmentTrack::trackAddedProduct($productid, $amount);

    } elseif ($area == 'C' && XCSegmentTrack::isUpdatedInCartEvent()) {
        XCSegmentTrack::trackUpdatedProduct($productindexes);

    } elseif ($area == 'C' && XCSegmentTrack::isRemovedToCartEvent()) {
        XCSegmentTrack::trackRemovedProduct($mode, empty($productindex) ? null : $productindex);

    } elseif (XCSegmentTrack::isLoggedInEvent()) {
        XCSegmentTrack::trackLoggedIn($username);

    } elseif (XCSegmentTrack::isLoggedOffEvent()) {
        XCSegmentTrack::trackLoggedOff();
    }

    if (defined('QUICK_START') || $area != 'C') {
        return;
    }

    if (version_compare($config['version'], XC_SEGMENT_WITH_ENTRY_POINTS) < 0 && !defined('XC_SEGMENT_IS_IN_CORE') && !empty($smarty)) {
        if (version_compare($config['version'], '4.7.0') >= 0) {
            // Smarty_prefilter_add_segment_entry_points is called here
            $smarty->addAutoloadFilters(array('add_segment_entry_points'), 'pre');
        } else {
            Smarty_prefilter_add_segment_entry_points('', null);
        }
    }

}//}}}
