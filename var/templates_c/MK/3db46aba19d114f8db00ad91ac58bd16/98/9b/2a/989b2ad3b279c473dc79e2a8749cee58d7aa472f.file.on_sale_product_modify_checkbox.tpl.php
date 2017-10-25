<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:54
         compiled from "D:\website\MK\skin\common_files\modules\On_Sale\on_sale_product_modify_checkbox.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2788859ef3206b6d247-22994395%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '989b2ad3b279c473dc79e2a8749cee58d7aa472f' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\modules\\On_Sale\\on_sale_product_modify_checkbox.tpl',
      1 => 1496750466,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2788859ef3206b6d247-22994395',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'geid' => 0,
    'lng' => 0,
    'product' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef3206b849f6_98137727',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef3206b849f6_98137727')) {function content_59ef3206b849f6_98137727($_smarty_tpl) {?>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[on_sale]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_on_sale'];?>
:</td>
  <td class="ProductDetails">
    <input type="hidden" name="on_sale" value="N" />
    <input type="checkbox" name="on_sale" value="Y"<?php if ($_smarty_tpl->tpl_vars['product']->value['on_sale']=="Y") {?> checked="checked"<?php }?> />
  </td>
</tr>
<?php }} ?>
