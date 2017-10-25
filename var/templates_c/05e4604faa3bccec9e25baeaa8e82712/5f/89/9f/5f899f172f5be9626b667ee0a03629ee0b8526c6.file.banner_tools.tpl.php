<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 09:48:39
         compiled from "D:\website\MK\skin\common_files\banner_tools.tpl" */ ?>
<?php /*%%SmartyHeaderCode:623459ec4d575e9ad4-10533191%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5f899f172f5be9626b667ee0a03629ee0b8526c6' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\banner_tools.tpl',
      1 => 1496750410,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '623459ec4d575e9ad4-10533191',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'banner_tools_data' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec4d575edfb0_59442952',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec4d575edfb0_59442952')) {function content_59ec4d575edfb0_59442952($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['banner_tools_data']->value) {?>
<div class="banner-tools">
  <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['banner_tools_data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
  <div class="banner-tools-box">
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['item']->value['template']), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

  </div>
  <?php } ?>
</div>
<?php }?>
<?php }} ?>
