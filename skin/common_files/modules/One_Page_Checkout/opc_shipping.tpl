{*
41562c5cfeb62cd856c8982b2d194c8a49e4f4c3, v5 (xcart_4_7_7), 2016-12-26 19:10:26, opc_shipping.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<div id="opc_shipping">
  {*START ALT checkout SECTION, anchor for dynamic tpl insert*}
  {if not $active_modules.Bongo_International or not $cart.bongo_landedCost}
  <h2>{$lng.lbl_shipping_method}</h2>
  <script type="text/javascript">
  //<![CDATA[
  // Used to update global $need_shipping var to work isCheckoutReady():ajax.checkout.js function properly
  var need_shipping = {if $need_shipping}true{else}false{/if};

  // Used to update global shippingsCOD defined in skin/common_files/customer/main/checkout_payment_methods.tpl on shipping load 
  var shippingsCOD = [{strip}
  {if $shipping}
    {foreach from=$shipping item=s}
    {if $s.is_cod eq 'Y'}
      '{$s.shippingid}',
    {/if}
    {/foreach}
  {/if}
  {/strip}];

  //]]>
  </script>

  <form action="cart.php" method="post" name="shippingsform">

    <input type="hidden" name="mode" value="checkout" />
    <input type="hidden" name="cart_operation" value="cart_operation" />
    <input type="hidden" name="action" value="update" />

    <div class="opc-section-container opc-shipping-options">
      {include file="customer/main/checkout_shipping_methods.tpl"}
      <div class="clearing"></div>
    </div>

    {if $display_ups_trademarks and $current_carrier eq "UPS"}
      {include file="modules/UPS_OnLine_Tools/ups_notice.tpl"}
    {/if}

  </form>
  {/if}{*if not $active_modules.Bongo_International or not $cart.bongo_landedCost*}
  {*END ALT checkout SECTION, anchor for dynamic tpl insert*}
</div>
