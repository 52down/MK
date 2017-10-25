{*
f796cd4ac105eb160691c59c49e70773bd16b2d8, v13 (xcart_4_7_7), 2016-09-01 16:39:33, datepicker.tpl, mixon 

vim: set ts=2 sw=2 sts=2 et:
*}

{if $development_mode_enabled}
    {load_defer file="lib/jqueryui/components/datepicker.js" type="js"}
    {include file="widgets/css_loader.tpl" css="lib/jqueryui/components/datepicker.css"}
{else}
    {load_defer file="lib/jqueryui/components/datepicker.min.js" type="js"}
    {include file="widgets/css_loader.tpl" css="lib/jqueryui/components/datepicker.min.css"}
{/if}

{load_defer file="lib/jqueryui/components/i18n/datepicker-all.min.js" type="js"}

<input id="{$id|default:$name|escape}" class="datepicker-formatted" name="{$name|escape}" type="text" value="{$date|default:$smarty.now|date_format:$config.Appearance.date_format}" />
<script type="text/javascript">
//<![CDATA[

$(document).ready(function () {ldelim}

$.datepicker.setDefaults($.datepicker.regional["{$shop_language|lower}"]);

// Original input object
var dp_in = $("#{$id|default:$name|escape}");

// Create a hidden field that will contain timestamp
// generated on-the-fly when setting date
var dp_ts = $(document.createElement('input'))
  .attr('type', 'hidden')
  .attr('name', '{$name|escape}')
  .attr('id', '{$id|default:$name|escape}')
  .val('{$date|default:$smarty.now}');

// Change attributes of an original object
$(dp_in)
  .attr('id',   'f_{$id|default:$name|escape}')
  .attr('name', 'f_{$name|escape}');

$(dp_ts).insertAfter(dp_in);
{assign var=_default_end_year value=$config.Company.end_year+2}

var opts = {ldelim}
  yearRange:   '{$start_year|default:$config.Company.start_year}:{$end_year|default:$_default_end_year}',
  dateFormat:  '{$config.Appearance.ui_date_format}',
  altFormat:   'yy-mm-dd',
  altField:    '#{$id|default:$name|escape}',
  changeMonth: {$changeMonth|default:'true'},
  changeYear:  {$changeYear|default:'true'},
  showOn:      'both',
  buttonImage: '{$ImagesDir}/calendar.png',
  buttonImageOnly: true

{rdelim};

$("#f_{$id|default:$name|escape}")
  .datepicker(opts)
  .bind('change', function() {ldelim}
    var re = new RegExp(/000$/);
    $('#{$id|default:$name|escape}').val($('#{$id|default:$name|escape}').val().replace(re, ''));
    {if $dp_onchange neq ''}
      {$dp_onchange}
    {/if}
              
  {rdelim})

{rdelim}) // $(document).ready(function () {ldelim}

//]]>
</script>
