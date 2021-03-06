{*
a3bd74e6f2f35ff8e940f539239f9f18761bdb4e, v2 (xcart_4_6_4), 2014-06-13 12:20:00, on_sale_icon_products_list.tpl, mixon
vim: set ts=2 sw=2 sts=2 et:
*}

{if $usertype eq "C" && $product.on_sale eq "Y"
  && (
    ($main eq "catalog" && ($cat le "0" || $cat eq "") && $config.On_Sale.on_sale_on_home_page eq "Y")
    || ($main eq "catalog" && $cat gt "0" && $config.On_Sale.on_sale_on_product_list eq "Y")
    || ($main eq "on_sale" && $config.On_Sale.on_sale_on_sale_page eq "Y")
    || (($main eq "search" || $main eq "advanced_search") && $config.On_Sale.on_sale_on_search_page eq "Y")
    || ($main eq "pmap_customer" && $config.On_Sale.on_sale_on_pmap_page eq "Y")
  )}
  {assign var=is_on_sale_product value="Y"}
{else}
  {assign var=is_on_sale_product value="N"}
{/if}

<a href="{$url}"{if $config.Appearance.thumbnail_height gt 0 or $product.tmbn_y gt 0 or $max_images_height gt 0} style="height: {$max_images_height|default:$config.Appearance.thumbnail_height|default:$product.tmbn_y}px;"{/if}>
{if $is_on_sale_product eq "Y"}
  <div class="on_sale_wrapper">
{/if}

{include file="product_thumbnail.tpl" productid=$product.productid image_x=$product.tmbn_x image_y=$product.tmbn_y product=$product.product tmbn_url=$product.tmbn_url}

{if $is_on_sale_product eq "Y"}
    <div class="on-sale-icon"></div>
  </div>
{/if}
</a>
