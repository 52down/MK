{*
4fc98c3f9332e2c5adff5caa54e8f9238a7d113e, v4 (xcart_4_7_7), 2016-09-05 13:13:58, head.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
<div class="line1">
  <div class="logo"> <a href="{$catalogs.customer}/home.php"><img src="{$ImagesDir}/xlogo.gif" alt="{$config.Company.company_name}" /></a> </div>
  {include file="customer/tabs.tpl"}
  
  {include file="customer/phones.tpl"} </div>
<div class="line2"> {if ($main ne 'cart' or $cart_empty) and $main ne 'checkout'}
  
  {include file="customer/search.tpl"}
  
  {include file="customer/language_selector.tpl"}
  
  {elseif $checkout_module ne 'Amazon_Payments_Advanced'}
  
  {include file="modules/`$checkout_module`/head.tpl"}
  
  {/if} </div>
*}
<header id="header">
  <div class="header-top">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-6 col-sm-3">
          <p>dealer portal</p>
        </div>
        <div class="col-xs-6 col-sm-9 ar">
          <ul>
            <li><a href="GetInspired.html">GET INSPIRED</a></li>
            <li><a href="OurStory.html">ABOUT</a></li>
            <li><a href="Resources_01.html">RESOURCES</a></li>
            <li class="header-top-dropdown-link"><a href="WhereToBuy.html">Where to Buy</a>
              <div class="header-top-dropdown">
                <dl>
                  <dd><a href="WhereToBuy.html">United States Dealers</a></dd>
                  <dd><a href="WhereToBuy-2.html">International Dealers</a></dd>
                </dl>
              </div>
            </li>
            <li><a href="Compare.html">COMPARE (0)</a></li>
            <li><a href="Login_SignUp.html">LOGIN</a></li>
            <li class="question-mark-link"><a href="javascript:;"><span class="question-mark">?</span></a>
              <div class="question-mark-dropdown">
                <dl>
                  <dd><i class="fa fa-comment-o"></i> <strong>Live Chat</strong><br>
                    Start a chat session. Our experts are here to help</dd>
                  <dd><i class="fa fa-envelope-o"></i> <strong>Email</strong><br>
                    sales@minkagroup.net</dd>
                  <dd><i class="fa fa-phone"></i> <strong>Phone</strong> (951) 735-9220<br>
                    <strong>Toll Free</strong> 1 (800) 221-7977<br>
                    <strong>Customer Care Hours</strong><br>
                    M - F 6am - 5pm PST</dd>
                  <dd><i class="fa fa-question-circle"></i> <strong>FAQ</strong><br>
                    View our most common questions.</dd>
                </dl>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="pc-header">
    <div class="header-main">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12 col-logo">
            <div class="pc-logo"><a class="" href="{$catalogs.customer}/"><img src="{$AltSkinDir}/_images/logo.png" alt="{$config.Company.company_name}" /></a></div>
          </div>
          <div class="col-xs-12 col-menu">
            <ul>
              <li class="dropdown-nav"><a href="javascript:;">FANS</a>
                <div class="dropdown-menu-sub first">
                  <div class="clears">
                    <dl class="fl">
                  	{foreach from=$categories_1 item=cat_1 name=cat1}
                    	{if $smarty.foreach.cat1.index eq $half_1}
                    </dl>
                    <dl class="fl">
                      <dd><a href="home.php?cat={$cat_1.categoryid}">{$cat_1.category}</a></dd>
                      {else}
                      <dd><a href="home.php?cat={$cat_1.categoryid}">{$cat_1.category}</a></dd>
                      {/if}
                    {/foreach}
                    </dl>
                  </div>
                  <dl class="width-2">
                    <dd><a class="btn btn-gold" href="ChooseTheRightFan.html">CHOOSING THE RIGHT CEILING FAN</a></dd>
                  </dl>
                </div>
              </li>
              <li class="dropdown-nav"><a href="javascript:;">INTERIOR LIGHTING</a>
                <div class="dropdown-menu-sub">
                  <dl>
                  	{foreach from=$categories_2 item=cat_2 name=cat2}
                    <dd><a href="javascript:;">{$cat_2.category}</a>
                      <div class="dropdown-menu-3 second">
                        <ol>
                        {foreach from=$cat_2.sub item=cat_2_sub name=cat_2_sub}
                        {if $smarty.foreach.cat_2_sub.index eq 7}
                        </ol>
                        <ol>
                          <li><a href="home.php?cat={$cat_2_sub.categoryid}">{$cat_2_sub.category}</a></li>
                        {else}
                          <li><a href="home.php?cat={$cat_2_sub.categoryid}">{$cat_2_sub.category}</a></li>
                        {/if}
                        {/foreach}
                        </ol>
                      </div>
                    </dd>
                    {/foreach}
                    <dd><a class="btn btn-gold" href="ChooseYourStyle.html">FIND YOUR STYLE</a></dd>
                  </dl>
                </div>
              </li>
              <li class="dropdown-nav"><a href="javascript:;">EXTERIOR LIGHTING</a>
                <div class="dropdown-menu-sub">
                  <dl>
                  	{foreach from=$categories_3 item=cat_3 name=cat3}
                    <dd><a href="javascript:;">{$cat_3.category}</a>
                      <div class="dropdown-menu-3">
                        <ol>
                        {foreach from=$cat_3.sub item=cat_3_sub name=cat_3_sub}
                          <li><a href="home.php?cat={$cat_2_sub.categoryid}">{$cat_3_sub.category}</a></li>
                        {/foreach}
                        </ol>
                      </div>
                    </dd>
                    {/foreach}
                    <dd><a class="btn btn-gold" href="ChooseYourStyle.html">FIND YOUR STYLE</a></dd>
                  </dl>
                </div>
              </li>
              <li class="dropdown-nav"><a href="javascript:;">BRANDS</a>
                <div class="dropdown-menu-sub">
                  <dl>
                  {foreach from=$categories_4 item=cat_4 name=cat4}
                    <dd><a href="home.php?cat={$cat_4.categoryid}">{$cat_4.category}</a></dd>
                  {/foreach}
                  </dl>
                </div>
              </li>
              <li class="dropdown-nav"><a href="javascript:;">STYLES</a>
                <div class="dropdown-menu-sub">
                  <dl>
                  {foreach from=$categories_5 item=cat_5 name=cat5}
                    <dd><a href="home.php?cat={$cat_5.categoryid}">{$cat_5.category}</a></dd>
                  {/foreach}
                  </dl>
                </div>
              </li>
              <li class="search-link-li"><a class="search-link" href="#">
                <div class="icon icon-search"></div>
                </a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="pc-search">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12">
            <form method="post" action="search.php" name="productsearchform">
        
              <input type="hidden" name="simple_search" value="Y" />
              <input type="hidden" name="mode" value="search" />
              <input type="hidden" name="posted_data[by_title]" value="Y" />
              <input type="hidden" name="posted_data[by_descr]" value="Y" />
              <input type="hidden" name="posted_data[by_sku]" value="Y" />
              <input type="hidden" name="posted_data[search_in_subcategories]" value="Y" />
              <input type="hidden" name="posted_data[including]" value="all" />
              <input type="search" placeholder="SEARCH" name="posted_data[substring]" value="{$search_prefilled.substring}" class="form-control substring">
              <button type="submit" class="btn btn-default">
              <div class="icon icon-search"></div>
              </button>
              <a href="#" class="search-close"> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="mob-menu">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-link "> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
          <a class="navbar-brand logo" href="index.html"><img src="{$AltSkinDir}/_images/logo.png"></a> <!--<a class="mob-user-circle-btn" href="#"><i class="fa fa-heart"></i></a>--> <a class="mob-search-btn" href="#">
          <div class="icon icon-search"></div>
          <div class="mob-search-icon"><span class="line-bar"></span><span class="line-bar"></span></div>
          </a> </div>
        <form class="navbar-form navbar-right" role="form" method="post" action="search.php" name="productsearchform">
    
          <input type="hidden" name="simple_search" value="Y" />
          <input type="hidden" name="mode" value="search" />
          <input type="hidden" name="posted_data[by_title]" value="Y" />
          <input type="hidden" name="posted_data[by_descr]" value="Y" />
          <input type="hidden" name="posted_data[by_sku]" value="Y" />
          <input type="hidden" name="posted_data[search_in_subcategories]" value="Y" />
          <input type="hidden" name="posted_data[including]" value="all" />
          <div class="form-group">
            <input type="search" placeholder="SEARCH" name="posted_data[substring]" value="{$search_prefilled.substring}" class="form-control substring">
          </div>
          <button type="submit" class="btn btn-default">
          <div class="icon icon-search"></div>
          </button>
        </form>
        
        <!--/.nav-collapse --> 
      </div>
      <!--/.container-fluid --> 
    </nav>
  </div>
</header>
<div class="nav-dropdown">
  <div class="container-fluid">
    <div class="nav-dropdown-main">
      <div class="row" id="nav-1">
        <div class="col-xs-12 ac"> <img src="{$AltSkinDir}/_images/Navigation-bg-01.jpg"> </div>
      </div>
      <div class="row" id="nav-2">
        <div class="col-xs-12 ac"> <img src="{$AltSkinDir}/_images/Navigation-bg-02.jpg"> </div>
      </div>
      <div class="row" id="nav-3">
        <div class="col-xs-12 ac"> <img src="{$AltSkinDir}/_images/Navigation-bg-03.jpg"> </div>
      </div>
      <div class="row" id="nav-4">
        <div class="col-xs-12 ac"> <img src="{$AltSkinDir}/_images/Navigation-bg-04.jpg"> </div>
      </div>
      <div class="row" id="nav-5">
        <div class="col-xs-12 ac"> <img src="{$AltSkinDir}/_images/Navigation-bg-05.jpg"> </div>
      </div>
    </div>
  </div>
</div>
{include file="customer/noscript.tpl"} 