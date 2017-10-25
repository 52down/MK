<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:54
         compiled from "D:\website\MK\skin\common_files\widgets\categoryselector\config.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2820959ef320639d433-27474770%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1b3d40d1a87374225aa3e5eaa2c64caa5fc4d283' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\widgets\\categoryselector\\config.tpl',
      1 => 1496750500,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2820959ef320639d433-27474770',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'shop_language' => 0,
    'extra_cat_config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef32063ab670_61812987',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef32063ab670_61812987')) {function content_59ef32063ab670_61812987($_smarty_tpl) {?>
{
  "language": "<?php echo $_smarty_tpl->tpl_vars['shop_language']->value;?>
",
  "theme": "xcart-ui",
  <?php echo $_smarty_tpl->tpl_vars['extra_cat_config']->value;?>

  "sorter": "xcartCategoryselectorLowercaseComparison"
}
<?php }} ?>
