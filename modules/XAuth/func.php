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
 * Functions
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v44 (xcart_4_7_7), 2017-01-23 20:12:10, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

if (empty($active_modules['XAuth'])) {
    return;
}

$_path = $xcart_dir . '/modules/XAuth/services/' . $config['XAuth']['xauth_service'] . '/func.php';
if (file_exists($_path)) {
    require_once $_path;
}

function func_xauth_get_user($service, $provider, $id, $profile = NULL)
{
    global $sql_tbl, $config;

    $user = func_xauth_select_user_by_identifier($id, $service, $provider);

    // Search in another providers if 'id' is email or URL
    if (
        !$user
        && (preg_match('/' . func_email_validation_regexp() . '/Ss', $id) || is_url($id))
    ) {
        $user = func_xauth_select_user_by_identifier($id);
    }

    if (
        !$user
        && is_array($profile)
        && isset($profile['email'])
        && $profile['email']
        && 'Y' == $config['XAuth']['xauth_login_by_email']
        && !in_array(x_get_area_type(), array('A','P'))
    ) {
        x_load('user'); // For XCUserSql
        $user = func_query_first(
            'SELECT *'
            . ' FROM ' . $sql_tbl['customers']
            . ' WHERE email = "' . addslashes($profile['email']) . '"'
            . ' AND usertype = "' . func_xauth_get_area_type() . '"'
            . ' AND ' . XCUserSql::getSqlRegisteredCond()
            . ' LIMIT 1'
        );
    }

    return $user;
}

function func_xauth_select_user_by_identifier($id, $service = NULL, $provider = NULL)
{ // {{{
    global $sql_tbl, $encryption_types;

    if (empty($id)) {
        assert('FALSE /* '.__FUNCTION__.': Empty $id-identifier*/');
        return array();
    }
    
    assert('in_array("B", $encryption_types) /* '.__FUNCTION__.': Change encryption_condition condition!*/');
    $encryption_condition = array("x.identifier LIKE 'B%'");
    $encryption_condition = empty($encryption_condition) ? '' : ' AND (' . implode(' OR ', $encryption_condition) . ')';

    $matched_id_type = 'crypted';
    foreach (array('plain', 'crypted') as $id_type) {
        $limit = ($id_type == 'plain' ? ' LIMIT 1' : ' ');
        $users = func_query(
            'SELECT c.*, x.identifier, x.auth_id'
            . ' FROM ' . $sql_tbl['customers'] . ' as c'
            . ' INNER JOIN ' . $sql_tbl['xauth_user_ids'] . ' as x'
            . ' ON c.id = x.id AND c.usertype = "' . func_xauth_get_area_type() . '"'
            . ($id_type == 'crypted' ? $encryption_condition : ' AND x.identifier = "' . addslashes($id) . '"')
            . (is_null($service) ? ' ' : ' AND x.service = "' . addslashes($service) . '"')
            . (is_null($provider) ? ' ' : ' AND x.provider = "' . addslashes($provider) . '"')
            . $limit
        );

        if (
            !empty($users)
            && is_array($users)
        ) {
            $matched_id_type = $id_type;
            break;
        }
    }

    if ($matched_id_type == 'crypted') {
        $result = array();
        if (!empty($users)) {
            x_load('crypt');

            foreach ($users as $user) {
                if (
                    func_get_crypt_type($user['identifier'])
                    && text_verify($id, text_decrypt($user['identifier']))
                ) {
                    $result = $user;
                    break;
                }
            }

            // Change crypted identifier to plain for customers
            if (
                !empty($result)
                && !in_array($result['usertype'], array('A','P'))
            ) {
                db_query("UPDATE $sql_tbl[xauth_user_ids] SET identifier='" . addslashes($id) . "' WHERE auth_id='$result[auth_id]'");
                func_xauth_update_signature($result['auth_id']);
            }
        }
    } else {
        // Plain identifier is matched
        $result = $users[0];
    }

    func_unset($result, 'identifier', 'auth_id');

    return $result;

} // }}}

