{*
312d23724fe4e2af2e3424b607e290aa8c914fb0, v5 (xcart_4_7_2), 2015-04-06 13:42:09, show_static_status_link.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

{if $config.XOrder_Statuses.xostat_use_colors eq 'Y'}
<div class="xostatus-search-status-indicator xostatus-orderstatus-background-{$status|escape}">&nbsp;</div>
{/if}

<div class="xostatus-status-link-container">
  <a href="order.php?orderid={$orderid}"><b>{include file="main/order_status.tpl" status=$status mode="static"}</b></a>
</div>

{order_status_desc status=$status var="current_status_desc"}

{if $current_status_desc ne ''}
<div class="xostatus-status-description-container">
  {include file="main/tooltip_js.tpl" title=$current_status_desc text=$current_status_desc id="staus_desc_`$orderid`" type="img"}
</div>
{/if}
