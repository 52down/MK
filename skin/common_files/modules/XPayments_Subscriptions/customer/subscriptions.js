/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * XPayments Subscriptions - Subscriptions js
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @version    abb7bdb4113eb817a1fd17d3569538080df45f5d, v5 (xcart_4_7_8), 2017-05-30 16:33:09, subscriptions.js, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

$(function () {
    $('.card-change-btn').click(function() {
        var id = $(this).data('subscription-id');
        $('[id^=saved-cards-container-]:not(.null-card)').hide();
        $('[id^=current-card-]:not(.null-card)').show();
        $('#saved-cards-container-' + id).show();
        $('#current-card-' + id).hide();
    });
});
