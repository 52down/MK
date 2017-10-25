<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:09:29
         compiled from "D:\website\MK\skin\common_files\quick_search.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3074259ec5239ebacd4-05996669%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa8762a8370af2ad99f21d31c083b851ac19786e' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\quick_search.tpl',
      1 => 1496750498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3074259ec5239ebacd4-05996669',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'SkinDir' => 0,
    'lng' => 0,
    'ImagesDir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec5239ebf659_07992093',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec5239ebf659_07992093')) {function content_59ec5239ebf659_07992093($_smarty_tpl) {?>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/js/quick_search.js"><?php echo '</script'; ?>
>
<div id="quick_search_panel" style="display:none;">
  <div class="quick-search-panel-main">

    <div class="quick-search-body" id="quick_search_body1">
      <span id="quick_search_results"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_keywords'];?>
</span>
      <span id="quick_search_no_results" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_no_results_found'];?>
</span>
      <span id="quick_search_no_pattern" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_quick_search_nopattern'];?>
</span><br />
    </div>

    <div class="quick-search-body" id="quick_search_body2" style="display:none;">
      <?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_searching'];?>
...<br /><br />
      <img src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/quick_search_searching.gif" alt="" />
    </div>

    <div class="quick-search-close" onclick="javascript:close_quick_search();"></div>

  </div>
</div>
<?php }} ?>
