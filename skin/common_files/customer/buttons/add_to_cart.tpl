{*
194626627da00f55901e393daa481ee1a5d33cfb, v4 (xcart_4_7_4), 2015-10-26 13:19:01, add_to_cart.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{* Uncomment this line if you don't want buy more button behavior: 
{include file="customer/buttons/button.tpl" button_title=$lng.lbl_add_to_cart additional_button_class=$additional_button_class|cat:' add-to-cart-button'}
*}
{if $active_modules.Pitney_Bowes and $product.restriction_code ne ''}
  {* disable button *}
  {include file='modules/Pitney_Bowes/product_restricted.tpl'}
{else}
  {* Comment the following 5 lines if you don't want buy more button behavior: *}
  {if $product.appearance.added_to_cart}
    {include file="customer/buttons/button.tpl" button_title=$lng.lbl_add_more additional_button_class=$additional_button_class|cat:' add-to-cart-button added-to-cart-button'}
  {else}
    {include file="customer/buttons/button.tpl" button_title=$lng.lbl_add_to_cart additional_button_class=$additional_button_class|cat:' add-to-cart-button'}
  {/if}
{/if}
