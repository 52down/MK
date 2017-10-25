{*
33a5d147bed24eb5923a591abbb371ca6a0146eb, v5 (xcart_4_7_6), 2016-03-07 18:30:44, cc_heidel.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<h1>Heidel platform. POST integrator</h1>
{$lng.txt_cc_configure_top_text}
<br /><br />
{capture name=dialog}
<form action="cc_processing.php?cc_processor={$smarty.get.cc_processor|escape:"url"}" method="post">

<table cellspacing="10">
<tr>
<td>{$lng.lbl_cc_heidel_sender}:</td>
<td><input type="text" name="param01" size="32" value="{$module_data.param01|escape}" /></td>
</tr>
<tr>
<td>{$lng.lbl_cc_heidel_token}:</td>
<td><input type="text" name="param02" size="32" value="{$module_data.param02|escape}" /></td>
</tr>

<tr>
<td>{$lng.lbl_cc_heidel_user}:</td>
<td><input type="text" name="param08" size="32" value="{$module_data.param08|escape}" /></td>
</tr>
<tr>
<td>{$lng.lbl_cc_heidel_pwd}:</td>
<td><input type="password" name="param07" size="32" value="{$module_data.param07|escape}" /></td>
</tr>

<tr>
<td>{$lng.lbl_cc_heidel_channel}:</td>
<td><input type="text" name="param04" size="32" value="{$module_data.param04|escape}" /></td>
</tr>
<tr>
<td>{$lng.lbl_cc_currency}:</td>
<td>
<select name="param03">
<option value="AUD"{if $module_data.param03 eq "AUD"} selected="selected"{/if}>Australian Dollar</option>
<option value="CAD"{if $module_data.param03 eq "CAD"} selected="selected"{/if}>Canadian Dollar</option>
<option value="CHF"{if $module_data.param03 eq "CHF"} selected="selected"{/if}>Swiss Franc</option>
<option value="CZK"{if $module_data.param03 eq "CZK"} selected="selected"{/if}>Czech Koruna</option>
<option value="DEM"{if $module_data.param03 eq "DEM"} selected="selected"{/if}>German mark</option>
<option value="DKK"{if $module_data.param03 eq "DKK"} selected="selected"{/if}>Danish Kroner</option>
<option value="EUR"{if $module_data.param03 eq "EUR"} selected="selected"{/if}>EURO</option>
<option value="FRF"{if $module_data.param03 eq "FRF"} selected="selected"{/if}>French franc</option>
<option value="GBP"{if $module_data.param03 eq "GBP"} selected="selected"{/if}>British pound</option>
<option value="HKD"{if $module_data.param03 eq "HKD"} selected="selected"{/if}>Hong Kong Dollar</option>
<option value="HUF"{if $module_data.param03 eq "HUF"} selected="selected"{/if}>Hungarian Forint</option>
<option value="ILS"{if $module_data.param03 eq "ILS"} selected="selected"{/if}>New Shekel</option>
<option value="JPY"{if $module_data.param03 eq "JPY"} selected="selected"{/if}>Japanese Yen</option>
<option value="MXN"{if $module_data.param03 eq "MXN"} selected="selected"{/if}>Peso</option>
<option value="NOK"{if $module_data.param03 eq "NOK"} selected="selected"{/if}>Norwegian Kroner</option>
<option value="NZD"{if $module_data.param03 eq "NZD"} selected="selected"{/if}>New Zealand Dollar</option>
<option value="PLN"{if $module_data.param03 eq "PLN"} selected="selected"{/if}>Polish Zloty</option>
<option value="RUB"{if $module_data.param03 eq "RUB"} selected="selected"{/if}>Russian Ruble</option>
<option value="SEK"{if $module_data.param03 eq "SEK"} selected="selected"{/if}>Swedish Krone</option>
<option value="SGD"{if $module_data.param03 eq "SGD"} selected="selected"{/if}>Singapore Dollar</option>
<option value="THB"{if $module_data.param03 eq "THB"} selected="selected"{/if}>Thai Bath</option>
<option value="TRL"{if $module_data.param03 eq "TRL"} selected="selected"{/if}>Lire Turque</option>
<option value="USD"{if $module_data.param03 eq "USD"} selected="selected"{/if}>US Dollar</option>
<option value="ZAR"{if $module_data.param03 eq "ZAR"} selected="selected"{/if}>South African Rand</option>
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
<td><input type="text" name="param06" size="32" value="{$module_data.param06|escape}" /></td>
</tr>
</table>
<br /><br />
<input type="submit" value="{$lng.lbl_update|strip_tags:false|escape}" />
</form>

{/capture}
{include file="dialog.tpl" title=$lng.lbl_cc_settings content=$smarty.capture.dialog extra='width="100%"'}
