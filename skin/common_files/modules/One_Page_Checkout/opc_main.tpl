{*
e96ba40e07a249d0afb40e7f661b6d0a32a57a88, v16 (xcart_4_7_7), 2017-01-24 12:33:10, opc_main.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{include file="modules/One_Page_Checkout/opc_init_js.tpl"}
{load_defer file="modules/One_Page_Checkout/ajax.checkout.js" type="js"}
{if $active_modules.TaxCloud}
  {include file="modules/TaxCloud/exemption_js.tpl"}
{/if}
{if $active_modules.Abandoned_Cart_Reminder && $login eq '' && $config.Abandoned_Cart_Reminder.abcr_ajax_save eq 'Y'}
  {load_defer file="modules/Abandoned_Cart_Reminder/checkout.js" type="js"}
{/if}

<h1>{$lng.lbl_checkout}</h1>

{include file="modules/One_Page_Checkout/opc_authbox.tpl"}

{if $amazon_pa_enabled}
  {include file="modules/Amazon_Payments_Advanced/checkout_btn.tpl" hide_or_use_text='Y'}
{/if}

<ul id="opc-sections">
  <li class="opc-section">
    {include file="modules/One_Page_Checkout/opc_profile.tpl"}
  </li>

  <li class="opc-section" id="opc_shipping_payment">

    {if $config.Shipping.enable_shipping eq "Y"}
      {include file="modules/One_Page_Checkout/opc_shipping.tpl"}
    {/if}

    {include file="modules/One_Page_Checkout/opc_payment.tpl"}

  </li>

  <li class="opc-section last" id="opc_summary_li">
    {include file="modules/One_Page_Checkout/opc_summary.tpl"}
  </li>

</ul>

{include file="customer/noscript.tpl" content=$lng.txt_opc_noscript_warning}
