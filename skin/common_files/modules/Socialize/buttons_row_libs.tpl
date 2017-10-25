{*
31d05b053c8b2d6a8f09d5d78bbc6cf55c44e450, v5 (xcart_4_7_3), 2015-06-25 11:23:00, buttons_row_libs.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{* Facebook *}
{func_soc_tpl_is_fb_plugins_enabled assign=_is_fb_plugins_enabled}
{if $_is_fb_plugins_enabled} {*check $config.Socialize.soc_fb_like_enabled eq "Y" or $config.Socialize.soc_fb_send_enabled eq "Y" and other settings*}
	{capture name="fb_init"}
    (function(d, s, id) {ldelim}
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.async = true;
    js.src = "//connect.facebook.net/{$store_language|@func_get_facebook_lang_code}/sdk.js#xfbml=1&version=v2.3{if $config.Socialize.soc_fb_appid ne ""}&appId={$config.Socialize.soc_fb_appid}{/if}";
    fjs.parentNode.insertBefore(js, fjs);
    {rdelim}(document, 'script', 'facebook-jssdk'));
  {/capture}
  {load_defer file="fb_init" direct_info=$smarty.capture.fb_init type="js"}
{/if}

{* Twitter *}
{if $config.Socialize.soc_tw_enabled eq "Y"}
	{capture name="tw_init"}
    window.twttr = (function(d, s, id) {ldelim}
      var js, fjs = d.getElementsByTagName(s)[0],
        t = window.twttr || {ldelim}{rdelim};
      if (d.getElementById(id)) return t;
      var p=/^http:/.test(d.location) ? 'http' : 'https';
      js = d.createElement(s);
      js.async = true;
      js.id = id;
      js.src = p + "://platform.twitter.com/widgets.js";
      fjs.parentNode.insertBefore(js, fjs);

      t._e = [];
      t.ready = function(f) {ldelim}
        t._e.push(f);
      {rdelim};

      return t;
    {rdelim}(document, "script", "twitter-wjs"));
  {/capture}
  {load_defer file="tw_init" direct_info=$smarty.capture.tw_init type="js"}
{/if}

{* Google+ *}
{if $config.Socialize.soc_ggl_plus_enabled eq "Y"}
  {capture name="ggl_init"}
  {if $store_language eq 'en'}
    window.___gcfg = {ldelim}lang: 'en-US'{rdelim};
  {else}
    window.___gcfg = {ldelim}lang: '{$store_language}'{rdelim};
  {/if}

  (function() {ldelim}
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = '{$current_protocol}://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  {rdelim})();
  {/capture}
  {load_defer file="ggl_init" direct_info=$smarty.capture.ggl_init type="js"}
{/if}
