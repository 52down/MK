{*
09d46970de4b3605245381ed8ecd8b55fffd1d3e, v2 (xcart_4_7_5), 2016-02-12 18:28:36, onoff.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

{*
  Supported params:

    $name - select control name
    $checked - control state
    $off_name - "off" replacement text
    $on_name - "on" replacement text
*}

{include file="widgets/css_loader.tpl" css="widgets/onoff/onoff.css"}

<div class="input input-checkbox-onoff onoffswitch">
  <input type="hidden" name="{$name}" value="">
  <input id="data-{$name}" name="{$name}" type="checkbox" value="1" {if $checked}checked="checked"{/if}>
  <label for="data-{$name}">
    <span class="off-label">{$off_name|default:$lng.lbl_off}</span>
    <span class="fa fa-check"></span>
    <span class="on-label">{$on_name|default:$lng.lbl_on}</span>
  </label>
</div>
