{*
fdf4c40775b539a54bc228e488550b992e275a43, v6 (xcart_4_7_8), 2017-05-31 11:32:26, kount_data.tpl, Ildar

vim: set ts=2 sw=2 sts=2 et:
*}

{if $fraud_check_data.rules}
  <h4>{$lng.lbl_xpc_antifraud_rules}:</h4>
  <ul>
  {foreach from=$fraud_check_data.rules item=rule key=k}
    <li>{$rule}</li>
  {/foreach}
  </ul>
{/if}

{if $fraud_check_data.errors}
  <h4>{$lng.lbl_xpc_antifraud_errors}:</h4>
  <ul>
  {foreach from=$fraud_check_data.errors item=error key=k}
    <li>{$error}</li>
  {/foreach}
  </ul>
{/if}

{if $fraud_check_data.warnings}
  <h4>{$lng.lbl_xpc_antifraud_warnings}:</h4>
  <ul>
  {foreach from=$fraud_check_data.warnings item=warning key=k}
    <li>{$warning}</li>
  {/foreach}
  </ul>
{/if}
