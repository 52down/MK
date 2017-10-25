{*
87417a2ea022a27a2af2a0bb910bf1ec767fec41, v5 (xcart_4_7_3), 2015-06-19 13:47:03, cart_offers.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $products and $cart.have_offers and $cart.applied_offers}

  {capture name=dialog}

  {foreach name=offers from=$cart.applied_offers item=offer}
  {assign var=offer_promo_checkout value=$offer.promo_checkout|default:$offer.offer_name}

  {if $offer_promo_checkout ne ""}
    <div>
    {if $offer.html_checkout}
      {$offer_promo_checkout}
    {else}
      <tt>{$offer_promo_checkout|escape}</tt>
    {/if}
    </div>

     {if not $smarty.foreach.offers.last}
      <div><img src="{$ImagesDir}/spacer.gif" width="1" height="30" alt="" /></div>
     {/if}
  {/if}

  {/foreach}

  {/capture}
  {include file="customer/dialog.tpl" title=$lng.lbl_sp_offers_applied_to_cart content=$smarty.capture.dialog additional_class="cart-offers"}

{/if}
