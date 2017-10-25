{*
194626627da00f55901e393daa481ee1a5d33cfb, v4 (xcart_4_7_4), 2015-10-26 13:19:01, card_list_admin_recharge.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

{if $saved_cards}
  <ul class="saved-cards">
    {foreach from=$saved_cards item=card key=card_id}
      <li>
        <label>
          <input type="radio" name="saved_card_id" value="{$card_id}"{if $card.is_default} checked="checked"{/if}/>
          {include file="modules/XPayments_Connector/card_info.tpl" type=$card.card_type number=$card.card_num expire=$card.card_expire}
        </label>
      </li>
    {/foreach}
  </ul>
{/if}
