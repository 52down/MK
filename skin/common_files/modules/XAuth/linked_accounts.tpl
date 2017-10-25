{*
71c4ecf2888b9b445e73a70a75e35cd9d4df18db, v2 (xcart_4_6_4), 2014-04-16 14:29:37, linked_accounts.tpl, aim
vim: set ts=2 sw=2 sts=2 et:
*}
<h1>{$lng.lbl_xauth_your_identifiers}</h1>

<table cellspacing="1" class="data-table register-table" summary="{$lng.lbl_xauth_linked_accounts|escape}">
<tbody>
{if $xauth_user_social_profiles}
{foreach from=$xauth_user_social_profiles key=k item=id}
  <tr class="xauth-linked-accounts">
    <td align="left" width="20%">
      <div class="xauth-account-provider-name">{$id.provider}</div>
    </td>
    <td align="left">
      {if $id.identifier ne ""}
        <a href="{$id.identifier}" target="_blank">{$id.identifier}</a>
      {else}
        {$lng.lbl_xauth_you_have_connected_social_account|substitute:'service_name':$id.provider}
      {/if}
    </td>
    <td width="10" align="center" valign="middle">
      <a class="remove" href="xauth_register.php?mode=remove&amp;auth_id={$id.auth_id}"></a>
    </td>
  </tr>
{/foreach}
{else}
  <tr>
    <td colspan="3">
      {$lng.txt_xauth_no_linked_accounts}
    </td>
  </tr>
{/if}
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center">
{include file="customer/buttons/button.tpl" type="input" additional_button_class="main-button" button_title=$lng.lbl_xauth_add_identifier href="javascript: return xauthTogglePopup(this);"}
    </td>
  </tr>
</tbody>
</table>
