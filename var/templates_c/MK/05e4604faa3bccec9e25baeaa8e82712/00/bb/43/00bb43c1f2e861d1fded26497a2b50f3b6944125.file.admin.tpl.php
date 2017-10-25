<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 09:48:24
         compiled from "D:\website\MK\skin\common_files\modules\Cloud_Search\admin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:389659ec4d48b09bf6-91966101%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '00bb43c1f2e861d1fded26497a2b50f3b6944125' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\modules\\Cloud_Search\\admin.tpl',
      1 => 1496750452,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '389659ec4d48b09bf6-91966101',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'usertype' => 0,
    'SkinDir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec4d48b0d5f5_02834671',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec4d48b0d5f5_02834671')) {function content_59ec4d48b0d5f5_02834671($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['usertype']->value=='A'&&$_GET['option']=='Cloud_Search') {?>

<?php echo '<script'; ?>
 type="text/javascript" src="//cloudsearch.x-cart.com/static/cloud_search_xcart_admin.js">
<?php echo '</script'; ?>
>

<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/modules/Cloud_Search/admin.css" />

<?php }?>
<?php }} ?>
