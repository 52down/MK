<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:11:20
         compiled from "D:\website\MK\skin\MK\customer\home_main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:298459ec52a8b04bc8-78996314%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f99082d0364e20518f77e07da792669429b8c2f6' => 
    array (
      0 => 'D:\\website\\MK\\skin\\MK\\customer\\home_main.tpl',
      1 => 1496750416,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '298459ec52a8b04bc8-78996314',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'main' => 0,
    'active_modules' => 0,
    'current_category' => 0,
    'help_section' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec52a8b58530_41284123',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec52a8b58530_41284123')) {function content_59ec52a8b58530_41284123($_smarty_tpl) {?>
<?php if ($_GET['mode']=="subscribed") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/subscribe_confirmation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_GET['mode']=="unsubscribed") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/unsubscribe_confirmation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="returns") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/RMA/customer/common.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="register") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/register.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="profile_delete") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/profile_delete_confirmation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="download") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Egoods/main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="send_to_friend") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/send_to_friend.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="manufacturers_list") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Manufacturers/customer_manufacturers_list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="manufacturer_products") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Manufacturers/customer_manufacturer_products.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="search"||$_smarty_tpl->tpl_vars['main']->value=="advanced_search") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/search_result.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="cart") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/cart.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif (($_smarty_tpl->tpl_vars['main']->value=="comparison"||$_smarty_tpl->tpl_vars['main']->value=='choosing')&&$_smarty_tpl->tpl_vars['active_modules']->value['Feature_Comparison']) {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Feature_Comparison/common.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="wishlist"&&$_smarty_tpl->tpl_vars['active_modules']->value['Wishlist']) {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Wishlist/wishlist.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="order_message") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/order_message.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="order_message_widget") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/order_message_widget.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="orders") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/search_orders.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="history_order") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/history_order.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="product") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/product.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="giftcert") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Gift_Certificates/customer/giftcert.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="new_arrivals"&&$_smarty_tpl->tpl_vars['active_modules']->value['New_Arrivals']) {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/New_Arrivals/new_arrivals.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="on_sale"&&$_smarty_tpl->tpl_vars['active_modules']->value['On_Sale']) {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/On_Sale/on_sale.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('navigation'=>"Y"), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="quick_reorder"&&$_smarty_tpl->tpl_vars['active_modules']->value['Quick_Reorder']) {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Quick_Reorder/quick_reorder.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="catalog"&&$_smarty_tpl->tpl_vars['current_category']->value['category']=='') {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/welcome.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="catalog") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/subcategories.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['active_modules']->value['Gift_Registry']!=''&&$_smarty_tpl->tpl_vars['main']->value=="giftreg") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Gift_Registry/giftreg_common.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="product_configurator") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Product_Configurator/pconf_common.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="change_password") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/change_password.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="customer_offers") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Special_Offers/customer/offers.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="customer_bonuses") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Special_Offers/customer/bonuses.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="survey") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Survey/customer_survey.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="surveys") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Survey/customer_surveys.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="view_message") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Survey/customer_view_message.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="view_results") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Survey/customer_view_results.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="help") {?>

  <?php if ($_smarty_tpl->tpl_vars['help_section']->value=="Password_Recovery") {?>
  <?php echo $_smarty_tpl->getSubTemplate ("customer/help/Password_Recovery.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


  <?php } elseif ($_smarty_tpl->tpl_vars['help_section']->value=="Password_Recovery_message") {?>
  <?php echo $_smarty_tpl->getSubTemplate ("customer/help/Password_Recovery_message.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


  <?php } elseif ($_smarty_tpl->tpl_vars['help_section']->value=="Password_Recovery_error") {?>
  <?php echo $_smarty_tpl->getSubTemplate ("customer/help/Password_Recovery.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


  <?php } elseif ($_smarty_tpl->tpl_vars['help_section']->value=="contactus") {?>
  <?php echo $_smarty_tpl->getSubTemplate ("customer/help/contactus.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


  <?php } else { ?>
  <?php echo $_smarty_tpl->getSubTemplate ("customer/help/general.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


  <?php }?>

<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="news_archive") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/News_Management/customer/news_archive.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="news_lists") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/News_Management/customer/news_lists.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="mc_news_archive") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Adv_Mailchimp_Subscription/customer/news_archive.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="mc_news_lists") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Adv_Mailchimp_Subscription/customer/news_lists.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="adv_news_archive") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/IContact_Subscription/customer/news_archive.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="adv_news_lists") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/IContact_Subscription/customer/news_lists.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="pages") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/pages.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="address_book") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/address_book.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="saved_cards"&&$_smarty_tpl->tpl_vars['active_modules']->value['XPayments_Connector']) {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/XPayments_Connector/saved_cards.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="profile_delete") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/profile_delete_confirmation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="profile_notdelete") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/profile_notdelete_message.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="cart_locked") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/error_cart_locked.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="giftreg_is_private") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Gift_Registry/error_giftreg_is_private.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="error_no_shipping") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/error_no_shipping.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="delivery_error") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/error_delivery.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="error_ccprocessor_unavailable") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/error_ccprocessor_unavail.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="error_cmpi_error") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/error_cmpi_error.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="error_ccprocessor_error") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/error_ccprocessor_error.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="subscribe_bad_email") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/News_Management/subscribe_bad_email.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="disabled_cookies") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/error_disabled_cookies.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="403") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/403.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="authentication") {?>
<?php echo $_smarty_tpl->getSubTemplate ("customer/main/authentication.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('is_remember'=>"Y"), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="reviews_list") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Advanced_Customer_Reviews/customer_reviews_list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="add_review") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Advanced_Customer_Reviews/customer_add_review.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="tickets"&&$_smarty_tpl->tpl_vars['active_modules']->value['Kayako_Connector']!='') {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Kayako_Connector/customer/tickets_main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="twofactor_token_verify"&&$_smarty_tpl->tpl_vars['active_modules']->value['TwoFactorAuth']) {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/TwoFactorAuth/customer/token_form.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="xps_subscriptions"&&$_smarty_tpl->tpl_vars['active_modules']->value['XPayments_Subscriptions']) {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/XPayments_Subscriptions/customer/subscriptions.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="linked_accounts"&&$_smarty_tpl->tpl_vars['active_modules']->value['XAuth']!='') {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/XAuth/linked_accounts.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="testimonials_list") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Testimonials/customer_testimonials_list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } elseif ($_smarty_tpl->tpl_vars['main']->value=="add_testimonial") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Testimonials/customer_add_testimonial.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php } else { ?>

<?php echo $_smarty_tpl->getSubTemplate ("common_templates.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php }?>
<?php }} ?>
