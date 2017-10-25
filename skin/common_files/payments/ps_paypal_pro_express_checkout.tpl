{*
78f82f1dbb5058a0003d0e90b34f53a7b989a0db, v14 (xcart_4_7_3), 2015-06-29 11:34:56, ps_paypal_pro_express_checkout.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}

{if 
  $paypal_express_active
  && $paypal_express_link ne "logo"
  && $paypal_express_link ne "text"
}
  {getvar var='paypal_express_incontext_available' func='func_get_paypal_express_incontext_available'}

  {if $config.HTTPS_test_passed eq 'Y'}
    {assign var='current_location_paypal' value=$https_location}
  {else}
    {assign var='current_location_paypal' value=$current_location}
  {/if}

  {if $paypal_express_incontext_available}
      {assign var='paypal_express_incontext_url_param' value='&incontext=1'}
      {assign var='paypal_express_incontext_data' value=' data-paypal-button="true"'}
      <script type="text/javascript">
      //<![CDATA[
        xcPayPalIncontextMerchantID = '{$config.paypal_incontext_merchantid|escape:"html"}';
      //]]>
      </script>
  {else}
      {assign var='paypal_express_incontext_url_param' value=''}
      {assign var='paypal_express_incontext_data' value=''}
      {assign var='paypal_express_incontext_available' value=''}
  {/if}
{/if}

{if $paypal_express_link eq "logo"}

  <a href="javascript:void(0);" onclick="javascript: window.open('https://www.paypal.com/cgi-bin/webscr?cmd=xpt/popup/OLCWhatIsPayPal-outside','olcwhatispaypal','width=400, height=350, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no');"><img src="https://www.paypalobjects.com/en_US/i/logo/PayPal_mark_37x23.gif" alt="{$lng.lbl_paypal_alt_text|escape}" /></a>

{elseif $paypal_express_link eq "text"}

  {$lng.txt_paypal_text2}

{elseif $paypal_express_link eq "return"}

  {assign var="smarty_get_paymentid" value=$smarty.get.paymentid|escape:"html"}
  {include file="customer/buttons/button.tpl" button_title=$lng.lbl_modify href="`$current_location_paypal`/payment/ps_paypal_pro.php?mode=express&payment_id=`$smarty_get_paymentid`&do_return=1`$paypal_express_incontext_url_param`"}

{elseif $paypal_express_link eq "button"}

  <div class="paypal-cart-button">
    <div>
      {if not $std_checkout_disabled}
        <p>{$lng.lbl_or_use}</p>
      {/if}
      <form action="{$current_location_paypal}/payment/ps_paypal_pro.php" method="get" name="paypalexpressbuttonform" id="paypalexpressbuttonform">
        <input type="hidden" name="mode" value="express" />
        <input type="hidden" name="payment_id" value="{$paypal_express_active}" />
      {if $paypal_express_incontext_available}
        <input type="hidden" name="incontext" value="1" />
        <div class="paypal-button-hidden"{$paypal_express_incontext_data}></div>
      {else}
        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_xpressCheckout.gif" />
      {/if}
      </form>
    </div>
  </div>

{else}

  {capture name=paypal_express_dialog}

    <form action="{$current_location_paypal}/payment/ps_paypal_pro.php" method="get" name="paypalexpressform">
      <input type="hidden" name="mode" value="express" />
      <input type="hidden" name="payment_id" value="{$paypal_express_active}" />
    {if $paypal_express_incontext_available}
      <input type="hidden" name="incontext" value="1" />
      <div class="paypal-button-hidden"{$paypal_express_incontext_data}></div>
    {else}
      <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_xpressCheckout.gif" class="paypal-cart-icon" />
    {/if}
      {$lng.txt_paypal_text1}
    </form>

  {/capture}
  {include file="customer/dialog.tpl" title=$lng.lbl_checkout_with_paypal_express content=$smarty.capture.paypal_express_dialog}

{/if}

{if $paypal_express_incontext_available}
    {load_defer file="js/paypal_express_incontext.js" type="js"}
{/if}
