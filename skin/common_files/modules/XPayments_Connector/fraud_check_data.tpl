{*
fdf4c40775b539a54bc228e488550b992e275a43, v1 (xcart_4_7_8), 2017-05-31 11:32:26, fraud_check_data.tpl, Ildar

vim: set ts=2 sw=2 sts=2 et:
*}

{foreach from=$order.extra.xpc_fraud_check_data item=fraud_check_data}
  {if $fraud_check_data.code eq 'antifraud'}

    <a name="xpc_antifraud"></a>
    <div class="xpc-antifraud-data">

      {if $is_invoice_page}
        <strong>{$fraud_check_data.service}</strong><br />
      {else}
        {include file="main/subheader.tpl" title=$fraud_check_data.service}
      {/if}

      <h3>
        {if $fraud_check_data.result_code eq 'D'}
          {$lng.lbl_xpc_antifraud_decline}.
        {elseif $fraud_check_data.result_code eq 'R'}
          {if $fraud_check_data.module eq 'NoFraud'}
            {$lng.lbl_xpc_nofraud_review}.
          {else}
            {$lng.lbl_xpc_antifraud_review}.
          {/if}
        {elseif $fraud_check_data.result_code eq 'A'}
          {$lng.lbl_xpc_antifraud_accept}.
        {else}
          <span class="status-E">{$lng.lbl_xpc_antifraud_error}.</span>
        {/if}
        {if $fraud_check_data.score gt 0}
          {$lng.lbl_xpc_antifraud_score}:
          <span class="status-{$fraud_check_data.result_code|default:"R"}">{$fraud_check_data.score|default:0}</span>
        {/if}
      </h3>

      <br/>

      <div class="xpc-antifraud-content">

        {if $fraud_check_data.transactionId}
          {$lng.lbl_xpc_antifraud_transaction_id}: {if $fraud_check_data.url}<a href="{$fraud_check_data.url}">{$fraud_check_data.transactionId}</a>{else}{$fraud_check_data.transactionId}{/if}
        {/if}

        {if $fraud_check_data.module eq 'Kount'}
          {include file="modules/XPayments_Connector/kount_data.tpl"}
        {else}

          {if $fraud_check_data.message ne ''}
            {$lng.lbl_xpc_antifraud_message}: {$fraud_check_data.message}
          {/if}

          {if $fraud_check_data.errors}
            <h4>{$lng.lbl_xpc_antifraud_errors}:</h4>
            <ul>
            {foreach from=$fraud_check_data.errors item=error key=k}
              <li>{$error}</li>
            {/foreach}
            </ul>
          {/if}

        {/if}

      </div>

    </div>

  {/if}
{/foreach}
