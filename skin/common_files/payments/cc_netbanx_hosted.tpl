{*
bf91ad602bafcbc494430af26e3c36f0123626ad, v3 (xcart_4_7_6), 2016-05-25 09:33:41, cc_netbanx_hosted.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<h1>{$module_data.module_name}</h1>

<img src="{$ImagesDir}/netbanx_184px.png" width="92" height="92" alt="Netbanx logo" align="right" style="padding-left: 10px;" />
{$lng.txt_cc_configure_top_text}
<br /><br />
<input type="button" name="netbanx_signup" value="{$lng.lbl_cc_netbanxhosted_signup}" onclick="javascript: window.open('http://www1.netbanx.com/about/contact/form/');" />
<br /><br />

{capture name=dialog}
<form action="cc_processing.php?cc_processor={$module_data.processor|escape:"url"}" method="post">

<table cellspacing="10">
  <tr>
    <td>{$lng.lbl_cc_netbanxhosted_key_id}:</td>
    <td><input type="text" name="param01" size="32" value="{$module_data.param01|escape}" /></td>
  </tr>

  <tr>
    <td>{$lng.lbl_cc_netbanxhosted_key_password}:</td>
    <td><input type="text" name="param02" size="105" value="{$module_data.param02|escape}" /></td>
  </tr>

  <tr>
    <td>{$lng.lbl_cc_netbanxhosted_merchant_email}:</td>
    <td><input type="text" name="param05" size="32" value="{$module_data.param05|escape}" /><br />
    </td>
  </tr>

  <tr>
    <td>{$lng.lbl_cc_currency}:</td>
    <td>
      <select name="param03">{* {{{ https://developer.optimalpayments.com/en/documentation/hosted-payment-api/currency-codes/ *}
        <option value="ARS"{if $module_data.param03 eq "ARS"} selected="selected"{/if}>Argentine Peso</option>
        <option value="AUD"{if $module_data.param03 eq "AUD"} selected="selected"{/if}>Australian Dollar</option>
        <option value="THB"{if $module_data.param03 eq "THB"} selected="selected"{/if}>Baht</option>
        <option value="BRL"{if $module_data.param03 eq "BRL"} selected="selected"{/if}>Brazilian Real</option>
        <option value="BGN"{if $module_data.param03 eq "BGN"} selected="selected"{/if}>Bulgarian Lev</option>
        <option value="CAD"{if $module_data.param03 eq "CAD"} selected="selected"{/if}>Canadian Dollar</option>
        <option value="CZK"{if $module_data.param03 eq "CZK"} selected="selected"{/if}>Czech Koruna</option>
        <option value="DKK"{if $module_data.param03 eq "DKK"} selected="selected"{/if}>Danish Krone</option>
        <option value="EUR"{if $module_data.param03 eq "EUR"} selected="selected"{/if}>Euro</option>
        <option value="HUF"{if $module_data.param03 eq "HUF"} selected="selected"{/if}>Forint</option>
        <option value="HKD"{if $module_data.param03 eq "HKD"} selected="selected"{/if}>Hong Kong Dollar</option>
        <option value="ISK"{if $module_data.param03 eq "ISK"} selected="selected"{/if}>Iceland Krona</option>
        <option value="JPY"{if $module_data.param03 eq "JPY"} selected="selected"{/if}>Japanese Yen</option>
        <option value="MXN"{if $module_data.param03 eq "MXN"} selected="selected"{/if}>Mexican Peso</option>
        <option value="ILS"{if $module_data.param03 eq "ILS"} selected="selected"{/if}>New Israeli Shekel</option>
        <option value="RON"{if $module_data.param03 eq "RON"} selected="selected"{/if}>New Leu</option>
        <option value="TWD"{if $module_data.param03 eq "TWD"} selected="selected"{/if}>New Taiwan Dollar</option>
        <option value="NZD"{if $module_data.param03 eq "NZD"} selected="selected"{/if}>New Zealand Dollar</option>
        <option value="NOK"{if $module_data.param03 eq "NOK"} selected="selected"{/if}>Norwegian Krone</option>
        <option value="GBP"{if $module_data.param03 eq "GBP"} selected="selected"{/if}>Pound Sterling</option>
        <option value="ZAR"{if $module_data.param03 eq "ZAR"} selected="selected"{/if}>Rand</option>
        <option value="SGD"{if $module_data.param03 eq "SGD"} selected="selected"{/if}>Singapore Dollar</option>
        <option value="SEK"{if $module_data.param03 eq "SEK"} selected="selected"{/if}>Swedish Krona</option>
        <option value="CHF"{if $module_data.param03 eq "CHF"} selected="selected"{/if}>Swiss Franc</option>
        <option value="USD"{if $module_data.param03 eq "USD" or not $module_data.param03} selected="selected"{/if}>US Dollar</option>
        <option value="PLN"{if $module_data.param03 eq "PLN"} selected="selected"{/if}>Zloty</option>
      </select>
    </td>
  </tr>{*}}}*}


  <tr>
    <td>{$lng.lbl_cc_netbanxhosted_paymentmethod}:</td> {* https://developer.optimalpayments.com/en/documentation/hosted-payment-api/payment-method-notes/ *}
    <td>
      <select name="param04">
        <option value="card"{if $module_data.param04 eq "card"} selected="selected"{/if}>card</option>
        <option value="giropay"{if $module_data.param04 eq "giropay"} selected="selected"{/if}>giropay</option>
        <option value="ideal"{if $module_data.param04 eq "ideal"} selected="selected"{/if}>ideal</option>
        <option value="interac"{if $module_data.param04 eq "interac"} selected="selected"{/if}>interac</option>
        <option value="masterpass"{if $module_data.param04 eq "masterpass"} selected="selected"{/if}>masterpass</option>
        <option value="neteller"{if $module_data.param04 eq "neteller"} selected="selected"{/if}>neteller</option>
        <option value="paynearme"{if $module_data.param04 eq "paynearme"} selected="selected"{/if}>paynearme</option>
        <option value="paypal"{if $module_data.param04 eq "paypal"} selected="selected"{/if}>paypal</option>
        <option value="poli"{if $module_data.param04 eq "poli"} selected="selected"{/if}>poli</option>
        <option value="prepaidcard"{if $module_data.param04 eq "prepaidcard"} selected="selected"{/if}>prepaidcard</option>
        <option value="sofortbanking"{if $module_data.param04 eq "sofortbanking"} selected="selected"{/if}>sofortbanking</option>
      </select>
    </td>
  </tr>

  <tr>
    <td>{$lng.lbl_cc_testlive_mode}:</td>
    <td>
      <select name="testmode">
        <option value="Y"{if $module_data.testmode eq "Y"} selected="selected"{/if}>{$lng.lbl_cc_testlive_test}</option>
        <option value="N"{if $module_data.testmode eq "N"} selected="selected"{/if}>{$lng.lbl_cc_testlive_live}</option>
      </select>
    </td>
  </tr>

  <tr>
    <td>{$lng.lbl_use_preauth_method}:</td>
    <td>
      <select name="use_preauth">
        <option value="">{$lng.lbl_auth_and_capture_method}</option>
        <option value="Y"{if $module_data.use_preauth eq 'Y'} selected="selected"{/if}>{$lng.lbl_auth_method}</option>
      </select>
    </td>
  </tr>

  <tr>
    <td>{$lng.lbl_cc_order_prefix}:</td>
    <td><input type="text" name="param09" size="32" maxlength="{if $single_mode}12{else}8{/if}" value="{$module_data.param09|escape}" /><br />
    </td>
  </tr>

</table>
<br />

<input type="submit" value="{$lng.lbl_update|strip_tags:false|escape}" />

</form>
{/capture}
{include file="dialog.tpl" title=$lng.lbl_cc_settings content=$smarty.capture.dialog extra='width="100%"'}
