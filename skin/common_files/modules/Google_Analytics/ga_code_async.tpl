{*
c0b5bca07617f5c9acaab782a0dec4b735db0d59, v5 (xcart_4_7_4), 2015-08-21 09:17:23, ga_code_async.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<script type="text/javascript">
//<![CDATA[

var _gaq = _gaq || [];
_gaq.push(["_setAccount", "{$config.Google_Analytics.ganalytics_code}"]);
_gaq.push(["_trackPageview"]);

{if 
  $config.Google_Analytics.ganalytics_e_commerce_analysis eq "Y" 
  and $ga_track_commerce eq "Y" 
  and $main eq "order_message"
  and $orders
}
  // Ecommerce Tracking for order_message page
  {foreach from=$orders item="order"}
    _gaq.push(["_addTrans",
      "{$order.order.orderid}",           // order ID - required
      "{$partner|default:'Main stock'}",  // affiliation or store name
      "{$order.order.total}",          // total - required
      "{if $order.order.tax gt 0}{$order.order.tax}{/if}",      // tax
      "{if $order.order.shipping_cost gt 0}{$order.order.shipping_cost}{/if}", // shipping
      "{$order.order.b_city|wm_remove|escape:javascript}",      // city
      "{$order.order.b_state|wm_remove|escape:javascript}",     // state or province
      "{$order.order.b_countryname|wm_remove|escape:javascript}"// country
    ]);

    {foreach from=$order.products item="product"}
      _gaq.push(["_addItem",
        "{$order.order.orderid}",           // order ID - required
        "{$product.productcode|wm_remove|escape:javascript}", // SKU/code - required
        "{$product.product|wm_remove|escape:javascript}{if $active_modules.Product_Options ne "" and $product.product_options_txt} ({$product.product_options_txt|replace:"\n":", "|wm_remove|escape:javascript}){/if}", // product name
        "{$product.category|default:'Unknown category'}", // category or variation
        "{$product.price}",          // unit price - required
        "{$product.amount}"          // quantity - required
      ]);
    {/foreach}

  {/foreach}
  _gaq.push(['_trackTrans']); //submits transaction to the Analytics servers
{/if}
{* The main script will be loaded in service_body_js.tpl below*}

//]]>
</script>
