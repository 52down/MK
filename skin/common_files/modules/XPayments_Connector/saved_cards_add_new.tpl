{*
fee1a20fd634bde49eb5dd1f82707c7298951e69, v13 (xcart_4_7_6), 2016-06-10 16:29:31, saved_cards_add_new.tpl, random

vim: set ts=2 sw=2 sts=2 et:
*}
{include file="modules/XPayments_Connector/saved_cards_add_new_js.tpl"}

<div id="xpc_iframe_container" style="display: none;">
 
  {capture name=xpc_save_cc_amount}{currency value=$config.XPayments_Connector.xpc_save_cc_amount}{/capture}
  {$lng.txt_xpc_saved_cards_add_new|substitute:amount:$smarty.capture.xpc_save_cc_amount}
  <br /><br />
  <div id="xpc_iframe_section" style="display: inline-block;">
    <form name="xpc_save_card_form" onsubmit="javascript: return submitXPCFrame();">
    {include file="modules/XPayments_Connector/xpc_iframe.tpl" save_cc=true}
    <div id="xpc_submit" class="button-row">
      {include file="customer/buttons/button.tpl" button_title=$lng.lbl_submit type="input" additional_button_class="main-button"}
    </div>
    </form>
  </div>
  <div id="xpc_address_hint">
    <strong>{$lng.lbl_billing_address}:</strong>
    {include file="customer/main/address_details_html.tpl" address=$xpc_address default_fields=$xpc_default_fields}
    {assign var=modify_url value="javascript: popupOpen('popup_address.php?mode=select&amp;for=save_card&amp;type=B');"}
    {assign var=link_href value="popup_address.php?mode=select&for=save_card&type=B"}
    {include file="customer/buttons/button.tpl" button_title=$lng.lbl_change href=$modify_url link_href=$link_href|default:$modify_url}
  </div>

</div>
