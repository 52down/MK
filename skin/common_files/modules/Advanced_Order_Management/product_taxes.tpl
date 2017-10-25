{*
c9016cf692c87f3c321f356ac5f6f6777f05390e, v5 (xcart_4_7_7), 2017-01-19 14:53:33, product_taxes.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}
{assign var='product_taxes' value=$product.taxes}
{if $product.taxes eq "" and $product.extra_data.taxes ne ''}
  {assign var='product_taxes' value=$product.extra_data.taxes}
{/if}
{if $product_taxes ne ""}
  <div class="aom-product-taxes">
    {foreach from=$product_taxes key=tax_name item=tax}
      {if $tax.tax_value gt 0}
        <div title="{$lng.lbl_tax_apply_to}:&nbsp;{$tax.formula}{if $tax.price_includes_tax eq 'Y'}{"\n"} *{$lng.lbl_price_includes_tax}{/if}{if $tax.display_including_tax eq 'Y'}{"\n"} *{$lng.lbl_display_including_tax}{/if}">
        {if $cart.product_tax_name eq ""}
          <span>{$tax.tax_display_name}</span>
        {/if}
          <span>
        {if $tax.rate_type eq "%"}
          {include file="main/display_tax_rate.tpl" value=$tax.rate_value}%
        {else}
          {currency value=$tax.rate_value}
        {/if}
          ({currency value=$tax.tax_value_precise title=$tax.tax_value_precise})
          </span>
        </div>
      {/if}
    {/foreach}
  </div>
{/if}
