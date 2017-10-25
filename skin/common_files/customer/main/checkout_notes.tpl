{*
2a8657a03044f2f96b7b6fdb859bda8bc2fa6aa3, v4 (xcart_4_7_3), 2015-05-20 11:42:08, checkout_notes.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{include file="customer/subheader.tpl" title=$lng.txt_notes class="grey"}

<table cellspacing="0" class="data-table" summary="{$lng.lbl_customer_notes|escape}">
  <tr>
    <td class="data-name">{$lng.lbl_customer_notes}:</td>
    <td><textarea cols="70" rows="10" name="Customer_Notes"></textarea></td>
  </tr>

  {if $active_modules.XAffiliate eq "Y" and $partner eq '' and $config.XAffiliate.ask_partnerid_on_checkout eq 'Y'}
    {include file="partner/main/checkout_partner.tpl"}
  {/if}

{if $active_modules.Adv_Mailchimp_Subscription ne '' and $mc_newslists ne ''}
  {include file="modules/Adv_Mailchimp_Subscription/customer/main/mailchimp_checkout_notes.tpl"}
{/if}

</table>
