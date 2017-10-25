<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:53
         compiled from "D:\website\MK\skin\common_files\main\edit_product_image.tpl" */ ?>
<?php /*%%SmartyHeaderCode:468259ef3205f08177-40956387%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f7920ffcf41e746cfc245c205a67433c84dd56cc' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\edit_product_image.tpl',
      1 => 1496750440,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '468259ef3205f08177-40956387',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'idtag' => 0,
    'type' => 0,
    'config' => 0,
    'lng' => 0,
    'xcart_web_dir' => 0,
    'id' => 0,
    'already_loaded' => 0,
    'image_x' => 0,
    'image_y' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef3205f28be3_08722746',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef3205f28be3_08722746')) {function content_59ef3205f28be3_08722746($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['idtag']->value=='') {
if (isset($_smarty_tpl->tpl_vars["idtag"])) {$_smarty_tpl->tpl_vars["idtag"] = clone $_smarty_tpl->tpl_vars["idtag"];
$_smarty_tpl->tpl_vars["idtag"]->value = "edit_image"; $_smarty_tpl->tpl_vars["idtag"]->nocache = null; $_smarty_tpl->tpl_vars["idtag"]->scope = 0;
} else $_smarty_tpl->tpl_vars["idtag"] = new Smarty_variable("edit_image", null, 0);
}?>
<table cellpadding="0" cellspacing="0" style="<?php if ($_smarty_tpl->tpl_vars['type']->value=="P") {?>width: <?php echo $_smarty_tpl->tpl_vars['config']->value['images_dimensions']['P']['width'];?>
px; height: <?php echo $_smarty_tpl->tpl_vars['config']->value['images_dimensions']['P']['height'];?>
px<?php } else { ?>width: <?php echo $_smarty_tpl->tpl_vars['config']->value['images_dimensions']['T']['width'];?>
px; height: <?php echo $_smarty_tpl->tpl_vars['config']->value['images_dimensions']['T']['height'];?>
px<?php }?>">
<tr><td class="ProductDetailsImage" align="center" valign="middle">
<a title="<?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_view_full_size'];?>
" id='a_<?php echo $_smarty_tpl->tpl_vars['idtag']->value;?>
' href="<?php echo $_smarty_tpl->tpl_vars['xcart_web_dir']->value;?>
/image.php?type=<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
&amp;id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&amp;ts=<?php echo XC_TIME;
if ($_smarty_tpl->tpl_vars['already_loaded']->value) {?>&amp;tmp=Y<?php }?>" target="_blank">
<img id="<?php echo $_smarty_tpl->tpl_vars['idtag']->value;?>
" src="<?php echo $_smarty_tpl->tpl_vars['xcart_web_dir']->value;?>
/image.php?type=<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
&amp;id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&amp;ts=<?php echo XC_TIME;
if ($_smarty_tpl->tpl_vars['already_loaded']->value) {?>&amp;tmp=Y<?php }?>"<?php if ($_smarty_tpl->tpl_vars['image_x']->value!=0) {?> width="<?php echo $_smarty_tpl->tpl_vars['image_x']->value;?>
"<?php }
if ($_smarty_tpl->tpl_vars['image_y']->value!=0) {?> height="<?php echo $_smarty_tpl->tpl_vars['image_y']->value;?>
"<?php }?> alt="<?php echo $_smarty_tpl->getSubTemplate ("main/image_property.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
"/>
</a>
<input id="skip_image_<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" type="hidden" name="skip_image[<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
]" value="" />
</td></tr>
</table>

<?php }} ?>
