{*
65d83ebbc5b4f1ee3191f7b95aa99e680929b075, v2 (xcart_4_7_8), 2017-06-06 17:01:38, prnotice.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{*** NOTE: If you are reselling X-Cart stores, please contact us (http://www.x-cart.com) before changing the Powered-by note here. ***}
{if $main eq "catalog" and $current_category.category eq ""}
  Powered by {if $sm_prnotice_txt ne 'X-Cart'}X-Cart {/if}<a href="https://www.x-cart.com" target="_blank">{$sm_prnotice_txt}</a>
{else}
  Powered by {if $sm_prnotice_txt ne 'X-Cart'}X-Cart {/if}{$sm_prnotice_txt}
{/if}
