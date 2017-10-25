<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 11:20:40
         compiled from "D:\website\MK\skin\common_files\modules\New_Arrivals\new_arrivals.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1857059ec62e8ec1b06-83276685%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8b30979f4c26b2a039177aeab9098eac779238f6' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\modules\\New_Arrivals\\new_arrivals.tpl',
      1 => 1496750464,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1857059ec62e8ec1b06-83276685',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'new_arrivals' => 0,
    'is_home_page' => 0,
    'config' => 0,
    'new_arrivals_main' => 0,
    'cat' => 0,
    'current_category' => 0,
    'is_new_arrivals_page' => 0,
    'new_arrivals_navigation_script' => 0,
    'new_arrival' => 0,
    'lng' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec62e8ed9904_72900448',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec62e8ed9904_72900448')) {function content_59ec62e8ed9904_72900448($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_amp')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.amp.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\modifier.date_format.php';
if (!is_callable('smarty_function_currency')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.currency.php';
?>

<?php if ($_smarty_tpl->tpl_vars['new_arrivals']->value&&(($_smarty_tpl->tpl_vars['is_home_page']->value=="Y"&&$_smarty_tpl->tpl_vars['config']->value['New_Arrivals']['new_arrivals_home']=="Y")||($_smarty_tpl->tpl_vars['new_arrivals_main']->value=="Y"&&$_smarty_tpl->tpl_vars['config']->value['New_Arrivals']['new_arrivals_main']=="Y"&&($_smarty_tpl->tpl_vars['cat']->value==0||$_smarty_tpl->tpl_vars['cat']->value==''||($_smarty_tpl->tpl_vars['cat']->value>0&&$_smarty_tpl->tpl_vars['current_category']->value['show_new_arrivals']=="Y")))||$_smarty_tpl->tpl_vars['is_new_arrivals_page']->value)) {?>
  <?php $_smarty_tpl->_capture_stack[0][] = array('dialog', null, null); ob_start(); ?>

    <?php if ($_smarty_tpl->tpl_vars['is_new_arrivals_page']->value) {?>
      <?php echo $_smarty_tpl->getSubTemplate ("customer/main/navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('navigation_script'=>$_smarty_tpl->tpl_vars['new_arrivals_navigation_script']->value), 0);?>

    <?php }?>

    <?php if ($_smarty_tpl->tpl_vars['config']->value['New_Arrivals']['view_new_arrivals']=="F") {?>
      <?php echo $_smarty_tpl->getSubTemplate ("customer/main/products.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('products'=>$_smarty_tpl->tpl_vars['new_arrivals']->value,'new_arrivals_show_date'=>"Y",'is_new_arrivals_products'=>"Y"), 0);?>

    <?php } else { ?>
      <ul class="new_arrivals-item">
        <?php  $_smarty_tpl->tpl_vars['new_arrival'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['new_arrival']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['new_arrivals']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['new_arrival']->key => $_smarty_tpl->tpl_vars['new_arrival']->value) {
$_smarty_tpl->tpl_vars['new_arrival']->_loop = true;
?>
          <li>
            <a href="product.php?productid=<?php echo $_smarty_tpl->tpl_vars['new_arrival']->value['productid'];?>
"><?php echo $_smarty_tpl->getSubTemplate ("product_thumbnail.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('productid'=>$_smarty_tpl->tpl_vars['new_arrival']->value['productid'],'product'=>$_smarty_tpl->tpl_vars['new_arrival']->value['product'],'tmbn_url'=>$_smarty_tpl->tpl_vars['new_arrival']->value['tmbn_url']), 0);?>
</a>
            <div class="details">
              <a class="product-title" href="product.php?productid=<?php echo $_smarty_tpl->tpl_vars['new_arrival']->value['productid'];?>
"><?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['new_arrival']->value['product']);?>
</a><br />(<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['new_arrival']->value['add_date'],$_smarty_tpl->tpl_vars['config']->value['Appearance']['date_format']);?>
)<br />
              <?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_our_price'];?>
: <?php echo smarty_function_currency(array('value'=>$_smarty_tpl->tpl_vars['new_arrival']->value['taxed_price']),$_smarty_tpl);?>

            </div>
            <div class="clearing"></div>
          </li>
        <?php } ?>
      </ul>
    <?php }?>

    <?php if ($_smarty_tpl->tpl_vars['is_new_arrivals_page']->value) {?>
      <?php echo $_smarty_tpl->getSubTemplate ("customer/main/navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('navigation_script'=>$_smarty_tpl->tpl_vars['new_arrivals_navigation_script']->value), 0);?>

    <?php }?>

  <?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
  <?php echo $_smarty_tpl->getSubTemplate ("customer/dialog.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_new_arrivals'],'content'=>Smarty::$_smarty_vars['capture']['dialog']), 0);?>

<?php }?>
<?php }} ?>
