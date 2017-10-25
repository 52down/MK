{*
aad85f2be3e7abf71f38a7de369cbd6188fe4f3b, v3 (xcart_4_7_0), 2015-02-11 09:38:53, auth.rpx.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{include file="modules/XAuth/janrain_init.tpl"}
{if $config.XAuth.xauth_rpx_display_mode eq 'v'}
  {include file="modules/XAuth/auth.rpx.vertical.tpl"}
{else}
  {include file="modules/XAuth/auth.rpx.horizontal.tpl"}
{/if}
