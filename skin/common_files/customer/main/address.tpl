{*
3990b2d1927665b8363196dcb13185d533fefc33, v6 (xcart_4_7_7), 2016-08-23 15:47:21, address.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
  
{if $av_error}

  {if $login ne '' and !$av_script_url}
    {assign var=av_script_url value="popup_address.php?id=`$id`"}
  {/if}

  {include file="modules/UPS_OnLine_Tools/register.tpl"}
  
{else}
  
  {include file="check_zipcode_js.tpl"}
  {include file="change_states_js.tpl"}
  
  {if $id gt 0}
    <h1>{$lng.lbl_edit_address}</h1>
  {else}
    <h1>{$lng.lbl_new_address}</h1>
  {/if}
  
  {if $reg_error ne ''}
    {include file="mark_required_fields_js.tpl" form="addressbook" errfields=$reg_error.fields}
    <p class="error-message">{$reg_error.errdesc}</p>
  {/if}
  
  <form action="popup_address.php" method="post" name="addressbook" onsubmit="javascript: return check_zip_code(this);"> 
  <input type="hidden" name="mode" value="{if $id gt 0}update{else}add{/if}" />
  <input type="hidden" name="id" value="{$id}" />
  <input type="hidden" name="for" value="{$for}" />
  
  <table cellpadding="3" cellspacing="1" width="100%" summary="{$lng.lbl_address_book}">
    
    {include file="customer/main/address_fields.tpl" address=$address name_prefix="posted_data" id_prefix=''}
  
    <tr{if $is_address_book_empty or $address.default_b eq 'Y'} style="display: none;"{/if}>
      <td colspan="2">&nbsp;</td>
      <td>
        {if not $is_address_book_empty and $address.default_b ne 'Y'}
          <label><input type="checkbox" id="default_b" name="posted_data[default_b]" size="32" maxlength="32"{if $address.default_b eq 'Y'} checked="checked"{/if}/>&nbsp;{$lng.lbl_use_as_b_address}</label>
        {else}
          <input type="hidden" name="posted_data[default_b]" value="Y" />
        {/if}
      </td>
    </tr>
  
    <tr{if $is_address_book_empty or $address.default_s eq 'Y'} style="display: none;"{/if}>
      <td colspan="2">&nbsp;</td>
      <td>
        {if not $is_address_book_empty and $address.default_s ne 'Y'}
          <label><input type="checkbox" id="default_s" name="posted_data[default_s]" size="32" maxlength="32"{if $address.default_s eq 'Y'} checked="checked"{/if}/>&nbsp;{$lng.lbl_use_as_s_address}</label>
        {else}
          <input type="hidden" name="posted_data[default_s]" value="Y" />
        {/if}
      </td>
    </tr>
  
  </table>
  <br />
  
  <div class="buttons-row buttons-auto-separator" align="center">
    {include file="customer/buttons/button.tpl" type="input" button_title=$lng.lbl_save}
    {if $return}
      {include file="customer/buttons/button.tpl" button_title=$lng.lbl_back href="javascript: popupOpen('popup_address.php?mode=`$return`&for=`$for`&type=`$type`'); return false;"}
    {/if}
  </div>
  
  </form>

{/if}
