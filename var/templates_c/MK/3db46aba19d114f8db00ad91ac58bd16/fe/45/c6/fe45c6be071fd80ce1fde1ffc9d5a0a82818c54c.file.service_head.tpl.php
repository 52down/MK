<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:27:32
         compiled from "D:\website\MK\skin\MK\customer\service_head.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1977859ec52a7a1d428-34374646%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fe45c6be071fd80ce1fde1ffc9d5a0a82818c54c' => 
    array (
      0 => 'D:\\website\\MK\\skin\\MK\\customer\\service_head.tpl',
      1 => 1508660759,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1977859ec52a7a1d428-34374646',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec52a7a2cc31_59373918',
  'variables' => 
  array (
    'meta_page_type' => 0,
    'meta_page_id' => 0,
    'current_location' => 0,
    'config' => 0,
    'active_modules' => 0,
    'canonical_url' => 0,
    'catalogs' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec52a7a2cc31_59373918')) {function content_59ec52a7a2cc31_59373918($_smarty_tpl) {?><?php if (!is_callable('smarty_function_get_title')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.get_title.php';
if (!is_callable('smarty_function_load_defer_code')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer_code.php';
?>
<?php echo smarty_function_get_title(array('page_type'=>$_smarty_tpl->tpl_vars['meta_page_type']->value,'page_id'=>$_smarty_tpl->tpl_vars['meta_page_id']->value),$_smarty_tpl);?>

<?php echo $_smarty_tpl->getSubTemplate ("customer/meta.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("customer/service_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("customer/service_css.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<link rel="shortcut icon" type="image/png" href="<?php echo $_smarty_tpl->tpl_vars['current_location']->value;?>
/favicon.ico" />

<?php if ($_smarty_tpl->tpl_vars['config']->value['SEO']['canonical']=='Y'||$_smarty_tpl->tpl_vars['active_modules']->value['Segment']) {?>
  <link rel="canonical" href="<?php echo $_smarty_tpl->tpl_vars['current_location']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['canonical_url']->value;?>
" />
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['config']->value['SEO']['clean_urls_enabled']=="Y") {?>
  <base href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['customer'];?>
/" />
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Refine_Filters']) {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/Refine_Filters/service_head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Socialize']!='') {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/Socialize/service_head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Lexity']!='') {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/Lexity/service_head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Bongo_International']) {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/Bongo_International/service_head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Facebook_Ecommerce']) {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/Facebook_Ecommerce/base_snippet_head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php echo smarty_function_load_defer_code(array('type'=>"css"),$_smarty_tpl);?>

<?php echo smarty_function_load_defer_code(array('type'=>"js"),$_smarty_tpl);?>

<?php }} ?>
