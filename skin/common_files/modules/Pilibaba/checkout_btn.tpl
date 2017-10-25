{*
a4d96b80d8d88263cd3b9113f19b2558458ae026, v3 (xcart_4_7_7), 2016-08-15 15:22:59, checkout_btn.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{* '{include file="modules/Pilibaba/checkout_btn.tpl" btn_place...' is added from x_tpl_add_callback_patch('customer/main/cart.tpl', 'func_pilibaba_tpl_insertButton', X_TPL_PREFILTER) by prefilter*}
{if $pilibaba_enabled}
  <div class="">
    <div>
      {if not $std_checkout_disabled or $paypal_express_active or $amazon_pa_enabled}
        {if $top_button ne 'Y'}
          <p>{$lng.lbl_or_use}</p>
        {/if}
      {/if}
        <a href="cart.php?mode=pilibaba_checkout"><img alt="Pilibaba Chinese Checkout" src="{$SkinDir}/modules/Pilibaba/images/checkout-btn.png" width='163px' height='50px' /></a>
    </div>
  </div>
{/if}
