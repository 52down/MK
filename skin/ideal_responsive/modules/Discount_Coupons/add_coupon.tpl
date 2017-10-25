{*
cbd5b33537a292f5a3d487cfe98638e2e7f94a89, v5 (xcart_4_7_5), 2016-02-08 20:36:40, add_coupon.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

{capture name=dialog}

  <a name='check_coupon'></a>
  <div class="add-coupon">
    <form action="cart.php" name="couponform">
      <input type="hidden" name="mode" value="add_coupon" />  
      <div class="data-name">
        {$lng.lbl_have_coupon_code}
        <input type="text" class="text default-value" size="32" name="coupon" placeholder="{$lng.lbl_coupon_code|escape}" />
      </div>
      {include file="customer/buttons/submit.tpl" type="input"}
    </form>
  </div>
{/capture}
{if $page eq 'place_order'}
  {include file="customer/dialog.tpl" title=$lng.lbl_redeem_discount_coupon content=$smarty.capture.dialog additional_class="cart" noborder=true}
{else}
  {include file="customer/dialog.tpl" title=$lng.lbl_redeem_discount_coupon content=$smarty.capture.dialog additional_class="simple-dialog" noborder=true}
{/if}
