<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:09:30
         compiled from "D:\website\MK\skin\common_files\main\tooltip_js.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2565159ec523a296f10-81729717%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eb8734dc73604ea96c99c2ee7a85c284fe1b855e' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\tooltip_js.tpl',
      1 => 1496750446,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2565159ec523a296f10-81729717',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'type' => 0,
    'idfor' => 0,
    'class' => 0,
    'show_title' => 0,
    'title' => 0,
    'lng' => 0,
    'id' => 0,
    'ajax_source' => 0,
    'ImagesDir' => 0,
    'alt_image' => 0,
    'wrapper_tag' => 0,
    'text' => 0,
    'cz_index' => 0,
    'width' => 0,
    'sticky' => 0,
    'extra_class' => 0,
    'tt' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec523a2bbba0_51741556',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec523a2bbba0_51741556')) {function content_59ec523a2bbba0_51741556($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_wm_remove')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.wm_remove.php';
if (!is_callable('smarty_function_load_defer')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer.php';
?>
<?php if ($_smarty_tpl->tpl_vars['type']->value=='label') {?>

  <label for="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['idfor']->value)===null||empty($tmp) ? "for_tooltip_link" : $tmp);?>
">
    <a class="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['class']->value)===null||empty($tmp) ? "NeedHelpLink" : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"<?php if ($_smarty_tpl->tpl_vars['show_title']->value) {?> title="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['title']->value)===null||empty($tmp) ? $_smarty_tpl->tpl_vars['lng']->value['lbl_need_help'] : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"<?php }?> id="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||empty($tmp) ? "tooltip_link" : $tmp);?>
" <?php if ($_smarty_tpl->tpl_vars['ajax_source']->value) {?>rel="<?php echo $_smarty_tpl->tpl_vars['ajax_source']->value;?>
"<?php } else { ?>rel="#<?php echo (($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||empty($tmp) ? "tooltip_link" : $tmp);?>
_tooltip"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['title']->value)===null||empty($tmp) ? $_smarty_tpl->tpl_vars['lng']->value['lbl_need_help'] : $tmp);?>
</a>
  </label>

<?php } elseif ($_smarty_tpl->tpl_vars['type']->value=='img') {?>

  <a href="javascript:void(0);" class="" id="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||empty($tmp) ? "tooltip_link" : $tmp);?>
"<?php if ($_smarty_tpl->tpl_vars['show_title']->value) {?> title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['title']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?> <?php if ($_smarty_tpl->tpl_vars['ajax_source']->value) {?>rel="<?php echo $_smarty_tpl->tpl_vars['ajax_source']->value;?>
"<?php } else { ?>rel="#<?php echo (($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||empty($tmp) ? "tooltip_link" : $tmp);?>
_tooltip"<?php }?> tabindex="-1" >
    <img src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/<?php echo (($tmp = @$_smarty_tpl->tpl_vars['alt_image']->value)===null||empty($tmp) ? "help_sign.gif" : $tmp);?>
" width="15" height="15" alt="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['title']->value)===null||empty($tmp) ? $_smarty_tpl->tpl_vars['lng']->value['lbl_need_help'] : $tmp), ENT_QUOTES, 'UTF-8', true);?>
" />
  </a>

<?php } else { ?>

  <a class="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['class']->value)===null||empty($tmp) ? "NeedHelpLink" : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"<?php if ($_smarty_tpl->tpl_vars['show_title']->value) {?> title="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['title']->value)===null||empty($tmp) ? $_smarty_tpl->tpl_vars['lng']->value['lbl_need_help'] : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"<?php }?> id="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||empty($tmp) ? "tooltip_link" : $tmp);?>
" href="#<?php echo (($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||empty($tmp) ? "tooltip_link" : $tmp);?>
_tooltip" <?php if ($_smarty_tpl->tpl_vars['ajax_source']->value) {?>rel="<?php echo $_smarty_tpl->tpl_vars['ajax_source']->value;?>
"<?php } else { ?>rel="#<?php echo (($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||empty($tmp) ? "tooltip_link" : $tmp);?>
_tooltip"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['title']->value)===null||empty($tmp) ? $_smarty_tpl->tpl_vars['lng']->value['lbl_need_help'] : $tmp);?>
</a>

<?php }?>

<<?php echo (($tmp = @$_smarty_tpl->tpl_vars['wrapper_tag']->value)===null||empty($tmp) ? "span" : $tmp);?>
 id="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||empty($tmp) ? "tooltip_link" : $tmp);?>
_tooltip" style="display:none;">
  <?php echo $_smarty_tpl->tpl_vars['text']->value;?>

</<?php echo (($tmp = @$_smarty_tpl->tpl_vars['wrapper_tag']->value)===null||empty($tmp) ? "span" : $tmp);?>
>

<?php $_smarty_tpl->_capture_stack[0][] = array('tooltip', 'tt', null); ob_start(); ?>
$(document).ready(function(){
  $('#<?php echo (($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||empty($tmp) ? "tooltip_link" : $tmp);?>
').cluetip({
    local: <?php if ($_smarty_tpl->tpl_vars['ajax_source']->value) {?>false<?php } else { ?>true<?php }?>,
    hideLocal: false,
    showTitle: <?php if ($_smarty_tpl->tpl_vars['show_title']->value) {?>true<?php } else { ?>false<?php }?>,
    cluezIndex: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['cz_index']->value)===null||empty($tmp) ? 1100 : $tmp);?>
,
<?php if ($_smarty_tpl->tpl_vars['width']->value>0) {?>
    width: <?php echo $_smarty_tpl->tpl_vars['width']->value;?>
,
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['sticky']->value) {?>
      sticky: true,
      mouseOutClose: true,
      closePosition: 'bottom',
      closeText: '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_close']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
<?php }?>
    clueTipClass: '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['extra_class']->value)===null||empty($tmp) ? "default" : $tmp);?>
'
  });
});
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<?php echo smarty_function_load_defer(array('file'=>"tooltip".((string)$_smarty_tpl->tpl_vars['id']->value),'direct_info'=>$_smarty_tpl->tpl_vars['tt']->value,'type'=>"js"),$_smarty_tpl);?>

<?php }} ?>
