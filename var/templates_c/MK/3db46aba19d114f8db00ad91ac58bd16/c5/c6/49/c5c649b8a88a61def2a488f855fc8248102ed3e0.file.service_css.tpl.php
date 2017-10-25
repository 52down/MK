<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:32:13
         compiled from "D:\website\MK\skin\MK\customer\service_css.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3163059ec52a8586739-78776320%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c5c649b8a88a61def2a488f855fc8248102ed3e0' => 
    array (
      0 => 'D:\\website\\MK\\skin\\MK\\customer\\service_css.tpl',
      1 => 1508661129,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3163059ec52a8586739-78776320',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec52a85a1ba3_04490924',
  'variables' => 
  array (
    'main' => 0,
    'det_images_widget' => 0,
    'active_modules' => 0,
    'func_tpl_is_jcarousel_is_needed' => 0,
    'AltSkinDir' => 0,
    'config' => 0,
    'ie_ver' => 0,
    'custom_styles' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec52a85a1ba3_04490924')) {function content_59ec52a85a1ba3_04490924($_smarty_tpl) {?><?php if (!is_callable('smarty_function_load_defer')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer.php';
if (!is_callable('smarty_function_getvar')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.getvar.php';
?> <?php echo smarty_function_load_defer(array('file'=>"lib/cluetip/jquery.cluetip.css",'type'=>"css"),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->tpl_vars['main']->value=='product') {?>   <?php echo smarty_function_getvar(array('var'=>'det_images_widget'),$_smarty_tpl);?>
   <?php if ($_smarty_tpl->tpl_vars['det_images_widget']->value=='cloudzoom') {?>     <?php echo smarty_function_load_defer(array('file'=>"lib/cloud_zoom/cloud-zoom.css",'type'=>"css"),$_smarty_tpl);?>
   <?php } elseif ($_smarty_tpl->tpl_vars['det_images_widget']->value=='colorbox') {?>     <?php echo smarty_function_load_defer(array('file'=>"lib/colorbox/colorbox.css",'type'=>"css"),$_smarty_tpl);?>
   <?php }?> <?php }?> <?php echo smarty_function_getvar(array('func'=>'func_tpl_is_jcarousel_is_needed'),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Wishlist']!=''&&$_smarty_tpl->tpl_vars['func_tpl_is_jcarousel_is_needed']->value) {?>   <?php echo smarty_function_load_defer(array('file'=>"modules/Wishlist/main_carousel.css",'type'=>"css"),$_smarty_tpl);?>
 <?php }?> <?php echo smarty_function_load_defer(array('file'=>"css/font-awesome.min.css",'type'=>"css"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->getSubTemplate ('customer/service_css_modules.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <?php if ($_smarty_tpl->tpl_vars['AltSkinDir']->value) {?>   <?php echo smarty_function_load_defer(array('file'=>"css/altskin.css",'type'=>"css"),$_smarty_tpl);?>
   <?php if ($_smarty_tpl->tpl_vars['config']->value['UA']['browser']=="MSIE") {?>     <?php echo smarty_function_load_defer(array('file'=>"css/altskin.IE".((string)$_smarty_tpl->tpl_vars['ie_ver']->value).".css",'type'=>"css"),$_smarty_tpl);?>
   <?php }?>   <?php if ($_smarty_tpl->tpl_vars['config']->value['UA']['browser']=='Firefox'||$_smarty_tpl->tpl_vars['config']->value['UA']['browser']=='Mozilla') {?>     <?php echo smarty_function_load_defer(array('file'=>"css/altskin.FF.css",'type'=>"css"),$_smarty_tpl);?>
   <?php }?>   <?php if ($_smarty_tpl->tpl_vars['config']->value['UA']['browser']=='Chrome') {?>     <?php echo smarty_function_load_defer(array('file'=>"css/altskin.Chrome.css",'type'=>"css"),$_smarty_tpl);?>
   <?php }?>   <?php echo $_smarty_tpl->getSubTemplate ('customer/service_css_modules.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('is_altskin'=>true), 0);?>
 <?php }?> <?php echo smarty_function_load_defer(array('file'=>"bootstrap/css/bootstrap.css",'type'=>"css"),$_smarty_tpl);?>
 <?php echo smarty_function_load_defer(array('file'=>"_includes/css/xcart.css",'rel'=>"stylesheet",'type'=>"css"),$_smarty_tpl);?>
 <?php echo smarty_function_load_defer(array('file'=>"_includes/css/swiper.min.css",'rel'=>"stylesheet",'type'=>"css"),$_smarty_tpl);?>
 <?php echo smarty_function_load_defer(array('file'=>"_includes/css/font-awesome.min.css",'rel'=>"stylesheet",'type'=>"css"),$_smarty_tpl);?>
 <?php echo smarty_function_load_defer(array('file'=>"_includes/fonts/font.css",'rel'=>"stylesheet",'type'=>"css"),$_smarty_tpl);?>
 <?php echo smarty_function_load_defer(array('file'=>"_includes/css/styles.css",'rel'=>"stylesheet",'type'=>"css"),$_smarty_tpl);?>
 <?php echo smarty_function_load_defer(array('file'=>"_includes/css/animate.css",'rel'=>"stylesheet",'type'=>"css"),$_smarty_tpl);?>
 <?php echo smarty_function_load_defer(array('file'=>"_includes/css/global.css",'rel'=>"stylesheet",'type'=>"css"),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->tpl_vars['custom_styles']->value) {?> <?php echo smarty_function_load_defer(array('file'=>"css/custom_styles",'direct_info'=>$_smarty_tpl->tpl_vars['custom_styles']->value,'type'=>"css"),$_smarty_tpl);?>
 <?php }?> <?php }} ?>
