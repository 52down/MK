{*
8f6ff520011c544489eb7eb7838db325129066fd, v3 (xcart_4_7_3), 2015-06-05 17:46:44, aw_product.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

<div class="aw-container aw-product-details">
  <div class="aw-title hidden">
    <h1>
      {$aw_product.name}
    </h1>
  </div>
  <div class="aw-content aw-table">
    <div class="aw-trow">
      <div class="aw-tcell">
        <div class="aw-images">
          <div>
            {if $aw_product.image_urls.0}
              <img src="{$aw_product.image_urls.0|amp}" />
            {/if}
          </div>
          <ul>
            {foreach from=$aw_product.image_urls item=i}
              <li>
                <a href="{$i|amp}" title="{$aw_product.name}" rel="aw-images">
                  <img src="{$i|amp}" />
                </a>
              </li>
            {/foreach}
          </ul>
        </div>
        <hr />
        <div class="aw-suplier-info">
          <h4>{$lng.lbl_aw_supplier_info}</h4>
          <table>
            <tr>
              <td rowspan="4">
                {if $aw_product.supplier_info.logo_url}
                  <img src="{$aw_product.supplier_info.logo_url|amp}" width="50px" />
                {/if}
              </td>
            </tr>
            <tr>
              <td>{$lng.lbl_company_name}:</td>
              <td>{$aw_product.supplier_info.company_name}</td>
            </tr>
            <tr>
              <td>{$lng.lbl_aw_location}:</td>
              <td>
                {$aw_product.supplier_info.comp_country}, {$aw_product.supplier_info.comp_city}, {$aw_product.supplier_info.comp_province}
              </td>
            </tr>
            <tr>
              <td>{$lng.lbl_aw_golden_suplier_years}:</td>
              <td>
                {$aw_product.supplier_info.golden_supplier_years} {$lng.lbl_aw_years}
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="aw-tcell">
        <div class="aw-order-info">
          <p class="aw-price">
            <strong>{$aw_product.min_price} {$aw_product.currency}</strong> / <span>{$aw_product.unit}</span>
          </p>
          <p class="aw-text">
          {$lng.lbl_min_order_amount} <span>{$aw_product.moq} {if $aw_product.moq gt 1}{$aw_product.units}{else}{$aw_product.unit}{/if}</span>
        </p>
        </div>
        <div class="aw-buttons">
          <a class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only aw-buy-btn" href="{$aw_product.detail_url}" target="_blank">
            <span class="ui-button-text">{$lng.lbl_aw_view_and_buy}</span>
          </a>
          <br /><br />
          <a class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only aw-import-btn" href="alibaba_wholesale_catalog.php?action=import&amp;aw_product_id={$aw_product.id|urlencode}" target="_blank"> {* XCAlibabaWholesaleDefs->TYPE_IMPORT *}
            <span class="ui-button-text">{$lng.lbl_aw_import}</span>
          </a>
        </div>
        <hr />
        <div class="aw-product-info">
          <h4>{$lng.lbl_product_details}</h4>
          <table>
            {foreach from=$aw_product.property_list item=p key=propertyid}
              <tr id="{$p.id}">
                <td>{$p.property_name}{if $p.property_value}:{/if}</td>
                <td>{$p.property_value}</td>
              </tr>
            {/foreach}
          </table>
        </div>
        <div class="aw-freight-info">
        </div>
      </div>
    </div>
  </div>
</div>
