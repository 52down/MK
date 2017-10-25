{*
019d82f77d401b781fdab41bfd87c9a8ae6c42be, v2 (xcart_4_7_7), 2017-01-16 21:16:26, banner_rotator_config.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}

{if $config.Banner_System.bs_rotation_time_delay ne ''}
  data-cycle-timeout="{assign var='time_delay' value=$config.Banner_System.bs_rotation_time_delay*1000}{$time_delay}"
{/if}
  data-cycle-slides="> div"
{if $banner.effect eq 'tileSlideVert' or $banner.effect eq 'tileSlideHorz'}
  data-cycle-fx="tileSlide"
{elseif $banner.effect eq 'tileBlindVert' or $banner.effect eq 'tileBlindHorz'}
  data-cycle-fx="tileBlind"
{else}
  data-cycle-fx="{$banner.effect}"
{/if}
  data-cycle-center-horz="true"
  data-cycle-center-vert="true"
{if $banner.effect eq 'tileSlideHorz' or $banner.effect eq 'tileBlindHorz'}
  data-cycle-tile-vertical="false"
{/if}
{if $banner_width and $banner_height}
  data-cycle-auto-height="{$banner_width}:{$banner_height}"
{/if}
{if $banner.nav eq 'Y'}
  data-cycle-pager="#bs-pager-{$banner.bannerid}"
  data-cycle-pager-template="<a href=#>{literal}{{slideNum}}{/literal}</a>"
{/if}
