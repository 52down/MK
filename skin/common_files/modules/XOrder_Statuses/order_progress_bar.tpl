{*
2e06fd106b3a584082c18cd597a001e2913c807d, v6 (xcart_4_7_0), 2015-02-27 18:09:41, order_progress_bar.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

{if $config.XOrder_Statuses.xostat_show_progress_bar eq 'Y'}

{if $xcart_send_mail eq 'Y'}
<style type="text/css">
<!--
{*
  {xostat_embedd_css_content file="modules/XOrder_Statuses/main.css"}
  {xostat_embedd_css_content file="modules/XOrder_Statuses/css/mail.pbar.css"}
*}
-->
</style>
{/if}

{*load_defer file="modules/XOrder_Statuses/css/pbar.css" type="css"*}

{tpl_order_statuses var=avail_statuses progress_bar='Y' orderid=$order.orderid order_status=$order.status}

<table class="progress-bar" width="100%" align="center" cellspacing="0" cellpadding="1">
<tr>
  {assign var=after_current_status value='N'}
  {foreach from=$avail_statuses item=st name=status_progress_bar}
    {assign var=current_status value='N'}
    {if ($st.code ne '' && $st.code eq $order.status) || ($st.code eq '' && $st.statusid eq $order.status)}
      {assign var=current_status value='Y'}
    {/if}
    <td align="center" valign="top" width="{$pb_display.cell_width}%"{if $current_status eq 'Y'} style="border: 1px solid #{$st.active_color};"{/if}{if $st.descr ne ''} title="{$st.descr|amp}"{/if}>
      {if $current_status eq 'Y'}<b>{/if}{$st.name}{if $current_status eq 'Y'}</b>{/if}
      {if $config.XOrder_Statuses.xostat_use_colors eq 'Y'}
      <br />
      <div style="width: 100%; height: 10px; background: #{if $after_current_status eq 'Y'}{$st.inactive_color}{else}{$st.active_color}{/if};"></div>
      {/if}
    </td>
    {if !$smarty.foreach.status_progress_bar.last}
    <td style="color: #{if $after_current_status eq 'Y'}{$st.inactive_color}{else}{$st.active_color}{/if};">
    <b>&rsaquo;</b>
    </td>
    {/if}
    {if $current_status eq 'Y' && $after_current_status eq 'N'}
    {assign var=after_current_status value='Y'}
    {/if}
  {/foreach}
</tr>
</table>
<br />

<table class="xostatus-pbar-container" width="100%" cellpadding="2" cellspacing="0">
<tr>
{foreach from=$avail_statuses item=st name=status_progress_bar}
  <td 
class="xostatus-pbar-element {if $smarty.foreach.status_progress_bar.first}first{elseif $smarty.foreach.status_progress_bar.last}last{else}middle{/if}{if $st.active eq 'Y'} active{/if} xostatus-pbar-background-{$st.css_name}-{if $st.show_color eq 'Y'}active{else}inactive{/if}" 
align="middle" 
{if not $smarty.foreach.status_progress_bar.first} width="{$pb_display.cell_width}%"{/if}
{if $st.descr ne ''} title="{$st.descr|amp}" style="cursor: help;"{/if}>
    {$st.name}
{if $xcart_send_mail eq 'Y' or true}
<div style="height: 1px;">&nbsp;</div>
{/if}
  </td>
{/foreach}
</tr>
</table>

{/if}
