{*
a26546caee6d4cd5438ef532e0f1d5a40f4b83f1, v4 (xcart_4_7_6), 2016-06-10 12:05:52, wishlist_sendall2friend.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{config_load file="$skin_config"}
{include file="mail/mail_header.tpl"}

{$lng.eml_hello}

{$lng.eml_wish_list_send_msg|substitute:"sender":"`$userinfo.firstname` `$userinfo.lastname`"}

{section name=num loop=$wl_products}
===========================================
{$wl_products[num].product}

{$wl_products[num].descr|truncate:200:"..."}

{$lng.lbl_price}: {currency value=$wl_products[num].price plain_text_message=Y}

{/section}
===========================================

{$lng.eml_click_to_view_wishlist}:

 {$catalogs.customer}/cart.php?mode=friend_wl&wlid={$wlid}

{include file="mail/signature.tpl"}
