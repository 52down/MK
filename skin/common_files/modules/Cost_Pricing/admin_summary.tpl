{*
579ad584bf6ad014ddfce56e1cb5d88c775e264a, v3 (xcart_4_7_5), 2016-02-08 19:37:48, admin_summary.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<tr class="{cycle values='SectionBox,TableSubHead'}">
  <td align="right"><b>{$lng.lbl_gross_profit}:</b></td>
  {section name=period loop=$gross_profit}
    <td align="center">{if $gross_profit[period] ge 0}{currency value=$gross_profit[period]}{else}{currency value=$gross_profit[period] display_sign=true}{/if}</td>
  {/section}
</tr>
