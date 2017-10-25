<div class="landscape-show ac">
  <div class="div-table">
    <div class="table-cell">
	  <img src="{$AltSkinDir}/_images/portrait.png">
	  <p>Best viewed in portrait mode.</p>
	</div>
  </div>
</div>
<div class="mob-navbar-pop">
  <div class="mob-navbar-pop-main">
    
    <div class="mob-navbar">
      <ul>
        <li class="dropdown-sub"><a href="#">Fans <span class="plus-ico">+</span><span class="minus-ico">-</span></a>
        	<div class="mob-menu-sub">
            	<dl>
              {foreach from=$categories_1 item=cat_1 name=cat1}
                <dd><a href="home.php?cat={$cat_1.categoryid}">{$cat_1.category}</a></dd>
              {/foreach}
              </dl>
            </div>
        </li>
        <li class="dropdown-sub"><a href="#">Interior Lighting <span class="plus-ico">+</span><span class="minus-ico">-</span></a>
        	<div class="mob-menu-sub">
            	<dl>
              {foreach from=$categories_2 item=cat_2 name=cat2}
                <dd class="link-nav-c"><a href="javascript:;" rel="{$cat_2.categoryid}">{$cat_2.category} <i class="fa fa-angle-right"></i></a></dd>
              {/foreach}
                <dd><a class="btn btn-gold" href="ChooseYourStyle.html">FIND YOUR STYLE</a></dd>
              </dl>
            </div>
        </li>
        <li class="dropdown-sub"><a href="#">Exterior Lighting <span class="plus-ico">+</span><span class="minus-ico">-</span></a>
        	<div class="mob-menu-sub">
            	<dl>
              {foreach from=$categories_3 item=cat_3 name=cat3}
                <dd class="link-nav-c"><a href="javascript:;" rel="{$cat_3.categoryid}">{$cat_3.category} <i class="fa fa-angle-right"></i></a></dd>
              {/foreach}
                <dd><a class="btn btn-gold" href="ChooseYourStyle.html">FIND YOUR STYLE</a></dd>
              </dl>
            </div>
        </li>
        <li class="dropdown-sub"><a href="#">Brands <span class="plus-ico">+</span><span class="minus-ico">-</span></a>
        	<div class="mob-menu-sub">
            	<dl>
              {foreach from=$categories_4 item=cat_4 name=cat4}
                <dd><a href="home.php?cat={$cat_4.categoryid}">{$cat_4.category}</a></dd>
              {/foreach}
              </dl>
            </div>
        </li>
        <li class="dropdown-sub"><a href="#">Styles <span class="plus-ico">+</span><span class="minus-ico">-</span></a>
        	<div class="mob-menu-sub">
            	<dl>
              {foreach from=$categories_5 item=cat_5 name=cat1}
                <dd><a href="home.php?cat={$cat_5.categoryid}">{$cat_5.category}</a></dd>
              {/foreach}
              </dl>
            </div>
        </li>
        <li class="dropdown-sub"><a href="#">Where to Buy <span class="plus-ico">+</span><span class="minus-ico">-</span></a>
        	<div class="mob-menu-sub">
            	<dl>
                  <dd><a href="WhereToBuy.html">United States Dealers</a></dd>
                  <dd><a href="WhereToBuy-2.html">International Dealers</a></dd>
                </dl>
            </div>
        </li>
        <li><a href="Resources_01.html">RESOURCES</a></li>
        <li><a href="OurStory.html">ABOUT</a></li>
        <li><a href="GetInspired.html">GET INSPIRED</a></li>
        <li><a href="#">Dealer Portal</a></li>
        <li><a href="Compare.html">COMPARE (0)</a></li>     
        <li><a href="Login_SignUp.html">LOGIN</a></li>
      </ul>
    </div>
    {foreach from=$categories_2 item=cat_2 name=cat2}
    <div class="mob-nav-c-{$cat_2.categoryid} mob-nav-c">
      <dl>
        <dt><a href="javascript:;"><i class="fa fa-angle-left"></i> INTERIOR LIGHTING</a></dt>
        <dd><a href="javascript:;">{$cat_2.category|upper}</a></dd>
        {foreach from=$cat_2.sub item=cat_2_sub}
        <dd><a href="home.php?cat={$cat_2_sub.categoryid}">{$cat_2_sub.category}</a></dd>
        {/foreach}
      </dl>
    </div>
    {/foreach}
    {foreach from=$categories_3 item=cat_3 name=cat3}
    <div class="mob-nav-c-{$cat_3.categoryid} mob-nav-c">
      <dl>
        <dt><a href="javascript:;"><i class="fa fa-angle-left"></i> Exterior LIGHTING</a></dt>
        <dd><a href="javascript:;">{$cat_3.category|upper}</a></dd>
        {foreach from=$cat_3.sub item=cat_3_sub}
        <dd><a href="home.php?cat={$cat_3_sub.categoryid}">{$cat_3_sub.category}</a></dd>
        {/foreach}
      </dl>
    </div>
    {/foreach}
    
  </div>
</div>
