{*
90f887473f85a3590756e3235f64ed48131fe383, v2 (xcart_4_7_6), 2016-05-18 10:43:45, fedex.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<form name="tracking" method='get' action="https://www.fedex.com/apps/fedextrack/" target="_blank">
  <input type="hidden" name="ascend_header" value="1" />
  <input type="hidden" name="clienttype" value="dotcom" />
  <input type="hidden" name="cntry_code" value="us" />
  <input type="hidden" name="language" value="english" />
  <input type="hidden" name="trackingnumber" value="{get_order_tracking_numbers orderid=$order.orderid current_tracking_ind=$tracking_ind limit=30 delim=','}" />
  {include file="customer/buttons/button.tpl" button_title=$lng.lbl_track_it title=$lng.txt_fedex_redirection type='input' button_fa_icon='fa fa-truck'}
</form>
