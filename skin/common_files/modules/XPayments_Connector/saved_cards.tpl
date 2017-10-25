{*
fee1a20fd634bde49eb5dd1f82707c7298951e69, v5 (xcart_4_7_6), 2016-06-10 16:29:31, saved_cards.tpl, random

vim: set ts=2 sw=2 sts=2 et:
*}

<h1>{$lng.lbl_saved_cards}</h1>

{$lng.lbl_saved_cards_top_note}

<br /><br />

{if $saved_cards}

  {include file="modules/XPayments_Connector/card_list_customer.tpl"}

{else}

  {$lng.lbl_no_saved_cards}

  {if $xpc_allow_add_new_card}
    <br /><br />
    {include file="customer/buttons/button.tpl" button_title=$lng.lbl_saved_card_add_new additional_button_class="xpc-add-new-card-button" href="javascript: showXPCFrame(this);"}
    {include file="modules/XPayments_Connector/saved_cards_add_new.tpl"}
  {/if}

{/if}

<br /><br />
