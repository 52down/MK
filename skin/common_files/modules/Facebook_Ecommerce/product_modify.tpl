{*
ad3a6575cb5e92118af4310c5e95ab1cfd69619c, v2 (xcart_4_7_8), 2017-05-24 10:42:28, product_modify.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{get_add_to_facebook_feed productid=$product.productid assign='smarty_add_to_facebook_feed'}
<tr>
  {if $geid ne ''}<td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="add_to_facebook_feed_ge_checked" /></td>{/if}
  <td class="FormButton" nowrap="nowrap"><label for="add_to_facebook_feed">{$lng.lbl_facebook_ecomm_add_to_feed}:</label></td>
  <td class="ProductDetails">
    <input type="hidden" name="add_to_facebook_feed" value="N" />
    <input type="checkbox" name="add_to_facebook_feed" id="add_to_facebook_feed" value="Y"{if $smarty_add_to_facebook_feed eq "Y"} checked="checked"{/if} />
  </td>
</tr>
