<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:09:31
         compiled from "D:\website\MK\skin\common_files\admin\main\modules_thirdparty.tpl" */ ?>
<?php /*%%SmartyHeaderCode:545859ec523b649ad5-93800136%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7e2c960cde515f48c85597ea7d0f00486f43e19f' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\admin\\main\\modules_thirdparty.tpl',
      1 => 1496750408,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '545859ec523b649ad5-93800136',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lng' => 0,
    'shop_type' => 0,
    'thirdparty_banners' => 0,
    'banner' => 0,
    'cb' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec523b666f67_93796633',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec523b666f67_93796633')) {function content_59ec523b666f67_93796633($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_substitute')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.substitute.php';
?>
<div id="modules-thirdparty-note"><?php echo smarty_modifier_substitute($_smarty_tpl->tpl_vars['lng']->value['txt_modules_thirdparty_note'],"shop_type",$_smarty_tpl->tpl_vars['shop_type']->value);?>
</div>
<ul class="modules-list extensions">
<?php  $_smarty_tpl->tpl_vars['banner'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['banner']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['thirdparty_banners']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['banner']->key => $_smarty_tpl->tpl_vars['banner']->value) {
$_smarty_tpl->tpl_vars['banner']->_loop = true;
?>
<?php if (isset($_smarty_tpl->tpl_vars['cb'])) {$_smarty_tpl->tpl_vars['cb'] = clone $_smarty_tpl->tpl_vars['cb'];
$_smarty_tpl->tpl_vars['cb']->value = mt_rand(1,99999999999); $_smarty_tpl->tpl_vars['cb']->nocache = null; $_smarty_tpl->tpl_vars['cb']->scope = 0;
} else $_smarty_tpl->tpl_vars['cb'] = new Smarty_variable(mt_rand(1,99999999999), null, 0);?>
<li>
  <iframe id="<?php echo $_smarty_tpl->tpl_vars['banner']->value['n'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['banner']->value['n'];?>
" src="//ads.qtmsoft.com/www/delivery/afr.php?zoneid=<?php echo $_smarty_tpl->tpl_vars['banner']->value['zoneid'];?>
&amp;cb=<?php echo $_smarty_tpl->tpl_vars['cb']->value;?>
" frameborder="0" scrolling="no"><a href="//ads.qtmsoft.com/www/delivery/ck.php?n=<?php echo $_smarty_tpl->tpl_vars['banner']->value['n'];?>
&amp;cb=<?php echo $_smarty_tpl->tpl_vars['cb']->value;?>
" target="_blank"><img src="//ads.qtmsoft.com/www/delivery/avw.php?zoneid=<?php echo $_smarty_tpl->tpl_vars['banner']->value['zoneid'];?>
&amp;cb=<?php echo $_smarty_tpl->tpl_vars['cb']->value;?>
&amp;n=<?php echo $_smarty_tpl->tpl_vars['banner']->value['n'];?>
" border="0" alt="" /></a></iframe>
</li>
<?php } ?>
</ul>
<div id="more-thirdparty-modules">
<?php echo $_smarty_tpl->getSubTemplate ("buttons/button.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('button_title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_more_thirdparty_modules'],'href'=>"//market.x-cart.com/go/xc4".((string)$_smarty_tpl->tpl_vars['shop_type']->value)."/?utm_source=xcart&amp;utm_medium=thirdparty_modules_link_bottom&amp;utm_campaign=xcart_modules",'substyle'=>"thirdparty-modules"), 0);?>

</div>
<?php }} ?>
