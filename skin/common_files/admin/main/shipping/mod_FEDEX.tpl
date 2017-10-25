{*
67814c9aec19d6cf932988e3b949b16094b3dab9, v1 (xcart_4_7_4), 2015-10-28 10:53:25, mod_FEDEX.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $carrier eq "FDX"}
{*************************************************************
 *  FEDEX OPTIONS                                            *
 *************************************************************}

{capture name=dialog}

<div align="right"><a href="shipping.php?carrier=FDX#rt">{$lng.lbl_X_shipping_methods|substitute:"service":"FedEx"}</a></div>

<br />

{if $config.Shipping.FEDEX_account_number ne '' and $config.Shipping.FEDEX_meter_number ne ''}

<br />
<br />

{$lng.txt_fedex_options_note}

<br />
<br />

<form method="post" action="shipping_options.php">
<input type="hidden" name="carrier" value="FDX" />

<table cellpadding="3" cellspacing="1" width="100%">

<tr>
  <td width="30%"><b>{$lng.lbl_fedex_carrier_type}:</b></td>
  <td width="70%">
    <select name="carrier_codes[]" multiple="multiple">
      <option value="FDXE"{if $shipping_options.fdx.carrier_codes.FDXE} selected="selected"{/if}>FedEx Express (FDXE)</option>
      <option value="FDXG"{if $shipping_options.fdx.carrier_codes.FDXG} selected="selected"{/if}>FedEx Ground (FDXG)</option>
      <option value="FXSP"{if $shipping_options.fdx.carrier_codes.FXSP} selected="selected"{/if}>FedEx SmartPost (FXSP)</option>
    </select>
  </td>
</tr>

<tr>
  <td><b>{$lng.lbl_packaging}:</b></td>
  <td>
  <select name="packaging">
    <option value="FEDEX_ENVELOPE"{if $shipping_options.fdx.packaging eq "FEDEX_ENVELOPE"} selected="selected"{/if}>FedEx Envelope</option>
    <option value="FEDEX_PAK"{if $shipping_options.fdx.packaging eq "FEDEX_PAK"} selected="selected"{/if}>FedEx Pak</option>
    <option value="FEDEX_BOX"{if $shipping_options.fdx.packaging eq "FEDEX_BOX"} selected="selected"{/if}>FedEx Box</option>
    <option value="FEDEX_TUBE"{if $shipping_options.fdx.packaging eq "FEDEX_TUBE"} selected="selected"{/if}>FedEx Tube</option>
    <option value="FEDEX_10KG_BOX"{if $shipping_options.fdx.packaging eq "FEDEX_10KG_BOX"} selected="selected"{/if}>FedEx 10Kg Box</option>
    <option value="FEDEX_25KG_BOX"{if $shipping_options.fdx.packaging eq "FEDEX_25KG_BOX"} selected="selected"{/if}>FedEx 25Kg Box</option>
    <option value="YOUR_PACKAGING"{if $shipping_options.fdx.packaging eq "YOUR_PACKAGING"} selected="selected"{/if}>My packaging</option>
  </select>
  </td>
</tr>

<tr>
  <td><b>{$lng.lbl_fedex_dropoff_type}:</b></td>
  <td>
  <select name="dropoff_type">
    <option value="REGULAR_PICKUP"{if $shipping_options.fdx.dropoff_type eq "REGULAR_PICKUP"} selected="selected"{/if}>Regular pickup</option>
    <option value="REQUEST_COURIER"{if $shipping_options.fdx.dropoff_type eq "REQUEST_COURIER"} selected="selected"{/if}>Request courier</option>
    <option value="DROP_BOX"{if $shipping_options.fdx.dropoff_type eq "DROP_BOX"} selected="selected"{/if}>Drop box</option>
    <option value="BUSINESS_SERVICE_CENTER"{if $shipping_options.fdx.dropoff_type eq "BUSINESS_SERVICE_CENTER"} selected="selected"{/if}>Business Service Center</option>
    <option value="STATION"{if $shipping_options.fdx.dropoff_type eq "STATION"} selected="selected"{/if}>Station</option>
  </select>
  </td>
