{*
0559ca8bda5978a4247cd80d0c9c0635f06a7290, v9 (xcart_4_7_8), 2017-06-01 10:08:00, order_status.tpl, Ildar

vim: set ts=2 sw=2 sts=2 et:
*}
{if $active_modules.XOrder_Statuses}
{include file="modules/XOrder_Statuses/status_selector.tpl"}
{else}
{if $extended eq "" and $status eq ""}

{$lng.lbl_wrong_status}

{elseif $mode eq "select"}

<select name="{$name}" {$extra}>
{if $extended ne ""}
  <option value="">&nbsp;</option>
{/if}
  <option value="I"{if $status eq "I"} selected="selected"{/if}>{$lng.lbl_not_finished}</option>
  <option value="Q"{if $status eq "Q"} selected="selected"{/if}>{$lng.lbl_queued}</option>
  {if $status eq "A" or $display_preauth}<option value="A"{if $status eq 'A'} selected="selected"{/if}>{$lng.lbl_pre_authorized}</option>{/if}
  <option value="P"{if $status eq "P"} selected="selected"{/if}>{$lng.lbl_processed}</option>
  {if $active_modules.ShippingEasy ne ''}<option value="S"{if $status eq "S"} selected="selected"{/if}>{$lng.lbl_shippingeasy_partially_shipped}</option>{/if}
  <option value="B"{if $status eq "B"} selected="selected"{/if}>{$lng.lbl_backordered}</option>
  <option value="R"{if $status eq "R"} selected="selected"{/if}>{$lng.lbl_refunded}</option>
  <option value="D"{if $status eq "D"} selected="selected"{/if}>{$lng.lbl_declined}</option>
  <option value="F"{if $status eq "F"} selected="selected"{/if}>{$lng.lbl_failed}</option>
  <option value="C"{if $status eq "C"} selected="selected"{/if}>{$lng.lbl_complete}</option>
</select>

{elseif $mode eq "static"}

{if $status eq "I"}
{$lng.lbl_not_finished}

{elseif $status eq "Q"}
{$lng.lbl_queued}

{elseif $status eq "A"}
{$lng.lbl_pre_authorized}

{elseif $status eq "P"}
{$lng.lbl_processed}

{elseif $status eq "S"}
{$lng.lbl_shippingeasy_partially_shipped}

{elseif $status eq "D"}
{$lng.lbl_declined}

{elseif $status eq "B"}
{$lng.lbl_backordered}

{elseif $status eq "R"}
{$lng.lbl_refunded}

{elseif $status eq "F"}
{$lng.lbl_failed}

{elseif $status eq "C"}
{$lng.lbl_complete}

{/if}

{/if}
{/if} {*if $active_modules.XOrder_Statuses*}
