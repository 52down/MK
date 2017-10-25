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
 * Common functions for X-Payment connector module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v45 (xcart_4_7_7), 2017-01-24 09:29:34, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

// X-Payment connector requirements codes

define('XPC_REQ_CURL', 1);
define('XPC_REQ_OPENSSL', 2);
define('XPC_REQ_DOM', 4);

define('XPC_SYSERR_CARTID', 1);
define('XPC_SYSERR_URL', 2);
define('XPC_SYSERR_PUBKEY', 4);
define('XPC_SYSERR_PRIVKEY', 8);
define('XPC_SYSERR_PRIVKEYPASS', 16);

define('XPC_API_EXPIRED', 506);

/**
 * Convert string to use in javascript code - declare function if not available in core
 */
if (!function_exists('func_js_escape')) {
    function func_js_escape($string)
    {
        return strtr(
            $string,
            array(
                '\\' => '\\\\',
                "'"  => "\\'",
                '"'  => '\\"',
                "\r" => '\\r',
                "\n" => '\\n',
                '</' => '<\/',
            )
        );
    }
}

/**
 * Load modules/XPayments_Connector/xpc_func.php script
 */
function func_xpay_func_load()
{
    global $xcart_dir;

    require_once ($xcart_dir . '/modules/XPayments_Connector/xpc_func.php');

    return true;
}

function func_xpay_update_save_card_address($address, $do_redirect = false)
{ //{{{

    global $logged_userid, $xpc_save_card_address, $xpc_save_card_show_form;

    x_session_register('xpc_save_card_address', array());

    if (is_array($address)) {
        $xpc_save_card_address = $address;
    } else {
        $addresses = func_get_address_book($logged_userid);
        foreach ($addresses as $addr) {
            if ($address == $addr['id']) {
                $xpc_save_card_address = $addr;
                break;
            }
        }
    }

    x_session_register('xpc_save_card_show_form');
    $xpc_save_card_show_form = true;

    if ($do_redirect) {
        func_header_location('saved_cards.php');
    }

} //}}}

/**
 * Process redirect of the main window from a child iframe
 * using JS
 *
 * @param $url location
 *
 * @return string
 * @access public
 * @see    ____func_see____
 */
function func_xpay_iframe_redirect($url)
{
    global $bill_output, $action, $top_message;

    $return_url = preg_replace('/[\x00-\x1f].*$/sm', '', $url); 

    x_session_save();
    func_define('XC_DISABLE_SESSION_SAVE', true);

    if ($bill_output['code'] == 2 && $action != 'return') {
        #
        # Process error, no redirect of the parent window
        #
        if (!empty($bill_output['billmes'])) {
            $xpc_error = $bill_output['billmes'];
        } elseif (!empty($top_message['content'])) {
            $xpc_error = $top_message['content'];
        } else  {
            $xpc_error = 'Unknown error';
        }
        
        echo htmlspecialchars($xpc_error);    

    } else {
        #
        # Process normal return, redirect the parent window
        #
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script type="text/javascript">
//<![CDATA[
function func_redirect(return_url) {
    if (window.parent !== window) {
        window.parent.location = return_url;
    } else {
        window.location = return_url;
    }
}
//]]>
</script>

</head>
<body onload="javascript: func_redirect('<?php echo $url; ?>');" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; color: #555; overflow-x: hidden;">
Please wait while processing the payment details...
</body>
</html>
<?php

    }

    func_flush();
    func_exit();

    exit();
}

?>