</tr>

<tr>
  <td><b>{$lng.lbl_fedex_ship_date}:</b></td>
  <td>
  <select name="ship_date">
    {section name=num loop=11 start=0}
    <option value="{$smarty.section.num.index}"{if $smarty.section.num.index eq $shipping_options.fdx.ship_date} selected="selected"{/if}>{$smarty.section.num.index}</option>
    {/section}
  </select>
  </td>
</tr>

<tr>
    <td><b>{$lng.lbl_fedex_currency}:</b></td>
    <td>
        <select name="currency_code">
          <option value="USD"{if $shipping_options.fdx.currency_code eq "USD"} selected="selected"{/if}>U.S. Dollars (USD)</option>
          <option value="CAD"{if $shipping_options.fdx.currency_code eq "CAD"} selected="selected"{/if}>Canadian Dollars (CAD)</option>
          <option value="EUR"{if $shipping_options.fdx.currency_code eq "EUR"} selected="selected"{/if}>European Currency Unit (EUR)</option>
          <option value="JYE"{if $shipping_options.fdx.currency_code eq "JYE"} selected="selected"{/if}>Japanese Yen (JYE)</option>
          <option value="UKL"{if $shipping_options.fdx.currency_code eq "UKL"} selected="selected"{/if}>British Pounds (UKL)</option>
          <option value="NOK"{if $shipping_options.fdx.currency_code eq "NOK"} selected="selected"{/if}>Norwegian Kronen (NOK)</option>
          <option value="AUD"{if $shipping_options.fdx.currency_code eq "AUD"} selected="selected"{/if}>Australian Dollars (AUD)</option>
          <option value="HKD"{if $shipping_options.fdx.currency_code eq "HKD"} selected="selected"{/if}>Hong Kong Dollars (HKD)</option>
          <option value="NTD"{if $shipping_options.fdx.currency_code eq "NTD"} selected="selected"{/if}>New Taiwan Dollars (NTD)</option>
          <option value="SID"{if $shipping_options.fdx.currency_code eq "SID"} selected="selected"{/if}>Singapore Dollars (SID)</option>
          <option value="ANG"{if $shipping_options.fdx.currency_code eq "ANG"} selected="selected"{/if}>Antilles Guilder (ANG)</option>
          <option value="RDD"{if $shipping_options.fdx.currency_code eq "RDD"} selected="selected"{/if}>Dominican Peso (RDD)</option>
          <option value="ARN"{if $shipping_options.fdx.currency_code eq "ARN"} selected="selected"{/if}>Argentina Peso (ARN)</option>
          <option value="ECD"{if $shipping_options.fdx.currency_code eq "ECD"} selected="selected"{/if}>E. Caribbean Dollars (ECD)</option>
          <option value="PKR"{if $shipping_options.fdx.currency_code eq "PKR"} selected="selected"{/if}>Pakistan Rupee (PKR)</option>
          <option value="AWG"{if $shipping_options.fdx.currency_code eq "AWG"} selected="selected"{/if}>Aruban Florins (AWG)</option>
          <option value="EGP"{if $shipping_options.fdx.currency_code eq "EGP"} selected="selected"{/if}>Egyptian Pound (EGP)</option>
          <option value="PHP"{if $shipping_options.fdx.currency_code eq "PHP"} selected="selected"{/if}>Philippine Pesos (PHP)</option>
          <option value="SAR"{if $shipping_options.fdx.currency_code eq "SAR"} selected="selected"{/if}>Saudi Arabian Riyals (SAR)</option>
          <option value="BHD"{if $shipping_options.fdx.currency_code eq "BHD"} selected="selected"{/if}>Bahraini Dinars (BHD)</option>
          <option value="BBD"{if $shipping_options.fdx.currency_code eq "BBD"} selected="selected"{/if}>Barbados Dollars (BBD)</option>
          <option value="INR"{if $shipping_options.fdx.currency_code eq "INR"} selected="selected"{/if}>Indian Rupees (INR)</option>
          <option value="WON"{if $shipping_options.fdx.currency_code eq "WON"} selected="selected"{/if}>South Korea Won (WON)</option>
          <option value="BMD"{if $shipping_options.fdx.currency_code eq "BMD"} selected="selected"{/if}>Bermuda Dollars (BMD)</option>
          <option value="JAD"{if $shipping_options.fdx.currency_code eq "JAD"} selected="selected"{/if}>Jamaican Dollars (JAD)</option>
          <option value="SEK"{if $shipping_options.fdx.currency_code eq "SEK"} selected="selected"{/if}>Swedish Krona (SEK)</option>
          <option value="BRL"{if $shipping_options.fdx.currency_code eq "BRL"} selected="selected"{/if}>Brazil Real (BRL)</option>
          <option value="SFR"{if $shipping_options.fdx.currency_code eq "SFR"} selected="selected"{/if}>Swiss Francs (SFR)</option>
          <option value="KUD"{if $shipping_options.fdx.currency_code eq "KUD"} selected="selected"{/if}>Kuwaiti Dinars (KUD)</option>
          <option value="THB"{if $shipping_options.fdx.currency_code eq "THB"} selected="selected"{/if}>Thailand Baht (THB)</option>
          <option value="BND"{if $shipping_options.fdx.currency_code eq "BND"} selected="selected"{/if}>Brunei Dollar (BND)</option>
          <option value="MOP"{if $shipping_options.fdx.currency_code eq "MOP"} selected="selected"{/if}>Macau Patacas (MOP)</option>
          <option value="TTD"{if $shipping_options.fdx.currency_code eq "TTD"} selected="selected"{/if}>Trinidad &amp; Tobago Dollars (TTD)</option>
          <option value="MYR"{if $shipping_options.fdx.currency_code eq "MYR"} selected="selected"{/if}>Malaysian Ringgits (MYR)</option>
          <option value="TRY"{if $shipping_options.fdx.currency_code eq "TRY"} selected="selected"{/if}>Turkish Lira (TRY)</option>
          <option value="CHP"{if $shipping_options.fdx.currency_code eq "CHP"} selected="selected"{/if}>Chilean Pesos (CHP)</option>
          <option value="UAE"{if $shipping_options.fdx.currency_code eq "UAE"} selected="selected"{/if}>Mexican Pesos	NMP (UAE)</option>
          <option value="DHS"{if $shipping_options.fdx.currency_code eq "DHS"} selected="selected"{/if}>Dirhams (DHS)</option>
          <option value="CNY"{if $shipping_options.fdx.currency_code eq "CNY"} selected="selected"{/if}>Chinese Renminbi (CNY)</option>
          <option value="DKK"{if $shipping_options.fdx.currency_code eq "DKK"} selected="selected"{/if}>Denmark Krone (DKK)</option>
          <option value="NZD"{if $shipping_options.fdx.currency_code eq "NZD"} selected="selected"{/if}>New Zealand Dollars (NZD)</option>
          <option value="VEF"{if $shipping_options.fdx.currency_code eq "VEF"} selected="selected"{/if}>Venezuela Bolivar (VEF)</option>
        </select>
    </td>
