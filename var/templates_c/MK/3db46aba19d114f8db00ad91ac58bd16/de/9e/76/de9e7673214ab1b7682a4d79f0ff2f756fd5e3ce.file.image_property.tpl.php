<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:54
         compiled from "D:\website\MK\skin\common_files\main\image_property.tpl" */ ?>
<?php /*%%SmartyHeaderCode:146759ef32060ff941-09832196%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'de9e7673214ab1b7682a4d79f0ff2f756fd5e3ce' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\image_property.tpl',
      1 => 1496750442,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '146759ef32060ff941-09832196',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'image' => 0,
    'lng' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef32061730b8_53482509',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef32061730b8_53482509')) {function content_59ef32061730b8_53482509($_smarty_tpl) {?><?php if (!is_callable('smarty_function_byte_format')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.byte_format.php';
if (!is_callable('smarty_modifier_replace')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\modifier.replace.php';
?>
<?php if ($_smarty_tpl->tpl_vars['image']->value&&$_smarty_tpl->tpl_vars['image']->value['image_type']!=''&&$_smarty_tpl->tpl_vars['image']->value['image_size']>0) {?>
  <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lng']->value['lbl_image_size'], ENT_QUOTES, 'UTF-8', true);?>
: <?php echo $_smarty_tpl->tpl_vars['image']->value['image_x'];?>
x<?php echo $_smarty_tpl->tpl_vars['image']->value['image_y'];?>
, <?php echo smarty_function_byte_format(array('value'=>$_smarty_tpl->tpl_vars['image']->value['image_size'],'format'=>'k'),$_smarty_tpl);?>
Kb
  <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lng']->value['lbl_image_type'], ENT_QUOTES, 'UTF-8', true);?>
: <?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['image']->value['image_type'],"image/",'');?>

<?php }?>
<?php }} ?>
