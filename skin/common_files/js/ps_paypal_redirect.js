/**
 * PayPal Payflow Pro - Transparent redirect (Partner Hosted with PCI Compliance) controller
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Michael Bugrov
 * @version    0520abd712e523c608eb0fbbf22828c2c67d6257, v4 (xcart_4_7_7), 2016-10-03 16:47:26, ps_paypal_redirect.js, mixon
 *
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

/* global ajax, lbl_error, pptr_msg_token_error, pptr_msg_being_placed */

/**
 * PayPal redirect widget
 *
 * @param {int} paymentid
 *
 * @returns {ajax.widgets.paypal_redirect}
 */
ajax.widgets.paypal_redirect = function(paymentid) {

    ajax.widgets.paypal_redirect.prototype.paymentid = paymentid;

    ajax.widgets.paypal_redirect.prototype.isAjaxCheckout = function()
    {
        return isXCAjaxCheckout();
    };

    ajax.widgets.paypal_redirect.prototype.getAjaxCheckoutObject = function()
    {
        if (ajax.widgets.paypal_redirect.prototype.isAjaxCheckout()) {
            return $('.opc-container').get(0).checkoutWidget;
        } else {
            return this;
        }
    };

    ajax.widgets.paypal_redirect.prototype.generateTokenResponseHandler = function(response) {

        var params = $.parseJSON(response);

        if (
            !params
            || (
                !params['action']
                && !params['secureToken']
                && !params['secureTokenID']
            )
        ) {
            $.unblockUI();

            ajax.widgets.paypal_redirect.prototype.getAjaxCheckoutObject().enablePaymentSelection();
            ajax.widgets.paypal_redirect.prototype.getAjaxCheckoutObject().enableCheckoutButton();

            xAlert(pptr_msg_token_error, lbl_error);
            return;
        }

        var appendInput = function ($form, name, value) {
            var $input = $('<input>');

            $input.attr('type','hidden');
            $input.attr('name', name);
            $input.attr('value',value);

            $form.append($input);
        };

        var box = jQuery('.transparent-redirect-box');

        var expMonth = parseInt(box.find('#cc_expire_month').val());
        var expYear = parseInt(box.find('#cc_expire_year').val().slice(-2));

        var paramList = 'TENDER=C'
                + '&ACCT=' + parseInt(box.find('#cc_number').val().replace(/\D/g, ''))
                + '&EXPDATE=' + (expMonth.length !== 2 ? ('0' + expMonth) : expMonth) + expYear
                + '&CVV2=' + parseInt(box.find('#cc_cvv2').val().replace(/\D/g, ''));

        var $form = $('<form method="post" action="' + params.action + '">');

        appendInput($form, 'SECURETOKEN', params.secureToken);
        appendInput($form, 'SECURETOKENID', params.secureTokenID);
        appendInput($form, 'PARMLIST', paramList);

        $form.appendTo('body').submit();
    };

    ajax.widgets.paypal_redirect.prototype.formOnFirstSubmitHandler = function(event) {

        if (
            ajax.widgets.paypal_redirect.prototype.isAjaxCheckout()
            && $('form[name=paymentform] input:checked').val() !== ajax.widgets.paypal_redirect.prototype.paymentid
        ) {
            // Skip event since a different payment method is selected
            return true;
        }

        if (
            $('.cc-form').length !== 0
            && !$('.cc-form').get(0).isCardFormValid()
        ) {
            // Stop event propagation
            event.stopImmediatePropagation();
            // Form data invalid prevent submit
            return false;
        }

        if ($('#accept_terms:checked').length !== 0) {

            var checkoutForm = $('form[name=checkout_form]');

            ajax.widgets.paypal_redirect.prototype.getAjaxCheckoutObject().disablePaymentSelection();
            ajax.widgets.paypal_redirect.prototype.getAjaxCheckoutObject().disableCheckoutButton();

            $.post(
                checkoutForm.attr('action'),
                checkoutForm.serialize(),
                ajax.widgets.paypal_redirect.prototype.generateTokenResponseHandler
            );

            showXCblockUI(pptr_msg_being_placed);

            // Stop event propagation until request is finished
            event.stopImmediatePropagation();

            // Prevent the form submission
            return false;
        }

        // Allow form submitting
        return true;
    };

    ajax.widgets.paypal_redirect.prototype.bindFormOnSubmit = function() {
        // Add first submit handler
        $('form[name=checkout_form]').onFirst('submit', ajax.widgets.paypal_redirect.prototype.formOnFirstSubmitHandler);
    };

    ajax.widgets.paypal_redirect.prototype.unBindFormOnSubmit = function() {
        // Remove first submit handler
        $('form[name=checkout_form]').off('submit', ajax.widgets.paypal_redirect.prototype.formOnFirstSubmitHandler);
    };

    // Finally bind handlers
    ajax.widgets.paypal_redirect.prototype.bindFormOnSubmit();
};
