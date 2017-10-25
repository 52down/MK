<div class="home-banner">
  <div class="swiper-container">
    <div class="swiper-wrapper">
    {foreach from=$top_banners item=banner}
    {if $banner.content ne ''}
    {foreach from=$banner.content item=content}
    {if $content.type eq "I"}
    {if $content.url ne ''}<a href="{$content.url|amp}">{/if}<div class="swiper-slide" style="background-image:url({$content.image_path|amp})"></div>{if $content.url ne ''}</a>{/if}
    {else}
      {$content.info}
    {/if}
    {/foreach}
    {/if}
    {/foreach}
    </div>
    <!-- Add Pagination --> 
    <!--<div class="swiper-pagination swiper-pagination-white"></div>--> 
    <!-- Add Arrows -->
    <div class="swiper-button-next swiper-button-black"></div>
    <div class="swiper-button-prev swiper-button-black"></div>
  </div>
  <a class="arrow-link" href="#"><i class="fa fa-angle-down"></i></a> 
</div>
{* 
Id: home_page_banner.tpl,v 1.0.0.0 2012/09/11 16:52:52 joliaj Exp $
vim: set ts=2 sw=2 sts=2 et:

{if $active_modules.Banner_System and $top_banners ne ''}
  {include file="modules/Banner_System/banner_rotator.tpl" banners=$top_banners banner_location='T'}
{elseif $active_modules.Demo_Mode and $active_modules.Banner_System}
  {include file="modules/Demo_Mode/banners.tpl"}
{/if}
*}