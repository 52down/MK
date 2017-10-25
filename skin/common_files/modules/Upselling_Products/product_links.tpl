{*
f796cd4ac105eb160691c59c49e70773bd16b2d8, v8 (xcart_4_7_7), 2016-09-01 16:39:33, product_links.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}
{if $active_modules.Upselling_Products ne ""}

{capture name=js_ajax_search_by_sku_fields_related}
  var autocomplete_field_selector = "#selected_productid_ids";
  var js_ajax_session_quick_key = "{get_ajax_session_quick_key|escape:javascript}";
{/capture}
{load_defer file="js_ajax_search_by_sku_fields_related" direct_info=$smarty.capture.js_ajax_search_by_sku_fields_related type="js"}

{include file="jquery_ui_autocomplete.tpl"}
{load_defer file="js/popup_product.js" type="js"}

{$lng.txt_upselling_links_top_text}

<br /><br />

{capture name=dialog}
<form action="product_modify.php" name="upsales" method="post">

<input type="hidden" name="productid" value="{$product.productid}" />
<input type="hidden" name="selected_productid" value="" />
<input type="hidden" name="mode" value="upselling_links" />
<input type="hidden" name="geid" value="{$geid}" />

<table {if $geid ne ''}cellspacing="0" cellpadding="4"{else}cellspacing="1" cellpadding="2"{/if} width="100%">

<tr class="TableHead">
{if $geid ne ''}<td width="15" class="TableSubHead">&nbsp;</td>{/if}
  <td width="15" class="DataTable">&nbsp;</td>
  <td width="20" class="DataTable">{$lng.lbl_pos}</td>
  <td width="15%" class="DataTable">{$lng.lbl_productid}</td>
  <td width="15%" class="DataTable">{$lng.lbl_sku}&nbsp;&nbsp;&nbsp;</td>
  <td width="70%">{$lng.lbl_product}</td>
</tr>

{if $product_links}

{section name=cat_num loop=$product_links}

<tr{cycle values=", class='TableSubHead'"}>
  {if $geid ne ''}<td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[u_product][{$product_links[cat_num].productid}]" /></td>{/if}
  <td><input type="checkbox" value="Y" name="uids[{$product_links[cat_num].productid}]" /></td>
  <td class="DataTable"><input type="text" value="{$product_links[cat_num].orderby}" name="upselling[{$product_links[cat_num].productid}]" size="4" /></td>
  <td class="DataTable"><a href="product_modify.php?productid={$product_links[cat_num].productid}" class="ItemsList">#{$product_links[cat_num].productid}</a></td>
  <td class="DataTable"><a href="product_modify.php?productid={$product_links[cat_num].productid}" class="ItemsList">{$product_links[cat_num].productcode}</a></td>
  <td class="DataTable"><a href="{$catalogs.customer}/product.php?productid={$product_links[cat_num].productid}&amp;is_admin_preview=Y" class="ItemsList">{$product_links[cat_num].product|truncate:64:"...":false|amp}{if $forsale_labels[$product_links[cat_num].forsale]}&nbsp;(<span class="SmallText"><i>{$lng[$forsale_labels[$product_links[cat_num].forsale]]}</i></span>){/if}</a></td>
</tr>
{/section}

<tr>
  {if $geid ne ''}<td width="15" class="TableSubHead">&nbsp;</td>{/if}
  <td nowrap="nowrap" colspan="4"><br />
  <input type="button" value="{$lng.lbl_delete_selected|strip_tags:false|escape}" onclick="javascript: if (checkMarks(this.form, new RegExp('uids', 'gi'))) {ldelim}document.upsales.mode.value='del_upsale_link'; document.upsales.submit();{rdelim}" />
  </td>
  <td align="center"><br />
  <input type="submit" value="{$lng.lbl_update|strip_tags:false|escape}" />
  </td>
</tr>

{else}

<tr>
  {if $geid ne ''}<td width="15" class="TableSubHead">&nbsp;</td>{/if}
  <td colspan="5" align="center">{$lng.lbl_no_products}</td>
</tr>

{/if}

<tr>
  {if $geid ne ''}<td width="15" class="TableSubHead">&nbsp;</td>{/if}
  <td>&nbsp;</td>
</tr>
<tr>
  {if $geid ne ''}<td width="15" class="TableSubHead">&nbsp;</td>{/if}
  <td colspan="5">{include file="main/subheader.tpl" title=$lng.lbl_add_new_link}</td>
</tr>

<tr>
  {if $geid ne ''}<td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[new_u_product]" /></td>{/if}
  <td colspan="5">
    {$lng.lbl_product}: 
    <input id="selected_productid_ids" name="selected_productid_ids" size="40" style="width: 50%" autofocus="autofocus" placeholder="{$lng.lbl_enter_skus|strip_tags:false|escape}" />
    <input type="button" value="{$lng.lbl_browse_|strip_tags:false|escape}" onclick="javascript: popup_product('upsales.selected_productid', 'upsales.selected_productid_ids');" tabindex="-1" />
    &nbsp;&nbsp;&nbsp;<input type="checkbox" id="bi_directional" name="bi_directional" />
    <label for="bi_directional">{$lng.lbl_bidirectional_link}</label>
  </td>
</tr>
<tr>
  {if $geid ne ''}<td width="15" class="TableSubHead">&nbsp;</td>{/if}
  <td>&nbsp;</td>
</tr>
<tr>
  {if $geid ne ''}<td width="15" class="TableSubHead">&nbsp;</td>{/if}
  <td nowrap="nowrap" colspan="4" align="right">
  <input type="submit" value="{$lng.lbl_add|strip_tags:false|escape}" />
  </td>
  <td>&nbsp;</td>
</tr>
</table>
</form>

{/capture}
{include file="dialog.tpl" title=$lng.lbl_related_products content=$smarty.capture.dialog extra='width="100%"'}
{/if}
