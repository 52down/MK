/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * CanadaPost registration wizard scripts
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Michael Bugrov
 * @version    e45e0e6de7ab90126e5e377e881e0567b211cf08, v1 (xcart_4_7_5), 2016-02-18 00:49:24, mod_CPC_wizard.js, mixon
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

$(document).ready(function() {

    var appendInput = function ($form, name, value) {
        var $input = $('<input>');

        $input.attr('type','hidden');
        $input.attr('name',name);
        $input.attr('value',value);

        $form.append($input);
    };

    $('#CPC_register_button').on('click', function() {
        var wizard = $(this).data('wizard');

        var $form = $('<form>');

        $form.attr('method', 'post');
        $form.attr('action', wizard.merchantRegUrl);

        appendInput($form, 'return-url', wizard.wizardReturnUrl);
        appendInput($form, 'token-id', wizard.tokenId);
        appendInput($form, 'platform-id', wizard.platformId);

        $form.appendTo('body').submit();
    });
});
