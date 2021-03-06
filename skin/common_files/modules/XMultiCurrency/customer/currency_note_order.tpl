{*
35ccba99f029d181b26817f94fc451d1144a0e0e, v2 (xcart_4_6_2), 2014-01-23 12:32:45, currency_note_order.tpl, aim
vim: set ts=2 sw=2 sts=2 et:
*}

{if $_mc_display_note}
{assign var="_mc_currsymbol" value=$order.extra.mc_primary_currency_symbol|default:$order.extra.mc_primary_currency}
{alter_currency value=1 currency=$order.extra.mc_primary_currency no_brackets=1 assign="billCurr"}
{currency value=1 currency=$order.extra.mc_store_currency currency_rate=$order.extra.mc_store_currency_rate precision=1 assign="displCurr"}
<table {if $is_nomail eq 'Y'}class="invoice-totals" cellspacing="0"{else}class="order-data-container"{/if}>
<tr>
  <td {if $is_nomail eq 'Y'}class="invoice-totals-row"{else}class="order-data-container"{/if}>
    <div {if $is_nomail eq 'Y'}class="mc-currency-note-order-block"{else}style="background-color: #eeeeee; border-top: 2px solid #999999; width: 100%; margin-top: 15px; margin-bottom: 15px;"{/if}>
      <div {if $is_nomail eq 'Y'}class="mc-currency-note-order-block-text"{else}style="padding: 5px;"{/if}>
      {$lng.mc_txt_currency_note_order|substitute:"currency":$order.extra.mc_primary_currency_name:"symbol":$_mc_currsymbol:"X":$billCurr:"Y":$displCurr}
      </div>
    </div>
  </td>
</tr>
</table>
{/if}

