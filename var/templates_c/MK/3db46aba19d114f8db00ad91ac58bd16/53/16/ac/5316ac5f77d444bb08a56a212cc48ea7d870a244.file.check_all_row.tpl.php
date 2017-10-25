<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:48
         compiled from "D:\website\MK\skin\common_files\main\check_all_row.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2918559ef320090b531-43212164%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5316ac5f77d444bb08a56a212cc48ea7d870a244' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\check_all_row.tpl',
      1 => 1496750440,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2918559ef320090b531-43212164',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'SkinDir' => 0,
    'style' => 0,
    'form' => 0,
    'prefix' => 0,
    'lng' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef320091f504_53922950',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef320091f504_53922950')) {function content_59ef320091f504_53922950($_smarty_tpl) {?>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/js/change_all_checkboxes.js"><?php echo '</script'; ?>
>
<div<?php if ($_smarty_tpl->tpl_vars['style']->value!='') {?> style="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
"<?php }?>><a href="javascript:checkAll(true,document.<?php echo $_smarty_tpl->tpl_vars['form']->value;?>
,'<?php echo $_smarty_tpl->tpl_vars['prefix']->value;?>
');"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_check_all'];?>
</a> / <a href="javascript:checkAll(false,document.<?php echo $_smarty_tpl->tpl_vars['form']->value;?>
,'<?php echo $_smarty_tpl->tpl_vars['prefix']->value;?>
');"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_uncheck_all'];?>
</a></div>
<?php }} ?>
