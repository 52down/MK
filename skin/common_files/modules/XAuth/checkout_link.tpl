{*
d867202178b9ca1004c14064b9856793118e7b00, v5 (xcart_4_7_4), 2015-10-13 17:08:41, checkout_link.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if ($xauth_checkout_link_show eq 'Y' and $is_from_xauth ne 'Y') or $xauth_not_configured eq 'Y'}
  {$lng.lbl_xauth_opc_sign_in|substitute:sign_in_link:$smarty.capture.loginbn}
{/if}