</tr>
{if $config.mod_fedex_version neq '9'}
<tr>
    <td><b>{$lng.lbl_fedex_purpose_type}:</b></td>
    <td>
        <select name="purpose_type">
          <option value=""{if $shipping_options.fdx.purpose_type eq ""} selected="selected"{/if}>&nbsp;</option>
          <option value="GIFT"{if $shipping_options.fdx.purpose_type eq "GIFT"} selected="selected"{/if}>GIFT</option>
          <option value="NOT_SOLD"{if $shipping_options.fdx.purpose_type eq "NOT_SOLD"} selected="selected"{/if}>NOT SOLD</option>
          <option value="PERSONAL_EFFECTS"{if $shipping_options.fdx.purpose_type eq "PERSONAL_EFFECTS"} selected="selected"{/if}>PERSONAL EFFECTS</option>
          <option value="REPAIR_AND_RETURN"{if $shipping_options.fdx.purpose_type eq "REPAIR_AND_RETURN"} selected="selected"{/if}>REPAIR AND RETURN</option>
          <option value="SAMPLE"{if $shipping_options.fdx.purpose_type eq "SAMPLE"} selected="selected"{/if}>SAMPLE</option>
          <option value="SOLD"{if $shipping_options.fdx.purpose_type eq "SOLD"} selected="selected"{/if}>SOLD</option>
        </select>
        {include file="main/tooltip_js.tpl" text=$lng.txt_fedex_purpose_type_note type="img" id="purpose_type_id" sticky=true}
    </td>
