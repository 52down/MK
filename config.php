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
 * Configuration settings
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Customer interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v556 (xcart_4_7_7), 2017-01-23 20:12:10, config.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!defined('XCART_START')) { header("Location: index.php"); die("Access denied"); }

/**
 * SQL database details
 *
 * This section configures a connection between X-Cart shopping cart software
 * and your MySQL database. If X-Cart is installed using the Web installation, the
 * variables of this section are configured in the Installation Wizard. If you
 * installed X-Cart manually or, if after X-Cart has been installed your MySQL
 * server information changed, use this section to provide database access
 * information manually.
 * To show possible collations, run SHOW COLLATION LIKE '%your sql_charset%';
 * For example:
 * SHOW COLLATION LIKE '%utf8%';
 * SHOW COLLATION LIKE '%latin1%';
 *
 * $sql_host - DNS name or IP of your MySQL server;
 * $sql_db - MySQL database name;
 * $sql_user - MySQL user name;
 * $sql_password - MySQL password.
 * $sql_charset - Default character set used for database. DO NOT CHANGE THIS VALUE WITHOUT ACTUALLY CONVERTING YOUR DATABASE;
 * $sql_collation - Default set of rules for comparing characters in the character set. Can be changed any time to any supported collation
 *
 */
$sql_host = 'localhost';
$sql_db = 'mk';
$sql_user = 'root';
$sql_password = 'pass';
$sql_charset ='utf8';
$sql_collation ='utf8_general_ci';

/**
 * To avoid performance issues, limit the number of joins to a reasonable value
 */
define('SQL_MAX_JOIN_SIZE', 1000000);
define('SQL_BIG_SELECTS', 'ON');

/**
 * X-Cart HTTP & HTTPS host and web directory
 *
 * This section defines the location of your X-Cart installation. If X-Cart is
 * installed using Web installation, the variables of this section are
 * configured via the Installation Wizard. If you install X-Cart manually, use
 * this section to provide your web server details manually.
 *
 * $xcart_http_host - Host name of the server on which your X-Cart software is
 * to be installed;
 * $xcart_https_host - Host name of the secure server that will provide access
 * to your X-Cart-based store via the HTTPS protocol;
 * $xcart_web_dir - X-Cart web directory.
 *
 * NOTE:
 * The variables $xcart_http_host and $xcart_https_host must contain hostnames
 * ONLY (no http:// or https:// prefixes, no trailing slashes).
 *
 * Web dir is the directory where your X-Cart is installed as seen from the Web,
 * not the file system.
 *
 * Web dir must start with a slash and have no slash at the end. An exception to
 * this rule is when you install X-Cart in the site root, in which case you need
 * to leave the variable empty.
 *
 * EXAMPLE 1:
 * $xcart_http_host ="www.yourhost.com";
 * $xcart_https_host ="www.securedirectories.com/yourhost.com";
 * $xcart_web_dir ="/xcart";
 * will result in the following URLs:
 * http://www.yourhost.com/xcart
 * https://www.securedirectories.com/yourhost.com/xcart
 *
 * EXAMPLE 2:
 * $xcart_http_host ="www.yourhost.com";
 * $xcart_https_host ="www.yourhost.com";
 * $xcart_web_dir ="";
 * will result in the following URLs:
 * http://www.yourhost.com/
 * https://www.yourhost.com/
 */
$xcart_http_host = 'localhost';
$xcart_https_host = 'localhost';
$xcart_web_dir = '';

/**
 * Storing Customers' Credit Card Info
 * is completely removed from X-Cart.
 *
 * Storing Customers' Checking Account Details
 * still can be configured, please refer to constant
 * STORE_CHECKING_ACCOUNTS in XCSecurity class below.
 */

/**
 * Default images
 *
 * The variable $default_image defines which image file should be used as the
 * default "No image available" picture (a picture that will appear in the
 * place of any missing image in your X-Cart-based store if no other "No image
 * available"-type picture is defined for that case).
 */
$default_image = 'default_image.gif';

/**
 * The variable $shop_closed_file defines which HTML page should be displayed
 * to anyone trying to access the Customer zone of your store when the store is
 * closed for maintenance.
 */
$shop_closed_file = 'shop_closed.html';

