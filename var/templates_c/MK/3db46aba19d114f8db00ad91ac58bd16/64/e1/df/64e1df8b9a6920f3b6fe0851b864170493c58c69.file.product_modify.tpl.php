<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:52
         compiled from "D:\website\MK\skin\common_files\main\product_modify.tpl" */ ?>
<?php /*%%SmartyHeaderCode:587459ef320495aad1-51367661%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '64e1df8b9a6920f3b6fe0851b864170493c58c69' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\product_modify.tpl',
      1 => 1496750444,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '587459ef320495aad1-51367661',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page_title' => 0,
    'product' => 0,
    'active_modules' => 0,
    'SkinDir' => 0,
    'products' => 0,
    'geid' => 0,
    'lng' => 0,
    'productid' => 0,
    'v' => 0,
    'section' => 0,
    'navigation_page' => 0,
    'submode' => 0,
    'product_options' => 0,
    'product_option' => 0,
    'is_pconf' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef3204a12b51_50475735',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef3204a12b51_50475735')) {function content_59ef3204a12b51_50475735($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\modifier.truncate.php';
if (!is_callable('smarty_function_cycle')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\function.cycle.php';
if (!is_callable('smarty_modifier_amp')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.amp.php';
?>
<a name="main"></a>

<?php echo $_smarty_tpl->getSubTemplate ("page_title.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['page_title']->value), 0);?>


<?php if ($_smarty_tpl->tpl_vars['product']->value) {?>
<span class='product-title'>
  <?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['product']->value['product'],72,"...",false);?>

</span>
<br />
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['New_Arrivals']) {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/New_Arrivals/new_arrivals_product_modify_date.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('product'=>$_smarty_tpl->tpl_vars['product']->value), 0);?>

<?php }?>
<?php }?>

<?php echo '<script'; ?>
 type="text/javascript" language="JavaScript 1.2">
//<![CDATA[
window.name="prodmodwin";
//]]>
<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/js/popup_image_selection.js"><?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("main/multirow.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php if ($_smarty_tpl->tpl_vars['products']->value&&$_smarty_tpl->tpl_vars['geid']->value) {?>
<br />
<?php $_smarty_tpl->_capture_stack[0][] = array('dialog', null, null); ob_start(); ?>
<?php echo $_smarty_tpl->getSubTemplate ("main/navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<table cellpadding="3" cellspacing="1" width="100%">

<tr class="TableHead">
  <td><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_sku'];?>
</td>
  <td><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_product'];?>
</td>
</tr>

<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>

<tr<?php echo smarty_function_cycle(array('name'=>"ge",'values'=>', class="TableSubHead"'),$_smarty_tpl);?>
>
  <td><?php if ($_smarty_tpl->tpl_vars['productid']->value==$_smarty_tpl->tpl_vars['v']->value['productid']) {?><b><?php } else { ?><a href="product_modify.php?productid=<?php echo $_smarty_tpl->tpl_vars['v']->value['productid'];
if ($_smarty_tpl->tpl_vars['section']->value!='main') {?>&amp;section=<?php echo $_smarty_tpl->tpl_vars['section']->value;
}?>&amp;geid=<?php echo $_smarty_tpl->tpl_vars['geid']->value;
if ($_smarty_tpl->tpl_vars['navigation_page']->value) {?>&amp;page=<?php echo $_smarty_tpl->tpl_vars['navigation_page']->value;
}?>"><?php }?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['productcode'], ENT_QUOTES, 'UTF-8', true);?>

<?php if ($_smarty_tpl->tpl_vars['productid']->value==$_smarty_tpl->tpl_vars['v']->value['productid']) {?></b><?php } else { ?></a><?php }?>
</td>
  <td><?php if ($_smarty_tpl->tpl_vars['productid']->value==$_smarty_tpl->tpl_vars['v']->value['productid']) {?><b><?php } else { ?><a href="product_modify.php?productid=<?php echo $_smarty_tpl->tpl_vars['v']->value['productid'];
if ($_smarty_tpl->tpl_vars['section']->value!='main') {?>&amp;section=<?php echo $_smarty_tpl->tpl_vars['section']->value;
}?>&amp;geid=<?php echo $_smarty_tpl->tpl_vars['geid']->value;
if ($_smarty_tpl->tpl_vars['navigation_page']->value) {?>&amp;page=<?php echo $_smarty_tpl->tpl_vars['navigation_page']->value;
}?>"><?php }?>
<?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['v']->value['product']);?>

<?php if ($_smarty_tpl->tpl_vars['productid']->value==$_smarty_tpl->tpl_vars['v']->value['productid']) {?></b><?php } else { ?></a><?php }?>
</td>
</tr>

<?php } ?>

</table>
<?php echo $_smarty_tpl->getSubTemplate ("main/navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<?php echo $_smarty_tpl->getSubTemplate ("dialog.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('content'=>Smarty::$_smarty_vars['capture']['dialog'],'title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_product_list'],'extra'=>"width='100%'"), 0);?>

<div class="product-details-geid-info">
<?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_edit_product_group'];?>

</div>
<div class="product-details-geid">
<?php }?>

<br />

<?php if ($_smarty_tpl->tpl_vars['section']->value=="main") {?>
<a name="section_main"></a>
<?php echo $_smarty_tpl->getSubTemplate ("main/product_details.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<br />
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['section']->value=="lng") {?>
<a name="section_lng"></a>
<?php echo $_smarty_tpl->getSubTemplate ("main/products_lng.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<br />
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Product_Options']&&$_smarty_tpl->tpl_vars['section']->value=="options") {?>
<a name="section_options"></a>
<?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_add_product_options_note'];?>
<br />
<br />
<div align="right"><?php echo $_smarty_tpl->getSubTemplate ("buttons/button.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('button_title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_product_options_help'],'href'=>"javascript:window.open('popup_info.php?action=OPT','OPT_HELP','width=600,height=460,toolbar=no,status=no,scrollbars=yes,resizable=no,menubar=no,location=no,direction=no');"), 0);?>
</div>
<br />
<?php if ($_smarty_tpl->tpl_vars['submode']->value=='product_options_add'||$_smarty_tpl->tpl_vars['product_options']->value==''||$_smarty_tpl->tpl_vars['product_option']->value!='') {?>

<?php echo $_smarty_tpl->getSubTemplate ("modules/Product_Options/add_product_options.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php } else { ?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Product_Options/product_options.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<br />
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Product_Options']&&$_smarty_tpl->tpl_vars['product']->value['is_variants']=='Y'&&$_smarty_tpl->tpl_vars['section']->value=="variants"&&!$_smarty_tpl->tpl_vars['is_pconf']->value) {?>
<a name="section_variants"></a>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Product_Options/product_variants.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<br />
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Product_Options']&&$_smarty_tpl->tpl_vars['active_modules']->value['Extra_Fields']&&$_smarty_tpl->tpl_vars['product']->value['is_variants']=="Y"&&$_smarty_tpl->tpl_vars['section']->value=="variants_extra_fields"&&!$_smarty_tpl->tpl_vars['is_pconf']->value) {?>
  <a name="section_variants_extra_fields"></a>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/Product_Options/product_variants_extra_fields_modify.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

  <br />
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Product_Configurator']&&$_smarty_tpl->tpl_vars['section']->value=="pclass"&&!$_smarty_tpl->tpl_vars['is_pconf']->value) {?>
<a name="section_pclass"></a>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Product_Configurator/pconf_classification.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<br />
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Wholesale_Trading']&&$_smarty_tpl->tpl_vars['product']->value['is_variants']!='Y'&&$_smarty_tpl->tpl_vars['section']->value=="wholesale"&&!$_smarty_tpl->tpl_vars['is_pconf']->value) {?>
<a name="section_wholesale"></a>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Wholesale_Trading/product_wholesale.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<br />
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Upselling_Products']&&$_smarty_tpl->tpl_vars['section']->value=="upselling") {?>
<a name="section_upselling"></a>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Upselling_Products/product_links.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<br />
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Detailed_Product_Images']&&$_smarty_tpl->tpl_vars['section']->value=="images") {?>
<a name="section_images"></a>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Detailed_Product_Images/product_images_modify.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<br />
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Magnifier']&&$_smarty_tpl->tpl_vars['section']->value=="zoomer") {?>
<a name="section_zoomer"></a>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Magnifier/product_magnifier_modify.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<br />
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Customer_Reviews']&&$_smarty_tpl->tpl_vars['section']->value=="reviews") {?>
<a name="section_reviews"></a>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Customer_Reviews/admin_reviews.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<br />
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Advanced_Customer_Reviews']&&$_smarty_tpl->tpl_vars['section']->value=="acr_reviews") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Advanced_Customer_Reviews/acr_product_modify.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Feature_Comparison']&&$_smarty_tpl->tpl_vars['section']->value=="feature_class"&&!$_smarty_tpl->tpl_vars['is_pconf']->value) {?>
<a name="section_feature_class"></a>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Feature_Comparison/product_class.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<br />
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Refine_Filters']&&$_smarty_tpl->tpl_vars['section']->value=="custom_class") {?>
<a name="section_custom_class"></a>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Refine_Filters/rf_product_class.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<br />
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Pitney_Bowes']&&$_smarty_tpl->tpl_vars['section']->value=="product_restrictions") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Pitney_Bowes/product_restrictions.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['POS_System']&&$_smarty_tpl->tpl_vars['section']->value=="barcode") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/POS_System/product_section_barcode.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Amazon_Feeds']&&$_smarty_tpl->tpl_vars['section']->value=="feeds_details") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Amazon_Feeds/product_feeds_details.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Bongo_International']&&$_smarty_tpl->tpl_vars['section']->value=="bongo") {?>
  <a name="section_bongo"></a>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/Bongo_International/product_modify.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

  <br />
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['product']->value&&$_smarty_tpl->tpl_vars['geid']->value) {?>
</div>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['section']->value=="error") {?>
<?php $_smarty_tpl->_capture_stack[0][] = array('dialog', null, null); ob_start(); ?>
<br />
<?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_cant_create_product_warning'];?>

<br /><br />
<?php echo $_smarty_tpl->getSubTemplate ("buttons/button.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('button_title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_register_provider'],'href'=>"user_add.php?usertype=P"), 0);?>

<br />
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<?php echo $_smarty_tpl->getSubTemplate ("dialog.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('content'=>Smarty::$_smarty_vars['capture']['dialog'],'title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_warning'],'extra'=>"width='100%'"), 0);?>


<?php }?>
<?php }} ?>
