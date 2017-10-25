{*
3e8deb3feb2702bbc410813cc1a4a699eaf27b1a, v2 (xcart_4_7_7), 2016-07-15 20:02:37, mod_AP.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $carrier eq "APOST"}
{*************************************************************
 *  AUSTRALIA POST OPTIONS                                   *
 *************************************************************}

{capture name=dialog}

<div align="right"><a href="shipping.php?carrier=APOST#rt">{$lng.lbl_X_shipping_methods|substitute:"service":"Australia post"}</a></div>

<form method="post" action="shipping_options.php">
<input type="hidden" name="carrier" value="APOST" />

<table width="100%">

{include file="admin/main/shipping_package_limits.tpl" shipper_options=$shipping_options.apost shipper="Australia Post"}

<tr>
  <td colspan="2"></td>
</tr>

<tr>
    <td colspan="2"><b>{$lng.lbl_note}</b>: {$lng.txt_apost_limits_note}</td>
</tr>

<tr>
  <td colspan="2"><hr /></td>
</tr>

<tr>
  <td><label for="status_new_method"><b>{$lng.lbl_carrier_new_method_status}:</b></label></td>
  <td><input type="checkbox" name="status_new_method" id="status_new_method" value="new_method_is_enabled"{if $shipping_options.apost.param01 eq "new_method_is_enabled"} checked="checked"{/if} /></td>
</tr>

<tr>
  <td><b>{$lng.lbl_shipping_cost_convertion_rate}:</b><br />
  <span class="SmallText">{$lng.txt_shipping_cost_convertion_rate_au_dollars}</span>
  </td>
  <td valign="top"><input type="text" name="currency_rate" size="10" value="{$shipping_options.apost.currency_rate|escape}" /></td>
</tr>


{include file="admin/main/shipping_value_selector.tpl" options=$shipping_options.apost.package_types lng_label=$lng.lbl_package_type param_prefix='apost' param_name='param03' toggle_selector='.use-package-dimensions' toggle_value='AUS_PARCEL_TYPE_BOXED_OTH'}

{include file="admin/main/shipping_value_checkbox.tpl" param_prefix='apost' param_name='param04' lng_cbx_label=$lng.lbl_apost_extra_cover lng_input_label=$lng.lbl_apost_extra_cover_value lng_input_text=$lng.txt_apost_extra_cover_note}

<tr>
  <td><b>{$lng.lbl_service_options}:</b></td>
  <td><div style="line-height: 170%;"><a href="javascript:void(0);" id="select_all_services_link">{$lng.lbl_select_all}</a></div>
  <select name="selected_apost_services[]" id="selected_apost_services" multiple="multiple" size="{$shipping_options.apost.service_options|@count}">
    {foreach from=$shipping_options.apost.service_options item=service}
      <option value="{$service.key}"{if $service.selected} selected="selected"{/if}>{$service.name}</option>
    {/foreach}
  </select>
  {capture name=select_all_services_js}{literal}
    $(document).ready( function() {
      $('#select_all_services_link').click(function() {
          $('#selected_apost_services option').prop('selected', true);
      })
    });
  {/literal}{/capture}
  {load_defer file="javascript_code" direct_info=$smarty.capture.select_all_services_js type="js"}
  </td>
</tr>


<tr>
  <td colspan="2" class="SubmitBox"><input type="submit" value="{$lng.lbl_apply|strip_tags:false|escape}" /></td>
</tr>
</table>
</form>

{/capture}
{assign var="section_title" value=$lng.lbl_X_shipping_options|substitute:"service":"Australia Post"}
{include file="dialog.tpl" content=$smarty.capture.dialog title=$section_title extra='width="100%"'}

{/if}
