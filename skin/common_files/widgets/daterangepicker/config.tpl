{*
9b083f337c6a09c8907112ebb4c99f2f6105399c, v5 (xcart_4_7_5), 2016-02-12 16:44:12, config.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}
{
  "startOfWeek":"{$config.Appearance.working_week_starts_from|lower}",
  "format":"{$dateRangeFormat}",
  "separator":"{$config.daterange_separator}",
  "language":"{$shop_language}",
  "shortcuts":{
    "prev-days":[{$config.Appearance.daterange_past_days}],
    "prev":[{$config.Appearance.daterange_past_periods}],
    "next-days":[{$config.Appearance.daterange_next_days}],
    "next":[{$config.Appearance.daterange_next_periods}]
  }
  {if $config.Appearance.daterange_custom_periods},"customShortcuts":[{$config.Appearance.daterange_custom_periods}]{/if}
  {if $limitStartDate ne ""},"startDate":"{$limitStartDate|date_format:$config.Appearance.date_format}"{/if}
  {if $limitEndDate ne ""},"endDate":"{$limitEndDate|date_format:$config.Appearance.date_format}"{/if}
}