</tr>
<tr>
    <td><b>{$lng.lbl_fedex_rate_type}:</b></td>
    <td>
        <select name="rate_request_types">
          <option value="ACCOUNT"{if $shipping_options.fdx.rate_request_types eq "ACCOUNT"} selected="selected"{/if}>ACCOUNT</option>
          <option value="LIST"{if $shipping_options.fdx.rate_request_types eq "LIST"} selected="selected"{/if}>LIST</option>
        </select>
        {include file="main/tooltip_js.tpl" text=$lng.txt_fedex_rate_request_types_note type="img" id="rate_request_type_id" sticky=true}
    </td>
</tr>
{/if}
<tr>
    <td colspan="2"><br />{include file="main/subheader.tpl" title=$lng.lbl_package_limits class="grey"}</td>
</tr>

<tr>
    <td colspan="2">{$lng.txt_shipper_limits_note|substitute:"shipper":"FedEx"}</td>
</tr>

<tr>
  <td>
    <b>{$lng.lbl_maximum_package_weight} ({$config.General.weight_symbol}):</b>
  </td>
  <td nowrap="nowrap">
    <input type="text" name="max_weight" value="{$shipping_options.fdx.max_weight|doubleval}" size="7" />
  </td>
</tr>

<tr>
  <td><b>{$lng.lbl_maximum_package_dimensions} ({$config.General.dimensions_symbol}):</b></td>
  <td nowrap="nowrap">
    <table cellpadding="0" cellspacing="1" border="0">
    <tr>
      <td>{$lng.lbl_length}</td>
      <td></td>
      <td>{$lng.lbl_width}</td>
      <td></td>
      <td>{$lng.lbl_height}</td>
    </tr>
    <tr>
      <td><input type="text" name="dim_length" value="{$shipping_options.fdx.dim_length}" size="6" /></td>
      <td>&nbsp;x&nbsp;</td>
      <td><input type="text" name="dim_width" value="{$shipping_options.fdx.dim_width}" size="6" /></td>
      <td>&nbsp;x&nbsp;</td>
      <td><input type="text" name="dim_height" value="{$shipping_options.fdx.dim_height}" size="6" /></td>
    </tr>
    </table>
  </td>
</tr>

<tr>
  <td><label for="param01"><b>{$lng.lbl_fedex_pkg_no_use}:</b></label></td>
  <td><input type="checkbox" name="param01" id="param01" value="Y"{if $shipping_options.fdx.param01 eq "Y" or !$shipping_options.fdx} checked="checked"{/if} /></td>
</tr>

<tr>
  <td><label for="param02"><b>{$lng.lbl_use_maximum_dimensions}:</b></label></td>
  <td><input type="checkbox" name="param02" id="param02" value="Y"{if $shipping_options.fdx.param02 eq "Y"} checked="checked"{/if} /></td>
</tr>

<tr>
    <td colspan="2"><br />{include file="main/subheader.tpl" title=$lng.lbl_fedex_cod class="grey"}</td>
</tr>

<tr>
    <td><b>{$lng.lbl_fedex_cod_value} ({$shipping_options.fdx.currency_code|default:"USD"}):</b></td>
    <td>
        <input type="text" name="cod_value" value="{$shipping_options.fdx.cod_value|default:"0.00"}" />
    </td>
</tr>

