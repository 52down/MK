{*
850e5138e855497e58a9e99e00c2e8e04e3f7234, v1 (xcart_4_4_0_beta_2), 2010-05-21 08:31:50, news_lists.tpl, joy
vim: set ts=2 sw=2 sts=2 et:
*}
{capture name=dialog}
<form action="news.php" method="post">
<input type="hidden" name="mode" value="subscribe" />
<input type="hidden" name="newsemail" value="{$newsemail|escape}" />
<table>
{foreach from=$lists item=list key=k}
<tr>
  <td width="5%"><input type="checkbox" name="s_lists[]" id="lists_{$k}" value="{$list.listid}" checked="checked" /></td>
  <td colspan="2"><label for="lists_{$k}"><b>{$list.name}</b></label></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="2"><label for="lists_{$k}"><i>{$list.descr}</i></label></td>
</tr>
{/foreach}
<tr>
  <td colspan="2">
    <br />
    <input type="submit" value="{$lng.lbl_subscribe|strip_tags:false|escape}" />
  </td>
</tr>
</table>
</form>
{/capture}
{include file="dialog.tpl" title=$lng.lbl_news_subscribe_to_newslists content=$smarty.capture.dialog extra='width="100%"'}
