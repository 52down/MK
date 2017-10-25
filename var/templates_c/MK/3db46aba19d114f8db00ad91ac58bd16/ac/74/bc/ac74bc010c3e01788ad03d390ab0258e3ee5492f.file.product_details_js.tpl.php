<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:53
         compiled from "D:\website\MK\skin\common_files\main\product_details_js.tpl" */ ?>
<?php /*%%SmartyHeaderCode:783959ef3205b50920-65527017%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ac74bc010c3e01788ad03d390ab0258e3ee5492f' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\product_details_js.tpl',
      1 => 1496750444,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '783959ef3205b50920-65527017',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lng' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef3205b93437_36187295',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef3205b93437_36187295')) {function content_59ef3205b93437_36187295($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_wm_remove')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.wm_remove.php';
?>
<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[
var requiredFields = [
  ['productcode', "<?php echo strtr(smarty_modifier_wm_remove(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['lng']->value['lbl_sku'])), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
", false],
  ['product', "<?php echo strtr(smarty_modifier_wm_remove(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['lng']->value['lbl_product_name'])), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
", false],
  <?php if ($_smarty_tpl->tpl_vars['config']->value['SEO']['clean_urls_enabled']=="Y") {?> ['clean_url', "<?php echo strtr(smarty_modifier_wm_remove(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['lng']->value['lbl_clean_url'])), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
", false], <?php }?>
  ['descr', "<?php echo strtr(smarty_modifier_wm_remove(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['lng']->value['lbl_description'])), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
", false],
  ['product_lng[product]', "<?php echo strtr(smarty_modifier_wm_remove(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['lng']->value['lbl_description'])), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
", false]
];



function ChangeTaxesBoxStatus(s) {
  if (s.form.elements.namedItem('taxes[]'))
    s.form.elements.namedItem('taxes[]').disabled = s.options[s.selectedIndex].value == 'Y';
}

function switchPDims(c) {
  var names = ['length', 'width', 'height', 'separate_box', 'items_per_box'];
  for (var i = 0; i < names.length; i++) {
    var e = c.form.elements.namedItem(names[i]);
    if (e) {
      e.disabled = !c.checked;

      // "Ship in a separate box" depends on "Use the dimensions of this product for shipping cost calculation" bt:84873
      if (names[i] == 'separate_box' && !c.checked)
        e.checked = false;
    }  
  }

  switchSSBox(c.form.elements.namedItem('separate_box'));
}

function switchSSBox(c) {
  if (!c)
    return;

  c.form.elements.namedItem('items_per_box').disabled = !c.checked || !c.form.elements.namedItem('small_item').checked;
}

//]]>
<?php echo '</script'; ?>
>
<?php }} ?>
