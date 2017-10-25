{*
2cd033e5331c1dd1ebfc2f7ca08fe8e2a78666b5, v2 (xcart_4_7_5), 2016-02-29 12:11:37, mod_CPC.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}
{if $carrier eq "CPC"}
{*************************************************************
 *  CANADA POST OPTIONS                                      *
 *************************************************************}

{capture name=dialog}

<div align="right"><a href="shipping.php?carrier=CPC#rt">{$lng.lbl_X_shipping_methods|substitute:"service":"Canada Post"}</a></div>

<form method="post" action="shipping_options.php">
<input type="hidden" name="carrier" value="CPC" />

<table cellpadding="3" cellspacing="1" width="100%">
{if $isOnBehalfOfAMerchant eq 'N'}
<tr>
  <td><label for="customer_number"><b>{$lng.lbl_cpc_customer_number}:</b></label></td>
  <td><input type="text" name="customer_number" id="customer_number" size="20" value="{$shipping_options.cpc.param03|escape}" /></td>
</tr>

<tr>
  <td><label for="contract_id"><b>{$lng.lbl_cpc_contract_id}:</b></label></td>
  <td><input type="text" name="contract_id" id="contract_id" size="20" value="{$shipping_options.cpc.param04|escape}" /></td>
</tr>

<tr>
  <td><label for="quote_type"><b>{$lng.lbl_cpc_quote_type}:</b></label></td>
  <td><select name="quote_type" id="quote_type">
    <option value="commercial"{if $shipping_options.cpc.param05 eq "commercial"} selected="selected"{/if}>commercial</option>
    <option value="counter"{if $shipping_options.cpc.param05 eq "counter"} selected="selected"{/if}>counter</option>
  </select>{include file="main/tooltip_js.tpl" text=$lng.txt_cpc_quote_type_help type="img" id="cpc_quote_type_help"}</td>
</tr>
{/if}

{include file="admin/main/shipping_package_limits.tpl" shipper_options=$shipping_options.cpc shipper="Canada Post"}

<tr>
  <td colspan="2"><hr /></td>
</tr>

<tr>
  <td><label for="status_new_method"><b>{$lng.lbl_carrier_new_method_status}:</b></label></td>
  <td><input type="checkbox" name="status_new_method" id="status_new_method" value="new_method_is_enabled"{if $shipping_options.cpc.param01 eq "new_method_is_enabled"} checked="checked"{/if} /></td>
</tr>

<tr>
  <td><b>{$lng.lbl_shipping_cost_convertion_rate}:</b><br />
  <font class="SmallText">{$lng.txt_shipping_cost_convertion_rate_us_dollars}</font>
  </td>
  <td valign="top"><input type="text" name="currency_rate" size="10" value="{$shipping_options.cpc.currency_rate|escape}" /></td>
</tr>

<tr>
    <td colspan="2"><br />{include file="main/subheader.tpl" title=$lng.lbl_package_options class="grey"}</td>
</tr>

<tr>
  <td width="30%"><b>{$lng.lbl_options}:</b></td>
  <td width="70%">
    <select name="options[]" multiple="multiple" size="6">
      <option value="SO"{if $shipping_options.cpc.options.SO} selected="selected"{/if}>Singnature</option>
      <option value="PA18"{if $shipping_options.cpc.options.PA18} selected="selected"{/if}>Proof of Age Required - 18</option>
      <option value="PA19"{if $shipping_options.cpc.options.PA19} selected="selected"{/if}>Proof of Age Required - 19</option>
      <option value="HFP"{if $shipping_options.cpc.options.HFP} selected="selected"{/if}>Card for pickup</option>
      <option value="DNS"{if $shipping_options.cpc.options.DNS} selected="selected"{/if}>Do not safe drop</option>
      <option value="LAD"{if $shipping_options.cpc.options.LAD} selected="selected"{/if}>Leave at door - do not card</option>
    </select>
  </td>
</tr>

{include file="admin/main/shipping_value_of_contents.tpl" shipper_options=$shipping_options.cpc lng_label=$lng.lbl_coverage name_prefix='coverage' param_name='param07' fixed_value_name='coverage_fixed_value'}

{include file="admin/main/shipping_value_of_contents.tpl" shipper_options=$shipping_options.cpc lng_label=$lng.lbl_cod name_prefix='cod' param_name='param02' fixed_value_name='cod_fixed_value'}

<tr>
  <td colspan="2" class="SubmitBox"><input type="submit" value="{$lng.lbl_apply|strip_tags:false|escape}" /></td>
</tr>

</table>
</form>

{/capture}
{assign var="section_title" value=$lng.lbl_X_shipping_options|substitute:"service":"Canada Post"}
{include file="dialog.tpl" content=$smarty.capture.dialog title=$section_title extra='width="100%"'}

{/if}
