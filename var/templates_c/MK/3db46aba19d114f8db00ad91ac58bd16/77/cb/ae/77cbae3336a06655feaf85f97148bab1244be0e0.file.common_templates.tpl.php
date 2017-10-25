<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:52
         compiled from "D:\website\MK\skin\common_files\common_templates.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2303759ef32045c77f4-01086143%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '77cbae3336a06655feaf85f97148bab1244be0e0' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\common_templates.tpl',
      1 => 1496750412,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2303759ef32045c77f4-01086143',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'main' => 0,
    'help_section' => 0,
    'template_main' => 0,
    'active_modules' => 0,
    'usertype' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef320463c7e0_13335713',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef320463c7e0_13335713')) {function content_59ef320463c7e0_13335713($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['main']->value=="last_admin") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/error_last_admin.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="product_disabled") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/error_product_disabled.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="wrong_merchant_password") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/error_wrong_merchant_password.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="cant_open_file") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/error_cant_open_file.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="profile_delete") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/profile_delete_confirmation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="profile_notdelete") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/profile_notdelete_message.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="classes") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Feature_Comparison/classes.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="help") {?>
<?php echo $_smarty_tpl->getSubTemplate ("help/index.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('section'=>$_smarty_tpl->tpl_vars['help_section']->value), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="xcart_news") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/xcart_news.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="access_denied") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/error_access_denied.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="permission_denied") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/error_permission_denied.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="order_delete_confirmation") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/order_delete_confirmation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="product_delete_confirmation") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/product_delete_confirmation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="orders") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/orders.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="create_order") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/create_order.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="history_order") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/history_order.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="product_modify") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/product_modify.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="edit_file") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/edit_file.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="edit_dir") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/edit_dir.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="patch") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/patch.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="editor_mode") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/editor_mode.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="shipping_disabled") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/error_shipping_disabled.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="realtime_shipping_disabled") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/error_realtime_shipping_disabled.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="news_archive") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/News_Management/news_archive.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="news_lists") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/News_Management/news_lists.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="disabled_cookies") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/error_disabled_cookies.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="demo_login_with_form") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Dev_Mode/login.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="surveys") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Survey/surveys.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="survey") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Survey/survey_modify.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="quick_search") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/quick_search.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="authentication") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/authentication.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('is_remember'=>"Y"), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="reviews") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Advanced_Customer_Reviews/search_reviews.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="review_modify") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Advanced_Customer_Reviews/admin_review.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['template_main']->value[$_smarty_tpl->tpl_vars['main']->value]!='') {?>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_main']->value[$_smarty_tpl->tpl_vars['main']->value], $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="product_notifications") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Product_Notifications/product_notifications_admin.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=='twofactor_token_verify'&&$_smarty_tpl->tpl_vars['active_modules']->value['TwoFactorAuth']) {?>
<?php echo $_smarty_tpl->getSubTemplate ('modules/TwoFactorAuth/token_form.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } else { ?>

  <?php if ($_smarty_tpl->tpl_vars['usertype']->value=='C') {?>
  <?php echo $_smarty_tpl->getSubTemplate ("customer/main/error_page_not_found.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

  <?php } else { ?>
  <?php echo $_smarty_tpl->getSubTemplate ("main/error_page_not_found.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

  <?php }?>

<?php }?>
<?php }} ?>