function func_xauth_login($service, $provider, $id, $profile, $address, &$error)
{
    global $config, $sql_tbl, $active_modules;

    $created = FALSE;

    // Detect by server + provider + id
    $user = func_xauth_get_user($service, $provider, $id);

    // Detect by email
    if (
        !$user
        && isset($profile['email'])
        && $profile['email']
        && 'Y' == $config['XAuth']['xauth_login_by_email']
        && !in_array(x_get_area_type(), array('A','P'))
    ) {
        x_load('user'); // For XCUserSql
        $users = func_query(
            'SELECT *'
            . ' FROM ' . $sql_tbl['customers']
            . ' WHERE email = "' . addslashes($profile['email']) . '"'
            . ' AND usertype = "' . func_xauth_get_area_type() . '"'
            . ' AND ' . XCUserSql::getSqlRegisteredCond()
            . ' AND status = "Y"'
        );

        if (1 < count($users)) {
            $error = 'email_multiple';
            return $user;

        } elseif ($users) {

            $user = reset($users);

            func_xauth_link_identifier(
                $user['id'],
                array(
                    'service'    => $service,
                    'provider'   => $provider,
                    'identifier' => $id,
                )
            );
            $error = 'email_link';
        }
    }

    // Create new account
    if (!$user && func_xauth_check_create_user_allow()) {
        $create_error = FALSE;
        $user = func_xauth_create_user($service, $provider, $id, $profile, $address, $create_error);
        if ($create_error) {
            $error = $create_error;
        }
        $created = TRUE;
    }

    // Login
    if ($user) {
        if (!func_xauth_check_login_user_allow($user)) {

            // User is forbid for log-in in current area
            $user = NULL;
            $error = 'login_forbid';

        } elseif (!func_xauth_check_login_user_status($user)) {

            // User is disabled or anonymous
            $user = NULL;
            $error = 'login_disabled';

        } elseif (!$created || 'Y' == $config['XAuth']['xauth_auto_login']) {

            // Auto-login
            func_xauth_login_user($user);

            if (
                $user['usertype'] == 'C'
                && !empty($user['id'])
            ) {
                x_load('cart');
                func_restore_serialized_cart($user['id']);
            }

        } else {

            // Delayed login
            $error = 'login_delayed';
            $user = NULL;
        }

    } elseif (!$error) {
        $error = 'not_found';
    }

    return $user;
}

