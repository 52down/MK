{*
3dc3e5ff96c9dff4ae8262a37fb56173b5cfc2b7, v3 (xcart_4_7_7), 2017-01-11 16:26:04, jquery_ui_tabs.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}

{if $development_mode_enabled}
  {load_defer file="lib/jqueryui/components/tabs.js" type="js"}
  {* For now CSS is loaded statically in jquery_ui.tpl *}
  {* include file="widgets/css_loader.tpl" css="lib/jqueryui/components/tabs.css" *}
{else}
  {load_defer file="lib/jqueryui/components/tabs.min.js" type="js"}
  {* For now CSS is loaded statically in jquery_ui.tpl *}
  {* include file="widgets/css_loader.tpl" css="lib/jqueryui/components/tabs.min.css" *}
{/if}

{if $usertype eq 'C'}
  {load_defer file="js/jquery_ui_fix.js" type="js"}
  {* FIX: Tabs are broken in customer area if Clean URLs are enabled *}
  {*      Load fix only for customer area as it affects tabs('option','active') return value *}
{/if}
