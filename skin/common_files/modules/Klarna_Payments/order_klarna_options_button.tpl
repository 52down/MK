{*
47e31aa4ee9dbd5e130c482df21526e9282fa40e, v2 (xcart_4_7_7), 2016-09-09 10:37:42, order_klarna_options_button.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $is_klarna_payment == 'Y'}
  {if $order.status eq 'A' and $order.klarna_order_status eq 'P'}
	  <td class="ButtonsRow">{include file="buttons/button.tpl" button_title=$lng.lbl_klarna_check_status href="javascript: self.location = 'process_order.php?orderid=`$order.orderid`&amp;mode=klarna_check_order_status';" substyle="return"}</td>
  {/if}
{/if}
