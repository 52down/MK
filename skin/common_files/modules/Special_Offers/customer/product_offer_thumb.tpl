{*
90e167bac1deecf9bafde0eb487e169dd685e0ea, v3 (xcart_4_7_7), 2017-01-25 10:09:46, product_offer_thumb.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $product.have_offers and $product.sp_discount_avail ne 'N' and $config.Special_Offers.offers_show_thumb_on_lists eq 'Y'}
  <a href="offers.php?mode=product&amp;productid={$product.productid}" class="offers-thumbnail"><img src="{$ImagesDir}/spacer.gif" alt="" /></a>
{/if}
