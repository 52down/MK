<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:52
         compiled from "D:\website\MK\skin\common_files\main\product_details.tpl" */ ?>
<?php /*%%SmartyHeaderCode:639359ef3204e9e436-50807909%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4fc3b869f4a5187cd069eb398f3f07ecd74d60b0' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\product_details.tpl',
      1 => 1496750444,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '639359ef3204e9e436-50807909',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'product' => 0,
    'is_pconf' => 0,
    'geid' => 0,
    'active_modules' => 0,
    'lng' => 0,
    'usertype' => 0,
    'new_product' => 0,
    'providers' => 0,
    'top_message' => 0,
    'provider_info' => 0,
    'default_categoryid' => 0,
    'manufacturers' => 0,
    'v' => 0,
    'customer_product_url' => 0,
    'html_editor_disabled' => 0,
    'variant_href' => 0,
    'zero' => 0,
    'taxes' => 0,
    'is_admin_user' => 0,
    'catalogs' => 0,
    'productid' => 0,
    'product_details_standalone' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef32050c03a9_14383407',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef32050c03a9_14383407')) {function content_59ef32050c03a9_14383407($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\modifier.replace.php';
if (!is_callable('smarty_modifier_substitute')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.substitute.php';
if (!is_callable('smarty_modifier_formatprice')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.formatprice.php';
if (!is_callable('smarty_function_load_defer_code')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer_code.php';
?>
<?php $_smarty_tpl->_capture_stack[0][] = array('dialog', null, null); ob_start(); ?>

<?php echo $_smarty_tpl->getSubTemplate ("check_clean_url.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("main/product_details_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("check_required_fields_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<form action="product_modify.php" method="post" name="modifyform" onsubmit="javascript: return checkRequired(requiredFields)<?php if ($_smarty_tpl->tpl_vars['config']->value['SEO']['clean_urls_enabled']=="Y") {?> &amp;&amp;checkCleanUrl(document.modifyform.clean_url)<?php }?>">
<input type="hidden" name="productid" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['productid'];?>
" />
<input type="hidden" name="section" value="main" />
<input type="hidden" name="mode" value="<?php if ($_smarty_tpl->tpl_vars['is_pconf']->value) {?>pconf<?php } else { ?>product_modify<?php }?>" />
<input type="hidden" name="geid" value="<?php echo $_smarty_tpl->tpl_vars['geid']->value;?>
" />

<table cellpadding="4" cellspacing="0" width="100%" class="product-details-table">

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Alibaba_Wholesale']) {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/Alibaba_Wholesale/product_details_admin.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php echo $_smarty_tpl->getSubTemplate ("main/image_area.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead">&nbsp;</td><?php }?>
  <td colspan="2"><br /><?php echo $_smarty_tpl->getSubTemplate ("main/subheader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_product_owner']), 0);?>
</td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead">&nbsp;</td><?php }?>
  <td class="FormButton" width="10%" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_provider'];?>
:</td>
  <td class="ProductDetails" width="90%">
<?php if ($_smarty_tpl->tpl_vars['usertype']->value=="A"&&$_smarty_tpl->tpl_vars['new_product']->value==1) {?>
  <select name="provider" class="InputWidth">
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['prov'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['prov']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['name'] = 'prov';
$_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['providers']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['prov']['total']);
?>
    <option value="<?php echo $_smarty_tpl->tpl_vars['providers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prov']['index']]['id'];?>
"<?php if ($_smarty_tpl->tpl_vars['product']->value['provider']==$_smarty_tpl->tpl_vars['providers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prov']['index']]['id']) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['providers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prov']['index']]['login'];?>
 (<?php echo $_smarty_tpl->tpl_vars['providers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prov']['index']]['title'];?>
 <?php echo $_smarty_tpl->tpl_vars['providers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prov']['index']]['lastname'];?>
 <?php echo $_smarty_tpl->tpl_vars['providers']->value[$_smarty_tpl->getVariable('smarty')->value['section']['prov']['index']]['firstname'];?>
)</option>
<?php endfor; endif; ?>
  </select>
  <?php if ($_smarty_tpl->tpl_vars['top_message']->value['fillerror']!=''&&$_smarty_tpl->tpl_vars['product']->value['provider']=='') {?><font class="Star">&lt;&lt;</font><?php }?>
<?php } else { ?>
<?php echo $_smarty_tpl->tpl_vars['provider_info']->value['title'];?>
 <?php echo $_smarty_tpl->tpl_vars['provider_info']->value['lastname'];?>
 <?php echo $_smarty_tpl->tpl_vars['provider_info']->value['firstname'];?>
 (<?php echo $_smarty_tpl->tpl_vars['provider_info']->value['login'];?>
)
<?php }?>
  </td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead">&nbsp;</td><?php }?>
  <td colspan="2"><br /><?php echo $_smarty_tpl->getSubTemplate ("main/subheader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_classification']), 0);?>
</td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[categoryid]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_main_category'];?>
:</td>
  <td class="ProductDetails">
    <?php echo $_smarty_tpl->getSubTemplate ("widgets/categoryselector/categoryselector.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('name'=>"categoryid",'class'=>"InputWidth",'selected_id'=>(($tmp = @$_smarty_tpl->tpl_vars['product']->value['categoryid'])===null||empty($tmp) ? $_smarty_tpl->tpl_vars['default_categoryid']->value : $tmp)), 0);?>

    <?php if ($_smarty_tpl->tpl_vars['top_message']->value['fillerror']!=''&&$_smarty_tpl->tpl_vars['product']->value['categoryid']=='') {?><span class="Star">&lt;&lt;</span><?php }?>
  </td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[categoryids]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_additional_categories'];?>
:</td>
  <td class="ProductDetails">
    <?php echo $_smarty_tpl->getSubTemplate ("widgets/categoryselector/categoryselector.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('name'=>"categoryids[]",'class'=>"InputWidth",'selected_ids'=>$_smarty_tpl->tpl_vars['product']->value['add_categoryids'],'extra'=>' multiple="multiple" size="8"'), 0);?>

  </td>
</tr>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Manufacturers']!=''&&!$_smarty_tpl->tpl_vars['is_pconf']->value) {?>
<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[manufacturer]" /></td><?php }?>
    <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_manufacturer'];?>
:</td>
    <td class="ProductDetails">
  <select name="manufacturerid">
      <option value=''<?php if ($_smarty_tpl->tpl_vars['product']->value['manufacturerid']=='') {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_no_manufacturer'];?>
</option>
    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['manufacturers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
      <option value='<?php echo $_smarty_tpl->tpl_vars['v']->value['manufacturerid'];?>
'<?php if ($_smarty_tpl->tpl_vars['v']->value['manufacturerid']==$_smarty_tpl->tpl_vars['product']->value['manufacturerid']) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['manufacturer'];?>
</option>
    <?php } ?>
    </select>
  </td>
</tr>
<?php }?>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[forsale]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_availability'];?>
:</td>
  <td class="ProductDetails">
  <select name="forsale">
    <option value="Y"<?php if ($_smarty_tpl->tpl_vars['product']->value['forsale']=="Y"||$_smarty_tpl->tpl_vars['product']->value['forsale']=='') {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_avail_for_sale'];?>
</option>
    <option value="H"<?php if ($_smarty_tpl->tpl_vars['product']->value['forsale']=="H") {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_hidden'];?>
</option>
    <option value="N"<?php if ($_smarty_tpl->tpl_vars['product']->value['forsale']!="Y"&&$_smarty_tpl->tpl_vars['product']->value['forsale']!=''&&$_smarty_tpl->tpl_vars['product']->value['forsale']!="H"&&($_smarty_tpl->tpl_vars['product']->value['forsale']!="B"||!$_smarty_tpl->tpl_vars['active_modules']->value['Product_Configurator'])) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_disabled'];?>
</option>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Product_Configurator']&&!$_smarty_tpl->tpl_vars['is_pconf']->value) {?>
    <option value="B"<?php if ($_smarty_tpl->tpl_vars['product']->value['forsale']=="B") {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_bundled'];?>
</option>
<?php }?>
  </select>
  </td>
</tr>

<?php if ($_smarty_tpl->tpl_vars['product']->value['internal_url']) {?>
<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead">&nbsp;</td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_product_url'];?>
:</td>
  <?php if (isset($_smarty_tpl->tpl_vars['customer_product_url'])) {$_smarty_tpl->tpl_vars['customer_product_url'] = clone $_smarty_tpl->tpl_vars['customer_product_url'];
$_smarty_tpl->tpl_vars['customer_product_url']->value = smarty_modifier_replace($_smarty_tpl->tpl_vars['product']->value['internal_url'],'https','http'); $_smarty_tpl->tpl_vars['customer_product_url']->nocache = null; $_smarty_tpl->tpl_vars['customer_product_url']->scope = 0;
} else $_smarty_tpl->tpl_vars['customer_product_url'] = new Smarty_variable(smarty_modifier_replace($_smarty_tpl->tpl_vars['product']->value['internal_url'],'https','http'), null, 0);?>
  <td class="ProductDetails"><a href="<?php echo $_smarty_tpl->tpl_vars['customer_product_url']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['customer_product_url']->value;?>
</a></td>
</tr>
<?php }?>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead">&nbsp;</td><?php }?>
  <td colspan="2"><br /><?php echo $_smarty_tpl->getSubTemplate ("main/subheader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_details']), 0);?>
</td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[productcode]" disabled="disabled"/></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_sku'];?>
:</td>
  <td class="ProductDetails"><input type="text" name="productcode" id="productcode" size="20" maxlength="32" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['productcode'], ENT_QUOTES, 'UTF-8', true);?>
" class="InputWidth" /></td>
</tr>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['POS_System']!='') {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/POS_System/product_modify_upc.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[product]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_product_name'];?>
* :</td>
  <td class="ProductDetails">
  <input type="text" name="product" id="product" size="45" class="InputWidth" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['config']->value['SEO']['clean_urls_enabled']=="Y") {?>onchange="javascript: if (this.form.clean_url.value == '') copy_clean_url(this, this.form.clean_url)"<?php }?> />
  <?php if ($_smarty_tpl->tpl_vars['top_message']->value['fillerror']!=''&&$_smarty_tpl->tpl_vars['product']->value['product']=='') {?><font class="Star">&lt;&lt;</font><?php }?>
  </td>
</tr>

<?php echo $_smarty_tpl->getSubTemplate ("main/clean_url_field.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('clean_url'=>$_smarty_tpl->tpl_vars['product']->value['clean_url'],'clean_urls_history'=>$_smarty_tpl->tpl_vars['product']->value['clean_urls_history'],'clean_url_fill_error'=>$_smarty_tpl->tpl_vars['top_message']->value['clean_url_fill_error'],'tooltip_id'=>'clean_url_tooltip_link'), 0);?>


<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[keywords]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_keywords'];?>
:</td>
  <td class="ProductDetails"><input type="text" name="keywords" class="InputWidth" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['keywords'], ENT_QUOTES, 'UTF-8', true);?>
" /></td>
</tr>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Egoods']!='') {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Egoods/egoods.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[descr]" /></td><?php }?>
  <td colspan="2" class="FormButton">
<div<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['HTML_Editor']&&!$_smarty_tpl->tpl_vars['html_editor_disabled']->value) {?> class="description"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_short_description'];?>
* :</div>
<div class="description-data">
<?php echo $_smarty_tpl->getSubTemplate ("main/textarea.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('name'=>"descr",'cols'=>45,'rows'=>8,'data'=>$_smarty_tpl->tpl_vars['product']->value['descr'],'width'=>"100%",'btn_rows'=>4,'entity_id'=>$_smarty_tpl->tpl_vars['product']->value['productid'],'entity_type'=>'product_descr'), 0);?>

<?php if ($_smarty_tpl->tpl_vars['top_message']->value['fillerror']!=''&&($_smarty_tpl->tpl_vars['product']->value['descr']==''||$_smarty_tpl->tpl_vars['product']->value['xss_descr']=="Y")) {?><font class="Star">&lt;&lt;</font><?php }?>
</div>
  </td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[fulldescr]" /></td><?php }?>
  <td colspan="2" class="FormButton">
<div<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['HTML_Editor']&&!$_smarty_tpl->tpl_vars['html_editor_disabled']->value) {?> class="description"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_det_description'];?>
:</div>
<div class="description-data">
  <?php echo $_smarty_tpl->getSubTemplate ("main/textarea.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('name'=>"fulldescr",'cols'=>45,'rows'=>12,'class'=>"InputWidth",'data'=>$_smarty_tpl->tpl_vars['product']->value['fulldescr'],'width'=>"100%",'btn_rows'=>4,'entity_id'=>$_smarty_tpl->tpl_vars['product']->value['productid'],'entity_type'=>'product_fulldescr'), 0);?>

  <?php if ($_smarty_tpl->tpl_vars['product']->value['xss_fulldescr']=="Y") {?><font class="Star">&lt;&lt;</font><?php }?>
</div>
  </td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead">&nbsp;</td><?php }?>
  <td colspan="2"><?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_html_tags_in_description'];?>
</td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[title_tag]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_title_tag'];?>
:</td>
  <td class="ProductDetails"><textarea name="title_tag" maxlength="255" cols="45" rows="6" class="InputWidth"><?php echo $_smarty_tpl->tpl_vars['product']->value['title_tag'];?>
</textarea></td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[meta_keywords]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_meta_keywords'];?>
:</td>
  <td class="ProductDetails"><textarea name="meta_keywords" maxlength="255" cols="45" rows="6" class="InputWidth"><?php echo $_smarty_tpl->tpl_vars['product']->value['meta_keywords'];?>
</textarea></td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[meta_description]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_meta_description'];?>
:</td>
  <td class="ProductDetails"><textarea name="meta_description" maxlength="255" cols="45" rows="6" class="InputWidth"><?php echo $_smarty_tpl->tpl_vars['product']->value['meta_description'];?>
</textarea></td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td class="TableSubHead">&nbsp;</td><?php }?>
  <td colspan="2"><hr /></td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><?php if ($_smarty_tpl->tpl_vars['product']->value['is_variants']=='Y') {?>&nbsp;<?php } else { ?><input type="checkbox" value="Y" name="fields[price]" /><?php }?></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php if (!$_smarty_tpl->tpl_vars['is_pconf']->value) {
echo $_smarty_tpl->tpl_vars['lng']->value['lbl_price'];
} else {
echo $_smarty_tpl->tpl_vars['lng']->value['lbl_pconf_base_price'];
}?> (<?php echo $_smarty_tpl->tpl_vars['config']->value['General']['currency_symbol'];?>
):</td>
  <td class="ProductDetails">
<?php if ($_smarty_tpl->tpl_vars['product']->value['is_variants']=='Y') {?>
<b><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_note'];?>
:</b> <?php echo smarty_modifier_substitute($_smarty_tpl->tpl_vars['lng']->value['txt_pvariant_edit_note'],"href",$_smarty_tpl->tpl_vars['variant_href']->value);?>

<?php } else { ?>
  <input type="text" name="price" size="18" value="<?php echo (($tmp = @smarty_modifier_formatprice($_smarty_tpl->tpl_vars['product']->value['price']))===null||empty($tmp) ? $_smarty_tpl->tpl_vars['zero']->value : $tmp);?>
" />
  <?php if ($_smarty_tpl->tpl_vars['top_message']->value['fillerror']!=''&&$_smarty_tpl->tpl_vars['product']->value['price']=='') {?><font class="Star">&lt;&lt;</font><?php }?>
<?php }?>
  </td>
</tr>

<?php if (!$_smarty_tpl->tpl_vars['is_pconf']->value) {?>
<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[list_price]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_list_price'];?>
 <span class="Text">(<?php echo $_smarty_tpl->tpl_vars['config']->value['General']['currency_symbol'];?>
):</span></td>
  <td class="ProductDetails">
  <?php if ($_smarty_tpl->tpl_vars['product']->value['is_variants']=='Y'&&$_smarty_tpl->tpl_vars['config']->value['Product_Options']['po_use_list_price_variants']=='Y') {?>
    <b><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_note'];?>
:</b> <?php echo smarty_modifier_substitute($_smarty_tpl->tpl_vars['lng']->value['txt_pvariant_edit_note'],"href",$_smarty_tpl->tpl_vars['variant_href']->value);?>

  <?php } else { ?>
    <input type="text" name="list_price" size="18" value="<?php echo (($tmp = @smarty_modifier_formatprice($_smarty_tpl->tpl_vars['product']->value['list_price']))===null||empty($tmp) ? $_smarty_tpl->tpl_vars['zero']->value : $tmp);?>
" />
  <?php }?>
  </td>
</tr>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Cost_Pricing']!='') {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/Cost_Pricing/product_modify_cost.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['XPayments_Subscriptions']) {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/XPayments_Subscriptions/product_details.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><?php if ($_smarty_tpl->tpl_vars['product']->value['is_variants']=='Y') {?>&nbsp;<?php } else { ?><input type="checkbox" value="Y" name="fields[avail]" /><?php }?></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_quantity_in_stock'];?>
:</td>
  <td class="ProductDetails">
<?php if ($_smarty_tpl->tpl_vars['product']->value['is_variants']=='Y') {?>
<b><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_note'];?>
:</b> <?php echo smarty_modifier_substitute($_smarty_tpl->tpl_vars['lng']->value['txt_pvariant_edit_note'],"href",$_smarty_tpl->tpl_vars['variant_href']->value);?>

<?php } else { ?>
  <input type="text" name="avail" size="18" value="<?php if ($_smarty_tpl->tpl_vars['product']->value['productid']=='') {
echo (($tmp = @$_smarty_tpl->tpl_vars['product']->value['avail'])===null||empty($tmp) ? 1000 : $tmp);
} else {
echo $_smarty_tpl->tpl_vars['product']->value['avail'];
}?>" />
  <?php if ($_smarty_tpl->tpl_vars['top_message']->value['fillerror']!=''&&$_smarty_tpl->tpl_vars['product']->value['avail']=='') {?><font class="Star">&lt;&lt;</font><?php }?>
<?php }?>
  </td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[low_avail_limit]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_lowlimit_in_stock'];?>
:</td>
  <td class="ProductDetails">
  <input type="text" name="low_avail_limit" size="18" value="<?php if ($_smarty_tpl->tpl_vars['product']->value['productid']=='') {?>10<?php } else {
echo $_smarty_tpl->tpl_vars['product']->value['low_avail_limit'];
}?>" />
  <?php if ($_smarty_tpl->tpl_vars['top_message']->value['fillerror']!=''&&$_smarty_tpl->tpl_vars['product']->value['low_avail_limit']<=0) {?><font class="Star">&lt;&lt;</font><?php }?>
  </td>
</tr>
<?php }?>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[min_amount]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_min_order_amount'];?>
:</td>
  <td class="ProductDetails"><input type="text" name="min_amount" size="18" value="<?php if ($_smarty_tpl->tpl_vars['product']->value['productid']=='') {?>1<?php } else {
echo $_smarty_tpl->tpl_vars['product']->value['min_amount'];
}?>" /></td>
</tr>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['RMA']!=''&&!$_smarty_tpl->tpl_vars['is_pconf']->value) {?>
<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[return_time]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_return_time'];?>
:</td>
  <td class="ProductDetails"><input type="text" name="return_time" size="18" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['return_time'];?>
" /></td>
</tr>
<?php }?>

<?php if (!$_smarty_tpl->tpl_vars['is_pconf']->value) {?>
<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td class="TableSubHead">&nbsp;</td><?php }?>
  <td colspan="2"><hr /></td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><?php if ($_smarty_tpl->tpl_vars['product']->value['is_variants']=='Y') {?>&nbsp;<?php } else { ?><input type="checkbox" value="Y" name="fields[weight]" /><?php }?></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_weight'];?>
 (<?php echo $_smarty_tpl->tpl_vars['config']->value['General']['weight_symbol'];?>
):</td>
  <td class="ProductDetails">
<?php if ($_smarty_tpl->tpl_vars['product']->value['is_variants']=='Y') {?>
<b><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_note'];?>
:</b> <?php echo smarty_modifier_substitute($_smarty_tpl->tpl_vars['lng']->value['txt_pvariant_edit_note'],"href",$_smarty_tpl->tpl_vars['variant_href']->value);?>

<?php } else { ?>
  <input type="text" name="weight" size="18" value="<?php echo (($tmp = @smarty_modifier_formatprice($_smarty_tpl->tpl_vars['product']->value['weight']))===null||empty($tmp) ? $_smarty_tpl->tpl_vars['zero']->value : $tmp);?>
" />
<?php }?>
  </td>
</tr>

<?php if ($_smarty_tpl->tpl_vars['product']->value['is_variants']!='Y') {?>
<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><?php if ($_smarty_tpl->tpl_vars['product']->value['is_variants']=='Y') {?>&nbsp;<?php } else { ?><input type="checkbox" value="Y" name="fields[net_weight]" /><?php }?></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_net_weight'];?>
 (<?php echo $_smarty_tpl->tpl_vars['config']->value['General']['weight_symbol'];?>
):</td>
  <td class="ProductDetails">
<?php if ($_smarty_tpl->tpl_vars['product']->value['is_variants']=='Y') {?>
<b><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_note'];?>
:</b> <?php echo smarty_modifier_substitute($_smarty_tpl->tpl_vars['lng']->value['txt_pvariant_edit_note'],"href",$_smarty_tpl->tpl_vars['variant_href']->value);?>

<?php } else { ?>
  <input type="text" name="net_weight" size="18" value="<?php echo (($tmp = @smarty_modifier_formatprice($_smarty_tpl->tpl_vars['product']->value['net_weight']))===null||empty($tmp) ? $_smarty_tpl->tpl_vars['zero']->value : $tmp);?>
" />
<?php }?>
  </td>
</tr>
<?php }?>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[free_shipping]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_free_shipping'];?>
:</td>
  <td class="ProductDetails">
  <select name="free_shipping">
    <option value='N'<?php if ($_smarty_tpl->tpl_vars['product']->value['free_shipping']=='N') {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_no'];?>
</option>
    <option value='Y'<?php if ($_smarty_tpl->tpl_vars['product']->value['free_shipping']=='Y') {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_yes'];?>
</option>
  </select>
  </td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[shipping_freight]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_shipping_freight'];?>
 (<?php echo $_smarty_tpl->tpl_vars['config']->value['General']['currency_symbol'];?>
):</td>
  <td class="ProductDetails">
  <input type="text" name="shipping_freight" size="18" value="<?php echo (($tmp = @smarty_modifier_formatprice($_smarty_tpl->tpl_vars['product']->value['shipping_freight']))===null||empty($tmp) ? $_smarty_tpl->tpl_vars['zero']->value : $tmp);?>
" />
  </td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[small_item]" /></td><?php }?>
  <td class="FormButton"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_small_item'];?>
:</td>
  <td class="ProductDetails">
  <input type="checkbox" name="small_item" value="Y"<?php if ($_smarty_tpl->tpl_vars['product']->value['small_item']!="Y") {?> checked="checked"<?php }?> onclick="javascript: switchPDims(this);" />
  </td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[dimensions]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_shipping_box_dimensions'];?>
 (<?php echo $_smarty_tpl->tpl_vars['config']->value['General']['dimensions_symbol'];?>
):</td>
  <td class="ProductDetails">
  <table cellpadding="0" cellspacing="1" border="0" width="100%">
  <tr>
    <td colspan="2"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_length'];?>
</td>
    <td colspan="2"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_width'];?>
</td>
    <td colspan="3"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_height'];?>
</td>
  </tr>
  <tr>
    <td><input type="text" name="length" size="6" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['product']->value['length'])===null||empty($tmp) ? $_smarty_tpl->tpl_vars['zero']->value : $tmp);?>
"<?php if ($_smarty_tpl->tpl_vars['product']->value['small_item']=="Y") {?> disabled="disabled"<?php }?> /></td>
    <td>&nbsp;x&nbsp;</td>
    <td><input type="text" name="width" size="6" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['product']->value['width'])===null||empty($tmp) ? $_smarty_tpl->tpl_vars['zero']->value : $tmp);?>
"<?php if ($_smarty_tpl->tpl_vars['product']->value['small_item']=="Y") {?> disabled="disabled"<?php }?> /></td>
    <td>&nbsp;x&nbsp;</td>
    <td><input type="text" name="height" size="6" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['product']->value['height'])===null||empty($tmp) ? $_smarty_tpl->tpl_vars['zero']->value : $tmp);?>
"<?php if ($_smarty_tpl->tpl_vars['product']->value['small_item']=="Y") {?> disabled="disabled"<?php }?> /></td>
    <td align="center" width="100%"><?php if ($_smarty_tpl->tpl_vars['new_product']->value==1) {?>&nbsp;<?php } else { ?><a href="javascript:void(0);" onclick="javascript: popupOpen('unavailable_shipping.php?id=<?php echo $_smarty_tpl->tpl_vars['product']->value['productid'];?>
', '', {width:550,height:500});"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_check_for_unavailable_shipping_methods'];?>
</a><?php }?></td>
  </tr>
  </table>
  </td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[separate_box]" /></td><?php }?>
  <td class="FormButton"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_ship_in_separate_box'];?>
:</td>
  <td class="ProductDetails">
  <input type="checkbox" name="separate_box" value="Y"<?php if ($_smarty_tpl->tpl_vars['product']->value['separate_box']=="Y") {?> checked="checked"<?php }
if ($_smarty_tpl->tpl_vars['product']->value['small_item']=="Y") {?> disabled="disabled"<?php }?> onclick="javascript: switchSSBox(this);" />
  </td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[items_per_box]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_items_per_box'];?>
:</td>
  <td class="ProductDetails">
  <input type="text" name="items_per_box" size="18" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['product']->value['items_per_box'])===null||empty($tmp) ? 1 : $tmp);?>
"<?php if ($_smarty_tpl->tpl_vars['product']->value['small_item']=="Y"||$_smarty_tpl->tpl_vars['product']->value['separate_box']!="Y") {?> disabled="disabled"<?php }?> />
  </td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td class="TableSubHead">&nbsp;</td><?php }?>
  <td colspan="2"><hr /></td>
</tr>
<?php }?> 

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[membershipids]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_membership'];?>
:</td>
  <td class="ProductDetails"><?php echo $_smarty_tpl->getSubTemplate ("main/membership_selector.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('data'=>$_smarty_tpl->tpl_vars['product']->value), 0);?>
</td>
</tr>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['AvaTax']!='') {?>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[avatax_tax_code]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_avatax_tax_code'];?>
:</td>
  <td class="ProductDetails"><input type="text" name="avatax_tax_code" size="18" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['avatax_tax_code'];?>
" /></td>
<?php }?>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[free_tax]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_tax_exempt'];?>
:</td>
  <td class="ProductDetails">
  <select name="free_tax"<?php if ($_smarty_tpl->tpl_vars['taxes']->value) {?> onchange="javascript: ChangeTaxesBoxStatus(this);"<?php }?>>
    <option value='N'<?php if ($_smarty_tpl->tpl_vars['product']->value['free_tax']=='N') {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_no'];?>
</option>
    <option value='Y'<?php if ($_smarty_tpl->tpl_vars['product']->value['free_tax']=='Y') {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_yes'];?>
</option>
  </select>
  </td>
</tr>

<?php if ($_smarty_tpl->tpl_vars['taxes']->value) {?>
<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[taxes]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_apply_taxes'];?>
:</td>
  <td class="ProductDetails">
  <select name="taxes[]" multiple="multiple"<?php if ($_smarty_tpl->tpl_vars['product']->value['free_tax']=="Y") {?> disabled="disabled"<?php }?>>
  <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['tax'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['tax']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['name'] = 'tax';
$_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['taxes']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['tax']['total']);
?>
  <option value="<?php echo $_smarty_tpl->tpl_vars['taxes']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tax']['index']]['taxid'];?>
"<?php if ($_smarty_tpl->tpl_vars['taxes']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tax']['index']]['selected']>0) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['taxes']->value[$_smarty_tpl->getVariable('smarty')->value['section']['tax']['index']]['tax_name'];?>
</option>
  <?php endfor; endif; ?>
  </select>
  <br /><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_hold_ctrl_key'];?>

  <?php if ($_smarty_tpl->tpl_vars['is_admin_user']->value) {?><br /><a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['provider'];?>
/taxes.php" class="SmallNote" target="_blank"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_click_here_to_manage_taxes'];?>
</a><?php }?>
  </td>
</tr>
<?php }?>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[discount_avail]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_apply_global_discounts'];?>
:</td>
  <td class="ProductDetails">
  <input type="checkbox" name="discount_avail" value="Y"<?php if ($_smarty_tpl->tpl_vars['product']->value['productid']==''||$_smarty_tpl->tpl_vars['product']->value['discount_avail']=="Y") {?> checked="checked"<?php }?> />
  </td>
</tr>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Extra_Fields']!='') {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Extra_Fields/product_modify.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Special_Offers']) {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/Special_Offers/product_modify.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['TaxCloud']!='') {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/TaxCloud/product_modify.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['On_Sale']) {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/On_Sale/on_sale_product_modify_checkbox.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('product'=>$_smarty_tpl->tpl_vars['product']->value), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['New_Arrivals']) {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/New_Arrivals/new_arrivals_product_modify_fields.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('product'=>$_smarty_tpl->tpl_vars['product']->value), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Facebook_Ecommerce']) {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/Facebook_Ecommerce/product_modify.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('product'=>$_smarty_tpl->tpl_vars['product']->value), 0);?>

<?php }?>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td class="TableSubHead">&nbsp;</td><?php }?>
  <td colspan="2" align="center">
    <br /><br />
    <div id="sticky_content">
    <table width="100%">
      <tr>
        <td width="120" align="left" class="main-button">
          <input type="submit" class="big-main-button" value=" <?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_apply_changes']), ENT_QUOTES, 'UTF-8', true);?>
 " />
        </td>
        <td width="100%" align="right">
          <?php if ($_smarty_tpl->tpl_vars['product']->value['productid']>0) {?>
            <input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_preview']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: window.open('<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['customer'];?>
/product.php?productid=<?php echo $_smarty_tpl->tpl_vars['product']->value['productid'];?>
&amp;is_admin_preview=Y', '_blank');" /> &nbsp;&nbsp;&nbsp;
            <input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_clone']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: submitForm(this.form, 'clone');" />&nbsp;&nbsp;&nbsp;
            <input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_delete']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: submitForm(this.form, 'delete');" />&nbsp;&nbsp;&nbsp;
            <input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_generate_html_links']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: submitForm(this.form, 'links');" />
          <?php }?>
        </td>
      </tr>
    </table>
    </div>
  </td>
</tr>

</table>
</form>

<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<?php echo $_smarty_tpl->getSubTemplate ("dialog.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('content'=>Smarty::$_smarty_vars['capture']['dialog'],'extra'=>'width="100%"'), 0);?>


<?php if ($_smarty_tpl->tpl_vars['new_product']->value!="1"&&$_smarty_tpl->tpl_vars['geid']->value=='') {?>
  <br />
  <?php echo $_smarty_tpl->getSubTemplate ("main/clean_urls.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('resource_name'=>"productid",'resource_id'=>$_smarty_tpl->tpl_vars['productid']->value,'clean_url_action'=>"product_modify.php",'clean_urls_history_mode'=>"clean_urls_history",'clean_urls_history'=>$_smarty_tpl->tpl_vars['product']->value['clean_urls_history']), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['product_details_standalone']->value) {?>
<?php echo smarty_function_load_defer_code(array('type'=>"css"),$_smarty_tpl);?>

<?php echo smarty_function_load_defer_code(array('type'=>"js"),$_smarty_tpl);?>

<?php }?>
<?php }} ?>
