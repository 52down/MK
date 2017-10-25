{*
a29e1b7957381fc2d95ee70e9cdca201bc070596, v4 (xcart_4_7_7), 2016-10-03 19:43:56, complex_selector.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}

{* BEGIN modules/XMultiCurrency/customer/init.tpl *}
<script type="text/javascript">
//<![CDATA[

var lng_mc_selector_title = '{$lng.mc_lbl_selector_title}';
var lng_thumbnails = [
{foreach from=$all_languages item=l}
  ['{$l.code}', '{if not $l.is_url}{$current_location}{/if}{$l.tmbn_url}'],
{/foreach}
  ['empty', '']
];

var mc_countries = [
{foreach from=$mc_all_countries item=cnt}
{if not $cnt.excluded}
['{$cnt.country_code}', '{$cnt.currency_code}', '{$cnt.language_code}'],
{/if}
{/foreach}
];
{literal}

function toggleSelectorDlg(base, linesCount)
{
  $('#mc-selector-language-block-menu').hide();
  _minHeight = 55 + linesCount * 52;
  var is_mobile = isXCOpenOnMobileDevice();
  $('#mc_selector').dialog({ title: lng_mc_selector_title, width: (is_mobile) ? 310 : 550, maxWidth: 550, minWidth: (is_mobile) ? 290 : 530, minHeight: _minHeight, draggable: false, modal: true});
}

function getLngThumbnail(code)
{
  for (var i = 0; i < lng_thumbnails.length; i++) {
    if (lng_thumbnails[i][0] == code) {
      return lng_thumbnails[i][1];
    }
  }
  return '';
}

function setCurrencyByCountry(country_code)
{
  var currency_code = '';

  for (var i = 0; i < mc_countries.length; i++) {
    if (mc_countries[i][0] == country_code) {
      currency_code = mc_countries[i][1];
      break;
    }
  }

  if (currency_code != '') {
    $('#mc_currency option[value="' + currency_code + '"]').attr('selected', 'selected');
  }
}

function setLanguageByCountry(country_code)
{
  var language_code = '';

  for (var i = 0; i < mc_countries.length; i++) {
    if (mc_countries[i][0] == country_code) {
      language_code = mc_countries[i][2];
      break;
    }
  }

  if (language_code != '') {
    $('#mc-selected-language').val(language_code);
    $('#mc-selector-language-current').css('backgroundImage', $('#mc-selector-language-block-menu-item-' + language_code).css('backgroundImage'));
    $('#mc-selector-language-current').html($('#mc-selector-language-block-menu-item-' + language_code).html());
  }
}


{/literal}

//]]>
</script>
{* END modules/XMultiCurrency/customer/init.tpl *}

{foreach from=$all_languages item=l name=languages}
  {if $store_language eq $l.code}
    {if $config.Appearance.line_language_selector eq 'Y'}
      {assign var="cur_lng_dspl" value=$l.code3}
    {elseif $config.Appearance.line_language_selector eq 'A'}
      {assign var="cur_lng_dspl" value=$l.code}
    {elseif $config.Appearance.line_language_selector eq 'L'}
      {assign var="cur_lng_dspl" value=$l.language}
    {/if}
    {assign var="curlng" value=$l}
  {/if}
{/foreach}

{assign var="mc_selector_lines" value=0}
{if $smarty.foreach.languages.total gt 1}
  {math assign="mc_selector_lines" equation="x+1" x=$mc_selector_lines}
{/if}
{if $mc_allow_currency_selection}
  {math assign="mc_selector_lines" equation="x+1" x=$mc_selector_lines}
{/if}
{if $config.mc_allow_select_country eq "Y"}
  {math assign="mc_selector_lines" equation="x+1" x=$mc_selector_lines}
{/if}

<div class="languages mc-selector-menu-block" id="mc-selector-menu" {if $smarty.foreach.languages.total gt 1 or $mc_allow_currency_selection}onclick="javascript: toggleSelectorDlg(this, {$mc_selector_lines})"{else}style="cursor: auto;" {/if}>

  <div class="mc-selector-menu-item">

  {if $config.Appearance.line_language_selector eq 'F'}
    <img src="{if not $curlng.is_url}{$current_location}{/if}{$curlng.tmbn_url|amp}" alt="{$curlng.language|escape}" width="{$curlng.image_x}" height="{$curlng.image_y}" title="{$lng.lbl_language|escape}: {$curlng.language|escape}" />

  {else}
    <strong class="language-code lng-{$store_language}" title="{$lng.lbl_language|escape}: {$curlng.language|escape}">'{$cur_lng_dspl}'</strong>
  {/if}

  </div>

  <div class="mc-selector-menu-item mc-currency" title="{$lng.mc_lbl_currency|escape}: {$store_currency_data.name|escape}">{$store_currency}{if $store_currency_data.symbol ne "" and $store_currency ne $store_currency_data.symbol} ({$store_currency_data.symbol}){/if}</div>

  {if $config.mc_allow_select_country eq "Y"}
  {assign var="store_country_name" value="country_`$store_country`"}
  <div class="mc-selector-menu-item mc-country" title="{$lng.lbl_country|escape}: {$lng.$store_country_name|escape}">{$lng.$store_country_name}</div>
  {/if}

</div>

{include file="modules/XMultiCurrency/customer/popup_block.tpl" _include_once=1}
