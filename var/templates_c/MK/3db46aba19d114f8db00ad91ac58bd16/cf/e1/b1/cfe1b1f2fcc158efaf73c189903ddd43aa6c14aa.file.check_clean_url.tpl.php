<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:53
         compiled from "D:\website\MK\skin\common_files\check_clean_url.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1235059ef3205a98c51-81181053%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cfe1b1f2fcc158efaf73c189903ddd43aa6c14aa' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\check_clean_url.tpl',
      1 => 1496750412,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1235059ef3205a98c51-81181053',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lng' => 0,
    'clean_url_validation_regexp' => 0,
    'config' => 0,
    'SkinDir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef3205ac5751_68371744',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef3205ac5751_68371744')) {function content_59ef3205ac5751_68371744($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_wm_remove')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.wm_remove.php';
if (!is_callable('smarty_modifier_replace')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\modifier.replace.php';
?>
<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[
var err_clean_url_wrong_format = "<?php echo smarty_modifier_replace(smarty_modifier_replace(strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['err_clean_url_wrong_format']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" )),"\n"," "),"\r"," ");?>
";
var clean_url_validation_regexp = new RegExp("<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['clean_url_validation_regexp']->value), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
", "g");
var js_clean_urls_lowercase = <?php if ($_smarty_tpl->tpl_vars['config']->value['SEO']['clean_urls_lowercase']=='Y') {?>true<?php } else { ?>false<?php }?>;
//]]>
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/js/check_clean_url.js"><?php echo '</script'; ?>
>
<?php }} ?>
