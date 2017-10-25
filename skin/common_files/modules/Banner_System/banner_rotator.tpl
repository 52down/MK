{*
019d82f77d401b781fdab41bfd87c9a8ae6c42be, v9 (xcart_4_7_7), 2017-01-16 21:16:26, banner_rotator.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*} 

<div id="banner-system-{$banner_location}">

  {foreach from=$banners item=banner}

    {if $banner.content ne ''}

      <div class="banner-wrapper">

        {assign var="banner_width" value=$banner.width|default:$config.Banner_System.default_banner_width}
        {assign var="banner_height" value=$banner.height|default:$config.Banner_System.default_banner_height}

        {include file="modules/Banner_System/banner_js_loader.tpl"}
        {include file="modules/Banner_System/banner_rotator_config.tpl" banner_width=$banner_width banner_height=$banner_height assign="banner_rotator_config"}

        <div id="slideshow{$banner.bannerid}" class="banner-system cycle-slideshow" {strip}{$banner_rotator_config}{/strip}>
          {foreach from=$banner.content item=content}
            <div class="slideshow_content_{$content.type}_{$content.id}">
              {if $content.type eq "I"}
                {if $content.url ne ''}<a href="{$content.url|amp}">{/if}<img src="{$content.image_path|amp}" alt="{$content.alt|escape}" />{if $content.url ne ''}</a>{/if}
                {else}
                <div class="content" {if $banner_width and $banner_height}style="width:{$banner_width}px;height:{$banner_height}px;"{/if}>{$content.info}</div>
              {/if}
            </div>
          {/foreach}
        </div>

        {if $banner.nav eq 'Y'}
          <div id="bs-pager-{$banner.bannerid}" class="cycle-pager"></div>
        {/if}
      </div>

    {/if}

  {/foreach}

</div>
