{*
9cee96dd82fdc2ff3066c65ef8d4ca5d6389eee6, v9 (xcart_4_7_8), 2017-05-02 12:03:35, bread_crumbs.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $location}
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
  <td valign="top" align="left">
  <div id="location">
      {foreach from=$location item=l name=location}
        {if $l.1 and not $smarty.foreach.location.last}
          <a href="{$l.1|amp}" class="bread-crumb">{if $webmaster_mode eq "editor"}{$l.0}{else}{$l.0|amp}{/if}</a>
        {else}
          <span class="bread-crumb{if $smarty.foreach.location.last} last-bread-crumb{/if}">{if $webmaster_mode eq "editor"}{$l.0}{else}{$l.0|amp}{/if}</span>
        {/if}
        {if not $smarty.foreach.location.last && $config.Appearance.breadcrumbs_separator ne ''}
          <span>{$config.Appearance.breadcrumbs_separator|amp}</span>
        {/if}
      {/foreach}
  </div>
  </td>
  <td class="printable-link-row">
  {include file="customer/printable_link.tpl"}
  </td>
</tr>
</table>
{/if}
