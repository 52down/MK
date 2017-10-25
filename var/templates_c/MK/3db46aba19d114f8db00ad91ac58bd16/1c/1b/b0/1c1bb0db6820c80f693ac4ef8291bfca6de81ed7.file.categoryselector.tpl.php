<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:54
         compiled from "D:\website\MK\skin\common_files\widgets\categoryselector\categoryselector.tpl" */ ?>
<?php /*%%SmartyHeaderCode:687259ef32061fcbc4-69091376%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c1bb0db6820c80f693ac4ef8291bfca6de81ed7' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\widgets\\categoryselector\\categoryselector.tpl',
      1 => 1496750500,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '687259ef32061fcbc4-69091376',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lng' => 0,
    'name' => 0,
    'class' => 0,
    'categoryselectorconfig' => 0,
    'extra' => 0,
    'display_empty' => 0,
    'allcategories' => 0,
    'selected_ids' => 0,
    'catid' => 0,
    'c' => 0,
    'selected_id' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef3206257547_88876693',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef3206257547_88876693')) {function content_59ef3206257547_88876693($_smarty_tpl) {?><?php if (!is_callable('smarty_function_load_defer')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer.php';
if (!is_callable('smarty_modifier_amp')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.amp.php';
?>



<?php echo $_smarty_tpl->getSubTemplate ("widgets/css_loader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('css'=>"lib/select2/css/select2.min.css"), 0);?>

<?php echo smarty_function_load_defer(array('file'=>"lib/select2/js/select2.min.js",'type'=>"js"),$_smarty_tpl);?>

<?php echo smarty_function_load_defer(array('file'=>"lib/select2/js/i18n/".((string)$_smarty_tpl->tpl_vars['shop_language']->value).".js",'type'=>"js"),$_smarty_tpl);?>


<?php $_smarty_tpl->tpl_vars["categoryselectorconfig"] = new Smarty_variable($_smarty_tpl->getSubTemplate ("widgets/categoryselector/config.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0));?>


<?php echo $_smarty_tpl->getSubTemplate ("widgets/css_loader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('css'=>"widgets/categoryselector/categoryselector.css"), 0);?>

<?php echo smarty_function_load_defer(array('file'=>"widgets/categoryselector/categorysorter.js",'type'=>"js"),$_smarty_tpl);?>

<?php echo smarty_function_load_defer(array('file'=>"widgets/categoryselector/categoryselector.js",'type'=>"js"),$_smarty_tpl);?>


<div class="categoryselector-widget-switcher">
  <span data-action="default"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_default'];?>
</span>
  <span data-action="widget"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_widget'];?>
</span>
</div>

<select name="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['name']->value)===null||empty($tmp) ? "categoryid" : $tmp);?>
" class="categoryselector<?php if ($_smarty_tpl->tpl_vars['class']->value) {?> <?php echo $_smarty_tpl->tpl_vars['class']->value;
}?>" data-categoryselectorconfig="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['categoryselectorconfig']->value, ENT_QUOTES, 'UTF-8', true);?>
" <?php echo $_smarty_tpl->tpl_vars['extra']->value;?>
>
  <?php if ($_smarty_tpl->tpl_vars['display_empty']->value=='P') {?>
    <option value=""><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_please_select_category'];?>
</option>
  <?php } elseif ($_smarty_tpl->tpl_vars['display_empty']->value=='E') {?>
    <option value="">&nbsp;</option>
  <?php }?>
  <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_smarty_tpl->tpl_vars['catid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['allcategories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value) {
$_smarty_tpl->tpl_vars['c']->_loop = true;
 $_smarty_tpl->tpl_vars['catid']->value = $_smarty_tpl->tpl_vars['c']->key;
?>
    <?php if ($_smarty_tpl->tpl_vars['selected_ids']->value) {?>
      <option value="<?php echo $_smarty_tpl->tpl_vars['catid']->value;?>
"<?php if ($_smarty_tpl->tpl_vars['selected_ids']->value[$_smarty_tpl->tpl_vars['catid']->value]) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['c']->value;?>
</option>
    <?php } else { ?>
      <option value="<?php echo $_smarty_tpl->tpl_vars['catid']->value;?>
"<?php if ($_smarty_tpl->tpl_vars['selected_id']->value==$_smarty_tpl->tpl_vars['catid']->value) {?> selected="selected"<?php }?> title="<?php echo htmlspecialchars(strip_tags((($_smarty_tpl->tpl_vars['c']->value).(' (id:')).($_smarty_tpl->tpl_vars['catid']->value)), ENT_QUOTES, 'UTF-8', true);?>
)"><?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['c']->value);?>
</option>
    <?php }?>
  <?php } ?>
</select>
<?php }} ?>
