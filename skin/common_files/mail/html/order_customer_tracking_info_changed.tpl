{*
528f88104626646f29d17b82818b980d0f42236a, v1 (xcart_4_7_8), 2017-05-26 16:11:43, order_customer_tracking_info_changed.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{config_load file="$skin_config"}
{include file="mail/html/mail_header.tpl"}

<br />{include file="mail/salutation.tpl" title=$customer.title firstname=$customer.firstname lastname=$customer.lastname}

<hr size="1" noshade="noshade" />
<br />
<table cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="20%"><b>{$lng.lbl_order_id}:</b></td>
<td width="10">&nbsp;</td>
<td width="80%"><tt><b>#{$order.orderid}</b></tt></td>
</tr>

<tr>
<td><b>{$lng.lbl_order_date}:</b></td>
<td width="10">&nbsp;</td>
<td><tt>{$order.date|date_format:$config.Appearance.datetime_format}</tt></td>
</tr>

<tr>
<td><b>{$lng.lbl_tracking_number}:</b></td>
<td width="10">&nbsp;</td>
<td><tt><b>{$order.tracking}</b></tt></td>
</tr>

<tr>
<td><b>{$lng.lbl_order_status}:</b></td>
<td width="10">&nbsp;</td>
<td><tt>{include file="main/order_status.tpl" mode="static" status=$order.status}</tt></td>
</tr>

</table>

{include file="mail/html/signature.tpl"}

