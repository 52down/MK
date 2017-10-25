{*
aba9bb66ca0b7941017e06ce77105af80df2c3c0, v4 (xcart_4_7_4), 2015-07-16 11:15:27, checkout_shipping_methods.tpl, mixon 

vim: set ts=2 sw=2 sts=2 et:
*}
{*  ERROR: no shipping methods available [begin]  *}

{if $shipping_calc_error ne ""}
  <div>{$shipping_calc_service} {$lng.lbl_err_shipping_calc}</div>
  <div class="error-message">{$shipping_calc_error}</div>
{/if}

{if $shipping eq "" and $need_shipping}
  <div class="text-block error-message">{$lng.lbl_no_shipping_for_location}</div>

{elseif $userinfo.address.S ne '' and $shipping eq '' and $config.Shipping.do_not_require_shipping eq 'Y' and $cart.shipping_cost eq 0}
  <div class="text-block">{$lng.lbl_free_shipping}</div>

{elseif $shipping eq "" and $cart.shipping_cost gt 0}
  <div class="text-block">{$lng.lbl_fixed_shipping_cost} ({currency value=$cart.shipping_cost})</div>

{elseif $shipping eq '' and $config.Shipping.enable_shipping eq 'Y'}
  <div class="text-block">{$lng.lbl_shipping_address_empty_warn}</div>
{/if}

{*  ERROR: no shipping methods available [end]  *}

{*  Select the shipping carrier [begin]  *}
{if $userinfo ne "" or $config.General.apply_default_country eq "Y" or $cart.shipping_cost gt 0}

  {if $active_modules.UPS_OnLine_Tools and $config.Shipping.realtime_shipping eq "Y" and $config.Shipping.use_intershipper ne "Y" and $show_carriers_selector eq "Y" and $is_ups_carrier_empty ne "Y" and $is_other_carriers_empty ne "Y"}
    <label class="form-text">
      {$lng.lbl_shipping_carrier}:
      {include file="main/select_carrier.tpl" name="selected_carrier" id="selected_carrier" onchange="javascript: self.location='cart.php?mode=`$main`&amp;action=update&amp;selected_carrier='+this.options[this.selectedIndex].value;"}
    </label>
    <br />
    <br />
  {/if}
{/if}
{*  Select the shipping carrier: [end]  *}

{*  Select the shipping method: [begin]  *}
{if $shipping ne "" and $need_shipping}

  {if $dhl_account_used}
      <div>{$lng.txt_dhl_account_checkout_note}</div>
  {/if}{* $dhl_account_used *}

  {if $userinfo ne '' or $config.General.apply_default_country eq "Y" or $cart.shipping_cost gt 0}
    <div class="checkout-shippings">
      {include file="modules/`$checkout_module`/shipping_methods.tpl"}
    </div>
  {/if}

{else}

  <input type="hidden" name="shippingid" value="0" />

{/if}
{*  Select the shipping method: [end]  *}

{include file="customer/main/dhl_ext_countries.tpl" onchange=true}
