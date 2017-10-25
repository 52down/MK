{*
b22557d68f255e53f54065809ac5c1db158f1d8a, v2 (xcart_4_7_5), 2016-01-29 18:59:55, mod_USPS.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $carrier eq "USPS"}
{*************************************************************
 *  USPS OPTIONS                                             *
 *************************************************************}

{capture name=dialog}

<div align="right"><a href="shipping.php?carrier=USPS#rt">{$lng.lbl_X_shipping_methods|substitute:"service":"U.S.P.S."}</a></div>

<form method="post" action="shipping_options.php">
<input type="hidden" name="carrier" value="USPS" />

<table cellpadding="3" cellspacing="1" width="100%">

{include file="admin/main/shipping_package_limits.tpl" shipper_options=$shipping_options.usps shipper=USPS}

<tr>
  <td><b>{$lng.lbl_usps_girth} ({$config.General.dimensions_symbol}):</b></td>
  <td nowrap="nowrap">
<input type="text" name="dim_girth" value="{$shipping_options.usps.dim_girth|escape}" size="7" />
  </td>
</tr>

<tr>
  <td colspan="2"><hr /></td>
</tr>

<tr>
  <td><label for="status_new_method"><b>{$lng.lbl_carrier_new_method_status}:</b></label></td>
  <td><input type="checkbox" name="status_new_method" id="status_new_method" value="new_method_is_enabled"{if $shipping_options.usps.param01 eq "new_method_is_enabled"} checked="checked"{/if} /></td>
</tr>

<tr>
  <td><label for="use_commercial_rate"><b>{$lng.lbl_usps_use_commercial_rate}:</b></label></td>
  <td><input type="checkbox" name="use_commercial_rate" id="use_commercial_rate" value="Y"{if $shipping_options.usps.use_commercial_rate eq "Y"} checked="checked"{/if} />
  {include file="main/tooltip_js.tpl" text=$lng.txt_usps_use_commercial_rate type="img" id="help_usps_use_commercial_rate1" sticky=true width=500}
  </td>
</tr>

<tr>
  <td><label for="use_commercial_plus_rate"><b>{$lng.lbl_usps_use_commercial_plus_rate}:</b></label></td>
  <td><input type="checkbox" name="use_commercial_plus_rate" id="use_commercial_plus_rate" value="Y"{if $shipping_options.usps.use_commercial_plus_rate eq "Y"} checked="checked"{/if} />
  {include file="main/tooltip_js.tpl" text=$lng.txt_usps_use_commercial_rate type="img" id="help_usps_use_commercial_rate2" sticky=true width=500}
  </td>
</tr>

<tr>
  <td><b>{$lng.lbl_shipping_cost_convertion_rate}:</b><br />
  <font class="SmallText">{$lng.txt_shipping_cost_convertion_rate_us_dollars}</font>
  </td>
  <td valign="top"><input type="text" name="currency_rate" size="10" value="{$shipping_options.usps.currency_rate|escape}" /></td>
</tr>

<tr>
  <td colspan="2"><hr /></td>
</tr>
{*
  International U.S.P.S. section
*}

<tr>
  <td colspan="2"><h3>{$lng.lbl_international_usps}</h3></td>
</tr>

<tr>
  <td width="50%"><b>{$lng.lbl_type_of_mail}:</b></td>
  <td>
  <select name="mailtype">
    <option value="All"{if $shipping_options.usps.mailtype eq "All"} selected="selected"{/if}>All</option>
    <option value="Package"{if $shipping_options.usps.mailtype eq "Package"} selected="selected"{/if}>Package</option>
    <option value="Postcards or aerogrammes"{if $shipping_options.usps.mailtype eq "Postcards or aerogrammes"} selected="selected"{/if}>Postcards or Aerogrammes</option>
    <option value="Envelope"{if $shipping_options.usps.mailtype eq "Envelope"} selected="selected"{/if}>Envelope</option>
    <option value="LargeEnvelope"{if $shipping_options.usps.mailtype eq "LargeEnvelope"} selected="selected"{/if}>Large Envelope</option>
    <option value="FlatRate"{if $shipping_options.usps.mailtype eq "FlatRate"} selected="selected"{/if}>Flat Rate</option>
  </select>
  </td>
</tr>

{include file="admin/main/shipping_value_of_contents.tpl" shipper_options=$shipping_options.usps lng_label=$lng.lbl_usps_value_of_content name_prefix='value_of_content' param_name='param07' fixed_value_name='fixed_value'}

