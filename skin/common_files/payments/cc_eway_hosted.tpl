{*
f96897f5c3182b69d76fa60933efced07d64bdf7, v1 (xcart_4_7_6), 2016-05-03 08:26:18, cc_eway_hosted.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<h1>{$module_data.module_name}</h1>
{capture name=dialog}
<form action="cc_processing.php?cc_processor={$module_data.processor|escape:"url"}" method="post">

<table cellspacing="10" width="100%">

<tr>
  <td width="40%">{$lng.lbl_cc_eway_hosted_api_key}:</td>
  <td width="60%"><input type="text" name="param01" size="32" value="{$module_data.param01|escape}" /></td>
</tr>

<tr>
  <td width="40%">{$lng.lbl_cc_eway_hosted_api_password}:</td>
  <td width="60%"><input type="text" name="param02" size="32" value="{$module_data.param02|escape}" /></td>
</tr>

{*include file="payments/currencies.tpl" param_name='param08' current=$module_data.param08*}

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
  <td><input type="text" name="param03" size="32" maxlength="{if $single_mode}12{else}8{/if}" value="{$module_data.param03|escape}" /></td>
</tr>

<tr>
  <td>{$lng.lbl_cc_eway_hosted_custom_view}:</td>
  <td>
    <select name="param04">
      <option value=""{if $module_data.param04 eq ''} selected="selected"{/if}>{$lng.lbl_default}</option>
      <option value="Bootstrap"{if $module_data.param04 eq 'Bootstrap'} selected="selected"{/if}>Bootstrap</option>
      <option value="BootstrapAmelia"{if $module_data.param04 eq 'BootstrapAmelia'} selected="selected"{/if}>BootstrapAmelia</option>
      <option value="BootstrapCerulean"{if $module_data.param04 eq 'BootstrapCerulean'} selected="selected"{/if}>BootstrapCerulean</option>
      <option value="BootstrapCosmo"{if $module_data.param04 eq 'BootstrapCosmo'} selected="selected"{/if}>BootstrapCosmo</option>
      <option value="BootstrapCyborg"{if $module_data.param04 eq 'BootstrapCyborg'} selected="selected"{/if}>BootstrapCyborg</option>
      <option value="BootstrapFlatly"{if $module_data.param04 eq 'BootstrapFlatly'} selected="selected"{/if}>BootstrapFlatly</option>
      <option value="BootstrapJournal"{if $module_data.param04 eq 'BootstrapJournal'} selected="selected"{/if}>BootstrapJournal</option>
      <option value="BootstrapReadable"{if $module_data.param04 eq 'BootstrapReadable'} selected="selected"{/if}>BootstrapReadable</option>
      <option value="BootstrapSimplexReadableJournal"{if $module_data.param04 eq 'BootstrapSimplexReadableJournal'} selected="selected"{/if}>BootstrapSimplexReadableJournal</option>
      <option value="BootstrapSlate"{if $module_data.param04 eq 'BootstrapSlate'} selected="selected"{/if}>BootstrapSlate</option>
      <option value="BootstrapSpacelab"{if $module_data.param04 eq 'BootstrapSpacelab'} selected="selected"{/if}>BootstrapSpacelab</option>
      <option value="BootstrapUnited"{if $module_data.param04 eq 'BootstrapUnited'} selected="selected"{/if}>BootstrapUnited</option>
    </select>
  </td>
</tr>

<tr>
  <td>{$lng.lbl_cc_eway_hosted_verify_customer_phone}:</td>
  <td><input type="hidden" name="param05" value="N" /><input type="checkbox" name="param05" size="32" value="Y"{if $module_data.param05 eq "Y"} checked="checked"{/if}/></td>
</tr>

<tr>
  <td>{$lng.lbl_cc_eway_hosted_verify_customer_email}:</td>
  <td><input type="hidden" name="param06" value="N" /><input type="checkbox" name="param06" size="32" value="Y"{if $module_data.param06 eq "Y"} checked="checked"{/if}/></td>
</tr>

<tr>
  <td>{$lng.lbl_cc_eway_hosted_show_line_items}:</td>
  <td><input type="hidden" name="param07" value="N" /><input type="checkbox" name="param07" size="32" value="Y"{if $module_data.param07 eq "Y"} checked="checked"{/if}/></td>
</tr>

</table>

<br /><br />

<input type="submit" value="{$lng.lbl_update|strip_tags:false|escape}" />
</form>

{/capture}
{include file="dialog.tpl" content=$smarty.capture.dialog extra='width="100%"'}
