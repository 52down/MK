{*
a26546caee6d4cd5438ef532e0f1d5a40f4b83f1, v3 (xcart_4_7_6), 2016-06-10 12:05:52, order_tracking_numbers.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{capture name=js_editable_opts_tracking}
  var js_ajax_session_quick_key = "{get_ajax_session_quick_key|escape:javascript}";
  var orderid = '{$orderid|escape:javascript}';

  $(document).ready(function() {

    var js_editable_opts =  {
       indicator  : '<img src="{$ImagesDir}/ui-anim_basic_16x16.gif">',
       tooltip    : '{$lng.lbl_click_to_edit|strip_tags:false|escape:javascript}',
       placeholder: '{$lng.lbl_enter_tracking_number|strip_tags:false|escape:javascript}',
       width      : (Math.max.apply(Math, $('#tracking_numbers div.edit').map(function(){ return $(this).width(); }).get()) + 30) + "px",
       submit     : '<button type="button" class="fa fa-check"></button>',
       cancel     : '<button type="button" class="fa fa-times"></button>',
       callback   : function(value, settings) {
          if ($(this).prop('id') != value) {
            if (value != '') {
              $(this).prop('id', value);
              // update data for trash.a for delete
              $(this).parent().parent().find('a').data('id_in_db', value);
            } else {
              $(this).prop('id', 'new_');
              // update data for trash.a for delete
              $(this).parent().parent().find('a').data('id_in_db', false);
            }
          }
     },
    };

    var aja_save_url = 'ajax_save_tracking_number.php?posted_ajax_session_quick_key='+js_ajax_session_quick_key+'&orderid='+orderid;

    $('#tracking_numbers div.edit').editable(aja_save_url, js_editable_opts);

    // delete handler
    $('#tracking_numbers').on('click', 'a', function() {
        var parent_tr = $(this).parent().parent();
        if ($(this).data('id_in_db')) {
          // delete from db
          $.post(aja_save_url + '&mode=delete', 'id=' + encodeURIComponent($(this).data('id_in_db')));
        }
        // remove tr row
        parent_tr.remove();
        return false;
    });

    // add a new text field to add tracking_number handler
    $("#add_tracking_number").click(function() {
        var randomID = Math.floor(Math.random()*1000001);
        var col = "<tr><td><div class='edit' id='new_" + randomID + "'></div></td><td><a href='javascript:void(0);'><i type='button' class='fa fa-trash-o'></i></a></td></tr>"
        $("#tracking_numbers").append(col);
        $('#tracking_numbers div.edit').unbind();
        $('#tracking_numbers div.edit').editable(aja_save_url, js_editable_opts);

        // open the created input box
        $("#new_" + randomID).trigger('click');
    });

  });

{/capture}

{load_defer file="js_editable_opts_tracking" direct_info=$smarty.capture.js_editable_opts_tracking type="js"}
{load_defer file="lib/jeditable/jquery.jeditable.min.js" type="js"}

<input type="button" id='add_tracking_number' value="{$lng.lbl_add_tracking_number|strip_tags:false|escape}" />
{getvar var="tracking_numbers" func="func_tpl_get_order_tracking_numbers" orderid=$orderid fields='all_fields'}
{if $tracking_numbers}
  <br />
  <br />
{/if}


<table id="tracking_numbers">
{if $tracking_numbers}
  {assign var="postal_service" value=$order.shipping|truncate:3:"":true}
  {foreach $tracking_numbers as $tracking_ind=>$t_elem}
    <tr><td><div class="edit" id="{$t_elem.tracking|escape}">{$t_elem.tracking|escape}</div></td><td width='50px'><a href='javascript:void(0);' data-id_in_db='{$t_elem.tracking|escape}'><i type="button" class="fa fa-trash-o"></i></a></td>

    {if $active_modules.Order_Tracking}
      {$order.tracking=$t_elem.tracking}
      <td>
        {if $postal_service eq "UPS"}
          {include file="modules/Order_Tracking/ups.tpl" tracking_ind=$tracking_ind}
        {elseif $postal_service eq "USP"}
          {include file="modules/Order_Tracking/usps.tpl" tracking_ind=$tracking_ind}
        {*elseif $postal_service eq "Can"}
          {include file="modules/Order_Tracking/canada_post.tpl" tracking_ind=$tracking_ind*}
        {elseif $postal_service eq "Fed"}
          {include file="modules/Order_Tracking/fedex.tpl" tracking_ind=$tracking_ind}
        {elseif $postal_service eq "Aus"}
          {include file="modules/Order_Tracking/australia_post.tpl" tracking_ind=$tracking_ind}
        {elseif $postal_service eq "DHL"}
          {include file="modules/Order_Tracking/dhl.tpl" tracking_ind=$tracking_ind}
        {elseif $postal_service eq "1-8"}{* ship_code eq "1800C" *}
          {include file="modules/Order_Tracking/courier1800c.tpl" tracking_ind=$tracking_ind}
        {/if}
      </td>
    {/if}
    </tr>
  {/foreach}
{else}
    <tr><td colspan='{if $active_modules.Order_Tracking}3{else}2{/if}'>&nbsp;</td></tr>
{/if}
</table>

