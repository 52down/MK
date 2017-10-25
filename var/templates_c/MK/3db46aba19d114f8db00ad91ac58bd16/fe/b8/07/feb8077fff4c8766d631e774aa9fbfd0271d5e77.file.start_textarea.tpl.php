<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:54
         compiled from "D:\website\MK\skin\common_files\main\start_textarea.tpl" */ ?>
<?php /*%%SmartyHeaderCode:320459ef32067dfe31-65588162%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'feb8077fff4c8766d631e774aa9fbfd0271d5e77' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\start_textarea.tpl',
      1 => 1496750444,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '320459ef32067dfe31-65588162',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'SkinDir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef32068209e6_30269109',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef32068209e6_30269109')) {function content_59ef32068209e6_30269109($_smarty_tpl) {?>
<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[
  var isHTML_Editor = true;
//]]>
<?php echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['config']->value['HTML_Editor']['editor']=="ckeditor") {?>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/modules/HTML_Editor/editors/ckeditor/ckeditor.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/modules/HTML_Editor/editors/ckeditor/start_textarea.js"><?php echo '</script'; ?>
>
<?php } elseif ($_smarty_tpl->tpl_vars['config']->value['HTML_Editor']['editor']=="tinymce") {?>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/modules/HTML_Editor/editors/tinymce/tiny_mce.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SkinDir']->value;?>
/modules/HTML_Editor/editors/tinymce/start_textarea.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[
tinyMCE.init({
  mode : "none",
  theme : "advanced",
  skin : "o2k7",
  skin_variant : "silver",
  relative_urls : false,
  plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
  theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
  theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
  theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
  theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
  theme_advanced_toolbar_location : "top",
  theme_advanced_toolbar_align : "left",
  theme_advanced_statusbar_location : "bottom",
  theme_advanced_resizing : true
});
//]]>
<?php echo '</script'; ?>
>
<?php } elseif ($_smarty_tpl->tpl_vars['config']->value['HTML_Editor']['editor']=="innovaeditor") {?>
<?php echo $_smarty_tpl->getSubTemplate ("modules/HTML_Editor/editor.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<?php }} ?>
