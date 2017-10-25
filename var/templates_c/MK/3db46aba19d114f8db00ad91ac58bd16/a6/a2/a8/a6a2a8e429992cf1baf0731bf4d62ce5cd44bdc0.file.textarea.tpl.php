<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:54
         compiled from "D:\website\MK\skin\common_files\main\textarea.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1704759ef3206528a11-02463021%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a6a2a8e429992cf1baf0731bf4d62ce5cd44bdc0' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\textarea.tpl',
      1 => 1496750446,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1704759ef3206528a11-02463021',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'active_modules' => 0,
    'html_editor_disabled' => 0,
    'name' => 0,
    'usertype' => 0,
    'config' => 0,
    'entity_id' => 0,
    'entity_type' => 0,
    'no_links' => 0,
    'width' => 0,
    'id' => 0,
    'lng' => 0,
    'on_js_editor_ready' => 0,
    'allow_upload_image_ckedit' => 0,
    'cols' => 0,
    'rows' => 0,
    'class' => 0,
    'skip_escape' => 0,
    'data' => 0,
    'style' => 0,
    'disabled' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef32065ad1c6_76048707',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef32065ad1c6_76048707')) {function content_59ef32065ad1c6_76048707($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_regex_replace')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\modifier.regex_replace.php';
?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['HTML_Editor']&&!$_smarty_tpl->tpl_vars['html_editor_disabled']->value) {?>

<?php echo $_smarty_tpl->getSubTemplate ("main/start_textarea.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('_include_once'=>1), 0);?>

<?php if (isset($_smarty_tpl->tpl_vars["id"])) {$_smarty_tpl->tpl_vars["id"] = clone $_smarty_tpl->tpl_vars["id"];
$_smarty_tpl->tpl_vars["id"]->value = smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['name']->value,"/[^\w\d_]/",''); $_smarty_tpl->tpl_vars["id"]->nocache = null; $_smarty_tpl->tpl_vars["id"]->scope = 0;
} else $_smarty_tpl->tpl_vars["id"] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['name']->value,"/[^\w\d_]/",''), null, 0);?>
<?php if (($_smarty_tpl->tpl_vars['usertype']->value=="A"||$_smarty_tpl->tpl_vars['usertype']->value=="P")&&$_smarty_tpl->tpl_vars['config']->value['HTML_Editor']['editor']=='ckeditor') {?>

  <?php echo '<script'; ?>
 type="text/javascript">
  //<![CDATA[
    (function() {
      var formidAntiXss = '#SMARTY_PLACE_FORMID_HERE#';
      var imageParentId = '<?php echo strtr($_smarty_tpl->tpl_vars['entity_id']->value, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
';
      var imageParentType = '<?php echo strtr($_smarty_tpl->tpl_vars['entity_type']->value, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
';
      var config_url = 'ckedit_uploadimage.php?formid=' + formidAntiXss + '&image_parent_id=' + imageParentId + '&image_parent_type=' + imageParentType;

      // global object
      xc_ckeditor_config = {
          uploadUrl: config_url,
          filebrowserUploadUrl: config_url,
          imageUploadUrl: config_url + '&type=dragdrop'
      };
    })();
  //]]>
  <?php echo '</script'; ?>
>
  <?php if (isset($_smarty_tpl->tpl_vars['allow_upload_image_ckedit'])) {$_smarty_tpl->tpl_vars['allow_upload_image_ckedit'] = clone $_smarty_tpl->tpl_vars['allow_upload_image_ckedit'];
$_smarty_tpl->tpl_vars['allow_upload_image_ckedit']->value = 1; $_smarty_tpl->tpl_vars['allow_upload_image_ckedit']->nocache = null; $_smarty_tpl->tpl_vars['allow_upload_image_ckedit']->scope = 0;
} else $_smarty_tpl->tpl_vars['allow_upload_image_ckedit'] = new Smarty_variable(1, null, 0);?>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['no_links']->value!="Y") {?><div class="AELinkBox" style="width: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['width']->value)===null||empty($tmp) ? "80%" : $tmp);?>
;"><a href="javascript:void(0);" style="display: none;" id="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
Dis" onclick="javascript: disableEditor('<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
');"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_default_editor'];?>
</a><b id="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
DisB"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_default_editor'];?>
</b>&nbsp;&nbsp;<a href="javascript:void(0);" id="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
Enb" onclick="javascript: enableEditor('<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
', <?php if ($_smarty_tpl->tpl_vars['on_js_editor_ready']->value) {
echo $_smarty_tpl->tpl_vars['on_js_editor_ready']->value;
} else { ?>''<?php }
if ($_smarty_tpl->tpl_vars['allow_upload_image_ckedit']->value) {?>, xc_ckeditor_config<?php }?>);"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_advanced_editor'];?>
</a><b id="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
EnbB" style="display: none;"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_advanced_editor'];?>
</b></div><?php }?><textarea id="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"<?php if ($_smarty_tpl->tpl_vars['cols']->value) {?> cols="<?php echo $_smarty_tpl->tpl_vars['cols']->value;?>
"<?php }?> <?php if ($_smarty_tpl->tpl_vars['rows']->value) {?> rows="<?php echo $_smarty_tpl->tpl_vars['rows']->value;?>
"<?php }?> class="InputWidth <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
" style="width: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['width']->value)===null||empty($tmp) ? "80%" : $tmp);?>
;"><?php if ($_smarty_tpl->tpl_vars['skip_escape']->value) {
echo $_smarty_tpl->tpl_vars['data']->value;
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value, ENT_QUOTES, 'UTF-8', true);
}?></textarea><div id="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
Box" style="display:none;"><textarea id="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
Adv"<?php if ($_smarty_tpl->tpl_vars['cols']->value) {?> cols="<?php echo $_smarty_tpl->tpl_vars['cols']->value;?>
"<?php }?> <?php if ($_smarty_tpl->tpl_vars['rows']->value) {?> rows="<?php echo $_smarty_tpl->tpl_vars['rows']->value;?>
"<?php }?> class="InputWidth <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
" style="width: 576px;<?php if ($_smarty_tpl->tpl_vars['no_links']->value=="Y") {?>display:none;<?php }?>"><?php if ($_smarty_tpl->tpl_vars['skip_escape']->value) {
echo $_smarty_tpl->tpl_vars['data']->value;
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value, ENT_QUOTES, 'UTF-8', true);
}?></textarea><?php if ($_smarty_tpl->tpl_vars['config']->value['HTML_Editor']['editor']=="ckeditor") {
echo $_smarty_tpl->getSubTemplate ("modules/HTML_Editor/editors/ckeditor/textarea.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id'=>$_smarty_tpl->tpl_vars['id']->value,'name'=>$_smarty_tpl->tpl_vars['name']->value,'data'=>$_smarty_tpl->tpl_vars['data']->value), 0);
} elseif ($_smarty_tpl->tpl_vars['config']->value['HTML_Editor']['editor']=="innovaeditor") {
echo $_smarty_tpl->getSubTemplate ("modules/HTML_Editor/editors/innovaeditor/textarea.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id'=>$_smarty_tpl->tpl_vars['id']->value,'name'=>$_smarty_tpl->tpl_vars['name']->value,'data'=>$_smarty_tpl->tpl_vars['data']->value), 0);
} elseif ($_smarty_tpl->tpl_vars['config']->value['HTML_Editor']['editor']=="tinymce") {
echo $_smarty_tpl->getSubTemplate ("modules/HTML_Editor/editors/tinymce/textarea.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id'=>$_smarty_tpl->tpl_vars['id']->value,'name'=>$_smarty_tpl->tpl_vars['name']->value,'data'=>$_smarty_tpl->tpl_vars['data']->value), 0);
}?></div>

<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[
var isOpen = getCookie('<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
EditorEnabled');
if (isOpen && isOpen == 'Y')
  $('#<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
Enb').click();
//]]>
<?php echo '</script'; ?>
>

<?php } else { ?>
<textarea id="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"<?php if ($_smarty_tpl->tpl_vars['cols']->value) {?> cols="<?php echo $_smarty_tpl->tpl_vars['cols']->value;?>
"<?php }
if ($_smarty_tpl->tpl_vars['rows']->value) {?> rows="<?php echo $_smarty_tpl->tpl_vars['rows']->value;?>
"<?php }?> class="InputWidth <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['style']->value) {?> style="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
"<?php }
if ($_smarty_tpl->tpl_vars['disabled']->value) {?> disabled="disabled"<?php }?>><?php if ($_smarty_tpl->tpl_vars['skip_escape']->value) {
echo $_smarty_tpl->tpl_vars['data']->value;
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value, ENT_QUOTES, 'UTF-8', true);
}?></textarea>

<?php }?>
<?php }} ?>
