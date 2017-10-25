{*
10c3e625033f1349de3faace1f7e01af9abfaa87, v3 (xcart_4_7_4), 2015-10-21 18:02:19, cc_alipay.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<h1>Alipay - Alibaba Corporation</h1>
{$lng.txt_cc_configure_top_text}
<br /><br />
{capture name=dialog}
  <form action="cc_processing.php?cc_processor={$smarty.get.cc_processor|escape:"url"}" method="post" enctype="multipart/form-data">
    <table cellspacing="10">

      <tr>
        <td>{$lng.lbl_cc_alipay_partnerid}:</td>
        <td><input type="text" name="param01" size="32" maxsize="16" value="{$module_data.param01|escape}" /></td>
      </tr>
      <tr>
        <td>{$lng.lbl_cc_alipay_secret}:</td>
        <td><input type="text" name="param02" size="32" maxsize="255" value="{$module_data.param02|escape}" /></td>
      </tr>
      <tr>
        <td colspan="2"><hr /></td>
      </tr>

      <tr>
        <td>{$lng.lbl_cc_currency}:</td>
        <td>
          <select name="param03">
            <option value="AUD" {if $module_data.param03 eq 'AUD'}selected{/if}>AUD Australian Dollar</option>
            <option value="CAD" {if $module_data.param03 eq 'CAD'}selected{/if}>CAD Canada Dollar</option>
            <option value="CHF" {if $module_data.param03 eq 'CHF'}selected{/if}>CHF Confederation Helvetica Franc</option>
            <option value="DKK" {if $module_data.param03 eq 'DKK'}selected{/if}>DKK Danish Krone</option>
            <option value="EUR" {if $module_data.param03 eq 'EUR'}selected{/if}>EUR Euro</option>
            <option value="GBP" {if $module_data.param03 eq 'GBP'}selected{/if}>GBP British Sterling</option>
            <option value="HKD" {if $module_data.param03 eq 'HKD'}selected{/if}>HKD Hong Kong Dollar</option>
            <option value="JPY" {if $module_data.param03 eq 'JPY'}selected{/if}>JPY Japanese Yen</option>
            <option value="MOP" {if $module_data.param03 eq 'MOP'}selected{/if}>MOP Macau Pataca</option>
            <option value="NOK" {if $module_data.param03 eq 'NOK'}selected{/if}>NOK Norwegian Krone</option>
            <option value="NZD" {if $module_data.param03 eq 'NZD'}selected{/if}>NZD New Zealand Dollar</option>
            <option value="RMB" {if $module_data.param03 eq 'RMB'}selected{/if}>RMB Chinese Yuan</option>
            <option value="RUB" {if $module_data.param03 eq 'RUB'}selected{/if}>RUB Russian Rouble</option>
            <option value="SEK" {if $module_data.param03 eq 'SEK'}selected{/if}>SEK Swedish Krona</option>
            <option value="SGD" {if $module_data.param03 eq 'SGD'}selected{/if}>SGD Singapore Dollar</option>
            <option value="USD" {if $module_data.param03 eq 'USD'}selected{/if}>USD U.S. Dollar</option>
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
        <td>{$lng.lbl_cc_order_prefix}:</td>
        <td><input type="text" name="param04" size="32" value="{$module_data.param04|escape}" /></td>
      </tr>

    </table>
    <br /><br />
    <input type="submit" value="{$lng.lbl_update|strip_tags:false|escape}" />
  </form>
{/capture}
{include file="dialog.tpl" title=$lng.lbl_cc_settings content=$smarty.capture.dialog extra='width="100%"'}
