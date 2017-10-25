<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:10:36
         compiled from "D:\website\MK\skin\common_files\admin\main\modules_banner.tpl" */ ?>
<?php /*%%SmartyHeaderCode:370259ec527c0b0488-20965234%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '245dc9d56f4467df11565229a18ba106bcb21689' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\admin\\main\\modules_banner.tpl',
      1 => 1496750408,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '370259ec527c0b0488-20965234',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lng' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec527c0b1db2_14214893',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec527c0b1db2_14214893')) {function content_59ec527c0b1db2_14214893($_smarty_tpl) {?>
<div id="modules_banner">
<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[

$(document).ready(function () {
  var offset = $('#modules-tabs-container').offset().top
               + $('ul.ui-tabs-nav').outerHeight()
               - parseInt($('.banner-tools').css('padding-top'), 10);
  $('.banner-tools').offset({ top: offset});
  $('#banner_close_link').click(function(){
    var date_time = new Date().getTime() + 3600*24*1000;
    $.cookie('hide_dialog_xcart_paid_modules', '1', { expires: new Date(date_time)});
  });
});

//]]>
<?php echo '</script'; ?>
>
<div id="banner_close_link">
<a href="javascript: void(0);" onclick="javascript: $('.banner-tools').hide(); return false;"></a>
</div>
<div id="xcart_paid_modules">
<iframe id="ac434a45" name="ac434a45" src="//ads.qtmsoft.com/www/delivery/afr.php?zoneid=12&amp;cb=4561"
frameborder="0" scrolling="no" width="210" height="400"><a href="//ads.qtmsoft.com/www/delivery/ck.php?n=af232f2e&amp;cb=4561" target="_blank"><img src="//ads.qtmsoft.com/www/delivery/avw.php?zoneid=12&amp;cb=4561&amp;n=af232f2e" border="0" alt="" /></a></iframe>
</div>
<div id="more_xcart_modules">
<a href="http://www.x-cart.com/modules.html?utm_source=xcart&amp;utm_medium=xcart_modules_link&amp;utm_campaign=xcart_modules" target="_blank"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_more_xcart_modules'];?>
</a>
</div>
</div>
<?php }} ?>
