/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Functions for Amazon Payments Advanced module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @version    ff56eee59e7aedda5d9c49be26fa7acaed0babc6, v14 (xcart_4_7_8), 2017-02-09 17:08:33, func.js, mixon
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

/* global amazon, ajax, store_language, need_shipping, shippingid, OffAmazonPayments, AMAZON_PA_CONST, amazon_pa_buttons_list, lbl_error, msg_being_placed, txt_accept_terms_err, txt_ajax_error_note */
/* global amazon_pa_place_order_enabled, amazon_pa_address_selected, amazon_pa_payment_selected */

/**
 * Checks address and update UI by provided amazon order reference id
 *
 * @returns {void}
 */
function func_amazon_pa_check_address() {

  $('#opc_shipping').block();
  $('#opc_totals').block();

  $.post('amazon_checkout.php', {
      'mode': 'check_address'
    },
    function (data) {

      if (data === 'error') {
        xAlert(txt_ajax_error_note, lbl_error, 'E');
        return;
      }

      ajax.core.loadBlock($('#opc_shipping'), 'amazon_pa_shipping', {}, function () {

        amazon_pa_address_selected = true;
        func_amazon_pa_on_change_shipping();

      });

      ajax.core.loadBlock($('#opc_totals'), 'amazon_pa_totals');
    }
  );
}

/**
 * Checks payment and update UI by provided amazon order reference id
 *
 * @returns {void}
 */
function func_amazon_pa_check_payment() {

  amazon_pa_payment_selected = true;
  func_amazon_pa_check_checkout_button();
}

/**
 * Checks checkout button availability
 *
 * @returns {void}
 */
function func_amazon_pa_check_checkout_button() {

  if (
    amazon_pa_payment_selected && amazon_pa_address_selected && func_amazon_ps_is_checkout_ready()
  ) {
    // enable place order button
    $('button.place-order-button').removeClass('inactive');
    amazon_pa_place_order_enabled = true;
  } else {
    // disable place order button
    $('button.place-order-button').addClass('inactive');
    amazon_pa_place_order_enabled = false;
  }
}

/**
 * Return TRUE if checkout is ready
 *
 * @returns {Boolean}
 */
function func_amazon_ps_is_checkout_ready() {

  if (
    need_shipping && (undefined === shippingid || shippingid <= 0)
  ) {
    return false;
  }
  return true;
}

/**
 * Updates UI when customer changes shipping method
 *
 * @returns {void}
 */
function func_amazon_pa_on_change_shipping() {

  $('#opc_totals').block();

  shippingid = $('#opc_shipping').find("input[type='radio']:checked").val();

  if (shippingid) {

    $.post(
      'amazon_checkout.php',
      {
        'mode': 'change_shipping',
        'shippingid': shippingid
      },
      function () {
        ajax.core.loadBlock($('#opc_totals'), 'amazon_pa_totals');
      }
    );

  } else {

    $('#opc_totals').unblock();
  }

  func_amazon_pa_check_checkout_button();
}

/**
 * Place order
 *
 * @returns {Boolean}
 */
function func_amazon_pa_place_order() {

  if (!amazon_pa_place_order_enabled) {
    return false;
  }

  // agreement
  var termsObj = $('#accept_terms').get(0);
  if (termsObj && !termsObj.checked) {
    xAlert(txt_accept_terms_err, '', 'W');
    return false;
  }

  // prevent double submission
  amazon_pa_place_order_enabled = false;
  showXCblockUI(msg_being_placed);

  return true;
}

function func_amazon_pa_get_checkout_widget_design()
{
  var design = {
    size: {width: '400px', height: '260px'}
  };

  if (isXCResponsiveSkinOpenOnMobileDevice()) {
    delete design['size'];
    if ($(window).width() < 568) {
      design['designMode'] = 'smartphoneCollapsible';
    } else {
      design['designMode'] = 'responsive';
    }
  }

  return design;
}

/**
 * Initialize buttons widgets
 *
 * @returns {void}
 */
function func_amazon_pa_init_buttons()
{
  if (typeof amazon_pa_buttons_list !== 'undefined') {
    amazon_pa_buttons_list.forEach(function (element) {
      func_amazon_pa_add_button(element);
    });
  }
}

