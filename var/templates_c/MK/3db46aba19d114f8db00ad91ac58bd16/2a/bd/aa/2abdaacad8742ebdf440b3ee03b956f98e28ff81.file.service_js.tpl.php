<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:22:51
         compiled from "D:\website\MK\skin\MK\customer\service_js.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3137659ec52a7e8c953-28955117%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2abdaacad8742ebdf440b3ee03b956f98e28ff81' => 
    array (
      0 => 'D:\\website\\MK\\skin\\MK\\customer\\service_js.tpl',
      1 => 1508660415,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3137659ec52a7e8c953-28955117',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec52a7f09085_69916453',
  'variables' => 
  array (
    '__frame_not_allowed' => 0,
    'number_format_dec' => 0,
    'number_format_th' => 0,
    'number_format_point' => 0,
    'store_language' => 0,
    'xcart_web_dir' => 0,
    'ImagesDir' => 0,
    'AltImagesDir' => 0,
    'lng' => 0,
    'usertype' => 0,
    'active_modules' => 0,
    'store_currency' => 0,
    'config' => 0,
    'use_email_validation' => 0,
    'email_validation_regexp' => 0,
    'is_admin_editor' => 0,
    'alt_skin_info' => 0,
    'webmaster_mode' => 0,
    'catalogs' => 0,
    'SkinDir' => 0,
    'webmaster_lng' => 0,
    'lbl_name' => 0,
    'lbl_val' => 0,
    'default_charset' => 0,
    'user_agent' => 0,
    'development_mode_enabled' => 0,
    'is_admin_preview' => 0,
    'main' => 0,
    'det_images_widget' => 0,
    'func_tpl_is_jcarousel_is_needed' => 0,
    'xauth_include_js' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec52a7f09085_69916453')) {function content_59ec52a7f09085_69916453($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_wm_remove')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.wm_remove.php';
if (!is_callable('smarty_modifier_replace')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\modifier.replace.php';
if (!is_callable('smarty_function_load_defer')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer.php';
if (!is_callable('smarty_function_getvar')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.getvar.php';
?> <?php $_smarty_tpl->_capture_stack[0][] = array('javascript_code', null, null); ob_start(); ?> <?php if ($_smarty_tpl->tpl_vars['__frame_not_allowed']->value&&!$_GET['open_in_layer']) {?> if (top != self)     top.location = self.location; <?php }?> var number_format_dec = '<?php echo $_smarty_tpl->tpl_vars['number_format_dec']->value;?>
'; var number_format_th = '<?php echo $_smarty_tpl->tpl_vars['number_format_th']->value;?>
'; var number_format_point = '<?php echo $_smarty_tpl->tpl_vars['number_format_point']->value;?>
'; var store_language = '<?php echo strtr($_smarty_tpl->tpl_vars['store_language']->value, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'; var xcart_web_dir = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['xcart_web_dir']->value), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
"; var images_dir = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['ImagesDir']->value), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
"; <?php if ($_smarty_tpl->tpl_vars['AltImagesDir']->value) {?>var alt_images_dir = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['AltImagesDir']->value), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
";<?php }?> var lbl_no_items_have_been_selected = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_no_items_have_been_selected']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'; var current_area = '<?php echo $_smarty_tpl->tpl_vars['usertype']->value;?>
'; <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['XMultiCurrency']!=''&&$_smarty_tpl->tpl_vars['store_currency']->value!='') {?> var currency_format = "<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['config']->value['XMultiCurrency']['selected_currency_format'],'$',$_smarty_tpl->tpl_vars['config']->value['XMultiCurrency']['selected_currency_symbol']);?>
"; <?php } else { ?> var currency_format = "<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['config']->value['General']['currency_format'],'$',$_smarty_tpl->tpl_vars['config']->value['General']['currency_symbol']);?>
"; <?php }?> var lbl_product_minquantity_error = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_product_minquantity_error']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
"; var lbl_product_maxquantity_error = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_product_maxquantity_error']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
"; var txt_out_of_stock = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['txt_out_of_stock']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
"; var lbl_product_quantity_type_error = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_product_quantity_type_error']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
"; var is_limit = <?php if ($_smarty_tpl->tpl_vars['config']->value['General']['unlimited_products']=='Y') {?>false<?php } else { ?>true<?php }?>; var lbl_required_field_is_empty = "<?php echo strtr(smarty_modifier_wm_remove(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['lng']->value['lbl_required_field_is_empty'])), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
"; var lbl_field_required = "<?php echo strtr(smarty_modifier_wm_remove(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['lng']->value['lbl_field_required'])), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
"; var lbl_field_format_is_invalid = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_field_format_is_invalid']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
"; var txt_required_fields_not_completed = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['txt_required_fields_not_completed']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
"; var lbl_blockui_default_message = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_blockui_default_message']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
"; var lbl_error = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_error']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'; var lbl_warning = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_warning']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'; var lbl_information = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_information']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'; var lbl_ok = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_ok']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'; var lbl_yes = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_yes']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'; var lbl_no = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_no']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'; var txt_minicart_total_note = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['txt_minicart_total_note']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'; var txt_ajax_error_note = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['txt_ajax_error_note']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'; <?php if ($_smarty_tpl->tpl_vars['use_email_validation']->value!="N") {?> var txt_email_invalid = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['txt_email_invalid']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
"; var email_validation_regexp = new RegExp("<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['email_validation_regexp']->value), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
", "gi"); <?php }?> var is_admin_editor = <?php if ($_smarty_tpl->tpl_vars['is_admin_editor']->value) {?>true<?php } else { ?>false<?php }?>; var is_responsive_skin = "<?php echo strtr($_smarty_tpl->tpl_vars['alt_skin_info']->value['responsive'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
"; var  topMessageDelay = []; topMessageDelay['i'] = <?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['Appearance']['delay_value'])===null||empty($tmp) ? 10 : $tmp);?>
*1000; topMessageDelay['w'] = <?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['Appearance']['delay_value_w'])===null||empty($tmp) ? 60 : $tmp);?>
*1000; topMessageDelay['e'] = <?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['Appearance']['delay_value_e'])===null||empty($tmp) ? 0 : $tmp);?>
*1000; <?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?> <?php echo smarty_function_load_defer(array('file'=>"javascript_code",'direct_info'=>Smarty::$_smarty_vars['capture']['javascript_code'],'type'=>"js"),$_smarty_tpl);?>
 <?php echo smarty_function_load_defer(array('file'=>"js/common.js",'type'=>"js"),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->tpl_vars['config']->value['Adaptives']['is_first_start']=='Y') {?>   <?php echo smarty_function_load_defer(array('file'=>"js/browser_identificator.js",'type'=>"js"),$_smarty_tpl);?>
 <?php }?> <?php if ($_smarty_tpl->tpl_vars['webmaster_mode']->value=="editor") {?>   <?php $_smarty_tpl->_capture_stack[0][] = array('webmaster_code', null, null); ob_start(); ?> var catalogs = {   admin: "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['catalogs']->value['admin']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
",   provider: "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['catalogs']->value['provider']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
",   customer: "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['catalogs']->value['customer']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
",   partner: "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['catalogs']->value['partner']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
",   images: "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['ImagesDir']->value), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
",   skin: "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['SkinDir']->value), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
" }; var lng_labels = []; <?php  $_smarty_tpl->tpl_vars['lbl_val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['lbl_val']->_loop = false;
 $_smarty_tpl->tpl_vars['lbl_name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['webmaster_lng']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['lbl_val']->key => $_smarty_tpl->tpl_vars['lbl_val']->value) {
$_smarty_tpl->tpl_vars['lbl_val']->_loop = true;
 $_smarty_tpl->tpl_vars['lbl_name']->value = $_smarty_tpl->tpl_vars['lbl_val']->key;
?> lng_labels['<?php echo $_smarty_tpl->tpl_vars['lbl_name']->value;?>
'] = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lbl_val']->value), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
"; <?php } ?> var page_charset = "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['default_charset']->value)===null||empty($tmp) ? "utf-8" : $tmp);?>
";   <?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>   <?php echo smarty_function_load_defer(array('file'=>"webmaster_code",'direct_info'=>Smarty::$_smarty_vars['capture']['webmaster_code'],'type'=>"js"),$_smarty_tpl);?>
   <?php echo smarty_function_load_defer(array('file'=>"js/editor_common.js",'type'=>"js"),$_smarty_tpl);?>
   <?php if ($_smarty_tpl->tpl_vars['user_agent']->value=="ns") {?>     <?php echo smarty_function_load_defer(array('file'=>"js/editorns.js",'type'=>"js"),$_smarty_tpl);?>
   <?php } else { ?>     <?php echo smarty_function_load_defer(array('file'=>"js/editor.js",'type'=>"js"),$_smarty_tpl);?>
   <?php }?> <?php }?> <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Magnifier']!='') {?>   <?php echo smarty_function_load_defer(array('file'=>"lib/swfobject-min.js",'type'=>"js"),$_smarty_tpl);?>
 <?php }?> <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['PayPal_Login']!='') {?>   <?php echo smarty_function_load_defer(array('file'=>"modules/PayPal_Login/main.js",'type'=>"js"),$_smarty_tpl);?>
 <?php }?> <?php echo smarty_function_load_defer(array('file'=>"bootstrap/js/jquery.min.js",'type'=>"js"),$_smarty_tpl);?>
 <?php echo smarty_function_load_defer(array('file'=>"bootstrap/js/bootstrap.min.js",'type'=>"js"),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->tpl_vars['config']->value['UA']['version']==8&&$_smarty_tpl->tpl_vars['config']->value['UA']['browser']=="MSIE") {?>   <?php echo smarty_function_load_defer(array('file'=>"lib/jquery-min.1x.js",'type'=>"js"),$_smarty_tpl);?>
 <?php } else { ?>   <?php echo smarty_function_load_defer(array('file'=>"lib/jquery-min.js",'type'=>"js"),$_smarty_tpl);?>
 <?php }?> <?php echo smarty_function_load_defer(array('file'=>"widgets/css_loader.js",'type'=>"js"),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->tpl_vars['development_mode_enabled']->value) {?>   <?php echo smarty_function_load_defer(array('file'=>"lib/jquery-migrate.development.js",'type'=>"js"),$_smarty_tpl);?>
 <?php } else { ?>   <?php echo smarty_function_load_defer(array('file'=>"lib/jquery-migrate.production.js",'type'=>"js"),$_smarty_tpl);?>
 <?php }?> <?php echo $_smarty_tpl->getSubTemplate ("jquery_ui.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <?php echo smarty_function_load_defer(array('file'=>"js/ajax.js",'type'=>"js"),$_smarty_tpl);?>
 <?php echo smarty_function_load_defer(array('file'=>"lib/cluetip/jquery.cluetip.js",'type'=>"js"),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->tpl_vars['is_admin_preview']->value) {?>   <?php $_smarty_tpl->_capture_stack[0][] = array('admin_preview_js', null, null); ob_start(); ?> var txt_this_form_is_for_demo_purposes = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['txt_this_form_is_for_demo_purposes']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'; var txt_this_link_is_for_demo_purposes = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['txt_this_link_is_for_demo_purposes']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
';   <?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>   <?php echo smarty_function_load_defer(array('file'=>"admin_preview_js",'direct_info'=>Smarty::$_smarty_vars['capture']['admin_preview_js'],'type'=>"js"),$_smarty_tpl);?>
   <?php echo smarty_function_load_defer(array('file'=>"js/admin_preview.js",'type'=>"js"),$_smarty_tpl);?>
 <?php }?> <?php echo smarty_function_load_defer(array('file'=>"js/top_message.js",'type'=>"js"),$_smarty_tpl);?>
 <?php echo smarty_function_load_defer(array('file'=>"js/popup_open.js",'type'=>"js"),$_smarty_tpl);?>
 <?php echo smarty_function_load_defer(array('file'=>"lib/jquery.blockUI.min.js",'type'=>"js"),$_smarty_tpl);?>
 <?php echo smarty_function_load_defer(array('file'=>"lib/jquery.blockUI.defaults.js",'type'=>"js"),$_smarty_tpl);?>
 <?php echo smarty_function_load_defer(array('file'=>"lib/jquery_cookie.js",'type'=>"js"),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->tpl_vars['main']->value=='product') {?>   <?php echo smarty_function_getvar(array('var'=>'det_images_widget'),$_smarty_tpl);?>
   <?php if ($_smarty_tpl->tpl_vars['det_images_widget']->value=='cloudzoom') {?>     <?php echo smarty_function_load_defer(array('file'=>"lib/cloud_zoom/cloud-zoom.min.js",'type'=>"js"),$_smarty_tpl);?>
     <?php echo smarty_function_load_defer(array('file'=>"modules/Detailed_Product_Images/cloudzoom_popup.js",'type'=>"js"),$_smarty_tpl);?>
   <?php }?> <?php }?> <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Product_Notifications']!='') {?>   <?php echo $_smarty_tpl->getSubTemplate ("modules/Product_Notifications/product_notification_widget.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <?php }?> <?php echo $_smarty_tpl->getSubTemplate ("onload_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <?php echo smarty_function_getvar(array('func'=>'func_tpl_is_jcarousel_is_needed'),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Wishlist']!=''&&$_smarty_tpl->tpl_vars['func_tpl_is_jcarousel_is_needed']->value) {?>   <?php echo smarty_function_load_defer(array('file'=>"lib/jcarousel.js",'type'=>"js"),$_smarty_tpl);?>
   <?php echo smarty_function_load_defer(array('file'=>"modules/Wishlist/wl_carousel.js",'type'=>"js"),$_smarty_tpl);?>
 <?php }?> <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Google_Analytics']) {?>   <?php if ($_smarty_tpl->tpl_vars['config']->value['Google_Analytics']['ganalytics_version']=='Asynchronous') {?>     <?php echo $_smarty_tpl->getSubTemplate ("modules/Google_Analytics/ga_code_async.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
   <?php } elseif ($_smarty_tpl->tpl_vars['config']->value['Google_Analytics']['ganalytics_version']=='universal') {?>     <?php echo $_smarty_tpl->getSubTemplate ("modules/Google_Analytics/ga_code_universal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
   <?php }?> <?php }?> <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Add_to_cart_popup']!='') {?>   <?php echo smarty_function_load_defer(array('file'=>"modules/Add_to_cart_popup/product_added.js",'type'=>"js"),$_smarty_tpl);?>
 <?php }?> <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Klarna_Payments']) {?>    <?php echo '<script'; ?>
 src="https://cdn.klarna.com/public/kitt/core/v1.0/js/klarna.min.js"><?php echo '</script'; ?>
