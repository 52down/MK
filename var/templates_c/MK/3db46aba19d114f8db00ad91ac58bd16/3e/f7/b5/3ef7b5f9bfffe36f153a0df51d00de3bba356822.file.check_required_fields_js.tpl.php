<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:53
         compiled from "D:\website\MK\skin\common_files\check_required_fields_js.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1124459ef3205c0c5e9-23997383%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3ef7b5f9bfffe36f153a0df51d00de3bba356822' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\check_required_fields_js.tpl',
      1 => 1496750412,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1124459ef3205c0c5e9-23997383',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'SkinDir' => 0,
    'fillerror' => 0,
    'formname' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef3205c21c57_36164286',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef3205c21c57_36164286')) {function content_59ef3205c21c57_36164286($_smarty_tpl) {?>

<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/js/check_required_fields_js.js"><?php echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['fillerror']->value!='') {?>
  <?php echo $_smarty_tpl->getSubTemplate ("mark_required_fields_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('form'=>(($tmp = @$_smarty_tpl->tpl_vars['formname']->value)===null||empty($tmp) ? "registerform" : $tmp),'errfields'=>$_smarty_tpl->tpl_vars['fillerror']->value['fields']), 0);?>

<?php }?>
<?php }} ?>
