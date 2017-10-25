<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:48
         compiled from "D:\website\MK\skin\common_files\main\navigation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2074759ef32004558e9-18167267%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'efc2889b6b94b6806f5c1af4fbbf9bf14f52e19b' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\navigation.tpl',
      1 => 1496750442,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2074759ef32004558e9-18167267',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'total_pages' => 0,
    'navigation_script' => 0,
    'navigation_max_pages' => 0,
    'lng' => 0,
    'navigation_arrow_left' => 0,
    'ImagesDir' => 0,
    'start_page' => 0,
    'navigation_page' => 0,
    'total_super_pages' => 0,
    'navigation_arrow_right' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef3200483a15_56005625',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef3200483a15_56005625')) {function content_59ef3200483a15_56005625($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_amp')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.amp.php';
?>
<?php if ($_smarty_tpl->tpl_vars['total_pages']->value>2) {?>

<?php if (isset($_smarty_tpl->tpl_vars["navigation_script"])) {$_smarty_tpl->tpl_vars["navigation_script"] = clone $_smarty_tpl->tpl_vars["navigation_script"];
$_smarty_tpl->tpl_vars["navigation_script"]->value = smarty_modifier_amp($_smarty_tpl->tpl_vars['navigation_script']->value); $_smarty_tpl->tpl_vars["navigation_script"]->nocache = null; $_smarty_tpl->tpl_vars["navigation_script"]->scope = 0;
} else $_smarty_tpl->tpl_vars["navigation_script"] = new Smarty_variable(smarty_modifier_amp($_smarty_tpl->tpl_vars['navigation_script']->value), null, 0);?>

<div class="nav-pages">
<!-- max_pages: <?php echo $_smarty_tpl->tpl_vars['navigation_max_pages']->value;?>
 -->
  <span class="nav-pages-title"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_result_pages'];?>
:</span>

<?php if ($_smarty_tpl->tpl_vars['navigation_arrow_left']->value) {?><a class="nav-pages-larrow" href="<?php echo $_smarty_tpl->tpl_vars['navigation_script']->value;?>
&amp;page=<?php echo $_smarty_tpl->tpl_vars['navigation_arrow_left']->value;?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/spacer.gif" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lng']->value['lbl_prev_page'], ENT_QUOTES, 'UTF-8', true);?>
" /></a><span class="nav-delim"></span><?php }
if ($_smarty_tpl->tpl_vars['start_page']->value>1) {?><a class="nav-page" href="<?php echo $_smarty_tpl->tpl_vars['navigation_script']->value;?>
&amp;page=1" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lng']->value['lbl_page'], ENT_QUOTES, 'UTF-8', true);?>
 #1">1</a><span class="nav-delim"></span><?php if ($_smarty_tpl->tpl_vars['start_page']->value>2) {?><span class="nav-dots">...</span><span class="nav-delim"></span><?php }
}
if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['page'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['page']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['name'] = 'page';
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['total_pages']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['start'] = (int) $_smarty_tpl->tpl_vars['start_page']->value;
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['page']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['page']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['page']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['page']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['page']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['page']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['page']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['page']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['page']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['page']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['page']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['page']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['page']['total']);
if ($_smarty_tpl->getVariable('smarty')->value['section']['page']['index']==$_smarty_tpl->tpl_vars['navigation_page']->value) {?><span class="current-page" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lng']->value['lbl_current_page'], ENT_QUOTES, 'UTF-8', true);?>
: #<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['page']['index'];?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['page']['index'];?>
</span><?php } else { ?><a class="nav-page" href="<?php echo $_smarty_tpl->tpl_vars['navigation_script']->value;?>
&amp;page=<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['page']['index'];?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lng']->value['lbl_page'], ENT_QUOTES, 'UTF-8', true);?>
 #<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['page']['index'];?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['page']['index'];?>
</a><?php }
if (!$_smarty_tpl->getVariable('smarty')->value['section']['page']['last']) {?><span class="nav-delim"></span><?php }
endfor; endif;
if ($_smarty_tpl->tpl_vars['total_pages']->value<=$_smarty_tpl->tpl_vars['total_super_pages']->value) {
if ($_smarty_tpl->tpl_vars['total_pages']->value<$_smarty_tpl->tpl_vars['total_super_pages']->value) {?><span class="nav-delim"></span><span class="nav-dots">...</span><?php }?><span class="nav-delim"></span><a class="nav-page" href="<?php echo $_smarty_tpl->tpl_vars['navigation_script']->value;?>
&amp;page=<?php echo $_smarty_tpl->tpl_vars['total_super_pages']->value;?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lng']->value['lbl_page'], ENT_QUOTES, 'UTF-8', true);?>
 #<?php echo $_smarty_tpl->tpl_vars['total_super_pages']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['total_super_pages']->value;?>
</a><?php }
if ($_smarty_tpl->tpl_vars['navigation_arrow_right']->value) {?><span class="nav-delim"></span><a class="nav-pages-rarrow" href="<?php echo $_smarty_tpl->tpl_vars['navigation_script']->value;?>
&amp;page=<?php echo $_smarty_tpl->tpl_vars['navigation_arrow_right']->value;?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/spacer.gif" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lng']->value['lbl_next_page'], ENT_QUOTES, 'UTF-8', true);?>
" /></a><?php }?>

</div>

<?php }?>
<?php }} ?>
