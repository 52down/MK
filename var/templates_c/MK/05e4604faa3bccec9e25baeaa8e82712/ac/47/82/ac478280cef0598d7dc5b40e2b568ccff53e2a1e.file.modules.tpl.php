<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:09:30
         compiled from "D:\website\MK\skin\common_files\admin\main\modules.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2482659ec523ad98908-50904398%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ac478280cef0598d7dc5b40e2b568ccff53e2a1e' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\admin\\main\\modules.tpl',
      1 => 1496750408,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2482659ec523ad98908-50904398',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lng' => 0,
    'modules_tabs' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec523adab3e8_46905696',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec523adab3e8_46905696')) {function content_59ec523adab3e8_46905696($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate ("page_title.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_modules']), 0);?>



<?php echo $_smarty_tpl->getSubTemplate ("customer/main/ui_tabs.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('prefix'=>"modules-tabs-",'mode'=>"inline",'default_tab'=>"-1last_used_tab",'tabs'=>$_smarty_tpl->tpl_vars['modules_tabs']->value), 0);?>

<?php }} ?>
