<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:10:33
         compiled from "D:\website\MK\skin\common_files\main\service_header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:421559ec5279274251-00407187%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0deed689bfe88895943ce1051b1a5bbcb57b5960' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\service_header.tpl',
      1 => 1496750444,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '421559ec5279274251-00407187',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lng' => 0,
    'reading_direction_tag' => 0,
    'http_location' => 0,
    'ImagesDir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec52792c1930_66049956',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec52792c1930_66049956')) {function content_59ec52792c1930_66049956($_smarty_tpl) {?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php  $_config = new Smarty_Internal_Config(((string)$_smarty_tpl->tpl_vars['skin_config']->value), $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_site_title'];?>
</title>
  <?php echo $_smarty_tpl->getSubTemplate ("meta.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

  <?php echo $_smarty_tpl->getSubTemplate ("service_css.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body<?php echo $_smarty_tpl->tpl_vars['reading_direction_tag']->value;?>
>

<?php echo '<script'; ?>
 type="text/javascript" language="javascript">
//<![CDATA[
function refresh()
{
    window.scroll(0, 100000);

    setTimeout('refresh()', 1000);
}
function scrollDown()
{
    setTimeout('refresh()', 1000);
}
scrollDown();
//]]>
<?php echo '</script'; ?>
>

<div id="head-admin">

  <div id="logo-gray">
    <a href="<?php echo $_smarty_tpl->tpl_vars['http_location']->value;?>
/"><img src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/logo_gray.png" alt="" /></a>
  </div>

  <div class="clearing"></div>

</div>

<br />
<?php }} ?>
