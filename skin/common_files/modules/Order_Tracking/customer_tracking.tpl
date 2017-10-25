{*
90f887473f85a3590756e3235f64ed48131fe383, v1 (xcart_4_7_6), 2016-05-18 10:43:45, customer_tracking.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $active_modules.Order_Tracking and $order.tracking}
  {getvar var="tracking_numbers" func="func_tpl_get_order_tracking_numbers" orderid=$order.orderid}

  <br />
  <br />
  <br />

  {include file="customer/subheader.tpl" title=$lng.lbl_tracking_order}

  {assign var="postal_service" value=$order.shipping|truncate:3:"":true}

  <table>
  {foreach $tracking_numbers as $tracking_ind=>$number}
    {$order.tracking=$number}
    <tr>
      <td>{$order.tracking}</td>
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
    </tr>
  {/foreach}
  </table>


{/if}
