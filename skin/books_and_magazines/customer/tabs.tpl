{*
16fd72c950254a8d4861815dac0d6147af93e43f, v2 (xcart_4_7_0), 2014-12-23 10:13:26, tabs.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{assign var=speed_bar value=$speed_bar|@array_reverse}
{if $speed_bar}
  <div class="tabs2{if $all_languages_cnt gt 1} with_languages{/if}">
    <ul>

      {foreach from=$speed_bar item=sb name=tabs}
        <li{interline name=tabs foreach_iteration="`$smarty.foreach.tabs.iteration`" foreach_total="`$smarty.foreach.tabs.total`"}><a href="{$sb.link|amp}">{$sb.title}</a></li>
      {/foreach}

    </ul>
  </div>
{/if}
