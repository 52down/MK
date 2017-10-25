{*
aad85f2be3e7abf71f38a7de369cbd6188fe4f3b, v4 (xcart_4_7_0), 2015-02-11 09:38:53, register.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $xauth_saved_data}
  <tr style="display: none">
    <td>
      <input type="hidden" name="xauth_identifier[service]" value="{$xauth_saved_data.service}" />
      <input type="hidden" name="xauth_identifier[provider]" value="{$xauth_saved_data.provider}" />
      <input type="hidden" name="xauth_identifier[identifier]" value="{$xauth_saved_data.identifier}" />
    </td>
  </tr>
{/if}
