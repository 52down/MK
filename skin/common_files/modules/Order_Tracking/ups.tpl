{*
90f887473f85a3590756e3235f64ed48131fe383, v2 (xcart_4_7_6), 2016-05-18 10:43:45, ups.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<form name="noname" method="post" action="https://wwwapps.ups.com/WebTracking/track" target="_blank">
  <input name="accept_UPS_license_agreement" type="hidden" value="yes"  />
  <input name="loc" type="hidden" value="en_US" />
  <input name="track.x" type="hidden" value="Track" />
  <input name="trackNums" type="hidden" value="{get_order_tracking_numbers orderid=$order.orderid current_tracking_ind=$tracking_ind limit=25 delim='\n'}" />
  {include file="customer/buttons/button.tpl" button_title=$lng.lbl_track_it title=$lng.txt_ups_redirection type='input' button_fa_icon='fa fa-truck'}
</form>