/**
 * Single Store mode (X-Cart PRO only)
 *
 * The variable $single_mode allows you to enable/disable Single Store mode if
 * your store is based on X-Cart PRO. Single Store mode is an operation mode in
 * which your store represents a unified environment shared by multiple
 * providers in such a way that any provider can edit the products of the other
 * providers, and shipping rates, discounts, taxes, discount coupons, etc are
 * the same for all the providers.
 *
 * Admissible values for $single_mode are 'true' and 'false':
 * 'true' - enables Single Store mode;
 * 'false' - puts your store into normal mode where each of your providers can
 * control his own products only and can have shipping rates, discounts, taxes,
 * etc different from those of the other providers.
 *
 * NOTE:
 * If your store is based on X-Cart GOLD, $single_mode must be set to 'true' at
 * all times.
 */
$single_mode = true;

/**
 * Temporary directories
 */
$var_dirs = array (
    'var'             => $xcart_dir . '/var',
    'tmp'             => $xcart_dir . '/var/tmp',
    'templates_c'     => $xcart_dir . '/var/templates_c',
);

if (defined('UPGRADE_DIR_IS_REQUIRED')) {
    $var_dirs['upgrade'] = $xcart_dir . '/var/upgrade';
}

$var_dirs_web = array (
);

/**
 * Log directory
 *
 * The variable $var_dirs['log'] defines the location of the directory where X-Cart log
 * files are stored.
 */
$var_dirs['log'] = $xcart_dir . '/var/log';

/**
 * Cache directory
 *
 * The variable $var_dirs['cache'] defines the location of the directory where
 * X-Cart cache files are stored.
 */
$var_dirs['cache'] = $xcart_dir.'/var/cache';
$var_dirs['smarty_cache'] = $var_dirs['cache'] . '/smarty_cache';
$var_dirs['search_cache'] = $var_dirs['cache'] . '/search_cache';
$var_dirs['product_cache'] = $var_dirs['cache'] . '/product_cache';
$var_dirs_web['cache'] = '/var/cache';

/**
 * Export directory
 *
 * The variable $export_dir defines the location of X-Cart export directory
 * (a directory on X-Cart server to which the CSV files of export packs are
 * stored).
 */
$export_dir = $var_dirs['tmp'];

/**
 *
 * DO NOT CHANGE ANYTHING BELOW THIS LINE UNLESS
 * YOU REALLY KNOW WHAT YOU ARE DOING
 *
 *
 *
 *
 * Thresholds for time (in seconds) and memory (in bytes) limits
 * Initial values:
 * $x_time_threshold = 4 seconds
 * $x_mem_threshold = 4 * 1024 * 1024 = 4194304 byte
 */
$x_time_threshold = 4;
$x_mem_threshold = 4194304;

/**
 * Automatic repair of the broken indexes in mySQL tables
 */
$mysql_autorepair = true;

/**
 * Caching
 *
 * The constant USE_DATA_CACHE defines whether you want to use data caching in
 * your store.
 * Admissible values for USE_DATA_CACHE are 'true' and 'false'.
 * By default, the value of this constant is set to 'true'. You can set it to
 * 'false' if you experience problems using the store with caching enabled
 * (for example, if you get some kind of error regarding a file in the /var/cache
 * directory of your X-Cart installation).
 */
define('USE_DATA_CACHE', true);

define('DATA_CACHE_TTL', 24*3600);

define('USE_SQL_DATA_CACHE', false);

define('SQL_DATA_CACHE_TTL', 3600);

/**
 * Memcache routine
 * Defines whether you want to use memcache for data caching 
 * http://help.x-cart.com/index.php?title=X-Cart:Using_Memcached_with_X-Cart
 */
#define('USE_MEMCACHE_DATA_CACHE', true);
define('MEMCACHE_SERVER_ADDRESS', 'localhost');
define('MEMCACHE_SERVER_PORT', 11211);

abstract class XCPhysics { //{{{
    const OUNCES_PER_1LB = 16;
    const GRAMS_PER_1LB = 453.59237;
    const LBS_PER_1KG = 2.20462262;
    const OUNCES_PER_1KG = 35.2739619;
    const GRAMS_PER_1KG = 1000;
    const GRAMS_PER_1OUNCE = 28.3495231;

