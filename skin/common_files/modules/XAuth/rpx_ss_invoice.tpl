{*
194626627da00f55901e393daa481ee1a5d33cfb, v5 (xcart_4_7_4), 2015-10-26 13:19:01, rpx_ss_invoice.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $config.XAuth.xauth_enable_ss_invoice eq 'Y'}
  {if $config.XAuth.xauth_ss_api_version eq '3'}
    <div class="clearing"></div>
    <div class="janrain-social-container">
      <div
        class="janrainSocialPlaceholder"
        data-janrain-url="{$http_location|escape}"
        data-janrain-title="{$config.Company.company_name|escape|default:''}"
        data-janrain-description=""
        data-janrain-image="{$http_location|replace:$xcart_web_dir:''|escape}{$AltImagesDir|escape}/custom/logo.png"
        data-janrain-message=""></div>
    </div>
    <div class="clearing"></div>
  {else}
    <div class="xauth-rpx-ss-invoice-button">
      {include file="customer/buttons/button.tpl" button_title=$lng.lbl_xauth_rpx_share href="javascript: return !xauthOpenInvoiceShare(this);"}
      <a href="javascript:void(0);" onclick="return !xauthOpenInvoiceShare(this);" class="xauth-ss-link">
        {include file="modules/XAuth/rpx_cc_icons.tpl"}
        {$lng.lbl_xauth_rpx_share_and_more_invoice}
      </a>
    </div>
  {/if}
{/if}
