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
 * Amazon order-related operations
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    dd95a1e8f063200d8d76f64a881fef1ca66dd24a, v12 (xcart_4_7_8), 2017-03-01 19:26:09, amazon_pa_order.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require __DIR__.'/auth.php';
require $xcart_dir . '/include/security.php';

if ($mode == 'amazon_pa_enable_module') {
    db_query("UPDATE $sql_tbl[modules] SET active = 'Y' WHERE module_name = 'Amazon_Payments_Advanced'");
    db_query("UPDATE $sql_tbl[modules] SET active = 'N' WHERE module_name = 'Amazon_Checkout'");
    func_remove_xcart_caches(true, func_get_cache_dirs());
    func_header_location("payment_methods.php");
}

if (empty($active_modules['Amazon_Payments_Advanced'])) {
    func_page_not_found();
}

x_load('mail', 'product', 'user', 'order');

if ($REQUEST_METHOD == 'POST' && !empty($mode) && !empty($orderid)) {

    $order = func_order_data($orderid);
    if (empty($order)) {
        func_page_not_found();
    }

    $err_msg = '';
    $order_status = '';
    $advinfo = array();

    $amazonAPI = func_amazon_pa_get_client_API();
    $requestParameters = array();

    switch ($mode) {

        case 'capture':
            $amz_captured = false;

            $requestParameters['amazon_authorization_id'] = $order['order']['extra']['amazon_pa_auth_id'];
            $requestParameters['capture_amount'] = $order['order']['total'];
            $requestParameters['currency_code'] = $order['order']['extra']['amazon_pa_currency'];
            $requestParameters['capture_reference_id'] = AMAZON_PA_CAPT_PREFIX . $orderid;

            $response = $amazonAPI->capture($requestParameters);

            if (
                ($result = $response->toArray())
                && !empty($result)
                && intval($result['ResponseStatus']) === 200
            ) {
                $_capt_details = $result['CaptureResult']['CaptureDetails'];
                if ($_capt_details) {
                    $amz_capture_id = $_capt_details['AmazonCaptureId'];
                    $_reply_status = $_capt_details['CaptureStatus']['State'];
                    $amz_captured = (
                        $_reply_status == 'Completed'
                        || (
                            !func_amazon_pa_is_API_sync_mode()
                            && $_reply_status == 'Pending'
                        )
                    );
                    $captured_total = $_capt_details['CaptureAmount']['Amount'];

                    $advinfo[] = "AmazonCaptureId: $amz_capture_id";
                    $advinfo[] = "CaptureStatus: $_reply_status";

                    func_amazon_pa_save_order_extra($orderid, 'amazon_pa_capture_id', $amz_capture_id);
                    func_amazon_pa_save_order_extra($orderid, 'amazon_pa_capture_status', $_reply_status);

                    if ($_reply_status == 'Declined') {
                        $order_status = 'D';
                    }
                    $err_msg = "Status=$_reply_status";
                } else {
                    // log error
                    $err_msg = 'Unexpected Capture reply';
                    func_amazon_pa_error('Unexpected Capture reply: ' . print_r($result, true));
                }
            }

            if (
                $amz_captured
                && $_reply_status != 'Pending'
            ) {
                // captured
                $order_status = 'P';
            }

            if (!empty($order_status)) {
                $override_completed_status = ($order_status != 'P');
                func_change_order_status($orderid, $order_status, join("\n", $advinfo), $override_completed_status);
            }

            if ($amz_captured) {
                $top_message['content'] = func_get_langvar_by_name('lbl_payment_capture_successfully_differ', array('captured_total' => $captured_total));
                if ($_reply_status == 'Pending') {
                    $top_message['type'] = 'W';
                    $top_message['content'] = func_get_langvar_by_name('lbl_payment_capture_pending');
                }
            } else {
                $top_message['type'] = 'E';
                $top_message['content'] = func_get_langvar_by_name('lbl_payment_capture_error', array('error_message' => $err_msg));
            }

            func_amazon_pa_debug('capture:' . print_r($requestParameters, true));
            func_amazon_pa_debug('result:' . print_r($result, true));
            break;

        case 'void':
            $amz_voided = false;

            $requestParameters['amazon_authorization_id'] = $order['order']['extra']['amazon_pa_auth_id'];
            $requestParameters['closure_reason'] = '';

            $response = $amazonAPI->closeAuthorization($requestParameters);

            if (
                ($result = $response->toArray())
                && !empty($result)
                && intval($result['ResponseStatus']) === 200
            ) {
                $amz_voided = true;
            } else {
                $err_msg = 'Void error';
            }

            if ($amz_voided) {
                func_change_order_status($orderid, 'D'); // cancelled status?

                $top_message['content'] = func_get_langvar_by_name('lbl_payment_void_successfully');
            } else {
                $top_message['type'] = 'E';
                $top_message['content'] = func_get_langvar_by_name('lbl_payment_void_error', array('error_message' => $err_msg));
            }

            func_amazon_pa_debug('closeAuthorization:' . print_r($requestParameters, true));
            func_amazon_pa_debug('result:' . print_r($result, true));
            break;

        case 'refund':
            $amz_refunded = false;

            $requestParameters['amazon_capture_id'] = $order['order']['extra']['amazon_pa_capture_id'];
            $requestParameters['refund_amount'] = $order['order']['total'];
            $requestParameters['currency_code'] = $order['order']['extra']['amazon_pa_currency'];
            $requestParameters['refund_reference_id'] = AMAZON_PA_REFD_PREFIX . $orderid;
            $requestParameters['seller_refund_note'] = '';

            $response = $amazonAPI->refund($requestParameters);

            if (
                ($result = $response->toArray())
                && !empty($result)
                && intval($result['ResponseStatus']) === 200
            ) {
                $_ref_details = $result['RefundResult']['RefundDetails'];
                if ($_ref_details) {
                    $amz_ref_id = $_ref_details['AmazonRefundId'];
                    $_reply_status = $_ref_details['RefundStatus']['State'];
                    $amz_refunded = (
                        $_reply_status == 'Completed'
                        || (!func_amazon_pa_is_API_sync_mode() && $_reply_status == 'Pending')
                    );
                    $refunded_total = $_ref_details['RefundAmount']['Amount'];

                    $advinfo[] = "AmazonRefundId: $amz_ref_id";
                    $advinfo[] = "RefundStatus: $_reply_status";

                    func_amazon_pa_save_order_extra($orderid, 'amazon_pa_refund_id', $amz_ref_id);
                    func_amazon_pa_save_order_extra($orderid, 'amazon_pa_refund_status', $_reply_status);

                    $err_msg = "Status=$_reply_status";
                } else {
                    // log error
                    $err_msg = 'Unexpected Refund reply';
                    func_amazon_pa_error('Unexpected Refund reply: ' . print_r($result, true));
                }
            }

            if ($amz_refunded) {
                func_change_order_status($orderid, 'D', join("\n", $advinfo));
                $top_message['content'] = func_get_langvar_by_name('lbl_payment_refund_successfully');

                if ($_reply_status == 'Pending') {
                    $top_message['type'] = 'W';
                    $top_message['content'] = func_get_langvar_by_name('lbl_payment_refund_pending');
                }
            } else {
                $top_message['type'] = 'E';
                $top_message['content'] = func_get_langvar_by_name('lbl_payment_refund_error', array('error_message' => $err_msg), false, true);
            }

            func_amazon_pa_debug('refund:' . print_r($requestParameters, true));
            func_amazon_pa_debug('result:' . print_r($result, true));
            break;

        case 'refresh':

            $requestParameters['amazon_authorization_id'] = $order['order']['extra']['amazon_pa_auth_id'];

            $response = $amazonAPI->getAuthorizationDetails($requestParameters);

            if (
                ($result = $response->toArray())
                && !empty($result)
                && intval($result['ResponseStatus']) === 200
            ) {
                $_auth_details = $result['GetAuthorizationDetailsResult']['AuthorizationDetails'];
                if ($_auth_details) {
                    $_reply_status = $_auth_details['AuthorizationStatus']['State'];
                    $_reply_reason = $_auth_details['AuthorizationStatus']['ReasonCode'];
                    $_oid = XCAmazonUtils::parseOrderIds(AMAZON_PA_AUTH_PREFIX, $_auth_details['AuthorizationReferenceId']);

                    func_amazon_pa_save_order_extra($_oid, 'amazon_pa_auth_status', $_reply_status);

                    $advinfo[] = "AuthorizationStatus: $_reply_status";
                    if (!empty($_reply_reason)) {
                        $advinfo[] = "AuthorizationReason: $_reply_reason";
                    }

                    if ($_reply_status == 'Open') {
                        if (!func_amazon_pa_is_API_capture_now()) {
                            // pre-authorized
                            func_change_order_status($_oid, 'A', join("\n", $advinfo));
                        }
                    }

                    if ($_reply_status == 'Closed') {
                        $_a_amnt = $_auth_details['AuthorizationAmount']['Amount'];
                        $_c_amnt = $_auth_details['CapturedAmount']['Amount'];

                        if ($_c_amnt > 0 && $_c_amnt == $_a_amnt) {

                            // capture now mode, funds were captured successfully, save captureID
                            $_capt_id = $_auth_details['IdList']['member'];

                            func_amazon_pa_save_order_extra($_oid, 'amazon_pa_capture_id', $_capt_id);

                            $advinfo[] = "AmazonCaptureId: $_capt_id";

                            func_change_order_status($_oid, 'P', join("\n", $advinfo));
                        }
                    }

                    if ($_reply_status == 'Declined') {
                        // declined
                        func_change_order_status($_oid, 'D', join("\n", $advinfo));
                    }
                }
            }

            func_amazon_pa_debug('getAuthorizationDetails:' . print_r($requestParameters, true));
            func_amazon_pa_debug('result:' . print_r($result, true));
            break;

        case 'refresh_refund_status':

            $requestParameters['amazon_refund_id'] = $order['order']['extra']['amazon_pa_refund_id'];

            $response = $amazonAPI->getRefundDetails($requestParameters);

            if (
                ($result = $response->toArray())
                && !empty($result)
                && intval($result['ResponseStatus']) === 200
            ) {
                $_ref_details = $result['GetRefundDetailsResult']['RefundDetails'];
                if ($_ref_details) {
                    $amz_ref_id = $_ref_details['AmazonRefundId'];
                    $_reply_status = $_ref_details['RefundStatus']['State'];
                    $_reply_reason = $_ref_details['RefundStatus']['ReasonCode'];
                    $_oid = str_replace(AMAZON_PA_REFD_PREFIX, '', $_ref_details['RefundReferenceId']);

                    $advinfo[] = "AmazonRefundId: $amz_ref_id";
                    $advinfo[] = "RefundStatus: $_reply_status";
                    if (!empty($_reply_reason)) {
                        $advinfo[] = "RefundReason: $_reply_reason";
                    }

                    func_amazon_pa_save_order_extra($_oid, 'amazon_pa_refund_status', $_reply_status);

                    if ($_reply_status == 'Completed') {
                        // refunded
                        func_change_order_status($_oid, 'D', join("\n", $advinfo));
                    }
                }
            }

            func_amazon_pa_debug('getRefundDetails:' . print_r($requestParameters, true));
            func_amazon_pa_debug('result:' . print_r($result, true));
            break;

        case 'refresh_capture_status':
            // not used
            break;

    } // switch

    func_header_location("order.php?orderid=$orderid");
}
