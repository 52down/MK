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
 * "eWAY hosted payment (Responsive Shared Page)" payment module (credit card processor)
 * https://eway.io/api-v3/?shell#responsive-shared-page
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Payment interface
 * @author     Ildar Amankulov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v5 (xcart_4_7_7), 2017-01-23 20:12:10, cc_eway_hosted.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

/**
 * https://eway.io/api-v3/?shell#responsive-shared-page
 */

// Uncomment the below line to enable the debug log
// define('XC_EWAY_DEBUG', 1);

if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['mode']) && in_array($_GET['mode'], array('cancel', 'return')))
{//{{{ Customer Return or Cancel

    require __DIR__.'/auth.php';

    if (!func_is_active_payment('cc_eway_hosted.php')) {
        exit;
    }

    if (defined('XC_EWAY_DEBUG')) {
        func_pp_debug_log('eway_hosted', 'B', $_GET);
    }

    if (
        $mode == 'cancel'
        || empty($AccessCode)
    ) {
        // Session is used to update order status and add 'Canceled by the user' to the Payment gateway log
        $bill_output['sessid'] = $XCARTSESSID;

        $bill_output['code'] = 2;
        $bill_output['billmes'] = !empty($AccessCode) ? func_get_langvar_by_name('lbl_canceled_by_user') : 'AccessCode is empty';

        require $xcart_dir . '/payment/payment_ccmid.php';

        x_session_register('top_message');
        $top_message = array(
            'type' => 'W',
            'content' => $bill_output['billmes']
        );
        func_header_location($xcart_catalogs['customer'] . '/cart.php?mode=checkout');
    }

    $module_params = func_get_pm_params('cc_eway_hosted.php');

    // Obtaion invoiceReference and transactionStatus
    x_load('http');
    list($a, $return) = func_https_request(
        'GET',
        'https://api.' . ($module_params['testmode'] == 'Y' ? 'sandbox.' : '') . 'ewaypayments.com/AccessCode/' . $AccessCode,
        '', // data
        '&', // join
        '', // cookie
        'application/x-www-form-urlencoded',
        '', // referer
        '', // cert
        '', // kcert
        array('Authorization' => 'Basic ' . base64_encode($module_params['param01'] . ':' . $module_params['param02'])) // headers
    );

    if (defined('XC_EWAY_DEBUG')) {
        func_pp_debug_log('eway_hosted', 'Transaction results', array('result' => json_decode($return, true)));
    }

    $transaction_results = json_decode($return, true);
    if (!empty($transaction_results['InvoiceReference'])) {
        $bill_output['sessid'] = func_query_first_cell("SELECT sessid FROM $sql_tbl[cc_pp3_data] WHERE ref = '" . addslashes($transaction_results['InvoiceReference']) . "'");;
    }

    $bill_output['code'] = empty($transaction_results['TransactionStatus']) ? 2 : 1;

    $res_codes = $transaction_results['ResponseMessage'] . ',' . $transaction_results['Errors'];
    $bill_output['billmes'] = XC_EwayResponseCodes::getErrorDescription($res_codes) . ' : ' . $res_codes . ':' . $transaction_results['ResponseCode'];

    if (!empty($transaction_results['AuthorisationCode']))
        $bill_output['billmes'] .= "\nAuthorisationCode: " . $transaction_results['AuthorisationCode'];

    if (!empty($transaction_results['TransactionID']))
        $bill_output['billmes'] .= "\nTransactionID: " . $transaction_results['TransactionID'];

    if (isset($transaction_results['TotalAmount'])) {
        $payment_return = array(
            'total' => ($transaction_results['TotalAmount'] / 100)
        );
    }

    require $xcart_dir . '/payment/payment_ccend.php';
//}}}
} else {
//{{{
    if (!defined('XCART_START')) { header('Location: ../'); die('Access denied'); }

    $InvoiceReference = $module_params['param03'] . join('-', $secure_oid);

    if (!$duplicate) {
        db_query("REPLACE INTO $sql_tbl[cc_pp3_data] (ref,sessid) VALUES ('".addslashes($InvoiceReference)."','".$XCARTSESSID."')");
    }

    $post = array(
        'Method'            => 'ProcessPayment',
        'TransactionType'   => 'Purchase',
        'DeviceID'          => 'X-Cart Version 4',
        'partnerID'         => 'd5525a32705a49a2b0e35476ac024c22',
        'RedirectUrl'       => $current_location . '/payment/cc_eway_hosted.php?mode=return',
        'CancelUrl'         => $current_location . '/payment/cc_eway_hosted.php?mode=cancel',
        'CustomerReadOnly'  => true,
        'VerifyCustomerPhone'  => $module_params['param05'] == 'Y' ? true : false,
        'VerifyCustomerEmail'  => $module_params['param06'] == 'Y' ? true : false,

        'Payment'           => array(
            'TotalAmount'       =>  $cart['total_cost'] * 100, // total amount in cents
            'InvoiceReference'  =>  $InvoiceReference,
            'InvoiceNumber'     =>  '#' . substr(join('-', $secure_oid), 0, 12),
        ),

        'Customer'           => array(
            'FirstName'         => $bill_firstname,
            'LastName'          => $bill_lastname,
            'Street1'           => $userinfo['b_address'],
            'Street2'           => empty($userinfo['b_address_2']) ? '' : $userinfo['b_address_2'],
            'City'              => $userinfo['b_city'],
            'State'             => $userinfo['b_state'],
            'PostalCode'        => $userinfo['b_zipcode'],
            'Country'           => $userinfo['b_country'],
            'Phone'             => $userinfo['phone'],
            'Email'             => $userinfo['email'],
        ),
    );

    // The Items section
    if ($module_params['param07'] == 'Y') {
        $post = XC_EwayHosted::getLineItems($cart, $post);
    }

    if (!empty($module_params['param04'])) {
        $post['CustomView'] = $module_params['param04'];
    }

    // Send request to receive payment URL
    x_load('http');
    list($a, $return) = func_https_request(
        'POST',
        'https://api.' . ($module_params['testmode'] == 'Y' ? 'sandbox.' : '') . 'ewaypayments.com/AccessCodesShared',
        json_encode($post), // data
        '&', // join
        '', // cookie
        'application/json',
        '', // referer
        '', // cert
        '', // kcert
        array('Authorization' => 'Basic ' . base64_encode($module_params['param01'] . ':' . $module_params['param02'])) // headers
    );


    if (defined('XC_EWAY_DEBUG')) {
        func_pp_debug_log('eway_hosted', 'I', array('data' => $post, 'result' => json_decode($return, true)));
    }

    // Parse response
    if (strpos($a, '200 OK') === false) {
        $bill_output['code'] = 2;
        $bill_output['billmes'] = 'Authentication Failure - the API credentials are incorrect';
    } else {
        $response = json_decode($return, true);
        if (!empty($response) && is_array($response)) {
            if (empty($response['Errors']) && !empty($response['SharedPaymentUrl'])) {

                // main successful redirect
                func_header_location($response['SharedPaymentUrl']);

            } else {
                $bill_output['code'] = 2;
                $bill_output['billmes'] = XC_EwayResponseCodes::getErrorDescription($response['Errors']) . ' : ' . $response['Errors'];
            }
        } else {
            $bill_output['code'] = 2;
            $bill_output['billmes'] = 'Empty response';
        }
    }

    if ($bill_output['code'] == 2) {
        require $xcart_dir . '/payment/payment_ccend.php';
    }

    //}}}
}

