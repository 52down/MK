<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:09:31
         compiled from "D:\website\MK\skin\common_files\admin\main\modules_installed.tpl" */ ?>
<?php /*%%SmartyHeaderCode:480659ec523b0d77c0-77546224%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fbc77fbf99316cd8356e030f79d6150e047cb495' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\admin\\main\\modules_installed.tpl',
      1 => 1496750408,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '480659ec523b0d77c0-77546224',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'modules_filter_tags' => 0,
    'admin_safe_mode' => 0,
    'modules' => 0,
    'm' => 0,
    'tag' => 0,
    'lng' => 0,
    'module_name' => 0,
    'module_descr' => 0,
    'ImagesDir' => 0,
    'module_requirements' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec523b102a38_12865561',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec523b102a38_12865561')) {function content_59ec523b102a38_12865561($_smarty_tpl) {?><?php if (!is_callable('smarty_function_load_defer')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer.php';
if (!is_callable('smarty_modifier_amp')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.amp.php';
?>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/modules_tags.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('modules_filter_tags'=>$_smarty_tpl->tpl_vars['modules_filter_tags']->value,'tag_type'=>'modules'), 0);?>

<form action="modules.php?mode=update" method="post" name="modulesform">
<?php if (!$_smarty_tpl->tpl_vars['admin_safe_mode']->value) {?>
<?php echo smarty_function_load_defer(array('file'=>"admin/js/toggle_modules.js",'type'=>"js"),$_smarty_tpl);?>

<?php }?>
<ul class="modules-list" id="modules-list">
<?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['modules']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value) {
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
<li id="li_modules_<?php echo $_smarty_tpl->tpl_vars['m']->value['module_name'];?>
" class="<?php if ($_smarty_tpl->tpl_vars['m']->value['active']=='Y') {?>active<?php }
$_smarty_tpl->tpl_vars['tag'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tag']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['m']->value['tags']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tag']->key => $_smarty_tpl->tpl_vars['tag']->value) {
$_smarty_tpl->tpl_vars['tag']->_loop = true;
?> <?php echo $_smarty_tpl->tpl_vars['tag']->value;
} ?>">
<div class="module-settings">
  <div class="module-enable">
  <?php if (isset($_smarty_tpl->tpl_vars["module_requirements"])) {$_smarty_tpl->tpl_vars["module_requirements"] = clone $_smarty_tpl->tpl_vars["module_requirements"];
$_smarty_tpl->tpl_vars["module_requirements"]->value = "module_requirements_".((string)$_smarty_tpl->tpl_vars['m']->value['module_name']); $_smarty_tpl->tpl_vars["module_requirements"]->nocache = null; $_smarty_tpl->tpl_vars["module_requirements"]->scope = 0;
} else $_smarty_tpl->tpl_vars["module_requirements"] = new Smarty_variable("module_requirements_".((string)$_smarty_tpl->tpl_vars['m']->value['module_name']), null, 0);?>
  <input type="checkbox" id="<?php echo $_smarty_tpl->tpl_vars['m']->value['module_name'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['m']->value['module_name'];?>
"<?php if ($_smarty_tpl->tpl_vars['m']->value['active']=="Y") {?> checked="checked"<?php }
if ((!$_smarty_tpl->tpl_vars['m']->value['requirements_passed']&&$_smarty_tpl->tpl_vars['m']->value['active']=="N")||$_smarty_tpl->tpl_vars['admin_safe_mode']->value) {?> disabled="disabled"<?php }
if (!$_smarty_tpl->tpl_vars['admin_safe_mode']->value) {?> onclick="javascript: toggleModule('<?php echo $_smarty_tpl->tpl_vars['m']->value['module_name'];?>
');"<?php }?> />
  <label for="<?php echo $_smarty_tpl->tpl_vars['m']->value['module_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_enable'];?>
</label>
  </div>
  <?php if ($_smarty_tpl->tpl_vars['m']->value['options_url']!='') {?>
  <div class="module-configure">
  <?php echo $_smarty_tpl->getSubTemplate ("buttons/button.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('button_title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_configure'],'href'=>smarty_modifier_amp($_smarty_tpl->tpl_vars['m']->value['options_url']),'substyle'=>"modules"), 0);?>

  </div>
  <?php }?>
</div>
<div class="module-description">
<?php if (isset($_smarty_tpl->tpl_vars["module_name"])) {$_smarty_tpl->tpl_vars["module_name"] = clone $_smarty_tpl->tpl_vars["module_name"];
$_smarty_tpl->tpl_vars["module_name"]->value = "module_name_".((string)$_smarty_tpl->tpl_vars['m']->value['module_name']); $_smarty_tpl->tpl_vars["module_name"]->nocache = null; $_smarty_tpl->tpl_vars["module_name"]->scope = 0;
} else $_smarty_tpl->tpl_vars["module_name"] = new Smarty_variable("module_name_".((string)$_smarty_tpl->tpl_vars['m']->value['module_name']), null, 0);?>
<div class="module-title"><?php if ($_smarty_tpl->tpl_vars['lng']->value[$_smarty_tpl->tpl_vars['module_name']->value]) {
echo $_smarty_tpl->tpl_vars['lng']->value[$_smarty_tpl->tpl_vars['module_name']->value];
} else {
echo $_smarty_tpl->tpl_vars['m']->value['module_name'];
}?></div>
<?php if (isset($_smarty_tpl->tpl_vars["module_descr"])) {$_smarty_tpl->tpl_vars["module_descr"] = clone $_smarty_tpl->tpl_vars["module_descr"];
$_smarty_tpl->tpl_vars["module_descr"]->value = "module_descr_".((string)$_smarty_tpl->tpl_vars['m']->value['module_name']); $_smarty_tpl->tpl_vars["module_descr"]->nocache = null; $_smarty_tpl->tpl_vars["module_descr"]->scope = 0;
} else $_smarty_tpl->tpl_vars["module_descr"] = new Smarty_variable("module_descr_".((string)$_smarty_tpl->tpl_vars['m']->value['module_name']), null, 0);?>
<?php if ($_smarty_tpl->tpl_vars['lng']->value[$_smarty_tpl->tpl_vars['module_descr']->value]) {
echo $_smarty_tpl->tpl_vars['lng']->value[$_smarty_tpl->tpl_vars['module_descr']->value];
} else {
echo $_smarty_tpl->tpl_vars['m']->value['module_descr'];
}?>
<?php if (!$_smarty_tpl->tpl_vars['m']->value['requirements_passed']) {?>
<br />
<table cellpadding="2">
  <tr>
    <td><img src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/icon_warning_small.gif" alt="" /></td>
    <td><font class="SmallText"><?php echo $_smarty_tpl->tpl_vars['lng']->value[$_smarty_tpl->tpl_vars['module_requirements']->value];?>
</font><?php if ($_smarty_tpl->tpl_vars['m']->value['active']=="Y") {?> <font class="AdminSmallMessage"><?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_disable_notconfigured_module'];?>
</font><?php }?></td>
  </tr>
</table>
<?php }?>
</div>
<div class="clearing"></div>
</li>
<?php } ?>
</ul>
<noscript>
<br />
<div id="sticky_content">
  <div class="main-button">
    <input class="big-main-button" type="submit" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_apply_changes']), ENT_QUOTES, 'UTF-8', true);?>
" />
  </div>
</div>
</noscript>
</form>
<?php }} ?>
