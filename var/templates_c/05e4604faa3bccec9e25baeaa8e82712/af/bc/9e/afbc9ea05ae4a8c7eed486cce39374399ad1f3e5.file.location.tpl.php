<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 09:48:38
         compiled from "D:\website\MK\skin\common_files\location.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2977359ec4d56de6ee5-06055519%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'afbc9ea05ae4a8c7eed486cce39374399ad1f3e5' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\location.tpl',
      1 => 1496750428,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2977359ec4d56de6ee5-06055519',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'location' => 0,
    'config' => 0,
    'lng' => 0,
    'alt_content' => 0,
    'newid' => 0,
    'alt_type' => 0,
    'image_none' => 0,
    'ImagesDir' => 0,
    'top_message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec4d56dfb177_33561764',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec4d56dfb177_33561764')) {function content_59ec4d56dfb177_33561764($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_amp')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.amp.php';
?>
<?php if ($_smarty_tpl->tpl_vars['location']->value!='') {?>

<div id="location">
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['position'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['position']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['position']['name'] = 'position';
$_smarty_tpl->tpl_vars['smarty']->value['section']['position']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['location']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
if ($_smarty_tpl->tpl_vars['location']->value[$_smarty_tpl->getVariable('smarty')->value['section']['position']['index']][1]!='') {?><a href="<?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['location']->value[$_smarty_tpl->getVariable('smarty')->value['section']['position']['index']][1]);?>
"><?php }?><span><?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['location']->value[$_smarty_tpl->getVariable('smarty')->value['section']['position']['index']][0]);?>
</span><?php if ($_smarty_tpl->tpl_vars['location']->value[$_smarty_tpl->getVariable('smarty')->value['section']['position']['index']][1]!='') {?></a><?php }
if (!$_smarty_tpl->getVariable('smarty')->value['section']['position']['last']) {?>&nbsp;<?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['config']->value['Appearance']['breadcrumbs_separator']);?>
&nbsp;<?php }
endfor; endif; ?>
</div>

<?php }?>

<!-- check javascript availability -->
<noscript>
  <table width="500" cellpadding="2" cellspacing="0" align="center">
  <tr>
    <td align="center" class="ErrorMessage"><?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_noscript_warning'];?>
</td>
  </tr>
  </table>
</noscript>

<?php if ($_smarty_tpl->tpl_vars['alt_content']->value) {?>
<table id="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['newid']->value)===null||empty($tmp) ? "dialog-message" : $tmp);?>
" width="100%">
<tr>
  <td>
    <div class="dialog-message">
      <div class="box message-<?php echo (($tmp = @$_smarty_tpl->tpl_vars['alt_type']->value)===null||empty($tmp) ? "I" : $tmp);?>
">

        <table width="100%">
        <tr>
<?php if ($_smarty_tpl->tpl_vars['image_none']->value!="Y") {?>
          <td width="50" valign="top">
            <img class="dialog-img" src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/spacer.gif" alt="" />
          </td>
<?php }?>
          <td align="left" valign="top">
            <?php echo $_smarty_tpl->tpl_vars['alt_content']->value;?>

          </td>
        </tr>
        </table>
      </div>
    </div>
  </td>
</tr>
</table>
<?php } elseif ($_smarty_tpl->tpl_vars['top_message']->value) {?>
  <?php echo $_smarty_tpl->getSubTemplate ("main/top_message.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<?php }} ?>