function func_xauth_create_user($service, $provider, $id, $profile, $address, &$error)
{
    global $config, $mail_smarty, $shop_language, $active_modules, $sql_tbl, $xcart_dir;

    if (!func_xauth_profile_is_completed($profile)) {
        x_log_add(
            'xauth',
            func_get_langvar_by_name('lbl_xauth_user_cannot_create_email', NULL, FALSE, TRUE, TRUE)
        );

        return FALSE;
    }

    x_load('crypt',
    'user'); // For XCUserSql

    if (!isset($profile['username'])) {
        $profile['username'] = $profile['email'];
    }

    $profile['login']    = 'Y' == $config['email_as_login'] ? $profile['email'] : $profile['username'];
    $profile['usertype'] = func_xauth_get_area_type();
    $profile['language'] = $shop_language;
    $profile['password'] = text_crypt(text_hash(func_xauth_generate_password()));
    $profile['status']   = 'Y';
    $profile['change_password_date'] = 0;

    $profile = func_addslashes($profile);

    // Check email + usertype unique
    $userIsExists = func_query_first_cell(
        'SELECT COUNT(*) FROM ' . $sql_tbl['customers']
        . ' WHERE email = "' . $profile['email'] . '"'
        . ' AND usertype = "' . $profile['usertype'] . '"'
        . ' AND ' . XCUserSql::getSqlRegisteredCond()
    );
    if (0 < $userIsExists) {
        x_log_add(
            'xauth',
            func_get_langvar_by_name(
                'lbl_xauth_user_cannot_create_email_duplicate',
                NULL,
                FALSE,
                TRUE,
                TRUE
            )
        );

        return FALSE;
    }

    // Check login unique
    $userIsExists = func_query_first_cell(
        'SELECT COUNT(*) FROM ' . $sql_tbl['customers']
        . ' WHERE login = "' . $profile['login'] . '"'
        . ' AND ' . XCUserSql::getSqlRegisteredCond()
    );
    if (0 < $userIsExists) {
        x_log_add(
            'xauth',
            func_get_langvar_by_name(
                $config['email_as_login']
                    ? 'lbl_xauth_user_cannot_create_email_duplicate'
                    : 'lbl_xauth_user_cannot_create_username_duplicate',
                NULL,
                FALSE,
                TRUE,
                TRUE
            )
        );

        if (!$config['email_as_login']) {
            $error = 'login_dup';
        }

        return FALSE;
    }

    // Create user
    $newuserid = func_array2insert(
        'customers',
        $profile
    );

    // Insert link to external auth id
    func_xauth_link_identifier(
        $newuserid,
        array(
            'service'    => $service,
            'provider'   => $provider,
            'identifier' => $id,
        )
    );

    // Add address
    if ($address) {
        $address['userid'] = $newuserid;
        $address['default_s'] = 'Y';
        $address['default_b'] = 'Y';

        $address = func_addslashes($address);

        $result = func_check_address($address, $profile['usertype']);
        if (empty($result['errors'])) {
            func_save_address($newuserid, 0, $address);
        }
    }

    // Email notifications
    x_load('mail');

    $newuser_info = func_userinfo($newuserid, $profile['usertype'], FALSE, NULL, 'C', FALSE);
    $mail_smarty->assign('userinfo', $newuser_info);
    $mail_smarty->assign('full_usertype', func_get_langvar_by_name('lbl_customer'));
    $mail_smarty->assign('password_reset_key', func_add_password_reset_key($newuser_info['id']));
    $mail_smarty->assign('userpath', func_get_usertype_dir($newuser_info['usertype']));

    $to_customer = $newuser_info['language'];

    func_send_mail(
        $newuser_info['email'],
        'mail/signin_notification_subj.tpl',
        'mail/signin_notification.tpl',
        $config['Company']['users_department'],
        FALSE
    );

    // Send mail to customers department
    if ('Y' == $config['Email_Note']['eml_signin_notif_admin']) {
        func_send_mail(
            $config['Company']['users_department'],
            'mail/signin_admin_notif_subj.tpl',
            'mail/signin_admin_notification.tpl',
            $profile['email'],
            TRUE
        );
    }

    require_once $xcart_dir . '/include/classes/class.XCSignature.php';
    $obj = new XCUserSignature($newuser_info);
    $obj->updateSignature();

    return $newuser_info;
}

function func_xauth_generate_password($length = 12)
{
    $vowels = 'aeuyAEUY';
    $consonants = 'bdghjmnpqrstvzBDGHJLMNPQRSTVWXZ23456789';
 
    $password = '';
    $alt = XC_TIME % 2;

    $vowelsLength = strlen($vowels);
    $consonantsLength = strlen($consonants);

    for ($i = 0; $i < $length; $i++) {
        $password .= 1 == $alt
            ? $consonants[(mt_rand() % $consonantsLength)]
            : $vowels[(mt_rand() % $vowelsLength)];
        $alt = 1 - $alt;
    }

    return $password;
}

function func_xauth_login_user($user)
{
    global $identifiers, $login_by_xauth;

    x_load('user');

    $res = func_authenticate_user($user['id']);

    x_session_register('identifiers', array());

    $identifiers[$user['usertype']] = array(
        'login'      => $user['login'],
        'login_type' => $user['usertype'],
        'userid'     => $user['id'],
    );

    x_session_register('login_by_xauth');

    $login_by_xauth = TRUE;

    return $res;
}