class XC_EwayResponseCodes {
    public static $codes = array (//{{{
        // https://eway.io/api-v3/?shell#transaction-response-messages
        'A2000' => 'Transaction Approved',// Successful
        'A2008' => 'Honour With Identification',// Successful
        'A2010' => 'Approved For Partial Amount',// Successful
        'A2011' => 'Approved, VIP',// Successful
        'A2016' => 'Approved, Update Track 3',// Successful
        'D4401' => 'Refer to Issuer',// Failed
        'D4402' => 'Refer to Issuer, special',// Failed
        'D4403' => 'No Merchant',// Failed
        'D4404' => 'Pick Up Card',// Failed
        'D4405' => 'Do Not Honour',// Failed
        'D4406' => 'Error',// Failed
        'D4407' => 'Pick Up Card, Special',// Failed
        'D4409' => 'Request In Progress',// Failed
        'D4412' => 'Invalid Transaction',// Failed
        'D4413' => 'Invalid Amount',// Failed
        'D4414' => 'Invalid Card Number',// Failed
        'D4415' => 'No Issuer',// Failed
        'D4419' => 'Re-enter Last Transaction',// Failed
        'D4421' => 'No Action Taken',// Failed
        'D4422' => 'Suspected Malfunction',// Failed
        'D4423' => 'Unacceptable Transaction Fee',// Failed
        'D4425' => 'Unable to Locate Record On File',// Failed
        'D4430' => 'Format Error',// Failed
        'D4431' => 'Bank Not Supported By Switch',// Failed
        'D4433' => 'Expired Card, Capture',// Failed
        'D4434' => 'Suspected Fraud, Retain Card',// Failed
        'D4435' => 'Card Acceptor, Contact Acquirer, Retain Card',// Failed
        'D4436' => 'Restricted Card, Retain Card',// Failed
        'D4437' => 'Contact Acquirer Security Department, Retain Card',// Failed
        'D4438' => 'PIN Tries Exceeded, Capture',// Failed
        'D4439' => 'No Credit Account',// Failed
        'D4440' => 'Function Not Supported',// Failed
        'D4441' => 'Lost Card',// Failed
        'D4442' => 'No Universal Account',// Failed
        'D4443' => 'Stolen Card',// Failed
        'D4444' => 'No Investment Account',// Failed
        'D4450' => 'Visa Checkout Transaction Error',// Failed
        'D4451' => 'Insufficient Funds',// Failed
        'D4452' => 'No Cheque Account',// Failed
        'D4453' => 'No Savings Account',// Failed
        'D4454' => 'Expired Card',// Failed
        'D4455' => 'Incorrect PIN',// Failed
        'D4456' => 'No Card Record',// Failed
        'D4457' => 'Function Not Permitted to Cardholder',// Failed
        'D4458' => 'Function Not Permitted to Terminal',// Failed
        'D4459' => 'Suspected Fraud',// Failed
        'D4460' => 'Acceptor Contact Acquirer',// Failed
        'D4461' => 'Exceeds Withdrawal Limit',// Failed
        'D4462' => 'Restricted Card',// Failed
        'D4463' => 'Security Violation',// Failed
        'D4464' => 'Original Amount Incorrect',// Failed
        'D4466' => 'Acceptor Contact Acquirer, Security',// Failed
        'D4467' => 'Capture Card',// Failed
        'D4475' => 'PIN Tries Exceeded',// Failed
        'D4482' => 'CVV Validation Error',// Failed
        'D4490' => 'Cut off In Progress',// Failed
        'D4491' => 'Card Issuer Unavailable',// Failed
        'D4492' => 'Unable To Route Transaction',// Failed
        'D4493' => 'Cannot Complete, Violation Of The Law',// Failed
        'D4494' => 'Duplicate Transaction',// Failed
        'D4495' => 'Amex Declined',// Failed
        'D4496' => 'System Error',// Failed
        'D4497' => 'MasterPass Error',// Failed
        'D4498' => 'PayPal Create Transaction Error',// Failed
        'D4499' => 'Invalid Transaction for Auth/Void',// Failed
        'D4450' => 'Visa Checkout Transaction Error',// Failed

        // https://eway.io/api-v3/?shell#validation-response-codes',
        'V6000' => 'Validation error',
        'V6001' => 'Invalid CustomerIP',
        'V6002' => 'Invalid DeviceID',
        'V6003' => 'Invalid Request PartnerID',
        'V6004' => 'Invalid Request Method',
        'V6010' => 'Invalid TransactionType, account not certified for eCome only MOTO or Recurring available',
        'V6011' => 'Invalid Payment TotalAmount',
        'V6012' => 'Invalid Payment InvoiceDescription',
        'V6013' => 'Invalid Payment InvoiceNumber',
        'V6014' => 'Invalid Payment InvoiceReference',
        'V6015' => 'Invalid Payment CurrencyCode',
        'V6016' => 'Payment Required',
        'V6017' => 'Payment CurrencyCode Required',
        'V6018' => 'Unknown Payment CurrencyCode',
        'V6021' => 'EWAY_CARDHOLDERNAME Required',
        'V6022' => 'EWAY_CARDNUMBER Required',
        'V6023' => 'EWAY_CARDCVN Required',
        'V6033' => 'Invalid Expiry Date',
        'V6034' => 'Invalid Issue Number',
        'V6035' => 'Invalid Valid From Date',
        'V6040' => 'Invalid TokenCustomerID',
        'V6041' => 'Customer Required',
        'V6042' => 'Customer FirstName Required',
        'V6043' => 'Customer LastName Required',
        'V6044' => 'Customer CountryCode Required',
        'V6045' => 'Customer Title Required',
        'V6046' => 'TokenCustomerID Required',
        'V6047' => 'RedirectURL Required',
        'V6048' => 'CheckoutURL Required when CheckoutPayment specified',
        'V6049' => 'Invalid Checkout URL',
        'V6051' => 'Invalid Customer FirstName',
        'V6052' => 'Invalid Customer LastName',
        'V6053' => 'Invalid Customer CountryCode',
        'V6058' => 'Invalid Customer Title',
        'V6059' => 'Invalid RedirectURL',
        'V6060' => 'Invalid TokenCustomerID',
        'V6061' => 'Invalid Customer Reference',
        'V6062' => 'Invalid Customer CompanyName',
        'V6063' => 'Invalid Customer JobDescription',
        'V6064' => 'Invalid Customer Street1',
        'V6065' => 'Invalid Customer Street2',
        'V6066' => 'Invalid Customer City',
        'V6067' => 'Invalid Customer State',
        'V6068' => 'Invalid Customer PostalCode',
        'V6069' => 'Invalid Customer Email',
        'V6070' => 'Invalid Customer Phone',
        'V6071' => 'Invalid Customer Mobile',
        'V6072' => 'Invalid Customer Comments',
        'V6073' => 'Invalid Customer Fax',
        'V6074' => 'Invalid Customer URL',
        'V6075' => 'Invalid ShippingAddress FirstName',
        'V6076' => 'Invalid ShippingAddress LastName',
        'V6077' => 'Invalid ShippingAddress Street1',
        'V6078' => 'Invalid ShippingAddress Street2',
        'V6079' => 'Invalid ShippingAddress City',
        'V6080' => 'Invalid ShippingAddress State',
        'V6081' => 'Invalid ShippingAddress PostalCode',
        'V6082' => 'Invalid ShippingAddress Email',
        'V6083' => 'Invalid ShippingAddress Phone',
        'V6084' => 'Invalid ShippingAddress Country',
        'V6085' => 'Invalid ShippingAddress ShippingMethod',
        'V6086' => 'Invalid ShippingAddress Fax',
        'V6091' => 'Unknown Customer CountryCode',
        'V6092' => 'Unknown ShippingAddress CountryCode',
        'V6100' => 'Invalid EWAY_CARDNAME',
        'V6101' => 'Invalid EWAY_CARDEXPIRYMONTH',
        'V6102' => 'Invalid EWAY_CARDEXPIRYYEAR',
        'V6103' => 'Invalid EWAY_CARDSTARTMONTH',
        'V6104' => 'Invalid EWAY_CARDSTARTYEAR',
        'V6105' => 'Invalid EWAY_CARDISSUENUMBER',
        'V6106' => 'Invalid EWAY_CARDCVN',
        'V6107' => 'Invalid EWAY_ACCESSCODE',
        'V6108' => 'Invalid CustomerHostAddress',
        'V6109' => 'Invalid UserAgent',
        'V6110' => 'Invalid EWAY_CARDNUMBER',
        'V6111' => 'Unauthorised API Access, Account Not PCI Certified',
        'V6112' => 'Redundant card details other than expiry year and month',
        'V6113' => 'Invalid transaction for refund',
        'V6114' => 'Gateway validation error',
        'V6115' => 'Invalid DirectRefundRequest, Transaction ID',
        'V6116' => 'Invalid card data on original TransactionID',
        'V6117' => 'Invalid CreateAccessCodeSharedRequest, FooterText',
        'V6118' => 'Invalid CreateAccessCodeSharedRequest, HeaderText',
        'V6119' => 'Invalid CreateAccessCodeSharedRequest, Language',
        'V6120' => 'Invalid CreateAccessCodeSharedRequest, LogoUrl',
        'V6121' => 'Invalid TransactionSearch, Filter Match Type',
        'V6122' => 'Invalid TransactionSearch, Non numeric Transaction ID',
        'V6123' => 'Invalid TransactionSearch,no TransactionID or AccessCode specified',
        'V6124' => 'Invalid Line Items. The line items have been provided however the totals do not match the TotalAmount field',
        'V6125' => 'Selected Payment Type not enabled',
        'V6126' => 'Invalid encrypted card number, decryption failed',
        'V6127' => 'Invalid encrypted cvn, decryption failed',
        'V6128' => 'Invalid Method for Payment Type',
        'V6129' => 'Transaction has not been authorised for Capture/Cancellation',
        'V6130' => 'Generic customer information error',
        'V6131' => 'Generic shipping information error',
        'V6132' => 'Transaction has already been completed or voided, operation not permitted',
        'V6133' => 'Checkout not available for Payment Type',
        'V6134' => 'Invalid Auth Transaction ID for Capture/Void',
        'V6135' => 'PayPal Error Processing Refund',
        'V6140' => 'Merchant account is suspended',
        'V6141' => 'Invalid PayPal account details or API signature',
        'V6142' => 'Authorise not available for Bank/Branch',
        'V6150' => 'Invalid Refund Amount',
        'V6151' => 'Refund amount greater than original transaction',
        'V6152' => 'Original transaction already refunded for total amount',
        'V6153' => 'Card type not support by merchant',
        'V6160' => 'Encryption Method Not Supported',
        'V6161' => 'Encryption failed, missing or invalid key',
        'V6165' => 'Invalid Visa Checkout data or decryption failed',
        'V6170' => 'Invalid TransactionSearch, Invoice Number is not unique',
        'V6171' => 'Invalid TransactionSearch, Invoice Number not found',
    );//}}}

