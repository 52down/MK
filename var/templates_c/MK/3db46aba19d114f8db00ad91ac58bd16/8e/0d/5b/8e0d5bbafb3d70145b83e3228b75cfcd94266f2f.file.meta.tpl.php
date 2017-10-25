<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:27:32
         compiled from "D:\website\MK\skin\MK\customer\meta.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1262759ec52a7b3f7e8-72707853%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8e0d5bbafb3d70145b83e3228b75cfcd94266f2f' => 
    array (
      0 => 'D:\\website\\MK\\skin\\MK\\customer\\meta.tpl',
      1 => 1508660850,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1262759ec52a7b3f7e8-72707853',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec52a7b8b918_51740916',
  'variables' => 
  array (
    'default_charset' => 0,
    'shop_language' => 0,
    'printable' => 0,
    'meta_page_type' => 0,
    'meta_page_id' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec52a7b8b918_51740916')) {function content_59ec52a7b8b918_51740916($_smarty_tpl) {?><?php if (!is_callable('smarty_function_meta')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.meta.php';
?>
  <meta http-equiv="Content-Type" content="text/html; charset=<?php echo (($tmp = @$_smarty_tpl->tpl_vars['default_charset']->value)===null||empty($tmp) ? "utf-8" : $tmp);?>
" />
  <meta http-equiv="X-UA-Compatible" content="<?php echo $_smarty_tpl->getConfigVariable('XUACompatible');?>
" />
  <meta http-equiv="Content-Script-Type" content="text/javascript" />
  <meta http-equiv="Content-Style-Type" content="text/css" />
  <meta http-equiv="Content-Language" content="<?php echo $_smarty_tpl->tpl_vars['shop_language']->value;?>
" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
<?php if ($_smarty_tpl->tpl_vars['printable']->value) {?>
  <meta name="ROBOTS" content="NOINDEX,NOFOLLOW" />
<?php } else { ?>
  <?php echo smarty_function_meta(array('type'=>'description','page_type'=>$_smarty_tpl->tpl_vars['meta_page_type']->value,'page_id'=>$_smarty_tpl->tpl_vars['meta_page_id']->value),$_smarty_tpl);?>

  <?php echo smarty_function_meta(array('type'=>'keywords','page_type'=>$_smarty_tpl->tpl_vars['meta_page_type']->value,'page_id'=>$_smarty_tpl->tpl_vars['meta_page_id']->value),$_smarty_tpl);?>

<?php }?><?php }} ?>
