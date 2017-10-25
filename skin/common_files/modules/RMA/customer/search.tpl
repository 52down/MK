{*
ac8c94920113307390c6b99bee08baf69d0fbf39, v3 (xcart_4_7_5), 2016-02-18 10:02:02, search.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

<h1>{$lng.lbl_search}</h1>

{capture name=dialog}

<form action="returns.php" method="post" name="searchreturnsform">
  <input type="hidden" name="mode" value="search" />

  <table cellspacing="0" class="data-table">

    <tr>
      <td class="data-name">{$lng.lbl_date_period}:</td>
      <td>{include file="widgets/daterangepicker/daterangepicker.tpl" name="search[date_range]" value=$search_prefilled.date_range}</td>
    </tr>

    <tr>
      <td class="data-name">{$lng.lbl_returnid}</td>
      <td>
        <input type="text" name="search[returnid]" value="{$search_prefilled.returnid}" size="5" />
      </td>
    </tr>

    <tr>
      <td class="data-name">{$lng.lbl_status}</td>
      <td>{include file="modules/RMA/return_status.tpl" name="search[status]" extended=1 mode="select" status=$search_prefilled.status}</td>
    </tr>

    <tr>
      <td>&nbsp;</td>
      <td class="button-row">
        {include file="customer/buttons/search.tpl" type="input"}
      </td>
    </tr>

  </table>

</form>

{/capture}
{include file="customer/dialog.tpl" content=$smarty.capture.dialog title=$lng.lbl_search noborder=true}
