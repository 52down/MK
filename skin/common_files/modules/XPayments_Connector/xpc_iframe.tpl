{*
f47176ce7a31af5b18d27f5c9cbb99199174beb5, v10 (xcart_4_7_6), 2015-10-26 16:26:23, xpc_iframe.tpl, random

vim: set ts=2 sw=2 sts=2 et:
*}
{* Draws iframe container *}
{if $save_cc}
  <iframe width="280" height="100" border="0" marginheight="0" marginwidth="0" frameborder="0" class="xpc_iframe" id="xpc_iframe" name="xpc_iframe">
  </iframe>
{else}
<div class="xpc-iframe-container">
{if $active_modules.One_Page_Checkout}

  <script type="text/javascript">
  //<![CDATA[
    xpc_paymentids[{$payment.paymentid}] = {$payment.paymentid};
  //]]>
  </script>

  <iframe width="{if $xpc_allow_full_width_iframe}100%{else}280{/if}" height="0" border="0" marginheight="0" marginwidth="0" frameborder="0" class="xpc_iframe" id="xpc_iframe{$payment.paymentid}" name="xpc_iframe{$payment.paymentid}">
  </iframe>

{elseif $active_modules.Fast_Lane_Checkout}

  <a name="payment_details"></a>

  <div class="xpc_iframe_container">
    <iframe width="100%" height="100" border="0" marginheight="0" marginwidth="0" frameborder="0" class="xpc_iframe" id="xpc_iframe" name="xpc_iframe" src="payment/cc_xpc_iframe.php?paymentid={$paymentid}">
    </iframe>
  </div>

  <script type="text/javascript">
  //<![CDATA[
    xpc_iframe_method = true;

    if (window.location.hash == '')
      window.location.hash = 'payment_details';

    $('.xpc_iframe_container').block();
  //]]>
  </script>

{/if}

{include file="modules/XPayments_Connector/allow_recharges.tpl"}
</div>
{/if}
