<?php die(); 
// Should you require our technical assistance with the error logs troubleshooting feel free to contact us through the
// personal HelpDesk at https://secure.x-cart.com/customer.php or email us on support@x-cart.com
//
// Technical support service can be purchased at http://www.x-cart.com/technical-support.html
?>
[22-Oct-2017 05:22:13] smarty_trace message:
    Array
    (
        [0] => Array
            (
                [file] => D:\website\MK\include\lib\smarty3\sysplugins\smarty_internal_template.php
                [line] => 213
                [function] => writeFile
                [class] => Smarty_Internal_Write_File
                [type] => ::
                [args] => Array
                    (
                        [0] => D:\website\MK/var/templates_c\ideal_comfort\9639b9f6701527db8a7bbba9f5ee5003\31\33\28\313328c825f603ea9b224b7497534c9f3a2d8a1c.file.head.tpl.php
                        [1] => <?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 05:22:17
             compiled from "D:\website\MK\skin\ideal_comfort\customer\head.tpl" */ ?>
    <?php /*%%SmartyHeaderCode:2136459ec0ee98449f3-70954965%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
    $_valid = $_smarty_tpl->decodeProperties(array (
      'file_dependency' => 
      array (
        '313328c825f603ea9b224b7497534c9f3a2d8a1c' => 
        array (
          0 => 'D:\\website\\MK\\skin\\ideal_comfort\\customer\\head.tpl',
          1 => 1496750500,
          2 => 'file',
        ),
      ),
      'nocache_hash' => '2136459ec0ee98449f3-70954965',
      'function' => 
      array (
      ),
      'variables' => 
      array (
        'catalogs' => 0,
        'AltImagesDir' => 0,
        'config' => 0,
        'main' => 0,
        'cart_empty' => 0,
      ),
      'has_nocache_code' => false,
      'version' => 'Smarty-3.1.21-dev',
      'unifunc' => 'content_59ec0ee985a941_34679339',
    ),false); /*/%%SmartyHeaderCode%%*/?>
    <?php if ($_valid && !is_callable('content_59ec0ee985a941_34679339')) {function content_59ec0ee985a941_34679339($_smarty_tpl) {?>
    <div class="line1">
      <div class="logo">
        <a href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['customer'];?>
    /home.php"><img src="<?php echo $_smarty_tpl->tpl_vars['AltImagesDir']->value;?>
    /custom/logo.png" alt="<?php echo $_smarty_tpl->tpl_vars['config']->value['Company']['company_name'];?>
    " /></a>
      </div>
      <div class="header-links">
            <div class="wrapper">
                <?php echo $_smarty_tpl->getSubTemplate ("customer/header_links.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
    
            </div>
      </div>
      <?php echo $_smarty_tpl->getSubTemplate ("customer/tabs.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
    
    
      <?php echo $_smarty_tpl->getSubTemplate ("customer/phones.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
    
    
    </div>
    
    <div class="line2">
      <?php if (($_smarty_tpl->tpl_vars['main']->value!='cart'||$_smarty_tpl->tpl_vars['cart_empty']->value)&&$_smarty_tpl->tpl_vars['main']->value!='checkout') {?>
    
        <?php echo $_smarty_tpl->getSubTemplate ("customer/search.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
    
    
        <?php echo $_smarty_tpl->getSubTemplate ("customer/language_selector.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
    
    
      <?php }?>
    </div>
    
    <?php echo $_smarty_tpl->getSubTemplate ("customer/noscript.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
    
    <?php }} ?>
    
                        [2] => XCTemplater object is here
                    )
    
            )
    
        [1] => Array
            (
                [file] => D:\website\MK\include\lib\smarty3\sysplugins\smarty_internal_templatebase.php
                [line] => 155
                [function] => compileTemplateSource
                [class] => Smarty_Internal_Template
                [type] => ->
                [args] => Array
                    (
                    )
    
            )
    
        [2] => Array
            (
                [file] => D:\website\MK\include\lib\smarty3\sysplugins\smarty_internal_template.php
                [line] => 304
                [function] => fetch
                [class] => Smarty_Internal_TemplateBase
                [type] => ->
                [args] => Array
                    (
                        [0] => XC_Smarty_Internal_Template object is here
                        [1] => 
                        [2] => 
                        [3] => 
                        [4] => 
                        [5] => 
                        [6] => 1
                    )
    
            )
    
        [3] => Array
            (
                [file] => D:\website\MK\include\templater\templater.php
                [line] => 331
                [function] => getSubTemplate
                [class] => Smarty_Internal_Template
                [type] => ->
                [args] => Array
                    (
                        [0] => customer/head.tpl
                        [1] => 
                        [2] => 9639b9f6701527db8a7bbba9f5ee5003
                        [3] => 0
                        [4] => 
                        [5] => Array
                            (
                            )
    
                        [6] => 0
                    )
    
            )
    
    )
    
Request URI: /home.php
-------------------------------------------------
