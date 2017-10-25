{*
7780bb5697d2bd949b75e69d0262d8edccf082b5, v6 (xcart_4_7_5), 2016-01-04 14:19:26, service_css.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $config.UA.browser eq 'MSIE'}
  {assign var=ie_ver value=$config.UA.version|string_format:'%d'}
{/if}
<link rel="stylesheet" type="text/css" href="{$SkinDir}/css/admin.css" />
<link rel="stylesheet" type="text/css" href="{$SkinDir}/css/font-awesome.min.css" />
{if $ie_ver ne ''}
<style type="text/css">
<!--
{/if}
{strip}
{foreach from=$css_files item=files key=mname}
  {foreach from=$files item=f}
    {if $f.admin}
      {if not $ie_ver}
        <link rel="stylesheet" type="text/css" href="{$SkinDir}/modules/{$mname}/{$f.subpath}admin{if $f.suffix}.{$f.suffix}{/if}.css" />
      {else}
        @import url("{$SkinDir}/modules/{$mname}/{$f.subpath}admin{if $f.suffix}.{$f.suffix}{/if}.css");
      {/if}
    {/if}
  {/foreach}
{/foreach}
{/strip}
{if $ie_ver ne ''}
-->
</style>
{/if}
{if $configuration_tabs ne '' and $main eq 'configuration'}
<link rel="stylesheet" type="text/css" href="{$SkinDir}/admin/css/configuration_tabs.css" />
{/if}
