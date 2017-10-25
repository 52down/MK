{*
e96ba40e07a249d0afb40e7f661b6d0a32a57a88, v3 (xcart_4_7_7), 2017-01-24 12:33:10, cart_checkout_buttons.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $cart.not_used_free_products}

  <div class="offers-cart-button">
    {include file="customer/buttons/button.tpl" button_title=$lng.lbl_sp_add_free_products href="offers.php?mode=add_free" style="button"}
  </div>

{elseif $customer_unused_offers}

  <div class="offers-cart-button">
    {include file="customer/buttons/button.tpl" button_title=$lng.lbl_sp_unused_offers href="offers.php?mode=unused" style="link"}
  </div>

{/if}
