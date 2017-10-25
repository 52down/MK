{*
9d603c19b3d483bbd894eb90be4b1d9278935a58, v3 (xcart_4_7_5), 2015-11-09 15:37:59, inv_updated.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}
{if $updated_items gt 0}
  {$lng.txt_inv_updated}
  <br />
{else}
  {$lng.txt_inv_not_updated}
{/if}
{if $err_rows}
  <font class="Star">{$lng.txt_inv_invalid_format}</font>
  <br />
  {foreach from=$err_rows item=err}
    <pre>{$err}</pre>
  {/foreach}
  <br />
{/if}
{include file="buttons/go_back.tpl"}
