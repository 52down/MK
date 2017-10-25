{*
62f54568162e84c76e11ec5204f8f9a436644181, v2 (xcart_4_7_7), 2016-09-27 09:29:16, linked_accounts_admin.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $xauth_register_displayed}
  <tr>
    <td colspan="3" class="RegSectionTitle">{$lng.lbl_xauth_linked_accounts}<hr size="1" noshade="noshade" /></td>
  </tr>

{if $xauth_ids}
{foreach from=$xauth_ids key=k item=id}
  <tr class="xauth-linked-accounts">
    <td align="right">
      <div class="xauth-account-provider-name" align="right">{$id.provider}</div>
    </td>
    <td></td>
    <td align="left">
      <table cellpadding="0" cellspacing="0">
      <tr>
        <td>
        {if $usertype ne "A" and $usertype ne "P" and $id.identifier ne ""}
          <a href="{$id.identifier}" target="_blank">{$id.identifier}</a>
        {else}
          {$lng.lbl_xauth_you_have_connected_social_account|substitute:'service_name':$id.provider}
        {/if}
        </td>
        <td width="10" align="center" valign="middle">
          <a class="remove" href="xauth_register.php?mode=remove&amp;auth_id={$id.auth_id}"></a>
        </td>
       </tr>
      </table>
    </td>
  </tr>
{/foreach}
{else}
  <tr>
    <td colspan="3" align="center">
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
{/if}
