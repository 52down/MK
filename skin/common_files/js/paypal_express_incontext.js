/**
 * PayPal Express In-cotext Checkout controller
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @version    3fffea33348f9023933aeaa060f58c3fc5f68d87, v4 (xcart_4_7_3), 2015-07-03 17:30:07, paypal_express_incontext.js, mixon
 *
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (typeof window.paypalCheckoutReady !== 'function') {
    window.paypalCheckoutReady = function () {
        paypal.checkout.setup(xcPayPalIncontextMerchantID,
            {
                container: $('[data-paypal-button]').toArray()
            }
        );
    };
} else {
    // initiate checkout
    window.paypalCheckoutReady();
}

(function (d, s, id) {
    var js, ref = d.getElementsByTagName(s)[0];
    if (!d.getElementById(id)) {
        js = d.createElement(s);
        js.id = id;
        js.async = true;
        js.src = "//www.paypalobjects.com/api/checkout.js";
        ref.parentNode.insertBefore(js, ref);
    }
}(document, "script", "paypal-js"));