/**
 * Initialize login widget
 *
 * @returns {void}
 */
function func_amazon_pa_init_login()
{
  amazon.Login.setClientId(AMAZON_PA_CONST.CID);
}

/**
 * Initialize checkout widgets
 *
 * @returns {Mixed}
 */
function func_amazon_pa_init_checkout() {

  if (typeof OffAmazonPayments === 'undefined') {
    return false;
  }

  if ($('input[name=shippingid]:checked').length === 0) {
    $('button.place-order-button').addClass('inactive');
  }

  $.blockUI.defaults.baseZ = 200000; // default is 1000 and it's too small

  $(document).on('change','input[name=shippingid]', func_amazon_pa_on_change_shipping);

  new OffAmazonPayments.Widgets.AddressBook({
    sellerId: AMAZON_PA_CONST.SID,
    amazonOrderReferenceId: AMAZON_PA_CONST.OREFID,
    design: func_amazon_pa_get_checkout_widget_design(),

    onAddressSelect: function () {
      func_amazon_pa_check_address(AMAZON_PA_CONST.OREFID);
    },
    onError: function (error) {
      if (AMAZON_PA_CONST.MODE === 'test') {
        alert('Amazon AddressBook widget error: code=' + error.getErrorCode() + ' msg=' + error.getErrorMessage());
      }
    }

  }).bind('addressBookWidgetDiv');

  new OffAmazonPayments.Widgets.Wallet({
    sellerId: AMAZON_PA_CONST.SID,
    amazonOrderReferenceId: AMAZON_PA_CONST.OREFID,
    design: func_amazon_pa_get_checkout_widget_design(),

    onPaymentSelect: function () {
      func_amazon_pa_check_payment(AMAZON_PA_CONST.OREFID);
    },
    onError: function (error) {
      if (AMAZON_PA_CONST.MODE === 'test') {
        alert('Amazon Wallet widget error: code=' + error.getErrorCode() + ' msg=' + error.getErrorMessage());
      }
    }
  }).bind('walletWidgetDiv');

}

/**
 * Adds button widget to DOM
 *
 * @param {string} elmid
 * @returns {Mixed}
 */
function func_amazon_pa_add_button(elmid) {

  if ($('#' + elmid).length <= 0) {
    return false;
  }

  if (typeof OffAmazonPayments === 'undefined') {
    return false;
  }

  var authRequest;
  var addressConsentToken;

  var language = store_language.toLocaleLowerCase() + '-' + store_language.toLocaleUpperCase();

  OffAmazonPayments.Button(elmid, AMAZON_PA_CONST.SID, {
    type:  'PwA',
    color: 'Gold',
    size:  'medium',
    language: language,

    authorization: function() {
      loginOptions = {scope: 'payments:widget payments:shipping_address', popup: true};
      authRequest = amazon.Login.authorize (loginOptions,
        function(response) {
          addressConsentToken = response.access_token;
        });
    },
    onSignIn: function (orderReference) {
      var referenceId = orderReference.getAmazonOrderReferenceId();

      if (!referenceId) {
        alert('Amazon put button widget error: referenceId missing');
      } else {
        window.location = 'amazon_checkout.php'
          + '?amz_pa_gaorid=' + orderReference.getAmazonOrderReferenceId()
          + '&amz_pa_gaact=' + addressConsentToken;
      }
    },
    onError: function (error) {
      if (AMAZON_PA_CONST.MODE === 'test') {
        alert('Amazon put button widget error: code=' + error.getErrorCode() + ' msg=' + error.getErrorMessage());
      }
    }
  });
}

var amazon_pa_place_order_enabled = false;
var amazon_pa_address_selected = false;
var amazon_pa_payment_selected = false;

/**
 * Executed once Amazon login widget is loaded
 *
 * @returns {vaoid}
 */
window.onAmazonLoginReady = function() {
  func_amazon_pa_init_login();
  func_amazon_pa_init_buttons();
};

/**
 * Executed once Amazon checkout widgets are loaded
 *
 * @returns {vaoid}
 */
window.onAmazonPaymentsReady = function() {
  func_amazon_pa_init_checkout();
};

// Init Amazon Widgets.js
$.getScript(AMAZON_PA_CONST.URL, function() {
  $(window).on('resize', func_amazon_pa_init_checkout);
});
