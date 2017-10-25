{*
f63bad4cdcc8ab5133640aeb9f9da15847fac720, v4 (xcart_4_7_3), 2015-06-23 16:00:50, aw_categories.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}

{if $aw_add_container}<div class="aw-tcell aw-categories">{/if}

{if $aw_categories|count gt 1}
<h2>
  {$lng.lbl_categories}
</h2>
{/if}
<ul>
  {foreach from=$aw_categories item=c key=catid}
    {if $c.parent eq $aw_current_category or $aw_parent_category eq ""}
    <li class="aw-cat-level-{$c.level}">
      <a href="#category{$c.id|escape:html}" id="{$c.id|escape:html}" data-type="category">{$c.name}</a>
    </li>
    {else}
    <li class="aw-cat-level-{$c.level} aw-parent">
      <a href="#category{$aw_parent_category|escape:html}" id="{$aw_parent_category|escape:html}" data-type="category">{$c.name}</a>
    </li>
    {/if}
  {/foreach}
</ul>

{if $aw_parent_category}
  <a href="#category{$aw_parent_category|escape:html}" id="{$aw_parent_category|escape:html}" data-type="category">{$lng.lbl_go_back}</a>
{/if}

{if $aw_add_container}</div>{/if}
