<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:54
         compiled from "D:\website\MK\skin\common_files\modules\Cost_Pricing\product_modify_cost.tpl" */ ?>
<?php /*%%SmartyHeaderCode:835459ef3206908c27-32873847%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9cfc5335fcb74b9adfbbe8509455dd55c45331d3' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\modules\\Cost_Pricing\\product_modify_cost.tpl',
      1 => 1496750452,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '835459ef3206908c27-32873847',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'geid' => 0,
    'lng' => 0,
    'config' => 0,
    'product' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef32069633f0_20004084',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef32069633f0_20004084')) {function content_59ef32069633f0_20004084($_smarty_tpl) {?>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="costp_ge_checked" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_cost_price'];?>
 <span class="Text">(<?php echo $_smarty_tpl->tpl_vars['config']->value['General']['currency_symbol'];?>
):</span></td>
  <td class="ProductDetails">
    <input type="text" name="cost_price" id="cost_price" size="18" value="<?php echo XCCostTpl::getCost(array('productid'=>$_smarty_tpl->tpl_vars['product']->value['productid'],'default'=>$_smarty_tpl->tpl_vars['product']->value['cost_price']),$_smarty_tpl);?>
" />
  </td>
</tr>
<?php }} ?>
