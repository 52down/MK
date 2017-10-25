{*

67814c9aec19d6cf932988e3b949b16094b3dab9, v2 (xcart_4_7_4), 2015-10-28 10:53:25, shipping_value_checkbox.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

<script type="text/javascript">
//<![CDATA[
$(document).ready( function() {ldelim}
  // initial ui update
  $('#{$param_prefix}_{$param_name}_line').toggle($('#{$param_prefix}_{$param_name}_checkbox').prop('checked') == true);
  // bind events related ui update
  $('#{$param_prefix}_{$param_name}_checkbox').on('change', function(event){ldelim}
    $('#{$param_prefix}_{$param_name}_line').toggle($(this).prop('checked') == true);
  {rdelim});
{rdelim});
//]]>
</script>

<tr>
  <td width="50%"><b>{$lng_cbx_label}:</b></td>
  <td>
    <input type="checkbox" name="{$param_name}_checkbox" id="{$param_prefix}_{$param_name}_checkbox" {if $shipping_options.$param_prefix.$param_name}checked="checked"{/if} />
  </td>
</tr>

<tr id="{$param_prefix}_{$param_name}_line">
    <td width="50%">
        <b>{$lng_input_label}:</b><br />
        <span class="SmallText">{$lng_input_text}</span>
    </td>
  <td>
    <input type="text" name="{$param_name}" id="{$param_prefix}_{$param_name}" value="{$shipping_options.$param_prefix.$param_name}" />
  </td>
</tr>
