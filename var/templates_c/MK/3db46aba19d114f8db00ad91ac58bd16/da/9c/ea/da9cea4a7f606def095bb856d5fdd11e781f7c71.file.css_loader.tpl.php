<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:24
         compiled from "D:\website\MK\skin\common_files\widgets\css_loader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1813259ef31e8b043b2-09628650%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'da9cea4a7f606def095bb856d5fdd11e781f7c71' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\widgets\\css_loader.tpl',
      1 => 1496750500,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1813259ef31e8b043b2-09628650',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'css' => 0,
    'SkinDir' => 0,
    'eltype' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef31e8b28df2_30350812',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef31e8b28df2_30350812')) {function content_59ef31e8b28df2_30350812($_smarty_tpl) {?>



<?php if ($_smarty_tpl->tpl_vars['css']->value!='') {?>
<?php echo '<script'; ?>
 type="text/javascript">//<![CDATA[
  if (typeof xc_load_css !== 'undefined') {
    xc_load_css('<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['css']->value;?>
', '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['eltype']->value)===null||empty($tmp) ? "link" : $tmp);?>
');
  }
//]]><?php echo '</script'; ?>
>
<?php }?>
<?php }} ?>
