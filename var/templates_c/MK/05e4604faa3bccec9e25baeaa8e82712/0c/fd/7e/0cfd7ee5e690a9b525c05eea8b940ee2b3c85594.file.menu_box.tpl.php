<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:09:37
         compiled from "D:\website\MK\skin\common_files\admin\menu_box.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2375059ec5241cf41c5-43730760%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0cfd7ee5e690a9b525c05eea8b940ee2b3c85594' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\admin\\menu_box.tpl',
      1 => 1496750410,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2375059ec5241cf41c5-43730760',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lng' => 0,
    'catalogs' => 0,
    'active_modules' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec5241d82f59_88685688',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec5241d82f59_88685688')) {function content_59ec5241d82f59_88685688($_smarty_tpl) {?>
<ul id="horizontal-menu">

<li>
<a href="home.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_dashboard'];?>
</a>
</li>

<li>

<a href='<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/orders.php?date=M'><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_orders'];?>
</a>

<div>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/orders.php?date=M"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_this_month_orders'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/orders.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_search_orders_menu'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Advanced_Order_Management']!='') {?>
  <a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/create_order.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_create_order'];?>
</a>
<?php }?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/commissions.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_provider_commissions'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['RMA']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/returns.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_returns'];?>
</a>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Gift_Certificates']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/giftcerts.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_gift_certificates'];?>
</a>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Abandoned_Cart_Reminder']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/abandoned_carts.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_abcr_abandoned_carts'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/abandoned_carts_statistic.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_abcr_order_statistic'];?>
</a>
<?php }?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/accounting_adv.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_accounting'];?>
</a>
</div>
</li>

<li>

<a href='<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/search.php'><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_catalog'];?>
</a>

<div>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/product_modify.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_add_new_product'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Alibaba_Wholesale']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/alibaba_wholesale_catalog.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_aw_add_product'];?>
</a>
<?php }?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/search.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_search_for_products'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Customer_Reviews']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/ratings_edit.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_ratings'];?>
</a>
<?php }?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/categories.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_categories'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Manufacturers']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/manufacturers.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_manufacturers'];?>
</a>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Product_Configurator']) {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Product_Configurator/pconf_menu_admin.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Feature_Comparison']) {?>
<a href="classes.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_product_feature_classes'];?>
</a>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Product_Notifications']!='') {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/product_notifications.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_prod_notif_adm'];?>
</a>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Advanced_Customer_Reviews']!='') {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/reviews.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_customer_reviews'];?>
</a>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Refine_Filters']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/manage_filters.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_rf_manage_filters'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/rf_classes.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_rf_custom_classes'];?>
</a>
<?php }?>
</div>
</li>

<li>

<a href='<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/users.php'><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_users'];?>
</a>

<div>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/users.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_user_search'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Wishlist']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/wishlists.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_wish_lists'];?>
</a>
<?php }?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/memberships.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_membership_levels'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/titles.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_titles'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Stop_List']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/stop_list.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_stop_list'];?>
</a>
<?php }?>
</div>
</li>

<li>

<a href='<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/shipping.php'><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_shipping_and_taxes'];?>
</a>

<div>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/countries.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_countries'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/states.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_states'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/taxes.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_taxes'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/configuration.php?option=Shipping"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_menu_shipping_options'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/shipping.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_shipping_methods'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['UPS_OnLine_Tools']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/ups.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_ups_online_tools'];?>
</a>
<?php }?>
</div>
</li>

<li>

<a href='<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/tools.php'><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_tools'];?>
</a>

<div>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/import.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_import_export'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/general.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_summary'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/statistics.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_statistics'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/db_backup.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_db_backup_restore'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/editor_mode.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_webmaster_mode'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/patch.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_patch_upgrade'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/change_mpassword.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_change_mpassword'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/tools.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_maintenance'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Lexity']) {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Lexity/menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['XMonitoring']) {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/XMonitoring/menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['XBackup']) {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/XBackup/menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
</div>
</li>

<li>

<a href='<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/configuration.php'><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_settings'];?>
</a>

<div>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/configuration.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_general_settings'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/payment_methods.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_payment_methods'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/modules.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_modules'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/images_location.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_images_location'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['XOrder_Statuses']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/xorder_statuses.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_xostat_order_statuses'];?>
</a>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['XPayments_Connector']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/configuration.php?option=XPayments_Connector"><?php echo $_smarty_tpl->tpl_vars['lng']->value['module_name_XPayments_Connector'];?>
</a>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['XMultiCurrency']!='') {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/currencies.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['mc_lbl_multicurrency_menu'];?>
</a>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['ShippingEasy']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/shippingeasy_statuses.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_shippingeasy_statuses'];?>
</a>
<?php }?>
</div>
</li>

<li>

<a href='<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/languages.php'><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_content'];?>
</a>

<div>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/languages.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_languages'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/pages.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_static_pages'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/speed_bar.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_speed_bar'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Banner_System']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/banner_system.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_banner_system'];?>
</a>
<?php }?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/html_catalog.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_html_catalog'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['News_Management']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/news.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_news_management'];?>
</a>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Adv_Mailchimp_Subscription']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/mailchimp_news.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_mailchimp_news_management'];?>
</a>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['IContact_Subscription']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/icontact_news.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_icontact_news_management'];?>
</a>
<?php }?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/file_edit.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_edit_templates'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/file_manage.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_files'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Survey']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/surveys.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_survey_surveys'];?>
</a>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Testimonials']!='') {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/testimonials.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_testimonials'];?>
</a><br />
<?php }?>
</div>
</li>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['XAffiliate']) {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/menu_affiliate.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Kayako_Connector']!='') {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Kayako_Connector/admin/menu_kayako.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php echo $_smarty_tpl->getSubTemplate ("admin/goodies.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


</ul>
<?php }} ?>
