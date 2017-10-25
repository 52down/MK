{*
9ed27b112a46cb360618b909a81f51dd2038c4d5, v1 (xcart_4_7_7), 2017-01-23 15:04:06, refund_notification.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}
{config_load file="$skin_config"}
{include file="mail/mail_header.tpl"}

{include file="mail/salutation.tpl" title=$customer.title firstname=$customer.firstname lastname=$customer.lastname}

{$lng.eml_order_refunded}

{$lng.lbl_order_id|mail_truncate}#{$order.orderid}
{$lng.lbl_order_date|mail_truncate}{$order.date|date_format:$config.Appearance.datetime_format}

{include file="mail/order_data.tpl"}

{include file="mail/signature.tpl"}