<tr>
    <td><b>{$lng.lbl_fedex_cod_type}:</b></td>
    <td>
        <select name="cod_type">
      <option value="ANY"{if $shipping_options.fdx.cod_type eq "ANY"} selected="selected"{/if}>{$lng.lbl_fedex_any}</option>
      <option value="GUARANTEED_FUNDS"{if $shipping_options.fdx.cod_type eq "GUARANTEED_FUNDS"} selected="selected"{/if}>{$lng.lbl_fedex_guaranteed_funds}</option>
      <option value="CASH"{if $shipping_options.fdx.cod_type eq "CASH"} selected="selected"{/if}>{$lng.lbl_fedex_cash}</option>
        </select>
    </td>
</tr>

<tr>
    <td colspan="2"><br />{include file="main/subheader.tpl" title=$lng.lbl_fedex_special_services class="grey"}</td>
</tr>

<tr>
  <td><b>{$lng.lbl_fedex_dangerous_goods}:</b></td>
  <td>
  <select name="dg_accessibility">
    <option value=""{if $shipping_options.fdx.dg_accessibility eq ""} selected="selected"{/if}>&nbsp;</option>
    <option value="ACCESSIBLE"{if $shipping_options.fdx.dg_accessibility eq "ACCESSIBLE"} selected="selected"{/if}>{$lng.lbl_fedex_accessible}</option>
    <option value="INACCESSIBLE"{if $shipping_options.fdx.dg_accessibility eq "INACCESSIBLE"} selected="selected"{/if}>{$lng.lbl_fedex_inaccessible}</option>
  </select>
  </td>
</tr>

<tr>
  <td><b>{$lng.lbl_fedex_signature_option}:</b></td>
  <td>
  <select name="signature">
    <option value=""{if $shipping_options.fdx.signature eq ""} selected="selected"{/if}>&nbsp;</option>
    <option value="NO_SIGNATURE_REQUIRED"{if $shipping_options.fdx.signature eq "NO_SIGNATURE_REQUIRED"} selected="selected"{/if}>{$lng.lbl_fedex_no_signature}</option>
    <option value="INDIRECT"{if $shipping_options.fdx.signature eq "INDIRECT"} selected="selected"{/if}>{$lng.lbl_fedex_signature_indirect}</option>
    <option value="DIRECT"{if $shipping_options.fdx.signature eq "DIRECT"} selected="selected"{/if}>{$lng.lbl_fedex_signature_direct}</option>
    <option value="ADULT"{if $shipping_options.fdx.signature eq "ADULT"} selected="selected"{/if}>{$lng.lbl_fedex_signature_adult}</option>
  </select>
  </td>
</tr>

<tr>
  <td colspan="2">

  <table cellpadding="3" cellspacing="1">

  <tr>
    <td width="10"><input type="checkbox" name="dry_ice" id="dry_ice" value="Y"{if $shipping_options.fdx.dry_ice eq "Y"} checked="checked"{/if} /></td>
    <td width="50%"><b><label for="dry_ice">{$lng.lbl_fedex_dry_ice}</label></b></td>
    <td width="20">&nbsp;</td>
    <td width="10"><input type="checkbox" name="hold_at_location" id="hold_at_location" value="Y"{if $shipping_options.fdx.hold_at_location eq "Y"} checked="checked"{/if} /></td>
    <td width="50%"><b><label for="hold_at_location">{$lng.lbl_fedex_hold_at_location}</label></b></td>
  </tr>

  <tr>
    <td><input type="checkbox" name="inside_pickup" id="inside_pickup" value="Y"{if $shipping_options.fdx.inside_pickup eq "Y"} checked="checked"{/if} /></td>
    <td><b><label for="inside_pickup">{$lng.lbl_fedex_inside_pickup}</label></b></td>
    <td>&nbsp;</td>
    <td><input type="checkbox" name="inside_delivery" id="inside_delivery" value="Y"{if $shipping_options.fdx.inside_delivery eq "Y"} checked="checked"{/if} /></td>
    <td><b><label for="inside_delivery">{$lng.lbl_fedex_inside_delivery}</label></b></td>
  </tr>

  <tr>
    <td><input type="checkbox" name="saturday_pickup" id="saturday_pickup" value="Y"{if $shipping_options.fdx.saturday_pickup eq "Y"} checked="checked"{/if} /></td>
    <td><b><label for="saturday_pickup">{$lng.lbl_fedex_saturday_pickup}</label></b></td>
    <td>&nbsp;</td>
    <td><input type="checkbox" name="saturday_delivery" id="saturday_delivery" value="Y"{if $shipping_options.fdx.saturday_delivery eq "Y"} checked="checked"{/if} /></td>
    <td><b><label for="saturday_delivery">{$lng.lbl_fedex_saturday_delivery}</label></b></td>
  </tr>

  <tr>
    <td valign="top"><input type="checkbox" name="residential_delivery" id="residential_delivery" value="Y"{if $shipping_options.fdx.residential_delivery eq "Y"} checked="checked"{/if} /></td>
    <td><b><label for="residential_delivery">{$lng.lbl_fedex_residential_delivery}</label></b>
    </td>
    <td>&nbsp;</td>
    <td valign="top"><input type="checkbox" name="nonstandard_container" id="nonstandard_container" value="Y"{if $shipping_options.fdx.nonstandard_container eq "Y"} checked="checked"{/if} /></td>
    <td valign="top"><b><label for="nonstandard_container">{$lng.lbl_fedex_nonstandard_container}</label></b></td>
  </tr>

  </table>

  </td>
