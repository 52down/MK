{*
194626627da00f55901e393daa481ee1a5d33cfb, v2 (xcart_4_7_4), 2015-10-26 13:19:01, history_order.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $order.extra.xpc_txnid and $config.XPayments_Connector.xpc_xpayments_url}
  <br />
  {strip}
<table cellpadding="2" cellspacing="2">
  <tr>
  <td>
    <a href="process_order.php?orderid={$order.orderid}&amp;mode=xpayments&amp;submode=get_info" target="_blank" onclick="javascript: window.open(this.href, 'paymentInfo', 'width=750, height=400, resizable=yes, toolbar=no, status=no, menubar=no, location=no'); return false;">{$lng.txt_xpc_view_payment_info}</a>
  </td>
  <td>
    <a class="external-link xpc-xpayments-link" href="{$config.XPayments_Connector.xpc_xpayments_url}/admin.php?target=payment&amp;txnid={$order.extra.xpc_txnid|escape}">{$lng.lbl_xpc_go_to_payment_page}</a>
  </td>
  </tr>
</table>
  {/strip}
  <br />
{/if}
