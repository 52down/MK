{*
9b083f337c6a09c8907112ebb4c99f2f6105399c, v7 (xcart_4_7_5), 2016-02-12 16:44:12, daterangepicker.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}

{*
  Supported params:

    $name - input control name

    $limitStartDate - start limit of selectable dates
    $limitEndDate - end limit of selectable dates

    $startDate - date range value start
    $endDate - date range value end

    $value - date range value
*}

{load_defer file="lib/moment/moment-with-langs.min.js" type="js"}

{include file="widgets/css_loader.tpl" css="lib/daterangepicker/daterangepicker.min.css"}
{load_defer file="lib/daterangepicker/daterangepicker.min.js" type="js"}

{if $dateRangeFormat eq ""}
  {assign var="dateRangeFormat" value=$config.Appearance.date_format|replace:'%Y':'YYYY'|replace:'%m':'MM'|replace:'%d':'DD'|replace:'%A':'dddd'|replace:'%B':'MMMM'|replace:'%b':'MMM'|replace:'%e':'D' scope="root"}
  {include file="widgets/daterangepicker/translation.tpl"}
{/if}

{include file="widgets/daterangepicker/config.tpl" assign="daterangeconfig" dateRangeFormat=$dateRangeFormat limitStartDate=$limitStartDate limitEndDate=$limitEndDate}

{include file="widgets/css_loader.tpl" css="widgets/daterangepicker/daterangepicker.css"}
{load_defer file="widgets/daterangepicker/daterangepicker.js" type="js"}

{if $startDate or $endDate}
  {assign var="dateRangeStartDate" value=$startDate|date_format:$config.Appearance.date_format}
  {assign var="dateRangeEndDate" value=$endDate|date_format:$config.Appearance.date_format}
  {assign var="dateRangeValue" value=$dateRangeStartDate|cat:$config.daterange_separator|cat:$dateRangeEndDate}
{/if}

<input name="{$name|default:'posted_data[date_range]'}" placeholder="{$lng.lbl_enter_date_range}" title="{$lng.lbl_enter_date_range}"
       type="text" value="{$value|default:$dateRangeValue|validate_date_range}" autocomplete="off" maxlength="255" class="date-range" data-daterangeconfig="{$daterangeconfig|escape}" />
