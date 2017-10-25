<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 09:48:23
         compiled from "D:\website\MK\skin\common_files\modules\Flyout_Menus\Icons\fancy_subcategories.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1071359ec4d47e19f09-76842450%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c551e5b6ced95deb3ae79250e5359f9d19776efe' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\modules\\Flyout_Menus\\Icons\\fancy_subcategories.tpl',
      1 => 1496750458,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1071359ec4d47e19f09-76842450',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'level' => 0,
    'parentid' => 0,
    'categories_menu_list' => 0,
    'loop_name' => 0,
    'catid' => 0,
    'config' => 0,
    'c' => 0,
    'fc_skin_path' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec4d47ee3529_11063962',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec4d47ee3529_11063962')) {function content_59ec4d47ee3529_11063962($_smarty_tpl) {?><?php if (!is_callable('smarty_function_interline')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.interline.php';
if (!is_callable('smarty_modifier_amp')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.amp.php';
?>
<ul class="fancycat-icons-level-<?php echo $_smarty_tpl->tpl_vars['level']->value;?>
">

  <?php if (isset($_smarty_tpl->tpl_vars["loop_name"])) {$_smarty_tpl->tpl_vars["loop_name"] = clone $_smarty_tpl->tpl_vars["loop_name"];
$_smarty_tpl->tpl_vars["loop_name"]->value = "subcat".((string)$_smarty_tpl->tpl_vars['parentid']->value); $_smarty_tpl->tpl_vars["loop_name"]->nocache = null; $_smarty_tpl->tpl_vars["loop_name"]->scope = 0;
} else $_smarty_tpl->tpl_vars["loop_name"] = new Smarty_variable("subcat".((string)$_smarty_tpl->tpl_vars['parentid']->value), null, 0);?>
  <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_smarty_tpl->tpl_vars['catid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['categories_menu_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['c']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['c']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value) {
$_smarty_tpl->tpl_vars['c']->_loop = true;
 $_smarty_tpl->tpl_vars['catid']->value = $_smarty_tpl->tpl_vars['c']->key;
 $_smarty_tpl->tpl_vars['c']->iteration++;
?>
    <li<?php echo smarty_function_interline(array('name'=>$_smarty_tpl->tpl_vars['loop_name']->value,'foreach_iteration'=>$_smarty_tpl->tpl_vars['c']->iteration,'foreach_total'=>$_smarty_tpl->tpl_vars['c']->total),$_smarty_tpl);?>
 style="z-index: <?php echo $_smarty_tpl->tpl_vars['c']->total-$_smarty_tpl->tpl_vars['c']->iteration+1001;?>
;">
      <a href="home.php?cat=<?php echo $_smarty_tpl->tpl_vars['catid']->value;?>
" class="<?php if ($_smarty_tpl->tpl_vars['config']->value['Flyout_Menus']['icons_icons_in_categories']>=$_smarty_tpl->tpl_vars['level']->value+1) {?>icon-link<?php }
if ($_smarty_tpl->tpl_vars['config']->value['Flyout_Menus']['icons_disable_subcat_triangle']=='Y'&&$_smarty_tpl->tpl_vars['c']->value['subcategory_count']>0) {?> sub-link<?php }
if ($_smarty_tpl->tpl_vars['config']->value['Flyout_Menus']['icons_empty_category_vis']=='Y'&&!$_smarty_tpl->tpl_vars['c']->value['childs']&&!$_smarty_tpl->tpl_vars['c']->value['product_count']) {?> empty-link<?php }
if ($_smarty_tpl->tpl_vars['config']->value['Flyout_Menus']['icons_nowrap_category']!='Y') {?> nowrap-link<?php }?>"><?php if ($_smarty_tpl->tpl_vars['config']->value['Flyout_Menus']['icons_icons_in_categories']>=$_smarty_tpl->tpl_vars['level']->value+1&&$_smarty_tpl->tpl_vars['c']->value['is_icon']) {?><img src="<?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['c']->value['thumb_url']);?>
" alt="" width="<?php echo $_smarty_tpl->tpl_vars['c']->value['thumb_x'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['c']->value['thumb_y'];?>
" /><?php }
echo smarty_modifier_amp($_smarty_tpl->tpl_vars['c']->value['category']);
if ($_smarty_tpl->tpl_vars['config']->value['Flyout_Menus']['icons_display_products_cnt']=='Y'&&$_smarty_tpl->tpl_vars['c']->value['top_product_count']>0) {?>&#32;(<?php echo $_smarty_tpl->tpl_vars['c']->value['top_product_count'];?>
)<?php }?></a>

      <?php if ($_smarty_tpl->tpl_vars['c']->value['childs']&&$_smarty_tpl->tpl_vars['c']->value['subcategory_count']>0&&($_smarty_tpl->tpl_vars['config']->value['Flyout_Menus']['icons_levels_limit']==0||$_smarty_tpl->tpl_vars['config']->value['Flyout_Menus']['icons_levels_limit']>$_smarty_tpl->tpl_vars['level']->value)) {?>
        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['fc_skin_path']->value)."/fancy_subcategories.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('categories_menu_list'=>$_smarty_tpl->tpl_vars['c']->value['childs'],'parentid'=>$_smarty_tpl->tpl_vars['catid']->value,'level'=>$_smarty_tpl->tpl_vars['level']->value+1), 0);?>

      <?php }?>
    </li>

  <?php } ?>

</ul>
<?php }} ?>
