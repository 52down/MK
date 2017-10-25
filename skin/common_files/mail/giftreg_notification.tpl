{*
a26546caee6d4cd5438ef532e0f1d5a40f4b83f1, v4 (xcart_4_7_6), 2016-06-10 12:05:52, giftreg_notification.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if not $display_only_body}
{config_load file="$skin_config"}
{include file="mail/mail_header.tpl"}
{/if}
{if $mail_data}
{$mail_data.message|strip_tags}
{else}
{$lng.eml_giftreg_notification|strip_tags}

{section name=num loop=$wl_products}
===========================================
{$wl_products[num].product}

{$wl_products[num].descr|truncate:200:"..."}

{$lng.lbl_price}: {currency value=$wl_products[num].price plain_text_message=Y}

{/section}
===========================================

{$lng.eml_giftreg_click_to_view}:

{$catalogs.customer}/giftregs.php?eventid={$eventid}&wlid={$wlid}
{/if}
{if not $display_only_body}
{include file="mail/signature.tpl"}
{/if}
