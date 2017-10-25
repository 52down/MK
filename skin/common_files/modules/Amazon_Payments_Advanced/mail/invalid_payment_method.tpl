{*
cdaa4cb7431f2a00897c5822c00abfc8a47e915d, v1 (xcart_4_7_8), 2017-03-03 18:36:28, invalid_payment_method.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{config_load file="$skin_config"}
{include file="mail/mail_header.tpl"}

{include file="mail/salutation.tpl" title='' firstname=$profile.firstname lastname=$profile.lastname}

{$lng.eml_amazon_pa_pm2be_updated|substitute:"url2update_pm":$url2update_pm}
{$url2update_pm}

{include file="mail/signature.tpl"}
