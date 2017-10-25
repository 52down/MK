{*
bf91ad602bafcbc494430af26e3c36f0123626ad, v21 (xcart_4_7_6), 2016-05-25 09:33:41, cc_authorizenet_sim.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<h1>{$module_data.module_name}</h1>
{$lng.txt_cc_configure_top_text}
<br /><br />

<a href="http://reseller.authorize.net/application/?id=5556098" target="_blank"><img src="{$ImagesDir}/certified_cart.gif" width="150" height="42" alt="" align='middle' /></a>
<a href="http://reseller.authorize.net/application/?id=5556098" class="simple-button" target="_blank">{$lng.lbl_cc_authorizenet_signup}</a>
<br />
<form action="cc_processing.php?cc_processor={$smarty.get.cc_processor|escape:"url"}" method="post">

<table cellspacing="10">
<tr>
<td>{$lng.lbl_anet_valid_referrer_url}:</td>
<td>{if $config.Security.use_https_login eq 'Y'}{$https_location}{else}{$http_location}{/if}/payment/cc_authorizenet_sim.php</td>
</tr>
<tr>
<td>{$lng.lbl_anet_relay_url}:</td>
<td>{if $config.Security.use_https_login eq 'Y'}{$https_location}{else}{$http_location}{/if}/payment/cc_authorizenet_sim.php</td>
</tr>
<tr>
<td>{$lng.lbl_cc_authorizenet_login}:</td>
<td><input type="text" name="param01" size="24" value="{$module_data.param01|escape}" /></td>
</tr>
<tr>
<td>{$lng.lbl_cc_authorizenet_trans_key}:</td>
<td><input type="text" name="param02" size="24" value="{$module_data.param02|escape}" /></td>
</tr>
<tr>
<td>{$lng.lbl_asim_timestamp_offset}:</td>
<td><input type="text" name="param06" size="6" maxlength="6" value="{$module_data.param06|default:"0"|escape}" /></td>
</tr>

<tr>
<td>{$lng.lbl_cc_currency}:</td>
<td>{* http://www.authorize.net/support/SIM_guide.pdf http://www.authorize.net/content/dam/authorize/documents/SIM_guide.pdf *}
<select name="param05">
<option value="used_from_authorize"{if $module_data.param05 eq "used_from_authorize"} selected="selected"{/if}>{$lng.lbl_cc_authorizenet_used_backend|escape}</option>
<option value="AUD"{if $module_data.param05 eq "AUD"} selected="selected"{/if}>Australian Dollar (Australia)</option>
<option value="CAD"{if $module_data.param05 eq "CAD"} selected="selected"{/if}>Canadian Dollar (Canada)</option>
<option value="GBP"{if $module_data.param05 eq "GBP"} selected="selected"{/if}>Pound Sterling (United Kingdom)</option>
<option value="NZD"{if $module_data.param05 eq "NZD"} selected="selected"{/if}>New Zealand Dollar</option>
<option value="USD"{if $module_data.param05 eq "USD" or $module_data.param05 eq ""} selected="selected"{/if}>US Dollar (United States)</option>
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
<td><input type="text" name="param04" size="36" maxlength="{if $single_mode}8{else}4{/if}" value="{$module_data.param04|escape}" />{include file="main/tooltip_js.tpl" text=$lng.txt_cc_authorizenet_prefix_help id="order_prefix_help" type='img' width=400}</td>
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

</table>
<br /><br />
<input type="submit" value="{$lng.lbl_update|strip_tags:false|escape}" />
</form>

<div style="padding: 0 20px">
  {$lng.txt_cc_authorizenet_tstamp_note}
</div>
