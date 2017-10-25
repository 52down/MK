{*
5a3bb4dd1fb27e8b32d3a81a9ca5283dee6f9945, v3 (xcart_4_7_8), 2017-04-24 18:24:39, product_feeds_details.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<form action="{$script_name}" method="post" name="productfeedsdetailsform">
  <input type="hidden" name="section" value="feeds_details" />
  <input type="hidden" name="mode" value="product_feeds_modify" />
  <input type="hidden" name="productid" value="{$product.productid}" />
  <input type="hidden" name="geid" value="{$geid}" />

  {assign var=colspan value="{if $geid ne ''}4{else}3{/if}"}

  <table class="afds-catalog">

    <tr>
      <td colspan="{$colspan}"><h2>{$lng.lbl_amazon_feeds_catalog}</h2></td>
    </tr>

    <tr>
      <td colspan="{$colspan}">
        {include file="modules/Amazon_Feeds/feeds_logo.tpl"}
      </td>
    </tr>

    <tr>
      <td colspan="{$colspan}">&nbsp;</td>
    </tr>

    <tr>
      {if $geid ne ''}<td class="TableSubHead"><input type="checkbox" value="Y" name="fields[amazon_feeds_product_type]" /></td>{/if}
      <td nowrap="nowrap">
        <b>{$lng.lbl_amazon_feeds_product_type}:</b>
      </td>
      <td><font class="Star">*</font></td>
      <td>
        {include file="modules/Amazon_Feeds/product_type_selector.tpl" name="product[amazon_feeds_product_type]" value=$product.amazon_feeds_product_type}
        {if $top_message.fillerror ne "" and $product.amazon_feeds_product_type eq ""}<span class="Star">&lt;&lt;</span>{/if}
      </td>
    </tr>

    <tr>
      <td colspan="{$colspan}">&nbsp;</td>
    </tr>

    <tr>
      <td colspan="{$colspan}">
        <div>
          <input type="submit" value="{$lng.lbl_apply_changes|strip_tags:false|escape}" />
        </div>
      </td>
    </tr>

  </table>

</form>

<table class="afds-feeds-results">

  {assign var=colspan value="{if $product.is_variants eq 'Y'}5{else}4{/if}"}

  <tr>
    <td colspan="{$colspan}"><h2>{$lng.lbl_amazon_feeds_details}</h2></td>
  </tr>

  <tr class="TableHead">
    <th style="white-space: nowrap">{$lng.lbl_amazon_feeds_feed_type}</th>
  {if $product.is_variants eq 'Y'}
    <th>{$lng.lbl_sku}</th>
  {/if}
    <th>{$lng.lbl_amazon_feeds_type}</th>
    <th>{$lng.lbl_amazon_feeds_code}</th>
    <th>{$lng.lbl_amazon_feeds_feed_results}</th>
  </tr>

  {foreach from=$product.amazon_feeds_results item=r}
    <tr{cycle values=", class='TableSubHead'"}>
      <td>{$r.feed_type}</td>
    {if $product.is_variants eq 'Y'}
      <td>{$r.productcode}</td>
    {/if}
      <td>{$lng.{"lbl_amazon_feeds_result_{$r.result}"}}</td>
      <td>{$r.code}</td>
      <td>{$r.message}</td>
    </tr>
  {foreachelse}
    <tr>
      <td colspan="{$colspan}" align="center">{$lng.lbl_amazon_feeds_no_results}</td>
    </tr>
  {/foreach}

</table>

{load_defer file="modules/Amazon_Feeds/controller.js" type="js"}
