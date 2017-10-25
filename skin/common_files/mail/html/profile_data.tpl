{*
aff759aa082b708fb9d5791aff835139b48d89cd, v5 (xcart_4_7_5), 2016-01-05 19:33:50, profile_data.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<hr noshade="noshade" size="1" color="#CCCCCC" width="70%" align="left" />

<table cellpadding="0" cellspacing="0" width="100%">

  <tr>
    <td colspan="4"><b>{$lng.lbl_account_information}</b></td>
  </tr>

  {if $config.email_as_login ne 'Y'}
    <tr>
      <td width="25">&nbsp;&nbsp;&nbsp;</td>
      <td width="20%"><tt>{$lng.lbl_username}:</tt></td>
      <td width="10">&nbsp;</td>
      <td width="80%"><tt>{$userinfo.login}</tt></td>
    </tr>
  {/if}

  <tr>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td><tt>{$lng.lbl_email}:</tt></td>
    <td>&nbsp;</td>
    <td><tt>{$userinfo.email}</tt></td>
  </tr>

  {if $password_reset_key}
    <tr>
      <td>&nbsp;&nbsp;&nbsp;</td>
      <td><tt>{$lng.lbl_password_reset_url}:</tt></td>
      <td>&nbsp;</td>
      <td><tt><a href="{if $config.Security.use_https_login eq 'Y'}{$https_location}{else}{$http_location}{/if}{if $userpath ne ''}{$userpath}{/if}/change_password.php?password_reset_key={$password_reset_key}&amp;user={$userinfo.id}">{if $config.Security.use_https_login eq 'Y'}{$https_location}{else}{$http_location}{/if}{if $userpath ne ''}{$userpath}{/if}/change_password.php?password_reset_key={$password_reset_key}&user={$userinfo.id}</a></tt></td>
    </tr>
  {/if}
 
  {if $userinfo.default_fields or $userinfo.membership or $userinfo.pending_membership ne $userinfo.membership}
    <tr>
      <td colspan="4"><b>{$lng.lbl_personal_information}</b></td>
    </tr>
  {/if}

  {if $userinfo.default_fields.title}
    <tr>
      <td>&nbsp;&nbsp;&nbsp;</td>
      <td><tt>{$lng.lbl_title}:</tt></td>
      <td>&nbsp;</td>
      <td><tt>{$userinfo.title|default:'-'}</tt></td>
    </tr>
  {/if}

  {if $userinfo.default_fields.firstname}
    <tr>
      <td>&nbsp;&nbsp;&nbsp;</td>
      <td><tt>{$lng.lbl_first_name}:</tt></td>
      <td>&nbsp;</td>
      <td><tt>{$userinfo.firstname|default:'-'}</tt></td>
    </tr>
  {/if}

  {if $userinfo.default_fields.lastname}
    <tr>
      <td>&nbsp;&nbsp;&nbsp;</td>
      <td><tt>{$lng.lbl_last_name}:</tt></td>
      <td>&nbsp;</td>
      <td><tt>{$userinfo.lastname|default:'-'}</tt></td>
    </tr>
  {/if}

  {if $userinfo.default_fields.company}
    <tr> 
      <td>&nbsp;&nbsp;&nbsp;</td>
      <td><tt>{$lng.lbl_company}:</tt></td>
      <td>&nbsp;</td> 
      <td><tt>{$userinfo.company|default:'-'}</tt></td>
    </tr>
  {/if}

  {if $userinfo.default_fields.ssn}
    <tr>
      <td>&nbsp;&nbsp;&nbsp;</td>
      <td><tt>{$lng.lbl_ssn}:</tt></td>
      <td>&nbsp;</td>
      <td><tt>{$userinfo.ssn|default:'-'}</tt></td>
    </tr>
  {/if}

  {if $userinfo.default_fields.tax_number}
    <tr> 
      <td>&nbsp;&nbsp;&nbsp;</td>
      <td><tt>{$lng.lbl_tax_number}:</tt></td>
      <td>&nbsp;</td> 
      <td><tt>{$userinfo.tax_number|default:'-'}</tt></td>
    </tr>
  {/if}

  {if $userinfo.membership}
    <tr> 
      <td>&nbsp;&nbsp;&nbsp;</td>
      <td><tt>{$lng.lbl_membership}:</tt></td>
      <td>&nbsp;</td> 
      <td><tt>{$userinfo.membership|default:'-'}</tt></td>
    </tr>
  {/if}

  {if $userinfo.pending_membership ne $userinfo.membership}
    <tr> 
      <td>&nbsp;&nbsp;&nbsp;</td>
      <td><tt>{$lng.lbl_signup_for_membership}:</tt></td>
      <td>&nbsp;</td> 
      <td><tt>{$userinfo.pending_membership|default:'-'}</tt></td>
    </tr>
  {/if}

  {if $address_book_data.B or $address_book_data.S}
    <tr>
      <td colspan="4" class="section">&nbsp;</td>
    </tr>
  
    <tr>
      <td colspan="2"><b>{$lng.lbl_billing_address}</b><br />{include file="customer/main/address_details_html.tpl" address=$address_book_data.B default_fields=$userinfo.default_address_fields additional_fields_type='B'}</td>
      <td colspan="2"><b>{$lng.lbl_shipping_address}</b><br />{include file="customer/main/address_details_html.tpl" address=$address_book_data.S default_fields=$userinfo.default_address_fields additional_fields_type='S'}</td>
    </tr>
  {/if}

  {foreach from=$userinfo.additional_fields item=v}
    {if $v.section eq 'P'}
      <tr>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td><tt>{$v.title}:</tt></td>
        <td>&nbsp;</td>
        <td><tt>{$v.value|default:'-'}</tt></td>
      </tr>
    {/if}
  {/foreach}

  {if $userinfo.field_sections.A}
    <tr>
      <td colspan="4"><b>{$lng.lbl_additional_information}</b></td>
    </tr>

    {foreach from=$userinfo.additional_fields item=v}
      {if $v.section eq 'A' or $v.section eq 'C'}
        <tr>
          <td>&nbsp;&nbsp;&nbsp;</td>
          <td><tt>{$v.title}:</tt></td>
          <td>&nbsp;</td>
          <td><tt>{$v.value}</tt></td>
        </tr>
      {/if}
    {/foreach}
  {/if}

</table>
