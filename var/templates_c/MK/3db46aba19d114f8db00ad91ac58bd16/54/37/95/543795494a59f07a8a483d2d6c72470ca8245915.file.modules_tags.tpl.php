<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:10:35
         compiled from "D:\website\MK\skin\common_files\admin\main\modules_tags.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2977259ec527b99c9c6-04824038%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '543795494a59f07a8a483d2d6c72470ca8245915' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\admin\\main\\modules_tags.tpl',
      1 => 1496750408,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2977259ec527b99c9c6-04824038',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'modules_filter_tags' => 0,
    'lng' => 0,
    'tag_type' => 0,
    'tag_key' => 0,
    'tag' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec527b9a78c1_71978042',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec527b9a78c1_71978042')) {function content_59ec527b9a78c1_71978042($_smarty_tpl) {?><?php if (!is_callable('smarty_function_load_defer')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer.php';
?>
<?php if ($_smarty_tpl->tpl_vars['modules_filter_tags']->value) {?>
<?php echo smarty_function_load_defer(array('file'=>"admin/js/module_tags.js",'type'=>"js"),$_smarty_tpl);?>

<?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_modules_filter_by_tag'];?>

<div class="modules-tags">
<?php  $_smarty_tpl->tpl_vars['tag'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tag']->_loop = false;
 $_smarty_tpl->tpl_vars['tag_key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['modules_filter_tags']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tag']->key => $_smarty_tpl->tpl_vars['tag']->value) {
$_smarty_tpl->tpl_vars['tag']->_loop = true;
 $_smarty_tpl->tpl_vars['tag_key']->value = $_smarty_tpl->tpl_vars['tag']->key;
?>
  <div class="modules-tag">
    <input type="radio" name="selectedtags_<?php echo $_smarty_tpl->tpl_vars['tag_type']->value;?>
" id="tag_<?php echo $_smarty_tpl->tpl_vars['tag_type']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['tag_key']->value;?>
" class="ui-helper-hidden-accessible" onclick="javascript: toggleTag('<?php echo $_smarty_tpl->tpl_vars['tag_key']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['tag_type']->value;?>
');"<?php if ($_smarty_tpl->tpl_vars['tag']->value['checked']) {?> checked="checked"<?php }?> /><label for="tag_<?php echo $_smarty_tpl->tpl_vars['tag_type']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['tag_key']->value;?>
" class="ui-button ui-widget ui-corner-all ui-button-text-only"><span class="ui-button-text"><?php echo $_smarty_tpl->tpl_vars['tag']->value['label'];?>
 <span class="tag-count"><?php echo $_smarty_tpl->tpl_vars['tag']->value['count'];?>
</span></span></label>
  </div>
<?php } ?>
</div>
<?php }?>
<?php }} ?>
