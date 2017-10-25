<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 09:48:37
         compiled from "D:\website\MK\skin\common_files\jquery_ui.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2300559ec4d55c2e524-23572133%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bc5b62418cc229a14b1a0c62d39f18cd3e588e5a' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\jquery_ui.tpl',
      1 => 1496750426,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2300559ec4d55c2e524-23572133',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'development_mode_enabled' => 0,
    'usertype' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec4d55c3fe60_81538501',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec4d55c3fe60_81538501')) {function content_59ec4d55c3fe60_81538501($_smarty_tpl) {?><?php if (!is_callable('smarty_function_load_defer')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer.php';
?> <?php if ($_smarty_tpl->tpl_vars['development_mode_enabled']->value) {?>   <?php echo smarty_function_load_defer(array('file'=>"js/jquery_ui_disable_compat.js",'type'=>"js"),$_smarty_tpl);?>
 <?php }?> <?php if ($_smarty_tpl->tpl_vars['development_mode_enabled']->value&&$_smarty_tpl->tpl_vars['usertype']->value=='C') {?>   <?php echo smarty_function_load_defer(array('file'=>"lib/jqueryui/jquery-ui.custom.js",'type'=>"js"),$_smarty_tpl);?>
   <?php echo smarty_function_load_defer(array('file'=>"lib/jqueryui/jquery-ui.structure.css",'type'=>"css"),$_smarty_tpl);?>
 <?php } else { ?>   <?php echo smarty_function_load_defer(array('file'=>"lib/jqueryui/jquery-ui.custom.min.js",'type'=>"js"),$_smarty_tpl);?>
   <?php echo smarty_function_load_defer(array('file'=>"lib/jqueryui/jquery-ui.structure.min.css",'type'=>"css"),$_smarty_tpl);?>
 <?php }?>  <?php if ($_smarty_tpl->tpl_vars['development_mode_enabled']->value) {?>   <?php echo smarty_function_load_defer(array('file'=>"lib/jqueryui/components/tabs.css",'type'=>"css"),$_smarty_tpl);?>
 <?php } else { ?>   <?php echo smarty_function_load_defer(array('file'=>"lib/jqueryui/components/tabs.min.css",'type'=>"css"),$_smarty_tpl);?>
 <?php }?> <?php if ($_smarty_tpl->tpl_vars['usertype']->value=='C') {?>   <?php if ($_smarty_tpl->tpl_vars['development_mode_enabled']->value) {?>     <?php echo smarty_function_load_defer(array('file'=>"lib/jqueryui/jquery-ui.theme.css",'type'=>"css"),$_smarty_tpl);?>
   <?php } else { ?>     <?php echo smarty_function_load_defer(array('file'=>"lib/jqueryui/jquery-ui.theme.min.css",'type'=>"css"),$_smarty_tpl);?>
   <?php }?> <?php } else { ?>   <?php echo smarty_function_load_defer(array('file'=>"js/jquery_ui_override.js",'type'=>"js"),$_smarty_tpl);?>
   <?php if ($_smarty_tpl->tpl_vars['development_mode_enabled']->value) {?>     <?php echo smarty_function_load_defer(array('file'=>"lib/jqueryui/jquery-ui.admin.css",'type'=>"css"),$_smarty_tpl);?>
   <?php } else { ?>     <?php echo smarty_function_load_defer(array('file'=>"lib/jqueryui/jquery-ui.admin.min.css",'type'=>"css"),$_smarty_tpl);?>
   <?php }?> <?php }?> <?php echo smarty_function_load_defer(array('file'=>"css/jquery_ui.css",'type'=>"css"),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->tpl_vars['config']->value['UA']['browser']=="MSIE"&&$_smarty_tpl->tpl_vars['config']->value['UA']['version']==8) {?> <?php echo smarty_function_load_defer(array('file'=>"css/jquery_ui.IE8.css",'type'=>"css"),$_smarty_tpl);?>
 <?php }?> <?php }} ?>