</tr>

<tr>
    <td colspan="2"><br />{include file="main/subheader.tpl" title=$lng.lbl_additional_charges class="grey"}</td>
</tr>

<tr>
  <td><label for="send_insured_value"><b>{$lng.lbl_fedex_send_insured_value}:</b></label></td>
  <td><input type="checkbox" name="send_insured_value" id="send_insured_value" value="Y"{if $shipping_options.fdx.send_insured_value eq "Y" or !$shipping_options.fdx} checked="checked"{/if} />
</td>
</tr>

<tr>
  <td><b>{$lng.lbl_fedex_handling_amount}:</b></td>
  <td>
  <input type="text" size="10" maxlength="10" name="handling_charges_amount" value="{$shipping_options.fdx.handling_charges_amount|default:"0.00"}" />
  {assign var="fdx_currency_code" value=$shipping_options.fdx.currency_code|default:"USD"}
  <select name="handling_charges_type">
    <option value="FIXED_AMOUNT"{if $shipping_options.fdx.handling_charges_type eq "FIXED_AMOUNT"} selected="selected"{/if}>{$fdx_currency_code}</option>
    <option value="PERCENTAGE_OF_NET_FREIGHT"{if $shipping_options.fdx.handling_charges_type eq "PERCENTAGE_OF_NET_FREIGHT"} selected="selected"{/if}>% of base</option>
    <option value="PERCENTAGE_OF_NET_CHARGE"{if $shipping_options.fdx.handling_charges_type eq "PERCENTAGE_OF_NET_CHARGE"} selected="selected"{/if}>% of net</option>
    <option value="PERCENTAGE_OF_NET_CHARGE_EXCLUDING_TAXES"{if $shipping_options.fdx.handling_charges_type eq "PERCENTAGE_OF_NET_CHARGE_EXCLUDING_TAXES"} selected="selected"{/if}>% of net (excluding taxes)</option>
  </select>

  {include file="main/tooltip_js.tpl" text=$lng.txt_fedex_help_charges_type|substitute:"currency_code":$fdx_currency_code type="img"}
  </td>
</tr>

<tr>
    <td colspan="2"><br />{include file="main/subheader.tpl" title=$lng.lbl_fedex_smartpost_settings class="grey"}</td>
</tr>

<tr>
  <td><label for="add_smartpost_detail"><b>{$lng.lbl_fedex_add_smartpost_detail}:</b></label></td>
  <td><input type="checkbox" name="add_smartpost_detail" id="add_smartpost_detail" value="Y"{if $shipping_options.fdx.add_smartpost_detail eq "Y"} checked="checked"{/if} onclick="javascript:  $('.smartpost_block').css('display', (this.checked ? '': 'none')); "/>
  {include file="main/tooltip_js.tpl" text=$lng.txt_fedex_smartpost_help type="img" id="smart_posthelp" sticky=true}
</td>
</tr>

