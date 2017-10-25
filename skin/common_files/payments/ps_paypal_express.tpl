{*
1da5bbb33d7d51430039532e2700585a757d1912, v12 (xcart_4_7_4), 2015-10-23 08:59:55, ps_paypal_express.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<table cellspacing="10">
{if $config.paypal_express_method eq 'payflow'}
  {assign var="module_data_payflow" value=$module_data}
  {assign var="module_data" value=$empty_var}
{/if}
</table>

<table class="paypal-method-settings">

  <tr class="first">
    <td class="setting-name">
      <input type="radio" name="paypal_express_method" value="email" id="method_email"{if $config.paypal_express_method ne 'api' && $config.paypal_express_method ne 'payflow'} checked="checked"{/if} onclick="javascript: changeExpressMethod();" />
      &nbsp;<label for="method_email">{$lng.txt_paypal_express_email_note}</label>:
    </td>
    <td>
      <input type="text" name="paypal_express_email" value="{$config.paypal_express_email|default:$default_paypal_email|escape}" id="express_email" size="40" />
    </td>
  </tr>

  <tr class="comment">
    <td colspan="2">{$lng.txt_paypal_express_email_descr}</td>
  </tr>

  <tr>
    <td colspan="2" class="setting-name"><input type="radio" name="paypal_express_method" value="api" id="method_api"{if $config.paypal_express_method eq 'api'} checked="checked"{/if} onclick="javascript: changeExpressMethod();" />
    &nbsp;<label for="method_api">{$lng.txt_paypal_express_api_note}</label>:</td>
  </tr>

  <tr class="comment">
    <td colspan="2">{$lng.txt_paypal_express_api_smallnote}</td>
  </tr>

  <tr>
    <td colspan="2" class="setting-name"><input type="radio" name="paypal_express_method" value="payflow" id="method_payflow"{if $config.paypal_express_method eq 'payflow'} checked="checked"{/if} onclick="javascript: changeExpressMethod();" />
    &nbsp;<label for="method_payflow">{$lng.txt_paypal_express_payflow_note}</label>:</td>
  </tr>

  <tr class="comment last">
    <td colspan="2">{$lng.txt_paypal_express_payflow_smallnote}</td>
  </tr>

</table>

<table class="paypal-method-settings" id="method_api_settings">
{*
  <tr>
    <td colspan="2" id="api_settings">

      <table cellspacing="10">
*}
        <tr class="api-setting api-first api-info">
          <td colspan="2">
            {$lng.lbl_paypal_api_get_credentials|substitute:'url':"javascript: void(0);\" onclick=\"javascript: window.open('https://www.paypal.com/us/cgi-bin/webscr?cmd=_get-api-signature&amp;generic-flow=true','PayPal','width=390,height=550,toolbar=no,status=no,scrollbars=yes,resizable=no,menubar=no,location=no,direction=no');"}
          </td>
        </tr>

        <tr class="api-setting">
          <td class="setting-name">{$lng.lbl_paypal_merchant_id}:</td>
          <td>
            <input type="text" name="paypal_incontext_merchantid" value="{$config.paypal_incontext_merchantid}" size="40" />
            {include file="main/tooltip_js.tpl" text=$lng.txt_help_paypal_incontext_merchantid id="tip_txt_help_paypal_incontext_merchantid" type='img' width=400 sticky=1}
          </td>
        </tr>

        <tr class="api-setting">
          <td class="setting-name">{$lng.lbl_paypal_api_access_username}:</td>
          <td><input type="text" name="{$conf_prefix}[param01]" size="42" value="{$module_data.param01|escape}" /></td>
        </tr>

        <tr class="api-setting">
          <td class="setting-name">{$lng.lbl_paypal_api_access_password}:</td>
          <td><input type="password" name="{$conf_prefix}[param02]" size="42" value="{$module_data.param02|escape}" /></td>
        </tr>

        <tr class="api-setting">
          <td valign="top" class="setting-name">{$lng.lbl_paypal_api_use_method}:</td>
          <td>
            <table>
              <tr>
                <td><input type="radio" id="APISE" name="{$conf_prefix}[param07]" value="S"{if $module_data.param07 ne 'C'} checked="checked"{/if} /></td>
                <td><label for="APISE">{$lng.lbl_paypal_api_signature_type}</label></td>
              </tr>
              <tr>
                <td><input type="radio" id="APICE" name="{$conf_prefix}[param07]" value="C"{if $module_data.param07 eq 'C'} checked="checked"{/if} /></td>
                <td><label for="APICE">{$lng.lbl_paypal_api_certificate_type}</label></td>
              </tr>
            </table>
          </td>
        </tr>

        <tr class="api-setting">
          <td class="setting-name">{$lng.lbl_paypal_api_certificate_file}:</td>
          <td>
            xcart_dir/payment/certs/<input type="text" name="{$conf_prefix}[param04]" size="42" value="{$module_data.param04|escape}" />
          </td>
        </tr>

        <tr class="api-setting">
          <td class="setting-name">{$lng.lbl_paypal_api_access_signature}:</td>
          <td><input type="text" name="{$conf_prefix}[param05]" size="70" value="{$module_data.param05|escape}" /></td>
        </tr>

        <tr class="api-setting api-last">
          <td class="setting-name">{$lng.lbl_use_preauth_method}:</td>
          <td>
            <select name="{$conf_prefix}[use_preauth]">
              <option value="">{$lng.lbl_auth_and_capture_method}</option>
              <option value="Y"{if $module_data.use_preauth eq 'Y'} selected="selected"{/if}>{$lng.lbl_auth_method}</option>
            </select>
          </td>
        </tr>
{*
      </table>

    </td>
  </tr>
*}

</table>

<table class="paypal-method-settings" id="method_api_and_email_settings">
  <tr>
    <td class="setting-name">{$lng.lbl_cc_testlive_mode}:</td>
    <td>
      <select name="{$conf_prefix}[testmode]">
        <option value="Y"{if $module_data.testmode eq "Y"} selected="selected"{/if}>{$lng.lbl_cc_testlive_test}</option>
        <option value="N"{if $module_data.testmode eq "N"} selected="selected"{/if}>{$lng.lbl_cc_testlive_live}</option>
      </select>
    </td>
  </tr>

  <tr class="comment">
    <td>&nbsp;</td>
    <td>{$lng.lbl_paypal_test_mode_note}</td>
  </tr>

  <tr class="last">
    <td class="setting-name">{$lng.lbl_cc_currency}:</td>
    <td>
      <select name="{$conf_prefix}[param03]">
        <option value="AUD"{if $module_data.param03 eq "AUD"} selected="selected"{/if}>Australian Dollar</option>
        <option value="BRL"{if $module_data.param03 eq "BRL"} selected="selected"{/if}>Brazilian Real</option>
        <option value="CAD"{if $module_data.param03 eq "CAD"} selected="selected"{/if}>Canadian Dollar</option>
        <option value="CHF"{if $module_data.param03 eq "CHF"} selected="selected"{/if}>Swiss Franc</option>
        <option value="CZK"{if $module_data.param03 eq "CZK"} selected="selected"{/if}>Czech Koruna</option>
        <option value="DKK"{if $module_data.param03 eq "DKK"} selected="selected"{/if}>Danish Krone</option>
        <option value="EUR"{if $module_data.param03 eq "EUR"} selected="selected"{/if}>Euro</option>
        <option value="GBP"{if $module_data.param03 eq "GBP"} selected="selected"{/if}>Pound Sterling</option>
        <option value="HKD"{if $module_data.param03 eq "HKD"} selected="selected"{/if}>Hong Kong Dollar</option>
        <option value="HUF"{if $module_data.param03 eq "HUF"} selected="selected"{/if}>Hungarian Forint</option>
        <option value="ILS"{if $module_data.param03 eq "ILS"} selected="selected"{/if}>Israeli New Sheqel</option>
        <option value="JPY"{if $module_data.param03 eq "JPY"} selected="selected"{/if}>Japanese Yen</option>
        <option value="MYR"{if $module_data.param03 eq "MYR"} selected="selected"{/if}>Malaysian Ringgit</option>
        <option value="MXN"{if $module_data.param03 eq "MXN"} selected="selected"{/if}>Mexican Peso</option>
        <option value="NOK"{if $module_data.param03 eq "NOK"} selected="selected"{/if}>Norwegian Krone</option>
        <option value="NZD"{if $module_data.param03 eq "NZD"} selected="selected"{/if}>New Zealand Dollar</option>
        <option value="PHP"{if $module_data.param03 eq "PHP"} selected="selected"{/if}>Philippine Peso</option>
        <option value="PLN"{if $module_data.param03 eq "PLN"} selected="selected"{/if}>Polish Zloty</option>
        <option value="SEK"{if $module_data.param03 eq "SEK"} selected="selected"{/if}>Swedish Krona</option>
        <option value="SGD"{if $module_data.param03 eq "SGD"} selected="selected"{/if}>Singapore Dollar</option>
        <option value="TWD"{if $module_data.param03 eq "TWD"} selected="selected"{/if}>Taiwan New Dollar</option>
        <option value="THB"{if $module_data.param03 eq "THB"} selected="selected"{/if}>Thai Baht</option>
        <option value="USD"{if $module_data.param03 eq 'USD' || $module_data.param03 eq ''} selected="selected"{/if}>U.S. Dollar</option>
      </select>
    </td>
  </tr>

  <tr class="optional header">
    <td colspan="2">{$lng.lbl_optional_settings}</td>
  </tr>

  <tr class="optional first">
    <td class="setting-name">{$lng.lbl_cc_order_prefix}:</td>
    <td>
      <input type="text" name="{$conf_prefix}[param06]" size="24" value="{$module_data.param06|escape}" />
    </td>
  </tr>

  <tr class="optional comment">
    <td>&nbsp;</td>
    <td>{$lng.txt_order_prefix_descr}</td>
  </tr>

  <tr class="optional">
    <td class="setting-name">{$lng.txt_paypal_payflowcolor}:</td>
    <td>
      <input type="text" name="{$conf_prefix}[param08]" size="24" maxlength="6" value="{$module_data.param08|escape}" />
    </td>
  </tr>

  <tr class="optional comment">
    <td>&nbsp;</td>
    <td>{$lng.lbl_paypal_api_rgb_color}</td>
  </tr>

  <tr class="optional">
    <td class="setting-name">{$lng.txt_paypal_hdrimage}:</td>
    <td>
      <input type="text" name="{$conf_prefix}[param09]" size="64" maxlength="127" value="{$module_data.param09|escape}" />
    </td>
  </tr>

  <tr class="optional comment last">
    <td>&nbsp;</td>
    <td>{$lng.txt_paypal_hdrimage_descr}</td>
  </tr>

</table>

{include file="payments/ps_paypal_uk.tpl" conf_prefix="conf_data[express_payflow]" module_data=$module_data_payflow}
