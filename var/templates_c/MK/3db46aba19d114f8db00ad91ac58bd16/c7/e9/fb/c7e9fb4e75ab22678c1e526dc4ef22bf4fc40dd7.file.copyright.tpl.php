<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:10:36
         compiled from "D:\website\MK\skin\common_files\copyright.tpl" */ ?>
<?php /*%%SmartyHeaderCode:717059ec527c267bb9-35997663%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c7e9fb4e75ab22678c1e526dc4ef22bf4fc40dd7' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\copyright.tpl',
      1 => 1496750412,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '717059ec527c267bb9-35997663',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lng' => 0,
    'config' => 0,
    'active_modules' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec527c271598_79794348',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec527c271598_79794348')) {function content_59ec527c271598_79794348($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\modifier.date_format.php';
?>
<?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_copyright'];?>
 &copy; <?php echo $_smarty_tpl->tpl_vars['config']->value['Company']['start_year'];
if ($_smarty_tpl->tpl_vars['config']->value['Company']['start_year']<$_smarty_tpl->tpl_vars['config']->value['Company']['end_year']) {?>-<?php echo smarty_modifier_date_format(XC_TIME,"%Y");
}?> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['config']->value['Company']['company_name'], ENT_QUOTES, 'UTF-8', true);?>


<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['XMultiCurrency']&&$_smarty_tpl->tpl_vars['config']->value['mc_geoip_service']=='maxmind_free') {?>
. <?php echo $_smarty_tpl->tpl_vars['lng']->value['mc_txt_maxmind_copyright'];?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Socialize']) {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/Socialize/footer_links.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<?php }} ?>
