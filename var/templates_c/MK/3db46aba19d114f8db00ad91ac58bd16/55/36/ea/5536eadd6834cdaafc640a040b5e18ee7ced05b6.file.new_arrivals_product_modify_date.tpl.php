<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:52
         compiled from "D:\website\MK\skin\common_files\modules\New_Arrivals\new_arrivals_product_modify_date.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1261159ef3204d75c59-25175895%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5536eadd6834cdaafc640a040b5e18ee7ced05b6' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\modules\\New_Arrivals\\new_arrivals_product_modify_date.tpl',
      1 => 1496750464,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1261159ef3204d75c59-25175895',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'product' => 0,
    'lng' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef3204d8a3a5_94837077',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef3204d8a3a5_94837077')) {function content_59ef3204d8a3a5_94837077($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\modifier.date_format.php';
?>

<?php if ($_smarty_tpl->tpl_vars['product']->value['add_date']>0) {?>
  <br />
  <div>
    <span class="FormButton"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_added'];?>
:</span>&nbsp;<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['product']->value['add_date'],$_smarty_tpl->tpl_vars['config']->value['Appearance']['date_format']);?>

  </div>
<?php }?>
<?php }} ?>
