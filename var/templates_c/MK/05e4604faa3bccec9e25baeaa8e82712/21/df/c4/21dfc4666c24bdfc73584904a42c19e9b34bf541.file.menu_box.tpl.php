<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:09:30
         compiled from "D:\website\MK\skin\common_files\single\menu_box.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2558459ec523a475ee6-62205409%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '21dfc4666c24bdfc73584904a42c19e9b34bf541' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\single\\menu_box.tpl',
      1 => 1496750498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2558459ec523a475ee6-62205409',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lng' => 0,
    'catalogs' => 0,
    'active_modules' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec523a4dfd70_54321791',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec523a4dfd70_54321791')) {function content_59ec523a4dfd70_54321791($_smarty_tpl) {?>
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
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['RMA']!='') {?>
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
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['provider'];?>
/product_modify.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_add_new_product'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Alibaba_Wholesale']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/alibaba_wholesale_catalog.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_aw_add_product'];?>
</a>
<?php }?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/search.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_products'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Customer_Reviews']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/ratings_edit.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_edit_ratings'];?>
</a>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Extra_Fields']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['provider'];?>
/extra_fields.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_extra_fields'];?>
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
<?php echo $_smarty_tpl->getSubTemplate ("modules/Product_Configurator/pconf_menu_provider.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Feature_Comparison']) {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Feature_Comparison/admin_menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Product_Notifications']!='') {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/product_notifications.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_prod_notif_adm'];?>
</a>
<?php }?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['provider'];?>
/discounts.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_discounts'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Discount_Coupons']) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['provider'];?>
/coupons.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_coupons'];?>
</a>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Special_Offers']) {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Special_Offers/menu_provider.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

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
/users.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_users'];?>
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

<?php if ($_smarty_tpl->tpl_vars['config']->value['Shipping']['enable_shipping']=="Y") {?>
  <a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['provider'];?>
/shipping_rates.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_shipping_and_taxes'];?>
</a>
<?php } else { ?>
  <a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/taxes.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_shipping_and_taxes'];?>
</a>
<?php }?>

<div>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/countries.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_countries'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/states.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_states'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['provider'];?>
/zones.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_destination_zones'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/taxes.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_taxing_system'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/configuration.php?option=Shipping"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_menu_shipping_options'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/shipping.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_shipping_methods'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['config']->value['Shipping']['enable_shipping']=="Y") {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['provider'];?>
/shipping_rates.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_shipping_charges'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['config']->value['Shipping']['realtime_shipping']=="Y") {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['provider'];?>
/shipping_rates.php?type=R"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_shipping_markups'];?>
</a>
<?php }?>
<?php }?>
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
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['provider'];?>
/inv_update.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_update_inventory'];?>
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
