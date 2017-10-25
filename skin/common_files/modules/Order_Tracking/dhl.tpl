{*
90f887473f85a3590756e3235f64ed48131fe383, v3 (xcart_4_7_6), 2016-05-18 10:43:45, dhl.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<form action="http://www.dhl.com/en/express/tracking.html" name="trackingIndex" id="trackingIndex" method="get" target="_blank">
  <input type="hidden" id="AWB" name="AWB" value="{get_order_tracking_numbers orderid=$order.orderid current_tracking_ind=$tracking_ind limit=10 delim=','}" />
  {include file="customer/buttons/button.tpl" button_title=$lng.lbl_track_it title=$lng.txt_dhl_redirection type='input' button_fa_icon='fa fa-truck'}
</form>
