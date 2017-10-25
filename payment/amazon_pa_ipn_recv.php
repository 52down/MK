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
 * PayPoint Fast Track
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Payment interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    7ac8b95f7e566e55d81ce40cffdc7ad9000da441, v12 (xcart_4_7_8), 2017-03-09 18:07:23, amazon_pa_ipn_recv.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require __DIR__.'/auth.php';

if (empty($active_modules['Amazon_Payments_Advanced'])) {
    exit();
}

// Get the IPN headers and Message body
$headers    = getallheaders();
$body       = file_get_contents('php://input');

if (empty($body)) {
    // empty request
    exit();
}

// Create an object($ipnHandler) of the IpnHandler class
$ipnHandler = new PayWithAmazon\IpnHandler($headers, $body);
$notification = $ipnHandler->toArray();

if (
    empty($notification['NotificationReferenceId'])
    || empty($notification['NotificationType'])
) {
    func_amazon_pa_error("Invalid IPN call" . print_r($notification, true), 'ipn');
}

// handle message
func_amazon_pa_debug('IPN message received:' . print_r($notification, true), 'ipn');

x_load('order');

$advinfo = array();
switch ($notification['NotificationType']) {

    case 'PaymentAuthorize':
    //{{{
        $_auth_details = $notification['AuthorizationDetails'];
        if ($_auth_details) {
            $_authorization_id = $_auth_details['AmazonAuthorizationId'];
            $_reply_status = $_auth_details['AuthorizationStatus']['State'];
            $_reply_reason = isset($_auth_details['AuthorizationStatus']['ReasonCode']) ? $_auth_details['AuthorizationStatus']['ReasonCode'] : '';

            $advinfo[] = "AmazonAuthorizationId: $_authorization_id";
            $advinfo[] = "AuthorizationStatus: $_reply_status";

            $_oid = XCAmazonUtils::parseOrderIds(AMAZON_PA_AUTH_PREFIX, $_auth_details['AuthorizationReferenceId']);

            func_amazon_pa_save_order_extra($_oid, 'amazon_pa_auth_id', $_authorization_id);
            func_amazon_pa_save_order_extra($_oid, 'amazon_pa_auth_status', $_reply_status);

            if (!empty($_reply_reason)) {
                $advinfo[] = "AuthorizationReason: $_reply_reason";
            }

            if ($_reply_status == 'Open') {
                if ($config['Amazon_Payments_Advanced']['amazon_pa_capture_mode'] == 'A') {
                    // authorized
                    func_change_order_status($_oid, 'A', join("\n", $advinfo));
                }
            }
            if ($_reply_status == 'Declined') {
                if ($_reply_reason == 'InvalidPaymentMethod') {
                    // https://pay.amazon.com/uk/developer/documentation/lpwa/201953810
                    // Asynchronous mode/wait for invalidPaymentMethod IPN
                    if (!empty($_auth_details['IdList']['Id'])) {
                        $_capture_id = is_array($_auth_details['IdList']['Id']) ? $_auth_details['IdList']['Id'] : array($_auth_details['IdList']['Id']);
                        $_capture_id = $_capture_id[count($_capture_id) - 1];
                        func_amazon_pa_save_order_extra($_oid, 'amazon_pa_auth_capture_id_to_ignore', $_capture_id);
                    }
                    func_change_order_status($_oid, 'Q', join("\n", $advinfo));
                } else {
                    // declined
                    func_change_order_status($_oid, 'D', join("\n", $advinfo));
                }
            }
        }
        break;
    //}}}

    case 'PaymentCapture':
    //{{{
        $_capt_details = $notification['CaptureDetails'];
        if ($_capt_details) {
            $_capture_id = $_capt_details['AmazonCaptureId'];
            $_reply_status = $_capt_details['CaptureStatus']['State'];
            $_reply_reason = isset($_capt_details['CaptureStatus']['ReasonCode']) ? $_capt_details['CaptureStatus']['ReasonCode'] : '';

            $advinfo[] = "AmazonCaptureId: $_capture_id";
            $advinfo[] = "CaptureStatus: $_reply_status";

            if (!empty($_reply_reason)) {
                $advinfo[] = "CaptureReason: $_reply_reason";
            }

            $_oid1 = str_replace(AMAZON_PA_CAPT_PREFIX, '', $_capt_details['CaptureReferenceId']);
            $_oid = XCAmazonUtils::parseOrderIds(AMAZON_PA_AUTH_PREFIX, $_oid1);

            func_amazon_pa_save_order_extra($_oid, 'amazon_pa_capture_id', $_capture_id); // captureNow mode
            func_amazon_pa_save_order_extra($_oid, 'amazon_pa_capture_status', $_reply_status);

            if ($_reply_status == 'Completed') {
                // captured, order is processed
                func_change_order_status($_oid, 'P', join("\n", $advinfo));
            }
            if ($_reply_status == 'Declined') {
                $invalidPaymentMethod =
                    $_reply_reason == 'ProcessingFailure'
                    && $_capture_id == func_query_first_cell("SELECT value FROM $sql_tbl[order_extras] WHERE khash='amazon_pa_auth_capture_id_to_ignore' AND orderid=" . intval($_oid[0]));

                if (!$invalidPaymentMethod) {
                    // declined
                    func_change_order_status($_oid, 'D', join("\n", $advinfo));
                }
            }
        }
        break;
    //}}}

    case 'PaymentRefund':
        $_ref_details = $notification['RefundDetails'];
        if ($_ref_details) {
            $amz_ref_id = $_ref_details['AmazonRefundId'];
            $_reply_status = $_ref_details['RefundStatus']['State'];
            $_reply_reason = $_ref_details['RefundStatus']['ReasonCode'];

            $advinfo[] = "AmazonRefundId: $amz_ref_id";
            $advinfo[] = "RefundStatus: $_reply_status";
            if (!empty($_reply_reason)) {
                $advinfo[] = "RefundReason: $_reply_reason";
            }

            $_oid = str_replace(AMAZON_PA_REFD_PREFIX, '', $_ref_details['RefundReferenceId']);

            func_amazon_pa_save_order_extra($_oid, 'amazon_pa_refund_id', $amz_ref_id);
            func_amazon_pa_save_order_extra($_oid, 'amazon_pa_refund_status', $_reply_status);

            if ($_reply_status == 'Completed') {
                // refunded
                func_change_order_status($_oid, 'R', join("\n", $advinfo));
            }
        }
        break;

    case 'OrderReferenceNotification':
    //{{{
        $_order_details = empty($notification['OrderReference']) ? array('OrderReferenceStatus' => array('State' => '')) : $notification['OrderReference'];

        // Step1 (Asynchronous mode: Declined authorisations via invalidPaymentMethod. Ask customer to change PM) https://payments.amazon.co.uk/developer/documentation/lpwa/201953810
        if (
            $_order_details['OrderReferenceStatus']['State'] == 'Suspended'
            && $_order_details['OrderReferenceStatus']['ReasonCode'] == 'InvalidPaymentMethod'
        ) {
            XCAmazonIPNOrderNotification::sendMail2Buyer($_order_details);
            break;
        }


        // Step2 (Asynchronous mode: Declined authorisations via invalidPaymentMethod. Ask customer to change PM) https://payments.amazon.co.uk/developer/documentation/lpwa/201953810
        if ($_order_details['OrderReferenceStatus']['State'] == 'Open') {
            $res = XCAmazonIPNOrderNotification::authorize_2nd($_order_details['AmazonOrderReferenceId']);
            if (!empty($res['authorized_oids'])) {
                func_change_order_status($res['authorized_oids'], $res['order_status'], join("\n", $res['advinfo']));
            }
            break;
        }

        func_amazon_pa_debug("Uncatched IPN Notification: see above $notification[NotificationType]", 'ipn');//{{{
        break;
    //}}}

    default: func_amazon_pa_debug("Uncatched IPN Notification: see above $notification[NotificationType]", 'ipn');//{{{
        break;
    //}}}
}// switch ($notification['NotificationType'])

exit();
