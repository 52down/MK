{*
a26546caee6d4cd5438ef532e0f1d5a40f4b83f1, v4 (xcart_4_7_6), 2016-06-10 12:05:52, giftcert.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{config_load file="$skin_config"}
{include file="mail/mail_header.tpl"}


{include file="mail/salutation.tpl" salutation=$giftcert.recipient}

{if $giftcert.purchaser ne ""}{assign var="purchaser" value=$giftcert.purchaser}{else}{assign var="purchaser" value=$giftcert.purchaser_email}{/if}{currency value=$giftcert.amount assign="amount" plain_text_message=Y}{$lng.eml_gc_header|substitute:"purchaser":$purchaser:"amount":$amount}


{$lng.lbl_message}:
{$giftcert.message}

+--------------------------------------------+
|                                            |
|   {$lng.lbl_gc_id}: {$giftcert.gcid}    
|                                            |
+--------------------------------------------+

{$lng.eml_gc_body}

{include file="mail/signature.tpl"}
