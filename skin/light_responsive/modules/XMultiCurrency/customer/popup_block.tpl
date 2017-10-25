{*
1b45150578a7bf789ecd822e3d70a0c1197c41c8, v1 (xcart_4_7_1), 2015-03-16 14:27:46, popup_block.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

<div class="mc-selector-popup-block" id="mc_selector">

  <form action="home.php" method="get" id="mcselectorform">

  <ul class="mc-selector-block">

  {* Language selector *}

  {if $smarty.foreach.languages.total gt 1}

  <li class="mc-selector-row mc-selector-language-row">
    <input type="hidden" name="sl" value="{$store_language}" id="mc-selected-language" />
    <div class="mc-selector-label">{$lng.lbl_select_language}:</div>

    {capture name="curlangdlg"}
    {foreach from=$all_languages item=l}
    {if $store_language eq $l.code}{assign var="mc_current_language" value=$l.language}{/if}
    <div class="mc-selector-language-block-menu-item" id="mc-selector-language-block-menu-item-{$l.code}" style="background-image: url({if not $l.is_url}{$current_location}{/if}{$l.tmbn_url|amp});" onclick="javascript: $('#mc-selected-language').val('{$l.code}'); $('#mc-selector-language-current').css('backgroundImage', $(this).css('backgroundImage')); $('#mc-selector-language-current').html($(this).html()); $('#mc-selector-language-block-menu').hide();">{$l.language}</div>
    {/foreach}
    {/capture}

    <span class="mc-selector-language-current" id="mc-selector-language-current" style="background-image: url({if not $curlng.is_url}{$current_location}{/if}{$curlng.tmbn_url|amp});" onclick="javascript: $('#mc-selector-language-block-menu').css('left', $(this).position().left); $('#mc-selector-language-block-menu').toggle();">{$mc_current_language}</span>

    <div class="mc-selector-language-block-menu" id="mc-selector-language-block-menu">
      {$smarty.capture.curlangdlg}
    </div>

  </li>

  {/if}

  {* Currency selector *}

  {if $mc_allow_currency_selection}

  <li class="mc-selector-row">

    {if $smarty.foreach.languages.total gt 1}
    <div class="mc-selector-row-separator"></div>
    {/if}

    <div class="mc-selector-label">{$lng.mc_lbl_select_surrency}:</div>
    <select name="mc_currency" id="mc_currency">
      {foreach from=$mc_all_currencies item=cur}
      <option value="{$cur.code}"{if $store_currency eq $cur.code} selected="selected"{/if}>{$cur.code} - {$cur.name}</option>
      {/foreach}
    </select>

  </li>

  {/if}

  {* Country selector *}

  {if $config.mc_allow_select_country eq "Y"}

  <li class="mc-selector-row">

    <div class="mc-selector-row-separator"></div>

    <div class="mc-selector-label">{$lng.mc_lbl_select_coountry}:</div>
    <select name="mc_country" id="mc_country" onchange="javascript: setCurrencyByCountry($('#mc_country option:selected').val()); setLanguageByCountry($('#mc_country option:selected').val())">
      {foreach from=$mc_all_countries item=cnt}
      {if not $cnt.excluded}
      <option value="{$cnt.country_code}"{if $store_country eq $cnt.country_code} selected="selected"{/if}>{$cnt.country}</option>
      {/if}
      {/foreach}
    </select>
  </li>

  {/if}

</ul>

  <div class="mc-selector-button">
    <input type="submit" value="{$lng.lbl_apply}" />
  </div>

  </form>

</div>
