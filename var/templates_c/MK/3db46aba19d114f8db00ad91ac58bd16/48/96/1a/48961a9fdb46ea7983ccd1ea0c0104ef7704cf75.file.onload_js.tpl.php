<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:11:20
         compiled from "D:\website\MK\skin\common_files\onload_js.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1626559ec52a8493875-35968722%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '48961a9fdb46ea7983ccd1ea0c0104ef7704cf75' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\onload_js.tpl',
      1 => 1496750492,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1626559ec52a8493875-35968722',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'lng' => 0,
    'active_modules' => 0,
    'products' => 0,
    'free_products' => 0,
    'cat_products' => 0,
    'printable' => 0,
    'products_has_fclasses' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec52a84a1f38_95095717',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec52a84a1f38_95095717')) {function content_59ec52a84a1f38_95095717($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_wm_remove')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.wm_remove.php';
if (!is_callable('smarty_function_load_defer')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer.php';
?> <?php $_smarty_tpl->_capture_stack[0][] = array('onload_js', null, null); ob_start(); ?> <?php if ($_GET['is_install_preview']) {?>  /*  Fix problem with refreshing of the skin preview   */ /*  during skin installation */ var _ts = new Date(); $('link').each(function(){ $(this).attr('href', this.href + '?' + _ts.valueOf()); });  <?php }?> <?php if ($_smarty_tpl->tpl_vars['config']->value['SEO']['clean_urls_enabled']=="Y") {?>  /*  Fix a.href if base url is defined for page */ function anchor_fix() { var links = document.getElementsByTagName('A'); var m; var _rg = new RegExp("(^|" + self.location.host + xcart_web_dir + "/)#([\\w\\d_-]+)$"); for (var i = 0; i < links.length; i++) {   if (links[i].href && (m = links[i].href.match(_rg))) {     links[i].href = 'javascript:void(self.location.hash = "' + m[2] + '");';   } } } if (window.addEventListener) window.addEventListener("load", anchor_fix, false); else if (window.attachEvent) window.attachEvent("onload", anchor_fix);  <?php }?>  function initDropOutButton() {   if ($(this).hasClass('activated-widget'))     return;   $(this).addClass('activated-widget');   var dropOutBoxObj = $(this).parent().find('.dropout-box');   /* Process the onclick event on a dropout button  */   $(this).click(     function(e) {       e.stopPropagation();       $('.dropout-box').removeClass('current');       dropOutBoxObj         .toggle()         .addClass('current');       $('.dropout-box').not('.current').hide();       if (dropOutBoxObj.offset().top + dropOutBoxObj.height() - $('#center-main').offset().top - $('#center-main').height() > 0) {         dropOutBoxObj.css('bottom', '-2px');       }     }   );   /* Click on a dropout layer keeps the dropout content opened */   $(this).parent().click(     function(e) {       e.stopPropagation();     }   );   /* shift the dropout layer from the right hand side  */   /* if it's out of the main area */   var borderDistance = ($("#center-main").offset().left + $("#center-main").outerWidth()) - ($(this).offset().left + dropOutBoxObj.outerWidth());   if (!isNaN(borderDistance) && borderDistance < 0) {     dropOutBoxObj.css('left', borderDistance+'px');   } } $(document).ready( function() {   $('body').click(     function() {       $('.dropout-box')         .filter(function() { return $(this).css('display') != 'none'; } )         .hide();     }   );   $('div.dropout-container div.drop-out-button').each(initDropOutButton); } );   $(document).ready( function() { $('form').not('.skip-auto-validation').each(function() {   applyCheckOnSubmit(this); }); $(document).on(   'click','a.toggle-link',    function(e) {     $('#' + $(this).attr('id').replace('link', 'box')).toggle();   } ); });   if (products_data == undefined) { var products_data = []; }  var txt_are_you_sure = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['txt_are_you_sure']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'; <?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?> <?php echo smarty_function_load_defer(array('file'=>"onload_js",'direct_info'=>Smarty::$_smarty_vars['capture']['onload_js'],'type'=>"js",'queue'=>"1"),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['EU_Cookie_Law']!='') {?> <?php echo $_smarty_tpl->getSubTemplate ("modules/EU_Cookie_Law/init.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <?php }?> <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Product_Options']!='') {?>   <?php echo smarty_function_load_defer(array('file'=>"modules/Product_Options/func.js",'type'=>"js"),$_smarty_tpl);?>
 <?php }?> <?php echo smarty_function_load_defer(array('file'=>"js/check_quantity.js",'type'=>"js"),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->tpl_vars['products']->value||$_smarty_tpl->tpl_vars['free_products']->value||$_smarty_tpl->tpl_vars['cat_products']->value) {?> <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Feature_Comparison']&&!$_smarty_tpl->tpl_vars['printable']->value&&$_smarty_tpl->tpl_vars['products_has_fclasses']->value) {?> <?php echo smarty_function_load_defer(array('file'=>"modules/Feature_Comparison/products_check.js",'type'=>"js"),$_smarty_tpl);?>
 <?php }?> <?php }?> <?php }} ?>
