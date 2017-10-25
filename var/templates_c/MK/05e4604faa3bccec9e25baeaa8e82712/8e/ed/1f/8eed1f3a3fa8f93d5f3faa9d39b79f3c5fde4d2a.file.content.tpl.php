<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 09:48:25
         compiled from "D:\website\MK\skin\MK\customer\content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1134259ec4d49b372b4-60532892%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8eed1f3a3fa8f93d5f3faa9d39b79f3c5fde4d2a' => 
    array (
      0 => 'D:\\website\\MK\\skin\\MK\\customer\\content.tpl',
      1 => 1508577173,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1134259ec4d49b372b4-60532892',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'main' => 0,
    'current_category' => 0,
    'page_style' => 0,
    'top_message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec4d49b52ce5_68438034',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec4d49b52ce5_68438034')) {function content_59ec4d49b52ce5_68438034($_smarty_tpl) {?><section class="content<?php if ($_smarty_tpl->tpl_vars['main']->value!="catalog"||$_smarty_tpl->tpl_vars['current_category']->value['category']!='') {?> page-content<?php }?> <?php echo $_smarty_tpl->tpl_vars['page_style']->value;?>
">
<?php if ($_smarty_tpl->tpl_vars['top_message']->value) {?>
  <?php echo $_smarty_tpl->getSubTemplate ("main/top_message.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/home_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</section>

<?php }} ?>
