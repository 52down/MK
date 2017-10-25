{*
d83d6034870b776d315d03bd9d2a216dfbe8f888, v2 (xcart_4_7_4), 2015-10-15 11:49:55, configuration_tabs.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}
<div class="page-tabs">
  <ul>
    {foreach from=$tabs item=tab}
    <li class="{if $tab.current ne 'Y'}tab{else}tab-current{/if}">
      <a href="{$tab.link}"{if $tab.style} class="{$tab.style}"{/if}>{$tab.title}</a>
    </li>
    {/foreach}
  </ul>
</div>
