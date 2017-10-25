{*
fdf4c40775b539a54bc228e488550b992e275a43, v1 (xcart_4_7_8), 2017-05-31 11:32:26, antifraud_status.tpl, Ildar

vim: set ts=2 sw=2 sts=2 et:
*}

{if $status eq 'D'}
  {assign var=hint value=$lng.lbl_xpc_antifraud_decline}
{elseif $status eq 'R'}
  {assign var=hint value=$lng.lbl_xpc_antifraud_review}
{elseif $status eq 'A'}
  {assign var=hint value=$lng.lbl_xpc_antifraud_accept}
{else}
  {assign var=hint value=$lng.lbl_xpc_antifraud_error}
{/if}

<a class="xpc-antifraud-status status-{$status|default:"E"}" href="order.php?orderid={$orderid}#xpc_antifraud" title="{$hint}">&nbsp;</a>
