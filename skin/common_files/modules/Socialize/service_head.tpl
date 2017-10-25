{*
070d1eca8841250c1c77f5ffa9b72676b0319ce4, v25 (xcart_4_7_4), 2015-09-21 18:39:00, service_head.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $active_modules.Socialize and $main neq 'cart' and $main neq 'checkout'
  and ($products neq '' or $product neq '' or $f_products ne '' or $new_arrivals ne '' or $cat_products ne '' or $main eq 'manufacturer_products')
  and (!$ie_ver or $ie_ver gt 6)
}
  {if not $active_modules.Facebook_Tab and not $is_w3c_validator}
    {if $main eq 'product' and $product}
      {*{{{product page*}
      {assign var="prod_descr" value=$product.descr|default:$product.fulldescr}
      <meta property="og:title" content="{$product.product|strip_tags|escape}"/>
      <meta property="og:description" content="{$prod_descr|truncate:'500':'...':false|strip_tags|escape}" />
      <meta property="og:url" content="{$http_location}/{$canonical_url}" />
      {*generate "og:image" "og:image:width" "og:image:height"*}
      {func_soc_tpl_get_og_image images=$product.images def_image=$product.image_url}
      {* Admin field. Use it for Insights
      <meta property="fb:admins" content="%YOUR_FB_USERID_HERE%" />
      }}}*}
    {elseif $main eq 'catalog' and $current_category}
      {*{{{category page*}
      <meta property="og:title" content="{$current_category.category|strip_tags|escape}"/>
      <meta property="og:description" content="{$current_category.description|truncate:'500':'...':false|strip_tags|escape}" />
      <meta property="og:url" content="{$http_location}/{$canonical_url}" />
      {if $current_category.is_icon and $current_category.image_path ne ''}
        <meta property="og:image" content="{get_category_image_url category=$current_category}" />
        {if $current_category.image_x}<meta property="og:image:width" content="{$current_category.image_x}" />{/if}
        {if $current_category.image_y}<meta property="og:image:height" content="{$current_category.image_y}" />{/if}
      {/if} {*}}}*}
    {elseif $main eq 'manufacturer_products' and $manufacturer}
      {*{{{manufacturer page*}
      <meta property="og:title" content="{$manufacturer.manufacturer|strip_tags|escape}"/>
      <meta property="og:description" content="{$manufacturer.descr|truncate:'500':'...':false|strip_tags|escape}" />
      <meta property="og:url" content="{$http_location}/{$canonical_url}" />
      {if $manufacturer.is_image eq 'Y'}
        <meta property="og:image" content="{$manufacturer.image_url}" />
        {if $manufacturer.image_x}<meta property="og:image:width" content="{$manufacturer.image_x}" />{/if}
        {if $manufacturer.image_y}<meta property="og:image:height" content="{$manufacturer.image_y}" />{/if}
      {/if}{*}}}*}
    {/if}
  {/if}
  {if $main eq 'product'
    or $config.Socialize.soc_plist_matrix eq "Y"
    or $config.Socialize.soc_plist_plain eq "Y"
  }
    {*{{{ pinterest js code*}
    {if $config.Socialize.soc_pin_enabled eq "Y"}
      {capture name="pinterest_options"}
        var pinterest_endpoint = "//assets.pinterest.com/pinit.html";
        {literal}
          var pinterest_options = {
            att: {
              layout: "count-layout",
              count: "always-show-count"
            },
            endpoint: pinterest_endpoint,
              button: "//pinterest.com/pin/create/button/?",
              vars: {
              req: ["url", "media"],
              opt: ["title", "description"]
            },
            layout: {
              none: {
                width: 43,
                height: 20
              },
              vertical: {
                width: 43,
                height: 58
              },
              horizontal: {
                width: 90,
                height: 20
              }
            }
          }
        {/literal}
      {/capture}
      {capture name="pinterest_call"}
        $(function(){ldelim}
          pin_it();
        {rdelim});
      {/capture}
      {load_defer file="pinterest_options" direct_info=$smarty.capture.pinterest_options type="js" queue=2049}
      {load_defer file="modules/Socialize/pinterest.js" type="js" queue=2050}
      {load_defer file="pinterest_call" direct_info=$smarty.capture.pinterest_call type="js" queue=2051}
    {/if}
  {/if}{*}}}*}
{/if}
{load_defer file="modules/Socialize/main.css" type="css"}
