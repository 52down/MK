<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:10:33
         compiled from "D:\website\MK\skin\common_files\service_css.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3156859ec52799a98b7-58582195%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '17d33a3ebf34a9920101798ffb29c9abeb56b278' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\service_css.tpl',
      1 => 1496750498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3156859ec52799a98b7-58582195',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'SkinDir' => 0,
    'ie_ver' => 0,
    'css_files' => 0,
    'files' => 0,
    'f' => 0,
    'mname' => 0,
    'configuration_tabs' => 0,
    'main' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec52799bd194_29264537',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec52799bd194_29264537')) {function content_59ec52799bd194_29264537($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['config']->value['UA']['browser']=='MSIE') {?>
  <?php if (isset($_smarty_tpl->tpl_vars['ie_ver'])) {$_smarty_tpl->tpl_vars['ie_ver'] = clone $_smarty_tpl->tpl_vars['ie_ver'];
$_smarty_tpl->tpl_vars['ie_ver']->value = sprintf('%d',$_smarty_tpl->tpl_vars['config']->value['UA']['version']); $_smarty_tpl->tpl_vars['ie_ver']->nocache = null; $_smarty_tpl->tpl_vars['ie_ver']->scope = 0;
} else $_smarty_tpl->tpl_vars['ie_ver'] = new Smarty_variable(sprintf('%d',$_smarty_tpl->tpl_vars['config']->value['UA']['version']), null, 0);?>
<?php }?>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/css/admin.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/css/font-awesome.min.css" />
<?php if ($_smarty_tpl->tpl_vars['ie_ver']->value!='') {?>
<style type="text/css">
<!--
<?php }?>
<?php  $_smarty_tpl->tpl_vars['files'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['files']->_loop = false;
 $_smarty_tpl->tpl_vars['mname'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['css_files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['files']->key => $_smarty_tpl->tpl_vars['files']->value) {
$_smarty_tpl->tpl_vars['files']->_loop = true;
 $_smarty_tpl->tpl_vars['mname']->value = $_smarty_tpl->tpl_vars['files']->key;
$_smarty_tpl->tpl_vars['f'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['f']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['f']->key => $_smarty_tpl->tpl_vars['f']->value) {
$_smarty_tpl->tpl_vars['f']->_loop = true;
if ($_smarty_tpl->tpl_vars['f']->value['admin']) {
if (!$_smarty_tpl->tpl_vars['ie_ver']->value) {?><link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/modules/<?php echo $_smarty_tpl->tpl_vars['mname']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['f']->value['subpath'];?>
admin<?php if ($_smarty_tpl->tpl_vars['f']->value['suffix']) {?>.<?php echo $_smarty_tpl->tpl_vars['f']->value['suffix'];
}?>.css" /><?php } else { ?>@import url("<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/modules/<?php echo $_smarty_tpl->tpl_vars['mname']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['f']->value['subpath'];?>
admin<?php if ($_smarty_tpl->tpl_vars['f']->value['suffix']) {?>.<?php echo $_smarty_tpl->tpl_vars['f']->value['suffix'];
}?>.css");<?php }
}
}
} ?>
<?php if ($_smarty_tpl->tpl_vars['ie_ver']->value!='') {?>
-->
</style>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['configuration_tabs']->value!=''&&$_smarty_tpl->tpl_vars['main']->value=='configuration') {?>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/admin/css/configuration_tabs.css" />
<?php }?>
<?php }} ?>
