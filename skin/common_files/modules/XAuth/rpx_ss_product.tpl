{*
6f3a4d822a325647af97aa302b1748156d5f0de0, v4 (xcart_4_7_4), 2015-10-23 18:53:39, rpx_ss_product.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $config.XAuth.xauth_enable_social_sharing eq 'Y'}
  {if $is_table}
  <tr>
    <td colspan="3">
  {else}
  <li>
  {/if}

  {if $config.XAuth.xauth_ss_api_version eq '3'}
    <div class="clearing"></div>
    <div class="janrain-social-container">
      <div
        class="janrainSocialPlaceholder"
        data-janrain-url="{resource_url type="product" id=$product.productid canonical_url=$canonical_url is_product_page=true}"
        data-janrain-title="{$product.product|escape|default:''}"
        data-janrain-description="{$product.descr|escape|default:''}"
        data-janrain-image="{$product.image_url|escape|default:''}"
        data-janrain-message=""></div>
    </div>
    <div class="clearing"></div>
  {else}
    <div class="button-row xauth-ss-button">
      {include file="customer/buttons/button.tpl" button_title=$lng.lbl_xauth_rpx_share href="javascript: return !xauthOpenProductShare(this);"}
      <a href="javascript:void(0);" onclick="return !xauthOpenProductShare('{$pname}', '{$pdescr}');" class="xauth-ss-link">
        {include file="modules/XAuth/rpx_cc_icons.tpl"}
        {$lng.lbl_xauth_rpx_share_and_more}
      </a>
    </div>
  {/if}

  {if $is_table}
    </td>
  </tr>
  {else}
  </li>
  {/if}
{/if}
