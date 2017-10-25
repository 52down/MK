<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:11:21
         compiled from "D:\website\MK\skin\MK\customer\main\home_page_banner.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2826259ec52a918a883-34911058%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2ab409b5d5cc34bc1bd8fbf06779373586e3f328' => 
    array (
      0 => 'D:\\website\\MK\\skin\\MK\\customer\\main\\home_page_banner.tpl',
      1 => 1508578284,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2826259ec52a918a883-34911058',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'top_banners' => 0,
    'banner' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec52a9195bc4_18470527',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec52a9195bc4_18470527')) {function content_59ec52a9195bc4_18470527($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_amp')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.amp.php';
?><div class="home-banner">
  <div class="swiper-container">
    <div class="swiper-wrapper">
    <?php  $_smarty_tpl->tpl_vars['banner'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['banner']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['top_banners']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['banner']->key => $_smarty_tpl->tpl_vars['banner']->value) {
$_smarty_tpl->tpl_vars['banner']->_loop = true;
?>
    <?php if ($_smarty_tpl->tpl_vars['banner']->value['content']!='') {?>
    <?php  $_smarty_tpl->tpl_vars['content'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['content']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['banner']->value['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['content']->key => $_smarty_tpl->tpl_vars['content']->value) {
$_smarty_tpl->tpl_vars['content']->_loop = true;
?>
    <?php if ($_smarty_tpl->tpl_vars['content']->value['type']=="I") {?>
    <?php if ($_smarty_tpl->tpl_vars['content']->value['url']!='') {?><a href="<?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['content']->value['url']);?>
"><?php }?><div class="swiper-slide" style="background-image:url(<?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['content']->value['image_path']);?>
)"></div><?php if ($_smarty_tpl->tpl_vars['content']->value['url']!='') {?></a><?php }?>
    <?php } else { ?>
      <?php echo $_smarty_tpl->tpl_vars['content']->value['info'];?>

    <?php }?>
    <?php } ?>
    <?php }?>
    <?php } ?>
    </div>
    <!-- Add Pagination --> 
    <!--<div class="swiper-pagination swiper-pagination-white"></div>--> 
    <!-- Add Arrows -->
    <div class="swiper-button-next swiper-button-black"></div>
    <div class="swiper-button-prev swiper-button-black"></div>
  </div>
  <a class="arrow-link" href="#"><i class="fa fa-angle-down"></i></a> 
</div>
<?php }} ?>
