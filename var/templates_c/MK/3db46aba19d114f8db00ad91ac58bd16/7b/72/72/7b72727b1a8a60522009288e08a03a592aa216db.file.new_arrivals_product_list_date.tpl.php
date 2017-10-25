<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:48
         compiled from "D:\website\MK\skin\common_files\modules\New_Arrivals\new_arrivals_product_list_date.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2941559ef3200a17081-09472177%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b72727b1a8a60522009288e08a03a592aa216db' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\modules\\New_Arrivals\\new_arrivals_product_list_date.tpl',
      1 => 1496750464,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2941559ef3200a17081-09472177',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'is_header' => 0,
    'search_prefilled' => 0,
    'url_to' => 0,
    'lng' => 0,
    'product' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef3200a3a890_03320483',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef3200a3a890_03320483')) {function content_59ef3200a3a890_03320483($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_amp')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.amp.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\modifier.date_format.php';
?>
<?php if ($_smarty_tpl->tpl_vars['config']->value['New_Arrivals']['show_date_col_on_product_list']=="Y") {?>
  <?php if ($_smarty_tpl->tpl_vars['is_header']->value=="Y") {?>
    <td nowrap="nowrap"><?php if ($_smarty_tpl->tpl_vars['search_prefilled']->value['sort_field']=="add_date") {
echo $_smarty_tpl->getSubTemplate ("buttons/sort_pointer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('dir'=>$_smarty_tpl->tpl_vars['search_prefilled']->value['sort_direction']), 0);?>
&nbsp;<?php }?><a href="<?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['url_to']->value);?>
&amp;sort=add_date&amp;sort_direction=<?php if ($_smarty_tpl->tpl_vars['search_prefilled']->value['sort_field']=="add_date") {
if ($_smarty_tpl->tpl_vars['search_prefilled']->value['sort_direction']==1) {?>0<?php } else { ?>1<?php }
} else {
echo $_smarty_tpl->tpl_vars['search_prefilled']->value['sort_direction'];
}?>"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_new_arrivals_date_added'];?>
</a></td>
  <?php } else { ?>
    <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['product']->value['add_date'],$_smarty_tpl->tpl_vars['config']->value['Appearance']['date_format']);?>
</td>
  <?php }?>
<?php }?>
<?php }} ?>
