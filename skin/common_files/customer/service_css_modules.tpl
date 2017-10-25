{*
0dfbe5d06d8c46f3f9e28e389b4dc4d352be3335, v5 (xcart_4_7_5), 2015-12-03 12:18:46, service_css_modules.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $is_altskin}
 {assign var='module_css_filename' value='altskin'}
{else}
 {assign var='module_css_filename' value=$smarty.config.CSSFilePrefix}
{/if}
{if $ie_ver ne ''}
<style type="text/css">
<!--
{/if}{foreach from=$css_files item=files key=mname}{foreach from=$files item=f}{if not $f.admin}{if not $f.main_tpls or in_array($main, $f.main_tpls)}{if (not $is_altskin and not $f.altskin) or ($is_altskin and $f.altskin)}{if ($f.browser eq $config.UA.browser and $f.version eq $config.UA.version) or ($f.browser eq $config.UA.browser and not $f.version) or (not $f.browser and not $f.version) or (not $f.browser)}{if $f.suffix}{load_defer file="modules/`$mname`/`$f.subpath``$module_css_filename`.`$f.suffix`.css" type='css' css_inc_mode=$ie_ver}{else}{load_defer file="modules/`$mname`/`$f.subpath``$module_css_filename`.css" type='css' css_inc_mode=$ie_ver}{/if}{/if}{/if}{/if}{/if}{/foreach}{/foreach}
{if $ie_ver ne ''}
-->
</style>
{/if}
{* See possible Css_files example in
modules/XOrder_Statuses/config.php
modules/Products_Map/config.php

expanded version for developers
{foreach from=$css_files item=files key=mname}
  {foreach from=$files item=f}
    {if not $f.admin}
      {if not $f.main_tpls or in_array($main, $f.main_tpls)}
        {if (not $is_altskin and not $f.altskin) or ($is_altskin and $f.altskin)}
          {if ($f.browser eq $config.UA.browser and $f.version eq $config.UA.version) or ($f.browser eq $config.UA.browser and not $f.version) or (not $f.browser and not $f.version) or (not $f.browser)}
            {if $f.suffix}
              {load_defer file="modules/`$mname`/`$f.subpath``$module_css_filename`.`$f.suffix`.css" type='css' css_inc_mode=$ie_ver}
            {else}
              {load_defer file="modules/`$mname`/`$f.subpath``$module_css_filename`.css" type='css' css_inc_mode=$ie_ver}
            {/if}
          {/if}
        {/if}
      {/if}
    {/if}
  {/foreach}
{/foreach}
*}
