<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:10:35
         compiled from "D:\website\MK\skin\common_files\jquery_ui_tabs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2703859ec527b7ed601-79153092%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cc532c3025731857fe103c68420f148e5e90c808' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\jquery_ui_tabs.tpl',
      1 => 1496750426,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2703859ec527b7ed601-79153092',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'development_mode_enabled' => 0,
    'usertype' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec527b7f56f1_81316008',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec527b7f56f1_81316008')) {function content_59ec527b7f56f1_81316008($_smarty_tpl) {?><?php if (!is_callable('smarty_function_load_defer')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer.php';
?>

<?php if ($_smarty_tpl->tpl_vars['development_mode_enabled']->value) {?>
  <?php echo smarty_function_load_defer(array('file'=>"lib/jqueryui/components/tabs.js",'type'=>"js"),$_smarty_tpl);?>

  
  
<?php } else { ?>
  <?php echo smarty_function_load_defer(array('file'=>"lib/jqueryui/components/tabs.min.js",'type'=>"js"),$_smarty_tpl);?>

  
  
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['usertype']->value=='C') {?>
  <?php echo smarty_function_load_defer(array('file'=>"js/jquery_ui_fix.js",'type'=>"js"),$_smarty_tpl);?>

  
  
<?php }?>
<?php }} ?>
