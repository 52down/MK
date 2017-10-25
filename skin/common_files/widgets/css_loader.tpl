{*
f796cd4ac105eb160691c59c49e70773bd16b2d8, v5 (xcart_4_7_7), 2016-09-01 16:39:33, css_loader.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}

{*
  Supported params:

    $css - css file name
    $eltype - { link, style } default link
*}

{if $css ne ''}
<script type="text/javascript">//<![CDATA[
  if (typeof xc_load_css !== 'undefined') {
    xc_load_css('{$SkinDir}/{$css}', '{$eltype|default:"link"}');
  }
//]]></script>
{/if}
