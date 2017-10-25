{*
442247067db63ddbfaaef7de30c2fd9530d4b850, v2 (xcart_4_7_8), 2017-06-06 16:31:36, shippingeasy_statuses.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{include file="page_title.tpl" title=$lng.lbl_shippingeasy_statuses}

<br />

{$lng.txt_shippingeasy_statuses_top_text}

<br /><br />

{capture name=dialog}

<form action="shippingeasy_statuses.php" method="post" name="ses_form">
<input type="hidden" name="mode" value="update" />

<table cellpadding="2" cellspacing="1" width="100%">
<tr class="TableHead">
  <td width="15">&nbsp;</td>
  <td width="50%">{$lng.lbl_shippingeasy_x_status}</td>
  <td width="50%">{$lng.lbl_shippingeasy_status}</td>
</tr>

{if $shippingeasy_statuses ne ''}
{foreach from=$shippingeasy_statuses item=v}
<tr{cycle values=', class="TableSubHead"'}>
  <td><input type="checkbox" name="ids[]" value="{$v.id}" /></td>
  <td align="center">{include file="main/order_status.tpl" status=$v.x_status mode="static" name="add[x_status]"}</td>
  <td align="center">{include file="modules/ShippingEasy/shippingeasy_status.tpl" status=$v.se_status mode="static" name="add[se_status]"}</td>
</tr>
{/foreach}
{else}
<tr>
  <td colspan="3" align="center">{$lng.txt_shippingeasy_no_data}</td>
</tr>
{/if}

{if $shippingeasy_statuses ne ''}
<tr>
  <td>&nbsp;</td>
  <td colspan="2" class="SubmitBox">
    <input type="button" value="{$lng.lbl_delete_selected|strip_tags:false|escape}" onclick="javascript: if (checkMarks(this.form, new RegExp('ids', 'ig'))) submitForm(this, 'delete');" />
  </td>
</tr>
{/if}

<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td colspan="3">{include file="main/subheader.tpl" title=$lng.lbl_add_new}</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td align="center">{include file="main/order_status.tpl" status='P' mode="select" name="add[x_status]"}</td>
  <td align="center">{include file="modules/ShippingEasy/shippingeasy_status.tpl" status='awaiting_shipment' mode="select" name="add[se_status]"}</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="2"><input type="button" value="{$lng.lbl_add|strip_tags:false|escape}" onclick="javascript: submitForm(this, 'add');" /></td>
</tr>

</table>
</form>

<br />
{/capture}
{include file="dialog.tpl" title='' content=$smarty.capture.dialog extra='width="100%"'}