function func_xauth_prepare_register($params, $smarty)
{
    global $sql_tbl, $config, $logged_userid;
    
    $userid = x_get_template_var_by_path('userinfo.id', $smarty);

    if (
        !is_null($userid)
        && !empty($userid)
        && ($logged_userid == $_GET['user'] || !$_GET['user'])
        && x_check_controller_condition(NULL, array('register', 'user_modify'))
    ) {
        if ('C' != x_get_area_type()) {

            $smarty->assignGlobal('xauth_register_displayed', TRUE);
        }

        $ids = func_xauth_get_user_social_ids($userid);

        if ($ids) {
            $smarty->assignGlobal('xauth_ids', $ids);
        }
    }

    x_session_register('saved_xauth_data');
    global $saved_xauth_data;
    if ($saved_xauth_data) {

        $smarty->assignGlobal('xauth_saved_data', $saved_xauth_data);
        $saved_xauth_data = NULL;
    }
}

function func_xauth_get_user_social_ids($userid)
{
    global $sql_tbl;

    if (empty($userid)) {

        return FALSE;
    }

    return func_query(
        'SELECT auth_id, id, service, provider, identifier FROM ' . $sql_tbl['xauth_user_ids']
        . ' WHERE id = \'' . intval($userid) . '\''
    );
}

function func_xauth_prepare_register_link()
{
    global $smarty, $sql_tbl, $config, $login;

    if (!$login) {
        // Link display was disabled due to multiple customer requests
        $smarty->assign('xauth_register_link_displayed', $config['XAuth']['xauth_display_sign_in_link']);
    }
}

function func_xauth_prepare_checkout_link()
{
    global $smarty, $login, $config;

    if (!$login) {
        // Link display was disabled due to multiple customer requests
        $smarty->assign('xauth_checkout_link_show', $config['XAuth']['xauth_display_sign_in_link']);
    }
}

function func_xauth_profile_is_completed($profile)
{
    x_load('user');

    $completed = FALSE;

    if (is_array($profile)) {

        $additional_fields = func_get_additional_fields('C', 0);
        $default_fields = func_get_default_fields('C');

        $completed = TRUE;

        foreach ($default_fields as $k => $v) {
            if (
                'Y' == $v['required']
                && (!isset($profile[$k]) || empty($profile[$k]))
            ) {
                $completed = FALSE;
                break;
            }
        }

        if ($additional_fields && $completed) {
            foreach ($additional_fields as $v) {
                if ('Y' == $v['required']) {
                    $completed = FALSE;
                    break;
                }
            }
        }

        $completed = $completed
            && isset($profile['email'])
            && is_string($profile['email'])
            && preg_match('/' . func_email_validation_regexp() . '/Ss', $profile['email']);

    }

    return $completed;
}

function func_xauth_link_identifier_callback($userid)
{
    if (isset($_POST['xauth_identifier']) && $_POST['xauth_identifier'] && is_array($_POST['xauth_identifier'])) {
        func_xauth_link_identifier($userid, func_stripslashes($_POST['xauth_identifier']));
    }
}

function func_xauth_unload_saved_xcauth_data()
{
    if (isset($_POST['xauth_identifier'])) {
        x_session_register('saved_xauth_data');

        global $saved_xauth_data;

        $saved_xauth_data = func_stripslashes($_POST['xauth_identifier']);
    }
}

function func_xauth_update_signature($auth_id) { //{{{
    global $xcart_dir, $sql_tbl;

    require_once $xcart_dir . '/include/classes/class.XCSignature.php';
    $user_data = func_query_first("SELECT " . XCUserXauthIdsSignature::getSignedFields() . " FROM $sql_tbl[customers] INNER JOIN $sql_tbl[xauth_user_ids] ON $sql_tbl[customers].id=$sql_tbl[xauth_user_ids].id AND $sql_tbl[xauth_user_ids].auth_id='$auth_id'");
    $obj_user = new XCUserXauthIdsSignature($user_data);
    $obj_user->updateSignature();

    return TRUE;
} //}}}

