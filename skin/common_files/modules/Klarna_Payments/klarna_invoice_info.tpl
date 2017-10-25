{*
c820d94557635045a13cec05be4b2d51d1759935, v2 (xcart_4_7_7), 2016-09-09 09:54:10, klarna_invoice_info.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $order.extra.reservation_id neq '' and $order.extra.klarna_invoice_id eq ''}
  ( {$lng.lbl_klarna_reservation_id}:{$order.extra.reservation_id} )
{elseif $order.extra.klarna_invoice_id neq ''}
  ( {$lng.lbl_klarna_invoice_id}:{$order.extra.klarna_invoice_id} )
{/if}
