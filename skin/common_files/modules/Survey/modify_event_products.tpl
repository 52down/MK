{*
ac8c94920113307390c6b99bee08baf69d0fbf39, v3 (xcart_4_7_5), 2016-02-18 10:02:02, modify_event_products.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{include file="main/visiblebox_link.tpl" mark="products" title=$lng.lbl_survey_ordered_products visible=$survey.event_elements.P}
<div id="boxproducts" style="padding-left: 20px;{if not $survey.event_elements.P} display: none;{/if}">

<table cellspacing="1" cellpadding="2">
<tr class="TableHead">
  <th width="15">&nbsp;</th>
  <th>{$lng.lbl_product}</th>
</tr>
{if $survey.event_elements.P}
{foreach from=$survey.event_elements.P key=code item=p}
<tr{cycle values=', class="TableSubHead"' name="product"}>
  <td><input type="checkbox" name="check[P][]" value="{$code}" /></td>
  <td>{$p.product}</td>
</tr>
{/foreach}
<tr>
  <td colspan="2"><input type="button" value="{$lng.lbl_delete_selected|strip_tags:false|escape}" onclick="javascript: this.form.delete_param.value = 'P'; if (checkMarks(this.form, new RegExp('check\\[P\\]\\[\\]', 'gi'))) submitForm(this, 'delete_event');" /></td>
</tr>
<tr>
  <td colspan="2">{include file="main/subheader.tpl" title=$lng.lbl_survey_add_product class="grey"}</td>
</tr>
{/if}
<tr>
  <td id="add_product_box_1">&nbsp;</td>
  <td id="add_product_box_2" nowrap="nowrap">
<input type="hidden" name="new_element[P][0]" />
<input type="text" size="55" name="newproduct[0]" placeholder="{$lng.lbl_enter_skus|strip_tags:false|escape}" />
<input type="button" value="{$lng.lbl_browse_|strip_tags:false|escape}" onclick="javascript: popup_product_multi(this);" />
  </td>
  <td>{include file="buttons/multirow_add.tpl" mark="add_product" is_lined=true}</td>
</tr>
</table>

</div>
