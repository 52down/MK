<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 09:48:36
         compiled from "D:\website\MK\skin\common_files\single\home.tpl" */ ?>
<?php /*%%SmartyHeaderCode:173459ec4d54f18176-08140715%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a0a7e563d633da49c553a32e0d50ae8a6ee87d57' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\single\\home.tpl',
      1 => 1496750498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '173459ec4d54f18176-08140715',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'reading_direction_tag' => 0,
    'login' => 0,
    'dialog_tools_data' => 0,
    'banner_tools_data' => 0,
    'main' => 0,
    'lng' => 0,
    'products' => 0,
    'processing_module' => 0,
    'active_modules' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec4d55084723_92524394',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec4d55084723_92524394')) {function content_59ec4d55084723_92524394($_smarty_tpl) {?><?php if (!is_callable('smarty_function_get_title')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.get_title.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php  $_config = new Smarty_Internal_Config(((string)$_smarty_tpl->tpl_vars['skin_config']->value), $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo smarty_function_get_title(array(),$_smarty_tpl);?>

<?php echo $_smarty_tpl->getSubTemplate ("meta.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("service_css.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body<?php echo $_smarty_tpl->tpl_vars['reading_direction_tag']->value;
if ($_smarty_tpl->tpl_vars['login']->value=='') {?> class="not-logged-in"<?php }?>>
<?php echo $_smarty_tpl->getSubTemplate ("rectangle_top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("head_admin.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('need_quick_search'=>"Y",'menu'=>"single"), 0);?>

<!-- main area -->
<table width="100%" cellpadding="0" cellspacing="0" align="center">
<tr>
<td colspan="2" id="location_and_status">
  <?php echo $_smarty_tpl->getSubTemplate ("location.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</td>
</tr>
<tr>
<td valign="top" class="central-space<?php if ($_smarty_tpl->tpl_vars['dialog_tools_data']->value) {?> dtools<?php } elseif ($_smarty_tpl->tpl_vars['banner_tools_data']->value) {?> btools<?php }?>">
<!-- central space -->
<?php echo $_smarty_tpl->getSubTemplate ("main/evaluation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php if ($_smarty_tpl->tpl_vars['main']->value=="authentication") {?>

<?php echo $_smarty_tpl->getSubTemplate ("main/authentication.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('login_title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_admin_login_title']), 0);?>


<?php } elseif ($_GET['mode']=="subscribed") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/subscribe_confirmation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="import_export") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/import_export.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="ups_import") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Order_Tracking/ups_import.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="xpc_admin") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/XPayments_Connector/xpc_admin.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="froogle_export") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Froogle/froogle.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="snapshots") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/snapshots.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="titles") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/titles.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="zones") {?>
<?php echo $_smarty_tpl->getSubTemplate ("provider/main/zones.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="zone_edit") {?>
<?php echo $_smarty_tpl->getSubTemplate ("provider/main/zone_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="ups_registration") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/UPS_OnLine_Tools/ups.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="order_edit") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Advanced_Order_Management/order_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="manufacturers") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Manufacturers/manufacturers.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="wishlists") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Wishlist/wishlists.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="wishlist") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Wishlist/display_wishlist.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="user_profile") {?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpldir']->value)."/main/register.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="stop_list") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Stop_List/stop_list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="returns") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/RMA/returns.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="benchmark") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Benchmark/bench.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="slg") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Shipping_Label_Generator/generator.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="register") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/register.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="product_links") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/product_links.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="general_info") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/general.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="tools") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/tools.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="user_access_control") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/user_access_control.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="taxes") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/taxes.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="tax_edit") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/tax_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="pages") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/pages.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

 
<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="page_edit") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/page_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="change_mpassword") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/change_mpassword.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="countries_edit") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/countries.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="counties_edit") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/counties.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="images_location") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/images_location.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="shipping_options") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/shipping_options.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="languages") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/languages.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="memberships") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/memberships.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="banner_info") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/banner_info.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="referred_sales") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/referred_sales.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="banner_system") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Banner_System/banner_system_modify.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="banner_content") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Banner_System/banner_content_modify.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="affiliates") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/affiliates.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="partner_top_performers") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/partner_top_performers.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="partner_adv_stats") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/partner_adv_stats.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="partner_adv_campaigns") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/partner_adv_campaigns.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="partner_level_commissions") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/partner_level_commissions.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="partner_orders") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/partner_orders.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="partner_report") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/partner_report.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="partner_banners") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/partner_banners.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="partner_plans") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/partner_plans.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="partner_plans_edit") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/partner_plans_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="payment_upload") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/payment_upload.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_GET['mode']=="unsubscribed") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/unsubscribe_confirmation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="search") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/search_result.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('products'=>$_smarty_tpl->tpl_vars['products']->value), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="categories") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/categories.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="modules") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/modules.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="payment_methods") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/payment_methods.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="cc_processing") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/cc_processing_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('processing_module'=>$_smarty_tpl->tpl_vars['processing_module']->value), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="edit_file") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/edit_file.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="edit_dir") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/edit_dir.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="countries") {?>
<?php echo $_smarty_tpl->getSubTemplate ("provider/main/countries.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="statistics") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/statistics.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="configuration") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/configuration.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="shipping") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/shipping.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="add_realtime_methods") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/add_realtime_methods.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="states_edit") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/states.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="users") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/users.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="featured_products") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/featured_products.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="category_modify") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/category_modify.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="category_products") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/category_products.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="category_delete_confirmation") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/category_del_confirmation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="user_delete_confirmation") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/user_delete_confirmation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="user_add") {?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpldir']->value)."/main/register.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="discounts") {?>
<?php echo $_smarty_tpl->getSubTemplate ("provider/main/discounts.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="coupons") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Discount_Coupons/coupons.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="extra_fields") {?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Extra_Fields']!='') {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Extra_Fields/extra_fields.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="giftcerts") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Gift_Certificates/gc_admin.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="db_backup") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/db_backup.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="shipping_rates") {?>
<?php echo $_smarty_tpl->getSubTemplate ("provider/main/shipping_rates.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="shipping_zones") {?>
<?php echo $_smarty_tpl->getSubTemplate ("provider/main/shipping_zones.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="top_info") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="promo") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/promotions.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="ratings_edit") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/ratings_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="inv_update") {?>
<?php echo $_smarty_tpl->getSubTemplate ("provider/main/inv_update.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="inv_updated") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/inv_updated.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="error_inv_update") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/error_inv_update.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="html_catalog") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/html_catalog.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="speed_bar") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/speed_bar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="product_configurator") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Product_Configurator/pconf_common.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="news_management") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/News_Management/news_common.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="mailchimp_news_management") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Adv_Mailchimp_Subscription/news_common.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="icontact_news_management") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/IContact_Subscription/news_common.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="change_password") {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/change_password.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="test_pgp") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/test_pgp.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="special_offers") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Special_Offers/common.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="lexity") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Lexity/main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="xmonitoring") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/XMonitoring/main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="logs") {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/logs.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="multi_currency") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/XMultiCurrency/admin/currencies.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="order_statuses") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/XOrder_Statuses/order_statuses.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="tickets"&&$_smarty_tpl->tpl_vars['active_modules']->value['Kayako_Connector']!='') {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Kayako_Connector/admin/tickets_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="xbackup"&&$_smarty_tpl->tpl_vars['active_modules']->value['XBackup']!='') {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/XBackup/main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="abandoned_carts") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Abandoned_Cart_Reminder/abandoned_carts.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="abandoned_carts_statistic") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Abandoned_Cart_Reminder/order_statistic.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="print_barcodes"&&$_smarty_tpl->tpl_vars['active_modules']->value['POS_System']!='') {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/POS_System/products_barcodes.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="edit_testimonial") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Testimonials/admin_edit_testimonial.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="testimonials") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Testimonials/admin_testimonials_list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="shippingeasy_statuses") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/ShippingEasy/shippingeasy_statuses.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="alibaba_wholesale_catalog"&&$_smarty_tpl->tpl_vars['active_modules']->value['Alibaba_Wholesale']!='') {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Alibaba_Wholesale/aw_catalog.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="parcels"&&$_smarty_tpl->tpl_vars['active_modules']->value['Pitney_Bowes']!='') {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Pitney_Bowes/parcels.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="parcel_items"&&$_smarty_tpl->tpl_vars['active_modules']->value['Pitney_Bowes']!='') {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Pitney_Bowes/parcel_items.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } else { ?>
<?php echo $_smarty_tpl->getSubTemplate ("common_templates.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<!-- /central space -->
&nbsp;
</td>

<td valign="top">
  <?php echo $_smarty_tpl->getSubTemplate ("dialog_tools.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

  <?php echo $_smarty_tpl->getSubTemplate ("banner_tools.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</td>

</tr>
</table>
<?php echo $_smarty_tpl->getSubTemplate ("rectangle_bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</body>
</html>
<?php }} ?>
