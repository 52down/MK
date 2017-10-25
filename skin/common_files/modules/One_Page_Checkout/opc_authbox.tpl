{*
b00f54887428e3836369a99d55eda321cfa5c047, v8 (xcart_4_7_7), 2016-09-28 19:20:49, opc_authbox.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<div class="opc-authbox" id="opc_authbox">
  {if $login ne ''}

    {$lng.txt_opc_greeting|substitute:"name":$fullname}&nbsp;
    <a href="register.php?mode=update" title="{$lng.lbl_view_profile|escape}">{$lng.lbl_view_profile}</a>&nbsp;
    <a href="login.php?mode=logout" title="{$lng.lbl_sign_out|escape}">{$lng.lbl_sign_out}</a>

  {else}
    
    {capture name='loginbn'}
      <a title="{$lng.lbl_sign_in|escape}" href="login.php" onclick="javascript: popupOpen('login.php'); return false;">{$lng.lbl_sign_in|lower|escape}</a>
    {/capture}

    {if ($userinfo eq '' or $userinfo.is_incomplete or $force_change_address) and $checkout_module ne 'Amazon_Payments_Advanced'}
      {$lng.txt_opc_sign_in_enter_name}
      <br />
    {/if}

    {if $active_modules.XAuth}
      {include file="modules/XAuth/checkout_link.tpl"}
    {else}
      {$lng.txt_opc_sign_in|substitute:"sign_in_link":$smarty.capture.loginbn}
    {/if}

  {/if}
</div>
