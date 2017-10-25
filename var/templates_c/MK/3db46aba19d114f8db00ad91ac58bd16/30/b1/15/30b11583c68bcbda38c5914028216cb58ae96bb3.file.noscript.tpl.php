<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:11:20
         compiled from "D:\website\MK\skin\common_files\customer\noscript.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1705059ec52a8a61121-15533641%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '30b11583c68bcbda38c5914028216cb58ae96bb3' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\customer\\noscript.tpl',
      1 => 1496750422,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1705059ec52a8a61121-15533641',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content' => 0,
    'lng' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec52a8a62fd9_09406392',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec52a8a62fd9_09406392')) {function content_59ec52a8a62fd9_09406392($_smarty_tpl) {?>
<noscript>
  <div class="noscript-warning">
    <div class="content"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['content']->value)===null||empty($tmp) ? $_smarty_tpl->tpl_vars['lng']->value['txt_noscript_warning'] : $tmp);?>
</div>
  </div>
</noscript>
<?php }} ?>
