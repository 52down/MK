{*
0ed76b6c3521b2e57cf9017603afc95e7064e102, v4 (xcart_4_7_5), 2016-02-01 10:03:13, check_clean_url.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<script type="text/javascript">
//<![CDATA[
var err_clean_url_wrong_format = "{$lng.err_clean_url_wrong_format|wm_remove|escape:javascript|replace:"\n":" "|replace:"\r":" "}";
var clean_url_validation_regexp = new RegExp("{$clean_url_validation_regexp|wm_remove|escape:javascript}", "g");
var js_clean_urls_lowercase = {if $config.SEO.clean_urls_lowercase eq 'Y'}true{else}false{/if};
//]]>
</script>
<script type="text/javascript" src="{$SkinDir}/js/check_clean_url.js"></script>
