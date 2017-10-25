<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:10:35
         compiled from "D:\website\MK\skin\common_files\buttons\button.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2370159ec527ba57644-80928222%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '09e6001d6666e105aea633b451c360bce0d67103' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\buttons\\button.tpl',
      1 => 1496750410,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2370159ec527ba57644-80928222',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'type' => 0,
    'href' => 0,
    'js_link' => 0,
    'js_to_href' => 0,
    'style' => 0,
    'submit' => 0,
    'title' => 0,
    'img_type' => 0,
    'ImagesDir' => 0,
    'reading_direction_tag' => 0,
    'button_title' => 0,
    'image_menu' => 0,
    'onclick' => 0,
    'target' => 0,
    'substyle' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec527ba893d8_68385757',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec527ba893d8_68385757')) {function content_59ec527ba893d8_68385757($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_regex_replace')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\modifier.regex_replace.php';
if (!is_callable('smarty_modifier_amp')) include 'D:\\website\\MK\\include\\templater\\plugins\\modifier.amp.php';
?>
<?php if ($_smarty_tpl->tpl_vars['config']->value['Adaptives']['platform']=='MacPPC'&&$_smarty_tpl->tpl_vars['config']->value['Adaptives']['browser']=='NN') {?>
  <?php if (isset($_smarty_tpl->tpl_vars["js_to_href"])) {$_smarty_tpl->tpl_vars["js_to_href"] = clone $_smarty_tpl->tpl_vars["js_to_href"];
$_smarty_tpl->tpl_vars["js_to_href"]->value = "Y"; $_smarty_tpl->tpl_vars["js_to_href"]->nocache = null; $_smarty_tpl->tpl_vars["js_to_href"]->scope = 0;
} else $_smarty_tpl->tpl_vars["js_to_href"] = new Smarty_variable("Y", null, 0);?>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['type']->value=='input') {?>
  <?php if (isset($_smarty_tpl->tpl_vars["img_type"])) {$_smarty_tpl->tpl_vars["img_type"] = clone $_smarty_tpl->tpl_vars["img_type"];
$_smarty_tpl->tpl_vars["img_type"]->value = 'input type="image"'; $_smarty_tpl->tpl_vars["img_type"]->nocache = null; $_smarty_tpl->tpl_vars["img_type"]->scope = 0;
} else $_smarty_tpl->tpl_vars["img_type"] = new Smarty_variable('input type="image"', null, 0);?>
<?php } else { ?>
  <?php if (isset($_smarty_tpl->tpl_vars["img_type"])) {$_smarty_tpl->tpl_vars["img_type"] = clone $_smarty_tpl->tpl_vars["img_type"];
$_smarty_tpl->tpl_vars["img_type"]->value = 'img'; $_smarty_tpl->tpl_vars["img_type"]->nocache = null; $_smarty_tpl->tpl_vars["img_type"]->scope = 0;
} else $_smarty_tpl->tpl_vars["img_type"] = new Smarty_variable('img', null, 0);?>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars["js_link"])) {$_smarty_tpl->tpl_vars["js_link"] = clone $_smarty_tpl->tpl_vars["js_link"];
$_smarty_tpl->tpl_vars["js_link"]->value = smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['href']->value,"/^\s*javascript\s*:/Si",''); $_smarty_tpl->tpl_vars["js_link"]->nocache = null; $_smarty_tpl->tpl_vars["js_link"]->scope = 0;
} else $_smarty_tpl->tpl_vars["js_link"] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['href']->value,"/^\s*javascript\s*:/Si",''), null, 0);?>
<?php if ($_smarty_tpl->tpl_vars['js_link']->value==$_smarty_tpl->tpl_vars['href']->value) {?>
  <?php if (isset($_smarty_tpl->tpl_vars["js_link"])) {$_smarty_tpl->tpl_vars["js_link"] = clone $_smarty_tpl->tpl_vars["js_link"];
$_smarty_tpl->tpl_vars["js_link"]->value = (smarty_modifier_amp(("javascript: self.location='").($_smarty_tpl->tpl_vars['href']->value))).("';"); $_smarty_tpl->tpl_vars["js_link"]->nocache = null; $_smarty_tpl->tpl_vars["js_link"]->scope = 0;
} else $_smarty_tpl->tpl_vars["js_link"] = new Smarty_variable((smarty_modifier_amp(("javascript: self.location='").($_smarty_tpl->tpl_vars['href']->value))).("';"), null, 0);?>
<?php } else { ?>
  <?php if (isset($_smarty_tpl->tpl_vars["js_link"])) {$_smarty_tpl->tpl_vars["js_link"] = clone $_smarty_tpl->tpl_vars["js_link"];
$_smarty_tpl->tpl_vars["js_link"]->value = $_smarty_tpl->tpl_vars['href']->value; $_smarty_tpl->tpl_vars["js_link"]->nocache = null; $_smarty_tpl->tpl_vars["js_link"]->scope = 0;
} else $_smarty_tpl->tpl_vars["js_link"] = new Smarty_variable($_smarty_tpl->tpl_vars['href']->value, null, 0);?>
  <?php if ($_smarty_tpl->tpl_vars['js_to_href']->value!='Y') {?>
    <?php if (isset($_smarty_tpl->tpl_vars["onclick"])) {$_smarty_tpl->tpl_vars["onclick"] = clone $_smarty_tpl->tpl_vars["onclick"];
$_smarty_tpl->tpl_vars["onclick"]->value = $_smarty_tpl->tpl_vars['href']->value; $_smarty_tpl->tpl_vars["onclick"]->nocache = null; $_smarty_tpl->tpl_vars["onclick"]->scope = 0;
} else $_smarty_tpl->tpl_vars["onclick"] = new Smarty_variable($_smarty_tpl->tpl_vars['href']->value, null, 0);?>
  <?php if ($_smarty_tpl->tpl_vars['style']->value!="button"&&$_smarty_tpl->tpl_vars['submit']->value=="Y") {?>
  <?php if (isset($_smarty_tpl->tpl_vars["href"])) {$_smarty_tpl->tpl_vars["href"] = clone $_smarty_tpl->tpl_vars["href"];
$_smarty_tpl->tpl_vars["href"]->value = "#"; $_smarty_tpl->tpl_vars["href"]->nocache = null; $_smarty_tpl->tpl_vars["href"]->scope = 0;
} else $_smarty_tpl->tpl_vars["href"] = new Smarty_variable("#", null, 0);?>
  <?php } else { ?>
  <?php if (isset($_smarty_tpl->tpl_vars["href"])) {$_smarty_tpl->tpl_vars["href"] = clone $_smarty_tpl->tpl_vars["href"];
$_smarty_tpl->tpl_vars["href"]->value = "javascript:void(0);"; $_smarty_tpl->tpl_vars["href"]->nocache = null; $_smarty_tpl->tpl_vars["href"]->scope = 0;
} else $_smarty_tpl->tpl_vars["href"] = new Smarty_variable("javascript:void(0);", null, 0);?>
  <?php }?>
  <?php }?>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['style']->value=='button'&&($_smarty_tpl->tpl_vars['config']->value['Adaptives']['platform']!='MacPPC'||$_smarty_tpl->tpl_vars['config']->value['Adaptives']['browser']!='NN')) {?>
<table cellspacing="0" cellpadding="0" onclick="<?php echo $_smarty_tpl->tpl_vars['js_link']->value;?>
" class="ButtonTable"<?php if ($_smarty_tpl->tpl_vars['title']->value!='') {?> title="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['title']->value), ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>>
<tr><td><<?php echo $_smarty_tpl->tpl_vars['img_type']->value;?>
 src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/but1.gif" class="ButtonSide" alt="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['title']->value), ENT_QUOTES, 'UTF-8', true);?>
