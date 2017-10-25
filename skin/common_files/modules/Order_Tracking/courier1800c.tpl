{*
90f887473f85a3590756e3235f64ed48131fe383, v1 (xcart_4_7_6), 2016-05-18 10:43:45, courier1800c.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<form name="tracking" method='get' action="https://www.1-800courier.com/tracking.asp" target="_blank">
  <input type="hidden" name="code" value="{$order.tracking|escape}" />
  {include file="customer/buttons/button.tpl" button_title=$lng.lbl_track_it type='input' button_fa_icon='fa fa-truck'}
</form>