    public static function getErrorDescription($code)
    {//{{{
        $codes = explode(',', $code);
        $str = '';
        foreach($codes as $code) {
            $str .= isset(self::$codes[$code]) ? (self::$codes[$code] . ',') : '';
        }
        return rtrim($str, ',');
    }//}}}
}

class XC_EwayHosted {
    public static function getLineItems($cart, $post)
    {//{{{
        $ind = 0;
        $max_description_len = 26;
        $maximum_items_count = 99;
        $cents_per_dollar = 100;
        if (!empty($cart['products'])) {
            $post['Items'] = array();
            x_load('cart'); // For Func_payment_product_description
            foreach ($cart['products'] as $p) {
                if ($ind > $maximum_items_count) {
                    break;
                }
                $post['Items'][$ind]['Description'] = $p['product'] . func_payment_product_description($p, $max_description_len - strlen($p['product']));
                $post['Items'][$ind]['Quantity'] = $p['amount'];
                $post['Items'][$ind]['Total'] = $p['amount'] * $p['display_price'] * $cents_per_dollar;
                $ind++;
            }
        }

        if (!empty($cart['giftcerts'])) {
            $post['Items'] = $post['Items'] ?: array();
            $lbl_gc_for = func_get_langvar_by_name('lbl_gc_for', null, false, true);
            foreach ($cart['giftcerts'] as $p) {
                if ($ind > $maximum_items_count) {
                    break;
                }
                $post['Items'][$ind]['Description'] = $lbl_gc_for . $p['recipient'];;
                $post['Items'][$ind]['Quantity'] = 1;
                $post['Items'][$ind]['Total'] = $p['amount'] * $cents_per_dollar;
                $ind++;
            }
        }

        return $post;
    }//}}}
}//}}}

exit;
