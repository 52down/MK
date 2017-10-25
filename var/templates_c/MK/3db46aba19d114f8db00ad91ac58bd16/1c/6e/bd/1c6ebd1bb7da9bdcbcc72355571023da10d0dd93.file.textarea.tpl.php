<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:54
         compiled from "D:\website\MK\skin\common_files\modules\HTML_Editor\editors\ckeditor\textarea.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1546959ef32068a7ea6-75682653%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c6ebd1bb7da9bdcbcc72355571023da10d0dd93' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\modules\\HTML_Editor\\editors\\ckeditor\\textarea.tpl',
      1 => 1496750460,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1546959ef32068a7ea6-75682653',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'id' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef32068c4318_00045395',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef32068c4318_00045395')) {function content_59ef32068c4318_00045395($_smarty_tpl) {?>
<?php echo '<script'; ?>
 type="text/javascript">
<!--
if (popup_html_editor_text!=undefined) {
  $("#<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
").val(popup_html_editor_text);
  CKEDITOR.replace("<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
");
}
-->
<?php echo '</script'; ?>
>
<?php }} ?>
