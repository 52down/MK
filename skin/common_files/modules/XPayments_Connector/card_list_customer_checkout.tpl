{*
194626627da00f55901e393daa481ee1a5d33cfb, v6 (xcart_4_7_4), 2015-10-26 13:19:01, card_list_customer_checkout.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

{if $saved_cards}
  <ul class="saved-cards">
    <li class="default-item">
      <label>
        <input type="hidden" name="saved_card_id" value="{$default_card_id}" id="default_card"/>
        {include file="modules/XPayments_Connector/card_info.tpl" type=$saved_cards[$default_card_id].card_type number=$saved_cards[$default_card_id].card_num expire=$saved_cards[$default_card_id].card_expire}
      </label>  
    </li>
    {foreach from=$saved_cards item=card key=card_id}
      <li class="all-items" style="display: none">
        <label>
          <input type="radio" name="saved_card_id" value="{$card_id}"{if $card_id eq $default_card_id} checked="checked"{/if}/>
          {include file="modules/XPayments_Connector/card_info.tpl" type=$card.card_type number=$card.card_num expire=$card.card_expire}
        </label>
      </li>
    {/foreach}
  </ul>
  {if $saved_cards|@count gt 1}
    <a class="default-item xpc-show-all-cards" href="javascript: void(0);" onclick="javascript: switchSavedCards();">{$lng.lbl_xpc_choose_different_card}</a>
  {/if}
{/if}

<script type="text/javascript">
{literal}

    function switchSavedCards() {
        $('.default-item').hide();
        $('.all-items').show();
        $('#default_card').remove();
    }

{/literal}
</script>