<tr {if $shipping_options.fdx.add_smartpost_detail ne "Y"}style="display: none;"{/if} class="smartpost_block">
  <td><b>{$lng.lbl_fedex_indicia}:</b></td>
  <td>
  <select name="smartpost_indicia">
    <option value="MEDIA_MAIL"{if $shipping_options.fdx.smartpost_indicia eq "MEDIA_MAIL"} selected="selected"{/if}>MEDIA_MAIL</option>
    <option value="PARCEL_RETURN"{if $shipping_options.fdx.smartpost_indicia eq "PARCEL_RETURN"} selected="selected"{/if}>PARCEL_RETURN</option>
    <option value="PARCEL_SELECT"{if $shipping_options.fdx.smartpost_indicia eq "PARCEL_SELECT"} selected="selected"{/if}>PARCEL_SELECT</option>
    <option value="PRESORTED_BOUND_PRINTED_MATTER"{if $shipping_options.fdx.smartpost_indicia eq "PRESORTED_BOUND_PRINTED_MATTER"} selected="selected"{/if}>PRESORTED_BOUND_PRINTED_MATTER</option>
    <option value="PRESORTED_STANDARD"{if $shipping_options.fdx.smartpost_indicia eq "PRESORTED_STANDARD"} selected="selected"{/if}>PRESORTED_STANDARD</option>
  </select>
  </td>
</tr>

<tr {if $shipping_options.fdx.add_smartpost_detail ne "Y"}style="display: none;"{/if} class="smartpost_block">
  <td><b>{$lng.lbl_fedex_ancillaryendorsement}:</b></td>
  <td>
  <select name="smartpost_ancillaryendorsement">
    <option value=""{if $shipping_options.fdx.smartpost_ancillaryendorsement eq ""} selected="selected"{/if}>&nbsp;</option>
    <option value="ADDRESS_CORRECTION"{if $shipping_options.fdx.smartpost_ancillaryendorsement eq "ADDRESS_CORRECTION"} selected="selected"{/if}>ADDRESS_CORRECTION</option>
    <option value="CARRIER_LEAVE_IF_NO_RESPONSE"{if $shipping_options.fdx.smartpost_ancillaryendorsement eq "CARRIER_LEAVE_IF_NO_RESPONSE"} selected="selected"{/if}>CARRIER_LEAVE_IF_NO_RESPONSE</option>
    <option value="CHANGE_SERVICE"{if $shipping_options.fdx.smartpost_ancillaryendorsement eq "CHANGE_SERVICE"} selected="selected"{/if}>CHANGE_SERVICE</option>
    <option value="FORWARDING_SERVICE"{if $shipping_options.fdx.smartpost_ancillaryendorsement eq "FORWARDING_SERVICE"} selected="selected"{/if}>FORWARDING_SERVICE</option>
    <option value="RETURN_SERVICE"{if $shipping_options.fdx.smartpost_ancillaryendorsement eq "RETURN_SERVICE"} selected="selected"{/if}>RETURN_SERVICE</option>
  </select>
  </td>
</tr>

