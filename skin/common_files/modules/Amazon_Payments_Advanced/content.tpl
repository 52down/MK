{*
5b047d743e66a0679ccdbf103f3f76df4244f63b, v6 (xcart_4_7_7), 2016-09-29 16:40:20, content.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}
<script type="text/javascript">
//<![CDATA[

var txt_accept_terms_err = '{$lng.txt_accept_terms_err|wm_remove|escape:"javascript"}';
var msg_being_placed     = '{$lng.msg_order_is_being_placed|wm_remove|escape:"javascript"}';

//]]>
</script>

<h1>{$lng.lbl_amazon_pa_checkout}</h1>

{include file="modules/One_Page_Checkout/opc_authbox.tpl"}

<ul id="opc-sections" class="amazon-payment-advanced">
  <li class="opc-section amazon-widgets">
    {* amazon widgets *}
    <div id="addressBookWidgetDiv"></div>
    <br />
    <div id="walletWidgetDiv"></div>
  </li>

  <li class="opc-section last" id="opc_summary_li">
    {if $config.Shipping.enable_shipping eq "Y"}
      {include file="modules/One_Page_Checkout/opc_shipping.tpl" checkout_module="One_Page_Checkout"}
    {/if}
    {include file="modules/One_Page_Checkout/opc_summary.tpl" button_href="javascript: return func_amazon_pa_place_order();" payment_script_url="amazon_checkout.php" checkout_module="One_Page_Checkout"}
  </li>
</ul>

{include file="customer/noscript.tpl" content=$lng.txt_opc_noscript_warning}
