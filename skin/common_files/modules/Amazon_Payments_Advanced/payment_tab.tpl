{*
0e4b8466ae4b59444fb272605fddbb0fda52d870, v5 (xcart_4_7_8), 2017-02-13 18:09:09, payment_tab.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $active_modules.Amazon_Payments_Advanced}
  {$lng.txt_amazon_pa_configuration_info|replace:'{{merchant_url}}':"$https_location/payment/amazon_pa_ipn_recv.php"|replace:'{{allowed_javascript_origins}}':("$https_location"|replace:"{$xcart_web_dir}":'/')|replace:'{{allowed_return_urls}}':"$https_location/amazon_checkout.php"}
  {include file="admin/main/configuration.tpl" configuration=$amazon_pa_configuration option="Amazon_Payments_Advanced"}
{else}
  <br />
  <center>
  <form action="amazon_pa_order.php" method="get">
  <input type="hidden" name="mode" value="amazon_pa_enable_module" />
  <div class="main-button">
    <input type="submit" class="big-main-button configure-style" value="{$lng.lbl_enable} {$lng.module_name_Amazon_Payments_Advanced}" />
  </div>
  <br />
  </form>
  </center>
{/if}
