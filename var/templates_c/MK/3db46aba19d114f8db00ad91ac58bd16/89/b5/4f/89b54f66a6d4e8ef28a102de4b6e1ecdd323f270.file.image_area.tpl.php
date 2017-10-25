<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:53
         compiled from "D:\website\MK\skin\common_files\main\image_area.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1938159ef3205c7abb2-20153816%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '89b54f66a6d4e8ef28a102de4b6e1ecdd323f270' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\image_area.tpl',
      1 => 1496750442,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1938159ef3205c7abb2-20153816',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'geid' => 0,
    'lng' => 0,
    'product' => 0,
    'SkinDir' => 0,
    'ImagesDir' => 0,
    'gdlib_enabled' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef3205cdbed0_02329912',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef3205cdbed0_02329912')) {function content_59ef3205cdbed0_02329912($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_wm_remove')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.wm_remove.php';
?>
<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead">&nbsp;</td><?php }?>
  <td colspan="2"><?php echo $_smarty_tpl->getSubTemplate ("main/subheader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_product_images']), 0);?>
</td>
</tr>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead">&nbsp;</td><?php }?>

<td colspan="2">
<table width="100%" cellpadding="1" cellspacing="1">
<tr>
<td width="50%" valign="top" align="left">

<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[
var  old_widthT = "<?php echo $_smarty_tpl->tpl_vars['product']->value['images']['T']['new_x'];?>
";
var  old_heightT = "<?php echo $_smarty_tpl->tpl_vars['product']->value['images']['T']['new_y'];?>
";
var  old_widthP = "<?php echo $_smarty_tpl->tpl_vars['product']->value['images']['P']['new_x'];?>
";
var  old_heightP = "<?php echo $_smarty_tpl->tpl_vars['product']->value['images']['P']['new_y'];?>
";
var  geid = "<?php echo $_smarty_tpl->tpl_vars['geid']->value;?>
";
var lbl_modified = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_modified']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
";
var  lbl_no_image_uploaded= "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_no_image_uploaded']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
";

var  change_buttons = new Array();
change_buttons['T'] = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_upload_thumbnail']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
";
change_buttons['P'] = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_upload_image']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
";
//]]>
<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/js/image_manipulations.js"><?php echo '</script'; ?>
>



<table cellspacing="4" cellpadding="4">
<tr> 
  <td class="ProductDetails" valign="top"><table class="geid-checkbox"><tr><?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td class="geid-checkbox"><input type="checkbox" value="Y" name="fields[image]" id="fields_image" /></td><?php }?><td><font class="FormButton"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_image'];?>
:</font></td></tr></table></td>
  <?php if ($_smarty_tpl->tpl_vars['product']->value['is_pimage']) {
if (isset($_smarty_tpl->tpl_vars["no_delete"])) {$_smarty_tpl->tpl_vars["no_delete"] = clone $_smarty_tpl->tpl_vars["no_delete"];
$_smarty_tpl->tpl_vars["no_delete"]->value = ''; $_smarty_tpl->tpl_vars["no_delete"]->nocache = null; $_smarty_tpl->tpl_vars["no_delete"]->scope = 0;
} else $_smarty_tpl->tpl_vars["no_delete"] = new Smarty_variable('', null, 0);
} else {
if (isset($_smarty_tpl->tpl_vars["no_delete"])) {$_smarty_tpl->tpl_vars["no_delete"] = clone $_smarty_tpl->tpl_vars["no_delete"];
$_smarty_tpl->tpl_vars["no_delete"]->value = "Y"; $_smarty_tpl->tpl_vars["no_delete"]->nocache = null; $_smarty_tpl->tpl_vars["no_delete"]->scope = 0;
} else $_smarty_tpl->tpl_vars["no_delete"] = new Smarty_variable("Y", null, 0);
}?>
</tr>
<tr>
  <td class="ProductDetails" valign="top" align="left">
  <?php echo $_smarty_tpl->getSubTemplate ("main/edit_product_image.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('type'=>"P",'id'=>$_smarty_tpl->tpl_vars['product']->value['productid'],'button_name'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_save'],'idtag'=>"edit_product_image",'image'=>$_smarty_tpl->tpl_vars['product']->value['image']['P'],'already_loaded'=>$_smarty_tpl->tpl_vars['product']->value['is_image_P'],'image_x'=>$_smarty_tpl->tpl_vars['product']->value['images']['P']['new_x'],'image_y'=>$_smarty_tpl->tpl_vars['product']->value['images']['P']['new_y']), 0);?>

  <br />
  <span id="original_image_descr_P"><?php if ($_smarty_tpl->tpl_vars['product']->value['is_pimage']) {
echo $_smarty_tpl->getSubTemplate ("main/image_property2.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('image'=>$_smarty_tpl->tpl_vars['product']->value['image']['P']), 0);
} else {
echo $_smarty_tpl->tpl_vars['lng']->value['lbl_no_image_uploaded'];
}?></span>
  <span id="modified_image_descr_P" style="display: none;"></span>
  <br /><br />
  </td>
</tr>

<tr>
<td class="ProductDetails" valign="top" align="left" style="padding: 4px 4px 10px 4px;">
  <input id="change_image" type="button" value="<?php if ($_smarty_tpl->tpl_vars['product']->value['is_pimage']) {
echo $_smarty_tpl->tpl_vars['lng']->value['lbl_change_image'];
} else {
echo $_smarty_tpl->tpl_vars['lng']->value['lbl_upload_image'];
}?>" onclick='javascript: popup_image_selection("P", "<?php echo $_smarty_tpl->tpl_vars['product']->value['productid'];?>
", "edit_product_image");' />
<br />

</td>
</tr>

<tr <?php if (!$_smarty_tpl->tpl_vars['product']->value['is_pimage']) {?>style="display: none;" id="edit_product_image_reset2"<?php }?>>
  <td class="SubHeaderLine" style="BACKGROUND-COLOR: #d3d3d3;"><img src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/spacer.gif" class="Spc" alt="" /><br /></td>
</tr> 

<tr id="edit_product_image_reset" style="display: none;">
<td class="ProductDetails" valign="top" align="left" style="padding: 10px 4px 4px 4px;">
  <input id="Pimage_reset" type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_reset_image']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: $('#edit_product_image').attr('src', '<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/spacer.gif');popup_image_selection_reset('P', '<?php echo $_smarty_tpl->tpl_vars['product']->value['productid'];?>
', 'edit_product_image'); reset_descr('P', 'edit_product_image', old_widthP, old_heightP);" />
</td>
</tr>

<tr id="Pimage_button3" <?php if (!$_smarty_tpl->tpl_vars['product']->value['is_pimage']) {?>style="display: none;"<?php }?>>
<td class="ProductDetails" valign="top" align="left">
  <input type="button" value="<?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_delete_image'];?>
" onclick="javascript: try { delete_image('edit_product_image', 'P', '<?php echo $_smarty_tpl->tpl_vars['product']->value['productid'];?>
', 'change_image'); } catch (err) { submitForm(this, 'delete_product_image'); }" />
</td>
</tr>
</table>



</td>

<td width="50%" valign="top" align="left">



<table cellspacing="4" cellpadding="4">
<tr>
  <td class="ProductDetails" valign="top"><table class="geid-checkbox"><tr><?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td class="geid-checkbox"><input type="checkbox" value="Y" name="fields[thumbnail]" id="fields_thumbnail" /></td><?php }?><td><font class="FormButton"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_thumbnail'];?>
:</font></td></tr></table></td>
  <?php if ($_smarty_tpl->tpl_vars['product']->value['is_thumbnail']) {
if (isset($_smarty_tpl->tpl_vars["no_delete"])) {$_smarty_tpl->tpl_vars["no_delete"] = clone $_smarty_tpl->tpl_vars["no_delete"];
$_smarty_tpl->tpl_vars["no_delete"]->value = ''; $_smarty_tpl->tpl_vars["no_delete"]->nocache = null; $_smarty_tpl->tpl_vars["no_delete"]->scope = 0;
} else $_smarty_tpl->tpl_vars["no_delete"] = new Smarty_variable('', null, 0);
} else {
if (isset($_smarty_tpl->tpl_vars["no_delete"])) {$_smarty_tpl->tpl_vars["no_delete"] = clone $_smarty_tpl->tpl_vars["no_delete"];
$_smarty_tpl->tpl_vars["no_delete"]->value = "Y"; $_smarty_tpl->tpl_vars["no_delete"]->nocache = null; $_smarty_tpl->tpl_vars["no_delete"]->scope = 0;
} else $_smarty_tpl->tpl_vars["no_delete"] = new Smarty_variable("Y", null, 0);
}?>
</tr>
<tr>
<td class="ProductDetails" valign="top" align="left">

  <table cellpadding="0" cellspacing="0">
  <tr><td valign="top" align="left">
  <?php echo $_smarty_tpl->getSubTemplate ("main/edit_product_image.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('type'=>"T",'id'=>$_smarty_tpl->tpl_vars['product']->value['productid'],'delete_js'=>"submitForm(this, 'delete_thumbnail');",'button_name'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_save'],'image'=>$_smarty_tpl->tpl_vars['product']->value['image']['T'],'already_loaded'=>$_smarty_tpl->tpl_vars['product']->value['is_image_T'],'image_x'=>$_smarty_tpl->tpl_vars['product']->value['images']['T']['new_x'],'image_y'=>$_smarty_tpl->tpl_vars['product']->value['images']['T']['new_y']), 0);?>

  <br />
  <span id="original_image_descr_T"><?php if ($_smarty_tpl->tpl_vars['product']->value['is_thumbnail']) {
echo $_smarty_tpl->getSubTemplate ("main/image_property2.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('image'=>$_smarty_tpl->tpl_vars['product']->value['image']['T']), 0);
} else {
echo $_smarty_tpl->tpl_vars['lng']->value['lbl_no_thumbnail_uploaded'];
}?></span>
  <span id="modified_image_descr_T" style="display: none;"></span>
  </td>
  <td class="Product_Details" valign="top" align="left">
    &nbsp;&nbsp;
    <?php echo $_smarty_tpl->getSubTemplate ("main/tooltip_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('text'=>$_smarty_tpl->tpl_vars['lng']->value['txt_need_thumbnail_help']), 0);?>

  </td>
  </tr>
  </table>

  <span class="ImageNotes"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_thumbnail_msg'];?>
</span>

</td>
</tr>

<tr>
<td class="ProductDetails" valign="top" align="left" <?php if (!$_smarty_tpl->tpl_vars['product']->value['is_pimage']||!$_smarty_tpl->tpl_vars['gdlib_enabled']->value) {?>style="padding: 4px 4px 10px 4px;"<?php }?>>
  <input id="change_thumbnail" type="button" value="<?php if ($_smarty_tpl->tpl_vars['product']->value['is_thumbnail']) {
echo $_smarty_tpl->tpl_vars['lng']->value['lbl_change_thumbnail'];
} else {
echo $_smarty_tpl->tpl_vars['lng']->value['lbl_upload_thumbnail'];
}?>" onclick='javascript: popup_image_selection("T", "<?php echo $_smarty_tpl->tpl_vars['product']->value['productid'];?>
", "edit_image");' />
</td>
</tr>

<?php if ($_smarty_tpl->tpl_vars['gdlib_enabled']->value) {?>

<tr id="tr_generate_thumbnail" <?php if (!$_smarty_tpl->tpl_vars['product']->value['is_pimage']) {?>style="display: none;"<?php }?>>
<td class="ProductDetails" nowrap="nowrap" valign="top" align="left" style="padding: 4px 4px 10px 4px;">
  <input type="button" id="generate_thumbnail" value="<?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_generate_thumbnail'];?>
" onclick="javascript: try { gen_thumbnail('<?php echo $_smarty_tpl->tpl_vars['product']->value['productid'];?>
'); } catch(err) { submitForm(this, 'generate_thumbnail'); };" />
</td>
</tr>

<?php }?>

<tr <?php if (!$_smarty_tpl->tpl_vars['product']->value['is_thumbnail']) {?>style="display: none;" id="edit_image_reset2"<?php }?>>
  <td class="SubHeaderLine" style="BACKGROUND-COLOR: #d3d3d3"><img src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/spacer.gif" class="Spc" alt="" /><br /></td>
</tr>

<tr id="edit_image_reset" style="display: none;">
<td class="ProductDetails" valign="top" align="left" style="padding: 10px 4px 4px 4px;">
  <input id="Timage_reset" type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_reset_thumbnail']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: $('#edit_image').attr('src', '<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/spacer.gif'); popup_image_selection_reset('T', '<?php echo $_smarty_tpl->tpl_vars['product']->value['productid'];?>
', 'edit_image'); reset_descr('T', 'edit_image', old_widthT, old_heightT);" />
</td>
</tr>

<tr id="Timage_button3" <?php if (!$_smarty_tpl->tpl_vars['product']->value['is_thumbnail']) {?>style="display: none;"<?php }?>>
<td class="ProductDetails" valign="top" align="left">
  <input type="button" value="<?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_delete_thumbnail'];?>
" onclick="javascript: try { delete_image('edit_image', 'T', '<?php echo $_smarty_tpl->tpl_vars['product']->value['productid'];?>
', 'change_thumbnail'); } catch (err) { submitForm(this, 'delete_thumbnail'); }" />
</td>
</tr>

</table>



</td>
</tr>
</table>

</td>
</tr>

<tr id='image_save_msg' style="display: none;">
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead">&nbsp;</td><?php }?>
  <td colspan="2" class="ImageNotes" nowrap="nowrap" align="center"><br /><br /><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_product_image_save_msg'];?>
<br /><br /><input type="submit" value=" <?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_save']), ENT_QUOTES, 'UTF-8', true);?>
 " /></td>
</tr>

<?php if (!$_smarty_tpl->tpl_vars['gdlib_enabled']->value) {?>
<tr>
<?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead">&nbsp;</td><?php }?>
<td colspan="2" class="ImageNotes"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_auto_resize_no_gd_library'];?>
</td>
</tr>
<?php }?>
<?php }} ?>
