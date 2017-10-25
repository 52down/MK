{*
0dfbe5d06d8c46f3f9e28e389b4dc4d352be3335, v6 (xcart_4_7_5), 2015-12-03 12:18:46, customer.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<h1>{$lng.pmap_location}</h1>

<div class="pmap_letters">
<p align="center">
  {foreach from=$pmap.symbols item="display" key="symb"}
    {if $symb eq $pmap.current}
      {assign var='span_class' value='class="pmap_current"'}
    {elseif $display eq XCProductsMap::GREY}
      {assign var='grey_class' value='class="pmap_disabled"'}
    {/if}

    {strip}
      {if $span_class ne ""}<span {$span_class|default:$grey_class}>{else}<a {$grey_class} href="{$pmap.navigation}={$symb}" title="Products #{$symb}">{/if}
      {if $symb eq "0-9"}#{else}{$symb}{/if}
      {if $span_class ne ""}</span>{else}</a>{/if}
    {/strip}

    {assign var='grey_class' value=''}
    {assign var='span_class' value=''}

  {/foreach}
</p>
</div>

<br clear="left" />

{capture name=dialog}

{if $pmap.products}

  {include file="customer/main/navigation.tpl"}
  {include file="customer/main/products.tpl" products=$pmap.products}
  {include file="customer/main/navigation.tpl"}

{else}

  {$lng.lbl_no_items_available}

{/if}

{/capture}
{include file="customer/dialog.tpl" title=$lng.pmap_location content=$smarty.capture.dialog noborder=true}
