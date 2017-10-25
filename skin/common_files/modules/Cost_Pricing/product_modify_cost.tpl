{*
8ee330cdccbe9f6ff951def88197ff1e141bb05c, v2 (xcart_4_7_5), 2016-02-08 19:08:36, product_modify_cost.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

<tr>
  {if $geid ne ''}<td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="costp_ge_checked" /></td>{/if}
  <td class="FormButton" nowrap="nowrap">{$lng.lbl_cost_price} <span class="Text">({$config.General.currency_symbol}):</span></td>
  <td class="ProductDetails">
    <input type="text" name="cost_price" id="cost_price" size="18" value="{costp_get_price productid=$product.productid default=$product.cost_price}" />
  </td>
</tr>
