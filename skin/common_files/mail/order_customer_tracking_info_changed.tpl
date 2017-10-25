{*
528f88104626646f29d17b82818b980d0f42236a, v1 (xcart_4_7_8), 2017-05-26 16:11:43, order_customer_tracking_info_changed.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{config_load file="$skin_config"}
{include file="mail/mail_header.tpl"}

{include file="mail/salutation.tpl" title=$customer.title firstname=$customer.firstname lastname=$customer.lastname}

{$lng.lbl_order_id|mail_truncate}#{$order.orderid}
{$lng.lbl_order_date|mail_truncate}{$order.date|date_format:$config.Appearance.datetime_format}
{$lng.lbl_tracking_number|mail_truncate}{$order.tracking}

{$lng.lbl_order_status|mail_truncate}{include file="main/order_status.tpl" mode="static" status=$order.status}

{include file="mail/signature.tpl"}
