{*
386e797abc9207c002afb588e77aa44fc6818635, v5 (xcart_4_7_6), 2016-06-13 17:20:08, admin_deploy.tpl, random

vim: set ts=2 sw=2 sts=2 et:
*}
<div id="xpc-deploy-page">
  <form action="xpc_admin.php" method="POST">
  <input type="hidden" id="mode" name="mode" value="deploy_configuration" />

  <div>
    {$lng.txt_xpc_deploy_description}
    <br /><br />
    <div class="xpc-option-name">
      <textarea id="xpc-deploy-entry" name="configuration_bundle" cols="80" rows="5" /></textarea>
    </div>
    <div class="xpc-option-value">
      <input type="button" onclick="javascript: $(this.form).submit();" value="{$lng.lbl_xpc_deploy}" />
    </div>
  </div>

  </form>

  <br />
  <a href="javascript: void(0);" onclick="javascript: $('#xpc-bundle-note').toggle();">{$lng.lbl_xpc_no_bundle_help_button}</a>
  <div id="xpc-bundle-note" style="display: none;">
    {$lng.txt_xpc_no_bundle_help}
    <form action="configuration.php?option=XPayments_Connector" method="POST" name="xpc_config">
    <input type="hidden" name="mode" value="deploy_configuration" />
    <input type="hidden" name="xpc_previous_cart_id" value="{$config.XPayments_Connector.xpc_shopping_cart_id}" />
    {include file="modules/XPayments_Connector/admin_options_list.tpl" options_list=$xpc_configuration.advanced options_errors=$check_sys_errs}
    <div id="hidden-options" style="display: none;">
      {include file="modules/XPayments_Connector/admin_options_list.tpl" options_list=$xpc_configuration.common}
      {include file="modules/XPayments_Connector/admin_options_list.tpl" options_list=$xpc_configuration.mapping_rules}
      {include file="modules/XPayments_Connector/admin_options_list.tpl" options_list=$xpc_configuration.save_cc}
    </div>
    <br />
    <div class="main-button">
      <input type="submit" value="{$lng.lbl_xpc_deploy}" />
    </div>
    </form>
  </div>
</div>
