<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 09:48:38
         compiled from "D:\website\MK\skin\common_files\main\evaluation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1101059ec4d56ebc328-41749105%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '18d02c24c27477f88df53e150d430ea830fe9768' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\evaluation.tpl',
      1 => 1496750440,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1101059ec4d56ebc328-41749105',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'is_enabled_evaluation_popup' => 0,
    'shop_evaluation' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec4d56ec0283_03895474',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec4d56ec0283_03895474')) {function content_59ec4d56ec0283_03895474($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['is_enabled_evaluation_popup']->value) {?>
<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[
  <?php if ($_smarty_tpl->tpl_vars['shop_evaluation']->value=='WRONG_DOMAIN') {?>
    var _popup_sets = {width:700,minHeight:425,closeOnEscape:true};
  <?php } else { ?>
    var _popup_sets = {width:700,minHeight:529,closeOnEscape:true};
  <?php }?>

$(document).ready(function () {
  return popupOpen('popup_info.php?action=evaluationPopup', '', _popup_sets);
});

//]]>
<?php echo '</script'; ?>
>
<?php }?>
<?php }} ?>
