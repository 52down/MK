{*
2786669d22adf190c43dd388f67ad43cd959f3c7, v5 (xcart_4_7_7), 2016-10-26 10:58:37, new_arrivals_search_by_date.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}

<script type="text/javascript">
//<![CDATA[
searchform_def[searchform_def.length] = ['posted_data[date_range]', ''];

{literal}

function managedate(type, status) {
  var fields = ['f_start_date', 'f_end_date'];

  for (i in fields) {
    if (document.searchform.elements[fields[i]]) {
      if (status) {
        $(document.searchform.elements[fields[i]]).prop("disabled", true).addClass('ui-state-disabled' );
      } else {
        $(document.searchform.elements[fields[i]]).prop("disabled", false).removeClass('ui-state-disabled' );
      }
    }
  }
}

{/literal}
//]]>
</script>

<tr>
  <td height="10" width="20%" class="FormButton" nowrap="nowrap" valign="top">{$lng.lbl_new_arrivals_date_added}:</td>
  <td>

    {include file="widgets/daterangepicker/daterangepicker.tpl" value=$search_prefilled.date_range}

  </td>
</tr>

<script type="text/javascript">
//<![CDATA[
$(document).ready( function(){ldelim}
  {if $search_prefilled.date_period eq "C"}
    managedate('date', false);
  {else}
    managedate('date', true);
  {/if}
{rdelim});
//]]>
</script>

