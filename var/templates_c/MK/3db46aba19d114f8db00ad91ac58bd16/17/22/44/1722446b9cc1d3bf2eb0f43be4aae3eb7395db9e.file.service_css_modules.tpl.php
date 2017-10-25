<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:11:20
         compiled from "D:\website\MK\skin\common_files\customer\service_css_modules.tpl" */ ?>
<?php /*%%SmartyHeaderCode:401559ec52a86f9178-45283237%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1722446b9cc1d3bf2eb0f43be4aae3eb7395db9e' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\customer\\service_css_modules.tpl',
      1 => 1496750422,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '401559ec52a86f9178-45283237',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'is_altskin' => 0,
    'ie_ver' => 0,
    'css_files' => 0,
    'files' => 0,
    'f' => 0,
    'main' => 0,
    'config' => 0,
    'mname' => 0,
    'module_css_filename' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec52a87117a8_61922645',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec52a87117a8_61922645')) {function content_59ec52a87117a8_61922645($_smarty_tpl) {?><?php if (!is_callable('smarty_function_load_defer')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer.php';
?> <?php if ($_smarty_tpl->tpl_vars['is_altskin']->value) {?>  <?php if (isset($_smarty_tpl->tpl_vars['module_css_filename'])) {$_smarty_tpl->tpl_vars['module_css_filename'] = clone $_smarty_tpl->tpl_vars['module_css_filename'];
$_smarty_tpl->tpl_vars['module_css_filename']->value = 'altskin'; $_smarty_tpl->tpl_vars['module_css_filename']->nocache = null; $_smarty_tpl->tpl_vars['module_css_filename']->scope = 0;
} else $_smarty_tpl->tpl_vars['module_css_filename'] = new Smarty_variable('altskin', null, 0);?> <?php } else { ?>  <?php if (isset($_smarty_tpl->tpl_vars['module_css_filename'])) {$_smarty_tpl->tpl_vars['module_css_filename'] = clone $_smarty_tpl->tpl_vars['module_css_filename'];
$_smarty_tpl->tpl_vars['module_css_filename']->value = $_smarty_tpl->getConfigVariable('CSSFilePrefix'); $_smarty_tpl->tpl_vars['module_css_filename']->nocache = null; $_smarty_tpl->tpl_vars['module_css_filename']->scope = 0;
} else $_smarty_tpl->tpl_vars['module_css_filename'] = new Smarty_variable($_smarty_tpl->getConfigVariable('CSSFilePrefix'), null, 0);?> <?php }?> <?php if ($_smarty_tpl->tpl_vars['ie_ver']->value!='') {?> <style type="text/css"> <!-- <?php }
$_smarty_tpl->tpl_vars['files'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['files']->_loop = false;
 $_smarty_tpl->tpl_vars['mname'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['css_files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['files']->key => $_smarty_tpl->tpl_vars['files']->value) {
$_smarty_tpl->tpl_vars['files']->_loop = true;
 $_smarty_tpl->tpl_vars['mname']->value = $_smarty_tpl->tpl_vars['files']->key;
$_smarty_tpl->tpl_vars['f'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['f']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['f']->key => $_smarty_tpl->tpl_vars['f']->value) {
$_smarty_tpl->tpl_vars['f']->_loop = true;
if (!$_smarty_tpl->tpl_vars['f']->value['admin']) {
if (!$_smarty_tpl->tpl_vars['f']->value['main_tpls']||in_array($_smarty_tpl->tpl_vars['main']->value,$_smarty_tpl->tpl_vars['f']->value['main_tpls'])) {
if ((!$_smarty_tpl->tpl_vars['is_altskin']->value&&!$_smarty_tpl->tpl_vars['f']->value['altskin'])||($_smarty_tpl->tpl_vars['is_altskin']->value&&$_smarty_tpl->tpl_vars['f']->value['altskin'])) {
if (($_smarty_tpl->tpl_vars['f']->value['browser']==$_smarty_tpl->tpl_vars['config']->value['UA']['browser']&&$_smarty_tpl->tpl_vars['f']->value['version']==$_smarty_tpl->tpl_vars['config']->value['UA']['version'])||($_smarty_tpl->tpl_vars['f']->value['browser']==$_smarty_tpl->tpl_vars['config']->value['UA']['browser']&&!$_smarty_tpl->tpl_vars['f']->value['version'])||(!$_smarty_tpl->tpl_vars['f']->value['browser']&&!$_smarty_tpl->tpl_vars['f']->value['version'])||(!$_smarty_tpl->tpl_vars['f']->value['browser'])) {
if ($_smarty_tpl->tpl_vars['f']->value['suffix']) {
echo smarty_function_load_defer(array('file'=>"modules/".((string)$_smarty_tpl->tpl_vars['mname']->value)."/".((string)$_smarty_tpl->tpl_vars['f']->value['subpath']).((string)$_smarty_tpl->tpl_vars['module_css_filename']->value).".".((string)$_smarty_tpl->tpl_vars['f']->value['suffix']).".css",'type'=>'css','css_inc_mode'=>$_smarty_tpl->tpl_vars['ie_ver']->value),$_smarty_tpl);
} else {
echo smarty_function_load_defer(array('file'=>"modules/".((string)$_smarty_tpl->tpl_vars['mname']->value)."/".((string)$_smarty_tpl->tpl_vars['f']->value['subpath']).((string)$_smarty_tpl->tpl_vars['module_css_filename']->value).".css",'type'=>'css','css_inc_mode'=>$_smarty_tpl->tpl_vars['ie_ver']->value),$_smarty_tpl);
}
}
}
}
}
}
} ?> <?php if ($_smarty_tpl->tpl_vars['ie_ver']->value!='') {?> --> </style> <?php }?>  <?php }} ?>
