{*
fee1a20fd634bde49eb5dd1f82707c7298951e69, v7 (xcart_4_7_6), 2016-06-10 16:29:31, card_list_customer.tpl, random

vim: set ts=2 sw=2 sts=2 et:
*}

<table cellspacing="3" cellpadding="2" border="0" width="90%" class="saved-cards">
  {if $saved_cards}
    <tr>
      <th>{$lng.lbl_order}</th>
      <th>{$lng.lbl_saved_card_header}</th>
      <th></th>
      <th></th>
    </tr>
    {foreach from=$saved_cards item=card key=card_id}
      <tr>
        <td>
          {if $card.orderid}
            <a href="order.php?orderid={$card.orderid}">#{$card.orderid}</a>
          {else}
            {$lng.txt_not_available}
          {/if}
        </td>
        <td{if $card_id eq $default_card_id} class="default-card"{/if}>
          {include file="modules/XPayments_Connector/card_info.tpl" type=$card.card_type number=$card.card_num expire=$card.card_expire}
        </td>
        <td>
          {if $card_id ne $default_card_id}
            <a href="saved_cards.php?mode=set_default&id={$card_id}">{$lng.lbl_saved_card_set_default_card}</a>
          {else}
            {$lng.lbl_saved_card_default}
          {/if}
        </td>
        <td>
          <a href="saved_cards.php?mode=delete&id={$card_id}">{$lng.lbl_remove}</a>
        </td>
      </tr>
    {/foreach}
  {/if}  
  <tr class="button-row">
    <td colspan="4">
      {if $xpc_allow_add_new_card}
        {include file="customer/buttons/button.tpl" button_title=$lng.lbl_saved_card_add_new additional_button_class="xpc-add-new-card-button" href="javascript: showXPCFrame(this);"}
      {/if}
    </td>
  </tr>
</table>

{if $xpc_allow_add_new_card}
  {include file="modules/XPayments_Connector/saved_cards_add_new.tpl"}
{/if}
