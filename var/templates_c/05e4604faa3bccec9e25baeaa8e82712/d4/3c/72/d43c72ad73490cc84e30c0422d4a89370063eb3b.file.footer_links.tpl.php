<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 09:48:39
         compiled from "D:\website\MK\skin\common_files\modules\Socialize\footer_links.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1341559ec4d578378a8-14203383%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd43c72ad73490cc84e30c0422d4a89370063eb3b' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\modules\\Socialize\\footer_links.tpl',
      1 => 1496750476,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1341559ec4d578378a8-14203383',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'active_modules' => 0,
    'config' => 0,
    'usertype' => 0,
    'SkinDir' => 0,
    'lng' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec4d57849328_03981295',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec4d57849328_03981295')) {function content_59ec4d57849328_03981295($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Socialize']&&($_smarty_tpl->tpl_vars['config']->value['Socialize']['soc_fb_page_url']!=''||$_smarty_tpl->tpl_vars['config']->value['Socialize']['soc_tw_user_name']!='')&&$_smarty_tpl->tpl_vars['usertype']->value=="C") {?>
  <ul class="soc-footer-links">
    <?php if ($_smarty_tpl->tpl_vars['config']->value['Socialize']['soc_fb_page_url']!='') {?>
      <li><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['Socialize']['soc_fb_page_url'];?>
" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/modules/Socialize/images/facebook.png" title="<?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_soc_facebook'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_soc_facebook'];?>
" /></a></li>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['config']->value['Socialize']['soc_tw_user_name']!='') {?>
      <li><a href="http://twitter.com/<?php echo $_smarty_tpl->tpl_vars['config']->value['Socialize']['soc_tw_user_name'];?>
" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/modules/Socialize/images/twitter.png" title="<?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_soc_twitter'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_soc_twitter'];?>
" /></a></li>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['config']->value['Socialize']['soc_pin_username']!='') {?>
      <li><a href="http://pinterest.com/<?php echo $_smarty_tpl->tpl_vars['config']->value['Socialize']['soc_pin_username'];?>
" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/modules/Socialize/images/pinterest.png" title="<?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_soc_pinterest'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_soc_pinterest'];?>
" /></a></li>
    <?php }?>
  </ul>
<?php }?>
<?php }} ?>
