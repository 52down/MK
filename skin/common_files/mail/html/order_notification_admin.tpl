{*
d4710a6854937a2e4f9b290ffa72b2ac9ab212ac, v2 (xcart_4_6_4), 2014-06-20 12:07:13, order_notification_admin.tpl, aim
vim: set ts=2 sw=2 sts=2 et:
*}
{config_load file="$skin_config"}
{include file="mail/html/mail_header.tpl"}

{assign var=where value="A"}

<br />{$lng.eml_order_notification|substitute:"orderid":$order.orderid}

{if $active_modules.PayPal_Here ne '' and $order.pph_web_url ne ''}
<br />{include file="modules/PayPal_Here/paypal_here_link.tpl" pph_url=$order.pph_web_url}
<br /><br />
{/if}

{include file="mail/html/order_invoice.tpl"}

{include file="mail/html/signature.tpl"}
