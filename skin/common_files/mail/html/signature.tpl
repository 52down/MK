{*
850e5138e855497e58a9e99e00c2e8e04e3f7234, v1 (xcart_4_4_0_beta_2), 2010-05-21 08:31:50, signature.tpl, joy
vim: set ts=2 sw=2 sts=2 et:
*}
<hr size="1" noshade="noshade" />
{$lng.eml_signature}
<p><font size="2">
{if $config.Company.company_name}{$config.Company.company_name}<br />{/if}
{if $config.Company.company_phone}{$lng.lbl_phone}: {$config.Company.company_phone}<br />{/if}
{if $config.Company.company_fax}{$lng.lbl_fax}:   {$config.Company.company_fax}<br />{/if}
{$lng.lbl_url}: <a href="{$http_location}/" target="_blank">{$config.Company.company_website|default:$http_location}</a>
</font></p>
