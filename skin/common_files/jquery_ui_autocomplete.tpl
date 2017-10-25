{*
f796cd4ac105eb160691c59c49e70773bd16b2d8, v1 (xcart_4_7_7), 2016-09-01 16:39:33, jquery_ui_autocomplete.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}

{*Dependencies core.js, widget.js, position.js are loaded from main minified file jqueryui/jquery-ui.custom.min.js*}
{if $development_mode_enabled}
    {load_defer file="lib/jqueryui/components/menu.js" type="js"}
    {include file="widgets/css_loader.tpl" css="lib/jqueryui/components/menu.css"}
    {load_defer file="lib/jqueryui/components/autocomplete.js" type="js"}
    {include file="widgets/css_loader.tpl" css="lib/jqueryui/components/autocomplete.css"}
{else}
    {load_defer file="lib/jqueryui/components/menu.min.js" type="js"}
    {include file="widgets/css_loader.tpl" css="lib/jqueryui/components/menu.min.css"}
    {load_defer file="lib/jqueryui/components/autocomplete.min.js" type="js"}
    {include file="widgets/css_loader.tpl" css="lib/jqueryui/components/autocomplete.min.css"}
{/if}
