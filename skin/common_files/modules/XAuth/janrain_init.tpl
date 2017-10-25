{*
aad85f2be3e7abf71f38a7de369cbd6188fe4f3b, v2 (xcart_4_7_0), 2015-02-11 09:38:53, janrain_init.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{literal}
<script type="text/javascript">
//<![CDATA[

(function() {
  if (typeof window.janrain !== 'object') {
    window.janrain = {};
  }

  if (typeof window.janrain.settings !== 'object') {
    window.janrain.settings = {};
  }
 
{/literal}
  janrain.settings.tokenUrl = '{$xauth_rpc_token_url_noencode}';

  janrain.settings.language = '{xauth_rpx_get_language}';

  if (document.location.protocol === 'https:') {ldelim}
    var janrain_widget_src = 'https://rpxnow.com/js/lib/{$config.XAuth.xauth_rpx_app_name}/engage.js';

  {rdelim} else {ldelim}

    var janrain_widget_src = 'http://widget-cdn.rpxnow.com/js/lib/{$config.XAuth.xauth_rpx_app_name}/engage.js';
  {rdelim}
{literal}

  function isReady() { 
    janrain.ready = true; 
  };

  if (document.addEventListener) {
    document.addEventListener("DOMContentLoaded", isReady, false);

  } else {
    window.attachEvent('onload', isReady);
  }

  var e = document.createElement('script');
  e.type = 'text/javascript';
  e.id = 'janrainAuthWidget';

  e.src = janrain_widget_src;

  var s = document.getElementsByTagName('script')[0];
  s.parentNode.insertBefore(e, s);

})();

//]]>
</script>
{/literal}
