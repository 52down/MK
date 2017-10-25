{*
141c878b03b2b0cdd5d2b31c952f4e1031962148, v11 (xcart_4_7_8), 2017-05-18 15:44:49, service_body_js.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{* segment_compatible from xcart_4_6_3 *}

{if $amazon_enabled}
    <script type="text/javascript" src="{$amazon_widget_url}"></script>
{/if}

{if $active_modules.Amazon_Payments_Advanced}
  {include file="modules/Amazon_Payments_Advanced/service_body.tpl"}
{/if}

{if $active_modules.Google_Analytics
  and $config.Google_Analytics.ganalytics_version eq 'Asynchronous'}
  {*The first part is loaded in modules/Google_Analytics/ga_code_async.tpl*}
  {capture name=ga_code_async_js_part2}
    (function() {ldelim}
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    {rdelim})();
  {/capture}
  {load_defer file="ga_code_async_js_part2" direct_info=$smarty.capture.ga_code_async_js_part2 type="js"}
{/if}

{if $active_modules.Segment ne '' and $smarty.cookies.is_robot ne 'Y'}
  {include file="modules/Segment/analytics_body_js.tpl"}
{/if}

{if $active_modules.Facebook_Ecommerce ne '' and $smarty.cookies.is_robot ne 'Y'}
  {include file="modules/Facebook_Ecommerce/ad_events_body.tpl"}
{/if}
