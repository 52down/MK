<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:09:30
         compiled from "D:\website\MK\skin\common_files\modules\Special_Offers\menu_provider.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2391359ec523aae74b2-78652968%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9fdfee187d3cab587cd7021ebb503c96ba0de3e3' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\modules\\Special_Offers\\menu_provider.tpl',
      1 => 1496750478,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2391359ec523aae74b2-78652968',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'catalogs' => 0,
    'lng' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec523aae9898_51280343',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec523aae9898_51280343')) {function content_59ec523aae9898_51280343($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['provider'];?>
/offers.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_special_offers'];?>
</a>
<?php }} ?>
