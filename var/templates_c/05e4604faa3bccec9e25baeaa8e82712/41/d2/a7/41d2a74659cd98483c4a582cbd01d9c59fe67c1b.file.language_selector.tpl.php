<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 09:48:39
         compiled from "D:\website\MK\skin\common_files\main\language_selector.tpl" */ ?>
<?php /*%%SmartyHeaderCode:212159ec4d572eca31-05313233%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '41d2a74659cd98483c4a582cbd01d9c59fe67c1b' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\language_selector.tpl',
      1 => 1496750442,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '212159ec4d572eca31-05313233',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'all_languages_cnt' => 0,
    'lng' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec4d572ef4f4_12319996',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec4d572ef4f4_12319996')) {function content_59ec4d572ef4f4_12319996($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['all_languages_cnt']->value>1) {?>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
<tr>
    <td colspan="3" align="right">
    <table cellspacing="1" cellpadding="2" border="0">
    <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_language'];?>
:</td>
        <td><?php echo $_smarty_tpl->getSubTemplate ("main/language_selector_short.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
</td>
    </tr>
    </table>
    </td>
</tr>
</table>
<?php }?>
<?php }} ?>
