{*
a3bd74e6f2f35ff8e940f539239f9f18761bdb4e, v2 (xcart_4_6_4), 2014-06-13 12:20:00, quick_reorder_link.tpl, mixon
vim: set ts=2 sw=2 sts=2 et:
*}

{if $show_quick_reorder_link eq "Y"}
  {if $current_skin eq "books_and_magazines"}
    <td><a href="quick_reorder.php">{$lng.lbl_quick_reorder_customer}</a></td>
  {elseif  $current_skin eq "ideal_comfort"}
    <a href="quick_reorder.php">{$lng.lbl_quick_reorder_customer}</a>
  {else}
    |
    <a href="quick_reorder.php">{$lng.lbl_quick_reorder_customer}</a>
  {/if}
{/if}
