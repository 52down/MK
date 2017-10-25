{*
8f6ff520011c544489eb7eb7838db325129066fd, v1 (xcart_4_7_3), 2015-06-05 17:46:44, product_details_admin.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{aw_get_alibaba_wholesale_id productid=$product.productid assign='product_alibaba_wholesale_id'}
{if $product_alibaba_wholesale_id}
<tr>
  <td colspan="2">
    <a class="aw-product-sign" href="alibaba_wholesale_catalog.php?action=redirect&amp;aw_product_id={$product_alibaba_wholesale_id|urlencode}" target="_blank"></a> {* XCAlibabaWholesaleDefs->TYPE_REDIRECT *}
  </td>
</tr>
{/if}
