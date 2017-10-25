{*
41562c5cfeb62cd856c8982b2d194c8a49e4f4c3, v9 (xcart_4_7_7), 2016-12-26 19:10:26, shipping_estimator.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{getvar var='is_address_book_empty' func='func_tpl_is_address_book_empty'}
{if $login eq '' and $config.Shipping.enable_shipping eq 'Y'}

  <div class="estimator-container cart-border">

    {if $userinfo ne ''}

      <strong>{$lng.lbl_destination}:</strong>

      {foreach from=$shipping_estimate_fields item=f key=k name=estimate}
        {if $userinfo.address.S eq ''}
          {assign var=k value="s_"|cat:$k}
        {/if}  
        {assign var=_fieldname value=$k|cat:'name'}
        {assign var=_field value=$userinfo.address.S.$_fieldname|default:$userinfo.address.S.$k|default:$userinfo.$_fieldname|default:$userinfo.$k}
        {if $f.avail eq 'Y' and $_field ne ''}
          {$_field}
          {if not $smarty.foreach.estimate.last}, {/if}{/if}
      {/foreach}
    
      {assign var=btitle value=$lng.lbl_change}

    {/if}

    <div class="button-row">
      {include file="customer/buttons/button.tpl" button_title=$btitle|default:$lng.lbl_estimate_shipping_cost href="javascript:popupOpen('popup_estimate_shipping.php');" style="link"}
    </div>

    {if not $active_modules.Bongo_International or not $cart.bongo_landedCost}
    <div class="smethods">
      {include file="customer/main/checkout_shipping_methods.tpl" simple_list=true}
    </div>
    {/if}

  </div>

  <hr />
{elseif $login and $is_address_book_empty and $need_shipping}
  <div class="estimator-container cart-border">
    <div class="button-row">
      {$lng.lbl_enter_address_to_estimate_shipping}
    </div>
  </div>
{/if}
