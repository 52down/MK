<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 09:48:25
         compiled from "D:\website\MK\skin\common_files\modules\Socialize\service_head.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2918659ec4d4960afe6-35432461%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '76c137a87456ccbe02a010bd412cab1df2469d15' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\modules\\Socialize\\service_head.tpl',
      1 => 1496750476,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2918659ec4d4960afe6-35432461',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'active_modules' => 0,
    'main' => 0,
    'products' => 0,
    'product' => 0,
    'f_products' => 0,
    'new_arrivals' => 0,
    'cat_products' => 0,
    'ie_ver' => 0,
    'is_w3c_validator' => 0,
    'prod_descr' => 0,
    'http_location' => 0,
    'canonical_url' => 0,
    'current_category' => 0,
    'manufacturer' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec4d4968eff8_89172429',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec4d4968eff8_89172429')) {function content_59ec4d4968eff8_89172429($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\modifier.truncate.php';
if (!is_callable('smarty_function_get_category_image_url')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.get_category_image_url.php';
if (!is_callable('smarty_function_load_defer')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer.php';
?>
<?php if ($_smarty_tpl->tpl_vars['active_modules']->value['Socialize']&&$_smarty_tpl->tpl_vars['main']->value!='cart'&&$_smarty_tpl->tpl_vars['main']->value!='checkout'&&($_smarty_tpl->tpl_vars['products']->value!=''||$_smarty_tpl->tpl_vars['product']->value!=''||$_smarty_tpl->tpl_vars['f_products']->value!=''||$_smarty_tpl->tpl_vars['new_arrivals']->value!=''||$_smarty_tpl->tpl_vars['cat_products']->value!=''||$_smarty_tpl->tpl_vars['main']->value=='manufacturer_products')&&(!$_smarty_tpl->tpl_vars['ie_ver']->value||$_smarty_tpl->tpl_vars['ie_ver']->value>6)) {?>
  <?php if (!$_smarty_tpl->tpl_vars['active_modules']->value['Facebook_Tab']&&!$_smarty_tpl->tpl_vars['is_w3c_validator']->value) {?>
    <?php if ($_smarty_tpl->tpl_vars['main']->value=='product'&&$_smarty_tpl->tpl_vars['product']->value) {?>
      
      <?php if (isset($_smarty_tpl->tpl_vars["prod_descr"])) {$_smarty_tpl->tpl_vars["prod_descr"] = clone $_smarty_tpl->tpl_vars["prod_descr"];
$_smarty_tpl->tpl_vars["prod_descr"]->value = (($tmp = @$_smarty_tpl->tpl_vars['product']->value['descr'])===null||empty($tmp) ? $_smarty_tpl->tpl_vars['product']->value['fulldescr'] : $tmp); $_smarty_tpl->tpl_vars["prod_descr"]->nocache = null; $_smarty_tpl->tpl_vars["prod_descr"]->scope = 0;
} else $_smarty_tpl->tpl_vars["prod_descr"] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['product']->value['descr'])===null||empty($tmp) ? $_smarty_tpl->tpl_vars['product']->value['fulldescr'] : $tmp), null, 0);?>
      <meta property="og:title" content="<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['product']->value['product']), ENT_QUOTES, 'UTF-8', true);?>
"/>
      <meta property="og:description" content="<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', smarty_modifier_truncate($_smarty_tpl->tpl_vars['prod_descr']->value,'500','...',false)), ENT_QUOTES, 'UTF-8', true);?>
" />
      <meta property="og:url" content="<?php echo $_smarty_tpl->tpl_vars['http_location']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['canonical_url']->value;?>
" />
      
      <?php echo func_soc_tpl_get_og_image(array('images'=>$_smarty_tpl->tpl_vars['product']->value['images'],'def_image'=>$_smarty_tpl->tpl_vars['product']->value['image_url']),$_smarty_tpl);?>

      
    <?php } elseif ($_smarty_tpl->tpl_vars['main']->value=='catalog'&&$_smarty_tpl->tpl_vars['current_category']->value) {?>
      
      <meta property="og:title" content="<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['current_category']->value['category']), ENT_QUOTES, 'UTF-8', true);?>
"/>
      <meta property="og:description" content="<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', smarty_modifier_truncate($_smarty_tpl->tpl_vars['current_category']->value['description'],'500','...',false)), ENT_QUOTES, 'UTF-8', true);?>
" />
      <meta property="og:url" content="<?php echo $_smarty_tpl->tpl_vars['http_location']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['canonical_url']->value;?>
" />
      <?php if ($_smarty_tpl->tpl_vars['current_category']->value['is_icon']&&$_smarty_tpl->tpl_vars['current_category']->value['image_path']!='') {?>
        <meta property="og:image" content="<?php echo smarty_function_get_category_image_url(array('category'=>$_smarty_tpl->tpl_vars['current_category']->value),$_smarty_tpl);?>
" />
        <?php if ($_smarty_tpl->tpl_vars['current_category']->value['image_x']) {?><meta property="og:image:width" content="<?php echo $_smarty_tpl->tpl_vars['current_category']->value['image_x'];?>
" /><?php }?>
        <?php if ($_smarty_tpl->tpl_vars['current_category']->value['image_y']) {?><meta property="og:image:height" content="<?php echo $_smarty_tpl->tpl_vars['current_category']->value['image_y'];?>
" /><?php }?>
      <?php }?> 
    <?php } elseif ($_smarty_tpl->tpl_vars['main']->value=='manufacturer_products'&&$_smarty_tpl->tpl_vars['manufacturer']->value) {?>
      
      <meta property="og:title" content="<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['manufacturer']->value['manufacturer']), ENT_QUOTES, 'UTF-8', true);?>
"/>
      <meta property="og:description" content="<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', smarty_modifier_truncate($_smarty_tpl->tpl_vars['manufacturer']->value['descr'],'500','...',false)), ENT_QUOTES, 'UTF-8', true);?>
" />
      <meta property="og:url" content="<?php echo $_smarty_tpl->tpl_vars['http_location']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['canonical_url']->value;?>
" />
      <?php if ($_smarty_tpl->tpl_vars['manufacturer']->value['is_image']=='Y') {?>
        <meta property="og:image" content="<?php echo $_smarty_tpl->tpl_vars['manufacturer']->value['image_url'];?>
" />
        <?php if ($_smarty_tpl->tpl_vars['manufacturer']->value['image_x']) {?><meta property="og:image:width" content="<?php echo $_smarty_tpl->tpl_vars['manufacturer']->value['image_x'];?>
" /><?php }?>
        <?php if ($_smarty_tpl->tpl_vars['manufacturer']->value['image_y']) {?><meta property="og:image:height" content="<?php echo $_smarty_tpl->tpl_vars['manufacturer']->value['image_y'];?>
" /><?php }?>
      <?php }?>
    <?php }?>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['main']->value=='product'||$_smarty_tpl->tpl_vars['config']->value['Socialize']['soc_plist_matrix']=="Y"||$_smarty_tpl->tpl_vars['config']->value['Socialize']['soc_plist_plain']=="Y") {?>
    
    <?php if ($_smarty_tpl->tpl_vars['config']->value['Socialize']['soc_pin_enabled']=="Y") {?>
      <?php $_smarty_tpl->_capture_stack[0][] = array("pinterest_options", null, null); ob_start(); ?>
        var pinterest_endpoint = "//assets.pinterest.com/pinit.html";
        
          var pinterest_options = {
            att: {
              layout: "count-layout",
              count: "always-show-count"
            },
            endpoint: pinterest_endpoint,
              button: "//pinterest.com/pin/create/button/?",
              vars: {
              req: ["url", "media"],
              opt: ["title", "description"]
            },
            layout: {
              none: {
                width: 43,
                height: 20
              },
              vertical: {
                width: 43,
                height: 58
              },
              horizontal: {
                width: 90,
                height: 20
              }
            }
          }
        
      <?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
      <?php $_smarty_tpl->_capture_stack[0][] = array("pinterest_call", null, null); ob_start(); ?>
        $(function(){
          pin_it();
        });
      <?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
      <?php echo smarty_function_load_defer(array('file'=>"pinterest_options",'direct_info'=>Smarty::$_smarty_vars['capture']['pinterest_options'],'type'=>"js",'queue'=>2049),$_smarty_tpl);?>

      <?php echo smarty_function_load_defer(array('file'=>"modules/Socialize/pinterest.js",'type'=>"js",'queue'=>2050),$_smarty_tpl);?>

      <?php echo smarty_function_load_defer(array('file'=>"pinterest_call",'direct_info'=>Smarty::$_smarty_vars['capture']['pinterest_call'],'type'=>"js",'queue'=>2051),$_smarty_tpl);?>

    <?php }?>
  <?php }?>
<?php }?>
<?php echo smarty_function_load_defer(array('file'=>"modules/Socialize/main.css",'type'=>"css"),$_smarty_tpl);?>

<?php }} ?>
