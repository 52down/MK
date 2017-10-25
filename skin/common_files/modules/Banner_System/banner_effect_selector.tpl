{*
f00d0a475881a7deeeedef638b07890cc2d708e5, v2 (xcart_4_7_7), 2017-01-11 22:28:12, banner_effect_selector.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}
<select name="{$name}">
  <option value="none" {if $selected_effect eq 'none'} selected="selected"{/if}>None</option>
  <option value="carousel" {if $selected_effect eq 'carousel'} selected="selected"{/if}>Carousel</option>
  <option value="fade" {if $selected_effect eq 'fade'} selected="selected"{/if}>Fade</option>
  <option value="fadeout" {if $selected_effect eq 'fadeout'} selected="selected"{/if}>Fadeout</option>
  <option value="flipHorz" {if $selected_effect eq 'flipHorz'} selected="selected"{/if}>FlipHorz</option>
  <option value="flipVert" {if $selected_effect eq 'flipVert'} selected="selected"{/if}>FlipVert</option>
  <option value="scrollHorz" {if $selected_effect eq 'scrollHorz'} selected="selected"{/if}>ScrollHorz</option>
  <option value="scrollVert" {if $selected_effect eq 'scrollVert'} selected="selected"{/if}>ScrollVert</option>
  <option value="shuffle" {if $selected_effect eq 'shuffle'} selected="selected"{/if}>Shuffle</option>
  <option value="tileSlideVert" {if $selected_effect eq 'tileSlideVert'} selected="selected"{/if}>TileSlideVert</option>
  <option value="tileSlideHorz" {if $selected_effect eq 'tileSlideHorz'} selected="selected"{/if}>TileSlideHorz</option>
  <option value="tileBlindVert" {if $selected_effect eq 'tileBlindVert'} selected="selected"{/if}>TileBlindVert</option>
  <option value="tileBlindHorz" {if $selected_effect eq 'tileBlindHorz'} selected="selected"{/if}>TileBlindHorz</option>
</select>
