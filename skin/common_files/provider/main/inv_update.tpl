{*
77563b994f43e8957e1ec8cd18a164903de776ee, v3 (xcart_4_7_5), 2016-01-29 17:42:55, inv_update.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{include file="page_title.tpl" title=$lng.lbl_update_inventory}

<form method="post" action="inv_update.php" enctype="multipart/form-data">

<table cellpadding="0" cellspacing="4" width="100%">

<tr>
  <td>{$lng.lbl_update}</td>
  <td>
  <select name="what">
     <option value="p" {if $inv_update_fields.what eq 'p'}selected="selected"{/if}>{$lng.lbl_pricing}</option>
     <option value="q" {if $inv_update_fields.what eq 'q'}selected="selected"{/if}>{$lng.lbl_in_stock}</option>
  </select>
  </td>
</tr>

<tr>
  <td>{$lng.txt_adm_1st_column_is_inv_update}</td>
  <td>
  <select name="first_column_type">
     <option value="by_sku" {if $inv_update_fields.first_column_type eq 'by_sku'}selected="selected"{/if}>{$lng.lbl_sku}</option>
     <option value="by_sku_or_productid" {if $inv_update_fields.first_column_type eq 'by_sku_or_productid'}selected="selected"{/if}>{$lng.lbl_adm_sku_or_productid}</option>
     <option value="by_productid" {if $inv_update_fields.first_column_type eq 'by_productid'}selected="selected"{/if}>{$lng.lbl_productid}</option>
  </select>
  </td>
</tr>

<tr>
  <td>{$lng.lbl_csv_delimiter}</td>
  <td>{include file="provider/main/ie_delimiter.tpl" saved_delimiter=$inv_update_fields.delimiter}</td>
</tr>
<tr>
  <td>{$lng.lbl_csv_file}</td>
  <td><input type="file" name="userfile" />
{if $upload_max_filesize}
<br /><font class="Star">{$lng.lbl_warning}!</font> {$lng.txt_max_file_size_that_can_be_uploaded}: {$upload_max_filesize}b.
{/if} 
  </td>
</tr>

<tr>
  <td colspan="2" class="main-button">
    <input type="submit" value="{$lng.lbl_update|strip_tags:false|escape}" />
  </td>
</tr>

</table>
</form>
