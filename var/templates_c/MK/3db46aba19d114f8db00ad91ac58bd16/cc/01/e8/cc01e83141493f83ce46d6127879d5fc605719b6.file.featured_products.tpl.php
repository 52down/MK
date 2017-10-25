<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:24
         compiled from "D:\website\MK\skin\common_files\admin\main\featured_products.tpl" */ ?>
<?php /*%%SmartyHeaderCode:176659ef31e8792948-19938977%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cc01e83141493f83ce46d6127879d5fc605719b6' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\admin\\main\\featured_products.tpl',
      1 => 1496750406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '176659ef31e8792948-19938977',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lng' => 0,
    'products' => 0,
    'f_cat' => 0,
    'catalogs' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef31e88901c2_59367122',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef31e88901c2_59367122')) {function content_59ef31e88901c2_59367122($_smarty_tpl) {?><?php if (!is_callable('smarty_function_get_ajax_session_quick_key')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.get_ajax_session_quick_key.php';
if (!is_callable('smarty_function_load_defer')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer.php';
if (!is_callable('smarty_function_cycle')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\function.cycle.php';
?>
<?php $_smarty_tpl->_capture_stack[0][] = array('js_ajax_search_by_sku_fields', null, null); ob_start(); ?>
  var autocomplete_field_selector = "#newproduct_ids";
  var js_ajax_session_quick_key = "<?php ob_start();?><?php echo smarty_function_get_ajax_session_quick_key(array(),$_smarty_tpl);?>
<?php echo strtr(ob_get_clean(), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ))?>";
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<?php echo smarty_function_load_defer(array('file'=>"js_ajax_search_by_sku_fields",'direct_info'=>Smarty::$_smarty_vars['capture']['js_ajax_search_by_sku_fields'],'type'=>"js"),$_smarty_tpl);?>


<?php echo $_smarty_tpl->getSubTemplate ("jquery_ui_autocomplete.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo smarty_function_load_defer(array('file'=>"js/popup_product.js",'type'=>"js"),$_smarty_tpl);?>


<a name="featured"></a>

<?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_featured_products'];?>


<br /><br />

<?php $_smarty_tpl->_capture_stack[0][] = array('dialog', null, null); ob_start(); ?>

<?php if ($_smarty_tpl->tpl_vars['products']->value!='') {?>
<?php echo $_smarty_tpl->getSubTemplate ("main/check_all_row.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('style'=>"line-height: 170%;",'form'=>"featuredproductsform",'prefix'=>"posted_data.+to_delete"), 0);?>

<?php }?>

<form action="categories.php" method="post" name="featuredproductsform">
<input type="hidden" name="mode" value="update" />
<input type="hidden" name="cat" value="<?php echo $_smarty_tpl->tpl_vars['f_cat']->value;?>
" />

<table cellpadding="3" cellspacing="1" width="100%">

<tr class="TableHead">
  <td width="10">&nbsp;</td>
  <td width="10%"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_sku'];?>
</td>
  <td width="70%"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_product_name'];?>
</td>
  <td width="15%" align="center"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_pos'];?>
</td>
  <td width="5%" align="center"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_active'];?>
</td>
</tr>

<?php if ($_smarty_tpl->tpl_vars['products']->value) {?>

<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['name'] = 'prod_num';
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['products']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['prod_num']['total']);
?>

<tr<?php echo smarty_function_cycle(array('values'=>", class='TableSubHead'"),$_smarty_tpl);?>
>
  <td><input type="checkbox" name="posted_data[<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod_num']['index']]['productid'];?>
][to_delete]" /></td>
  <td><b><a href="product_modify.php?productid=<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod_num']['index']]['productid'];?>
"><?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod_num']['index']]['productcode'];?>
</a></b></td>
  <td><b><a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['customer'];?>
/product.php?productid=<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod_num']['index']]['productid'];?>
&amp;is_admin_preview=Y" target="_blank"><?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod_num']['index']]['product'];?>
</a></b></td>
  <td align="center"><input type="text" name="posted_data[<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod_num']['index']]['productid'];?>
][product_order]" size="5" value="<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod_num']['index']]['product_order'];?>
" /></td>
  <td align="center"><input type="checkbox" name="posted_data[<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod_num']['index']]['productid'];?>
][avail]"<?php if ($_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod_num']['index']]['avail']=="Y") {?> checked="checked"<?php }?> /></td>
</tr>

<?php endfor; endif; ?>

<tr>
  <td colspan="5" class="SubmitBox">
  <input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_delete_selected']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: if (checkMarks(this.form, new RegExp('posted_data\\[[0-9]+\\]\\[to_delete\\]', 'ig'))) {document.featuredproductsform.mode.value = 'delete'; document.featuredproductsform.submit();}" />
  <input type="submit" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_update']), ENT_QUOTES, 'UTF-8', true);?>
" />
  </td>
</tr>

<?php } else { ?>

<tr>
<td colspan="5" align="center"><?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_no_featured_products'];?>
</td>
</tr>

<?php }?>

</table>
</form>

<form action="categories.php" method="post" name="add_featuredproductsform">
<input type="hidden" name="mode" value="add" />
<input type="hidden" name="cat" value="<?php echo $_smarty_tpl->tpl_vars['f_cat']->value;?>
" />

<table cellpadding="3" cellspacing="1" width="100%">

<tr>
<td colspan="5"><br /><br /><?php echo $_smarty_tpl->getSubTemplate ("main/subheader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_add_product']), 0);?>
</td>
</tr>

<tr>
  <td colspan="3">
    <input type="hidden" name="newproductid" />
    <input name="newproduct_ids" id="newproduct_ids" size="64" placeholder="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_enter_skus']), ENT_QUOTES, 'UTF-8', true);?>
" />
    <input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_browse_']), ENT_QUOTES, 'UTF-8', true);?>
" tabindex="-1" onclick="javascript: popup_product('add_featuredproductsform.newproductid', 'add_featuredproductsform.newproduct_ids');" />
  </td>
  <td align="center"><input type="text" name="neworder" size="5" /></td>
  <td align="center"><input type="checkbox" name="newavail" checked="checked" /></td>
</tr>

<tr>
  <td colspan="5" class="SubmitBox">
  <input type="submit" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_add_new']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: document.add_featuredproductsform.mode.value = 'add'; document.add_featuredproductsform.submit();"/>
  </td>
</tr>

</table>
</form>

<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<?php echo $_smarty_tpl->getSubTemplate ("dialog.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_featured_products'],'content'=>Smarty::$_smarty_vars['capture']['dialog'],'extra'=>'width="100%"'), 0);?>

<?php }} ?>
