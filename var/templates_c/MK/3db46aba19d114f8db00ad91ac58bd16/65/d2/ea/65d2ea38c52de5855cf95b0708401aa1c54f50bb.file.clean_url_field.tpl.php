<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:54
         compiled from "D:\website\MK\skin\common_files\main\clean_url_field.tpl" */ ?>
<?php /*%%SmartyHeaderCode:232659ef3206400bc3-03283084%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '65d2ea38c52de5855cf95b0708401aa1c54f50bb' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\clean_url_field.tpl',
      1 => 1496750440,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '232659ef3206400bc3-03283084',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'geid' => 0,
    'lng' => 0,
    'show_req_fields' => 0,
    'config' => 0,
    'clean_url' => 0,
    'clean_url_fill_error' => 0,
    'tooltip_id' => 0,
    'clean_urls_history' => 0,
    'is_admin_user' => 0,
    'catalogs' => 0,
    'usertype' => 0,
    'active_modules' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef320642b237_23464010',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef320642b237_23464010')) {function content_59ef320642b237_23464010($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_substitute')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.substitute.php';
?>
<tr>

  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?>
    <td width="15" class="TableSubHead" valign="top"><input type="checkbox" disabled="disabled"/></td>
  <?php }?>

  <td class="FormButton" nowrap="nowrap" valign="top"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_clean_url'];?>
:</td>
  
  <?php if ($_smarty_tpl->tpl_vars['show_req_fields']->value=="Y") {?>
    <td width="10" height="10" valign="top"><span class="Star"><?php if ($_smarty_tpl->tpl_vars['config']->value['SEO']['clean_urls_enabled']=="Y") {?>*<?php }?></span></td>
  <?php }?>
  
  <td class="ProductDetails" width="80%">
    <div>
      <input type="text" name="clean_url" id="clean_url" size="45" maxlength="250" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['clean_url']->value, ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['config']->value['SEO']['clean_urls_enabled']=="Y") {?> onchange="javascript: checkCleanUrl(this, 'Y', 'Y');"<?php } else { ?>class="ReadOnlyField" readonly="readonly"<?php }?> />&nbsp;
      <?php if ($_smarty_tpl->tpl_vars['clean_url_fill_error']->value) {?><span class="Star">&lt;&lt;&nbsp;</span><?php }?>

      <?php echo $_smarty_tpl->getSubTemplate ("main/tooltip_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>$_smarty_tpl->tpl_vars['lng']->value['lbl_clean_url_what_is'],'text'=>$_smarty_tpl->tpl_vars['lng']->value['txt_clean_url_descr'],'id'=>$_smarty_tpl->tpl_vars['tooltip_id']->value), 0);?>

    </div>

    <br />

    <div class="SmallText">
    <?php if ($_smarty_tpl->tpl_vars['config']->value['SEO']['clean_urls_enabled']=="Y") {?>

      <div id="clean_url_error" class="Star"></div>
      <input type="checkbox" name="clean_url_save_in_history" id="clean_url_save_in_history" value="Y" checked="checked" />
      <label for="clean_url_save_in_history"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_clean_url_save_old'];?>
</label><br />

      <?php if ($_smarty_tpl->tpl_vars['clean_urls_history']->value) {?>
        [ <a href="#clean_url_history"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_clean_url_manage_history'];?>
</a> ]<br />
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['is_admin_user']->value) {?>
        <?php echo smarty_modifier_substitute($_smarty_tpl->tpl_vars['lng']->value['lbl_clean_url_format_warning'],"seo_option_page",((string)$_smarty_tpl->tpl_vars['catalogs']->value['admin'])."/configuration.php?option=SEO");?>

      <?php } else { ?>
        <?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_clean_url_format_warning_provider'];?>

      <?php }?>

    <?php } else { ?>

      <?php if ($_smarty_tpl->tpl_vars['usertype']->value=="A"||($_smarty_tpl->tpl_vars['usertype']->value=="P"&&$_smarty_tpl->tpl_vars['active_modules']->value['Simple_Mode']=="Y")) {?>
        <?php echo smarty_modifier_substitute($_smarty_tpl->tpl_vars['lng']->value['lbl_clean_url_disabled_mode_warning'],"seo_option_page",((string)$_smarty_tpl->tpl_vars['catalogs']->value['admin'])."/configuration.php?option=SEO");?>

      <?php } else { ?>
        <?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_clean_url_disabled_mode_warning_provider'];?>

      <?php }?>

    <?php }?>

    </div>

    <br />

  </td>

</tr>
<?php }} ?>
