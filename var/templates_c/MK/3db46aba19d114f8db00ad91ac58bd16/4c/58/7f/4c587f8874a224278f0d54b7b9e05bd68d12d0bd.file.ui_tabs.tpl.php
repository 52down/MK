<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:10:35
         compiled from "D:\website\MK\skin\common_files\customer\main\ui_tabs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2351359ec527b707475-85161060%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4c587f8874a224278f0d54b7b9e05bd68d12d0bd' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\customer\\main\\ui_tabs.tpl',
      1 => 1496750420,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2351359ec527b707475-85161060',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'default_tab' => 0,
    'prefix' => 0,
    'tabs' => 0,
    'ind' => 0,
    'tab' => 0,
    'ti' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec527b71de50_12860053',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec527b71de50_12860053')) {function content_59ec527b71de50_12860053($_smarty_tpl) {?><?php if (!is_callable('smarty_function_inc')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.inc.php';
if (!is_callable('smarty_modifier_amp')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.amp.php';
if (!is_callable('smarty_modifier_wm_remove')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.wm_remove.php';
?>

<?php echo $_smarty_tpl->getSubTemplate ("jquery_ui_tabs.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[
$(function() {
  var default_tab = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['default_tab']->value)===null||empty($tmp) ? 0 : $tmp);?>
';
  var _storage_key_base = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['prefix']->value)===null||empty($tmp) ? "ui-tabs-" : $tmp);?>
';
  var _storage_key = _storage_key_base + xcart_web_dir;
  

  if (
    isLocalStorageSupported()
    && default_tab == '-1last_used_tab'
  ) {
    // Take into account EU cookie law
    var _used_storage = ('function' != typeof window.func_is_allowed_cookie || func_is_allowed_cookie(_storage_key_base)) ? localStorage : sessionStorage;
    var tOpts = {
      activate : function( event, ui ) {
          _used_storage[_storage_key] = ui.newTab.index();
      }
    };
    default_tab = parseInt(_used_storage[_storage_key]) || 0;
  } else {
    var tOpts = {};
    default_tab = parseInt(default_tab) || 0;
  }

  // Allow choose active tab by adding hash in URL, do not set 'active' in this way
  if (window.location.hash == '') {
    tOpts.active = default_tab;
  }

  

  $('#<?php echo $_smarty_tpl->tpl_vars['prefix']->value;?>
container').tabs(tOpts);
});
//]]>
<?php echo '</script'; ?>
>

<div id="<?php echo $_smarty_tpl->tpl_vars['prefix']->value;?>
container">

  <ul>
  <?php  $_smarty_tpl->tpl_vars['tab'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tab']->_loop = false;
 $_smarty_tpl->tpl_vars['ind'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['tabs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tab']->key => $_smarty_tpl->tpl_vars['tab']->value) {
$_smarty_tpl->tpl_vars['tab']->_loop = true;
 $_smarty_tpl->tpl_vars['ind']->value = $_smarty_tpl->tpl_vars['tab']->key;
?>
    <?php echo smarty_function_inc(array('value'=>$_smarty_tpl->tpl_vars['ind']->value,'assign'=>"ti"),$_smarty_tpl);?>

    <li><a href="<?php if ($_smarty_tpl->tpl_vars['tab']->value['url']) {
echo smarty_modifier_amp($_smarty_tpl->tpl_vars['tab']->value['url']);
} else { ?>#<?php echo $_smarty_tpl->tpl_vars['prefix']->value;
echo (($tmp = @$_smarty_tpl->tpl_vars['tab']->value['anchor'])===null||empty($tmp) ? $_smarty_tpl->tpl_vars['ti']->value : $tmp);
}?>"><?php echo htmlspecialchars(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['tab']->value['title']), ENT_QUOTES, 'UTF-8', true);?>
</a></li>
  <?php } ?>
  </ul>

  <?php  $_smarty_tpl->tpl_vars['tab'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tab']->_loop = false;
 $_smarty_tpl->tpl_vars['ind'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['tabs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tab']->key => $_smarty_tpl->tpl_vars['tab']->value) {
$_smarty_tpl->tpl_vars['tab']->_loop = true;
 $_smarty_tpl->tpl_vars['ind']->value = $_smarty_tpl->tpl_vars['tab']->key;
?>
    <?php if ($_smarty_tpl->tpl_vars['tab']->value['tpl']) {?>
      <?php echo smarty_function_inc(array('value'=>$_smarty_tpl->tpl_vars['ind']->value,'assign'=>"ti"),$_smarty_tpl);?>

      <div id="<?php echo $_smarty_tpl->tpl_vars['prefix']->value;
echo (($tmp = @$_smarty_tpl->tpl_vars['tab']->value['anchor'])===null||empty($tmp) ? $_smarty_tpl->tpl_vars['ti']->value : $tmp);?>
">
        <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['tab']->value['tpl'], $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('nodialog'=>true), 0);?>

      </div>
    <?php }?>
  <?php } ?>

</div>
<?php }} ?>
