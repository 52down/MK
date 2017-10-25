{*
07f3f09431f1747ff6057acc275823caa01a311f, v5 (xcart_4_7_7), 2016-08-24 19:20:46, register.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

  <p class="text-block">{$lng.txt_ups_av_err}</p>

  <form action="{$av_script_url|default:"cart.php?mode=checkout"|amp}" method="post" name="avform">

    <input type="hidden" name="av_suggest" value="Y" />

    <table cellspacing="1" width="100%" class="ups-error width-100">

      {$address=$address|default:$av_error.params}

      <tr>
        <td class="ups-error-name"><strong>{$lng.lbl_you_entered}:</strong></td>
        <td>
          {$address.city}, {$address.state}
          {if $address.state ne ""}
            ({$address.statename})
          {/if}
          {$address.zipcode}
        </td>
      </tr>

      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>

      {if $av_error.result ne ""}

        <tr>
          <td><strong>{$lng.lbl_we_suggest}:</strong></td>
          <td>
            <select name="rank" id="ups_rank">
              {foreach item=av key=key from=$av_error.result}
                <option value="{$key|escape}">{$av.city}, {$av.state} {$av.zipcode}</option>
              {/foreach}
            </select>
          </td>
        </tr>

        <tr>
          <td>&nbsp;</td>
          <td>
            <div class="buttons-row buttons-auto-separator">
              {include file="customer/buttons/button.tpl" button_title=$lng.lbl_reenter_address href="javascript: this.form.av_suggest.value='R';" type="input" button_id="ups_reenter_address"}
              {include file="customer/buttons/button.tpl" button_title=$lng.lbl_use_suggestion href="javascript: this.form.av_suggest.value='Y';" type="input" button_id="ups_use_suggestion"}
              {include file="customer/buttons/button.tpl" button_title=$lng.lbl_keep_current_address href="javascript: this.form.av_suggest.value='K';" type="input" button_id="ups_keep_address"}
            </div>
          </td>
        </tr>

      {else}

        <tr>
          <td colspan="2" class="data-required">{$lng.txt_ups_av_no_alternative_address}</td>
        </tr>

        <tr>
          <td colspan="2" class="button-row">
            {include file="customer/buttons/button.tpl" button_title=$lng.lbl_reenter_address href="javascript: this.form.av_suggest.value='R'; this.form.submit();" type="input"}
          </td>
        </tr>

      {/if}

    </table>
  </form>

  <hr />

  {include file="modules/UPS_OnLine_Tools/ups_av_notice.tpl"}

