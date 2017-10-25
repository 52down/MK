{*
194626627da00f55901e393daa481ee1a5d33cfb, v4 (xcart_4_7_4), 2015-10-26 13:19:01, card_list_admin.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

{if $saved_cards}
    <table cellspacing="3" cellpadding="2" border="0" width="70%" class="saved-cards">
      <tr>
        <th>{$lng.lbl_order}</th>
        <th>{$lng.lbl_saved_card_header}</th>
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
          <td>
            {include file="modules/XPayments_Connector/card_info.tpl" type=$card.card_type number=$card.card_num expire=$card.card_expire}
          </td>
          <td>
            <a href="user_modify.php?action=delete_saved_card&id={$card_id}&user={$smarty.get.user}&usertype=C">{$lng.lbl_remove}</a>
          </td>
        </tr>
      {/foreach}
    </table>
{/if}
