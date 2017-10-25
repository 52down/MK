{*
174a10630db9313f4ea0c2668158867263bd8cdf, v2 (xcart_4_7_5), 2015-12-29 10:12:46, test_https_module.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{$lng.txt_test_https_module_descr}

<br /><br />

{capture name="dialog"}

<form action="general.php">
<input type="hidden" name="mode" value="test_https_module" />

<table>

<tr>
  <td>{$lng.lbl_url}</td>
  <td>
  <input type="text" name="test_https_url" value="{$test_https_url|default:$https_location}" size="60" />
  &nbsp;
  <input type="submit" value="{$lng.lbl_submit|strip_tags:false|escape}" />
  </td>
</tr>

</table>
</form>

{/capture}
{include file="dialog.tpl" content=$smarty.capture.dialog title=$lng.lbl_https_module_test_params extra='width="100%"'}
<br /><br />
{if $headers_data ne "" or $response_data ne ""}
{capture name="dialog"}
<pre>
{$headers_data|escape}
<hr />
{$response_data|escape}
</pre>
{/capture}
{include file="dialog.tpl" content=$smarty.capture.dialog title=$lng.lbl_https_module_response extra='width="100%"'}
{/if}
