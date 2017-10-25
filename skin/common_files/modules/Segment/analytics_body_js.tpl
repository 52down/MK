{*
60f7192e0242007d465c06a1c586e543dec47d2a, v3 (xcart_4_7_7), 2016-07-01 19:06:28, analytics_body_js.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

<script type="text/javascript">
//<![CDATA[

function xc_segment_body() {ldelim}
  if (!analytics)
    return false;

  {* Identify User {{{ *}
  {if $login or $userinfo.email}
      analytics.identify('{$logged_userid|default:$userinfo.email|escape:javascript}', {ldelim}
        {if $logged_userid} website: '{$catalogs.admin}/user_modify.php?usertype={$usertype}&amp;user={$logged_userid|escape:url}',{/if}
        {if $userinfo}
          {if $userinfo.email}email: '{$userinfo.email|escape:javascript}',{/if}
          {if $userinfo.first_login}createdAt: '{$userinfo.first_login|escape:javascript}',{/if}
          {if $userinfo.firstname}firstName: '{$userinfo.firstname|escape:javascript}',{/if}
          {if $userinfo.lastname}lastName: '{$userinfo.lastname|escape:javascript}',{/if}
          {if $userinfo.id}id: '{$userinfo.id|escape:javascript}',{/if}
          {if $userinfo.phone}phone: '{$userinfo.phone|escape:javascript}',{/if}
          {if $userinfo.title}title: '{$userinfo.title|escape:javascript}',{/if}
          {if $userinfo.id}userId: '{$userinfo.id|escape:javascript}',{/if}
          {if $userinfo.b_city or $userinfo.b_zipcode or $userinfo.b_state or $userinfo.b_address or $userinfo.b_country}address: {ldelim}
            {if $userinfo.b_city}city: '{$userinfo.b_city|escape:javascript}',{/if}
            {if $userinfo.b_zipcode}postalCode: '{$userinfo.b_zipcode|escape:javascript}',{/if}
            {if $userinfo.b_state}state: '{$userinfo.b_state|escape:javascript}',{/if}
            {if $userinfo.b_address}street: '{$userinfo.b_address|escape:javascript}',{/if}
            {if $userinfo.b_country}country: '{$userinfo.b_country|escape:javascript}'{/if}
          {rdelim},{/if}
        {/if}
        name: '{$fullname|default:$userinfo.b_lastname|escape:javascript}'
      {rdelim});
  {/if}{* }}} *}

{* Track Open Login Popup {{{ *}
{if $config.Segment.segment_t_open_login_popup eq 'Y' and not $login}
    //segment_compatible from xcart_4_4_5
    $('#href_Sign_in').click(
    (function() {ldelim}
      analytics.track('Open Login Popup', {ldelim}
        current_area: '{$usertype}',
        from_page: document.title
      {rdelim});

    {rdelim}));
{/if}{* }}} *}

    {* Page view  {* {{{ *}
    if (document.title)
        analytics.page(document.title);
    else
        analytics.page();{* }}} *}

{* Track Viewed Product Category {{{ *}
{if
  $config.Segment.segment_t_viewed_category eq 'Y'
  and $main eq "catalog"
  and $current_category
}
  analytics.track('Viewed Product Category', {ldelim}
    category: '{$current_category.category|strip_tags:false|escape:javascript}'
  {rdelim});
{/if}{* }}} *}

{* Track Viewed Product {{{ *}
{if
  $config.Segment.segment_t_viewed_product eq 'Y'
  and $main eq "product"
  and $product
}
  analytics.track('Viewed Product', {ldelim}
    id: '{$product.productid}',
    sku: "{$product.productcode|strip_tags:false|escape:javascript}",
    name: "{$product.product|strip_tags:false|escape:javascript}{if $active_modules.Product_Options ne "" and $product.product_options_txt} ({$product.product_options_txt|replace:"\n":", "|strip_tags:false|escape:javascript}){/if}",
    price: "{$product.taxed_price}",
    category: document.title
  {rdelim});
{/if}{* }}} *}

{* Track Product Tabs Jump {{{ *}
{if
  $segment_product_tabs2track
  and $main eq "product"
  and $product
}
    {foreach from=$segment_product_tabs2track item="tracked_tab"}
      $('#product-tabs-container').find('a[href$="{$tracked_tab.anchor_link}"]').click(
      (function() {ldelim}
        analytics.track('{$tracked_tab.event_name}', {ldelim}
          name: "{$product.product|strip_tags:false|escape:javascript}",
          from_page: document.title
        {rdelim});
      {rdelim}));
    {/foreach}
{/if}{* }}} *}

{* Track Search Products {{{ *}
{if $config.Segment.segment_t_search_products eq 'Y'}
  (function() {ldelim}
    var search_form = $("form[name='productsearchform']");
    var place_holder = '{$lng.lbl_enter_keyword|strip_tags:false|escape:javascript}';
    var _search_string = search_form.find("input[name='posted_data[substring]']").val();
    _search_string = _search_string == place_holder ? '' : _search_string;
    analytics.trackForm(search_form, 'Search Products', {ldelim}
      search_string: _search_string,
      current_area: '{$usertype}'
    {rdelim});
    {if $main eq 'advanced_search' or $main eq 'search'}
      var search_form2 = $("form[name='searchform'][action='search.php']");
      analytics.trackForm(search_form2, 'Search Products', {ldelim}
        search_string: search_form2.find("input[name='posted_data[substring]']").val(),
        current_area: '{$usertype}'
      {rdelim});
    {/if}
  {rdelim})();
{/if}{* }}} *}

{* Track Send to Friend {{{ *}
{if $config.Segment.segment_t_send2friend eq 'Y' and ($main eq 'product' or $main eq 'send_to_friend')}
  (function() {ldelim}
    var search_form2 = $("form[name='send'][action='product.php']");
    analytics.trackForm(search_form2, 'Send to Friend', {ldelim}
      product_name: "{$product.product|strip_tags:false|escape:javascript}"
    {rdelim});
  {rdelim})();
{/if}{* }}} *}

{* Track Sent Contact Us {{{ *}
{if $config.Segment.segment_t_sent_contact_us eq 'Y' and $main eq 'help' and $help_section eq 'contactus'}
  (function() {ldelim}
    var search_form2 = $("form[name='registerform'][action^='help.php?section=contactus']");
    analytics.trackForm(search_form2, 'Sent Contact Us', {ldelim}
      current_area: '{$usertype}'
    {rdelim});
  {rdelim})();
{/if}{* }}} *}

{* Track Sent Survey {{{ *}
{if $config.Segment.segment_t_sent_survey eq 'Y' and $active_modules.Survey and ($menu_surveys or $survey)}
  (function() {ldelim}
    var search_form2 = $("form[name^='surveyfillmenuform'][action='survey.php']");
    analytics.trackForm(search_form2, 'Sent Survey', {ldelim}
      current_area: '{$usertype}'
    {rdelim});

    {if $main eq 'survey'}
      var search_form2 = $("form[name^='surveyfillform'][action='survey.php']");
      analytics.trackForm(search_form2, 'Sent Survey', {ldelim}
        current_area: '{$usertype}'
      {rdelim});
    {/if}
  {rdelim})();
{/if}{* }}} *}

{* Track Added/Removed Product {{{ *}
{if $config.Segment.segment_t_added_product eq 'Y' or $config.Segment.segment_t_removed_product eq 'Y'}
    $(ajax.messages).bind(
      'cartChanged',
      function(e, data) {ldelim}
        var g = 1;
        if (data.status == 1 && data.changes) {ldelim}
          for (var i in data.changes) {ldelim}
            if (hasOwnProperty(data.changes, i) && data.changes[i].changed != 0) {ldelim}
              analytics.track(data.changes[i].changed < 0 || data.changes[i].change > 0 ? 'Removed Product' : 'Added Product', {ldelim}
                id: data.changes[i].productid,
                quantity: data.changes[i].changed ? data.changes[i].changed : data.changes[i].change*-1,
                sku: data.changes[i].productid == '{$product.productid}' ? "{$product.productcode|strip_tags:false|escape:javascript}" : '',
                name: data.changes[i].productid == '{$product.productid}' ? "{$product.product|strip_tags:false|escape:javascript}{if $active_modules.Product_Options ne "" and $product.product_options_txt} ({$product.product_options_txt|replace:"\n":", "|strip_tags:false|escape:javascript}){/if}" : '',
                price: data.changes[i].productid == '{$product.productid}' ? "{$product.taxed_price}" : '',
                category: document.title
              {rdelim});
            {rdelim}
          {rdelim}
        {rdelim}

        return true;
      {rdelim}
    );
{/if}{* }}} *}

{* Track Open Minicart {{{ *}
{if $config.Segment.segment_t_open_minicart eq 'Y' and $minicart_total_items gt 0}
   //segment_compatible from xcart_4_3_0 for class
    $(".ajax-minicart-icon").click( // TODO add id for minicart
    (function() {ldelim}
      analytics.track('Open Minicart', {ldelim}
        current_area: '{$usertype}',
        from_page: document.title
      {rdelim});

    {rdelim}));
{/if}{* }}} *}

{* Track Completing Order {{{ *}
{if
  $config.Segment.segment_t_completed_order eq 'Y'
  and $ga_track_commerce eq "Y"
  and $main eq "order_message"
  and $orders
}
  {*segment_compatible: php must be patched related to Ga_track_commerce condition*}

  // Ecommerce Tracking for order_message page
  {foreach from=$orders item="order" name=placed_orders}
    {if $smarty.foreach.placed_orders.first}
      {assign var="_userinfo" value=$order.userinfo}
      analytics.identify('{$logged_userid|default:$_userinfo.email|escape:javascript}', {ldelim}
        {if $logged_userid} website: '{$catalogs.admin}/user_modify.php?usertype={$usertype}&amp;user={$logged_userid|escape:url}',{/if}
        {if $_userinfo}
          {if $_userinfo.email}email: '{$_userinfo.email|escape:javascript}',{/if}
          {if $_userinfo.first_login}createdAt: '{$_userinfo.first_login|escape:javascript}',{/if}
          {if $_userinfo.firstname}firstName: '{$_userinfo.firstname|escape:javascript}',{/if}
          {if $_userinfo.lastname}lastName: '{$_userinfo.lastname|escape:javascript}',{/if}
          {if $_userinfo.id}id: '{$_userinfo.id|escape:javascript}',{/if}
          {if $_userinfo.phone}phone: '{$_userinfo.phone|escape:javascript}',{/if}
          {if $_userinfo.title}title: '{$_userinfo.title|escape:javascript}',{/if}
          {if $_userinfo.id}userId: '{$_userinfo.id|escape:javascript}',{/if}
          {if $_userinfo.b_city or $_userinfo.b_zipcode or $_userinfo.b_state or $_userinfo.b_address or $_userinfo.b_country}address: {ldelim}
            {if $_userinfo.b_city}city: '{$_userinfo.b_city|escape:javascript}',{/if}
            {if $_userinfo.b_zipcode}postalCode: '{$_userinfo.b_zipcode|escape:javascript}',{/if}
            {if $_userinfo.b_state}state: '{$_userinfo.b_state|escape:javascript}',{/if}
            {if $_userinfo.b_address}street: '{$_userinfo.b_address|escape:javascript}',{/if}
            {if $_userinfo.b_country}country: '{$_userinfo.b_country|escape:javascript}'{/if}
          {rdelim},{/if}
        {/if}
        name: '{$fullname|default:$_userinfo.b_lastname|escape:javascript}'
      {rdelim});
    {/if}

    analytics.track('Completed Order', {ldelim}
      orderId: "{$order.order.orderid}",
      total: "{$order.order.total}",
      revenue: "{$order.order.subtotal}",
      {if $order.order.shipping_cost}shipping: "{$order.order.shipping_cost}",{/if}
      {if $order.order.tax}shipping: "{$order.order.tax}",{/if}
      {if $order.order.coupon_discount or $order.order.discount}discount: {$order.order.coupon_discount+$order.order.discount},{/if}{* works in 4.7.x only *}
      {if $order.order.coupon}coupon: "{$order.order.coupon|escape:javascript}",{/if}
      // currency: 'USD',

      products: [
        {foreach from=$order.products item="product"}
          {ldelim}
            id: "{$product.productid}",
            sku: "{$product.productcode|strip_tags:false|escape:javascript}",
            name: "{$product.product|strip_tags:false|escape:javascript}{if $active_modules.Product_Options ne "" and $product.product_options_txt} ({$product.product_options_txt|replace:"\n":", "|strip_tags:false|escape:javascript}){/if}",
            price: "{$product.price}",
            quantity: "{$product.amount}",
            category: "{$product.category|strip_tags:false|escape:javascript}"
          {rdelim},
        {/foreach}

        {foreach from=$giftcerts item="gc" name='giftcerts_foreach'}
          {ldelim}
            id: "{$order.order.orderid}_{$smarty.foreach.giftcerts_foreach.iteration}",
            name: "{$lng.lbl_recipient}: {$gc.recipient_email|strip_tags:false|escape:javascript}/{$gc.recipient_firstname|strip_tags:false|escape:javascript}/{$gc.recipient_lastname|strip_tags:false|escape:javascript}",
            price: "{$gc.amount}",
            quantity: "1"
          {rdelim},
        {/foreach}
      ]

  {/foreach}
  {rdelim});
{/if}{* }}} *}

{rdelim} // Function Xc_segment_body


if (document.addEventListener)
  document.addEventListener("DOMContentLoaded", xc_segment_body, false);
else
  window.attachEvent('onload', xc_segment_body);

//]]>
</script>
