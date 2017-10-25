{*
be9581a5c8bee4302a16debb9e0897116cdf6192, v2 (xcart_4_7_8), 2017-04-03 20:33:15, order_extra_data.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{include file="main/subheader.tpl" title=$lng.lbl_sp_order_offers_applied}
{if not $data.applied_offers}
  {getvar var=order_applied_offers func='func_tpl_get_order_applied_offers' orderid=$order.orderid}
{else}
  {assign var="order_applied_offers" value=$data.applied_offers}
{/if}

{if not $order_applied_offers}
{$lng.lbl_sp_no_order_offers_applied}
{else}
<table width="100%" cellspacing="5" cellpadding="5" border="0">
{foreach name=offers from=$order_applied_offers item=offer}
<tr class="TableSubHead">
  <td colspan="3" class="sp-order-offer-name">{$offer.offer_name}</td>
</tr>
<tr>
  <td width="50%" class="sp-order-nav-title">{$lng.lbl_sp_nav_conditions}:</td>
  <td>&nbsp;</td>
  <td width="50%" class="sp-order-nav-title">{$lng.lbl_sp_nav_bonuses}:</td>
</tr>
<tr>
  <td valign="top">
  <table width="100%" cellspacing="5" cellpadding="0" border="0">
  {assign var="cnum" value=1}
  {foreach name=conditions from=$offer.conditions item=condition}
  <tr>
    <td class="sp-order-offer-name">{$cnum}.</td>
    <td width="100%" class="sp-order-offer-name">{include file="modules/Special_Offers/condition_names.tpl" item_type=$condition.condition_type}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>{include file="modules/Special_Offers/condition_names.tpl" item_type=$condition.condition_type action="include" item=$condition item_mode="view"}</td>
  </tr>
  {if not $smarty.foreach.conditions.last}
  <tr>
    <td>&nbsp;</td>
  </tr>
  {/if}
  {inc assign="cnum" value=$cnum}
  {/foreach}
  </table>
  </td>
  <td>&nbsp;</td>
  <td valign="top">
  <table width="100%" cellspacing="5" cellpadding="0" border="0">
  {assign var="bnum" value=1}
  {foreach name=bonuses from=$offer.bonuses item=bonus}
  <tr>
    <td class="sp-order-offer-name">{$bnum}.</td>
    <td width="100%" class="sp-order-offer-name">{include file="modules/Special_Offers/bonus_names.tpl" item_type=$bonus.bonus_type}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>{include file="modules/Special_Offers/bonus_names.tpl" item_type=$bonus.bonus_type action="include" item=$bonus item_mode="view"}</td>
  </tr>
  {if not $smarty.foreach.bonuses.last}
  <tr>
    <td>&nbsp;</td>
  </tr>
  {/if}
  {inc assign="bnum" value=$bnum}
  {/foreach}
  </table>
  </td>
</tr>
{/foreach}
</table>
{/if}
