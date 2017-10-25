{*
c637cdcaba13a2df236f4557880eea90aee41b81, v4 (xcart_4_7_7), 2017-01-25 18:42:58, product_details.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<tr>
  <td class="property-name product-price" valign="top">{$lng.lbl_xps_setup_fee}:</td>
  <td class="property-value" valign="top" colspan="2">
    <span class="product-price-value">{currency value=$product.taxed_price tag_id="product_price"}</span>
    <span class="product-market-price">{alter_currency value=$product.taxed_price tag_id="product_alt_price"}</span>
    {if $product.taxes}
      <br />{include file="customer/main/taxed_price.tpl" taxes=$product.taxes}
    {/if}
  </td>
</tr>

<tr>
  <td class="property-name product-price" valign="top">{$lng.lbl_xps_subscription_fee}:</td>
  <td class="property-value" valign="top" colspan="2">
    <span class="product-price-value">{currency value=$product.subscription.fee tag_id="subscription_fee"}</span>
    <span class="product-market-price">{alter_currency value=$product.subscription.fee tag_id="subscription_alt_fee"}</span>
  </td>
</tr>

<tr>
  <td class="property-name product-price" valign="top">&nbsp;</td>
  <td class="property-value" valign="top" colspan="2">
    {$product.subscription.desc}
    {if $product.subscription.rebill_periods gt 1}
      <br/>{$lng.lbl_xps_total_payments}: {$product.subscription.rebill_periods}
    {/if}
  </td>
</tr>
