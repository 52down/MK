<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 09:48:39
         compiled from "D:\website\MK\skin\common_files\dialog.tpl" */ ?>
<?php /*%%SmartyHeaderCode:806059ec4d57471124-74658535%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '375282e9f06b8f7ebc0b6f622b63a25c36d68719' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\dialog.tpl',
      1 => 1496750424,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '806059ec4d57471124-74658535',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'extra' => 0,
    'zero_cellspacing' => 0,
    'valign' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec4d57475b65_28085406',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec4d57475b65_28085406')) {function content_59ec4d57475b65_28085406($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['title']->value) {?>
  <h2><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h2>
<?php }?>
<table cellspacing="0" <?php echo $_smarty_tpl->tpl_vars['extra']->value;?>
>
<tr>
  <td class="DialogBorder">
    <table cellspacing="<?php if (!$_smarty_tpl->tpl_vars['zero_cellspacing']->value) {?>1<?php } else { ?>0<?php }?>" class="DialogBox">
      <tr>
        <td class="DialogBox" valign="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['valign']->value)===null||empty($tmp) ? "top" : $tmp);?>
">
          <?php echo $_smarty_tpl->tpl_vars['content']->value;?>
&nbsp;
        </td>
      </tr>
    </table>
  </td>
</tr>
</table>
<?php }} ?>