<tr {if $shipping_options.fdx.add_smartpost_detail ne "Y"}style="display: none;"{/if} class="smartpost_block">
  <td><b>{$lng.lbl_fedex_hubid}:</b></td>
  <td>
  <select name="smartpost_hubid">
    <option value="5303"{if $shipping_options.fdx.smartpost_hubid eq "5303"} selected="selected"{/if}>Atlanta ATGA (5303)</option>
    <option value="5281"{if $shipping_options.fdx.smartpost_hubid eq "5281"} selected="selected"{/if}>Charlotte CHNC (5281)</option>
    <option value="5602"{if $shipping_options.fdx.smartpost_hubid eq "5602"} selected="selected"{/if}>Chicago CIIL (5602)</option>
    <option value="5929"{if $shipping_options.fdx.smartpost_hubid eq "5929"} selected="selected"{/if}>Chino COCA (5929)</option>
    <option value="5751"{if $shipping_options.fdx.smartpost_hubid eq "5751"} selected="selected"{/if}>Dallas DLTX (5751)</option>
    <option value="5802"{if $shipping_options.fdx.smartpost_hubid eq "5802"} selected="selected"{/if}>Denver DNCO (5802)</option>
    <option value="5481"{if $shipping_options.fdx.smartpost_hubid eq "5481"} selected="selected"{/if}>Detroit DTMI (5481)</option>
    <option value="5087"{if $shipping_options.fdx.smartpost_hubid eq "5087"} selected="selected"{/if}>Edison EDNJ (5087)</option>
    <option value="5431"{if $shipping_options.fdx.smartpost_hubid eq "5431"} selected="selected"{/if}>Grove City GCOH (5431)</option>
    <option value="5771"{if $shipping_options.fdx.smartpost_hubid eq "5771"} selected="selected"{/if}>Houston HOTX (5771)</option>
    <option value="5465"{if $shipping_options.fdx.smartpost_hubid eq "5465"} selected="selected"{/if}>Indianapolis ININ (5465)</option>
    <option value="5648"{if $shipping_options.fdx.smartpost_hubid eq "5648"} selected="selected"{/if}>Kansas City KCKS (5648)</option>
    <option value="5902"{if $shipping_options.fdx.smartpost_hubid eq "5902"} selected="selected"{/if}>Los Angeles LACA (5902)</option>
    <option value="5254"{if $shipping_options.fdx.smartpost_hubid eq "5254"} selected="selected"{/if}>Martinsburg MAWV (5254)</option>
    <option value="5379"{if $shipping_options.fdx.smartpost_hubid eq "5379"} selected="selected"{/if}>Memphis METN (5379)</option>
    <option value="5552"{if $shipping_options.fdx.smartpost_hubid eq "5552"} selected="selected"{/if}>Minneapolis MPMN (5552)</option>
    <option value="5531"{if $shipping_options.fdx.smartpost_hubid eq "5531"} selected="selected"{/if}>New Berlin NBWI (5531)</option>
    <option value="5110"{if $shipping_options.fdx.smartpost_hubid eq "5110"} selected="selected"{/if}>Newburgh NENY (5110)</option>
    <option value="5015"{if $shipping_options.fdx.smartpost_hubid eq "5015"} selected="selected"{/if}>Northborough NOMA (5015)</option>
    <option value="5327"{if $shipping_options.fdx.smartpost_hubid eq "5327"} selected="selected"{/if}>Orlando ORFL (5327)</option>
    <option value="5194"{if $shipping_options.fdx.smartpost_hubid eq "5194"} selected="selected"{/if}>Philadelphia PHPA (5194)</option>
    <option value="5854"{if $shipping_options.fdx.smartpost_hubid eq "5854"} selected="selected"{/if}>Phoenix PHAZ (5854)</option>
    <option value="5150"{if $shipping_options.fdx.smartpost_hubid eq "5150"} selected="selected"{/if}>Pittsburgh PTPA (5150)</option>
    <option value="5958"{if $shipping_options.fdx.smartpost_hubid eq "5958"} selected="selected"{/if}>Sacramento SACA (5958)</option>
    <option value="5843"{if $shipping_options.fdx.smartpost_hubid eq "5843"} selected="selected"{/if}>Salt Lake City SCUT (5843)</option>
    <option value="5983"{if $shipping_options.fdx.smartpost_hubid eq "5983"} selected="selected"{/if}>Seattle SEWA (5983)</option>
    <option value="5631"{if $shipping_options.fdx.smartpost_hubid eq "5631"} selected="selected"{/if}>St. Louis STMO (5631)</option>
  </select>
  {include file="main/tooltip_js.tpl" text=$lng.txt_fedex_smartpost_hubid_help type="img" id="smartpost_hubid_" sticky=true}
  </td>
</tr>

</table>

<br />
<br />

<input type="submit" value="{$lng.lbl_apply|escape}" name="update_options" />

</form>

{else}

{$lng.txt_fedex_disabled_note}

<br />
<br />

{/if}

{/capture}
{assign var="section_title" value=$lng.lbl_X_shipping_options|substitute:"service":"FedEx"}
{include file="dialog.tpl" content=$smarty.capture.dialog title=$section_title extra='width="100%"'}

{/if}
