{*
626362abdced0086c1c116748026db88b0984243, v2 (xcart_4_7_4), 2015-10-01 14:20:13, buy_more.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}
{if $active_modules.Pitney_Bowes and $product.restriction_code ne ''}
  {* disable button *}
  {include file='modules/Pitney_Bowes/product_restricted.tpl'}
{else}
  {include file="customer/buttons/button.tpl" button_title=$lng.lbl_add_more additional_button_class=$additional_button_class|cat:' add-to-cart-button added-to-cart-button'}
{/if}
