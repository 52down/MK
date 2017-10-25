{*
6499ffa01e35bb7c9329bc31cf4420d71e05d1f6, v21 (xcart_4_7_7), 2016-09-02 09:31:05, jquery_ui.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

{if $development_mode_enabled}
  {load_defer file="js/jquery_ui_disable_compat.js" type="js"}
{/if}

{if $development_mode_enabled and $usertype eq 'C'}
  {load_defer file="lib/jqueryui/jquery-ui.custom.js" type="js"}
  {load_defer file="lib/jqueryui/jquery-ui.structure.css" type="css"}
{else}
  {load_defer file="lib/jqueryui/jquery-ui.custom.min.js" type="js"}
  {load_defer file="lib/jqueryui/jquery-ui.structure.min.css" type="css"}
{/if}

{* Pre-load default Jquery UI tabs CSS,
   since tabs are currently customized in themes CSS *}
{if $development_mode_enabled}
  {load_defer file="lib/jqueryui/components/tabs.css" type="css"}
{else}
  {load_defer file="lib/jqueryui/components/tabs.min.css" type="css"}
{/if}

{if $usertype eq 'C'}
  {if $development_mode_enabled}
    {load_defer file="lib/jqueryui/jquery-ui.theme.css" type="css"}
  {else}
    {load_defer file="lib/jqueryui/jquery-ui.theme.min.css" type="css"}
  {/if}
{else}
  {load_defer file="js/jquery_ui_override.js" type="js"}
  {if $development_mode_enabled}
    {load_defer file="lib/jqueryui/jquery-ui.admin.css" type="css"}
  {else}
    {load_defer file="lib/jqueryui/jquery-ui.admin.min.css" type="css"}
  {/if}
{/if}
{load_defer file="css/jquery_ui.css" type="css"}
{if $config.UA.browser eq "MSIE" and $config.UA.version eq 8}
{load_defer file="css/jquery_ui.IE8.css" type="css"}
{/if}
