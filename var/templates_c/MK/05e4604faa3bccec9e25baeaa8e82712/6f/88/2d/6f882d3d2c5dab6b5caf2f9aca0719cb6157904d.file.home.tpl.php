<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 09:48:24
         compiled from "D:\website\MK\skin\MK\customer\home.tpl" */ ?>
<?php /*%%SmartyHeaderCode:809459ec4d4823ba74-74402076%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6f882d3d2c5dab6b5caf2f9aca0719cb6157904d' => 
    array (
      0 => 'D:\\website\\MK\\skin\\MK\\customer\\home.tpl',
      1 => 1508641028,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '809459ec4d4823ba74-74402076',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'body_onload' => 0,
    'container_classes' => 0,
    'c' => 0,
    'active_modules' => 0,
    'view_info_panel' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec4d4826ab43_58979756',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec4d4826ab43_58979756')) {function content_59ec4d4826ab43_58979756($_smarty_tpl) {?><?php if (!is_callable('smarty_function_load_defer_code')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer_code.php';
?>
<?php  $_config = new Smarty_Internal_Config(((string)$_smarty_tpl->tpl_vars['skin_config']->value), $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<!DOCTYPE html>
<head>
<?php echo $_smarty_tpl->getSubTemplate ("customer/service_head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body<?php if ($_smarty_tpl->tpl_vars['body_onload']->value!='') {?> onload="javascript: <?php echo $_smarty_tpl->tpl_vars['body_onload']->value;?>
"<?php }
if ($_smarty_tpl->tpl_vars['container_classes']->value) {?> class="<?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['container_classes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value) {
$_smarty_tpl->tpl_vars['c']->_loop = true;
echo $_smarty_tpl->tpl_vars['c']->value;?>
 <?php } ?>"<?php }?>>
<?php echo $_smarty_tpl->getSubTemplate ("customer/mobile_head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="page-wrap">
<?php echo $_smarty_tpl->getSubTemplate ("customer/head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("customer/content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("customer/bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['EU_Cookie_Law']&&$_smarty_tpl->tpl_vars['view_info_panel']->value=="Y") {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/EU_Cookie_Law/info_panel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<?php echo smarty_function_load_defer_code(array('type'=>"css"),$_smarty_tpl);?>

<?php echo $_smarty_tpl->getSubTemplate ("customer/service_body_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo smarty_function_load_defer_code(array('type'=>"js"),$_smarty_tpl);?>

</body>
</html>
<?php }} ?>
