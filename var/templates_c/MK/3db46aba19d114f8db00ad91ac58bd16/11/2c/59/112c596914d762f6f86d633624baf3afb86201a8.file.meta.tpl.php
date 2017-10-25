<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:10:33
         compiled from "D:\website\MK\skin\common_files\meta.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2992459ec527937c7d8-52151435%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '112c596914d762f6f86d633624baf3afb86201a8' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\meta.tpl',
      1 => 1496750446,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2992459ec527937c7d8-52151435',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'default_charset' => 0,
    'usertype' => 0,
    'current_language' => 0,
    'store_language' => 0,
    'current_location' => 0,
    '__frame_not_allowed' => 0,
    'SkinDir' => 0,
    'config' => 0,
    'single_mode' => 0,
    'webmaster_mode' => 0,
    'catalogs' => 0,
    'ImagesDir' => 0,
    'webmaster_lng' => 0,
    'lbl_name' => 0,
    'lbl_val' => 0,
    'user_agent' => 0,
    'active_modules' => 0,
    'lng' => 0,
    'development_mode_enabled' => 0,
    'gmap_enabled' => 0,
    'is_https_zone' => 0,
    'xauth_include_js' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec52793c7df5_64168543',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec52793c7df5_64168543')) {function content_59ec52793c7df5_64168543($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_wm_remove')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.wm_remove.php';
if (!is_callable('smarty_function_load_defer')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer.php';
if (!is_callable('smarty_function_load_defer_code')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer_code.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo (($tmp = @$_smarty_tpl->tpl_vars['default_charset']->value)===null||empty($tmp) ? "utf-8" : $tmp);?>
" />
<meta http-equiv="X-UA-Compatible" content="<?php echo $_smarty_tpl->getConfigVariable('XUACompatible');?>
" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Language" content="<?php if (($_smarty_tpl->tpl_vars['usertype']->value=="P"||$_smarty_tpl->tpl_vars['usertype']->value=="A")&&$_smarty_tpl->tpl_vars['current_language']->value!='') {
echo htmlspecialchars($_smarty_tpl->tpl_vars['current_language']->value, ENT_QUOTES, 'UTF-8', true);
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['store_language']->value, ENT_QUOTES, 'UTF-8', true);
}?>" />
<meta name="robots" content="noindex, nofollow" />

<link rel="shortcut icon" type="image/png" href="<?php echo $_smarty_tpl->tpl_vars['current_location']->value;?>
/favicon.ico" />

<?php if ($_smarty_tpl->tpl_vars['__frame_not_allowed']->value) {?>
<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[
if (top != self && top.location.hostname != self.location.hostname)
  top.location = self.location;
//]]>
<?php echo '</script'; ?>
>
<?php }?>
<?php echo $_smarty_tpl->getSubTemplate ("presets_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/js/common.js"><?php echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['config']->value['Adaptives']['is_first_start']=='Y') {?>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/js/browser_identificator.js"><?php echo '</script'; ?>
>
<?php }?>
<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[
var constants = new Object();
<?php if ($_smarty_tpl->tpl_vars['usertype']->value=="A"||($_smarty_tpl->tpl_vars['usertype']->value=="P"&&$_smarty_tpl->tpl_vars['single_mode']->value)) {?>
constants.DIR_CUSTOMER = "<?php echo @constant('DIR_CUSTOMER');?>
";
constants.DIR_ADMIN = "<?php echo @constant('DIR_ADMIN');?>
";
constants.DIR_PROVIDER = "<?php echo @constant('DIR_PROVIDER');?>
";
constants.DIR_PARTNER = "<?php echo @constant('DIR_PARTNER');?>
";
<?php }?>
//]]>
<?php echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['webmaster_mode']->value=="editor") {?>
<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[
var store_language = "<?php if (($_smarty_tpl->tpl_vars['usertype']->value=="P"||$_smarty_tpl->tpl_vars['usertype']->value=="A")&&$_smarty_tpl->tpl_vars['current_language']->value!='') {
echo strtr($_smarty_tpl->tpl_vars['current_language']->value, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));
} else {
echo strtr($_smarty_tpl->tpl_vars['store_language']->value, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));
}?>";
var catalogs = new Object();
catalogs.admin = "<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
";
catalogs.provider = "<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['provider'];?>
";
catalogs.customer = "<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['customer'];?>
";
catalogs.partner = "<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['partner'];?>
";
catalogs.images = "<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
";
catalogs.skin = "<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
";
var lng_labels = [];
<?php  $_smarty_tpl->tpl_vars['lbl_val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['lbl_val']->_loop = false;
 $_smarty_tpl->tpl_vars['lbl_name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['webmaster_lng']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['lbl_val']->key => $_smarty_tpl->tpl_vars['lbl_val']->value) {
$_smarty_tpl->tpl_vars['lbl_val']->_loop = true;
 $_smarty_tpl->tpl_vars['lbl_name']->value = $_smarty_tpl->tpl_vars['lbl_val']->key;
?>
lng_labels['<?php echo $_smarty_tpl->tpl_vars['lbl_name']->value;?>
'] = '<?php echo $_smarty_tpl->tpl_vars['lbl_val']->value;?>
';
<?php } ?>
var page_charset = "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['default_charset']->value)===null||empty($tmp) ? "utf-8" : $tmp);?>
";
//]]>
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" language="JavaScript 1.2" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/js/editor_common.js"><?php echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['user_agent']->value=="ns") {?>
<?php echo '<script'; ?>
 type="text/javascript" language="JavaScript 1.2" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/js/editorns.js"><?php echo '</script'; ?>
>
<?php } else { ?>
<?php echo '<script'; ?>
 type="text/javascript" language="JavaScript 1.2" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/js/editor.js"><?php echo '</script'; ?>
>
<?php }?>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Magnifier']!='') {?>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/lib/swfobject-min.js"><?php echo '</script'; ?>
>
<?php }?>

<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[
var lbl_error = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_error']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
';
var lbl_warning = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_warning']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
';
var lbl_information = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_information']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
';
var lbl_go_to_last_edit_section = '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_go_to_last_edit_section']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
';
var topMessageDelay = [];
topMessageDelay['i'] = <?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['Appearance']['delay_value'])===null||empty($tmp) ? 10 : $tmp);?>
*1000;
topMessageDelay['w'] = <?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['Appearance']['delay_value_w'])===null||empty($tmp) ? 60 : $tmp);?>
*1000;
topMessageDelay['e'] = <?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['Appearance']['delay_value_e'])===null||empty($tmp) ? 0 : $tmp);?>
*1000;
//]]>
<?php echo '</script'; ?>
>

