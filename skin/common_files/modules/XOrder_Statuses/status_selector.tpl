{*
0559ca8bda5978a4247cd80d0c9c0635f06a7290, v9 (xcart_4_7_8), 2017-06-01 10:08:00, status_selector.tpl, Ildar

vim: set ts=2 sw=2 sts=2 et:
*}

{tpl_order_statuses var="avail_statuses"}
{if $extended eq "" and $status eq ""}

{$lng.lbl_wrong_status}

{elseif $mode eq "select"}{*if $extended eq "" and $status eq ""*}

{if $config.XOrder_Statuses.xostat_use_colors eq 'Y'}
<div class="xostatus-search-status-indicator xostatus-orderstatus-background-{$status|escape}">&nbsp;</div>

<div class="xostatus-orderstatus-select-container">
{/if}

{if $usertype eq 'C'}
    {load_defer file="modules/XOrder_Statuses/common.js" type="js"}
{/if}

<select name="{$name}" {$extra}{if $config.XOrder_Statuses.xostat_use_colors eq 'Y'} onchange="javascript: func_orderstatuses_change_circle(this);"{/if}>
{if $extended ne ""}
  <option value="">&nbsp;</option>
{/if}
{foreach from=$avail_statuses item=st}
{if $st.code ne 'A' || $st.code eq $status || ($st.code eq 'A' && $display_preauth)}
  <option value="{$st.code}"{if $status eq $st.code} selected="selected"{/if}>{$st.name}</option>
{/if}
{/foreach}
{if $active_modules.ShippingEasy ne ''}<option value="S"{if $status eq "S"} selected="selected"{/if}>{$lng.lbl_shippingeasy_partially_shipped}</option>{/if}
</select>

{if $config.XOrder_Statuses.xostat_use_colors eq 'Y'}
</div>

<div class="clearing"></div>
{/if}

{elseif $mode eq "static"}{*if $extended eq "" and $status eq ""*}

{foreach from=$avail_statuses item=st}
  {if ($st.code ne '' && $status eq $st.code) || ($st.code eq '' && $status eq $st.statusid)}{$st.name}{/if}
{/foreach}
{if $st.code ne '' && $status eq 'S'}{$lng.lbl_shippingeasy_partially_shipped}{/if}
{/if}