<tr>
  <td><b>{$lng.lbl_usps_container3}:</b></td>
  <td>
  <select name="container_intl">
    <option value="RECTANGULAR"{if $shipping_options.usps.param10 eq "RECTANGULAR"} selected="selected"{/if}>Rectangular</option>
    <option value="NONRECTANGULAR"{if $shipping_options.usps.param10 eq "NONRECTANGULAR"} selected="selected"{/if}>Non Rectangular</option>
  </select>
  </td>
</tr>

<tr>
  <td colspan="2"><hr /></td>
</tr>

<tr>
  <td colspan="2"><h3>{$lng.lbl_domestic_usps}</h3></td>
</tr>

<tr>
  <td><b>{$lng.lbl_services}:</b></td>
  <td><div style="line-height: 170%;"><a href="javascript:void(0);" id="select_all_services_link">{$lng.lbl_select_all}</a></div>
  <select name="selected_services[]" id="selected_services" multiple="multiple" size="{$all_usps_services|@count}">
    {foreach from=$all_usps_services item=service_name}
      <option value="{$service_name}"{if $shipping_options.usps.selected_services[$service_name]} selected="selected"{/if}>{$service_name}</option>
    {/foreach}
  </select>
  {include file="main/tooltip_js.tpl" text=$lng.txt_usps_services_help type="img" id="help_usps_services" sticky=true width=500}
  {capture name=select_all_services_js}{literal}
    $(document).ready( function() {
      $('#select_all_services_link').click(function() {
          $('#selected_services option').prop('selected', true);
      })
    });
  {/literal}{/capture}
  {load_defer file="javascript_code" direct_info=$smarty.capture.select_all_services_js type="js"}
  </td>
</tr>

<tr>
  <td><b>{$lng.lbl_usps_ground_only_indicator}:</b></td>
  <td>
  <select name="ground_only">
    <option value="true"{if $shipping_options.usps.ground_only eq "true"} selected="selected"{/if}>{$lng.lbl_usps_ground_required}</option>
    <option value="false"{if $shipping_options.usps.ground_only eq "false"} selected="selected"{/if}>{$lng.lbl_usps_ground_not_required}</option>
  </select>
  </td>
</tr>

<tr>
  <td><b>{$lng.lbl_machinable}:</b></td>
  <td>
  <select name="machinable">
    <option value="FALSE"{if $shipping_options.usps.param02 eq "FALSE"} selected="selected"{/if}>{$lng.lbl_no}</option>
    <option value="TRUE"{if $shipping_options.usps.param02 eq "TRUE"} selected="selected"{/if}>{$lng.lbl_yes}</option>
  </select>
  </td>
</tr>

<tr>
  <td><b>{$lng.lbl_usps_container}:</b></td>
  <td>
  <select name="container_express" style="max-width: 310px;">
    <option value="None">{$lng.lbl_none}</option>
    <option value="FLAT RATE ENVELOPE"{if $shipping_options.usps.param03 eq "FLAT RATE ENVELOPE"} selected="selected"{/if}>Priority Mail Express Flat Rate Envelope, 12.5 x 9.5</option>
    <option value="LEGAL FLAT RATE ENVELOPE"{if $shipping_options.usps.param03 eq "LEGAL FLAT RATE ENVELOPE"} selected="selected"{/if}>Priority Mail Express Legal Flat Rate Envelope, 15 x 9.5</option>
    <option value="PADDED FLAT RATE ENVELOPE"{if $shipping_options.usps.param03 eq "PADDED FLAT RATE ENVELOPE"} selected="selected"{/if}>Priority Mail Express Padded Flat Rate Envelope, 12.5 x 9.5</option>
    <option value="RECTANGULAR"{if $shipping_options.usps.param03 eq "RECTANGULAR"} selected="selected"{/if}>Rectangular (Priority Mail Express Large)</option>
    <option value="NONRECTANGULAR"{if $shipping_options.usps.param03 eq "NONRECTANGULAR"} selected="selected"{/if}>Non Rectangular (Priority Mail Express Large)</option>
  </select>
  {include file="main/tooltip_js.tpl" text=$lng.txt_usps_container_help type="img" id="help_container_express" sticky=true width=500}
  </td>
</tr>