" /></td><td class="Button"<?php echo $_smarty_tpl->tpl_vars['reading_direction_tag']->value;?>
><font class="Button"><?php echo $_smarty_tpl->tpl_vars['button_title']->value;?>
</font></td><td><img src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/but2.gif" class="ButtonSide" alt="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['title']->value), ENT_QUOTES, 'UTF-8', true);?>
" /></td></tr>
</table>
<?php } elseif ($_smarty_tpl->tpl_vars['image_menu']->value) {?>
<table cellspacing="0" class="SimpleButton"><tr><?php if ($_smarty_tpl->tpl_vars['button_title']->value!='') {?><td><a class="VertMenuItems" href="<?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['href']->value);?>
"<?php if ($_smarty_tpl->tpl_vars['onclick']->value!='') {?> onclick="<?php echo $_smarty_tpl->tpl_vars['onclick']->value;?>
"<?php }
if ($_smarty_tpl->tpl_vars['title']->value!='') {?> title="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['title']->value), ENT_QUOTES, 'UTF-8', true);?>
"<?php }
if ($_smarty_tpl->tpl_vars['target']->value!='') {?> target="<?php echo $_smarty_tpl->tpl_vars['target']->value;?>
"<?php }?>><font class="VertMenuItems"><?php echo $_smarty_tpl->tpl_vars['button_title']->value;?>
</font></a>&nbsp;</td><?php }?><td><?php if ($_smarty_tpl->tpl_vars['img_type']->value=='img') {?><a class="VertMenuItems" href="<?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['href']->value);?>
"<?php if ($_smarty_tpl->tpl_vars['onclick']->value!='') {?> onclick="<?php echo $_smarty_tpl->tpl_vars['onclick']->value;?>
"<?php }
if ($_smarty_tpl->tpl_vars['title']->value!='') {?> title="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['title']->value), ENT_QUOTES, 'UTF-8', true);?>
"<?php }
if ($_smarty_tpl->tpl_vars['target']->value!='') {?> target="<?php echo $_smarty_tpl->tpl_vars['target']->value;?>
"<?php }?>><?php }?><<?php echo $_smarty_tpl->tpl_vars['img_type']->value;?>
 src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/go_menu.gif" class="GoImage" alt="" /><?php if ($_smarty_tpl->tpl_vars['img_type']->value=='img') {?></a><?php }?></td></tr></table>
<?php } else { ?>
<table cellspacing="0" class="SimpleButton"><tr><?php if ($_smarty_tpl->tpl_vars['button_title']->value!='') {?><td><a class="<?php if ($_smarty_tpl->tpl_vars['img_type']->value=='img') {?>simple-button simple-<?php echo (($tmp = @$_smarty_tpl->tpl_vars['substyle']->value)===null||empty($tmp) ? "arrow" : $tmp);?>
-button<?php } else { ?>Button<?php }?>" href="<?php echo smarty_modifier_amp($_smarty_tpl->tpl_vars['href']->value);?>
"<?php if ($_smarty_tpl->tpl_vars['onclick']->value!='') {?> onclick="<?php echo $_smarty_tpl->tpl_vars['onclick']->value;?>
"<?php }
if ($_smarty_tpl->tpl_vars['title']->value!='') {?> title="<?php echo htmlspecialchars(strip_tags($_smarty_tpl->tpl_vars['title']->value), ENT_QUOTES, 'UTF-8', true);?>
"<?php }
if ($_smarty_tpl->tpl_vars['target']->value!='') {?> target="<?php echo $_smarty_tpl->tpl_vars['target']->value;?>
"<?php }?>><?php echo $_smarty_tpl->tpl_vars['button_title']->value;?>
</a></td><?php }
if ($_smarty_tpl->tpl_vars['img_type']->value!='img') {?><td>&nbsp;<<?php echo $_smarty_tpl->tpl_vars['img_type']->value;?>
 src="<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/go.gif" class="GoImage" alt="" /></td><?php }?></tr></table>
<?php }?>
<?php }} ?>