function func_xauth_link_identifier($userid, $identifier = '')
{
    global $sql_tbl, $xcart_dir;

    if (empty($identifier)) {

        $identifier = $_POST['xauth_identifier'];
    }

    if (empty($identifier['identifier'])) {
        assert('FALSE /* '.__FUNCTION__.': Empty $identifier[identifier] for auth xauth_user_ids table*/');
        return FALSE;
    }

    require_once $xcart_dir . '/include/classes/class.XCSignature.php';
    $is_crypt_applicable = (func_query_first_cell("SELECT COUNT(id) FROM $sql_tbl[customers] WHERE id='$userid' AND " . XCUserXauthIdsSignature::getApplicableSqlCondition()) > 0);
    if ($is_crypt_applicable) {
        x_load('crypt');
        if (
            func_get_crypt_type($identifier['identifier']) != 'B'
            || !text_decrypt($identifier['identifier'])
        ) {
            $identifier['identifier'] = text_crypt(text_hash($identifier['identifier']));
        }
    }

    $update_data = array(
        'id'         => $userid,
        'service'    => addslashes($identifier['service']),
        'provider'   => addslashes($identifier['provider']),
        'identifier' => addslashes($identifier['identifier']),
    );

    $auth_id = func_array2insert(
        'xauth_user_ids',
        $update_data
    );

    if ($is_crypt_applicable) {
        func_xauth_update_signature($auth_id);
    }

    return $auth_id;
}

function func_xauth_check_create_user_allow()
{
    global $config;
    
    return 'Y' == $config['XAuth']['xauth_create_profile']
        && 'C' == x_get_area_type();
}

function func_xauth_check_login_user_allow($user)
{
    global $active_modules;

    $ap = array('A', 'P');

    return $user['usertype'] == x_get_area_type()
        || (!empty($active_modules['Simple_Mode']) && in_array($user['usertype'], $ap) && in_array(x_get_area_type(), $ap));
}

function func_xauth_check_login_user_status($user)
{
    return 'Y' == $user['status'];
}

function func_xauth_is_show_login($areaType = NULL)
{
    global $active_modules, $sql_tbl;

    if (!$areaType)  {
        $areaType = x_get_area_type();
    }

    $sql = 'SELECT c.id'
        . ' FROM ' . $sql_tbl['customers'] . ' as c'
        . ' INNER JOIN ' . $sql_tbl['xauth_user_ids'] . ' as x'
        . ' ON c.id = x.id';

    if (isset($active_modules['Simple_Mode']) && in_array($areaType, array('A', 'P'))) {
        $sql .= ' WHERE c.usertype IN ("A", "P")';

    } else {
        $sql .= ' WHERE c.usertype = "' . $areaType . '"';
    }

    $sql .= ' LIMIT 1';

    return func_query_first_cell($sql) || func_xauth_check_create_user_allow();
}

function func_xauth_is_configured()
{
    global $config;

    $function_name = 'func_xauth_' . $config['XAuth']['xauth_service'] . '_is_configured';

    return !function_exists($function_name) || $function_name();
}

function func_xauth_get_accounts_icons()
{
    global $config, $smarty;

    $function_name = 'func_xauth_' . $config['XAuth']['xauth_service'] . '_get_accounts';

    if (function_exists($function_name)) {
        $allowed_accounts = $function_name();

    } else {
        $allowed_accounts = array(
            'openid'   => 'OpenID',
        );
    }

    $xauth_rpx_accounts = array();
    foreach ($allowed_accounts as $ext_source => $ext_source_name) {
        $xauth_rpx_accounts[] = '<a class="xauth-account xauth-acc-' . $ext_source . '" title="' . $ext_source_name. '" href="javascript:void(0);" onclick="javascript: xauthTogglePopup(this);"><img src="' . x_get_template_var('ImagesDir', $smarty) . '/spacer.gif" alt="" /></a>';
    }

    return implode('', $xauth_rpx_accounts);
}

