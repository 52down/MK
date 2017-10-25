{*
442247067db63ddbfaaef7de30c2fd9530d4b850, v2 (xcart_4_7_8), 2017-06-06 16:31:36, shippingeasy_status.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $mode eq "select"}

  <select name="{$name}">
    <option value="awaiting_shipment"{if $status eq "awaiting_shipment"} selected="selected"{/if}>{$lng.lbl_shippingeasy_awaiting_shipment}</option>
    <option value="awaiting_payment"{if $status eq "awaiting_payment"} selected="selected"{/if}>{$lng.lbl_shippingeasy_awaiting_payment}</option>
    <option value="awaiting_fulfillment"{if $status eq "awaiting_fulfillment"} selected="selected"{/if}>{$lng.lbl_shippingeasy_awaiting_fulfillment}</option>
    <option value="partially_shipped"{if $status eq "partially_shipped"} selected="selected"{/if}>{$lng.lbl_shippingeasy_partially_shipped}</option>
  </select>

{elseif $mode eq "static"}

  {if $status eq "awaiting_shipment"}
    {$lng.lbl_shippingeasy_awaiting_shipment}

  {elseif $status eq "awaiting_payment"}
    {$lng.lbl_shippingeasy_awaiting_payment}

  {elseif $status eq "awaiting_fulfillment"}
    {$lng.lbl_shippingeasy_awaiting_fulfillment}

  {elseif $status eq "partially_shipped"}
    {$lng.lbl_shippingeasy_partially_shipped}

  {/if}

{/if}
