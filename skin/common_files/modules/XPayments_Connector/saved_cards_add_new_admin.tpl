{*
fdf4c40775b539a54bc228e488550b992e275a43, v4 (xcart_4_7_8), 2017-05-31 11:32:26, saved_cards_add_new_admin.tpl, Ildar

vim: set ts=2 sw=2 sts=2 et:
*}
{include file="modules/XPayments_Connector/saved_cards_add_new_js.tpl" is_admin=true}

<div id="xpc_iframe_container" style="display: none;">

  {capture name=xpc_save_cc_amount}{currency value=$config.XPayments_Connector.xpc_save_cc_amount}{/capture}
  {$lng.txt_xpc_saved_cards_add_new|substitute:amount:$smarty.capture.xpc_save_cc_amount}
  <br /><br />
  <div id="xpc_iframe_section" style="display: inline-block;">
    <form name="xpc_save_card_form" onsubmit="javascript: return submitXPCFrame();">
    {include file="modules/XPayments_Connector/xpc_iframe.tpl" save_cc=true}
    <div id="xpc_submit" class="button-row">
      <input type="submit" value="{$lng.lbl_submit}" />
    </div>
    </form>
  </div>
  <div id="xpc_address_hint">
    <strong>{$lng.lbl_billing_address}:</strong>
    {include file="customer/main/address_details_html.tpl" address=$xpc_address default_fields=$xpc_default_fields}
    <div class="address-line xpc-address-comment">{$lng.txt_xpc_add_new_card_address_admin_note}</div>
  </div>

</div>
