<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:09:42
         compiled from "D:\website\MK\skin\common_files\admin\menu_affiliate.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1735759ec5246e98120-14903479%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8f3309b16992e4d66918e430564993b27a049636' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\admin\\menu_affiliate.tpl',
      1 => 1496750410,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1735759ec5246e98120-14903479',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'catalogs' => 0,
    'lng' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec5246ea08e5_58928219',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec5246ea08e5_58928219')) {function content_59ec5246ea08e5_58928219($_smarty_tpl) {?>
<li>

<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/partner_plans.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_affiliates'];?>
</a>

<div>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/partner_plans.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_affiliate_plans'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/partner_orders.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_partners_orders'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/partner_report.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_partner_accounts'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/payment_upload.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_payment_upload'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/partner_banners.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_banners'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/banner_info.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_affiliate_statistics'];?>
</a>
<a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['admin'];?>
/partner_adv_campaigns.php"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_advertising_campaigns'];?>
</a>
</div>
</li>

<?php }} ?>
