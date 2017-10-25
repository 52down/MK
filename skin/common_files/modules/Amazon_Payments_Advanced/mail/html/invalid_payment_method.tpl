{*
cdaa4cb7431f2a00897c5822c00abfc8a47e915d, v1 (xcart_4_7_8), 2017-03-03 18:36:28, invalid_payment_method.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{include file="mail/html/mail_header.tpl"}

{include file="mail/salutation.tpl" title='' firstname=$profile.firstname lastname=$profile.lastname}
<br />
<br />
{$lng.eml_amazon_pa_pm2be_updated|substitute:"url2update_pm":$url2update_pm}
<br />

{include file="mail/html/signature.tpl"}
