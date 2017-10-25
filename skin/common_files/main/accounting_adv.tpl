{*
efa6fc2f8b96d3b5782783e7b1dc8b653ddca823, v5 (xcart_4_7_8), 2017-05-18 17:43:39, accounting_adv.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

{capture name=dialog}

  <h1 class="title" id="page-title" >Accounting</h1>
  <div class="accounting-page-wrapper">
    <div class="description">
      <p>Choose your accounting system below and configure it.</p>
      <p>Not seeing your accounting software here? <a href="http://ideas.x-cart.com/forums/32109-x-cart-classic-4-x?utm_source=xcart&amp;utm_medium=help_menu_link&amp;utm_campaign=help_menu" target="_blank">Let us know</a></p>
    </div>

    <div class="available-block">
      <ul class="available-block-list">
        <li>
          <a href="//market.x-cart.com/go/xc4Goldplus/Unify%20for%20Quickbooks?utm_source=xcart&amp;utm_medium=help_menu_link&amp;utm_campaign=help_menu" class="marketplace-search" target="_blank">
            <img src="{$ImagesDir}/adv/accounting/qb_logo.jpg" alt="QuickBooks" />
            <span class="link-wrapper">QuickBooks</span>
          </a>
        </li>
        <li>
          <a href="//market.x-cart.com/go/xc4Goldplus/Unify%20for%20Xero?utm_source=xcart&amp;utm_medium=help_menu_link&amp;utm_campaign=help_menu" class="marketplace-search" target="_blank">
            <img src="{$ImagesDir}/adv/accounting/xero_logo.jpg" alt="Xero integration" />
            <span class="link-wrapper">Xero integration</span>
          </a>
        </li>
        <li>
          <a href="orders.php" class="marketplace-search">
            <img src="{$ImagesDir}/adv/accounting/export.jpg" alt="Export orders" />
            <span class="link-wrapper">Export orders</span>
          </a>
        </li>
      </ul>
    </div>
  </div>

{/capture}
{include file="dialog.tpl" content=$smarty.capture.dialog extra='width="100%"'}
