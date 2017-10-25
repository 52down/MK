{*
194626627da00f55901e393daa481ee1a5d33cfb, v4 (xcart_4_7_4), 2015-10-26 13:19:01, rpx_social_sharing.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $config.XAuth.xauth_ss_api_version eq '3'}
  {include file='modules/XAuth/rpx/social_sharing_v3.tpl'}
{else}
  {include file='modules/XAuth/rpx/social_sharing_v2.tpl'}
{/if}
