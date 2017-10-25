{*
247b5228aa62b0106bf47ec18089fe2486031f02, v4 (xcart_4_7_4), 2015-07-23 22:09:36, xpc_popup.tpl, random

vim: set ts=2 sw=2 sts=2 et:
*}
<!-- MAIN -->
{if $message ne ''}
  {if $type ne $smarty.const.XPC_IFRAME_ALERT}
    {$lng.txt_xpc_checkout_error|substitute:'message':$message}
  {else}
    {$message}
  {/if}
{else}
  {$lng.txt_ajax_error_note}
{/if}
<!-- /MAIN -->
