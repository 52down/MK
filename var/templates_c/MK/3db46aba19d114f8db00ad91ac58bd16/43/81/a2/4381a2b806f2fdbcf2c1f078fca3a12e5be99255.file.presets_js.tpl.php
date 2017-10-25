<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:10:33
         compiled from "D:\website\MK\skin\common_files\presets_js.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2798159ec5279686a35-90156469%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4381a2b806f2fdbcf2c1f078fca3a12e5be99255' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\presets_js.tpl',
      1 => 1496750498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2798159ec5279686a35-90156469',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'number_format_dec' => 0,
    'number_format_th' => 0,
    'number_format_point' => 0,
    'store_language' => 0,
    'xcart_web_dir' => 0,
    'ImagesDir' => 0,
    'lng' => 0,
    'usertype' => 0,
    'SkinDir' => 0,
    'use_email_validation' => 0,
    'email_validation_regexp' => 0,
    'is_admin_editor' => 0,
    'current_area' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec52796a0cd6_82304935',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec52796a0cd6_82304935')) {function content_59ec52796a0cd6_82304935($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_wm_remove')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.wm_remove.php';
?>
<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[
var number_format_dec = '<?php echo $_smarty_tpl->tpl_vars['number_format_dec']->value;?>
';
var number_format_th = '<?php echo $_smarty_tpl->tpl_vars['number_format_th']->value;?>
';
var number_format_point = '<?php echo $_smarty_tpl->tpl_vars['number_format_point']->value;?>
';
var store_language = '<?php echo strtr($_smarty_tpl->tpl_vars['store_language']->value, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
';
var xcart_web_dir = "<?php echo strtr($_smarty_tpl->tpl_vars['xcart_web_dir']->value, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
";
var images_dir = "<?php echo strtr($_smarty_tpl->tpl_vars['ImagesDir']->value, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
";
var lbl_no_items_have_been_selected = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_no_items_have_been_selected']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
';
var current_area = '<?php echo $_smarty_tpl->tpl_vars['usertype']->value;?>
';
var skin_dir = '<?php echo strtr($_smarty_tpl->tpl_vars['SkinDir']->value, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
';
var lbl_required_field_is_empty = "<?php echo strtr(smarty_modifier_wm_remove(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['lng']->value['lbl_required_field_is_empty'])), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
";
var lbl_field_required = "<?php echo strtr(smarty_modifier_wm_remove(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['lng']->value['lbl_field_required'])), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
";
var lbl_field_format_is_invalid = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_field_format_is_invalid']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
";
var txt_required_fields_not_completed = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['txt_required_fields_not_completed']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
";
<?php if ($_smarty_tpl->tpl_vars['use_email_validation']->value!="N") {?>
var txt_email_invalid = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['txt_email_invalid']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
";
var email_validation_regexp = new RegExp("<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['email_validation_regexp']->value), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
", "gi");
<?php }?>
var lbl_error = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_error']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
';
var lbl_warning = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_warning']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
';
var lbl_ok = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_ok']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
';
var lbl_yes = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_yes']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
';
var lbl_no = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_no']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
';
var txt_ajax_error_note = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['txt_ajax_error_note']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
';
var is_admin_editor = <?php if ($_smarty_tpl->tpl_vars['is_admin_editor']->value) {?>true<?php } else { ?>false<?php }?>;
var lbl_blockui_default_message = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_blockui_default_message']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
";
var current_location = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['current_area']->value), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
';
//]]>
<?php echo '</script'; ?>
>
<?php }} ?>
