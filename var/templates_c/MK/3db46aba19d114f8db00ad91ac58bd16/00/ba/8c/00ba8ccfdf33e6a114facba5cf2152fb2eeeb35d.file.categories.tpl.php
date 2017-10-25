<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:23
         compiled from "D:\website\MK\skin\common_files\admin\main\categories.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2127459ef31e7b88325-33342559%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '00ba8ccfdf33e6a114facba5cf2152fb2eeeb35d' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\admin\\main\\categories.tpl',
      1 => 1496750406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2127459ef31e7b88325-33342559',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lng' => 0,
    'cat' => 0,
    'current_category' => 0,
    'active_modules' => 0,
    'categories' => 0,
    'catid' => 0,
    'c' => 0,
    'cat_selected' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef31e82c98a0_30440421',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef31e82c98a0_30440421')) {function content_59ef31e82c98a0_30440421($_smarty_tpl) {?><?php if (!is_callable('smarty_function_cycle')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\function.cycle.php';
?>
<?php echo $_smarty_tpl->getSubTemplate ("page_title.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_categories_management']), 0);?>


<br />

<?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_categories_management_top_text'];?>


<br /><br />

<?php $_smarty_tpl->_capture_stack[0][] = array('dialog', null, null); ob_start(); ?>
<a name="Categories"></a>
<?php echo $_smarty_tpl->getSubTemplate ("admin/main/location.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php if ($_smarty_tpl->tpl_vars['cat']->value) {?>

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
<td align="right" class="SubmitBox">
<input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_modify_category']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: self.location='category_modify.php?cat=<?php echo $_smarty_tpl->tpl_vars['cat']->value;?>
'" />
<input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_category_products']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: self.location='category_products.php?cat=<?php echo $_smarty_tpl->tpl_vars['cat']->value;?>
'" />
<input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_delete_category']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: self.location='process_category.php?cat=<?php echo $_smarty_tpl->tpl_vars['cat']->value;?>
&amp;mode=delete'" />
</td>
</tr>

</table>

<br /><br />

<?php echo $_smarty_tpl->getSubTemplate ("main/subheader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['txt_list_of_subcategories']), 0);?>


<?php }?>

<br />

<form action="process_category.php" method="post" name="processcategoryform" id="processcategoryform" >
<input type="hidden" name="cat_org" value="<?php echo htmlspecialchars($_GET['cat'], ENT_QUOTES, 'UTF-8', true);?>
" />

<table cellpadding="2" cellspacing="1" width="100%">

<tr class="TableHead">
  <td><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_pos'];?>
</td>
  <td colspan="2"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_category_name'];?>
</td>
  <td align="center"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_products'];?>
*</td>
  <td align="center"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_subcategories'];?>
</td>
  <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['New_Arrivals']) {?>
    <?php echo $_smarty_tpl->getSubTemplate ("modules/New_Arrivals/new_arrivals_categories_selector.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('is_header'=>"Y",'is_list'=>"Y"), 0);?>

  <?php }?>
  <td align="center"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_enabled'];?>
</td>
</tr>

<?php if (isset($_smarty_tpl->tpl_vars["cat_selected"])) {$_smarty_tpl->tpl_vars["cat_selected"] = clone $_smarty_tpl->tpl_vars["cat_selected"];
$_smarty_tpl->tpl_vars["cat_selected"]->value = 0; $_smarty_tpl->tpl_vars["cat_selected"]->nocache = null; $_smarty_tpl->tpl_vars["cat_selected"]->scope = 0;
} else $_smarty_tpl->tpl_vars["cat_selected"] = new Smarty_variable(0, null, 0);?>
<?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_smarty_tpl->tpl_vars['catid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value) {
$_smarty_tpl->tpl_vars['c']->_loop = true;
 $_smarty_tpl->tpl_vars['catid']->value = $_smarty_tpl->tpl_vars['c']->key;
?>

<tr<?php echo smarty_function_cycle(array('values'=>', class="TableSubHead"'),$_smarty_tpl);?>
>
  <td width="1%"><input type="text" size="3" name="posted_data[<?php echo $_smarty_tpl->tpl_vars['catid']->value;?>
][order_by]" maxlength="3" value="<?php echo $_smarty_tpl->tpl_vars['c']->value['order_by'];?>
" /></td>
  <td width="1%"><input type="radio" name="cat" value="<?php echo $_smarty_tpl->tpl_vars['catid']->value;?>
"<?php if ($_smarty_tpl->tpl_vars['cat_selected']->value==0) {?> checked="checked"<?php }?> /></td>
  <td><a href="categories.php?cat=<?php echo $_smarty_tpl->tpl_vars['catid']->value;?>
"><font class="<?php if ($_smarty_tpl->tpl_vars['c']->value['avail']=="N") {?>ItemsListDisabled<?php } else { ?>ItemsList<?php }?>"><?php echo $_smarty_tpl->tpl_vars['c']->value['category'];?>
</font></a></td>
  <td align="center">
<?php if ($_smarty_tpl->tpl_vars['c']->value['product_count']==0&&$_smarty_tpl->tpl_vars['c']->value['product_count_global']==0) {?>
<?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_not_available'];?>

<?php } else { ?>
<a href="category_products.php?cat=<?php echo $_smarty_tpl->tpl_vars['catid']->value;?>
"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['c']->value['product_count'])===null||empty($tmp) ? $_smarty_tpl->tpl_vars['lng']->value['txt_not_available'] : $tmp);?>
</a> (<?php echo $_smarty_tpl->tpl_vars['c']->value['product_count_global'];?>
)
<?php }?>
  </td>
  <td align="center"><a href="categories.php?cat=<?php echo $_smarty_tpl->tpl_vars['catid']->value;?>
"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['c']->value['subcategory_count'])===null||empty($tmp) ? $_smarty_tpl->tpl_vars['lng']->value['txt_not_available'] : $tmp);?>
</a></td>
  <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['New_Arrivals']) {?>
    <?php echo $_smarty_tpl->getSubTemplate ("modules/New_Arrivals/new_arrivals_categories_selector.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('category'=>$_smarty_tpl->tpl_vars['c']->value,'categoryid'=>$_smarty_tpl->tpl_vars['catid']->value,'is_list'=>"Y"), 0);?>

  <?php }?>
  <td align="center">
  <select name="posted_data[<?php echo $_smarty_tpl->tpl_vars['catid']->value;?>
][avail]">
    <option value="Y"<?php if ($_smarty_tpl->tpl_vars['c']->value['avail']=="Y") {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_yes'];?>
</option>
    <option value="N"<?php if ($_smarty_tpl->tpl_vars['c']->value['avail']=="N") {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_no'];?>
</option>
  </select>
  </td>
</tr>

<?php if (isset($_smarty_tpl->tpl_vars["cat_selected"])) {$_smarty_tpl->tpl_vars["cat_selected"] = clone $_smarty_tpl->tpl_vars["cat_selected"];
$_smarty_tpl->tpl_vars["cat_selected"]->value = 1; $_smarty_tpl->tpl_vars["cat_selected"]->nocache = null; $_smarty_tpl->tpl_vars["cat_selected"]->scope = 0;
} else $_smarty_tpl->tpl_vars["cat_selected"] = new Smarty_variable(1, null, 0);?>

<?php }
if (!$_smarty_tpl->tpl_vars['c']->_loop) {
?>

<tr>
  <td colspan="6" align="center"><?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_no_categories'];?>
</td>
</tr>

<?php } ?>

<?php if ($_smarty_tpl->tpl_vars['categories']->value) {?>
<tr>
  <td colspan="6">
<b>*<?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_note'];?>
:</b> <?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_categories_management_note'];?>

  </td>
</tr>
<tr>
  <td colspan="6" class="SubmitBox">
<input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_update']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: submitForm(this, 'apply');" />
<br /><br />
<input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_modify_selected']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: submitForm(this, 'update');" />
<input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_delete_selected']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: submitForm(this, 'delete');" />
  </td>
</tr>
<?php }?>

<tr>
  <td colspan="6" class="SubmitBox"><input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_add_new_']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="self.location='category_modify.php?mode=add&amp;cat=<?php echo $_smarty_tpl->tpl_vars['cat']->value;?>
'" /></td>
</tr>

</table>

<input type="hidden" name="mode" value="apply" />
</form>

<br />

<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<?php echo $_smarty_tpl->getSubTemplate ("dialog.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_categories'],'content'=>Smarty::$_smarty_vars['capture']['dialog'],'extra'=>'width="100%"'), 0);?>


<br /><br />

<?php echo $_smarty_tpl->getSubTemplate ("admin/main/featured_products.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php }} ?>