>   <?php echo '<script'; ?>
 src="https://cdn.klarna.com/public/kitt/toc/v1.1/js/klarna.terms.min.js"><?php echo '</script'; ?>
> <?php }?> <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['POS_System']!=''&&$_smarty_tpl->tpl_vars['main']->value=="cart") {?>   <?php echo smarty_function_load_defer(array('file'=>"modules/POS_System/js/scan_barcode_field.js",'type'=>"js"),$_smarty_tpl);?>
 <?php }?> <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Cloud_Search']!='') {?>   <?php echo $_smarty_tpl->getSubTemplate ("modules/Cloud_Search/customer_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('_include_once'=>1), 0);?>
 <?php }?> <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['XAuth']!=''&&$_smarty_tpl->tpl_vars['xauth_include_js']->value=='Y') {?>   <?php echo smarty_function_load_defer(array('file'=>"modules/XAuth/controller.js",'type'=>"js"),$_smarty_tpl);?>
 <?php }?>  <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Segment']!=''&&$_COOKIE['is_robot']!='Y') {?>   <?php echo $_smarty_tpl->getSubTemplate ("modules/Segment/analytics_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <?php }?>  <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Bongo_International']) {?>   <?php if ($_smarty_tpl->tpl_vars['config']->value['Bongo_International']['bongo_extend_enabled']=='Y'&&$_smarty_tpl->tpl_vars['config']->value['Bongo_International']['bongo_extend_code']) {?>     <?php echo $_smarty_tpl->tpl_vars['config']->value['Bongo_International']['bongo_extend_code'];?>
   <?php }?> <?php }?> <?php echo smarty_function_load_defer(array('file'=>"_includes/js/swiper.min.js",'type'=>"js"),$_smarty_tpl);?>
 <?php echo smarty_function_load_defer(array('file'=>"_includes/js/main-jquery.js",'type'=>"js"),$_smarty_tpl);?>
 <?php }} ?>
