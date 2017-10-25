{*
daab505dce0ecbdfd0feb1acf7301bfac5f21f23, v7 (xcart_4_7_7), 2016-12-19 18:18:47, checkout_btn.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}
{if $amazon_pa_enabled}
<div class="loginAndPayWithAmazonContainer">
    {if (not $std_checkout_disabled or $paypal_express_active) and $hide_or_use_text ne 'Y'}
      <p>{$lng.lbl_or_use}</p>
    {/if}
    <div id="payWithAmazonDiv_{$btn_place}"></div>
{capture name=amazon_pa_button_javascript_code}
if (typeof amazon_pa_buttons_list === 'undefined') {ldelim}
  // Define global var
  var amazon_pa_buttons_list = new Array();
{rdelim}
amazon_pa_buttons_list.push('payWithAmazonDiv_{$btn_place}');
if (
  typeof func_amazon_pa_add_button !== 'undefined'
  && typeof OffAmazonPayments !== 'undefined'
) {ldelim}
  // Add button in case of delayed load
  func_amazon_pa_add_button(amazon_pa_buttons_list.pop());
{rdelim}
{/capture}
{load_defer file="amazon_pa_put_button_javascript_code" direct_info=$smarty.capture.amazon_pa_button_javascript_code type="js"}
</div>
{/if}
