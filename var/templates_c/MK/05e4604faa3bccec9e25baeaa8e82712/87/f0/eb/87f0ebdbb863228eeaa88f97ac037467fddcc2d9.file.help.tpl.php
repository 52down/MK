<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:09:30
         compiled from "D:\website\MK\skin\common_files\admin\help.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1418959ec523a18f260-48948639%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '87f0ebdbb863228eeaa88f97ac037467fddcc2d9' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\admin\\help.tpl',
      1 => 1496750406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1418959ec523a18f260-48948639',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lng' => 0,
    'config' => 0,
    'shop_evaluation' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec523a198506_31712946',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec523a198506_31712946')) {function content_59ec523a198506_31712946($_smarty_tpl) {?>
<li class="menu-item help">
    <i class="icon fa fa-question-circle"></i>
    <a href="http://help.x-cart.com/index.php?title=X-Cart:User_manual_contents&amp;utm_source=xcart&amp;utm_medium=help_menu_link&amp;utm_campaign=help_menu" target="_blank">
        <span><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_help'];?>
</span>
    </a>
  <div class="children-block">
    <ul>
        <li class="menu-item">
            <a href="http://help.x-cart.com/index.php?title=X-Cart:FAQs&amp;utm_source=xcart&amp;utm_medium=help_menu_link&amp;utm_campaign=help_menu" target="_blank">
                <i class="icon fa fa-external-link"></i>
                <span><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_xcart_faqs'];?>
</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="http://help.x-cart.com/index.php?title=X-Cart:User_manual_contents&amp;utm_source=xcart&amp;utm_medium=help_menu_link&amp;utm_campaign=help_menu" target="_blank">
                <i class="icon fa fa-external-link"></i>
                <span><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_xcart_manuals'];?>
</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="http://forum.x-cart.com/?utm_source=xcart&amp;utm_medium=help_menu_link&amp;utm_campaign=help_menu" target="_blank">
                <i class="icon fa fa-external-link"></i>
                <span><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_community_forums'];?>
</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="https://bt.x-cart.com/bug_report_page.php?project_id=54&amp;product_version=<?php echo $_smarty_tpl->tpl_vars['config']->value['version'];?>
&amp;utm_source=xcart&amp;utm_medium=help_menu_link&amp;utm_campaign=help_menu" target="_blank">
                <i class="icon fa fa-external-link"></i>
                <span><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_post_bug'];?>
</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="http://ideas.x-cart.com/forums/32109-x-cart-classic-4-x?utm_source=xcart&amp;utm_medium=help_menu_link&amp;utm_campaign=help_menu" target="_blank">
                <i class="icon fa fa-external-link"></i>
                <span><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_suggest_feature'];?>
</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="http://www.x-cart.com/license-agreement-classic.html?utm_source=xcart&amp;utm_medium=help_menu_link&amp;utm_campaign=help_menu" target="_blank">
                <i class="icon fa fa-external-link"></i>
                <span><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_license_agreement'];?>
</span>
            </a>
        </li>
        <?php if ($_smarty_tpl->tpl_vars['shop_evaluation']->value) {?>
        <li class="menu-item">
            <a href="http://www.x-cart.com/purchasing_shopping_cart_software.html?utm_source=xcart&amp;utm_medium=help_menu_link&amp;utm_campaign=help_menu" target="_blank">
                <i class="icon fa fa-external-link"></i>
                <span><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_purchase_paid_license'];?>
</span>
            </a>
        </li>
        <?php }?>
        <li class="menu-item support-link">
            <a href="https://secure.x-cart.com/customer.php?area=center&amp;target=customer_info&amp;utm_source=xcart&amp;utm_medium=help_menu_link&amp;utm_campaign=help_menu" target="_blank">
                <i class="icon fa fa-external-link"></i>
                <span><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_get_support_assistance'];?>
</span>
            </a>
        </li>
    </ul>
  </div>
</li>
<?php }} ?>
