{*
80fa109209fb7816206a99abbf1e10a4916abe75, v2 (xcart_4_7_7), 2017-01-25 15:47:50, banner_js_loader.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}

{if $development_mode_enabled}
  {load_defer file="modules/Banner_System/lib/js/jquery.cycle2.js" type="js"}
  {load_defer file="modules/Banner_System/lib/js/jquery.cycle2.center.js" type="js"}
  {* additional effects *}
  {if $banner.effect eq 'carousel' or $banner.effect eq 'shuffle' or $banner.effect eq 'scrollVert'}
    {load_defer file="modules/Banner_System/lib/js/jquery.cycle2.{$banner.effect}.js" type="js"}
  {/if}
  {if $banner.effect eq 'flipHorz' or $banner.effect eq 'flipVert'}
    {load_defer file="modules/Banner_System/lib/js/jquery.cycle2.flip.js" type="js"}
  {/if}
  {if $banner.effect eq 'tileSlideVert' or $banner.effect eq 'tileSlideHorz' or $banner.effect eq 'tileBlindVert' or $banner.effect eq 'tileBlindHorz'}
    {load_defer file="modules/Banner_System/lib/js/jquery.cycle2.tile.js" type="js"}
  {/if}
{else}
  {load_defer file="modules/Banner_System/lib/js/jquery.cycle2.min.js" type="js"}
  {load_defer file="modules/Banner_System/lib/js/jquery.cycle2.center.min.js" type="js"}
  {* additional effects *}
  {if $banner.effect eq 'carousel' or $banner.effect eq 'shuffle' or $banner.effect eq 'scrollVert'}
    {load_defer file="modules/Banner_System/lib/js/jquery.cycle2.{$banner.effect}.min.js" type="js"}
  {/if}
  {if $banner.effect eq 'flipHorz' or $banner.effect eq 'flipVert'}
    {load_defer file="modules/Banner_System/lib/js/jquery.cycle2.flip.min.js" type="js"}
  {/if}
  {if $banner.effect eq 'tileSlideVert' or $banner.effect eq 'tileSlideHorz' or $banner.effect eq 'tileBlindVert' or $banner.effect eq 'tileBlindHorz'}
    {load_defer file="modules/Banner_System/lib/js/jquery.cycle2.tile.min.js" type="js"}
  {/if}
{/if}
