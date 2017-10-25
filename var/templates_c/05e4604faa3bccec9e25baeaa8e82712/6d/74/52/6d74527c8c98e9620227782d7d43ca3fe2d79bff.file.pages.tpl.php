<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 09:48:38
         compiled from "D:\website\MK\skin\common_files\admin\main\pages.tpl" */ ?>
<?php /*%%SmartyHeaderCode:718759ec4d56f16a41-57826815%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d74527c8c98e9620227782d7d43ca3fe2d79bff' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\admin\\main\\pages.tpl',
      1 => 1496750408,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '718759ec4d56f16a41-57826815',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lng' => 0,
    'is_writable' => 0,
    'pages' => 0,
    'pages_from_opc' => 0,
    'catalogs' => 0,
    'embedded' => 0,
    'config' => 0,
    'all_languages_cnt' => 0,
    'xcart_web_dir' => 0,
    'root' => 0,
    'template_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec4d5700fca6_01381392',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec4d5700fca6_01381392')) {function content_59ec4d5700fca6_01381392($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_wm_remove')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.wm_remove.php';
if (!is_callable('smarty_function_cycle')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\function.cycle.php';
if (!is_callable('smarty_modifier_truncate')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\modifier.truncate.php';
if (!is_callable('smarty_modifier_substitute')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.substitute.php';
?>
<?php echo $_smarty_tpl->getSubTemplate ("page_title.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_static_pages']), 0);?>


<?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_static_pages_top_text'];?>


<br /><br />

<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[

function prompt_about_opc_pages() {
  if ($('#pagesform_e').find('input[data-pages-used-on-opc]:checked').length > 0) {
    var txt_adm_dont_delete_aliased_pages = "<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['txt_adm_dont_delete_aliased_pages']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
";
    return confirm(txt_adm_dont_delete_aliased_pages);
  }
  return true;
}
//]]>
<?php echo '</script'; ?>
>


<?php $_smarty_tpl->_capture_stack[0][] = array('dialog', null, null); ob_start(); ?>

<?php echo $_smarty_tpl->getSubTemplate ("main/language_selector.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('script'=>"pages.php?"), 0);?>


<?php if ($_smarty_tpl->tpl_vars['is_writable']->value) {?>

<form action="pages.php" method="post" name="pagesform_e" id="pagesform_e">
<input type="hidden" name="mode" value="update" />
<input type="hidden" name="sec" value="E" />

<table cellpadding="3" cellspacing="1" width="100%">

<tr>
  <td colspan="6"><?php echo $_smarty_tpl->getSubTemplate ("main/subheader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_embedded_level'],'class'=>"grey"), 0);?>
</td>
</tr>

<?php if ($_smarty_tpl->tpl_vars['pages']->value) {?>

<?php $_smarty_tpl->_capture_stack[0][] = array('embedpages', null, null); ob_start(); ?>

<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pg'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pg']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['name'] = 'pg';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['pages']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['total']);
?>

<?php if ($_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['level']=="E") {?>

<?php if (isset($_smarty_tpl->tpl_vars["embedded"])) {$_smarty_tpl->tpl_vars["embedded"] = clone $_smarty_tpl->tpl_vars["embedded"];
$_smarty_tpl->tpl_vars["embedded"]->value = "found"; $_smarty_tpl->tpl_vars["embedded"]->nocache = null; $_smarty_tpl->tpl_vars["embedded"]->scope = 0;
} else $_smarty_tpl->tpl_vars["embedded"] = new Smarty_variable("found", null, 0);?>

<tr<?php echo smarty_function_cycle(array('name'=>"embed",'values'=>", class='TableSubHead'"),$_smarty_tpl);?>
>
<td width="5">
  <input type="checkbox" name="to_delete[<?php echo $_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['pageid'];?>
]" value="Y" <?php if (in_array($_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['filename'],$_smarty_tpl->tpl_vars['pages_from_opc']->value)) {?>data-pages-used-on-opc="true"<?php }?>/>
</td>
<td>
  <input type="text" name="posted_data[<?php echo $_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['pageid'];?>
][orderby]" value="<?php echo $_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['orderby'];?>
" size="5" />
</td>
<td>
  <b><a href="pages.php?pageid=<?php echo $_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['pageid'];?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['filename'], ENT_QUOTES, 'UTF-8', true);?>
">
    <?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['title'],"40","..."), ENT_QUOTES, 'UTF-8', true);?>

  </a></b>
</td>
<td align="center">
  <input type="checkbox" name="posted_data[<?php echo $_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['pageid'];?>
][show_in_menu]" value="Y"<?php if ($_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['show_in_menu']=='Y') {?> checked="checked"<?php }?> />
</td>
<td>
  <input type="checkbox" name="posted_data[<?php echo $_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['pageid'];?>
][active]" value="Y"<?php if ($_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['active']=="Y") {?> checked="checked"<?php }?> />
</td>
<td align="right" width="30">
  <a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['customer'];?>
/pages.php?pageid=<?php echo $_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['pageid'];?>
&amp;mode=preview" target="previewpage">
    <?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_preview'];?>

  </a>
</td>
</tr>

<?php }?>

<?php endfor; endif; ?>

<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['embedded']->value) {?>

<tr>
<td colspan="6">
<?php echo $_smarty_tpl->getSubTemplate ("main/check_all_row.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('form'=>"pagesform_e",'prefix'=>"to_delete"), 0);?>

</td>
</tr>

<?php }?>

<tr class="TableHead">
  <td width="10">&nbsp;</td>
  <td width="10%"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_pos'];?>
</td>
  <td width="60%"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_page_title'];?>
</td>
  <td width="10%"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_page_th_show_in_menu'];?>
</td>
  <td width="100" colspan="2"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_status'];?>
</td>
</tr>

<?php if ($_smarty_tpl->tpl_vars['embedded']->value) {?>

<?php echo Smarty::$_smarty_vars['capture']['embedpages'];?>


<tr>
<td>&nbsp;</td>
<td colspan="5">
  <hr />
    <table cellpadding="0" cellspacing="0">
    <tr>
    <td width="5">
      <input type="checkbox" id="parse_smarty_tags" name="parse_smarty_tags" value="Y"<?php if ($_smarty_tpl->tpl_vars['config']->value['General']['parse_smarty_tags']=="Y") {?> checked="checked"<?php }?> />
    </td>
    <td>
      <label for="parse_smarty_tags">
        <?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_parse_smarty_tags_in_embedded_pages'];?>

      </label>
    </td>
    </tr>
    <?php if ($_smarty_tpl->tpl_vars['all_languages_cnt']->value>1) {?>
    <tr>
    <td width="5">
      <input type="checkbox" id="delete_all_lng_pages" name="delete_all_lng_pages" value="Y" checked="checked" />
    </td>
    <td>
      <label for="delete_all_lng_pages">
        <?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_static_pages_delete_all'];?>

      </label>
    </td>
    </tr>
    <?php }?>
    </table>
</td>
</tr>

<tr>
  <td colspan="6" class="SubmitBox">
    <input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_delete_selected']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: if (prompt_about_opc_pages() && checkMarks(this.form, new RegExp('to_delete\[[0-9]+\]', 'gi'))) submitForm(this, 'delete');" />
    <input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_update']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: submitForm(this, 'update');" />
  </td>
</tr>

<?php } else { ?>

<tr>
<td align="center" colspan="6">
  <?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_no_embedded_pages'];?>

</td>
</tr>

<?php }?>

<tr>
  <td colspan="6" class="SubmitBox">
    <input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_add_new_']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: self.location='pages.php?level=E&amp;pageid=0';" />
  </td>
</tr>

</table>

</form>

<form action="pages.php" method="post" name="pagesform_r">
<input type="hidden" name="mode" value="update" />
<input type="hidden" name="sec" value="R" />

<table cellpadding="3" cellspacing="1" width="100%">

<?php if ($_smarty_tpl->tpl_vars['pages']->value) {?>

<?php $_smarty_tpl->_capture_stack[0][] = array('rootpages', null, null); ob_start(); ?>

<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pg'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pg']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['name'] = 'pg';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['pages']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pg']['total']);
?>

<?php if ($_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['level']=="R") {?>

<?php if (isset($_smarty_tpl->tpl_vars["root"])) {$_smarty_tpl->tpl_vars["root"] = clone $_smarty_tpl->tpl_vars["root"];
$_smarty_tpl->tpl_vars["root"]->value = "found"; $_smarty_tpl->tpl_vars["root"]->nocache = null; $_smarty_tpl->tpl_vars["root"]->scope = 0;
} else $_smarty_tpl->tpl_vars["root"] = new Smarty_variable("found", null, 0);?>

<tr<?php echo smarty_function_cycle(array('name'=>"root",'values'=>", class='TableSubHead'"),$_smarty_tpl);?>
>
  <td width="2">
    <input type="checkbox" name="to_delete[<?php echo $_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['pageid'];?>
]" value="Y" />
    <input type="hidden" name="pages_array[<?php echo $_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['pageid'];?>
][active]" value="Y" />
    <input type="hidden" name="posted_data[<?php echo $_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['pageid'];?>
][show_in_menu]" value="" />
  </td>
  <td>
    <b><a href="pages.php?pageid=<?php echo $_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['pageid'];?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['filename'], ENT_QUOTES, 'UTF-8', true);?>
">
      <?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['title'],"40","..."), ENT_QUOTES, 'UTF-8', true);?>

    </a></b>
  </td>
  <td align="right" width="30">
    <a href="<?php echo $_smarty_tpl->tpl_vars['xcart_web_dir']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['pages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pg']['index']]['filename'];?>
" target="previewpage">
      <?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_preview'];?>

    </a>
  </td>
</tr>

<?php }?>

<?php endfor; endif; ?>

<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php }?>

<tr>
<td colspan="3">
  <br /><br />
  <?php echo $_smarty_tpl->getSubTemplate ("main/subheader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_root_level'],'class'=>"grey"), 0);?>

</td>
</tr>

<?php if ($_smarty_tpl->tpl_vars['root']->value) {?>

<tr>
<td colspan="3">
  <?php echo $_smarty_tpl->getSubTemplate ("main/check_all_row.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('form'=>"pagesform_r",'prefix'=>"to_delete"), 0);?>

</td>
</tr>

<?php }?>

<tr class="TableHead">
<td width="2">&nbsp;</td>
<td colspan="2">
  <?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_page_title'];?>

</td>
</tr>

<?php if ($_smarty_tpl->tpl_vars['root']->value) {?>

<?php echo Smarty::$_smarty_vars['capture']['rootpages'];?>


<tr>
  <td colspan="3" class="SubmitBox">
    <input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_delete_selected']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: if (checkMarks(this.form, new RegExp('to_delete\[[0-9]+\]', 'gi'))) submitForm(this, 'delete');" />
  </td>
</tr>

<?php } else { ?>

<tr>
<td align="center" colspan="3">
  <?php echo $_smarty_tpl->tpl_vars['lng']->value['txt_no_root_pages'];?>

</td>
</tr>

<?php }?>

<tr>
<td colspan="3" class="SubmitBox">
  <input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_add_new_']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: self.location='pages.php?level=R&amp;pageid=0';" />

  <br /><br />

  <div align="right">
    <input type="button" value="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['lng']->value['lbl_find_pages']), ENT_QUOTES, 'UTF-8', true);?>
" onclick="javascript: submitForm(this, 'check');" />
  </div>
</td>
</tr>

</table>
</form>

<?php } else { ?>

<?php echo smarty_modifier_substitute($_smarty_tpl->tpl_vars['lng']->value['txt_the_directory_is_not_writable'],"X",$_smarty_tpl->tpl_vars['template_dir']->value);?>


<?php }?>

<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<?php echo $_smarty_tpl->getSubTemplate ("dialog.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_static_pages'],'content'=>Smarty::$_smarty_vars['capture']['dialog'],'extra'=>'width="100%"'), 0);?>


<?php }} ?>
