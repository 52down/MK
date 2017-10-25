{*
5cc5854600293293a69fd76f7a5ffdbe7a9bbccb, v3 (xcart_4_7_4), 2015-08-31 16:58:21, product.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{foreach from=$extra_fields item=v}
  {if $v.active eq 'Y' and $v.is_value eq 'Y'}
    <tr id="pef-box-{$v.fieldid}"{if $v.field_value eq ""} class="hidden"{/if}>
      <td class="property-name property-name2">{$v.field}</td>
      <td class="property-value" colspan="2">{$v.field_value}</td>
    </tr>
  {/if}
{/foreach}
