{*
579ad584bf6ad014ddfce56e1cb5d88c775e264a, v3 (xcart_4_7_5), 2016-02-08 19:37:48, admin_orders_list.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<tr>
  <td colspan="{$colspan}" align="right">{$lng.lbl_gross_profit}: <b>{if $gross_profit ge 0}{currency value=$gross_profit}{else}{currency value=$gross_profit display_sign=true}{/if}</b></td>
</tr>
