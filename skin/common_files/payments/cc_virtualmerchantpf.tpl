{*
e13f84339111e4187b315cf308e23ce6dbca8a07, v3 (xcart_4_7_7), 2016-10-06 11:03:22, cc_virtualmerchantpf.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<h1>{$module_data.module_name}</h1>
{$lng.txt_cc_configure_top_text}
<br /><br />
{capture name=dialog}
<form action="cc_processing.php?cc_processor={$smarty.get.cc_processor|escape:"url"}" method="post">

<table cellspacing="10">

  <tr>
    <td>{$lng.lbl_cc_vm_id}:</td>
    <td><input type="text" name="param01" size="64" value="{$module_data.param01|escape}" /></td>
  </tr>

  <tr>
    <td>{$lng.lbl_cc_vm_userid}:</td>
    <td><input type="text" name="param07" size="64" value="{$module_data.param07|escape}" /></td>
  </tr>

  <tr>
    <td>{$lng.lbl_cc_vm_userpin}:</td>
    <td><input type="text" name="param02" size="64" value="{$module_data.param02|escape}" /></td>
  </tr>

  <tr>
    <td>{$lng.lbl_cc_testlive_mode}:</td>
    <td>
      <select name="testmode">
        <option value="Y"{if $module_data.testmode eq "Y"} selected="selected"{/if}>{$lng.lbl_cc_testlive_test}</option>
        <option value="D"{if $module_data.testmode eq "D"} selected="selected"{/if}>{$lng.lbl_cc_testlive_demo}</option>
        <option value="N"{if $module_data.testmode eq "N"} selected="selected"{/if}>{$lng.lbl_cc_testlive_live}</option>
      </select>
    </td>
  </tr>

  <tr>
    <td>{$lng.lbl_cc_order_prefix}:</td>
    <td><input type="text" name="param04" size="36" value="{$module_data.param04|escape}" /></td>
  </tr>

  <tr>
    <td>{$lng.lbl_cc_vm_cvv2}:</td>
    <td>
      <select name="param05">
        <option value="Y"{if $module_data.param05 eq "Y"} selected="selected"{/if}>{$lng.lbl_yes}</option>
        <option value="N"{if $module_data.param05 eq "N"} selected="selected"{/if}>{$lng.lbl_no}</option>
      </select>
    </td>
  </tr>

  <tr>
    <td>{$lng.lbl_cc_vm_avs}:</td>
    <td>
      <select name="param06">
        <option value="Y"{if $module_data.param06 eq "Y"} selected="selected"{/if}>{$lng.lbl_yes}</option>
        <option value="N"{if $module_data.param06 eq "N"} selected="selected"{/if}>{$lng.lbl_no}</option>
      </select>
    </td>
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

{/capture}
{include file="dialog.tpl" title=$lng.lbl_cc_settings content=$smarty.capture.dialog extra='width="100%"'}
