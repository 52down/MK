<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:48
         compiled from "D:\website\MK\skin\common_files\main\products.tpl" */ ?>
<?php /*%%SmartyHeaderCode:304859ef32005e3a40-79292891%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0049bcc879b4a4467619690b265861ddd84bc0a7' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\products.tpl',
      1 => 1496750444,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '304859ef32005e3a40-79292891',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'products' => 0,
    'lng' => 0,
    'main' => 0,
    'cat' => 0,
    'navpage' => 0,
    'search_prefilled' => 0,
    'url_to' => 0,
    'active_modules' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef32006a4dd9_82279910',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef32006a4dd9_82279910')) {function content_59ef32006a4dd9_82279910($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_wm_remove')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.wm_remove.php';
if (!is_callable('smarty_modifier_amp')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.amp.php';
if (!is_callable('smarty_function_cycle')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\function.cycle.php';
if (!is_callable('smarty_modifier_formatprice')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.formatprice.php';
?>
<?php if ($_smarty_tpl->tpl_vars['products']->value!='') {?>
<br />
<?php echo $_smarty_tpl->getSubTemplate ("main/check_all_row.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('style'=>"line-height: 170%;",'form'=>"processproductform",'prefix'=>"productids"), 0);?>

<br />
<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[
var txt_pvariant_edit_note_list = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['txt_pvariant_edit_note_list']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
";


function pvAlert(obj) {
  if (obj.pvAlertFlag)
    return false;

  alert(txt_pvariant_edit_note_list);
  obj.pvAlertFlag = true;
  return true;
}

//]]>
<?php echo '</script'; ?>
>

<table cellpadding="2" cellspacing="1" width="100%">

<?php if ($_smarty_tpl->tpl_vars['main']->value=="category_products") {?>
<?php if (isset($_smarty_tpl->tpl_vars["url_to"])) {$_smarty_tpl->tpl_vars["url_to"] = clone $_smarty_tpl->tpl_vars["url_to"];
$_smarty_tpl->tpl_vars["url_to"]->value = "category_products.php?cat=".((string)$_smarty_tpl->tpl_vars['cat']->value)."&amp;page=".((string)$_smarty_tpl->tpl_vars['navpage']->value); $_smarty_tpl->tpl_vars["url_to"]->nocache = null; $_smarty_tpl->tpl_vars["url_to"]->scope = 0;
} else $_smarty_tpl->tpl_vars["url_to"] = new Smarty_variable("category_products.php?cat=".((string)$_smarty_tpl->tpl_vars['cat']->value)."&amp;page=".((string)$_smarty_tpl->tpl_vars['navpage']->value), null, 0);?>
<?php } else { ?>
<?php if (isset($_smarty_tpl->tpl_vars["url_to"])) {$_smarty_tpl->tpl_vars["url_to"] = clone $_smarty_tpl->tpl_vars["url_to"];
$_smarty_tpl->tpl_vars["url_to"]->value = "search.php?mode=search&amp;page=".((string)$_smarty_tpl->tpl_vars['navpage']->value); $_smarty_tpl->tpl_vars["url_to"]->nocache = null; $_smarty_tpl->tpl_vars["url_to"]->scope = 0;
} else $_smarty_tpl->tpl_vars["url_to"] = new Smarty_variable("search.php?mode=search&amp;page=".((string)$_smarty_tpl->tpl_vars['navpage']->value), null, 0);?>
<?php }?>

<tr class="TableHead">
  <td width="5">&nbsp;</td>
  <td nowrap="nowrap"><?php if ($_smarty_tpl->tpl_vars['search_prefilled']->value['sort_field']=="productcode") {
echo $_smarty_tpl->getSubTemplate ("buttons/sort_pointer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('dir'=>$_smarty_tpl->tpl_vars['search_prefilled']->value['sort_direction']), 0);?>
&nbsp;<?php }?><a href="<?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['url_to']->value);?>
&amp;sort=productcode&amp;sort_direction=<?php if ($_smarty_tpl->tpl_vars['search_prefilled']->value['sort_field']=="productcode") {
if ($_smarty_tpl->tpl_vars['search_prefilled']->value['sort_direction']==1) {?>0<?php } else { ?>1<?php }
} else {
echo $_smarty_tpl->tpl_vars['search_prefilled']->value['sort_direction'];
}?>"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_sku'];?>
</a></td>
  <td width="100%" nowrap="nowrap"><?php if ($_smarty_tpl->tpl_vars['search_prefilled']->value['sort_field']=="title") {
echo $_smarty_tpl->getSubTemplate ("buttons/sort_pointer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('dir'=>$_smarty_tpl->tpl_vars['search_prefilled']->value['sort_direction']), 0);?>
&nbsp;<?php }?><a href="<?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['url_to']->value);?>
&amp;sort=title&amp;sort_direction=<?php if ($_smarty_tpl->tpl_vars['search_prefilled']->value['sort_field']=="title") {
if ($_smarty_tpl->tpl_vars['search_prefilled']->value['sort_direction']==1) {?>0<?php } else { ?>1<?php }
} else {
echo $_smarty_tpl->tpl_vars['search_prefilled']->value['sort_direction'];
}?>"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_product'];?>
</a></td>
<?php if ($_smarty_tpl->tpl_vars['main']->value=="category_products") {?>
  <td nowrap="nowrap"><?php if ($_smarty_tpl->tpl_vars['search_prefilled']->value['sort_field']=="orderby") {
echo $_smarty_tpl->getSubTemplate ("buttons/sort_pointer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('dir'=>$_smarty_tpl->tpl_vars['search_prefilled']->value['sort_direction']), 0);?>
&nbsp;<?php }?><a href="<?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['url_to']->value);?>
&amp;sort=orderby&amp;sort_direction=<?php if ($_smarty_tpl->tpl_vars['search_prefilled']->value['sort_field']=="orderby") {
if ($_smarty_tpl->tpl_vars['search_prefilled']->value['sort_direction']==1) {?>0<?php } else { ?>1<?php }
} else {
echo $_smarty_tpl->tpl_vars['search_prefilled']->value['sort_direction'];
}?>"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_pos'];?>
</a></td>
<?php }?>
  <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['New_Arrivals']) {?>
    <?php echo $_smarty_tpl->getSubTemplate ("modules/New_Arrivals/new_arrivals_product_list_date.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('is_header'=>"Y"), 0);?>

  <?php }?>
  <td nowrap="nowrap"><?php if ($_smarty_tpl->tpl_vars['search_prefilled']->value['sort_field']=="quantity") {
echo $_smarty_tpl->getSubTemplate ("buttons/sort_pointer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('dir'=>$_smarty_tpl->tpl_vars['search_prefilled']->value['sort_direction']), 0);?>
&nbsp;<?php }?><a href="<?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['url_to']->value);?>
&amp;sort=quantity&amp;sort_direction=<?php if ($_smarty_tpl->tpl_vars['search_prefilled']->value['sort_field']=="quantity") {
if ($_smarty_tpl->tpl_vars['search_prefilled']->value['sort_direction']==1) {?>0<?php } else { ?>1<?php }
} else {
echo $_smarty_tpl->tpl_vars['search_prefilled']->value['sort_direction'];
}?>"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_in_stock'];?>
</a></td>
  <td nowrap="nowrap"><?php if ($_smarty_tpl->tpl_vars['search_prefilled']->value['sort_field']=="price") {
echo $_smarty_tpl->getSubTemplate ("buttons/sort_pointer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('dir'=>$_smarty_tpl->tpl_vars['search_prefilled']->value['sort_direction']), 0);?>
&nbsp;<?php }?><a href="<?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['url_to']->value);?>
&amp;sort=price&amp;sort_direction=<?php if ($_smarty_tpl->tpl_vars['search_prefilled']->value['sort_field']=="price") {
if ($_smarty_tpl->tpl_vars['search_prefilled']->value['sort_direction']==1) {?>0<?php } else { ?>1<?php }
} else {
echo $_smarty_tpl->tpl_vars['search_prefilled']->value['sort_direction'];
}?>"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_price'];?>
 (<?php echo $_smarty_tpl->tpl_vars['config']->value['General']['currency_symbol'];?>
)</a></td>
</tr>

<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['prod'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['prod']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['name'] = 'prod';
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['products']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['prod']['total']);
?>

<tr<?php echo smarty_function_cycle(array('values'=>', class="TableSubHead"'),$_smarty_tpl);?>
>
  <td width="5"><input type="checkbox" name="productids[<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]['productid'];?>
]" /></td>
  <td><a href="product_modify.php?productid=<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]['productid'];
if ($_smarty_tpl->tpl_vars['navpage']->value) {?>&amp;page=<?php echo $_smarty_tpl->tpl_vars['navpage']->value;
}?>"><?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]['productcode'];?>
</a></td>
  <td width="100%"><?php if ($_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]['main']=="Y"||$_smarty_tpl->tpl_vars['main']->value!="category_products") {?><b><?php }?><a href="product_modify.php?productid=<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]['productid'];
if ($_smarty_tpl->tpl_vars['navpage']->value) {?>&amp;page=<?php echo $_smarty_tpl->tpl_vars['navpage']->value;
}?>"><?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]['product'];?>
</a><?php if ($_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]['main']=="Y"||$_smarty_tpl->tpl_vars['main']->value!="category_products") {?></b><?php }
if ($_smarty_tpl->tpl_vars['active_modules']->value['Alibaba_Wholesale']&&$_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]['alibaba_wholesale_id']) {?><a class="aw-product-sign" href="alibaba_wholesale_catalog.php?action=redirect&aw_product_id=<?php echo urlencode($_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]['alibaba_wholesale_id']);?>
" target="_blank"></a>  <?php }?></td>
<?php if ($_smarty_tpl->tpl_vars['main']->value=="category_products") {?>
  <td><input type="text" size="9" maxlength="10" name="posted_data[<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]['productid'];?>
][orderby]" value="<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]['orderby'];?>
" /></td>
<?php }?>
  <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['New_Arrivals']) {?>
    <?php echo $_smarty_tpl->getSubTemplate ("modules/New_Arrivals/new_arrivals_product_list_date.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('product'=>$_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]), 0);?>

  <?php }?>
  <td align="center">
<?php if ($_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]['product_type']!='C') {?>
<input type="text" size="9" maxlength="10" name="posted_data[<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]['productid'];?>
][avail]" value="<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]['avail'];?>
"<?php if ($_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]['is_variants']=='Y') {?> readonly="readonly" onclick="javascript: pvAlert(this);"<?php }?> />
<?php }?>
  </td>
  <td>
<?php if ($_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]['product_type']!='C') {?>
<input type="text" size="9" maxlength="15" name="posted_data[<?php echo $_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]['productid'];?>
][price]" value="<?php echo smarty_modifier_formatprice($_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]['price']);?>
"<?php if ($_smarty_tpl->tpl_vars['products']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prod']['index']]['is_variants']=='Y') {?> readonly="readonly" onclick="javascript: pvAlert(this);"<?php }?> />
<?php }?>
  </td>

</tr>

<?php endfor; endif; ?>

</table>
<?php }?>
<?php }} ?>
