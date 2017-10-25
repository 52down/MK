{*
e45e0e6de7ab90126e5e377e881e0567b211cf08, v1 (xcart_4_7_5), 2016-02-18 00:49:24, mod_CPC_wizard.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}

{if $config.CPC_wizard_enabled eq 'Y'}

  <p>{$lng.txt_cpc_shipping_rates_note}</p>
  <p>{$lng.txt_cpc_location_limit_note}</p>

  <h2>{$lng.lbl_cpc_registration_wizard}</h2>

  <p>{$lng.txt_cpc_registration_note}</p>

  {getvar var='CPC_wizard_config' func='func_CPC_get_wizard_config'}

  <button type="button" id="CPC_register_button" data-wizard="{$CPC_wizard_config|escape}">{$lng.lbl_register}</button>

  {load_defer file="admin/main/shipping/mod_CPC_wizard.js" type="js"}

{else}

  <p>{$lng.txt_cpc_wizard_reset_note} <a href="{$catalogs.admin}/configuration.php?option=Shipping&amp;action=CPC_enable_wizard" onclick="javascript: return confirm('{$lng.txt_are_you_sure_to_proceed}');">{$lng.lbl_cpc_enable_wizard}</a>.</p>

{/if}
