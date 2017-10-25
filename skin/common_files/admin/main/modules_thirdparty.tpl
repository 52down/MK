{*
efa6fc2f8b96d3b5782783e7b1dc8b653ddca823, v7 (xcart_4_7_8), 2017-05-18 17:43:39, modules_thirdparty.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<div id="modules-thirdparty-note">{$lng.txt_modules_thirdparty_note|substitute:"shop_type":$shop_type}</div>
<ul class="modules-list extensions">
{foreach from=$thirdparty_banners item=banner}
{assign var=cb value=1|mt_rand:99999999999}
<li>
  <iframe id="{$banner.n}" name="{$banner.n}" src="//ads.qtmsoft.com/www/delivery/afr.php?zoneid={$banner.zoneid}&amp;cb={$cb}" frameborder="0" scrolling="no"><a href="//ads.qtmsoft.com/www/delivery/ck.php?n={$banner.n}&amp;cb={$cb}" target="_blank"><img src="//ads.qtmsoft.com/www/delivery/avw.php?zoneid={$banner.zoneid}&amp;cb={$cb}&amp;n={$banner.n}" border="0" alt="" /></a></iframe>
</li>
{/foreach}
</ul>
<div id="more-thirdparty-modules">
{include file="buttons/button.tpl" button_title=$lng.lbl_more_thirdparty_modules href="//market.x-cart.com/go/xc4`$shop_type`/?utm_source=xcart&amp;utm_medium=thirdparty_modules_link_bottom&amp;utm_campaign=xcart_modules" substyle="thirdparty-modules"}
</div>
