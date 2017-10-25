{*
350042ea72f8d02d75dfce69a0fafa85d0867aed, v6 (xcart_4_4_4), 2011-07-29 13:41:09, shipping_methods.tpl, aim
vim: set ts=2 sw=2 sts=2 et:
*}
<table cellspacing="0" class="checkout-shippings" summary="{$lng.lbl_payment_methods|escape}">

{foreach from=$shipping item=s name=sm}
  <tr{if $smarty.foreach.sm.last} class="last"{/if}>
    {if not $simple_list}
      <td>
        <input type="radio" id="shipping{$s.shippingid}" name="shippingid" value="{$s.shippingid}"{if $s.shippingid eq $cart.shippingid} checked="checked"{/if} />
      </td>
    {/if}
    <td class="shipping-name">
      <label for="shipping{$s.shippingid}">
      {$s.shipping|trademark}{if $s.shipping_time ne ""} - {$s.shipping_time}{/if}
      </label>
      {if $s.warning ne ""}
        <div class="{if $s.shippingid eq $cart.shippingid}error-message{else}small-note{/if}">{$s.warning}</div>
      {/if}
    </td>
    {if $config.Appearance.display_shipping_cost eq "Y" and ($userinfo ne "" or $config.General.apply_default_country eq "Y" or $cart.shipping_cost gt 0)}
      <td class="shipping-cost">{currency value=$s.rate}</td>
    {else}
      <td class="shipping-cost">&nbsp;</td>
    {/if}

  </tr>
{/foreach}

</table>
