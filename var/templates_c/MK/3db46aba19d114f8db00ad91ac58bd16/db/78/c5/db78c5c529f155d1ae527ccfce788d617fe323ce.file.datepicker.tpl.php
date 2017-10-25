<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:54
         compiled from "D:\website\MK\skin\common_files\main\datepicker.tpl" */ ?>
<?php /*%%SmartyHeaderCode:945459ef3206cedf39-98992560%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'db78c5c529f155d1ae527ccfce788d617fe323ce' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\main\\datepicker.tpl',
      1 => 1496750440,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '945459ef3206cedf39-98992560',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'development_mode_enabled' => 0,
    'id' => 0,
    'name' => 0,
    'date' => 0,
    'config' => 0,
    'shop_language' => 0,
    'start_year' => 0,
    'end_year' => 0,
    '_default_end_year' => 0,
    'changeMonth' => 0,
    'changeYear' => 0,
    'ImagesDir' => 0,
    'dp_onchange' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef3206d6d191_47578539',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef3206d6d191_47578539')) {function content_59ef3206d6d191_47578539($_smarty_tpl) {?><?php if (!is_callable('smarty_function_load_defer')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\modifier.date_format.php';
?>

<?php if ($_smarty_tpl->tpl_vars['development_mode_enabled']->value) {?>
    <?php echo smarty_function_load_defer(array('file'=>"lib/jqueryui/components/datepicker.js",'type'=>"js"),$_smarty_tpl);?>

    <?php echo $_smarty_tpl->getSubTemplate ("widgets/css_loader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('css'=>"lib/jqueryui/components/datepicker.css"), 0);?>

<?php } else { ?>
    <?php echo smarty_function_load_defer(array('file'=>"lib/jqueryui/components/datepicker.min.js",'type'=>"js"),$_smarty_tpl);?>

    <?php echo $_smarty_tpl->getSubTemplate ("widgets/css_loader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('css'=>"lib/jqueryui/components/datepicker.min.css"), 0);?>

<?php }?>

<?php echo smarty_function_load_defer(array('file'=>"lib/jqueryui/components/i18n/datepicker-all.min.js",'type'=>"js"),$_smarty_tpl);?>


<input id="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||empty($tmp) ? $_smarty_tpl->tpl_vars['name']->value : $tmp), ENT_QUOTES, 'UTF-8', true);?>
" class="datepicker-formatted" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8', true);?>
" type="text" value="<?php echo smarty_modifier_date_format((($tmp = @$_smarty_tpl->tpl_vars['date']->value)===null||empty($tmp) ? XC_TIME : $tmp),$_smarty_tpl->tpl_vars['config']->value['Appearance']['date_format']);?>
" />
<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[

$(document).ready(function () {

$.datepicker.setDefaults($.datepicker.regional["<?php echo mb_strtolower($_smarty_tpl->tpl_vars['shop_language']->value, 'UTF-8');?>
"]);

// Original input object
var dp_in = $("#<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||empty($tmp) ? $_smarty_tpl->tpl_vars['name']->value : $tmp), ENT_QUOTES, 'UTF-8', true);?>
");

// Create a hidden field that will contain timestamp
// generated on-the-fly when setting date
var dp_ts = $(document.createElement('input'))
  .attr('type', 'hidden')
  .attr('name', '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8', true);?>
')
  .attr('id', '<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||empty($tmp) ? $_smarty_tpl->tpl_vars['name']->value : $tmp), ENT_QUOTES, 'UTF-8', true);?>
')
  .val('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['date']->value)===null||empty($tmp) ? XC_TIME : $tmp);?>
');

// Change attributes of an original object
$(dp_in)
  .attr('id',   'f_<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||empty($tmp) ? $_smarty_tpl->tpl_vars['name']->value : $tmp), ENT_QUOTES, 'UTF-8', true);?>
')
  .attr('name', 'f_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8', true);?>
');

$(dp_ts).insertAfter(dp_in);
<?php if (isset($_smarty_tpl->tpl_vars['_default_end_year'])) {$_smarty_tpl->tpl_vars['_default_end_year'] = clone $_smarty_tpl->tpl_vars['_default_end_year'];
$_smarty_tpl->tpl_vars['_default_end_year']->value = $_smarty_tpl->tpl_vars['config']->value['Company']['end_year']+2; $_smarty_tpl->tpl_vars['_default_end_year']->nocache = null; $_smarty_tpl->tpl_vars['_default_end_year']->scope = 0;
} else $_smarty_tpl->tpl_vars['_default_end_year'] = new Smarty_variable($_smarty_tpl->tpl_vars['config']->value['Company']['end_year']+2, null, 0);?>

var opts = {
  yearRange:   '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['start_year']->value)===null||empty($tmp) ? $_smarty_tpl->tpl_vars['config']->value['Company']['start_year'] : $tmp);?>
:<?php echo (($tmp = @$_smarty_tpl->tpl_vars['end_year']->value)===null||empty($tmp) ? $_smarty_tpl->tpl_vars['_default_end_year']->value : $tmp);?>
',
  dateFormat:  '<?php echo $_smarty_tpl->tpl_vars['config']->value['Appearance']['ui_date_format'];?>
',
  altFormat:   'yy-mm-dd',
  altField:    '#<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||empty($tmp) ? $_smarty_tpl->tpl_vars['name']->value : $tmp), ENT_QUOTES, 'UTF-8', true);?>
',
  changeMonth: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['changeMonth']->value)===null||empty($tmp) ? 'true' : $tmp);?>
,
  changeYear:  <?php echo (($tmp = @$_smarty_tpl->tpl_vars['changeYear']->value)===null||empty($tmp) ? 'true' : $tmp);?>
,
  showOn:      'both',
  buttonImage: '<?php echo $_smarty_tpl->tpl_vars['ImagesDir']->value;?>
/calendar.png',
  buttonImageOnly: true

};

$("#f_<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||empty($tmp) ? $_smarty_tpl->tpl_vars['name']->value : $tmp), ENT_QUOTES, 'UTF-8', true);?>
")
  .datepicker(opts)
  .bind('change', function() {
    var re = new RegExp(/000$/);
    $('#<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||empty($tmp) ? $_smarty_tpl->tpl_vars['name']->value : $tmp), ENT_QUOTES, 'UTF-8', true);?>
').val($('#<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||empty($tmp) ? $_smarty_tpl->tpl_vars['name']->value : $tmp), ENT_QUOTES, 'UTF-8', true);?>
').val().replace(re, ''));
    <?php if ($_smarty_tpl->tpl_vars['dp_onchange']->value!='') {?>
      <?php echo $_smarty_tpl->tpl_vars['dp_onchange']->value;?>

    <?php }?>
              
  })

}) // $(document).ready(function () {

//]]>
<?php echo '</script'; ?>
>
<?php }} ?>
