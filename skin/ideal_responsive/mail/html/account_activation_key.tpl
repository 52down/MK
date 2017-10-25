{*
d531547cff031f0ee7925530d6e0307732ee397a, v2 (xcart_4_7_3), 2015-06-15 11:17:44, account_activation_key.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{config_load file="$skin_config"}
{include file="mail/html/mail_header.tpl"}

{capture name="row"}
<h1>{include file="mail/salutation.tpl" title=$userinfo.title firstname=$userinfo.firstname lastname=$userinfo.lastname}</h1>

{if $reason eq 'long_unused'}
{$lng.eml_account_was_suspended_long_unused|substitute:"number":$config.Security.suspend_admin_after|substitute:"login_name":$userinfo.login}:
{else}
{$lng.eml_account_was_suspended|substitute:"number":$lock_login_attempts|substitute:"login_name":$userinfo.login}:
{/if}

<br /><br /><a href="{$http_location}/login.php?activation_key={$activation_key}">{$http_location}/login.php?activation_key={$activation_key}</a>
{/capture}
{include file="mail/html/responsive_row.tpl" content=$smarty.capture.row}

{include file="mail/html/signature.tpl"}
