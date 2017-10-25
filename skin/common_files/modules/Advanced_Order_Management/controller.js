/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * AOM widget
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @version    6a9b375c55bf8451cd1c0194a9362763f50cb463, v8 (xcart_4_7_7), 2016-08-19 12:32:20, controller.js, mixon
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

(function($) {

    var original_value_attr = 'data-aom-orig-value';

    init = function() {
        $('[' + original_value_attr + ']').each(onChange);
        $('[' + original_value_attr + ']').bind('input change paste focus', onChange);

        $('.aom-get-price').bind('click', onGetPrice);
    };

    isValueChanged = function (element) {
        var control = $(element);
        var value  = getControlValue(control);

        // check if value is changed
        if (
            value !== getOriginalValue(control)
        ) {
            return true;
        }

        return false;
    };

    compareWithOriginal = function () {
        var control = $(this);

        // check if value is changed
        if (isValueChanged(control)) {
            // add value changed class
            control.addClass('aom-value-is-changed');
            // check if restore button is added
            if (control.next('.aom-restore-value').length === 0) {
                // add button
                var restoreBtn = $('<div class="aom-restore-value"></div>').bind('click', onRestoreValue);
                control.after(restoreBtn);
            }
        } else {
            // remove value changed class
            control.removeClass('aom-value-is-changed');
            // remove button
            control.next('.aom-restore-value').remove();
        }
    };

    getOriginalValue = function (element) {
        var control = $(element);
        var controlValue = control.attr(original_value_attr);

        if (
            control.prop('tagName').toLowerCase() === 'input'
            && control.attr('type')
            && control.attr('type').toLowerCase() === 'checkbox'
        ) {
            controlValue = (controlValue !== "");
        }

        return controlValue;
    };

    getControlValue = function (element) {
        var control = $(element);
        var controlValue = control.val();

        if (
            control.prop('tagName').toLowerCase() === 'input'
            && control.attr('type')
            && control.attr('type').toLowerCase() === 'checkbox'
        ) {
            controlValue = control.is(':checked');
        }

        return controlValue;
    };

    setControlValue = function (element, value) {
        var control = $(element);

        if (
            control.prop('tagName').toLowerCase() === 'input'
            && control.attr('type').toLowerCase() === 'checkbox'
        ) {
            control.prop('checked', value);
        } else {
            control.val(value);
        }
    };

    getRelatedControl = function (element) {
        var control = $(element);
        return control.attr('data-aom-related-ui-control');
    };

    getProductOptions = function (sectionID) {
        var selector = '[name^="product_details[' + sectionID + '][product_options]"]';
        var poptions = $(selector);

        var options = {};

        $.each(
            poptions,
            function (index, value) {
                var optionid = $(value).attr('id').replace('po', '');
                options[optionid] = getControlValue(value);
            }
        );

        return options;
    };

    onGetPrice = function () {
        var element = $(this);

        var productID = $(element).attr('data-aom-productid');
        var sectionID = $(element).attr('data-aom-sectionid');
        var priceField = $(element).attr('data-aom-price-field');
        var userMembership = $(element).attr('data-aom-membershipid');

        var quantity = $('[name="product_details[' + sectionID + '][amount]"]').val();

        var request_data = {
            block: 'product_price_data',
            productid: productID,
            quantity: quantity,
            product_options: getProductOptions(sectionID),
            membershipid: userMembership,
            use_aom_user: 'Y'
        };

        return ajax.query.add(
            {
                // request info
                type: 'GET',
                url: 'get_block.php',
                data: request_data,
                // callback function
                success: function(value) {
                    if ($.isNumeric(value)) {
                        $('[name="product_details[' + sectionID + '][' + priceField + ']"]')
                                .val(value)
                                .change();
                    } else {
                        xAlert(value, lbl_error, 'E');
                    }
                },
                // error handling
                error: function() {
                    xAlert(txt_ajax_error_note, lbl_error, 'E');
                }
            }
        ) !== false;
    };

    onRestoreValue = function () {
        var control = $(this).prev();

        setControlValue(control, getOriginalValue(control));
        compareWithOriginal.apply(control);

        var related = $('[name="' + getRelatedControl(control) + '"]');

        if (
            related.length > 0
            && getControlValue(related) !== false
        ) {
            related.click();
        }

        $(this).remove();
    };

    onChange = function () {
        compareWithOriginal.apply(this);
    };

    $(document).ready(init);
})($);
