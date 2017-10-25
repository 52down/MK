{*
194626627da00f55901e393daa481ee1a5d33cfb, v2 (xcart_4_7_4), 2015-10-26 13:19:01, order_invoice.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $order.extra.xpc_saved_card_num and $order.extra.xpc_saved_card_type}
  {$order.extra.xpc_saved_card_type} {$order.extra.xpc_saved_card_num} {$order.extra.xpc_saved_card_expire}<br />
{/if}
