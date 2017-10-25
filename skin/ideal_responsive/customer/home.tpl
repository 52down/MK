{*
00dfe6acce1a85a1d4fac8a204ab4eabaa5d1c37, v10 (xcart_4_7_5), 2016-02-09 11:54:20, home.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
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
          {if $_is_fb_plugins_enabled} {*check $config.Socialize.soc_fb_like_enabled eq "Y" or $config.Socialize.soc_fb_send_enabled eq "Y" and other settings*}
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

      {include file="customer/bottom.tpl"}

    </div>

    {if $active_modules.Google_Analytics and $config.Google_Analytics.ganalytics_version eq 'Traditional'}
      {include file="modules/Google_Analytics/ga_code.tpl"}
    {/if}

  </div>
</div>
{if $active_modules.EU_Cookie_Law ne "" and $view_info_panel eq "Y"}
  {include file="modules/EU_Cookie_Law/info_panel.tpl"}
{/if}
{load_defer_code type="css"}
{include file="customer/service_body_js.tpl"}
{load_defer_code type="js"}
</body>
</html>
