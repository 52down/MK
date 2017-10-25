{*
67814c9aec19d6cf932988e3b949b16094b3dab9, v57 (xcart_4_7_4), 2015-10-28 10:53:25, shipping_options.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{include file="page_title.tpl" title=$lng.lbl_shipping_options}

<br />

{$lng.txt_shipping_options_top_text}

<br /><br />

{include file="check_email_script.tpl"}
{include file="check_zipcode_js.tpl"}

{$lng.lbl_select_service}:
{section name=carrier loop=$carriers}
{if $carriers[carrier].0 eq $carrier}
<b>{$carriers[carrier].1}</b>
{else}
<a href="shipping_options.php?carrier={$carriers[carrier].0}">{$carriers[carrier].1}</a>
{/if}
{if not $smarty.section.carrier.last}&nbsp;::&nbsp;{/if}
{/section}

<br /><br />

{include file="admin/main/shipping/mod_1800C.tpl"}

{include file="admin/main/shipping/mod_AP.tpl"}

{include file="admin/main/shipping/mod_CPC.tpl"}

{include file="admin/main/shipping/mod_DHL.tpl"}

{include file="admin/main/shipping/mod_FEDEX.tpl"}

{include file="admin/main/shipping/mod_Intershipper.tpl"}

{include file="admin/main/shipping/mod_USPS.tpl"}

{if $active_modules.Pitney_Bowes ne ''}
  {include file="modules/Pitney_Bowes/admin/mod_PB.tpl"}
{/if}
