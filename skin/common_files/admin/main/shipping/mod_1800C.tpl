{*
67814c9aec19d6cf932988e3b949b16094b3dab9, v1 (xcart_4_7_4), 2015-10-28 10:53:25, mod_1800C.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $carrier eq "1800C"}
{*************************************************************
 *  1800C OPTIONS                                            *
 *************************************************************}

{capture name=dialog}
<div align="right"><a href="shipping.php?carrier=1800C#rt">{$lng.lbl_X_shipping_methods|substitute:"service":"1-800Courier"}</a></div>

<br />

{if $config.Shipping.1800c_username eq '' or $config.Shipping.1800c_password eq ''}
  {$lng.txt_1800C_disabled_note}
{else}
  {$lng.txt_1800C_enabled_note}
{/if}
<br />
<h2>{$lng.lbl_1800c_send_information}</h2>
<table>
<tr>
  <td><b>{$lng.lbl_1800c_warehouse_name}:</b></td>
  <td>&nbsp;</td>
  <td>{$seller_address.company_name}</td>
  <td>&nbsp;&nbsp;<a href="configuration.php?option=Shipping#anchor_1800c_username">{$lng.lbl_1800c_change_info}</a></td>
</tr>
<tr>
  <td><b>{$lng.lbl_city}:</b></td>
  <td>&nbsp;</td>
  <td>{$seller_address.city}</td>
</tr>
<tr>
  <td><b>{$lng.lbl_state}:</b></td>
  <td>&nbsp;</td>
  <td>{$seller_address.state}</td>
</tr>
<tr>
  <td><b>{$lng.lbl_country}:</b></td>
  <td>&nbsp;</td>
  <td>{$seller_address.country}</td>
</tr>
<tr>
  <td><b>{$lng.lbl_zip_code}:</b></td>
  <td>&nbsp;</td>
  <td>{$seller_address.zipcode}</td>
</tr>
<tr>
  <td><b>{$lng.lbl_address}:</b></td>
  <td>&nbsp;</td>
  <td>{$seller_address.address}</td>
</tr>
<tr>
  <td><b>{$lng.lbl_phone}:</b></td>
  <td>&nbsp;</td>
  <td>{$seller_address.phone}</td>
</tr>
<tr>
  <td><b>{$lng.lbl_1800c_business_hours}:</b></td>
  <td>&nbsp;</td>
  <td>{$seller_address.business_hours}</td>
</tr>
<tr>
  <td><b>{$lng.lbl_1800c_operation_days}:</b></td>
  <td>&nbsp;</td>
  <td>{$seller_address.operation_days}</td>
</tr>
<tr>
  <td><b>{$lng.lbl_username}:</b></td>
  <td>&nbsp;</td>
  <td>{$seller_address.username}</td>
</tr>
<tr>
  <td><b>{$lng.lbl_1800c_ready_time}:</b></td>
  <td>&nbsp;</td>
  <td>{$seller_address.readytime}</td>
</tr>
<tr>
  <td><b>{$lng.lbl_1800c_subsidizing_rate}:</b></td>
  <td>&nbsp;</td>
  <td>{$seller_address.subsidize}</td>
</tr>
</table>
{if $send_is_avail}
<form method="post" action="shipping_options.php" name='send_to_1800c'>
<input type="hidden" name="carrier" value="1800C" />
<input type="hidden" name="mode" value="send_info" />
</form>
{else}
<br />{$lng.msg_1800c_options_is_empty}<br />
{/if}
<br />
<input type="button" value="{$lng.lbl_1800c_send_info|escape}"{if $send_is_avail} onclick="forms.send_to_1800c.submit()"{else} disabled="disabled"{/if} />

{/capture}
{assign var="section_title" value=$lng.lbl_X_shipping_options|substitute:"service":"1-800Courier "}
{include file="dialog.tpl" content=$smarty.capture.dialog title=$section_title extra='width="100%"'}

{/if}
