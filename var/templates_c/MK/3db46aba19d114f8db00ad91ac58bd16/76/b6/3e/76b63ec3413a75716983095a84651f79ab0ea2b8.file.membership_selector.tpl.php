<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:54
         compiled from "D:\website\MK\skin\common_files\main\membership_selector.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2897959ef32069c7c85-33118846%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '76b63ec3413a75716983095a84651f79ab0ea2b8' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\membership_selector.tpl',
      1 => 1496750442,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2897959ef32069c7c85-33118846',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'field' => 0,
    'memberships' => 0,
    'size' => 0,
    'data' => 0,
    'lng' => 0,
    'v' => 0,
    'is_short' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef3206a8e480_07247698',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef3206a8e480_07247698')) {function content_59ef3206a8e480_07247698($_smarty_tpl) {?><?php if (!is_callable('smarty_function_count')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.count.php';
if (!is_callable('smarty_function_inc')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.inc.php';
?>
<?php if ($_smarty_tpl->tpl_vars['field']->value=='') {?>
  <?php if (isset($_smarty_tpl->tpl_vars["field"])) {$_smarty_tpl->tpl_vars["field"] = clone $_smarty_tpl->tpl_vars["field"];
$_smarty_tpl->tpl_vars["field"]->value = "membershipids[]"; $_smarty_tpl->tpl_vars["field"]->nocache = null; $_smarty_tpl->tpl_vars["field"]->scope = 0;
} else $_smarty_tpl->tpl_vars["field"] = new Smarty_variable("membershipids[]", null, 0);?>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars["size"])) {$_smarty_tpl->tpl_vars["size"] = clone $_smarty_tpl->tpl_vars["size"];
$_smarty_tpl->tpl_vars["size"]->value = 1; $_smarty_tpl->tpl_vars["size"]->nocache = null; $_smarty_tpl->tpl_vars["size"]->scope = 0;
} else $_smarty_tpl->tpl_vars["size"] = new Smarty_variable(1, null, 0);?>

<?php if ($_smarty_tpl->tpl_vars['memberships']->value) {?>
  <?php echo smarty_function_count(array('assign'=>"size",'value'=>$_smarty_tpl->tpl_vars['memberships']->value,'print'=>false),$_smarty_tpl);?>

  <?php echo smarty_function_inc(array('assign'=>"size",'value'=>$_smarty_tpl->tpl_vars['size']->value),$_smarty_tpl);?>


  <?php if ($_smarty_tpl->tpl_vars['size']->value>5) {?>
    <?php if (isset($_smarty_tpl->tpl_vars["size"])) {$_smarty_tpl->tpl_vars["size"] = clone $_smarty_tpl->tpl_vars["size"];
$_smarty_tpl->tpl_vars["size"]->value = 5; $_smarty_tpl->tpl_vars["size"]->nocache = null; $_smarty_tpl->tpl_vars["size"]->scope = 0;
} else $_smarty_tpl->tpl_vars["size"] = new Smarty_variable(5, null, 0);?>
  <?php }?>

<?php }?>

<select name="<?php echo $_smarty_tpl->tpl_vars['field']->value;?>
" multiple="multiple" size="<?php echo $_smarty_tpl->tpl_vars['size']->value;?>
">
  <option value="-1"<?php if ((($tmp = @$_smarty_tpl->tpl_vars['data']->value['membershipids'])===null||empty($tmp) ? '' : $tmp)==''||($_smarty_tpl->tpl_vars['data']->value['membershipids'][0]!='')) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_all'];?>
</option>
  <?php if ($_smarty_tpl->tpl_vars['memberships']->value) {?>
    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['memberships']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['membershipid'];?>
"<?php if ((($tmp = @$_smarty_tpl->tpl_vars['data']->value['membershipids'])===null||empty($tmp) ? '' : $tmp)!=''&&$_smarty_tpl->tpl_vars['data']->value['membershipids'][$_smarty_tpl->tpl_vars['v']->value['membershipid']]!='') {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['membership'];?>
</option>
    <?php } ?>
  <?php }?>
</select>
<?php if ($_smarty_tpl->tpl_vars['is_short']->value!='Y') {?>
  <p><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_hold_ctrl_key'];?>
</p>
<?php }?>
<?php }} ?>
