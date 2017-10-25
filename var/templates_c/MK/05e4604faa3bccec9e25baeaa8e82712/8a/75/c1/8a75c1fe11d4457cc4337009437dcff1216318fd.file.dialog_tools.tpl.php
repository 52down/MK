<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:09:31
         compiled from "D:\website\MK\skin\common_files\dialog_tools.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1641959ec523b765776-96396132%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8a75c1fe11d4457cc4337009437dcff1216318fd' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\dialog_tools.tpl',
      1 => 1496750424,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1641959ec523b765776-96396132',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'dialog_tools_data' => 0,
    'config' => 0,
    'left' => 0,
    'right' => 0,
    'lng' => 0,
    'cell' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec523b77d982_90381883',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec523b77d982_90381883')) {function content_59ec523b77d982_90381883($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['dialog_tools_data']->value) {?>
  <?php if (isset($_smarty_tpl->tpl_vars["left"])) {$_smarty_tpl->tpl_vars["left"] = clone $_smarty_tpl->tpl_vars["left"];
$_smarty_tpl->tpl_vars["left"]->value = $_smarty_tpl->tpl_vars['dialog_tools_data']->value['left']; $_smarty_tpl->tpl_vars["left"]->nocache = null; $_smarty_tpl->tpl_vars["left"]->scope = 0;
} else $_smarty_tpl->tpl_vars["left"] = new Smarty_variable($_smarty_tpl->tpl_vars['dialog_tools_data']->value['left'], null, 0);?>
  <?php if (isset($_smarty_tpl->tpl_vars["right"])) {$_smarty_tpl->tpl_vars["right"] = clone $_smarty_tpl->tpl_vars["right"];
$_smarty_tpl->tpl_vars["right"]->value = $_smarty_tpl->tpl_vars['dialog_tools_data']->value['right']; $_smarty_tpl->tpl_vars["right"]->nocache = null; $_smarty_tpl->tpl_vars["right"]->scope = 0;
} else $_smarty_tpl->tpl_vars["right"] = new Smarty_variable($_smarty_tpl->tpl_vars['dialog_tools_data']->value['right'], null, 0);?>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['dialog_tools_data']->value['left']||$_smarty_tpl->tpl_vars['dialog_tools_data']->value['right']||$_smarty_tpl->tpl_vars['dialog_tools_data']->value['help']&&$_smarty_tpl->tpl_vars['config']->value['Appearance']['enable_admin_context_help']=='Y') {?>
<table cellpadding="0" cellspacing="0" width="100%" class="dialog-tools-table">
<tr>
  <td>

  <div class="dialog-tools">

    <?php if ($_smarty_tpl->tpl_vars['left']->value||$_smarty_tpl->tpl_vars['right']->value) {?>
      <ul class="dialog-tools-header">
      <?php if ($_smarty_tpl->tpl_vars['left']->value) {?>
        <li class="dialog-header-left<?php if ($_smarty_tpl->tpl_vars['dialog_tools_data']->value['show']=="right") {?> dialog-tools-nonactive<?php }?>" onclick="javascript: dialog_tools_activate('left', 'right');">
        <?php if ($_smarty_tpl->tpl_vars['left']->value['title']) {
echo $_smarty_tpl->tpl_vars['left']->value['title'];
} else {
echo $_smarty_tpl->tpl_vars['lng']->value['lbl_in_this_section'];
}?>
        </li>
      <?php }?>
      <?php if ($_smarty_tpl->tpl_vars['right']->value) {?>
        <li class="dialog-header-right<?php if ($_smarty_tpl->tpl_vars['left']->value&&$_smarty_tpl->tpl_vars['dialog_tools_data']->value['show']!="right") {?> dialog-tools-nonactive<?php }?>" onclick="javascript: dialog_tools_activate('right', 'left');">
        <?php if ($_smarty_tpl->tpl_vars['right']->value['title']) {
echo $_smarty_tpl->tpl_vars['right']->value['title'];
} else {
echo $_smarty_tpl->tpl_vars['lng']->value['lbl_see_also'];
}?>
        </li>
      <?php }?>
      </ul>
    <?php } elseif ($_smarty_tpl->tpl_vars['dialog_tools_data']->value['help']&&$_smarty_tpl->tpl_vars['config']->value['Appearance']['enable_admin_context_help']=='Y') {?>
      
      <div class="dialog-tools-header"></div>
    <?php }?>

    <div class="clearing">&nbsp;</div>

    <div class="dialog-tools-box">

<?php if ($_smarty_tpl->tpl_vars['left']->value) {?>
<?php if ($_smarty_tpl->tpl_vars['left']->value['data']) {?>
<?php if (isset($_smarty_tpl->tpl_vars['left'])) {$_smarty_tpl->tpl_vars['left'] = clone $_smarty_tpl->tpl_vars['left'];
$_smarty_tpl->tpl_vars['left']->value = $_smarty_tpl->tpl_vars['left']->value['data']; $_smarty_tpl->tpl_vars['left']->nocache = null; $_smarty_tpl->tpl_vars['left']->scope = 0;
} else $_smarty_tpl->tpl_vars['left'] = new Smarty_variable($_smarty_tpl->tpl_vars['left']->value['data'], null, 0);?>
<?php }?>
      <ul class="dialog-tools-content dialog-tools-left<?php if ($_smarty_tpl->tpl_vars['dialog_tools_data']->value['show']=="right") {?> hidden<?php }?>">
<?php  $_smarty_tpl->tpl_vars['cell'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cell']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['left']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cell']->key => $_smarty_tpl->tpl_vars['cell']->value) {
$_smarty_tpl->tpl_vars['cell']->_loop = true;
?>
      <?php echo $_smarty_tpl->getSubTemplate ("dialog_tools_cell.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('cell'=>$_smarty_tpl->tpl_vars['cell']->value), 0);?>

<?php } ?>
      </ul>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['right']->value) {?>
<?php if ($_smarty_tpl->tpl_vars['right']->value['data']) {?>
<?php if (isset($_smarty_tpl->tpl_vars['right'])) {$_smarty_tpl->tpl_vars['right'] = clone $_smarty_tpl->tpl_vars['right'];
$_smarty_tpl->tpl_vars['right']->value = $_smarty_tpl->tpl_vars['right']->value['data']; $_smarty_tpl->tpl_vars['right']->nocache = null; $_smarty_tpl->tpl_vars['right']->scope = 0;
} else $_smarty_tpl->tpl_vars['right'] = new Smarty_variable($_smarty_tpl->tpl_vars['right']->value['data'], null, 0);?>
<?php }?>
      <ul class="dialog-tools-content dialog-tools-right<?php if ($_smarty_tpl->tpl_vars['left']->value&&$_smarty_tpl->tpl_vars['dialog_tools_data']->value['show']!="right") {?> hidden<?php }?>">
<?php  $_smarty_tpl->tpl_vars['cell'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cell']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['right']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cell']->key => $_smarty_tpl->tpl_vars['cell']->value) {
$_smarty_tpl->tpl_vars['cell']->_loop = true;
?>
      <?php echo $_smarty_tpl->getSubTemplate ("dialog_tools_cell.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('cell'=>$_smarty_tpl->tpl_vars['cell']->value), 0);?>

<?php } ?>
      </ul>
<?php }?>

    </div>

  </div>

  </td>
</tr>
</table>
<?php }?>
<?php }} ?>