<!--[if lt IE 9]>
  <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/lib/jquery-min.1x.js"><?php echo '</script'; ?>
>
<![endif]-->
<!--[if gte IE 9]><!-->
  <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/lib/jquery-min.js"><?php echo '</script'; ?>
>
<!--<![endif]-->

<?php echo smarty_function_load_defer(array('file'=>"widgets/css_loader.js",'type'=>"js"),$_smarty_tpl);?>


<?php if ($_smarty_tpl->tpl_vars['development_mode_enabled']->value) {?>
  <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/lib/jquery-migrate.development.js"><?php echo '</script'; ?>
>
<?php } else { ?>
  <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/lib/jquery-migrate.production.js"><?php echo '</script'; ?>
>
<?php }?>

<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/lib/cluetip/jquery.cluetip.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/lib/jquery_cookie.js"><?php echo '</script'; ?>
>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/lib/cluetip/jquery.cluetip.css" />

<?php if ($_smarty_tpl->tpl_vars['gmap_enabled']->value) {?>
<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[
var gmapGeocodeError="<?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_gmap_geocode_error'];?>
";
var lbl_close="<?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_close'];?>
";
//]]>
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php if ($_smarty_tpl->tpl_vars['is_https_zone']->value) {?>https<?php } else { ?>http<?php }?>://maps.google.com/maps/api/js?key=<?php echo $_smarty_tpl->tpl_vars['config']->value['General']['google_maps_api_key'];?>
"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/js/gmap.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/js/modal.js"><?php echo '</script'; ?>
>
<?php }?>

<?php echo $_smarty_tpl->getSubTemplate ("jquery_ui.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[

$(document).ready( function() {
  $('form').not('.skip-auto-validation').each( function() {
    applyCheckOnSubmit(this);
  });

  $("input:submit, input:button, button, a.simple-button").button();
});


//]]>
<?php echo '</script'; ?>
>

<?php if ($_smarty_tpl->tpl_vars['config']->value['Appearance']['enable_admin_context_help']=='Y') {?>
  <?php echo $_smarty_tpl->getSubTemplate ("context_help.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Cloud_Search']!='') {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/Cloud_Search/admin.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('_include_once'=>1), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['XOrder_Statuses']!='') {?>
  <?php echo smarty_function_load_defer(array('file'=>"modules/XOrder_Statuses/common.js",'type'=>"js"),$_smarty_tpl);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['XAuth']!=''&&$_smarty_tpl->tpl_vars['xauth_include_js']->value=='Y') {?>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/modules/XAuth/controller.js"><?php echo '</script'; ?>
>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Bongo_International']) {?>
  <?php echo $_smarty_tpl->getSubTemplate ("modules/Bongo_International/meta.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php echo smarty_function_load_defer(array('file'=>"js/ajax.js",'type'=>"js"),$_smarty_tpl);?>

<?php echo smarty_function_load_defer(array('file'=>"js/top_message.js",'type'=>"js"),$_smarty_tpl);?>

<?php echo smarty_function_load_defer(array('file'=>"js/popup_open.js",'type'=>"js"),$_smarty_tpl);?>

<?php echo smarty_function_load_defer(array('file'=>"lib/jquery.blockUI.min.js",'type'=>"js"),$_smarty_tpl);?>

<?php echo smarty_function_load_defer(array('file'=>"lib/jquery.blockUI.defaults.js",'type'=>"js"),$_smarty_tpl);?>


<?php echo smarty_function_load_defer(array('file'=>"js/sticky.js",'type'=>"js"),$_smarty_tpl);?>


<?php if ($_smarty_tpl->tpl_vars['development_mode_enabled']->value) {?>
  <?php $_smarty_tpl->_capture_stack[0][] = array('js_err_collector', null, null); ob_start(); ?>
    window.onerror=function(msg, url, line) {
        $("body").attr("JSError",msg + "\n" + url + ':' + line);
    };
  <?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
  <?php echo smarty_function_load_defer(array('file'=>"js_err_collector",'direct_info'=>Smarty::$_smarty_vars['capture']['js_err_collector'],'type'=>"js"),$_smarty_tpl);?>

<?php }?>

<?php echo smarty_function_load_defer_code(array('type'=>"css"),$_smarty_tpl);?>

<?php echo smarty_function_load_defer_code(array('type'=>"js"),$_smarty_tpl);?>

<?php }} ?>
