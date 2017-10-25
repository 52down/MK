{*
90f887473f85a3590756e3235f64ed48131fe383, v8 (xcart_4_7_6), 2016-05-18 10:43:45, history_order.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

<h1>{$lng.lbl_order_details_label}</h1>

<p class="text-block">{$lng.txt_order_details_top_text}</p>

{capture name=dialog}

  <div>
    {if $orderid_prev ne ""}
      <a href="order.php?orderid={$orderid_prev}">&lt;&lt;&nbsp;{$lng.lbl_order} #{$orderid_prev}</a>
    {/if}
    {if $orderid_next ne ""}
      {if $orderid_prev ne ""}
        |
      {/if}
      <a href="order.php?orderid={$orderid_next}">{$lng.lbl_order} #{$orderid_next}&nbsp;&gt;&gt;</a>
    {/if}
  </div>

  <div class="buttons-row">
    {if $active_modules.RMA ne ''} 

      {if $return_products ne ''}
        {include file="customer/buttons/button.tpl" button_title=$lng.lbl_create_return href="#returns" style="link"}
        <div class="button-separator"></div>
      {/if}

      {if $order.is_returns}
        {include file="customer/buttons/button.tpl" button_title=$lng.lbl_order_returns href="returns.php?mode=search&search[orderid]=`$order.orderid`" style="link"}
        <div class="button-separator"></div>
      {/if}

    {/if}

    {assign var=order_url value="order.php?orderid=`$order.orderid`"}
    {if $order.access_key}
      {assign var=order_url value="`$order_url`&amp;access_key=`$order.access_key`"}
    {/if}
    {if $order.status eq 'A' or $order.status eq 'P' or $order.status eq 'C'}
      {assign var=bn_title value=$lng.lbl_print_receipt}
    {else}
      {assign var=bn_title value=$lng.lbl_print_invoice}
    {/if}
    {include file="customer/buttons/button.tpl" button_title=$bn_title target="_blank" href="`$order_url`&mode=invoice" style="link"}
    
    {if $active_modules.Advanced_Order_Management and $order.history ne ""}
      <div class="button-separator"></div>
      {include file="customer/buttons/button.tpl" button_title=$lng.lbl_aom_show_history href="javascript:popupOpen('`$order_url`&amp;mode=history','`$lng.lbl_aom_show_history`')" style="link" link_href="`$order_url`&mode=history" target="_blank"}
    {/if}

    {if $active_modules.POS_System ne ""}
      {include file="modules/POS_System/receipt/customer_print_receipt_link.tpl"}
    {/if}

  </div>

  <hr />

  {include file="mail/html/order_invoice.tpl" is_nomail='Y'}

  {if $active_modules.Order_Tracking and $order.tracking}
    {include file="modules/Order_Tracking/customer_tracking.tpl"}
  {/if}

{/capture}
{include file="customer/dialog.tpl" title=$lng.lbl_order_details_label content=$smarty.capture.dialog noborder=true}

{if $active_modules.RMA}

  <a name="returns"></a>
  {include file="modules/RMA/customer/add_returns.tpl"}

{/if}
