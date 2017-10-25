{*
ccae421283d4f9a7997cecefe67b3241aa76546a, v3 (xcart_4_7_4), 2015-07-21 00:26:16, order_invoice.tpl, random

vim: set ts=2 sw=2 sts=2 et:
*}
{if $customer ne ''}
  {assign var="_userinfo" value=$customer}{else}{assign var="_userinfo" value=$userinfo}
{/if}

{config_load file="$skin_config"}

<div class="order-invoice width-100">

      <div class="width-100 responsive">

          <div class="invoice-company-icon">
            <img src="{$AltImagesDir}/custom/small_logo.gif" alt="" />
          </div>

          <div class="invoice-data-box">

            <table cellspacing="0"{if $is_nomail ne 'Y'} cellpadding="2" width="100%"{/if} summary="{$lng.lbl_details|escape}">
              <tr>
                <td{if $is_nomail ne 'Y'} valign="top"{/if} id="html_order_info">
                  <strong {if $is_nomail eq 'Y'}class="invoice-title"{else} style="font-size: 28px; text-transform: uppercase;"{/if}>
                    {if $order.status eq 'A' or $order.status eq 'P' or $order.status eq 'C'}{$lng.lbl_receipt}{else}{$lng.lbl_invoice}{/if}
                  </strong>
                  <br />
                  <br />
                  <strong>{$lng.lbl_date}:</strong> {$order.date|date_format:$config.Appearance.datetime_format}<br />
                  <strong>{$lng.lbl_order_id}:</strong> #{$order.orderid}<br />
                  <strong>{$lng.lbl_order_status}:</strong> {include file="main/order_status.tpl" status=$order.status mode="static"}<br />
                  <strong>{$lng.lbl_payment_method}:</strong><br />
                  {$order.payment_method}<br />
                  {if $active_modules.XPayments_Connector}
                    {include file="modules/XPayments_Connector/order_invoice.tpl"}
                  {/if}
                  {if $order.extra.wp_auth_code}
                    {$lng.lbl_xpc_wp_auth_code}: {$order.extra.wp_auth_code}<br/>
                    {$lng.lbl_xpc_wp_status}: {$order.extra.wp_status}<br/>
                  {/if}
                  {if not $active_modules.POS_System or not $pos_hide_shipping_info}
                    <strong>{$lng.lbl_delivery}:</strong><br />
                    {$order.shipping|trademark:'use_alt'|default:$lng.txt_not_available}
                  {/if}
                  {if $order.tracking}
                  <br /><strong>{$lng.lbl_tracking_number}:</strong> {$order.tracking|escape}
                  {/if}
                </td>
                <td {if $is_nomail eq 'Y'}class="invoice-right-info"{else}valign="bottom" align="right"{/if}>
                  <strong>{$config.Company.company_name}</strong><br />
                  {$config.Company.location_address}, {$config.Company.location_city}<br />
                  {$config.Company.location_zipcode}{if $config.Company.location_country_has_states}, {$config.Company.location_state_name}{/if}<br />
                  {$config.Company.location_country_name}<br />
                  {if $config.Company.company_phone}
                    {$lng.lbl_phone_1_title}: {$config.Company.company_phone}<br />
                  {/if}
                  {if $config.Company.company_phone_2}
                    {$lng.lbl_phone_2_title}: {$config.Company.company_phone_2}<br />
                  {/if}
                  {if $config.Company.company_fax}
                    {$lng.lbl_fax}: {$config.Company.company_fax}<br />
                  {/if}
                  {if $config.Company.orders_department}
                    {$lng.lbl_email}: {$config.Company.orders_department}<br />
                  {/if}
                  {if $order.applied_taxes}
                    <br />
                    {foreach from=$order.applied_taxes key=tax_name item=tax}
                      {$tax.regnumber}<br />
                    {/foreach}
                  {/if}
                </td>
              </tr>
            </table>
          </div>
      </div>

      <hr {if $is_nomail eq 'Y'}class="invoice-line"{else} style="border: 0px none; border-bottom: 2px solid #58595b; margin: 2px 0px 17px 0px; padding: 0px; height: 0px;"{/if}/>

      <table cellspacing="0"{if $is_nomail eq 'Y'} class="invoice-personal-info"{else} cellpadding="0" style="width:45%; border: 0px none; margin-bottom: 15px;"{/if} summary="{$lng.lbl_address|escape}">
        
        <tr>
          <td><strong>{$lng.lbl_email}:</strong></td>
          <td>{$order.email}</td>
        </tr>

        {if $_userinfo.default_fields.title}
          <tr>
            <td><strong>{$lng.lbl_title}:</strong></td>
            <td>{$order.title}</td>
          </tr>
        {/if}

        {if $_userinfo.default_fields.firstname}
          <tr>
            <td{if $is_nomail ne 'Y'} nowrap="nowrap"{/if}><strong>{$lng.lbl_first_name}:</strong></td>
            <td>{$order.firstname}</td>
          </tr>
        {/if}

        {if $_userinfo.default_fields.lastname}
          <tr>
            <td{if $is_nomail eq 'Y'} nowrap="nowrap"{/if}><strong>{$lng.lbl_last_name}:</strong></td>
            <td>{$order.lastname}</td>
          </tr>
        {/if}

        {if $_userinfo.default_fields.company}
          <tr>
            <td><strong>{$lng.lbl_company}:</strong></td>
            <td>{$order.company}</td>
          </tr>
        {/if}

        {if $_userinfo.default_fields.tax_number}
          <tr>
            <td><strong>{$lng.lbl_tax_number}:</strong></td>
            <td>{$order.tax_number}</td>
          </tr>
        {/if}

        {if $_userinfo.default_fields.url}
          <tr>
            <td><strong>{$lng.lbl_url}:</strong></td>
            <td>{$order.url}</td>
          </tr>
        {/if}

        {foreach from=$_userinfo.additional_fields item=v}
          {if $v.section eq 'P' and $v.value ne ''}
            <tr>
              <td><strong>{$v.title}:</strong></td>
              <td>{$v.value}</td>
            </tr>
          {/if}
        {/foreach}
        <tr style="display: none;"><td colspan="2">&nbsp;</td></tr>
      </table>

    	<table cellspacing="0" {if $is_nomail eq 'Y'}class="invoice-address-box"{else}cellpadding="0" style="width: 100%; border: 0px none; margin-bottom: 30px;"{/if} summary="{$lng.lbl_addresses|escape}">
        {if not $active_modules.POS_System or not $pos_hide_shipping_info}
      	<tr>
      		<td {if $is_nomail eq 'Y'}class="invoice-address-title"{else}style="width:45%; height: 25px;"{/if}><strong>{$lng.lbl_billing_address}</strong></td>
          <td width="10%" class="invoice-address-delim">&nbsp;</td>
          <td {if $is_nomail eq 'Y'}class="invoice-address-title"{else}style="width: 45%; height: 25px;"{/if}><strong>{$lng.lbl_shipping_address}</strong></td>
      	</tr>
      	<tr>
      		<td {if $is_nomail eq 'Y'}class="invoice-line"{else}height="4"{/if}><img src="{$ImagesDir}/spacer.gif" {if $is_nomail ne 'Y'}style="height: 2px; width: 100%; background: #58595b none;max-height: 2px;"{/if} alt="" /></td>
          <td class="invoice-address-delim"><img height="2" src="{$ImagesDir}/spacer.gif" width="1" alt="" /></td>
          <td {if $is_nomail eq 'Y'}class="invoice-line"{else}height="4"{/if}><img src="{$ImagesDir}/spacer.gif" {if $is_nomail ne 'Y'}style="height: 2px; width: 100%; background: #58595b none;max-height: 2px;"{/if} alt="" /></td>
        </tr>
        {else}{* POS_System *}
      	<tr>
      		<td {if $is_nomail eq 'Y'}class="invoice-address-title"{else}style="width:45%; height: 25px;"{/if}>&nbsp;</td>
          <td width="10%" class="invoice-address-delim">&nbsp;</td>
          <td {if $is_nomail eq 'Y'}class="invoice-address-title"{else}style="width: 45%; height: 25px;"{/if}>&nbsp;</td>
      	</tr>
        {/if}
        <tr>
          <td>

            <table cellspacing="0"{if $is_nomail ne 'Y'} cellpadding="0" style="width: 100%; border: none;"{/if} summary="{$lng.lbl_billing_address|escape}">

              {if $_userinfo.default_address_fields.title}
                <tr>
                  <td><strong>{$lng.lbl_title}:</strong></td>
                  <td>{$order.b_title|escape}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.firstname}
                <tr>
                  <td><strong>{$lng.lbl_first_name}:</strong> </td>
                  <td>{$order.b_firstname|escape}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.lastname}
                <tr>
                  <td><strong>{$lng.lbl_last_name}:</strong> </td>
                  <td>{$order.b_lastname|escape}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.address}
                <tr>
                  <td><strong>{$lng.lbl_address}:</strong> </td>
                  <td>{$order.b_address|escape}<br />{$order.b_address_2|escape}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.city}
                <tr>
                  <td><strong>{$lng.lbl_city}:</strong> </td>
                  <td>{$order.b_city|escape}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.county and $config.General.use_counties eq 'Y'}
                <tr>
                  <td><strong>{$lng.lbl_county}:</strong> </td>
                  <td>{$order.b_countyname|escape}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.state}
                <tr>
                  <td><strong>{$lng.lbl_state}:</strong> </td>
                  <td>{$order.b_statename|escape}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.country}
                <tr>
                  <td><strong>{$lng.lbl_country}:</strong> </td>
                  <td>{$order.b_countryname|escape}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.zipcode}
                <tr>
                  <td><strong>{$lng.lbl_zip_code}:</strong> </td>
                  <td>{include file="main/zipcode.tpl" val=$order.b_zipcode zip4=$order.b_zip4 static=true}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.phone}
                <tr>
                  <td><strong>{$lng.lbl_phone}:</strong> </td>
                  <td>{$order.b_phone|escape}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.fax}
                <tr>
                  <td><strong>{$lng.lbl_fax}:</strong> </td>
                  <td>{$order.b_fax|escape}</td>
                </tr>
              {/if}

              {foreach from=$_userinfo.additional_fields item=v}
                {if $v.section eq 'B' and $v.value.B ne ''}
                  <tr>
                    <td><strong>{$v.title}:</strong></td>
                    <td>{$v.value.B}</td>
                  </tr>
                {/if}
              {/foreach}

            </table>

          </td>
           <td class="invoice-address-delim">&nbsp;</td>
           {if not $active_modules.POS_System or not $pos_hide_shipping_info}
           <td>

            <table cellspacing="0"{if $is_nomail ne 'Y'} cellpadding="0" width="100%" border="0"{/if} summary="{$lng.lbl_shipping_address|escape}">

              {if $_userinfo.default_address_fields.title}
                <tr>
                  <td><strong>{$lng.lbl_title}:</strong></td>
                  <td>{$order.s_title|escape}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.firstname}
                <tr>
                  <td><strong>{$lng.lbl_first_name}:</strong> </td>
                  <td>{$order.s_firstname|escape}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.lastname}
                <tr>
                  <td><strong>{$lng.lbl_last_name}:</strong> </td>
                  <td>{$order.s_lastname|escape}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.address}
                <tr>
                  <td><strong>{$lng.lbl_address}:</strong> </td>
                  <td>{$order.s_address|escape}<br />{$order.s_address_2|escape}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.city}
                <tr>
                  <td><strong>{$lng.lbl_city}:</strong> </td>
                  <td>{$order.s_city|escape}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.county and $config.General.use_counties eq 'Y'}
                <tr>
                  <td><strong>{$lng.lbl_county}:</strong> </td>
                  <td>{$order.s_countyname|escape}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.state}
                <tr>
                  <td><strong>{$lng.lbl_state}:</strong> </td>
                  <td>{$order.s_statename|escape}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.country}
                <tr>
                  <td><strong>{$lng.lbl_country}:</strong> </td>
                  <td>{$order.s_countryname|escape}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.zipcode}
                <tr>
                  <td><strong>{$lng.lbl_zip_code}:</strong> </td>
                  <td>{include file="main/zipcode.tpl" val=$order.s_zipcode zip4=$order.s_zip4 static=true}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.phone}
                <tr>
                  <td><strong>{$lng.lbl_phone}:</strong> </td>
                  <td>{$order.s_phone|escape}</td>
                </tr>
              {/if}

              {if $_userinfo.default_address_fields.fax}
                <tr>
                  <td><strong>{$lng.lbl_fax}:</strong> </td>
                  <td>{$order.s_fax|escape}</td>
                </tr>
              {/if}

              {foreach from=$_userinfo.additional_fields item=v}
                {if $v.section eq 'B' and $v.value.S ne ''}
                  <tr>
                    <td><strong>{$v.title}:</strong></td>
                    <td>{$v.value.S}</td>
                  </tr>
                 {/if}
              {/foreach}

            </table>
          </td>
          {else}{* POS_System *}
            <td>&nbsp;</td>
          {/if}
        </tr>

        {assign var="is_header" value=""}
        {foreach from=$_userinfo.additional_fields item=v}
          {if $v.section eq 'A' and $v.value ne ''}
            {if $is_header eq ''}
              <tr>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td {if $is_nomail eq 'Y'}class="invoice-address-title"{else} style="width: 45%; height: 25px;"{/if}><strong>{$lng.lbl_additional_information}</strong></td>
              	<td colspan="2" width="55%">&nbsp;</td>
              </tr>
              <tr>
                <td {if $is_nomail eq 'Y'}class="invoice-line"{else}height="4"{/if}><img src="{$ImagesDir}/spacer.gif" {if $is_nomail ne 'Y'}style="height: 2px; width: 100%; background: #58595b none;max-height: 2px;"{/if} alt="" /></td>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td>

                  <table cellspacing="0"{if $is_nomail ne 'Y'} cellpadding="0" width="100%" border="0"{/if} summary="{$lng.lbl_additional_information|escape}">
                    {assign var="is_header" value="E"}
            {/if}

            <tr>
              <td><strong>{$v.title}</strong></td>
               <td>{$v.value}</td>
            </tr>
          {/if}
        {/foreach}

        {if $is_header eq 'E'}
              </table>
            </td>
            <td colspan="2">&nbsp;</td>
          </tr>
        {/if}

        {if $order.PO_Number}
          <table class="block-grid two-up address-table-container">
            <tr>
              <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td><strong>{$lng.lbl_po_number}</strong>: {$order.PO_Number}</td>
              <td colspan="2" width="55%">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3">&nbsp;</td>
            </tr>
          </table>
        {/if}

        {if $config.Email.show_cc_info eq "Y" 
          and $show_order_details eq "Y" 
          and ($order.details ne "" or $order.extra.advinfo ne "")
        }

          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>

          <tr>
            <td {if $is_nomail eq 'Y'}class="invoice-address-title"{else} style="width: 45%; height: 25px;"{/if}><strong>{$lng.lbl_order_payment_details}</strong></td>
            <td colspan="2" width="55%">&nbsp;</td>
          </tr>
  
          <tr>
            <td {if $is_nomail eq 'Y'}class="invoice-line"{else}height="4"{/if}><img src="{$ImagesDir}/spacer.gif" {if $is_nomail ne 'Y'}style="height: 2px; width: 100%; background: #58595b none;max-height: 2px;"{/if} alt="" /></td>
            <td colspan="2">&nbsp;</td>
          </tr>

          {if $order.details ne ""}
            <tr>
              <td colspan="3">{$order.details|order_details_translate|escape|replace:"\n":"<br />"}</td>
            </tr>
          {/if}
          
          {if $order.extra.advinfo ne ""}
            <tr>
              <td colspan="3">{$order.extra.advinfo|escape|replace:"\n":"<br />"}</td>
            </tr>  
          {/if}
        {/if}

        {if $order.netbanx_reference}
          <tr>
            <td colspan="3">NetBanx Reference: {$order.netbanx_reference}</td>
          </tr>
        {/if}

      </table>

      {include file="mail/html/order_data.tpl"}

  
  {if $order.need_giftwrap eq "Y"}
    <table class="width-100">
      {include file="modules/Gift_Registry/gift_wrapping_invoice.tpl" show=message}
    </table>
  {/if}

  {if $order.customer_notes ne ""}

      <div class="invoice-customer-notes">
        <p{if $is_nomail ne 'Y'} style="font-size: 14px; font-weight: bold; text-align: center;"{/if}>{$lng.lbl_customer_notes}</p>
        <div{if $is_nomail ne 'Y'} style="border: 1px solid #cecfce; padding: 5px;"{/if}>{$order.customer_notes|nl2br}</div>
      </div>

  {/if}


  <div class="invoice-bottom-note">
    {$lng.txt_thank_you_for_purchase}
  </div>
    
</div>
