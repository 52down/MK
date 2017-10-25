{*
2786669d22adf190c43dd388f67ad43cd959f3c7, v6 (xcart_4_7_7), 2016-10-26 10:58:37, search_orders.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}

<h1>{$lng.lbl_orders}</h1>

<p class="text-block">
  {if $orders ne ""}
    {$lng.txt_search_orders_header}
  {else}
    {$lng.txt_search_orders_header}
  {/if}
</p>

{if $mode ne "search" or $orders eq ""}

  <script type="text/javascript" src="{$SkinDir}/js/reset.js"></script>
<script type="text/javascript">
//<![CDATA[
var txt_delete_orders_warning = "{$lng.txt_delete_orders_warning|wm_remove|escape:javascript|strip_tags}";
var searchform_def = [
  ['posted_data[date_range]', ''],
  ['StartDay', '{$smarty.now|date_format:"%d"}'],
  ['StartMonth', '{$smarty.now|date_format:"%m"}'],
  ['StartYear', '{$smarty.now|date_format:"%Y"}'],
  ['EndDay', '{$smarty.now|date_format:"%d"}'],
  ['EndMonth', '{$smarty.now|date_format:"%m"}'],
  ['EndYear', '{$smarty.now|date_format:"%Y"}'],
  ['posted_data[total_min]', '{$zero}'],
  ['posted_data[total_max]', ''],
  ['posted_data[by_title]', true],
  ['posted_data[by_options]', true],
  ['posted_data[price_min]', '{$zero}'],
  ['posted_data[price_max]', ''],
  ['posted_data[address_type]', ''],
  ['posted_data[is_export]', ''],
  ['posted_data[orderid1]', ''],
  ['posted_data[orderid2]', ''],
  ['posted_data[payment_method]', ''],
  ['posted_data[product_substring]', ''],
  ['posted_data[features][]', ''],
  ['posted_data[provider]', ''],
  ['posted_data[shipping_method]', ''],
  ['posted_data[productcode]', ''],
  ['posted_data[productid]', ''],
  ['posted_data[customer]', ''],
  ['posted_data[by_username]', true],
  ['posted_data[by_firstname]', true],
  ['posted_data[by_lastname]', true],
  ['posted_data[company]', ''],
  ['posted_data[city]', ''],
  ['posted_data[state]', ''],
  ['posted_data[country]', ''],
  ['posted_data[zipcode]', ''],
  ['posted_data[phone]', ''],
  ['posted_data[email]', ''],
  ['posted_data[status]', '']
];
{literal}
function managedate(type, status) {
  if (type != 'date')
    var fields = ['posted_data[city]','posted_data[state]','posted_data[country]','posted_data[zipcode]'];
  else
    var fields = ['f_start_date', 'f_end_date'];
  
  for (var i = 0; i < fields.length; i++) {
    if (document.searchform.elements.namedItem(fields[i]))
      document.searchform.elements.namedItem(fields[i]).disabled = status;
  }
}
{/literal}
//]]>
</script>

  {capture name=dialog}

    <form name="searchform" action="orders.php" method="post">
      <input type="hidden" name="mode" value="" />

      {$lng.txt_search_orders_text}
      <br /><br />
      <table cellspacing="0" cellpadding="0" class="width-100" summary="{$lng.lbl_search_orders|escape}">

        <tr>
          <td class="data-name">{$lng.lbl_date_period}:</td>
          <td class="input-row">

            {include file="widgets/daterangepicker/daterangepicker.tpl" value=$search_prefilled.date_range}

          </td>
        </tr>

      </table>

      {if $search_prefilled.date_period ne "C"}
<script type="text/javascript">
//<![CDATA[
managedate('date',true);
//]]>
</script>
      {/if}

      {include file="customer/visiblebox_link.tpl" id="adv_search_box" title=$lng.lbl_advanced_search_options visible=$search_prefilled.need_advanced_options}

      <div id="adv_search_box"{if not $search_prefilled.need_advanced_options} style="display: none;"{/if}>

        <table cellspacing="0" cellpadding="0" class="width-100" summary="{$lng.lbl_advanced_search_options|escape}">

          <tr>
            <td class="data-name">{$lng.lbl_order_id}:</td>
            <td>
              <input type="text" name="posted_data[orderid1]" size="10" maxlength="15" value="{$search_prefilled.orderid1|escape}" />
              -
              <input type="text" name="posted_data[orderid2]" size="10" maxlength="15" value="{$search_prefilled.orderid2|escape}" />
            </td>
          </tr>

          <tr> 
            <td class="data-name">{$lng.lbl_order_status}:</td>
            <td class="data-input">{include file="main/order_status.tpl" status=$search_prefilled.status mode="select" name="posted_data[status]" extended="Y" display_preauth=true}</td>
          </tr>

        </table>

      </div>

      <table cellspacing="0" cellpadding="0" class="width-100" summary="{$lng.lbl_search|escape}">
        <tr>
          <td class="data-name valign-middle"><a href="javascript:void(0);" onclick="javascript: reset_form('searchform', searchform_def);" class="underline normal">{$lng.lbl_reset_filter}</a></td>
          <td class="valign-middle">
            {include file="customer/buttons/button.tpl" button_title=$lng.lbl_search type="input" style="button" additional_button_class="main-button"}
          </td>
        </tr>
      </table>

    </form>
  
  {/capture}
  {include file="customer/dialog.tpl" title=$lng.lbl_search_orders content=$smarty.capture.dialog additional_class="adv-search"}

{/if}

{if $mode eq "search"}

  <p class="text-block">
    {if $total_items gte "1"}

      {$lng.txt_N_results_found|substitute:"items":$total_items}<br />
      {$lng.txt_displaying_X_Y_results|substitute:"first_item":$first_item:"last_item":$last_item}

    {else}

      {$lng.txt_N_results_found|substitute:"items":0}

    {/if}
  </p>

{/if}

{if $orders ne ""}

  {include file="customer/main/orders_list.tpl"}

{/if}
