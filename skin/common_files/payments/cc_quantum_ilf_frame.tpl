{*
d638e1485d77852def028bd58a4a7afd1cc6f5a4, v3 (xcart_4_7_3), 2015-06-13 15:54:03, cc_quantum_ilf_frame.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

{if $config.Adaptives.screen_x gt 0}
  {math equation="min(max(x,min_allowed),max_allowed)" x=$config.Adaptives.screen_x min_allowed=320 max_allowed=800 assign=_calculated_width}
{else}
  {assign var="_calculated_width" value=800}
{/if}

{include file='payments/iframe_common.tpl' iframe_src=$ilf_src cancel_url=$cancel_url height='500' width=$_calculated_width}

<script type="text/javascript">
//<![CDATA[
{literal}
function refreshSession(k, ip) {
	if (!k || !ip)
		return false;

  var post_url = 'cc_quantum_ilf.php?frame_refresh=' + Math.random();

  var data = {
    ip: ip,
    k: k
  };

	var request = {
    type: 'POST',
    url: post_url,
    data: data
  };

	return ajax.query.add(request)
}
{/literal}

setInterval("refreshSession('{$ilf_key}', '{$ilf_ip}')", 20000);
//]]>
</script>
