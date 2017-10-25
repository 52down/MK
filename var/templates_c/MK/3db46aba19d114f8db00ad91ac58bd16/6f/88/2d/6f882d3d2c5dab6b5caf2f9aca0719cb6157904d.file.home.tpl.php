<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:14:24
         compiled from "D:\website\MK\skin\MK\customer\home.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1422159ec52a7909082-37527907%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6f882d3d2c5dab6b5caf2f9aca0719cb6157904d' => 
    array (
      0 => 'D:\\website\\MK\\skin\\MK\\customer\\home.tpl',
      1 => 1508659994,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1422159ec52a7909082-37527907',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec52a7947689_86060589',
  'variables' => 
  array (
    'AltSkinDir' => 0,
    'body_onload' => 0,
    'container_classes' => 0,
    'c' => 0,
    'active_modules' => 0,
    'view_info_panel' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec52a7947689_86060589')) {function content_59ec52a7947689_86060589($_smarty_tpl) {?><?php if (!is_callable('smarty_function_load_defer_code')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer_code.php';
?>
<?php  $_config = new Smarty_Internal_Config(((string)$_smarty_tpl->tpl_vars['skin_config']->value), $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<!DOCTYPE html>
<head>
<?php echo $_smarty_tpl->getSubTemplate ("customer/service_head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['AltSkinDir']->value;?>
/bootstrap/js/html5shiv.min.js"><?php echo '</script'; ?>
>
      <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['AltSkinDir']->value;?>
/bootstrap/js/respond.min.js"><?php echo '</script'; ?>
>
    <![endif]-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 

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
