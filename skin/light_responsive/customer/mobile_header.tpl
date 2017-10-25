{*
e9f27ed4484032fad545c067ae29decb031a4f2c, v3 (xcart_4_7_8), 2017-02-13 17:49:17, mobile_header.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<div class="mobile-header" id="mobile-header">
  <ul class="nav nav-pills">

    <li class="dropdown">
      <a id="main-menu-toggle" class="dropdown-toggle" href="#">
        <span class="fa fa-bars"></span>
      </a>
      <div id="main-menu-box" class="dropdown-menu">

        {include file="customer/tabs.tpl" mode="plain_list"}
        {if $all_languages_cnt gt 1 or $active_modules.XMultiCurrency}
          <div class="languages-box">
            {if $all_languages_cnt gt 1}
              <div class="language-label">{$lng.lbl_language}</div>
            {/if}
            {include file="customer/language_selector.tpl"}
            <div class="clearing"></div>
          </div>
        {/if}

      </div>
    </li>

    <li class="dropdown">
      <a id="search-toggle" class="dropdown-toggle" href="#">
        <span class="fa fa-search"></span>
      </a>
      <div id="search-box" class="dropdown-menu">

        {include file="customer/search.tpl"}

      </div>
    </li>

    <li class="dropdown">
      <a id="account-toggle" class="dropdown-toggle" href="#">
        <span class="fa fa-user"></span>
      </a>
      <div id="account-box" class="dropdown-menu">

        {include file="customer/header_links.tpl" mode="plain_list"}

      </div>
    </li>

  </ul>
</div>
