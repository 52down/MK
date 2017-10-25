<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:11:21
         compiled from "D:\website\MK\skin\common_files\customer\service_body_js.tpl" */ ?>
<?php /*%%SmartyHeaderCode:767759ec52a929f101-97068671%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '48f41feccb009fc39ef1a985fd5c249860dcfdba' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\customer\\service_body_js.tpl',
      1 => 1496750422,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '767759ec52a929f101-97068671',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'amazon_enabled' => 0,
    'amazon_widget_url' => 0,
    'active_modules' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec52a92ab649_65988721',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec52a92ab649_65988721')) {function content_59ec52a92ab649_65988721($_smarty_tpl) {?><?php if (!is_callable('smarty_function_load_defer')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer.php';
?>


<?php if ($_smarty_tpl->tpl_vars['amazon_enabled']->value) {?>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['amazon_widget_url']->value;?>
"><?php echo '</script'; ?>
>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Amazon_Payments_Advanced']) {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/Amazon_Payments_Advanced/service_body.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Google_Analytics']&&$_smarty_tpl->tpl_vars['config']->value['Google_Analytics']['ganalytics_version']=='Asynchronous') {?>
  
  <?php $_smarty_tpl->_capture_stack[0][] = array('ga_code_async_js_part2', null, null); ob_start(); ?>
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  <?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
  <?php echo smarty_function_load_defer(array('file'=>"ga_code_async_js_part2",'direct_info'=>Smarty::$_smarty_vars['capture']['ga_code_async_js_part2'],'type'=>"js"),$_smarty_tpl);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Segment']!=''&&$_COOKIE['is_robot']!='Y') {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/Segment/analytics_body_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Facebook_Ecommerce']!=''&&$_COOKIE['is_robot']!='Y') {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/Facebook_Ecommerce/ad_events_body.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<?php }} ?>
