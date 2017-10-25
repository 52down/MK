{*
8738c369aba806e259453b15f7220fb3bb92f88c, v6 (xcart_4_7_7), 2016-10-20 18:26:28, categoryselector.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}

{*
  Supported params:

    $name - select control name
    $class - class to add to select element
    $extra - extra attributes to add to select element

    $display_empty - epmpty option selector
    $selected_id - selected option
    $selected_ids - selected options list
*}

{include file="widgets/css_loader.tpl" css="lib/select2/css/select2.min.css"}
{load_defer file="lib/select2/js/select2.min.js" type="js"}
{load_defer file="lib/select2/js/i18n/$shop_language.js" type="js"}

{include file="widgets/categoryselector/config.tpl" assign="categoryselectorconfig"}

{include file="widgets/css_loader.tpl" css="widgets/categoryselector/categoryselector.css"}
{load_defer file="widgets/categoryselector/categorysorter.js" type="js"}
{load_defer file="widgets/categoryselector/categoryselector.js" type="js"}

<div class="categoryselector-widget-switcher">
  <span data-action="default">{$lng.lbl_default}</span>
  <span data-action="widget">{$lng.lbl_widget}</span>
</div>

<select name="{$name|default:"categoryid"}" class="categoryselector{if $class} {$class}{/if}" data-categoryselectorconfig="{$categoryselectorconfig|escape}" {$extra}>
  {if $display_empty eq 'P'}
    <option value="">{$lng.lbl_please_select_category}</option>
  {elseif $display_empty eq 'E'}
    <option value="">&nbsp;</option>
  {/if}
  {foreach from=$allcategories item=c key=catid}
    {if $selected_ids}
      <option value="{$catid}"{if $selected_ids[$catid]} selected="selected"{/if}>{$c}</option>
    {else}
      <option value="{$catid}"{if $selected_id eq $catid} selected="selected"{/if} title="{$c|cat:' (id:'|cat:$catid|strip_tags:false|escape})">{$c|amp}</option>
    {/if}
  {/foreach}
</select>