<tr>
  <td><b>{$lng.lbl_usps_container2}:</b></td>
  <td>
  <select name="container_priority" style="max-width: 310px;">
    <option value="None">{$lng.lbl_none}</option>
    <option value="FLAT RATE ENVELOPE"{if $shipping_options.usps.param04 eq "FLAT RATE ENVELOPE"} selected="selected"{/if}>Priority Mail Flat Rate Envelope, 12.5 x 9.5</option>
    <option value="LEGAL FLAT RATE ENVELOPE"{if $shipping_options.usps.param04 eq "LEGAL FLAT RATE ENVELOPE"} selected="selected"{/if}>Priority Mail Legal Flat Rate Envelope, 15 x 9.5</option>
    <option value="PADDED FLAT RATE ENVELOPE"{if $shipping_options.usps.param04 eq "PADDED FLAT RATE ENVELOPE"} selected="selected"{/if}>Priority Mail Padded Flat Rate Envelope, 12.5 x 9.5</option>
    <option value="GIFT CARD FLAT RATE ENVELOPE"{if $shipping_options.usps.param04 eq "GIFT CARD FLAT RATE ENVELOPE"} selected="selected"{/if}>Priority Mail Gift Card Flat Rate, 10" x 7"</option>
    <option value="SM FLAT RATE ENVELOPE"{if $shipping_options.usps.param04 eq "SM FLAT RATE ENVELOPE"} selected="selected"{/if}>Priority Mail Small Flat Rate Envelope, 10" x 6"</option>
    <option value="WINDOW FLAT RATE ENVELOPE"{if $shipping_options.usps.param04 eq "WINDOW FLAT RATE ENVELOPE"} selected="selected"{/if}>Priority Mail Window Flat Rate Envelope, 10" x 5"</option>
    <option value="SM FLAT RATE BOX"{if $shipping_options.usps.param04 eq "SM FLAT RATE BOX"} selected="selected"{/if}>Priority Mail Small Flat Rate Box, 8-5/8" x 5-3/8" x 1-5/8"</option>
    <option value="MD FLAT RATE BOX"{if $shipping_options.usps.param04 eq "MD FLAT RATE BOX"} selected="selected"{/if}>Priority Mail Medium Flat Rate Boxes, 11" x 8-1/2" x 5-1/2", 13-5/8" x 11-7/8" x 3-3/8"</option>
    <option value="LG FLAT RATE BOX"{if $shipping_options.usps.param04 eq "LG FLAT RATE BOX"} selected="selected"{/if}>Priority Mail Large Flat Rate Boxes, 12" x 12" x 5-1/2", 23-11/16" x 11-3/4" x 3"</option>
    <option value="REGIONALRATEBOXA"{if $shipping_options.usps.param04 eq "REGIONALRATEBOXA"} selected="selected"{/if}>Priority Mail Regional Box A: weight limit 15 lbs.12-13/16"x10-15/16"x2-3/8",10"x7"x4-3/4"</option>
    <option value="REGIONALRATEBOXB"{if $shipping_options.usps.param04 eq "REGIONALRATEBOXB"} selected="selected"{/if}>Priority Mail Regional Box B: weight limit 20 lbs.15-7/8"x14-3/8"x2-7/8",12"x10-1/4"x5"</option>
    <option value="RECTANGULAR"{if $shipping_options.usps.param04 eq "RECTANGULAR"} selected="selected"{/if}>Rectangular (Priority Mail Large)</option>
    <option value="NONRECTANGULAR"{if $shipping_options.usps.param04 eq "NONRECTANGULAR"} selected="selected"{/if}>Non Rectangular (Priority Mail Large)</option>
  </select>
  {include file="main/tooltip_js.tpl" text=$lng.txt_usps_container_help type="img" id="help_container_priority" sticky=true width=500}
  </td>
</tr>

<tr>
  <td><b>{$lng.lbl_usps_first_class_mail_type}:</b></td>
  <td>
  <select name="firstclassmailtype">
    <option value="LETTER"{if $shipping_options.usps.param05 eq "LETTER"} selected="selected"{/if}>Letter</option>
    <option value="FLAT"{if $shipping_options.usps.param05 eq "FLAT"} selected="selected"{/if}>Flat</option>
    <option value="PARCEL"{if $shipping_options.usps.param05 eq "PARCEL"} selected="selected"{/if}>Parcel</option>
    <option value="POSTCARD"{if $shipping_options.usps.param05 eq "POSTCARD"} selected="selected"{/if}>PostCard</option>
    <option value="PACKAGE SERVICE"{if $shipping_options.usps.param05 eq "PACKAGE SERVICE"} selected="selected"{/if}>Package Service</option>
  </select>
  </td>
</tr>

<tr>
  <td colspan="2" class="SubmitBox"><input type="submit" value="{$lng.lbl_apply|strip_tags:false|escape}" /></td>
</tr>

</table>
</form>

{/capture}
{assign var="section_title" value=$lng.lbl_X_shipping_options|substitute:"service":"U.S.P.S."}
{include file="dialog.tpl" content=$smarty.capture.dialog title=$section_title extra='width="100%"'}

{/if}