    const CM_PER_1INCH = 2.54;
} //}}} abstract class XCPhysics;

abstract class XCSecurity { //{{{

    /**
     * These options allows you to define the protection method for SQL/Security and file changes from the Admin area.
     * The possible values are "ip" and "file". To disable set them to FALSE.
     * Note: It is highly recommended to keep these options enabled!
     *
     * If you choose "ip" for your protection method, 
     *  access to the protected pages will be allowed only from specific ip addresses.
     * If you choose "file" for your protection method, 
     *  access to the protected pages will be allowed only after creating a special file in the var/tmp folder.
     * The "file" method provides stronger security.
     *
    */
    // Locks all SQL/Security and upgrade/patch operations in the Admin area.
    const PROTECT_DB_AND_PATCHES = 'ip';
    // Locks upload of distribution files for ESD products and the 'Edit templates' feature.
    const PROTECT_ESD_AND_TEMPLATES = 'ip';

    /**
     * This constant defines whether the session id of admin user should be
     * locked to the IP address from which this session originated.
     * 
     * The possible values are (From high secure level to low):
     * - 'ip': Strongly recommended. Using this value provides the highest level
     * of security. With this value, the session id of admin user will be
     * locked to a specific IP address. For example 192.168.31.40
     * - 'secure_mask': Using this value provides medium to high level of security.
     * With this value the session id of admin user will be locked to the IP subnetwork.
     * including the IP address from which the admin session originated. For example 192.168.31.*
     * - 'mask': Using this value provides medium to low level of security.
     * With this value the session id of admin user will be locked to the IP subnetwork 
     * including the IP address from which the admin session originated. For example 192.168.*.*
     * - FALSE: Not recommended. This value disables binding of admin user
     * session id to his IP address. You may want to use this value if admin
     * is going to work via two or more ISPs alternating all the time.
     *
     * Note that, if the value of PROTECT_XID_BY_IP at your store is set to
     * 'ip', in rare cases (namely, if your ISP changes your IP address too
     * often, like every few seconds) you may experience problems logging in
     * to the Admin area. If this happens, consider switching to 'secure_mask'/'mask' or
     * disable binding of admin user session IDs to IP addresses altogether by
     * setting the value of PROTECT_XID_BY_IP to FALSE.
     */
    const PROTECT_XID_BY_IP = 'secure_mask';

    /**
     * This constant (formerly SECURITY_BLOCK_UNKNOWN_ADMIN_IP) allows you to enable a
     * functionality that will prevent usage of your store's back-end from IP
     * addresses unknown to the system.
     */
    const BLOCK_UNKNOWN_ADMIN_IP = FALSE;

    /**
     * This constant (formerly $admin_allowed_ip) contains
     * comma separated list of IP for access to admin area
     * Leave empty for unrestricted access.
     * E.g.:
     *   1) access is unrestricted:
     *       ADMIN_ALLOWED_IP = '';
     *   2) access allowed only from IP 192.168.0.1 and 127.0.0.1:
     *       ADMIN_ALLOWED_IP = "192.168.0.1, 127.0.0.1";
     */
    const ADMIN_ALLOWED_IP = '';

    /**
     * The constant FRAME_NOT_ALLOWED forbids calling X-Cart in IFRAME / FRAME tags.
     * If you do not use X-Cart in any pages where X-Cart is displayed through a
     * frame, this option can be enabled to enhance security. This option prevents
     * attacks in which the attacker displays X-Cart through a frame and, using web
     * browser vulnerabilities, intercepts the information being entered in it.
     */
    const FRAME_NOT_ALLOWED = FALSE;

    /**
     * The constant FORM_ID_ORDER_LENGTH sets the length for the list of unique
     * form identifiers. A unique form identifier ensures that a form is valid
     * and serves as a protection from CSRF attacks. If FORM_ID_ORDER_LENGTH is
     * not declared or is set to a non-numeric value or a value less than 1,
     * it's value will be set to 100.
     */
    const FORM_ID_ORDER_LENGTH = 100;

    /**
     * Extensions of files, disallowed for uploading (enter a comma separated list)
     */
    const DISALLOWED_FILE_EXTS =
        'phtml, phar, php5, php4, php3, php, pl, cgi, asp, exe, com, bat, pif, htaccess';

