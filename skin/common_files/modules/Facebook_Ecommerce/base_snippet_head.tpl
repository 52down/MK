{*
141c878b03b2b0cdd5d2b31c952f4e1031962148, v1 (xcart_4_7_8), 2017-05-18 15:44:49, base_snippet_head.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<!-- Facebook Pixel Code -->
<script type="text/javascript">
//<![CDATA[
{literal}
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','//connect.facebook.net/en_US/fbevents.js');
{/literal}
fbq('init', '{$config.Facebook_Ecommerce.facebook_ecomm_pixel_id|escape:"javascript"}'); // Insert your pixel ID here.
fbq('track', 'PageView');

//]]>
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={$config.Facebook_Ecommerce.facebook_ecomm_pixel_id|escape:"html"}&amp;ev=PageView&amp;noscript=1"/></noscript>
<!-- End Facebook Pixel Code -->
