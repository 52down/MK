{*
141c878b03b2b0cdd5d2b31c952f4e1031962148, v1 (xcart_4_7_8), 2017-05-18 15:44:49, ad_events_body.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<script type="text/javascript">
//<![CDATA[

{* Track Viewed Product {{{ *}
{if
  $main eq "product"
  and $product
}
  fbq('track', 'ViewContent', {ldelim}
      content_type: 'product_group', //either 'product' or 'product_group'
      content_ids: ['_pid{$product.productid}'], //array of one or more product ids in the page
      value: "{$product.taxed_price}",    //OPTIONAL, but highly recommended
      currency: '{$store_currency|default:$config.facebook_ecomm_currency|escape:javascript}' //store_currency is from if $active_modules.XMultiCurrency
  {rdelim});
{/if}{* }}} *}

{* Track Added/Removed Product {{{ *}
    $(ajax.messages).bind(
      'cartChanged',
      function(e, data) {ldelim}
        var g = 1;
        if (data.status == 1 && data.changes) {ldelim}
          for (var i in data.changes) {ldelim}
            if (hasOwnProperty(data.changes, i) && data.changes[i].changed != 0) {ldelim}
              fbq('track', data.changes[i].changed < 0 || data.changes[i].change > 0 ? 'RemoveFromCart' : 'AddToCart', {ldelim}
                content_ids: ['_pid' + data.changes[i].productid],
                content_type: 'product_group',
                value: data.changes[i].productid == '{$product.productid}' ? "{$product.taxed_price}" : '',
                currency: '{$store_currency|default:$config.facebook_ecomm_currency|escape:javascript}'//store_currency is from if $active_modules.XMultiCurrency
              {rdelim});
            {rdelim}
          {rdelim}
        {rdelim}

        return true;
      {rdelim}
    );
{* }}} *}

{* Track Completing Order {{{ *}
{if
  $ga_track_commerce eq "Y"
  and $main eq "order_message"
  and $orders
}
  // Ecommerce Tracking for order_message page
  {foreach from=$orders item="order" name=placed_orders}
    fbq('track', 'Purchase', {ldelim}
        content_type: 'product', //either 'product' or 'product_group'
        content_ids: [{foreach from=$order.products item="product"}'{$product.productcode|default:$product.productid|escape:javascript}',{/foreach}], //array of one or more product ids in the page
        value: {$order.order.total}, //
        currency: '{$store_currency|default:$config.facebook_ecomm_currency|escape:javascript}' //the currency of the web site, it would be taken as “USD” by default if not specified
    {rdelim});
  {/foreach}
{/if}{* }}} *}

//]]>
</script>
