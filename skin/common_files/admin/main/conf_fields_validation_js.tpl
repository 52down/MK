{*
ac8c94920113307390c6b99bee08baf69d0fbf39, v7 (xcart_4_7_5), 2016-02-18 10:02:02, conf_fields_validation_js.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<script type="text/javascript">
//<![CDATA[
var email_validation_regexp = /{$email_validation_regexp}/gi

var validationFields = [
{if $configuration}
{foreach from=$configuration item=conf_var}
{if $conf_var.validation}
{assign var="opt_comment" value="opt_`$conf_var.name`"}
  {ldelim}name: '{$conf_var.name}', validation: "{$conf_var.validation|escape:javascript}", comment: "{$lng.$opt_comment|default:$conf_var.comment|wm_remove|escape:javascript}"{rdelim},
{/if}
{/foreach}
{/if}
  {ldelim}{rdelim}
];

var invalid_parameter_text = '{$lng.err_invalid_field_data|wm_remove|escape:javascript}';
var email_extended_validation_regexp = new RegExp("{$email_extended_validation_regexp|wm_remove|escape:javascript}", "gi");

{getvar var=_styles func=func_get_configuration_styles}
{if $_styles}
  $(document).ready(function () {ldelim}
    if (typeof _configureFieldsXC == 'function') 
      _configureFieldsXC('{$_styles|wm_remove|escape:javascript}');
  {rdelim});
{/if}

//]]>
</script>
<script type="text/javascript" src="{$SkinDir}/js/conf_fields_validation.js"></script>
