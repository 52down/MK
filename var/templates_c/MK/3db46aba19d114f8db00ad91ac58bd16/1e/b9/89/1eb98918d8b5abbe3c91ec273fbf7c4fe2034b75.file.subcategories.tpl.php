<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 11:20:40
         compiled from "D:\website\MK\skin\common_files\customer\main\subcategories.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2942959ec62e8d08fb5-12455096%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1eb98918d8b5abbe3c91ec273fbf7c4fe2034b75' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\customer\\main\\subcategories.tpl',
      1 => 1496750420,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2942959ec62e8d08fb5-12455096',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'active_modules' => 0,
    'config' => 0,
    'current_category' => 0,
    'categories' => 0,
    'standoff' => 0,
    'f_products' => 0,
    'cat_products' => 0,
    'lng' => 0,
    'cat' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec62e8d5c028_83105421',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec62e8d5c028_83105421')) {function content_59ec62e8d5c028_83105421($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_amp')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.amp.php';
if (!is_callable('smarty_function_get_category_image_url')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.get_category_image_url.php';
if (!is_callable('smarty_function_inc')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.inc.php';
?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Bestsellers']&&$_smarty_tpl->tpl_vars['config']->value['Bestsellers']['bestsellers_menu']!="Y") {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/Bestsellers/bestsellers.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['New_Arrivals']) {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/New_Arrivals/new_arrivals.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('new_arrivals_main'=>"Y"), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Special_Offers']) {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/Special_Offers/customer/category_offers_short_list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<h1><?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['current_category']->value['category']);?>
</h1>

<?php if ($_smarty_tpl->tpl_vars['config']->value['Appearance']['subcategories_per_row']=='Y') {?>

  <?php if ($_smarty_tpl->tpl_vars['current_category']->value['description']!='') {?>
    <div class="subcategory-descr"><?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['current_category']->value['description']);?>
</div>
  <?php }?>

  <?php if ($_smarty_tpl->tpl_vars['categories']->value) {?>
    <?php echo $_smarty_tpl->getSubTemplate ("customer/main/subcategories_t.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

  <?php }?>

<?php } else { ?>

  <img class="subcategory-image" src="<?php echo smarty_function_get_category_image_url(array('category'=>$_smarty_tpl->tpl_vars['current_category']->value),$_smarty_tpl);?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current_category']->value['category'], ENT_QUOTES, 'UTF-8', true);?>
"<?php if ($_smarty_tpl->tpl_vars['current_category']->value['image_x']) {?> width="<?php echo $_smarty_tpl->tpl_vars['current_category']->value['image_x'];?>
"<?php }
if ($_smarty_tpl->tpl_vars['current_category']->value['image_y']) {?> height="<?php echo $_smarty_tpl->tpl_vars['current_category']->value['image_y'];?>
"<?php }?> />
  <?php echo smarty_function_inc(array('assign'=>"standoff",'value'=>(($tmp = @$_smarty_tpl->tpl_vars['current_category']->value['image_x'])===null||empty($tmp) ? 0 : $tmp),'inc'=>15),$_smarty_tpl);?>

  <div style="margin-left: <?php echo $_smarty_tpl->tpl_vars['standoff']->value;?>
px;">
    <?php if ($_smarty_tpl->tpl_vars['current_category']->value['description']!='') {?>
      <div class="subcategory-descr"><?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['current_category']->value['description']);?>
</div>
    <?php }?>

    <?php if ($_smarty_tpl->tpl_vars['categories']->value) {?>
      <?php echo $_smarty_tpl->getSubTemplate ("customer/main/subcategories_list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <?php }?>
  </div>
  <div class="clearing"></div>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['f_products']->value) {?>
  <?php echo $_smarty_tpl->getSubTemplate ("customer/main/featured.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['cat_products']->value) {?>

  <?php $_smarty_tpl->_capture_stack[0][] = array('dialog', null, null); ob_start(); ?>

    <?php echo $_smarty_tpl->getSubTemplate ("customer/main/navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


    <?php echo $_smarty_tpl->getSubTemplate ("customer/main/products.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('products'=>$_smarty_tpl->tpl_vars['cat_products']->value), 0);?>


    <?php echo $_smarty_tpl->getSubTemplate ("customer/main/navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


  <?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
  <?php echo $_smarty_tpl->getSubTemplate ("customer/dialog.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_products'],'content'=>((string)Smarty::$_smarty_vars['capture']['dialog']),'products_sort_url'=>"home.php?cat=".((string)$_smarty_tpl->tpl_vars['cat']->value)."&",'sort'=>true,'additional_class'=>"products-dialog dialog-category-products-list"), 0);?>


<?php } elseif (!$_smarty_tpl->tpl_vars['cat_products']->value&&!$_smarty_tpl->tpl_vars['categories']->value) {?>

  <?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_no_products_in_cat'];?>


<?php }?>
<?php }} ?>
