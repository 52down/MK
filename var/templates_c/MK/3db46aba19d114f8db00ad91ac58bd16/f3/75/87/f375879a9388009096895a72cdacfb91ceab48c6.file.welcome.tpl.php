<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:11:21
         compiled from "D:\website\MK\skin\MK\customer\main\welcome.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2220959ec52a91248f7-47855246%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f375879a9388009096895a72cdacfb91ceab48c6' => 
    array (
      0 => 'D:\\website\\MK\\skin\\MK\\customer\\main\\welcome.tpl',
      1 => 1508658579,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2220959ec52a91248f7-47855246',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'homepage' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec52a91292e0_89498397',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec52a91292e0_89498397')) {function content_59ec52a91292e0_89498397($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("customer/main/home_page_banner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php $_template = new XC_Smarty_Internal_Template('eval:'.$_smarty_tpl->tpl_vars['homepage']->value, $_smarty_tpl->smarty, $_smarty_tpl);echo $_template->fetch(); ?>
<?php }} ?>
