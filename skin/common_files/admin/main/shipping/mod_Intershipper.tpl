{*
67814c9aec19d6cf932988e3b949b16094b3dab9, v1 (xcart_4_7_4), 2015-10-28 10:53:25, mod_Intershipper.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $carrier eq "Intershipper"}
{*************************************************************
 *  INTERSHIPPER OPTIONS                                     *
 *************************************************************}

{capture name=dialog}

<div align="right"><a href="shipping.php#rt">{$lng.lbl_manage_shipping_methods}</a></div>

<form method="post" action="shipping_options.php">
<input type="hidden" name="carrier" value="Intershipper" />

<table cellpadding="3" cellspacing="1" width="100%">

<tr>
  <td width="40%"><b>{$lng.lbl_type_of_delivery}:</b></td>
  <td>
  <select name="delivery">
    <option value="COM"{if $shipping_options.intershipper.param00 eq "COM"} selected="selected"{/if}>Commercial delivery</option>
    <option value="RES"{if $shipping_options.intershipper.param00 eq "RES"} selected="selected"{/if}>Residential delivery</option>
  </select>
  </td>
</tr>

<tr>
  <td><b>{$lng.lbl_type_of_pickup}:</b></td>
  <td>
  <select name="shipmethod">
    <option value="DRP"{if $shipping_options.intershipper.param01 eq "DRP"} selected="selected" {/if}>Drop of at carrier location</option>
    <option value="SCD"{if $shipping_options.intershipper.param01 eq "SCD"} selected="selected" {/if}>Regularly Scheduled Pickup</option>
    <option value="PCK"{if $shipping_options.intershipper.param01 eq "PCK"} selected="selected" {/if}>Schedule A Special Pickup</option>
  </select>
  </td>
</tr>

<tr>
  <td><b>{$lng.lbl_package_type}:</b></td>
  <td>
  <select name="packaging">
    <option value="BOX"{if $shipping_options.intershipper.param06 eq "BOX"} selected="selected"{/if}>Customer-supplied Box</option>
    <option value="CBX"{if $shipping_options.intershipper.param06 eq "CBX"} selected="selected"{/if}>Carrier Box</option>
    <option value="CPK"{if $shipping_options.intershipper.param06 eq "CPK"} selected="selected"{/if}>Carrier Pak</option>
    <option value="ENV"{if $shipping_options.intershipper.param06 eq "ENV"} selected="selected"{/if}>Carrier Envelope</option>
    <option value="MEM"{if $shipping_options.intershipper.param06 eq "MEM"} selected="selected"{/if}>Media Mail</option>
    <option value="TUB"{if $shipping_options.intershipper.param06 eq "TUB"} selected="selected"{/if}>Carrier Tube</option>
  </select>
  </td>
</tr>

<tr>
  <td><b>{$lng.lbl_nature_of_shipment_contents}:</b></td>
  <td>
  <select name="contents">
    <option value="OTR"{if $shipping_options.intershipper.param07 eq "OTR"} selected="selected"{/if}>Other: Most shipments will use this code</option>
    <option value="LQD"{if $shipping_options.intershipper.param07 eq "LQD"} selected="selected"{/if}>Liquid</option>
    <option value="AHM"{if $shipping_options.intershipper.param07 eq "AHM"} selected="selected"{/if}>Accessible HazMat</option>
    <option value="IHM"{if $shipping_options.intershipper.param07 eq "IHM"} selected="selected"{/if}>Inaccessible HazMat</option>
  </select>
  </td>
</tr>

<tr>
  <td><b>{$lng.lbl_package_cod_value}:</b></td>
  <td><input type="text" name="codvalue" size="10" value="{$shipping_options.intershipper.param08|escape}" /></td>
</tr>

<tr>
  <td><b>{$lng.lbl_optional_services}:</b></td>
  <td>
    <input type="checkbox" name="options[]" value="ADP" {if $shipping_options.intershipper.options.ADP ne ""} checked="checked" {/if}/>Additional Handling<br/>
    <input type="checkbox" name="options[]" value="SDP" {if $shipping_options.intershipper.options.SDP ne ""} checked="checked" {/if}/>Saturday Delivery <br/>
    <input type="checkbox" name="options[]" value="PDP" {if $shipping_options.intershipper.options.PDP ne ""} checked="checked" {/if}/>Proof of Delivery<br/>
  </td>
</tr>

<tr>
  <td>
    <b>{$lng.lbl_maximum_package_weight} ({$config.General.weight_symbol})*:</b>
  </td>
  <td>
    <input type="text" name="weight" size="6" value="{$shipping_options.intershipper.param09|doubleval}"/> ({$lng.lbl_should_not_exceed} {$max_intershipper_weight} {$config.General.weight_symbol})
  </td>
</tr>

<tr>
  <td><b>{$lng.lbl_maximum_package_dimensions} ({$config.General.dimensions_symbol})*:</b></td>
  <td>
    <table cellpadding="0" cellspacing="1" border="0">
    <tr>
      <td>{$lng.lbl_length}</td>
      <td></td>
      <td>{$lng.lbl_width}</td>
      <td></td>
      <td>{$lng.lbl_height}</td>
    </tr>
    <tr>
      <td><input type="text" name="length" size="6" value="{$shipping_options.intershipper.param02|doubleval}"/></td>
      <td>&nbsp;x&nbsp;</td>
      <td><input type="text" name="width" size="6" value="{$shipping_options.intershipper.param03|doubleval}" /></td>
      <td>&nbsp;x&nbsp;</td>
      <td><input type="text" name="height" size="6" value="{$shipping_options.intershipper.param04|doubleval}"/></td>
    </tr>
    </table>
  </td>
</tr>

<tr>
  <td><label for="use_maximum_dimensions"><b>{$lng.lbl_use_maximum_dimensions}:</b></label></td>
  <td><input type="checkbox" name="use_maximum_dimensions" id="use_maximum_dimensions" value="Y"{if $shipping_options.intershipper.param10 eq "Y"} checked="checked"{/if} /></td>
</tr>

<tr>
  <td colspan="2"><b>*</b> {$lng.txt_intershipper_limits_note}</td>
</tr>

<tr>
  <td colspan="2" class="SubmitBox"><input type="submit" value="{$lng.lbl_apply|strip_tags:false|escape}" /></td>
</tr>

</table>
</form>

{/capture}
{assign var="section_title" value=$lng.lbl_X_shipping_options|substitute:"service":"InterShipper"}
{include file="dialog.tpl" content=$smarty.capture.dialog title=$section_title extra='width="100%"'}

{/if}
