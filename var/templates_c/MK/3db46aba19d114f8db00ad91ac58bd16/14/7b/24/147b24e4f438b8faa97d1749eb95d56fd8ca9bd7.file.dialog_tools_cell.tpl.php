<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:24
         compiled from "D:\website\MK\skin\common_files\dialog_tools_cell.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1112259ef31e8d4d8a7-38765003%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '147b24e4f438b8faa97d1749eb95d56fd8ca9bd7' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\dialog_tools_cell.tpl',
      1 => 1496750424,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1112259ef31e8d4d8a7-38765003',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cell' => 0,
    'ImagesDir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef31e8d66c78_62944869',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef31e8d66c78_62944869')) {function content_59ef31e8d66c78_62944869($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_amp')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.amp.php';
?>
<?php if ($_smarty_tpl->tpl_vars['cell']->value['separator']) {?>
<li class="dialog-cell-separator"><img src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/spacer.gif" alt="" /></li>
<?php } else { ?>
<li>
  <a class="dialog-cell<?php if ($_smarty_tpl->tpl_vars['cell']->value['style']=="hl") {?>-hl<?php }?>" href="<?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['cell']->value['link']);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cell']->value['title'], ENT_QUOTES, 'UTF-8', true);?>
"<?php if ($_smarty_tpl->tpl_vars['cell']->value['target']!='') {?> target="<?php echo $_smarty_tpl->tpl_vars['cell']->value['target'];?>
"<?php }?>>
    <?php echo $_smarty_tpl->tpl_vars['cell']->value['title'];?>

  </a>
</li>
<?php }?>
<?php }} ?>
