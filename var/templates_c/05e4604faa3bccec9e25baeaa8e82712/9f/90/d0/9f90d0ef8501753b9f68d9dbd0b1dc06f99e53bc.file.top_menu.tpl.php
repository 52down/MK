<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 09:48:38
         compiled from "D:\website\MK\skin\common_files\admin\top_menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1927659ec4d5615c852-37016414%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9f90d0ef8501753b9f68d9dbd0b1dc06f99e53bc' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\admin\\top_menu.tpl',
      1 => 1496750410,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1927659ec4d5615c852-37016414',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'http_location' => 0,
    'lng' => 0,
    'login' => 0,
    'usertype' => 0,
    'logged_userid' => 0,
    'current_area' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec4d561670a8_09990124',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec4d561670a8_09990124')) {function content_59ec4d561670a8_09990124($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['config']->value['General']['shop_closed']=="Y") {?>
    <li class="link-item your-store closed">
        <a href="<?php echo $_smarty_tpl->tpl_vars['http_location']->value;?>
/home.php?shopkey=<?php echo $_smarty_tpl->tpl_vars['config']->value['General']['shop_closed_key'];?>
" target="_blank">
            <i class="icon fa fa-desktop"></i>
            <span><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_your_storefront'];?>
 <span class="closed">(<?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_closed'];?>
)</span></span>
        </a>
        <?php echo $_smarty_tpl->getSubTemplate ("admin/storefront_status.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    </li>
<?php } else { ?>
    <li class="link-item your-store open">
        <a href="<?php echo $_smarty_tpl->tpl_vars['http_location']->value;?>
" target="_blank">
            <i class="icon fa fa-desktop"></i>
            <span><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_your_storefront'];?>
</span>
        </a>
        <?php echo $_smarty_tpl->getSubTemplate ("admin/storefront_status.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    </li>
<?php }?>

<?php echo $_smarty_tpl->getSubTemplate ("admin/help.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php echo $_smarty_tpl->getSubTemplate ("admin/quick_search.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<li class="menu-item account">
    <a href="#" class="list">
        <span><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_profile'];?>
</span>
    </a>
    <div class="children-block">
        <ul>
            <?php if ($_smarty_tpl->tpl_vars['login']->value!=''&&$_smarty_tpl->tpl_vars['usertype']->value=='B') {?>
            <li class="menu-item text partner">
                <span><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_your_partner_id'];?>
: <strong><?php echo $_smarty_tpl->tpl_vars['logged_userid']->value;?>
</strong></span>
            </li>
            <?php }?>
            <li class="menu-item text login">
                <span><?php echo $_smarty_tpl->tpl_vars['login']->value;?>
</span>
            </li>
            <li class="menu-item ">
                <a href="<?php echo $_smarty_tpl->tpl_vars['current_area']->value;?>
/register.php?mode=update">
                    <span><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_profile_details'];?>
</span>
                </a>
            </li>
            <li class="menu-item logoff">
                <a href="login.php?mode=logout">
                    <span><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_logoff'];?>
</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<?php }} ?>
