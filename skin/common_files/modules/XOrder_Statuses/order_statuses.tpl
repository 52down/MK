{*
1d17fe4557cd83de7351090b6ac953ee0998602b, v8 (xcart_4_7_1), 2015-03-20 14:44:07, order_statuses.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

{load_defer file="modules/XOrder_Statuses/jscolor/jscolor.js" type="js"}

<form name="searchordersform" method="post" action="orders.php">
<input type="hidden" name="posted_data[status]" id="search_form_status" value="" />
</form>

{capture name=dialog}

{include file="main/language_selector.tpl" script="xorder_statuses.php?"}

<form name="statuses_form" method="post" action="xorder_statuses.php">
<input type="hidden" name="mode" value="update" />

<table cellpadding="3" cellspacing="1" width="100%">
<tr class="TableHead">
  <td width="1%" rowspan="2"></td>
  <td width="20%" rowspan="2">{$lng.lbl_xostat_order_status_name}</td>
  <td width="30%" rowspan="2">{$lng.lbl_xostat_order_status_descr}</td>
{if $config.XOrder_Statuses.xostat_use_colors eq 'Y'}
  <td width="4%" rowspan="2">{$lng.lbl_xostat_order_status_color}</td>
{/if}
{*if $config.XOrder_Statuses.xostat_show_progress_bar eq 'Y'}
  <td width="1%" rowspan="2">{$lng.lbl_xostat_order_status_use_for_progress}</td>
  <td width="1%" rowspan="2">
    {$lng.lbl_xostat_show_only_for_orders_with_status}
    {include file="main/tooltip_js.tpl" title=$lng.lbl_xostat_order_status_use_for_progress text=$lng.txt_xostat_order_status_use_for_progress_desc id="help_show_only_for_orders_with_status" type="img"}
  </td>
{/if*}
  <td width="1%" rowspan="2">{$lng.lbl_xostat_reserve_products}</td>
  <td width="40%" colspan="3">{$lng.lbl_xostat_send_notification_to}</td>
  <td width="4%" rowspan="2">{$lng.lbl_orderby}</td>
  <td width="1%" rowspan="2">{$lng.lbl_xostat_order_status_orders_count}</td>
</tr>
<tr class="TableHead">
  <td>{$lng.lbl_customer}</td>
  <td {if $active_modules.Simple_Mode}colspan="2"{/if}>{$lng.lbl_xostat_orders_department}</td>
  {if not $active_modules.Simple_Mode}
    <td>{$lng.lbl_provider}</td>
  {/if}
</tr>
{*** Statuses list  ***}
{if $order_statuses}
{foreach from=$order_statuses item=status}
<tr>
  <td align="center" valign="top"><input type="checkbox" name="delete_status[{$status.statusid}]" value="{$status.statusid}"{if $status.system_status eq 'Y' || $status.orders_count gt 0} disabled="disabled"{/if} /></td>
  <td align="center" valign="top"><input type="text" size="32" maxlength="128" name="statuses[{$status.statusid}][name]" value="{$status.name}" /></td>
  {if $status.system_status eq 'Y'}
    <td align="center">
      <span>{$lng.lbl_xostat_system_status} -> <b>"{$status.code}"</b></span>
    </td>
  {else}
    <td align="left">
      <textarea name="statuses[{$status.statusid}][descr]" cols="45" rows="4">{$status.descr}</textarea>
    </td>
  {/if}
{if $config.XOrder_Statuses.xostat_use_colors eq 'Y'}
  <td align="center" valign="top"><input type="text" name="statuses[{$status.statusid}][color]" value="{$status.color}" maxlength="6" size="8" class="color" /></td>
{/if}
{*if $config.XOrder_Statuses.xostat_show_progress_bar eq 'Y'}
  <td align="center" valign="top"><input type="checkbox" name="statuses[{$status.statusid}][show_in_progress]"{if $status.show_in_progress eq 'Y'} checked="checked"{/if}/></td>
  <td align="center" valign="top"><input type="checkbox" name="statuses[{$status.statusid}][only_when_active]"{if $status.only_when_active eq 'Y'} checked="checked"{/if}/></td>
{/if*}
  <td align="center" valign="top"><input type="checkbox" name="statuses[{$status.statusid}][reserve_products]"{if $status.reserve_products eq 'Y'} checked="checked"{/if}{if $status.system_status eq 'Y'} disabled="disabled{/if}"/></td>
{if $status.system_status eq 'Y'}
  <td align="center" valign="top" colspan="3">{$lng.txt_xostat_order_status_use_config_page_link}</td>
{else}
  <td align="center" valign="top"><input type="checkbox" name="statuses[{$status.statusid}][notify_customer]"{if $status.notify_customer eq 'Y'} checked="checked"{/if}/></td>
  <td align="center" valign="top"><input type="checkbox" name="statuses[{$status.statusid}][notify_orders_dep]"{if $status.notify_orders_dep eq 'Y'} checked="checked"{/if}/></td>
  {if not $active_modules.Simple_Mode}
    <td align="center" valign="top"><input type="checkbox" name="statuses[{$status.statusid}][notify_provider]"{if $status.notify_provider eq 'Y'} checked="checked"{/if}/></td>
  {else}
    <td>&nbsp;</td>
  {/if}
{/if}
  <td align="center" valign="top"><input type="text" size="2" maxlength="3" name="statuses[{$status.statusid}][orderby]" value="{$status.orderby}" /></td>
  <td align="center" valign="top">
    {if $status.orders_count gt 0}
    <a href="javascript: document.getElementById('search_form_status').value='{$status.code}'; document.searchordersform.submit();">{$status.orders_count}</a>
    {else}0{/if}
  </td>
</tr>
{/foreach}
{/if}
{*** Add new status ***}
<tr> 
  <td class="SubHeader" colspan="10"><br /><br />{$lng.lbl_xostat_orders_status_add_new}</td> 
</tr> 
<tr> 
  <td class="SubHeaderLine" colspan="10"></td> 
</tr>
<tr>
  <td></td>
  <td align="center" valign="top"><input type="text" size="32" maxlength="128" name="add_status[name]" value="" /></td>
  <td align="left"><textarea name="add_status[descr]" cols="45" rows="3"></textarea></td>
{if $config.XOrder_Statuses.xostat_use_colors eq 'Y'}
  <td align="center" valign="top"><input type="text" name="add_status[color]" maxlength="6" size="8" class="color" /></td>
{/if}
{*if $config.XOrder_Statuses.xostat_show_progress_bar eq 'Y'}
  <td align="center" valign="top"><input type="checkbox" name="add_status[show_in_progress]" checked="checked"/></td>
  <td align="center" valign="top"><input type="checkbox" name="add_status[only_when_active]" /></td>
{/if*}
  <td align="center" valign="top"><input type="checkbox" name="add_status[reserve_products]" checked="checked"/></td>
  <td align="center" valign="top"><input type="checkbox" name="add_status[notify_customer]" checked="checked"/></td>
  <td align="center" valign="top"><input type="checkbox" name="add_status[notify_orders_dep]" checked="checked"/></td>
  {if not $active_modules.Simple_Mode}
    <td align="center" valign="top"><input type="checkbox" name="add_status[notify_provider]" checked="checked"/></td>
  {else}
    <td>&nbsp;</td>
  {/if}
  <td align="center" valign="top"><input type="text" name="add_status[orderby]" maxlength="3" size="2" value="{$new_orderby|default:10}" /></td>
  <td></td>
</tr>
</table>
<br />
<input type="submit" value="{$lng.lbl_add_update}" />
&nbsp;&nbsp;
<input type="button" value="{$lng.lbl_delete_selected}" onclick="javascript: document.statuses_form.mode.value='delete'; document.statuses_form.submit();" />
</form>
{/capture}
{include file="dialog.tpl" title=$lng.lbl_xostat_order_statuses content=$smarty.capture.dialog extra='width="100%"'}
