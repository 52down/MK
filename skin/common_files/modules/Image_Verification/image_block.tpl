{*
59087bdf11016e629fc50f7bf042a2bc6fdb7855, v5 (xcart_4_7_6), 2016-05-20 17:25:27, image_block.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<div class="iv-img">
	<img src="{$xcart_web_dir}/antibot_image.php?section={$id}&amp;rnd={"1"|mt_rand:10000}" id="{$id}" alt="" /><br />
{if $is_ajax_request eq "Y"}
<a href="javascript:void(0);" onclick="javascript: change_antibot_image('{$id}');" tabindex="-1">{$lng.lbl_get_a_different_code|wm_remove|escape:javascript}</a>
{else}
<script type="text/javascript">
//<![CDATA[
document.write('<'+'a href="javascript:void(0);" onclick="javascript: change_antibot_image(\'{$id}\');" tabindex="-1">{$lng.lbl_get_a_different_code|wm_remove|escape:javascript}<'+'/a>');
//]]>
</script>
{/if}
</div>
{if !$nobr}<br />{/if}
