{*
6f3a4d822a325647af97aa302b1748156d5f0de0, v4 (xcart_4_7_4), 2015-10-23 18:53:39, rpx_ss_cart_item.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $config.XAuth.xauth_enable_ss_cart eq 'Y'}
  {if $config.XAuth.xauth_ss_api_version eq '3'}
    <div class="clearing"></div>
    <div class="janrain-social-container">
      <div
        class="janrainSocialPlaceholder"
        data-janrain-url="{resource_url type="product" id=$product.productid}"
        data-janrain-title="{$product.product|escape|default:''}"
        data-janrain-description="{$product.descr|escape|default:''}"
        data-janrain-image="{$product.pimage_url|escape|default:''}"
        data-janrain-message=""></div>
    </div>
    <div class="clearing"></div>
  {else}
    <div class="xauth-rpx-ss-cart-item-button">
      {include file="customer/buttons/button.tpl" button_title=$lng.lbl_xauth_rpx_share href="javascript: return !xauthOpenCartItemShare(this);" additional_button_class="light-button"}
      <a href="javascript:void(0);" onclick="return !xauthOpenCartItemShare(this);" class="xauth-ss-link">
        {include file="modules/XAuth/rpx_cc_icons.tpl"}
        {$lng.lbl_xauth_rpx_share_and_more}
      </a>
    </div>
  {/if}
{/if}
