{*
194626627da00f55901e393daa481ee1a5d33cfb, v2 (xcart_4_7_4), 2015-10-26 13:19:01, card_info.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<div class="card-container{if $extra_class} {$extra_class}{/if}">
  <div class="card-icon {$type|lower}"></div>
  <div class="card-info">
    <div class="card-number">{$number}</div>
    <div class="card-expire">{if $expire}{$expire}{else}&nbsp;{/if}</div>
  </div>
</div>
