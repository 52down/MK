<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:09:30
         compiled from "D:\website\MK\skin\common_files\admin\storefront_status.tpl" */ ?>
<?php /*%%SmartyHeaderCode:499659ec523a0d5dd0-08975519%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2549ca4a872d2f9bed30d9f044a7005e241c2060' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\admin\\storefront_status.tpl',
      1 => 1496750410,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '499659ec523a0d5dd0-08975519',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'login' => 0,
    'usertype' => 0,
    'need_storefront_link' => 0,
    'config' => 0,
    'lng' => 0,
    'storefront_link' => 0,
    'http_location' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec523a0e0829_21980214',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec523a0e0829_21980214')) {function content_59ec523a0e0829_21980214($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_amp')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.amp.php';
if (!is_callable('smarty_modifier_wm_remove')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.wm_remove.php';
?>
<?php if ($_smarty_tpl->tpl_vars['login']->value&&$_smarty_tpl->tpl_vars['usertype']->value=='A'&&$_smarty_tpl->tpl_vars['need_storefront_link']->value) {?>
    <div class="children-block">
        <ul>
            <?php if ($_smarty_tpl->tpl_vars['config']->value['General']['shop_closed']=="Y") {?>
                <li class="link-item frontend-closed">
                    <div class="link-item-block">
                        <span class="storefront-title storefront-closed"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_storefront_closed'];?>
</span>[<a href="<?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['storefront_link']->value);?>
"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_open'];?>
</a>]
                        <span class="private-link-storefront-block"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_access_store_via'];?>
 <a href="<?php echo $_smarty_tpl->tpl_vars['http_location']->value;?>
/home.php?shopkey=<?php echo $_smarty_tpl->tpl_vars['config']->value['General']['shop_closed_key'];?>
"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_private_link'];?>
</a></span>
                    </div>
                </li>
            <?php } else { ?>
                <li class="menu-item frontend-opened">
                    <div class="link-item-block">
                        <span class="storefront-title storefront-opened"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_storefront_open'];?>
</span>[<a href="javascript:void(0);" onclick="javascript:if(confirm('<?php echo strtr(smarty_modifier_wm_remove($_smarty_tpl->tpl_vars['lng']->value['lbl_open_storefront_warning']), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'))window.location='<?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['storefront_link']->value);?>
';"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_close'];?>
</a>]
                    </div>
                </li>
            <?php }?>
        </ul>
    </div>
<?php }?>
<?php }} ?>
