{*
5a3bb4dd1fb27e8b32d3a81a9ca5283dee6f9945, v4 (xcart_4_7_8), 2017-04-24 18:24:39, product_type_selector.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $amazon_feeds_catalog}
{include file="widgets/css_loader.tpl" css="lib/select2/css/select2.min.css"}
{load_defer file="lib/select2/js/select2.min.js" type="js"}
{load_defer file="lib/select2/js/i18n/$shop_language.js" type="js"}

{include file="widgets/categoryselector/config.tpl" assign="categoryselectorconfig" extra_cat_config=$extra_cat_config}

{include file="widgets/css_loader.tpl" css="widgets/categoryselector/categoryselector.css"}
{load_defer file="widgets/categoryselector/categoryselector.js" type="js"}

<div class="afds-product-type">
  <select name="{$name}" class="categoryselector InputWidth" data-categoryselectorconfig="{$categoryselectorconfig|escape}">
    <option value="{XCAmazonFeedsDefs::SEARCH_FORM_EMPTY_CAT_VALUE}"{if $value eq XCAmazonFeedsDefs::SEARCH_FORM_EMPTY_CAT_VALUE or $value eq ""} selected="selected"{/if} title="{$lng.lbl_amazon_feeds_no_type}">{$lng.lbl_amazon_feeds_no_type}</option>
    {foreach from=$amazon_feeds_catalog item=grp key=name}
      <optgroup label="{$name}">
        {foreach from=$grp item=pt key=ptid}
          <option value="{$ptid|escape}" title="{$pt|strip_tags:false|escape}"{if $value eq $ptid} selected="selected"{/if}>{$pt}</option>
        {/foreach}
      </optgroup>
    {/foreach}
  </select>
  <div class="error-label">{$lng.err_amazon_feeds_type_required|escape}</div>
</div>
{/if}{* if $amazon_feeds_catalog *}
