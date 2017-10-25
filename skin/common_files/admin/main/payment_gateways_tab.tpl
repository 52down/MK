{*
c65bc8efeadfa825151734996204e9e77a8a2e5a, v2 (xcart_4_7_5), 2016-02-08 17:43:58, payment_gateways_tab.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{include file="admin/main/cc_processing.tpl"}
<div id="payment-banner">
  {math equation='rand(1, 1000000)' assign=random_number}
  <iframe id='payment-banner-iframe' name='payment-banner-iframe' src='//ads.qtmsoft.com/www/delivery/afr.php?zoneid=8&amp;cb={$random_number}' frameborder='0' scrolling='no' width='830' height='400'><a href='//ads.qtmsoft.com/www/delivery/ck.php?n=a6fa0971&amp;cb={$random_number}' target='_blank'><img src='//ads.qtmsoft.com/www/delivery/avw.php?zoneid=8&amp;cb={$random_number}&amp;n=a6fa0971' border='0' alt='' /></a></iframe>
</div>
