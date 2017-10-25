<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:10:36
         compiled from "D:\website\MK\skin\common_files\main\prnotice.tpl" */ ?>
<?php /*%%SmartyHeaderCode:238159ec527c1f4138-97303788%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e4210410767c58bd535f5d2753e8a526fa33d5b0' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\prnotice.tpl',
      1 => 1496750444,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '238159ec527c1f4138-97303788',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'main' => 0,
    'current_category' => 0,
    'sm_prnotice_txt' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec527c1f8a59_41429928',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec527c1f8a59_41429928')) {function content_59ec527c1f8a59_41429928($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['main']->value=="catalog"&&$_smarty_tpl->tpl_vars['current_category']->value['category']=='') {?>
  Powered by <?php if ($_smarty_tpl->tpl_vars['sm_prnotice_txt']->value!='X-Cart') {?>X-Cart <?php }?><a href="https://www.x-cart.com" target="_blank"><?php echo $_smarty_tpl->tpl_vars['sm_prnotice_txt']->value;?>
</a>
<?php } else { ?>
  Powered by <?php if ($_smarty_tpl->tpl_vars['sm_prnotice_txt']->value!='X-Cart') {?>X-Cart <?php }
echo $_smarty_tpl->tpl_vars['sm_prnotice_txt']->value;?>

<?php }?>
<?php }} ?>