    /**
     * The constant COMPILED_TPL_CHECK_MD5 defines whether MD5 verification should be used for compiled templates.
     * It is recommended to keep this option disabled to avoid negative effect on the store's performance.
     *
     * The feature has been removed since X-Cart version 4.7.0
     *
     * The only exceptions to this recommendation are:
     * 1) when you are on a shared hosting, and other users of this hosting have write permissions to the var/templates_c directory of your X-Cart installation.
     * 2) when you are not sure your hosting provides a high level of protection against viruses or may have other security vulnerabilities which may result in an intruder gaining write access to the var/templates_c directory.
     */
    const COMPILED_TPL_CHECK_MD5 = FALSE;

    /**
     * STORE_CHECKING_ACCOUNTS (formerly $store_ch) defines whether you want your customers
     * checking account details to be stored in the database or not.
     * The checking account details that can be stored include:
     * - Bank account number;
     * - Bank routing number;
     * - Fraction number.
     *
     * If Direct Debit is used then Account owner name is stored instead of Fraction number.
     *
     * Admissible values for this constant are:
     * TRUE - X-Cart will store your customers' checking account details in the
     * order details;
     * FALSE - X-Cart will not store your customers' checking account details
     * anywhere.
     */
    const STORE_CHECKING_ACCOUNTS = FALSE;

    /**
     * The constant CHECK_CUSTOMERS_INTEGRITY defines whether admin profiles in xcart_customers should be checked for authenticity to prevent their malicious faking and stealing.
     * It is highly recommended to keep this option enabled (set to TRUE) at all times.
     */
    const CHECK_CUSTOMERS_INTEGRITY = TRUE;

    /**
     * The constant CHECK_XAUTH_USER_IDS_INTEGRITY defines whether Social login admin profiles in xcart_xauth_user_ids should be checked for authenticity to prevent their malicious faking and stealing.
     * It is highly recommended to keep this option enabled (set to TRUE) at all times.
     */
    const CHECK_XAUTH_USER_IDS_INTEGRITY = TRUE;

    /**
     * The constant CHECK_RESET_PASSWORDS_INTEGRITY defines whether the password_reset_key field in xcart_reset_passwords should be checked
     * for authenticity in order to prevent its malicious faking and stealing.
     * It is highly recommended to keep this option enabled (set to TRUE) at all times.
     */
    const CHECK_RESET_PASSWORDS_INTEGRITY = TRUE;

    /**
     * The constant CHECK_CONFIG_INTEGRITY defines whether critical config values in xcart_config should be checked 
     * for authenticity in order to prevent their malicious faking and stealing.
     * It is highly recommended to keep this option enabled (set to TRUE) at all times.
     */
    const CHECK_CONFIG_INTEGRITY = TRUE;

    /**
     * Demo mode - protects the pages essential for the functioning of X-Cart
     * from potentially harmful modifications
     */
    public static $admin_safe_mode = FALSE;

    /**
     * The constant HASH_CYCLE_LIMIT defines cycles limit used for hash generation algorythms
     * The value depends on the CPU power of the server (recommended value >= 6000)
     */
    const HASH_CYCLE_LIMIT = 6000;

} //}}} abstract class XCSecurity;

/**
 * The constant USE_SESSION_HISTORY allows you to enable synchronization of
 * user sessions on the main website of your store and on domain aliases.
 */
define('USE_SESSION_HISTORY', true);

/**
 * The constant USE_CURLOPT_INTERFACE enables the functionality that forces the
 * use of the CURLOPT_INTERFACE setting for the libcurl https module. 
 * This setting is required by some payment gateways.
 * Example error text: "Information received from an Invalid IP address. (INVALID)"
 * Take a look at the page
 * http://www.php.net/manual/en/function.curl-setopt.php#CURLOPT_INTERFACE
 * for the description of the CURLOPT_INTERFACE setting.
 */
define('USE_CURLOPT_INTERFACE', false);

/**
 * Enable this in case of problems with HTTP 1.1 requests
 */
define('HTTP_1_0_COMPATIBILITY_MODE', false);

