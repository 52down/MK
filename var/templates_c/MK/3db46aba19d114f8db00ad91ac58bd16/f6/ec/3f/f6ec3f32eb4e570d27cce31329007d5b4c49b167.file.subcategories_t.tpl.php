<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 11:20:41
         compiled from "D:\website\MK\skin\common_files\customer\main\subcategories_t.tpl" */ ?>
<?php /*%%SmartyHeaderCode:793159ec62e905ebb3-66722744%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f6ec3f32eb4e570d27cce31329007d5b4c49b167' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\customer\\main\\subcategories_t.tpl',
      1 => 1496750420,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '793159ec62e905ebb3-66722744',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'categories' => 0,
    'subcat_div_width' => 0,
    'subcat_div_height' => 0,
    'subcategory' => 0,
    'ImagesDir' => 0,
    'subcat_img_height' => 0,
    'config' => 0,
    'lng' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec62e906ea75_04054527',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec62e906ea75_04054527')) {function content_59ec62e906ea75_04054527($_smarty_tpl) {?><?php if (!is_callable('smarty_function_get_category_image_url')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.get_category_image_url.php';
if (!is_callable('smarty_modifier_substitute')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.substitute.php';
?>
<?php  $_smarty_tpl->tpl_vars['subcategory'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['subcategory']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['subcategory']->key => $_smarty_tpl->tpl_vars['subcategory']->value) {
$_smarty_tpl->tpl_vars['subcategory']->_loop = true;
?>

  <span class="subcategories" style="min-width: <?php echo $_smarty_tpl->tpl_vars['subcat_div_width']->value;?>
px; width: <?php echo $_smarty_tpl->tpl_vars['subcat_div_width']->value;?>
px; min-height: <?php echo $_smarty_tpl->tpl_vars['subcat_div_height']->value;?>
px;">
    <?php if ($_smarty_tpl->tpl_vars['subcategory']->value['is_icon']) {?>
      <a href="home.php?cat=<?php echo $_smarty_tpl->tpl_vars['subcategory']->value['categoryid'];?>
"><img src="<?php echo smarty_function_get_category_image_url(array('category'=>$_smarty_tpl->tpl_vars['subcategory']->value),$_smarty_tpl);?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['subcategory']->value['category'], ENT_QUOTES, 'UTF-8', true);?>
" width="<?php echo $_smarty_tpl->tpl_vars['subcategory']->value['image_x'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['subcategory']->value['image_y'];?>
" /></a>
    <?php } else { ?>
      <img src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/spacer.gif" alt="" width="1" height="<?php echo $_smarty_tpl->tpl_vars['subcat_img_height']->value;?>
" />
    <?php }?>
    <br />
    <a href="home.php?cat=<?php echo $_smarty_tpl->tpl_vars['subcategory']->value['categoryid'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['subcategory']->value['category'], ENT_QUOTES, 'UTF-8', true);?>
</a><br />
    <?php if ($_smarty_tpl->tpl_vars['config']->value['Appearance']['count_products']=="Y") {?>
      <?php if ($_smarty_tpl->tpl_vars['subcategory']->value['product_count']) {?>
        <?php echo smarty_modifier_substitute($_smarty_tpl->tpl_vars['lng']->value['lbl_N_products'],'products',$_smarty_tpl->tpl_vars['subcategory']->value['product_count']);?>

      <?php } elseif ($_smarty_tpl->tpl_vars['subcategory']->value['subcategory_count']) {?>
        <?php echo smarty_modifier_substitute($_smarty_tpl->tpl_vars['lng']->value['lbl_N_categories'],'count',$_smarty_tpl->tpl_vars['subcategory']->value['subcategory_count']);?>

      <?php }?>
    <?php }?>
  </span>

<?php } ?>
<div class="clearing"></div>
<br />
<?php }} ?>
