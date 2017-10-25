<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:24
         compiled from "D:\website\MK\skin\common_files\main\subheader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2879759ef31e8b96e85-71630617%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '734c342da00b7123adaef3667cbac84694f74dd2' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\subheader.tpl',
      1 => 1496750444,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2879759ef31e8b96e85-71630617',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'class' => 0,
    'title' => 0,
    'ImagesDir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef31e8bae1c0_88697636',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef31e8bae1c0_88697636')) {function content_59ef31e8bae1c0_88697636($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['class']->value=='grey') {?>
<table cellspacing="0" class="SubHeaderGrey">
<tr>
  <td class="SubHeaderGrey"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</td>
</tr>
<tr>
  <td class="SubHeaderGreyLine"><img src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/spacer.gif" class="Spc" alt="" /></td>
</tr>
</table>
<?php } elseif ($_smarty_tpl->tpl_vars['class']->value=="red") {?>
<table cellspacing="0" class="SubHeaderRed">
<tr>
  <td class="SubHeaderRed"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</td>
</tr>
<tr>
  <td class="SubHeaderRedLine"><img src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/spacer.gif" class="Spc" alt="" /><br /></td>
</tr>
</table>
<?php } elseif ($_smarty_tpl->tpl_vars['class']->value=="black") {?>
<table cellspacing="0" class="SubHeaderBlack">
<tr>
  <td class="SubHeaderBlack"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</td>
</tr>
<tr>
  <td class="SubHeaderBlackLine"><img src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/spacer.gif" class="Spc" alt="" /><br /></td>
</tr>
</table>
<?php } else { ?>
<table cellspacing="0" class="SubHeader">
<tr>
  <td class="SubHeader"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</td>
</tr>
<tr>
  <td class="SubHeaderLine"><img src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/spacer.gif" class="Spc" alt="" /><br /></td>
</tr>
</table>
<?php }?>

<?php }} ?>
