{*
f02a1a0b1a70d8f7247467b594775789e415ff2b, v1 (xcart_4_7_4), 2015-09-10 21:26:11, acr_your_coupon.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{config_load file="$skin_config"}

{$lng.txt_acr_your_coupon_text|substitute:"discount_coupon":$discount_coupon}:<br />
<b>{$coupon_code}</b>
<br />
<br />
{include file="mail/html/signature.tpl"}

