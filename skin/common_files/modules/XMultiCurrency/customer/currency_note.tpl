{*
efdb1978092cd94543a5472d62e7e28d1ad0aaa0, v4 (xcart_4_7_0), 2015-02-26 17:28:14, currency_note.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

{if $store_currency ne $primary_currency}
{alter_currency value=1 no_brackets=1 assign="billCurr"}
{currency value=1 precision=1 assign="displCurr"}
<div class="mc-currency-note-block cart-border">
  {if $primary_currency ne $primary_currency_data.symbol}
  {$lng.mc_txt_currency_note|substitute:"currency":$primary_currency:"symbol":$primary_currency_data.symbol:"X":$billCurr:"Y":$displCurr}
  {else}
  {$lng.mc_lbl_currency_note2|substitute:"currency":$primary_currency:"X":$billCurr:"Y":$displCurr}
  {/if}
</div>
{/if}

