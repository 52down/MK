{*
ce4b5330ce02f9d721030c7d7df5f5701f94e352, v7 (xcart_4_7_3), 2015-05-07 20:20:39, patch_apply_tbl.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

{literal}
<script type="text/javascript">
//<![CDATA[
function visibleBoxFiles(show) {
  $('.ok_file_row').toggle();
  $('#btn_close_ok_file_row').toggle();
  $('#btn_open_ok_file_row').toggle();
  return true;
}

//]]>
</script>
{/literal}

<table cellpadding="3" cellspacing="1" width="100%">
<tr>
  <td height="14" class="TableHead" nowrap="nowrap">{$lng.lbl_file}</td>
  <td height="14" class="TableHead" nowrap="nowrap" width="100">{$lng.lbl_status}
  {if ($prefix eq 'pf1_' or $prefix eq 'pf2_') && $mode eq 'upgrade'}
    <img id="btn_close_ok_file_row" src="{$ImagesDir}/plus.gif" alt="{$lng.lbl_click_to_open|escape}" onclick="javascript: visibleBoxFiles(true);" />
    <img id="btn_open_ok_file_row" style="display: none" src="{$ImagesDir}/minus.gif" alt="{$lng.lbl_click_to_close|escape}" onclick="javascript: visibleBoxFiles(false);" />
    {assign var="allow_hide_ok_files" value='Y'}
  {/if}
  </td>
</tr>
{assign var="prev_status" value=''}
{assign var="prefix" value=$prefix|default:'pf_'}

{section name=index loop=$files}

{assign var="class_ok_file_row" value='not_ok_file_row'}
{if $files[index].status eq 1}
  {assign var=aclass value="1"}
  {assign var="class_ok_file_row" value='ok_file_row'}
{elseif $files[index].status eq 9}
  {assign var=aclass value="2"}
{else}
  {assign var=aclass value="3"}
{/if}



{capture name='block_visibility'}
{if $allow_hide_ok_files eq 'Y'}
  {if $prev_status ne '' and $files[index].status eq $prev_status and $files[index].status eq 1}
    style="display:none"
  {else}
    style="table-row"
    {if $class_ok_file_row eq 'ok_file_row'}
      {*first ok file should not have 'ok_file_row' class*}
      {assign var="class_ok_file_row" value=''}
    {/if}
    {assign var="prev_status" value=''}
  {/if}
{/if}
{/capture}

<tr {$smarty.capture.block_visibility} {if $smarty.section.index.index mod 2 eq 0} class="TableLine {$class_ok_file_row}"{else} class="{$class_ok_file_row}"{/if}>
  <td class="patch-status patch-status-{$aclass}">{$files[index].orig_file}</td>
  <td>
    {if $confirmed ne '' and $files[index].status eq 1}
      {assign var="status_tooltip" value=$lng.txt_file_x_successfully_patched|substitute:'file':''}
    {else}
      {assign var="status_tooltip" value=$files[index].status_txt|default:$files[index].status_lbl}
    {/if}
    {include file="main/tooltip_js.tpl" class="patch-status patch-status-`$aclass`" text=$status_tooltip title=$files[index].status_lbl id=$prefix|cat:''|cat:$smarty.section.index.index}
  </td>
</tr>
  {assign var="prev_status" value=$files[index].status}
{/section}
</table>
