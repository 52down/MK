{*
00dfe6acce1a85a1d4fac8a204ab4eabaa5d1c37, v17 (xcart_4_7_5), 2016-02-09 11:54:20, home.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{config_load file="$skin_config"}
<!DOCTYPE html>
<head>
{include file="customer/service_head.tpl"}
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="{$AltSkinDir}/bootstrap/js/html5shiv.min.js"></script>
      <script src="{$AltSkinDir}/bootstrap/js/respond.min.js"></script>
    <![endif]-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 

</head>
<body{if $body_onload ne ''} onload="javascript: {$body_onload}"{/if}{if $container_classes} class="{foreach from=$container_classes item=c}{$c} {/foreach}"{/if}>
{include file="customer/mobile_head.tpl"}
<div class="page-wrap">
{include file="customer/head.tpl"}
{include file="customer/content.tpl"}
{include file="customer/bottom.tpl"}
</div>
{*
<?xml version="1.0" encoding="{$default_charset|default:"utf-8"}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
{config_load file="$skin_config"}
<html xmlns="http://www.w3.org/1999/xhtml"{if $active_modules.Socialize} xmlns:g="http://base.google.com/ns/1.0" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://ogp.me/ns/fb#"{/if}>
<head>
  {include file="customer/service_head.tpl"}
</head>
<body{if $body_onload ne ''} onload="javascript: {$body_onload}"{/if}{if $container_classes} class="{foreach from=$container_classes item=c}{$c} {/foreach}"{/if}>
{if $main eq 'product' and $is_admin_preview}
  {include file="customer/main/product_admin_preview_top.tpl"}
{/if}
<div id="page-container"{if $page_container_class} class="{$page_container_class}"{/if}>
  <div id="page-container2">
    <div id="content-container">
      <div id="content-container2">

        {if $active_modules.Socialize}
          {getvar func=func_soc_tpl_is_fb_plugins_enabled var=_is_fb_plugins_enabled}
          {if $_is_fb_plugins_enabled} 
            <div id="fb-root"></div>
          {/if}
        {/if}

        {include file="customer/content.tpl"}

      </div>
    </div>

    <div class="clearing">&nbsp;</div>

    <div id="header">
      {include file="customer/head.tpl"}
    </div>

    <div id="footer">

      {if $active_modules.Users_online}
        {include file="modules/Users_online/menu_users_online.tpl"}
      {/if}

      {include file="customer/bottom.tpl"}

    </div>

    {if $active_modules.Google_Analytics and $config.Google_Analytics.ganalytics_version eq 'Traditional'}
      {include file="modules/Google_Analytics/ga_code.tpl"}
    {/if}

  </div>
</div>
*}
{if $active_modules.EU_Cookie_Law and $view_info_panel eq "Y"}
  {include file="modules/EU_Cookie_Law/info_panel.tpl"}
{/if}
{load_defer_code type="css"}
{include file="customer/service_body_js.tpl"}
{load_defer_code type="js"}
</body>
</html>
