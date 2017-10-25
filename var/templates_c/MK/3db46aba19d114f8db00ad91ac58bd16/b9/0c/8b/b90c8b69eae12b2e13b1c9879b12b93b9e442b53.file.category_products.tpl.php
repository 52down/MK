<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:48
         compiled from "D:\website\MK\skin\common_files\admin\main\category_products.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1455459ef32001c7103-98143857%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b90c8b69eae12b2e13b1c9879b12b93b9e442b53' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\admin\\main\\category_products.tpl',
      1 => 1496750406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1455459ef32001c7103-98143857',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lng' => 0,
    'current_category' => 0,
    'cat' => 0,
    'mode' => 0,
    'total_items' => 0,
    'first_item' => 0,
    'last_item' => 0,
    'products' => 0,
    'total_pages' => 0,
    'navigation_page' => 0,
    'navpage' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef32002a1080_80496090',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef32002a1080_80496090')) {function content_59ef32002a1080_80496090($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_wm_remove')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.wm_remove.php';
if (!is_callable('smarty_modifier_substitute')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.substitute.php';
?>
<?php echo $_smarty_tpl->getSubTemplate ("page_title.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_category_products']), 0);?>


<?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_category_products_top_text'];?>


<br /><br />

<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[
var txt_delete_products_warning = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['txt_delete_products_warning']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
";
//]]>
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_capture_stack[0][] = array('dialog', null, null); ob_start(); ?>

<?php echo $_smarty_tpl->getSubTemplate ("admin/main/location.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<table width="100%">

<tr>
<td align="center" class="TopLabel"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_current_category'];?>
: "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['current_category']->value['category'])===null||empty($tmp) ? $_smarty_tpl->tpl_vars['lng']->value['lbl_root_level'] : $tmp);?>
"
<?php if ($_smarty_tpl->tpl_vars['current_category']->value['avail']=="N") {?>
<div class="ErrorMessage"><?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_category_disabled'];?>
</div>
<?php }?>
</td>
</tr>

<tr>
<td align="right"><br />
<input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_modify_category']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: self.location='category_modify.php?cat=<?php echo $_smarty_tpl->tpl_vars['cat']->value;?>
'" />
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_delete_category']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: self.location='process_category.php?cat=<?php echo $_smarty_tpl->tpl_vars['cat']->value;?>
&amp;mode=delete'" />
</td>
</tr>

</table>

<br /><br />

<?php echo $_smarty_tpl->getSubTemplate ("main/subheader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_category_products']), 0);?>


<!-- SEARCH RESULTS SUMMARY -->

<?php if ($_smarty_tpl->tpl_vars['mode']->value=="search") {?>
<?php if ($_smarty_tpl->tpl_vars['total_items']->value>"1") {?>
<?php echo smarty_modifier_substitute($_smarty_tpl->tpl_vars['lng']->value['txt_N_results_found'],"items",$_smarty_tpl->tpl_vars['total_items']->value);?>
<br />
<?php echo smarty_modifier_substitute($_smarty_tpl->tpl_vars['lng']->value['txt_displaying_X_Y_results'],"first_item",$_smarty_tpl->tpl_vars['first_item']->value,"last_item",$_smarty_tpl->tpl_vars['last_item']->value);?>

<?php } elseif ($_smarty_tpl->tpl_vars['total_items']->value=="0") {?>
<br />
<div align="center"><?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_no_products_in_cat'];?>
</div>
<?php }?>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['products']->value) {?>

<!-- SEARCH RESULTS START -->

<br />

<?php if ($_smarty_tpl->tpl_vars['total_pages']->value>2) {?>
<?php if (isset($_smarty_tpl->tpl_vars["navpage"])) {$_smarty_tpl->tpl_vars["navpage"] = clone $_smarty_tpl->tpl_vars["navpage"];
$_smarty_tpl->tpl_vars["navpage"]->value = $_smarty_tpl->tpl_vars['navigation_page']->value; $_smarty_tpl->tpl_vars["navpage"]->nocache = null; $_smarty_tpl->tpl_vars["navpage"]->scope = 0;
} else $_smarty_tpl->tpl_vars["navpage"] = new Smarty_variable($_smarty_tpl->tpl_vars['navigation_page']->value, null, 0);?>
<?php }?>

<form action="process_product.php" method="post" name="processproductform">
<input type="hidden" name="section" value="category_products" />
<input type="hidden" name="mode" value="update" />
<input type="hidden" name="navpage" value="<?php echo $_smarty_tpl->tpl_vars['navpage']->value;?>
" />
<input type="hidden" name="cat" value="<?php echo $_smarty_tpl->tpl_vars['cat']->value;?>
" />

<table cellpadding="0" cellspacing="0" width="100%">

<tr>
<td>

<?php echo $_smarty_tpl->getSubTemplate ("main/navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php echo $_smarty_tpl->getSubTemplate ("main/products.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('products'=>$_smarty_tpl->tpl_vars['products']->value), 0);?>


<br />

<?php echo $_smarty_tpl->getSubTemplate ("main/navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<br />

<input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_delete_selected']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: if (checkMarks(this.form, new RegExp('productids\[[0-9]+\]', 'gi'))) if (confirm(txt_delete_products_warning)) submitForm(this, 'delete');" />
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_update']), ENT_QUOTES, 'UTF-8', true);?>
" />
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_modify_selected']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: if (checkMarks(this.form, new RegExp('productids\[[0-9]+\]', 'gi'))) { document.processproductform.action = 'product_modify.php'; submitForm(this, 'list'); }" />
<br /><br /><br />

<?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_operation_for_first_selected_only'];?>


<br /><br />

<input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_preview_product']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: if (checkMarks(this.form, new RegExp('productids\[[0-9]+\]', 'gi'))) submitForm(this, 'details');" />
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_clone_product']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: if (checkMarks(this.form, new RegExp('productids\[[0-9]+\]', 'gi'))) submitForm(this, 'clone');" />
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_generate_html_links']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: if (checkMarks(this.form, new RegExp('productids\[[0-9]+\]', 'gi'))) submitForm(this, 'links');" />

</td>
</tr>

</table>
</form>

<?php }?>

<br />

<input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_add_new_']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: self.location = 'product_modify.php?categoryid=<?php echo $_smarty_tpl->tpl_vars['cat']->value;?>
';" />

<br />

<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<?php echo $_smarty_tpl->getSubTemplate ("dialog.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_products'],'content'=>Smarty::$_smarty_vars['capture']['dialog'],'extra'=>'width="100%"'), 0);?>


<?php }} ?>
