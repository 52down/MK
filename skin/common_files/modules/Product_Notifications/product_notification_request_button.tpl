{*
e5f2424dd32f2fa845553f42e8a381f63df1b321, v3 (xcart_4_7_6), 2016-03-29 17:59:19, product_notification_request_button.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}
{assign var='tip_lbl_name' value="lbl_prod_notif_button_tip_`$type`"}
{if $view eq "D"}
  <div id="prod_notif_request_button_{$productid}_{$type}">
    <a class="prod-notif-request-button prod-notif-request-button-{$type}" href="javascript:void(0);">
      <img src="{$ImagesDir}/spacer.gif" alt="" />
      <span>{$lng.lbl_prod_notif_click_here}</span>
    </a>
    {$lng.$tip_lbl_name}
  </div>
{else}
  <a id="prod_notif_request_button_{$productid}_{$type}" class="prod-notif-request-button prod-notif-request-button-{$type}" href="javascript:void(0);" title="{$lng.lbl_prod_notif_click_here} {$lng.$tip_lbl_name}"><img src="{$ImagesDir}/spacer.gif" alt="" /></a>
{/if}
