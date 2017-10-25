{*
47f0ee57db1266f275a2d7b0e1331eb446f57d28, v20 (xcart_4_7_7), 2016-10-28 11:29:23, checkout_js.tpl, random

vim: set ts=2 sw=2 sts=2 et:
*}

{if $active_modules.XPayments_Connector and $config.XPayments_Connector.xpc_use_iframe eq 'Y'}
  {load_defer file="modules/XPayments_Connector/iframe_common.js" type="js"}
{/if}

<script type="text/javascript">
//<![CDATA[
var txt_accept_terms_err = '{$lng.txt_accept_terms_err|wm_remove|escape:"javascript"}';
var lbl_warning = '{$lng.lbl_warning|wm_remove|escape:"javascript"}';

{literal}
function checkCheckoutForm() {
  var result = true;
{/literal}
  var unique_key = "{unique_key}";

{literal}

  if (!result) {
    return false;
  }

  var termsObj = $('#accept_terms')[0];
  if (termsObj && !termsObj.checked) {
    xAlert(txt_accept_terms_err, lbl_warning, 'W');
    return false;
  }

  if (result && checkDBClick()) {
    if (document.getElementById('msg'))
       document.getElementById('msg').style.display = '';

    if (document.getElementById('btn_box'))
       document.getElementById('btn_box').style.display = 'none';
  }

  return result;
}

var checkDBClick = function() {
  var clicked = false;
  return function() {
    if (clicked)
      return false;

    clicked = true;
    return true;
  }
}();

function checkCheckoutFormXP() {
  if (checkCheckoutForm()) {
    var isXPCAllowSaveCard = ($('input[type=checkbox][name=allow_save_cards]').is(':checked') || $('input[type=hidden][name=allow_save_cards]').val() == 'Y') ? 'Y' : '';
    var partnerId = ($('input[name=partner_id]').length) ? $('input[name=partner_id]').val() : '';

    var extraData = {
      xpc_action: 'xpc_before_place_order',
      allow_save_cards: isXPCAllowSaveCard,
      partner_id: partnerId,
      Customer_Notes: $('textarea[name=Customer_Notes]').val()
    };

    // Save newsletter subscription
    $.each($('input[name^=mailchimp_subscription]'), function(key, val) {
      if (val.checked) {
        extraData[val.name] = 'Y';
      }
    });

    $.post(
      'payment/cc_xpc_iframe.php',
      extraData,
      function() {
        if (window.postMessage && window.JSON) {
          var message = {
            message: 'submitPaymentForm',
            params: {}
          };

          if (window.frames['xpc_iframe'])
            window.frames['xpc_iframe'].postMessage(JSON.stringify(message), '*');
        }
      }
    );

  }

  return false;
}

function messageListener(event) {
  if (event.source === window.frames['xpc_iframe'] && window.JSON) {
    var msg = JSON.parse(event.data);
    if (msg) {
      if ('paymentFormSubmitError' === msg.message) {
        $('#msg').hide();
        $('#btn_box').show();
        if (msg.params.type !== undefined && msg.params.type != 0) {
          $('.xpc_iframe_container').unblock();
          $('#xpc_iframe').height(0);
          var errorMsg = (msg.params.error === undefined) ? '' : msg.params.error;

          if (XPC_IFRAME_TOP_MESSAGE == msg.params.type) {

            showTopMessage(errorMsg, 'e');

          } else {

            popupOpen(
              'payment/cc_xpc_iframe.php?xpc_action=xpc_popup'
              + '&message=' + encodeURIComponent(errorMsg)
              + '&type=' + parseInt(msg.params.type)
              + '&paymentid=' + this.paymentid
              + '&payment_method=' + $('input[name=payment_method]').val()
            );
          }
        }

      }

      if ('ready' === msg.message) {
        msg.params.height >= 0 && $('#xpc_iframe').height(msg.params.height);

        $('.xpc_iframe_container').unblock();
      }

      if ('showMessage' === msg.message) {
        xAlert(msg.params.text, '', 'I');
      }

    }
  }
}

if (window.addEventListener)
  addEventListener('message', messageListener, false);
else
  attachEvent('onmessage', messageListener);

{/literal}
//]]>
</script>

{if $active_modules.TaxCloud}
  {include file="modules/TaxCloud/exemption_js.tpl"}
{/if}

