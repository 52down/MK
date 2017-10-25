{*
67814c9aec19d6cf932988e3b949b16094b3dab9, v1 (xcart_4_7_4), 2015-10-28 10:53:25, mod_DHL.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $carrier eq "DHL"}
{*************************************************************
 *  DHL OPTIONS                                              *
 *************************************************************}

  {capture name=dialog}

    <div align="right"><a href="shipping.php?carrier=DHL#rt">{$lng.lbl_X_shipping_methods|substitute:"service":"DHL"}</a></div>

    <form method="post" action="shipping_options.php">
      <input type="hidden" name="carrier" value="DHL" />

      <table width="100%">

        {include file="admin/main/shipping_package_limits.tpl" shipper_options=$shipping_options.dhl shipper="DHL"}

        <tr>
          <td colspan="2"><br />{include file="main/subheader.tpl" title=$lng.lbl_dhl_package_options class="grey"}</td>
        </tr>
        <tr>
          <td width="50%"><b>{$lng.lbl_dhl_pkgtype}:</b></td>
          <td width="50%">
            <select name="pkg_type">
              <option value="FLY"{if $shipping_options.dhl.pkg_type eq "FLY"} selected="selected"{/if}>Flyer/Smalls</option>
              <option value="COY"{if $shipping_options.dhl.pkg_type eq "COY"} selected="selected"{/if}>Parcels/Conveyables</option>
              <option value="NCY"{if $shipping_options.dhl.pkg_type eq "NCY"} selected="selected"{/if}>Non-conveyables</option>
              <option value="PAL"{if $shipping_options.dhl.pkg_type eq "PAL"} selected="selected"{/if}>Pallets</option>
              <option value="DBL"{if $shipping_options.dhl.pkg_type eq "DBL"} selected="selected"{/if}>Double Pallets</option>
              <option value="BOX"{if $shipping_options.dhl.pkg_type eq "BOX"} selected="selected"{/if}>Parcels</option>
            </select>

            {include file="main/tooltip_js.tpl" text=$lng.txt_dhl_help_pkgtype type="img"}
          </td>
        </tr>

        <tr>
          <td colspan="2"><hr /></td>
        </tr>
        <tr>
          <td><b>{$lng.lbl_dhl_currency}:</b></td>
          <td>
            <select name="currency">
              {foreach key=code item=currency from=$dhl_currencies}
                <option value="{$code}"{if $code eq $shipping_options.dhl.currency} selected="selected"{/if}>{$code} - {$currency}</option>
              {/foreach}
            </select>
          </td>
        </tr>
        <tr>
          <td><b>{$lng.lbl_shipping_cost_convertion_rate}:</b><br />
            <font class="SmallText">{$lng.txt_shipping_cost_convertion_rate_currency}</font>
          </td>
          <td valign="top"><input type="text" name="currency_rate" size="10" value="{$shipping_options.dhl.currency_rate|escape}" /></td>
        </tr>

        <tr>
          <td colspan="2"><hr /></td>
        </tr>
        {include file="admin/main/shipping_value_of_contents.tpl" shipper_options=$shipping_options.dhl lng_label=$lng.lbl_dhl_insured_value name_prefix='insured' param_name='insured_type' fixed_value_name='insured_fixed_value'}

        {include file="admin/main/shipping_value_of_contents.tpl" shipper_options=$shipping_options.dhl lng_label=$lng.lbl_dhl_declared_value name_prefix='declared' param_name='declared_type' fixed_value_name='declared_fixed_value'}

        <tr>
          <td colspan="2"><hr /></td>
        </tr>
        {include file="admin/main/shipping_value_of_contents.tpl" shipper_options=$shipping_options.dhl lng_label=$lng.lbl_dhl_cod_value name_prefix='cod' param_name='cod_type' fixed_value_name='cod_fixed_value'}

        <tr>
          <td colspan="2"><hr /></td>
        </tr>
        <tr>
          <td><label for="status_new_method"><b>{$lng.lbl_carrier_new_method_status}:</b></label></td>
          <td><input type="checkbox" name="status_new_method" id="status_new_method" value="new_method_is_enabled"{if $shipping_options.dhl.param01 eq "new_method_is_enabled"} checked="checked"{/if} /></td>
        </tr>

        <tr>
          <td colspan="2" class="SubmitBox"><input type="submit" value="{$lng.lbl_apply|strip_tags:false|escape}" /></td>
        </tr>

      </table>
    </form>
  {/capture}
  {assign var="section_title" value=$lng.lbl_X_shipping_options|substitute:"service":"DHL"}
  {include file="dialog.tpl" content=$smarty.capture.dialog title=$section_title extra='width="100%"'}

{/if}
