{*
cd60b31ddbbf50dfac79b1cfa245322fc36709bd, v5 (xcart_4_6_5), 2014-10-17 17:37:42, register_link.tpl, aim
vim: set ts=2 sw=2 sts=2 et:
*}
{if $xauth_register_link_displayed eq 'Y' and $is_from_xauth ne 'Y'}
  {capture name='loginbn'}
    <a title="{$lng.lbl_sign_in|escape}" href="login.php" onclick="javascript: popupOpen('login.php'); return false;">{$lng.lbl_sign_in|lower|escape}</a>
  {/capture}
  {$lng.lbl_xauth_register_link|substitute:sign_in_link:$smarty.capture.loginbn}<br /><br />
{/if}
