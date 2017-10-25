{*
5a3bb4dd1fb27e8b32d3a81a9ca5283dee6f9945, v3 (xcart_4_7_8), 2017-04-24 18:24:39, products_search.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

<script type="text/javascript">
//<![CDATA[
searchform_def[searchform_def.length] = ['posted_data[amazon_feeds_exported]', ''];
searchform_def[searchform_def.length] = ['posted_data[s_amazon_feeds_product_type]', '{XCAmazonFeedsDefs::SEARCH_FORM_EMPTY_CAT_VALUE}'];

//]]>
</script>
<tr>
  <td height="10" width="20%" class="FormButton" nowrap="nowrap" valign="top">{$lng.lbl_amazon_feeds_export_status}:</td>
  <td>

    <select id="amazon_feeds_exported" name="posted_data[amazon_feeds_exported]">
      <option value=""{if $search_prefilled.amazon_feeds_exported eq ""} selected="selected"{/if}>{$lng.lbl_amazon_feeds_export_no_status}</option>
      <option value="exported"{if $search_prefilled.amazon_feeds_exported eq "exported"} selected="selected"{/if}>{$lng.lbl_amazon_feeds_export_exported}</option>
      <option value="has_warnings"{if $search_prefilled.amazon_feeds_exported eq "has_warnings"} selected="selected"{/if}>{$lng.lbl_amazon_feeds_export_warnings}</option>
      <option value="has_errors"{if $search_prefilled.amazon_feeds_exported eq "has_errors"} selected="selected"{/if}>{$lng.lbl_amazon_feeds_export_errors}</option>
    </select>

  </td>
</tr>

{getvar var='amazon_feeds_catalog' func='func_amazon_feeds_tpl_get_amazon_feeds_cats'}
<tr>
  <td height="10" class="FormButton" nowrap="nowrap">{$lng.lbl_amazon_feeds_product_type}:</td>
  <td width="80%">
    {include file="modules/Amazon_Feeds/product_type_selector.tpl" name="posted_data[s_amazon_feeds_product_type]" value=$search_prefilled.s_amazon_feeds_product_type amazon_feeds_catalog=$amazon_feeds_catalog extra_cat_config='"width": "70%",'}
  </td>
</tr>
