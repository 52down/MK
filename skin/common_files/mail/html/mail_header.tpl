{*
850e5138e855497e58a9e99e00c2e8e04e3f7234, v1 (xcart_4_4_0_beta_2), 2010-05-21 08:31:50, mail_header.tpl, joy
vim: set ts=2 sw=2 sts=2 et:
*}
<br /><font size="2">
{assign var="link" value="<a href=\"$http_location/\" target=\"_blank\">`$config.Company.company_name`</a>"}
{$lng.eml_mail_header|substitute:"company":$link}
</font>

