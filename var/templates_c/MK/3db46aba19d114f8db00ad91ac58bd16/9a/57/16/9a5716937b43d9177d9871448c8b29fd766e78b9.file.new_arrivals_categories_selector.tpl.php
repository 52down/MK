<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:24
         compiled from "D:\website\MK\skin\common_files\modules\New_Arrivals\new_arrivals_categories_selector.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2052059ef31e864bdc8-38385395%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9a5716937b43d9177d9871448c8b29fd766e78b9' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\modules\\New_Arrivals\\new_arrivals_categories_selector.tpl',
      1 => 1496750464,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2052059ef31e864bdc8-38385395',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'is_list' => 0,
    'is_header' => 0,
    'lng' => 0,
    'categoryid' => 0,
    'category' => 0,
    'is_details' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef31e8665392_52598782',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef31e8665392_52598782')) {function content_59ef31e8665392_52598782($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['is_list']->value=="Y") {?>
  <?php if ($_smarty_tpl->tpl_vars['is_header']->value=="Y") {?>
    <td align="center"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_new_arrivals_show_new_arrivals'];?>
</td>
  <?php } else { ?>
    <td align="center">
    <select name="posted_data[<?php echo $_smarty_tpl->tpl_vars['categoryid']->value;?>
][show_new_arrivals]">
      <option value="Y"<?php if ($_smarty_tpl->tpl_vars['category']->value['show_new_arrivals']=="Y"||$_smarty_tpl->tpl_vars['category']->value['show_new_arrivals']=='') {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_yes'];?>
</option>
      <option value="N"<?php if ($_smarty_tpl->tpl_vars['category']->value['show_new_arrivals']=="N") {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_no'];?>
</option>
    </select>
    </td>
  <?php }?>
<?php } elseif ($_smarty_tpl->tpl_vars['is_details']->value=="Y") {?>
  <tr>
    <td height="10" class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_new_arrivals_show_new_arrivals'];?>
:</td>
    <td width="10" height="10"><font class="Star"></font></td>
    <td height="10">
      <select name="show_new_arrivals">
        <option value="Y" <?php if ($_smarty_tpl->tpl_vars['category']->value['show_new_arrivals']=="Y"||$_smarty_tpl->tpl_vars['category']->value['show_new_arrivals']=='') {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_yes'];?>
</option>
        <option value="N" <?php if ($_smarty_tpl->tpl_vars['category']->value['show_new_arrivals']=="N") {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_no'];?>
</option>
      </select>
    </td>
  </tr>
<?php }?>
<?php }} ?>
