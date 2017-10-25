{*
31ff6439a36f6d410a9c62150ccfb0d84fbccc3f, v14 (xcart_4_7_3), 2015-06-25 12:58:12, buttons_row.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

{if ($active_modules.Socialize ne "" and ($detailed or ($matrix and $config.Socialize.soc_plist_matrix eq "Y") or (!$matrix and $config.Socialize.soc_plist_plain eq "Y"))) and (!$ie_ver or $ie_ver gt 6)}

  {func_soc_tpl_is_fb_plugins_enabled assign=_is_fb_plugins_enabled} {*check $config.Socialize.soc_fb_like_enabled eq "Y" or $config.Socialize.soc_fb_send_enabled eq "Y" and other settings*}
  {if $_is_fb_plugins_enabled or $config.Socialize.soc_tw_enabled eq "Y" or $config.Socialize.soc_ggl_plus_enabled eq "Y"}
    {include file="modules/Socialize/buttons_row_libs.tpl" _include_once=1}
  {/if}

  <div class="{if !$matrix}buttons-row {/if}soc-buttons-row">

    {func_soc_tpl_get_canonical_url assign=href counturl=shared_counturl productid=$product.productid canonical_url=$canonical_url is_product_page=$detailed}

    {if $smarty.get.block eq 'buy_now' or $smarty.get.block eq 'product_details'}
      {assign var="ajax_result" value=true}
    {/if}

    {* Facebook like *}
    {if $config.Socialize.soc_fb_like_enabled eq "Y"}
      <div class="soc-item{if $matrix} top-margin-2{/if}">
        <div class="fb-like" data-href="{$href}" data-share="{if $config.Socialize.soc_fb_send_enabled eq "Y"}true{else}false{/if}" data-layout="{if $matrix}box_count{else}button_count{/if}" data-show-faces="false"></div>
        {if $ajax_result}
          <script type="text/javascript">
            //<![CDATA[
            if (typeof(FB) != 'undefined') {ldelim} FB.XFBML.parse(); {rdelim}
            //]]>
          </script>
        {/if}
      </div>
    {/if}

    {* Facebook send *}
    {if $config.Socialize.soc_fb_like_enabled eq "N" && $config.Socialize.soc_fb_send_enabled eq "Y"}
      <div class="soc-item{if $matrix} top-margin-42{/if}">
          <div class="fb-send" data-href="{$href}"></div>
          {if $ajax_result}
            <script type="text/javascript">
              //<![CDATA[
              if (typeof(FB) != 'undefined') {ldelim} FB.XFBML.parse(); {rdelim}
              //]]>
            </script>
          {/if}
      </div>
    {/if}

    {* Twitter *}
    {if $config.Socialize.soc_tw_enabled eq "Y"}
      <div class="soc-item{if $matrix} top-margin-2{/if}">

        <a href="https://twitter.com/share" class="twitter-share-button" data-url="{$href}" data-counturl="{$shared_counturl}" data-count="{if $matrix}vertical{else}horizontal{/if}"{if $config.Socialize.soc_tw_user_name} data-via="{$config.Socialize.soc_tw_user_name}"{/if}>{$lng.lbl_soc_tweet}</a>

        {if $ajax_result}
        <script type="text/javascript">
          //<![CDATA[
          if (typeof(twttr) != 'undefined') {ldelim} twttr.widgets.load(); {rdelim}
          //]]>
        </script>
        {/if}

      </div>
      {if $matrix && $config.Socialize.soc_pin_enabled eq "Y" && $config.Socialize.soc_ggl_plus_enabled eq "Y"}
        <div class="clearing"></div>
      {/if}
    {/if}

    {* Google+ *}
    {if $config.Socialize.soc_ggl_plus_enabled eq "Y"}
      <div class="soc-item{if $matrix} top-margin-2{/if}">
        
        <div class="g-plusone" data-size="{if $matrix}tall{else}medium{/if}" data-href="{$shared_counturl}"></div>
        {if $ajax_result}
            <script type="text/javascript">
              //<![CDATA[
              if (typeof(gapi) != 'undefined') {ldelim} gapi.plusone.go(); {rdelim}
              //]]>
            </script>
        {/if}

      </div>
    {/if}

    {if $config.Socialize.soc_pin_enabled eq "Y"}
      <div class="soc-item{if $matrix} top-margin-5{/if}">

        {assign var="image_url" value=$product.image_url|default:$product.tmbn_url}
        {assign var="descr" value=$product.descr}

        <a href="http://pinterest.com/pin/create/button/?url={$href|escape:"url"}&media={$image_url|escape:"url"}&description={$descr|strip|escape:"url"|truncate:$smarty.const.XC_SOC_PIN_MAX_DESCR}" class="pin-it-button" count-layout="{if $matrix}vertical{else}horizontal{/if}">{$lng.lbl_soc_pin_it}</a>

        {if $ajax_result}
          <script type="text/javascript">
            //<![CDATA[
            pin_it();
            //]]>
          </script>
        {/if}
      </div>
    {/if}

    <div class="clearing"></div>
  </div>
  <div class="clearing"></div>

{/if}
