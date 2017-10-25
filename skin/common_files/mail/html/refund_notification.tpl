{*
9ed27b112a46cb360618b909a81f51dd2038c4d5, v1 (xcart_4_7_7), 2017-01-23 15:04:06, refund_notification.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}
{config_load file="$skin_config"}
{include file="mail/html/mail_header.tpl"}

<br />{include file="mail/salutation.tpl" title=$customer.title firstname=$customer.firstname lastname=$customer.lastname}

<br />{$lng.eml_order_refunded}

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
<td><tt><b>{$order.date|date_format:$config.Appearance.datetime_format}</b></tt></td>
</tr>

<tr>
  <td colspan="3">{include file="mail/html/order_data.tpl"}</td>
</tr>
</table>

{include file="mail/html/signature.tpl"}