function func_xauth_get_area_type()
{
    global $active_modules;

    return (!empty($active_modules['Simple_Mode']) && 'A' == x_get_area_type())
        ? 'P'
        : x_get_area_type();
}

function func_xauth_rpx_icon_available($params)
{
    global $smarty;

    $available_icons = array(
        'facebook',
        'twitter',
        'myspace',
        'live',
        'linkedin',
        'paypal',
        'google',
        'yahoo',
        'aol',
        'openid',
        'blogger',
        'flickr',
        'hyves',
        'lj',
        'myopenid',
        'netlog',
        'wp'
    );

    if (!empty($params['assign'])) {

        $smarty->assign($params['assign'], (in_array($params['prov'], $available_icons) ? TRUE : FALSE));

        return '';

    } else {

        return in_array($params['prov'], $available_icons) ? TRUE : FALSE;
    }
}

function func_xauth_clear_login_data()
{
    x_session_unregister('saved_xauth_data');
    x_session_unregister('login_by_xauth');
}

function func_xauth_process_login_error($error)
{
    global $config, $saved_xauth_data;

    x_session_register('saved_xauth_data');

    if (
        $config['email_as_login'] == 'Y'
        && is_array($saved_xauth_data)
        && !empty($saved_xauth_data)
    ) {
        $errors[] = array(
            'fields'    => array('email'),
            'error'     => func_get_langvar_by_name('txt_xauth_email_already_exists')
        );

    } else {
        
        $error[] = func_reg_error(1);
    }

    return $error;
}

function func_xauth_register_php_hook($login)
{
    global $saved_xauth_data, $login_by_xauth, $smarty, $REQUEST_METHOD, $show_antibot_arr, $xauth_identifier, $passwd1, $passwd2;

    x_session_register('saved_xauth_data');
    x_session_register('login_by_xauth');

    if (!isset($passwd1)) {

        $passwd1 = '';
    }

    if (!isset($passwd2)) {

        $passwd2 = '';
    }

    if (empty($login)) {

        if (
            is_array($saved_xauth_data)
            && !empty($saved_xauth_data)
        ) {
            $show_antibot_arr['on_registration'] = 'N';
            x_set_template_var_by_path('show_antibot.on_registration', 'N', $smarty);

            $smarty->assign('is_from_xauth', 'Y');
        }

        if (
            $REQUEST_METHOD == 'POST'
            && !empty($xauth_identifier)
            && $xauth_identifier == $saved_xauth_data
        ) {
            $passwd1 = $passwd2 = func_xauth_generate_password();
        }

    } elseif (TRUE === $login_by_xauth) {

        $smarty->assign('is_from_xauth', 'Y');
    }

    return array($passwd1, $passwd2);
}

function func_xauth_get_rpc_token_url($page_view_mode='popup')
{//{{{
    global $XCART_SESSION_NAME, $XCARTSESSID, $xcart_catalogs;

    if ('A' == x_get_area_type()) {
        $base = $xcart_catalogs['admin'];

    } elseif ('P' == x_get_area_type()) {
        $base = $xcart_catalogs['provider'];

    } elseif ('B' == x_get_area_type()) {
        $base = $xcart_catalogs['partner'];

    } else {
        $base = $xcart_catalogs['customer'];
    }

    return $base . '/xauth_return_rpx.php?' . $XCART_SESSION_NAME . '=' . $XCARTSESSID . ($page_view_mode == 'standalone' ? '&is_standalone_login_page=1' : '');
}//}}}
