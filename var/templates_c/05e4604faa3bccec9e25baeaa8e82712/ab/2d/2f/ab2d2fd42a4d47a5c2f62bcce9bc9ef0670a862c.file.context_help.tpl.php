<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 09:48:37
         compiled from "D:\website\MK\skin\common_files\context_help.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1877059ec4d55d43184-39582869%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ab2d2fd42a4d47a5c2f62bcce9bc9ef0670a862c' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\context_help.tpl',
      1 => 1496750412,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1877059ec4d55d43184-39582869',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lng' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec4d55d4fb91_64594868',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec4d55d4fb91_64594868')) {function content_59ec4d55d4fb91_64594868($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_wm_remove')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.wm_remove.php';
if (!is_callable('smarty_function_load_defer')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer.php';
?>
<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[
var contextHelpSettings = {
	searchApiUrl:        window.location.protocol + '//cloudsearch.x-cart.com/help/search',
	searchAsYouType:  	 false,
	numExpandedResults:  3,
	widgetTitle:      '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_help']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
	inputPlaceholder: '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_type_your_query']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
	buttonTitle:      '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_search']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
	hideTabCaption:   '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_hide_this_tab']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
	autocorrectionTpl:'<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_searching_for_autocorrection']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
	noResultsText:    '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_no_results_found']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
	connErrorText:    '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_help_server_connection_error']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
	hideHelpTabText:  '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_hide_help_tab_text']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
	seeMoreCaption:   '<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_see_n_more_results']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'
};
//]]>
<?php echo '</script'; ?>
>
<?php echo smarty_function_load_defer(array('file'=>"lib/handlebars.min.js",'type'=>"js"),$_smarty_tpl);?>

<?php echo smarty_function_load_defer(array('file'=>"js/context_help.js",'type'=>"js"),$_smarty_tpl);?>

<?php }} ?>
