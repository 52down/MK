<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:09:29
         compiled from "D:\website\MK\skin\common_files\head_admin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1464159ec5239e0eb63-39597272%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '29a9808d863525a7bcfa797dc0236b9388c70ce9' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\head_admin.tpl',
      1 => 1496750424,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1464159ec5239e0eb63-39597272',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'login' => 0,
    'current_area' => 0,
    'ImagesDir' => 0,
    'top_news' => 0,
    'menu' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec5239e18828_79770316',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec5239e18828_79770316')) {function content_59ec5239e18828_79770316($_smarty_tpl) {?><?php if (!is_callable('smarty_function_getvar')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.getvar.php';
?>
<?php if ($_smarty_tpl->tpl_vars['login']->value!='') {?>
<?php echo $_smarty_tpl->getSubTemplate ("quick_search.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<div id="head-admin">

  <div id="logo-gray">
    <a href="<?php echo $_smarty_tpl->tpl_vars['current_area']->value;?>
/home.php"><img src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/logo_gray.png" alt="" /></a>
  </div>

  <?php if ($_smarty_tpl->tpl_vars['login']->value) {?>

    <?php echo smarty_function_getvar(array('var'=>'top_news','func'=>'func_tpl_get_admin_top_news'),$_smarty_tpl);?>

    <?php if ($_smarty_tpl->tpl_vars['top_news']->value) {?>
      <div class="admin-top-news">
        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['top_news']->value['description'])===null||empty($tmp) ? $_smarty_tpl->tpl_vars['top_news']->value['title'] : $tmp);?>

      </div>
    <?php }?>

    <div id="admin-top-menu">
        <ul>
        <?php echo $_smarty_tpl->getSubTemplate ("admin/top_menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        </ul>
    </div>

  <?php }?>

  <div class="clearing"></div>

  <?php if ($_smarty_tpl->tpl_vars['login']->value&&$_smarty_tpl->tpl_vars['menu']->value) {?>
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['menu']->value)."/menu_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

  <?php }?>

</div>
<?php }} ?>
