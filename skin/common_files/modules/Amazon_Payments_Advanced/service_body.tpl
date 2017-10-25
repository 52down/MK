{*
fdb7f7b22942cecc3ca713dc966bbc2e1c594aed, v7 (xcart_4_7_8), 2017-03-06 18:41:27, service_body.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $amazon_pa_enabled}
  {if $config.Amazon_Payments_Advanced.amazon_pa_mode eq 'live'}
    {assign var="wdt_url" value="https://static-na.payments-amazon.com/OffAmazonPayments/us/js/Widgets.js"}
    {if $config.Amazon_Payments_Advanced.amazon_pa_region eq 'de'}
      {assign var="wdt_url" value="https://static-eu.payments-amazon.com/OffAmazonPayments/de/js/Widgets.js"}
    {elseif $config.Amazon_Payments_Advanced.amazon_pa_region eq 'uk'}
      {assign var="wdt_url" value="https://static-eu.payments-amazon.com/OffAmazonPayments/uk/js/Widgets.js"}
    {/if}
  {else}
    {assign var="wdt_url" value="https://static-na.payments-amazon.com/OffAmazonPayments/us/sandbox/js/Widgets.js"}
    {if $config.Amazon_Payments_Advanced.amazon_pa_region eq 'de'}
      {assign var="wdt_url" value="https://static-eu.payments-amazon.com/OffAmazonPayments/de/sandbox/js/Widgets.js"}
    {elseif $config.Amazon_Payments_Advanced.amazon_pa_region eq 'uk'}
      {assign var="wdt_url" value="https://static-eu.payments-amazon.com/OffAmazonPayments/uk/sandbox/js/Widgets.js"}
    {/if}
  {/if}

  {assign var=amazon_pa_widgets_skipt_url value="{$wdt_url}?sellerId={$config.Amazon_Payments_Advanced.amazon_pa_sid}"}

{capture name=amazon_pa_init_javascript_code}
var AMAZON_PA_CONST = {ldelim}
  SID: '{$config.Amazon_Payments_Advanced.amazon_pa_sid}',
  CID: '{$config.Amazon_Payments_Advanced.amazon_pa_cid}',
  MODE: '{$config.Amazon_Payments_Advanced.amazon_pa_mode}',
  OREFID: '{$amazon_pa_order_ref_id}',
  TOKEN: '{$amazon_pa_client_access_token}',
  URL: '{$amazon_pa_widgets_skipt_url}'
{rdelim};
{/capture}
{load_defer file="amazon_pa_init_javascript_code" direct_info=$smarty.capture.amazon_pa_init_javascript_code type="js"}

  {load_defer file="modules/Amazon_Payments_Advanced/func.js" type="js"}
{/if}
