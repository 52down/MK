<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:24
         compiled from "D:\website\MK\skin\common_files\jquery_ui_autocomplete.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1335159ef31e8a4cc00-94182914%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6a3832e2186cc4fa305715c81401f11e5ad53114' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\jquery_ui_autocomplete.tpl',
      1 => 1496750426,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1335159ef31e8a4cc00-94182914',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'development_mode_enabled' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef31e8a67de5_78876575',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef31e8a67de5_78876575')) {function content_59ef31e8a67de5_78876575($_smarty_tpl) {?><?php if (!is_callable('smarty_function_load_defer')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer.php';
?>


<?php if ($_smarty_tpl->tpl_vars['development_mode_enabled']->value) {?>
    <?php echo smarty_function_load_defer(array('file'=>"lib/jqueryui/components/menu.js",'type'=>"js"),$_smarty_tpl);?>

    <?php echo $_smarty_tpl->getSubTemplate ("widgets/css_loader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('css'=>"lib/jqueryui/components/menu.css"), 0);?>

    <?php echo smarty_function_load_defer(array('file'=>"lib/jqueryui/components/autocomplete.js",'type'=>"js"),$_smarty_tpl);?>

    <?php echo $_smarty_tpl->getSubTemplate ("widgets/css_loader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('css'=>"lib/jqueryui/components/autocomplete.css"), 0);?>

<?php } else { ?>
    <?php echo smarty_function_load_defer(array('file'=>"lib/jqueryui/components/menu.min.js",'type'=>"js"),$_smarty_tpl);?>

    <?php echo $_smarty_tpl->getSubTemplate ("widgets/css_loader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('css'=>"lib/jqueryui/components/menu.min.css"), 0);?>

    <?php echo smarty_function_load_defer(array('file'=>"lib/jqueryui/components/autocomplete.min.js",'type'=>"js"),$_smarty_tpl);?>

    <?php echo $_smarty_tpl->getSubTemplate ("widgets/css_loader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('css'=>"lib/jqueryui/components/autocomplete.min.css"), 0);?>

<?php }?>
<?php }} ?>
