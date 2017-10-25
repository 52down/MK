{*
d9b1d00165e59fde73afc10f3535f68de64e0a5a, v8 (xcart_4_7_6), 2016-06-13 15:23:24, saved_cards_admin.tpl, Vladimir

vim: set ts=2 sw=2 sts=2 et:
*}
{if $hide_header eq ""}
<tr>
<td colspan="3" class="RegSectionTitle">{$lng.lbl_saved_cards}<hr size="1" noshade="noshade" /></td>
</tr>
{/if}

<tr>
  <td colspan="3">

    {if $saved_cards}

      {include file="modules/XPayments_Connector/card_list_admin.tpl"}

    {else}

      {$lng.lbl_no_saved_cards}
      <br />

    {/if}

    {if $xpc_allow_add_new_card}
      <br />
      <a href="javascript: void(0);" class="xpc-add-new-card-button" onclick="javascript: showXPCFrame('.xpc-add-new-card-button, .FormButton input[type=submit]');">{$lng.lbl_saved_card_add_new}<img src="{$ImagesDir}/go.gif" class="GoImage" alt="" /></a>
    {/if}

  </td>
</tr>
