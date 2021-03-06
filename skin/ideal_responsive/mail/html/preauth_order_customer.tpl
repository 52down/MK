{*
e94f191a2cc0cb8dbefd384fabaa6f48af5f3c11, v1 (xcart_4_6_2), 2013-12-25 09:14:58, preauth_order_customer.tpl, random
vim: set ts=2 sw=2 sts=2 et:
*}
{config_load file="$skin_config"}
{include file="mail/html/mail_header.tpl"}

{capture name="row"}
<h1>{include file="mail/salutation.tpl" title=$order.title firstname=$order.firstname lastname=$order.lastname}</h1>

{$lng.eml_thankyou_for_order}

<br /><br />
<b>{if $order.status eq 'A' or $order.status eq 'P' or $order.status eq 'C'}{$lng.lbl_receipt}{else}{$lng.lbl_invoice}{/if}:</b>
{/capture}
{include file="mail/html/responsive_row.tpl" content=$smarty.capture.row}

{include file="mail/html/order_invoice.tpl"}

{include file="mail/html/signature.tpl"}
