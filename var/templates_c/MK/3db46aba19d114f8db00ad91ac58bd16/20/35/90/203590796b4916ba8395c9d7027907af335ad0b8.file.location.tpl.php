<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:24
         compiled from "D:\website\MK\skin\common_files\admin\main\location.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3233159ef31e858b820-93587162%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '203590796b4916ba8395c9d7027907af335ad0b8' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\admin\\main\\location.tpl',
      1 => 1496750406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3233159ef31e858b820-93587162',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'category_location' => 0,
    'cat' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef31e85ce645_66771834',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef31e85ce645_66771834')) {function content_59ef31e85ce645_66771834($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_amp')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.amp.php';
?>
<?php if ($_smarty_tpl->tpl_vars['category_location']->value&&$_smarty_tpl->tpl_vars['cat']->value!='') {?>
<div class="navigation-path">
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['position'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['position']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['position']['name'] = 'position';
$_smarty_tpl->tpl_vars['smarty']->value['section']['position']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['category_location']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['position']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['position']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['position']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['position']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['position']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['position']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['position']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['position']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['position']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['position']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['position']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['position']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['position']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['position']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['position']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['position']['total']);
if ($_smarty_tpl->tpl_vars['category_location']->value[$_smarty_tpl->getVariable('smarty')->value['section']['position']['index']][1]!='') {
if ($_smarty_tpl->getVariable('smarty')->value['section']['position']['last']) {?><span class="current"><?php } else { ?><a href="<?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['category_location']->value[$_smarty_tpl->getVariable('smarty')->value['section']['position']['index']][1]);?>
"><?php }
}
echo $_smarty_tpl->tpl_vars['category_location']->value[$_smarty_tpl->getVariable('smarty')->value['section']['position']['index']][0];
if ($_smarty_tpl->tpl_vars['category_location']->value[$_smarty_tpl->getVariable('smarty')->value['section']['position']['index']][1]!='') {
if ($_smarty_tpl->getVariable('smarty')->value['section']['position']['last']) {?></span><?php } else { ?></a><?php }
}
if ($_smarty_tpl->getVariable('smarty')->value['section']['position']['last']!="true") {?>&nbsp;/&nbsp;<?php }
endfor; endif; ?></div>
<br /><br />
<?php }?>
<?php }} ?>
