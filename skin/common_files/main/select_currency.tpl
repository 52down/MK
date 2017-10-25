{*
07f3f09431f1747ff6057acc275823caa01a311f, v3 (xcart_4_7_7), 2016-08-24 19:20:46, select_currency.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<select name="{if $name ne ""}{$name}{else}selected_currency{/if}"{if $id} id="{$id}"{/if}{if $onchange} onchange="{$onchange}"{/if}>
  {foreach from=$currencies item=currency}
  <option value="{if $use_curr_int_code eq "Y"}{$currency.code_int}{else}{$currency.code}{/if}"{if $current_currency eq $currency.code} selected="selected"{/if}>{$currency.code} : {$currency.name}</option>
  {/foreach}
</select>
