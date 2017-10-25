{*
a769b0d78488d7f50b227e642fa05218c5862fa4, v8 (xcart_4_7_8), 2017-02-12 18:21:54, featured_products.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{capture name=js_ajax_search_by_sku_fields}
  var autocomplete_field_selector = "#newproduct_ids";
  var js_ajax_session_quick_key = "{get_ajax_session_quick_key|escape:javascript}";
{/capture}
{load_defer file="js_ajax_search_by_sku_fields" direct_info=$smarty.capture.js_ajax_search_by_sku_fields type="js"}

{include file="jquery_ui_autocomplete.tpl"}
{load_defer file="js/popup_product.js" type="js"}

<a name="featured"></a>

{$lng.txt_featured_products}

<br /><br />

{capture name=dialog}

{if $products ne ""}
{include file="main/check_all_row.tpl" style="line-height: 170%;" form="featuredproductsform" prefix="posted_data.+to_delete"}
{/if}

<form action="categories.php" method="post" name="featuredproductsform">
<input type="hidden" name="mode" value="update" />
<input type="hidden" name="cat" value="{$f_cat}" />

<table cellpadding="3" cellspacing="1" width="100%">

<tr class="TableHead">
  <td width="10">&nbsp;</td>
  <td width="10%">{$lng.lbl_sku}</td>
  <td width="70%">{$lng.lbl_product_name}</td>
  <td width="15%" align="center">{$lng.lbl_pos}</td>
  <td width="5%" align="center">{$lng.lbl_active}</td>
</tr>

{if $products}

{section name=prod_num loop=$products}

<tr{cycle values=", class='TableSubHead'"}>
  <td><input type="checkbox" name="posted_data[{$products[prod_num].productid}][to_delete]" /></td>
  <td><b><a href="product_modify.php?productid={$products[prod_num].productid}">{$products[prod_num].productcode}</a></b></td>
  <td><b><a href="{$catalogs.customer}/product.php?productid={$products[prod_num].productid}&amp;is_admin_preview=Y" target="_blank">{$products[prod_num].product}</a></b></td>
  <td align="center"><input type="text" name="posted_data[{$products[prod_num].productid}][product_order]" size="5" value="{$products[prod_num].product_order}" /></td>
  <td align="center"><input type="checkbox" name="posted_data[{$products[prod_num].productid}][avail]"{if $products[prod_num].avail eq "Y"} checked="checked"{/if} /></td>
</tr>

{/section}

<tr>
  <td colspan="5" class="SubmitBox">
  <input type="button" value="{$lng.lbl_delete_selected|strip_tags:false|escape}" onclick="javascript: if (checkMarks(this.form, new RegExp('posted_data\\[[0-9]+\\]\\[to_delete\\]', 'ig'))) {ldelim}document.featuredproductsform.mode.value = 'delete'; document.featuredproductsform.submit();{rdelim}" />
  <input type="submit" value="{$lng.lbl_update|strip_tags:false|escape}" />
  </td>
</tr>

{else}

<tr>
<td colspan="5" align="center">{$lng.txt_no_featured_products}</td>
</tr>

{/if}

</table>
</form>

<form action="categories.php" method="post" name="add_featuredproductsform">
<input type="hidden" name="mode" value="add" />
<input type="hidden" name="cat" value="{$f_cat}" />

<table cellpadding="3" cellspacing="1" width="100%">

<tr>
<td colspan="5"><br /><br />{include file="main/subheader.tpl" title=$lng.lbl_add_product}</td>
</tr>

<tr>
  <td colspan="3">
    <input type="hidden" name="newproductid" />
    <input name="newproduct_ids" id="newproduct_ids" size="64" placeholder="{$lng.lbl_enter_skus|strip_tags:false|escape}" />
    <input type="button" value="{$lng.lbl_browse_|strip_tags:false|escape}" tabindex="-1" onclick="javascript: popup_product('add_featuredproductsform.newproductid', 'add_featuredproductsform.newproduct_ids');" />
  </td>
  <td align="center"><input type="text" name="neworder" size="5" /></td>
  <td align="center"><input type="checkbox" name="newavail" checked="checked" /></td>
</tr>

<tr>
  <td colspan="5" class="SubmitBox">
  <input type="submit" value="{$lng.lbl_add_new|strip_tags:false|escape}" onclick="javascript: document.add_featuredproductsform.mode.value = 'add'; document.add_featuredproductsform.submit();"/>
  </td>
</tr>

</table>
</form>

{/capture}
{include file="dialog.tpl" title=$lng.lbl_featured_products content=$smarty.capture.dialog extra='width="100%"'}
