{*
fee1a20fd634bde49eb5dd1f82707c7298951e69, v1 (xcart_4_7_6), 2016-06-10 16:29:31, saved_cards_add_new_js.tpl, random

vim: set ts=2 sw=2 sts=2 et:
*}
{load_defer file="modules/XPayments_Connector/iframe_common.js" type="js"}
<script type="text/javascript">
//<![CDATA[
var save_cc_paymentid = '{$xpc_save_cc_paymentid}';
var xpc_location = '{if $is_admin}{$catalogs.admin}/xpc_payment.php?for_userid={$userinfo.id}&{else}{$catalogs.customer}/payment/cc_xpc_iframe.php?{/if}';
var popup_location = '{$catalogs.customer}/payment/cc_xpc_iframe.php?xpc_action=xpc_popup';

{literal}

function showXPCFrame(caller) {
  $('#xpc_iframe').attr('src', xpc_location + 'paymentid=' + save_cc_paymentid + '&save_cc=Y');
  $(caller).hide(100);
  $('#xpc_iframe_container').show(200);
  $('#xpc_iframe_section').block();
}

function submitXPCFrame() {
  $('#xpc_iframe_section').block();
  if (window.postMessage && window.JSON) {
    var message = {
      message: 'submitPaymentForm',
      params: {}
    };

    if (window.frames['xpc_iframe'])
      window.frames['xpc_iframe'].postMessage(JSON.stringify(message), '*');
  }
  return false;
}

function messageListener(event) {
  if (event.source === window.frames['xpc_iframe'] && window.JSON) {
    var msg = JSON.parse(event.data);
    if (msg) {
      if ('paymentFormSubmitError' === msg.message) {
        $('#xpc_iframe_section').unblock();
        if (msg.params.type !== undefined && msg.params.type != XPC_IFRAME_DO_NOTHING) {
          var errorMsg = (msg.params.error === undefined) ? '' : msg.params.error;

          if (XPC_IFRAME_TOP_MESSAGE == msg.params.type) {

            showTopMessage(errorMsg, 'e');

          } else {

            popupOpen(
              popup_location
              + '&message=' + encodeURIComponent(errorMsg)
              + '&type=' + parseInt(msg.params.type)
              + '&paymentid=' + save_cc_paymentid
              + '&payment_method=' + lbl_error
              + '&save_cc=Y'
            );

          }
        }
      }

      if ('ready' === msg.message) {
        msg.params.height >= 0 && $('#xpc_iframe').height(msg.params.height);
        $('#xpc_iframe_section').unblock();
      }
    }
  }
}

if (window.addEventListener)
  addEventListener('message', messageListener, false);
else
  attachEvent('onmessage', messageListener);

function xpcSelectAddress(elm) {

  var formid = $(elm).attr('id').replace('address_box_', 'address_');
  var f = $('#' + formid).get(0);

  $('.popup-dialog').dialog('close');

  f.submit();

  return true;

}

$(document).on(
  'click',
  '.address-select',
  function(e) {
    xpcSelectAddress(this);
  }
);
{/literal}

{if $auto_open_save_card}
{literal}
$(function() {
    showXPCFrame($('.xpc-add-new-card-button').first());
})
{/literal}
{/if}
//]]>
</script>
