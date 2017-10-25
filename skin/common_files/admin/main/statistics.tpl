{*
5ad4e34e669e2c8fc3ca90d4a0282e1220d4a0e4, v6 (xcart_4_7_5), 2015-12-24 01:20:59, statistics.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}
{include file="page_title.tpl" title=$lng.lbl_statistics}

<br />
{if $mode ne 'adaptives' and $mode ne 'users_online'}
{capture name=dialog}

<form action="statistics.php{if $php_url.query_string}?{$php_url.query_string|escape}{/if}" method="post">
<input type="hidden" name="mode" value="{$mode}" />

<table cellpadding="1" cellspacing="1">

<tr>
  <th>{include file="widgets/daterangepicker/daterangepicker.tpl" name="date_range" startDate=$start_date endDate=$end_date}</th>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><input type="submit" value="{$lng.lbl_submit|strip_tags:false|escape}" /></td>
</tr>

</table>
</form>

{/capture}
{include file="dialog.tpl" title=$lng.lbl_date_setting content=$smarty.capture.dialog extra='width="100%"'}

<br />
{/if}

{if $mode eq "general"}

{capture name=dialog}

<table cellspacing="0" cellpadding="0" width="100%">

<tr>
  <th class="TableHead" colspan="2" align="left" height="16">&nbsp;{$lng.lbl_total_statistics}</th>
</tr>

<tr> 
  <td height="10" colspan="2"></td>
</tr>

<tr> 
  <td valign="top" width="343" class="Text">{$lng.lbl_number_of_customers}<span class="SmallText"><i>({$lng.lbl_registered|lower}/{$lng.lbl_anonymous})</i></span></td>
  <td valign="top" width="67" class="Text" align="right">{$statistics.clients}/{$statistics.clients_anonymous}</td>
</tr>

<tr> 
  <td height="10" colspan="2"></td>
</tr>

<tr> 
  <td valign="top" width="343" class="Text">{$lng.lbl_number_of_providers}</td>
  <td valign="top" width="67" class="Text" align="right">{$statistics.providers}</td>
</tr>

<tr> 
  <td height="10" colspan="2"></td>
</tr>

<tr> 
  <td valign="top" width="343" class="Text">{$lng.lbl_number_of_products}</td>
  <td valign="top" width="67" class="Text" align="right">{$statistics.products}</td>
</tr>

<tr> 
  <td height="10" colspan="2"></td>
</tr>

<tr> 
  <td valign="top" width="343" class="Text">{$lng.lbl_number_of_root_categories}</td>
  <td valign="top" width="67" class="Text" align="right">{$statistics.categories}</td>
</tr>

<tr> 
  <td height="10" colspan="2"></td>
</tr>

<tr> 
  <td valign="top" width="343" class="Text">{$lng.lbl_number_of_subcategories}</td>
  <td valign="top" width="67" class="Text" align="right">{$statistics.subcategories}</td>
</tr>

<tr> 
  <td height="10" colspan="2"></td>
</tr>

<tr> 
  <td valign="top" width="343" class="Text">{$lng.lbl_number_of_orders}</td>
  <td valign="top" width="67" class="Text" align="right">{$statistics.orders}</td>
</tr>

<tr> 
  <td height="10" colspan="2"></td>
</tr>

<tr>
  <th class="TableHead" colspan="2" align="left" height="16">&nbsp;{$lng.lbl_general_statistics_for_period}: <i><font color="#000099">{$start_date|date_format:$config.Appearance.datetime_format} - {$end_date|date_format:$config.Appearance.datetime_format}</font></i></th>
</tr>

<tr> 
  <td height="10" colspan="2"></td>
</tr>

<tr> 
  <td valign="top" width="343" class="Text">{$lng.lbl_new_customers}<span class="SmallText"><i>({$lng.lbl_registered|lower}/{$lng.lbl_anonymous})</i></span></td>
  <td valign="top" width="67" class="Text" align="right">{$statistics.clients_last_month}/{$statistics.clients_last_month_anonymous}</td>
</tr>

<tr> 
  <td height="10" colspan="2"></td>
</tr>

<tr> 
  <td valign="top" width="343" class="Text">{$lng.lbl_new_providers}</td>
  <td valign="top" width="67" class="Text" align="right">{$statistics.providers_last_month}</td>
</tr>

<tr> 
  <td height="10" colspan="2"></td>
</tr>

<tr> 
  <td valign="top" width="343" class="Text">{$lng.lbl_new_products}</td>
  <td valign="top" width="67" class="Text" align="right">{$statistics.products_last_month}</td>
</tr>

<tr> 
  <td height="10" colspan="2"></td>
</tr>

<tr> 
  <td valign="top" width="343" class="Text">{$lng.lbl_new_orders}</td>
  <td valign="top" width="67" class="Text" align="right">{$statistics.orders_last_month}</td>
</tr>

</table>

{/capture}
{include file="dialog.tpl" title=$lng.lbl_total_statistics content=$smarty.capture.dialog extra='width="100%"'}

<br />

{else}

{capture name=dialog}

{if $mode eq "logins"}
{include file="admin/main/atracking_logins.tpl"}
{assign var="box_title" value=$lng.lbl_log_in_history}

{elseif $mode eq "adaptives"}
{include file="admin/main/atracking_adaptives.tpl"}
{assign var="box_title" value=$lng.lbl_browser_settings}

{elseif $mode eq "search"}
{include file="admin/main/atracking_search.tpl"}
{assign var="box_title" value=$lng.lbl_search_statistics}

{elseif $mode eq "users_online"}
{include file="modules/Users_online/stats.tpl"}
{assign var="box_title" value=$lng.lbl_users_online}

{/if}

{/capture}
{include file="dialog.tpl" title=$box_title content=$smarty.capture.dialog extra='width="100%"'}

{/if}