/**
 * The variable sets a limit for the number of redirects from HTTP to HTTPS.
 * When this limit is reached, X-Cart supposes that the HTTPS part of the store
 * does not work and stops trying to redirect to the HTTPS part.
 * If the value of the variable is not a number or less than zero,
 * redirection will always happen.
 */
$https_redirect_limit = 20;

/**
 * Error tracking code
 *
 * Turning on/off the debug mode
 * 0 - no debug info;
 * 1 - display error (and exit script - for SQL errors);
 * 2 - write errors to the log files (var/log/x-errors_*.php)
 * 3 - display error and write it to the log files.
 */
$debug_mode = 2;

/*
 * Enable this directive if you are a developer changing X-Cart source
code.
 * This directive enables function assertion http://php.net/assert
 * This directive enables all php warnings/notices
 * This directive should be disabled in production.
*/
#define('DEVELOPMENT_MODE', 1);

/**
 * Error reporting level:
 */
if ($debug_mode) {
    $x_error_reporting = E_ALL ^ E_NOTICE;
} else {
    $x_error_reporting = 0;
}

if (
    defined('DEVELOPMENT_MODE')
    && constant('DEVELOPMENT_MODE')
) {
    $x_error_reporting = -1;
}

/**
 * Files directory
 */
$files_dir    = DIRECTORY_SEPARATOR . 'files';
$files_webdir = '/files';

/**
 * Prefix for admin/provider file directories
 * Directories will be named as follows:
 * $files_dir/{prefix}{userid}
 */
$files_dir_prefix = 'userfiles_';

/**
 * Templates repository
 * where original templates are located for 'restore' facility
 */
$templates_repository_dir = '/skin_backup';

/**
 * Templates repository root dir
 * where all Smarty templates are located
 */
$smarty_skin_root_dir = '/skin';

/**
 * Core templates repository
 * where common Smarty templates are located
 */
$smarty_skin_dir = '/skin/common_files';

/**
 * Set the session name here
 */
$XCART_SESSION_NAME = 'xid_c7ef3';

/**
 * Session duration (in seconds)
 *
 * Setting a very small value for this option can cause malfunctioning
 * of some lengthy store procedures.
 * Recommended value is not less than 3600.
 */
define('XCART_SESSION_LENGTH', 3600);

/**
 * Search by separate words
 *
 * Maximum number of words that can be searched for when search by separate
 * words is enabled
 * (Expressions enclosed in double-quote marks are treated as single words)
 */
$search_word_limit = 10;

/**
 * Minimum word length (minimum number of significant characters a word must
 * have to be considered a word) when search by separate words is enabled
 */
$search_word_length_limit = 2;

/**
 * The variables $xc_security_key* are used to store X-Cart security keys that
 * ensure the security of admin operations. These keys are generated
 * automatically with your store's $blowfish_key value. Similarly to your
 * store's $blowfish_key value, the values of $xc_security_key* variables must
 * be unique per store and must be stored securely. To enhance the security of
 * your store, it is recommended to periodically update the security keys by re-
 * generating them along with your Blowfish key.
 */
