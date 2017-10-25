{*
f796cd4ac105eb160691c59c49e70773bd16b2d8, v7 (xcart_4_7_7), 2016-09-01 16:39:33, top_links.tpl, mixon 

vim: set ts=2 sw=2 sts=2 et:
*}

{include file="jquery_ui_tabs.tpl"}

<div id="top-links" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
  <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
  {foreach from=$tabs item=tab key=ind}
    {inc value=$ind assign="ti"}
    <li class="ui-state-default ui-corner-top{if $tab.selected} ui-tabs-active ui-state-active{/if}">
      <a href="{if $tab.url}{$tab.url|amp}{else}#{$prefix}{$ti}{/if}" class="ui-tabs-anchor">{$tab.title|wm_remove|escape}</a>
    </li>
  {/foreach}
  </ul>
  <div class="ui-tabs-panel ui-widget-content"></div>
</div>
