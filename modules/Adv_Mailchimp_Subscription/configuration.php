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
 * Configuration options processing.
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    ec87b6f6bb5e283a65fa2622c05a64b4677c9f5c, v16 (xcart_4_7_8), 2017-03-20 16:41:54, configuration.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header('Location: ../'); die('Access denied'); }

assert('count($config["Adv_Mailchimp_Subscription"]) === 9 /*Adv_Mailchimp_Subscription count settings are changed Adv_Mailchimp_Subscription. Update the modules/Adv_Mailchimp_Subscription/configuration.php file*/');

if ($REQUEST_METHOD == 'POST') {

    if (empty($adv_mailchimp_apikey)) {

    	$top_message['content'] = func_get_langvar_by_name('txt_please_enter_all_required_info');
        func_header_location('configuration.php?option=Adv_Mailchimp_Subscription#tr_adv_mailchimp_apikey');

    } else {

       $adv_mailchimp_lists = func_mailchimp_get_lists(0, $adv_mailchimp_apikey);
       if (!empty($adv_mailchimp_lists['Error_message'])) {
           $top_message['content'] = func_get_langvar_by_name(
                "txt_mailchimp_error_txt",
                array(
                    "error_txt" => $adv_mailchimp_lists['Error_message'],
                )
            );
           func_header_location("configuration.php?option=Adv_Mailchimp_Subscription");

        } else {

            if (!empty($adv_mailchimp_lists)) {
                $top_message['content'] = func_get_langvar_by_name('msg_adm_mailchimp_connection_configured');
            }

            foreach(array('adv_mailchimp_apikey', 'adv_mailchimp_currency_code', 'adv_mailchimp_campaign_expire', 'adv_mailchimp_default_store') as $_val) {
                func_array2update(
                    'config',
                    array(
                        'value' => $$_val,
                    ),
                    "name = '$_val' AND category = 'Adv_Mailchimp_Subscription'"
                );
            }

            foreach(array('adv_mailchimp_send_orders', 'adv_mailchimp_send_carts', 'adv_mailchimp_register_opt', 'adv_mailchimp_subscribe_order','adv_mailchimp_p_recommendations') as $_val) {
                func_array2update(
                    'config',
                    array(
                        'value' => !empty($$_val) && $$_val == 'on' ? 'Y' : '',
                    ),
                    "name = '$_val' AND category = 'Adv_Mailchimp_Subscription'"
                );
            }
        }

        func_header_location('configuration.php?option=Adv_Mailchimp_Subscription');
    }
}
