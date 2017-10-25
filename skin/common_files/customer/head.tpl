{*
4fc98c3f9332e2c5adff5caa54e8f9238a7d113e, v4 (xcart_4_7_7), 2016-09-05 13:13:58, head.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}
<div class="line1">
  <div class="logo">
    <a href="{$catalogs.customer}/home.php"><img src="{$ImagesDir}/xlogo.gif" alt="{$config.Company.company_name}" /></a>
  </div>

  {include file="customer/tabs.tpl"}

  {include file="customer/phones.tpl"}

</div>

<div class="line2">
  {if ($main ne 'cart' or $cart_empty) and $main ne 'checkout'}

    {include file="customer/search.tpl"}

    {include file="customer/language_selector.tpl"}

  {elseif $checkout_module ne 'Amazon_Payments_Advanced'}

    {include file="modules/`$checkout_module`/head.tpl"}

  {/if}
</div>

{include file="customer/noscript.tpl"}
