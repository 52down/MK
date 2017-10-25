<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:54
         compiled from "D:\website\MK\skin\common_files\main\clean_urls.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2804759ef3206ecb8b8-98836636%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd1be4e26f370abeef387a45a5310a2972260c7a8' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\clean_urls.tpl',
      1 => 1496750440,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2804759ef3206ecb8b8-98836636',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'clean_urls_history' => 0,
    'k' => 0,
    'config' => 0,
    'clean_url_action' => 0,
    'resource_name' => 0,
    'resource_id' => 0,
    'clean_urls_history_mode' => 0,
    'lng' => 0,
    'kurl' => 0,
    'url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef3206f06ab0_81415909',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef3206f06ab0_81415909')) {function content_59ef3206f06ab0_81415909($_smarty_tpl) {?><?php if (!is_callable('smarty_function_cycle')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\function.cycle.php';
?>

<?php if ($_smarty_tpl->tpl_vars['clean_urls_history']->value) {?>

  <?php echo $_smarty_tpl->getSubTemplate ("check_clean_url.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


  <a name="clean_url_history"></a>

  <?php $_smarty_tpl->_capture_stack[0][] = array('dialog', null, null); ob_start(); ?>

  <?php echo '<script'; ?>
 type="text/javascript" language="JavaScript 1.2">//<![CDATA[
  var clean_urls_history = new Array(<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['clean_urls_history']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>'clean_urls_history[<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
]',<?php } ?>'');
  //]]><?php echo '</script'; ?>
>

  <?php if ($_smarty_tpl->tpl_vars['config']->value['SEO']['clean_urls_enabled']=="Y") {?>
    <form action="<?php echo $_smarty_tpl->tpl_vars['clean_url_action']->value;?>
" method="post" name="clean_urls_history_form">
    <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['resource_name']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['resource_id']->value;?>
" />
    <input type="hidden" name="mode" value="<?php echo $_smarty_tpl->tpl_vars['clean_urls_history_mode']->value;?>
" />
    <?php echo $_smarty_tpl->getSubTemplate ("main/check_all_row.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('style'=>"line-height: 170%;",'form'=>"clean_urls_history_form",'prefix'=>"clean_urls_history"), 0);?>

  <?php }?>

  <table cellpadding="2" cellspacing="1" border="0">
    <tr class="TableHead">
      <?php if ($_smarty_tpl->tpl_vars['config']->value['SEO']['clean_urls_enabled']=="Y") {?>
        <th width="15">&nbsp;</th>
      <?php }?>
      <th><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_clean_url_value'];?>
</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['url'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['url']->_loop = false;
 $_smarty_tpl->tpl_vars['kurl'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['clean_urls_history']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['url']->key => $_smarty_tpl->tpl_vars['url']->value) {
$_smarty_tpl->tpl_vars['url']->_loop = true;
 $_smarty_tpl->tpl_vars['kurl']->value = $_smarty_tpl->tpl_vars['url']->key;
?>
      <tr<?php echo smarty_function_cycle(array('values'=>" , class='TableSubHead'"),$_smarty_tpl);?>
>
        <?php if ($_smarty_tpl->tpl_vars['config']->value['SEO']['clean_urls_enabled']=="Y") {?>
          <td valign="top"><input type="checkbox" name="clean_urls_history[<?php echo $_smarty_tpl->tpl_vars['kurl']->value;?>
]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['kurl']->value, ENT_QUOTES, 'UTF-8', true);?>
" /></td>
        <?php }?>
        <td valign="top" width="300"><?php echo $_smarty_tpl->tpl_vars['url']->value;?>
</td>
      </tr>
    <?php } ?>
    <?php if ($_smarty_tpl->tpl_vars['config']->value['SEO']['clean_urls_enabled']=="Y") {?>
      <tr>
        <td colspan="2">
          <input type="button" value="<?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_delete_selected'];?>
" onclick="javascript: if (checkMarks(this.form, new RegExp('clean_urls_history', 'ig'))) document.clean_urls_history_form.submit();" />
        </td>
      </tr>
    <?php }?>
  </table>
  <?php if ($_smarty_tpl->tpl_vars['config']->value['SEO']['clean_urls_enabled']=="Y") {?>
    </form>
  <?php }?>
  <?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
  <?php echo $_smarty_tpl->getSubTemplate ("dialog.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_clean_url_history'],'content'=>Smarty::$_smarty_vars['capture']['dialog'],'extra'=>'width="100%"'), 0);?>

<?php }?>
<?php }} ?>
