{*
a26546caee6d4cd5438ef532e0f1d5a40f4b83f1, v5 (xcart_4_7_6), 2016-06-10 12:05:52, send2friend.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{config_load file="$skin_config"}
{include file="mail/mail_header.tpl"}

{$lng.eml_hello}

{$lng.eml_send2friend|substitute:"sender":$name}

{$product.product}
===========================================
{$product.descr}

{$lng.lbl_price}: {currency value=$product.taxed_price plain_text_message=Y}

{if $message}
{$lng.lbl_message}:
===========================================
{$message}

{/if}

{$lng.eml_click_to_view_product}:

{resource_url type="product" id=$product.productid}

{include file="mail/signature.tpl"}
