<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:09:31
         compiled from "D:\website\MK\skin\common_files\bottom.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1523159ec523b980bf0-03745448%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '481273d693c1f82e7ac4717b0df87c6af5a33a60' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\bottom.tpl',
      1 => 1496750410,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1523159ec523b980bf0-03745448',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'active_modules' => 0,
    'login' => 0,
    'all_languages_cnt' => 0,
    'php_url' => 0,
    'lng' => 0,
    'all_languages' => 0,
    'l' => 0,
    'current_language' => 0,
    'ImagesDir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec523b98b2f5_97826694',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec523b98b2f5_97826694')) {function content_59ec523b98b2f5_97826694($_smarty_tpl) {?>
<table width="100%" cellpadding="0" cellspacing="0">

<?php if (($_smarty_tpl->tpl_vars['active_modules']->value['Users_online']!='')||($_smarty_tpl->tpl_vars['login']->value&&$_smarty_tpl->tpl_vars['all_languages_cnt']->value>1)) {?>
<tr>
  <td>
  <table width="100%">
    <tr>

      <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Users_online']!='') {?>
        <td class="users-online-box">
          <?php echo $_smarty_tpl->getSubTemplate ("modules/Users_online/menu_users_online.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        </td>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['login']->value&&$_smarty_tpl->tpl_vars['all_languages_cnt']->value>1) {?>
      <td class="admin-language">
        <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8', true);?>
" method="post" name="asl_form">
          <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['php_url']->value['query_string'], ENT_QUOTES, 'UTF-8', true);?>
" />
          <?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_language'];?>
:
          <select name="asl" onchange="javascript: document.asl_form.submit()">
          <?php  $_smarty_tpl->tpl_vars['l'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['l']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['all_languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['l']->key => $_smarty_tpl->tpl_vars['l']->value) {
$_smarty_tpl->tpl_vars['l']->_loop = true;
?>
          <option value="<?php echo $_smarty_tpl->tpl_vars['l']->value['code'];?>
"<?php if ($_smarty_tpl->tpl_vars['current_language']->value==$_smarty_tpl->tpl_vars['l']->value['code']) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['l']->value['language'];?>
</option>
          <?php } ?>
          </select>
        </form>
      </td>
      <?php }?>

      </tr>
    </table>
  </td>
</tr>
<?php }?>

<tr>
  <td class="HeadThinLine">
    <img src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/spacer.gif" class="Spc" alt="" />
  </td>
</tr>

<tr>
  <td class="BottomBox">
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="Bottom" align="left">
          <?php echo $_smarty_tpl->getSubTemplate ("main/prnotice.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        </td>
        <td class="Bottom" align="right">
          <?php echo $_smarty_tpl->getSubTemplate ("copyright.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        </td>
      </tr>
    </table>
  </td>
</tr>

</table>
<?php }} ?>
