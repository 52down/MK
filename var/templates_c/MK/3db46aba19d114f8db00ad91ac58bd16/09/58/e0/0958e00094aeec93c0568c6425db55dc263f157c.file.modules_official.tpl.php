<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:10:35
         compiled from "D:\website\MK\skin\common_files\admin\main\modules_official.tpl" */ ?>
<?php /*%%SmartyHeaderCode:42659ec527bcbf909-01325591%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0958e00094aeec93c0568c6425db55dc263f157c' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\admin\\main\\modules_official.tpl',
      1 => 1496750408,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '42659ec527bcbf909-01325591',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'paid_modules_filter_tags' => 0,
    'paid_modules' => 0,
    'k' => 0,
    'm' => 0,
    'tag' => 0,
    'lng' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec527bccbfa2_72680820',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec527bccbfa2_72680820')) {function content_59ec527bccbfa2_72680820($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/modules_tags.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('modules_filter_tags'=>$_smarty_tpl->tpl_vars['paid_modules_filter_tags']->value,'tag_type'=>'extensions'), 0);?>

<ul class="modules-list extensions">
<?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['paid_modules']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value) {
$_smarty_tpl->tpl_vars['m']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['m']->key;
?>
<li id="li_extensions_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['m']->value['tags']) {?> class="<?php  $_smarty_tpl->tpl_vars['tag'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tag']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['m']->value['tags']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tag']->key => $_smarty_tpl->tpl_vars['tag']->value) {
$_smarty_tpl->tpl_vars['tag']->_loop = true;
?> <?php echo $_smarty_tpl->tpl_vars['tag']->value;
} ?>"<?php }?>>
  <div class="module-icon">
    <a href="<?php echo $_smarty_tpl->tpl_vars['m']->value['page'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['m']->value['icon'];?>
" /></a>
    <div class="module-price"><?php if ($_smarty_tpl->tpl_vars['m']->value['price_suffix']) {
echo $_smarty_tpl->tpl_vars['lng']->value['lbl_modules_price_from'];?>
 <?php }?><span class="price"><?php if ($_smarty_tpl->tpl_vars['m']->value['price']!=0) {?>$<?php echo $_smarty_tpl->tpl_vars['m']->value['price'];?>
 <?php echo $_smarty_tpl->tpl_vars['m']->value['price_suffix'];
} else {
echo $_smarty_tpl->tpl_vars['lng']->value['lbl_modules_free_price'];
}?></span></div>
  </div>
  <div class="module-description">
    <div class="module-title"><a href="<?php echo $_smarty_tpl->tpl_vars['m']->value['page'];?>
"><?php echo $_smarty_tpl->tpl_vars['m']->value['name'];?>
</a></div>
    <?php echo $_smarty_tpl->tpl_vars['m']->value['desc'];?>

    <div class="module-details"><a href="<?php echo $_smarty_tpl->tpl_vars['m']->value['page'];?>
"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_read_more'];?>
</a></div>
  </div>
  <div class="clearing"></div>
</li>
<?php } ?>
</ul>
<?php }} ?>
