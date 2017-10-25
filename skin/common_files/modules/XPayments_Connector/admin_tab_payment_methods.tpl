{*
194626627da00f55901e393daa481ee1a5d33cfb, v7 (xcart_4_7_4), 2015-10-26 13:19:01, admin_tab_payment_methods.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

{if $no_active_payment_methods}
<div class="xpc-no-active-pm-warning">
  <span><img src="{$ImagesDir}/icon_warning.gif" alt="" /></span>{$lng.txt_xpc_no_active_payment_methods}<span></span>
</div>
<br />
{/if}

<form action="xpc_admin.php?mode=update_payment_methods" id="xpc_update_pm_form" method="POST">

<table cellpadding="5" cellspacing="1" border="0">

  <tr class="TableHead">
    <td>{$lng.lbl_active}</td>
    <td>{$lng.lbl_payment_method}</td>
    <td>{$lng.lbl_xpc_cc_currency}</td>
    <td>{$lng.lbl_xpc_use_recharges}</td>
  </tr>

  {foreach from=$cc_processors item=pm}
  <tr{cycle values=', class="TableSubHead"'}>
    <td>
      <input type="checkbox" name="active[]" value="{$pm.paymentid}" {if $pm.active eq "Y"}checked="checked"{/if}/>
    </td>
    <td>{$pm.module_name}</td>
    <td>{if $pm.currency}{$pm.currency_name} ({$pm.currency}){else}{$lng.lbl_unknown}{/if}</td>
    <td>
      {if $pm.can_recharge}
        <input type="checkbox" name="use_recharges[]" value="{$pm.paymentid}" {if $pm.use_recharges eq "Y"}checked="checked"{/if}/>
      {else}
        {$lng.txt_not_available}
      {/if}
    </td>
  </tr>
  {/foreach}

</table>

<input type="submit" id="xpc_update_pm_submit" value="{$lng.lbl_update}">

</form>

<br />
<br />

{$lng.txt_xpc_pm_config_note_2|substitute:'url':$xp_backend_url}

<br />
<br />

{include file="main/subheader.tpl" title=$lng.lbl_xpc_import_payment_methods class="black"}

{$lng.txt_xpc_import_payment_methods_warn}

<br />
<br />

<input type="button" name="import_payment_methods" value="{$lng.lbl_xpc_request_payment_methods|strip_tags:false|escape}" onclick="javascript: self.location='xpc_admin.php?mode=import_payment_methods';" />