$xc_security_key_session = 'kvHS4vDAuSNjV76OyjAeDU9ds5_ZSlfs90p4q7MncS-tAQaYP8UQvu_oLumVF9I_jIbLXCKCsPMOrB7YjT_9SCATk6WLEBfs3GuqkkflXFRweCCDesf4_muD9TtKGWIvApZ1v9V3IfKRZlVDKh-c7McWThDxkakoWGNN9Z06LcrTtDxQuxnQe-NJ1hhxnldXiOnkIYBMefaqXHUW7yNBlvKTZsszUMw_D2SUGJP7lYUoIajjPDVR2ETZycEXg6PV1z--gkE1Wkdsv41w-cykAwBH9X4xPbgMxAnZ7coOarUPWJFYtMs4N8zFjSutLpMf-uqyxioVu-BTYlGPt-L4oEA_wf0tEiOLlgicewFxqXFIUhTL-1eNWQpGMeWsGDUnxFaapISq7eyRN3UV_TWNkAPaaFY363AhbTkn47pBEgfAFhKIfiyJk0fz6ldHgZm_FqatzJjSn6CbT1u9QVQekmHtccugNbQn1QK6PJb8iPxMYbv_aLVvMhL34PWJ2fdw';
$xc_security_key_config = 'hZdrljwmmdquNnHquCbNvgLSUxiFzsK2MYPm0yDwQTxQx4sKLtQrQIftxFkGXD3kDpF5uvh_aCz2o6JFb2uQCoI3HpBkPdUVVVjemlgfo-T1mwnabpe4COvoubcB0RlfY-s3YrIIXSSgZZBOxt77u2M95yKtWbNZJDvCDdRbbv5Pe55IiCocOv1RM8mcOJFpAadNKGH-zcsSZ-KDaMI27qwdP-RuTwzsHwDa6gqy3z3oV9OXFzkq9IKOGncIKRNPxrMjqzf8pnb4c8i45Zsenyy4bHPGvN-zNmMm2hPkd9gMBC1LGw57_OAR9LOB2z4XTd1M5b-WbJ1FvmOW4NQBQcXpuuZgn138AOJfLiSbvXqdRbKlTbhj3H0ySadDICZJOMi9ScfOU021X7egtu3xAn8pRvHYyr7egcA4RaYgaOBbiPaY5q1x-WbdI91u-hG5zlIUL1NtYU0ANAFty8ljI2DVJC1kcSbJ-XqfLZs31Kcw9DuREaWbmzY8Gf7a4lhf';
$xc_security_key_general = 'QQCoL2-mt2egsyX1UCrt4-BUh-ytTzs_zZ9ulr_NxItUIFrxEAdhYDM4ZFiJzmTVYNweb13v-fNEkBrXvV23YCp6xFz5NZmTpw6stLAHdM5nRKTNU0wFqxyGFoRZ1tvjd1AgV1wvurfEKK9plENpCz3Rgjqh9vpqLV7SDzP20rrw1xH4OaClUd75Q7s9M4NmjG3G1gWUjzeb6UF-9SB3dqjVxmYo0k-OHQ3S-AsUVOeGrmNtOWyhKjXQKAmEJN75lhXYwanQ5AQ7xpVm-_RZhBdtl44H1kpptHyMvgQLhDlOwmXbF9quY3pXVzrlB5XgsexN2tMal1K-nfbnB2Wlf2lBZ21ms_jjQoFD-MykdbIuL0vHArpS6xbOFo5Jlp3qkd0vdZhiCNGj4-t4AMpdRnnWE3XYamB8aJhm0NEnYrsuMt8ewNMLsjEsG8xqTfJm-u8M2AS8uW67zQrBr2NLLFiiEYWgavfDDtiFZhLdV0DeByJ2hcudh8SLP6rJfWga';

/**
 * Skin configuration file
 */
$skin_config_file = 'skin1.conf';

/**
 * Put installation access code here
 * A person who does not know the auth code can not access the install.php installations script
 */
$installation_auth_code = '8EgB2ky0IzyWWNi18EsuBvlSM-C2qbr5';

/**
 * !!!NEVER CHANGE THE SETTINGS BELOW THIS LINE MANUALLY!!!
 *
 * The variable $blowfish_key contains your Blowfish encryption key automatically
 * generated by X-Cart during installation. This key is used to encrypt all the
 * sensitive data in your store including user passwords, credit card data, etc.
 *
 * NEVER try to change your Blowfish encryption key by editing the value  of the
 * $blowfish_key variable in this file: your data is already encrypted with this
 * key and X-Cart needs exactly the same key to be able to decrypt it. Changing
 * $blowfish_key manually will corrupt all the user passwords (including the
 * administrator's password), so you will not be able to use the store.
 *
 * Please be aware that a lost Blowfish key cannot be restored, so X-Cart team
 * will not be able to help you regain access to your store if you remove or
 * change the value of $blowfish_key.
 *
 * It is quite safe to use X-Cart with the Blowfish key generated during
 * installation; however, if you still want to change it, please refer to
 * X-Cart Reference Manual or contact X-Cart Tech Support for details.
 */
$blowfish_key = 'mdlJByFWrQpuflucPMji1hueEGUMB4K-';

/**
 * Special parameter
 */
$_prnotice_txt = 'X-Cart';

/**
 * WARNING :
 * Please ensure that you have no whitespaces or empty lines below this message.
 * Adding a whitespace or an empty line below this line will cause a PHP error.
 */

@include_once $xcart_dir.'/config.local.php';
?>
