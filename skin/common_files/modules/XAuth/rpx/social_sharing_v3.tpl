{*
6f3a4d822a325647af97aa302b1748156d5f0de0, v2 (xcart_4_7_4), 2015-10-23 18:53:39, social_sharing_v3.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $xauth_social_sharing_enabled_providers}
<script type="text/javascript">
//<![CDATA[
  if (typeof window.janrain !== 'object') window.janrain = {};
  if (typeof window.janrain.settings !== 'object') window.janrain.settings = {};

  janrain.settings.social = {
    providers: [
    {foreach from=$xauth_social_sharing_enabled_providers item='provider'}
      "{$provider|escape:javascript}",
    {/foreach}
    ]
  };

  janrain.settings.appUrl = "{$config.XAuth.xauth_rpx_app_domain|escape:javascript}";

  (function() {
    var e = document.createElement('script');
    e.type = 'text/javascript';
    e.id = 'janrainWidgets';

    if (document.location.protocol === 'https:') {
      e.src = 'https://cdn-social.janrain.com/social/janrain-social.min.js';
    } else {
      e.src = 'http://cdn-social.janrain.com/social/janrain-social.min.js';
    }

    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(e, s);
  })();
//]]>
</script>
{/if}
