<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-24 14:28:54
         compiled from "D:\website\MK\skin\common_files\modules\New_Arrivals\new_arrivals_product_modify_fields.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1290559ef3206bddd40-94913652%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '01c2fe78e6f3ce9cf00598c03cfa8d029cbffd62' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\modules\\New_Arrivals\\new_arrivals_product_modify_fields.tpl',
      1 => 1496750464,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1290559ef3206bddd40-94913652',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'geid' => 0,
    'lng' => 0,
    'product' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ef3206c19247_33967862',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ef3206c19247_33967862')) {function content_59ef3206c19247_33967862($_smarty_tpl) {?>

<tr>
  <?php if ($_smarty_tpl->tpl_vars['geid']->value!='') {?><td width="15" class="TableSubHead"><input type="checkbox" value="Y" name="fields[mark_as_new]" /></td><?php }?>
  <td class="FormButton" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_new_arrivals_new_product'];?>
:</td>
  <td class="ProductDetails">
    <table cellspacing="0" cellpadding="0">
      <tr>
        <td>
          <input type="hidden" name="mark_as_new" value="N" />
          <input type="checkbox" name="mark_as_new" id="mark_as_new" value="Y"<?php if ($_smarty_tpl->tpl_vars['product']->value['mark_as_new']=="A"||$_smarty_tpl->tpl_vars['product']->value['mark_as_new']=="S") {?> checked="checked"<?php }?> />
        </td>
        <td class="date-period-selector"<?php if ($_smarty_tpl->tpl_vars['product']->value['mark_as_new']!="A"&&$_smarty_tpl->tpl_vars['product']->value['mark_as_new']!="S") {?> style="padding: 0 0 0 12px; display: none"<?php } else { ?> style="padding: 0 0 0 12px"<?php }?>>
          <?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_date_period'];?>
:
          <select name="show_as_new_date_period_selector" id="show_as_new_date_period_selector">
            <option value="A"<?php if ($_smarty_tpl->tpl_vars['product']->value['mark_as_new']=="A"||$_smarty_tpl->tpl_vars['product']->value['mark_as_new']=='') {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_new_arrivals_always'];?>
</option>
            <option value="S"<?php if ($_smarty_tpl->tpl_vars['product']->value['mark_as_new']=="S") {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_new_arrivals_specific_dates'];?>
</option>
          </select>
        </td>
      </tr>
    </table>

    <div class="date-period-always"<?php if ($_smarty_tpl->tpl_vars['product']->value['mark_as_new']!="A") {?> style="display: none"<?php }?>>
      <p><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_new_arrivals_date_period_note'];?>
</p>
    </div>

    <br />
    <table cellspacing="0" cellpadding="0" class="date-period-specific"<?php if ($_smarty_tpl->tpl_vars['product']->value['mark_as_new']!="S") {?> style="display: none"<?php }?>>
      <tr>
        <td align="right"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_from'];?>
:&nbsp;</td>
        <td><?php echo $_smarty_tpl->getSubTemplate ("main/datepicker.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('name'=>"show_as_new_from",'date'=>$_smarty_tpl->tpl_vars['product']->value['show_as_new_from'],'start_year'=>"c-2",'end_year'=>"+5"), 0);?>
</td>
      </tr>
      <tr>
        <td align="right"><?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_to'];?>
:&nbsp;</td>
        <td><?php echo $_smarty_tpl->getSubTemplate ("main/datepicker.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('name'=>"show_as_new_to",'date'=>$_smarty_tpl->tpl_vars['product']->value['show_as_new_to'],'start_year'=>"c-2",'end_year'=>"+5"), 0);?>
</td>
      </tr>
    </table>
  </td>
</tr>

<?php echo '<script'; ?>
 type="text/javascript">
//<![CDATA[

 
$(function () {
 
  function markAsNew() {
    if ($("#mark_as_new").is(':checked')) {
      $(".date-period-selector").show();
      showAsNewDatePeriodSelectorChange();
    } else {
      $(".date-period-selector").hide();
      $(".date-period-specific").hide();
      $(".date-period-always").hide();
    }
  }

  function showAsNewDatePeriodSelectorChange() {
    if ($("#show_as_new_date_period_selector").val() == 'S') {
      $(".date-period-specific").show();
      $(".date-period-always").hide();
    } else {
      $(".date-period-specific").hide();
      $(".date-period-always").show();
    }
  }
 
  $("#mark_as_new").click(function() {
    markAsNew();
  });

  $("#show_as_new_date_period_selector").change(function() {
    showAsNewDatePeriodSelectorChange();
  });
 
})
 

//]]>
<?php echo '</script'; ?>
>

<?php }} ?>
