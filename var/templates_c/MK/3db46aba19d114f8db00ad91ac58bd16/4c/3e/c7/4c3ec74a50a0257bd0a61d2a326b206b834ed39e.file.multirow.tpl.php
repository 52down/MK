<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:52
         compiled from "D:\website\MK\skin\common_files\main\multirow.tpl" */ ?>
<?php /*%%SmartyHeaderCode:505659ef3204de6039-70641668%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4c3ec74a50a0257bd0a61d2a326b206b834ed39e' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\multirow.tpl',
      1 => 1496750442,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '505659ef3204de6039-70641668',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lng' => 0,
    'ImagesDir' => 0,
    'SkinDir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef3204e10568_77571572',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef3204e10568_77571572')) {function content_59ef3204e10568_77571572($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_wm_remove')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.wm_remove.php';
?>
<?php echo '<script'; ?>
 type="text/javascript" language="JavaScript 1.2">
//<![CDATA[
var lbl_remove_row = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_remove_row']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
';
var lbl_add_row = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_add_row']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
';
var inputset_plus_img = "<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/plus.gif";
var inputset_minus_img = "<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/minus.gif";
//]]>
<?php echo '</script'; ?>
>
<img src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/plus.gif" width="0" height="0" alt="" style="display: none" />
<img src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/minus.gif" width="0" height="0" alt="" style="display: none" />
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/js/multirow.js"><?php echo '</script'; ?>
>
<?php }} ?>
