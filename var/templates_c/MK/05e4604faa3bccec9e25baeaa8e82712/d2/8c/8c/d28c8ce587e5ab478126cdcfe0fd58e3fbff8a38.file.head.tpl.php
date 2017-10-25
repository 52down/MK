<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 09:48:25
         compiled from "D:\website\MK\skin\MK\customer\head.tpl" */ ?>
<?php /*%%SmartyHeaderCode:340859ec4d4996ea52-06466919%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd28c8ce587e5ab478126cdcfe0fd58e3fbff8a38' => 
    array (
      0 => 'D:\\website\\MK\\skin\\MK\\customer\\head.tpl',
      1 => 1508654915,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '340859ec4d4996ea52-06466919',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'catalogs' => 0,
    'AltSkinDir' => 0,
    'config' => 0,
    'categories_1' => 0,
    'half_1' => 0,
    'cat_1' => 0,
    'categories_2' => 0,
    'cat_2' => 0,
    'cat_2_sub' => 0,
    'categories_3' => 0,
    'cat_3' => 0,
    'cat_3_sub' => 0,
    'categories_4' => 0,
    'cat_4' => 0,
    'categories_5' => 0,
    'cat_5' => 0,
    'search_prefilled' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec4d4998e3b3_03593824',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec4d4998e3b3_03593824')) {function content_59ec4d4998e3b3_03593824($_smarty_tpl) {?>
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
            <div class="pc-logo"><a class="" href="<?php echo $_smarty_tpl->tpl_vars['catalogs']->value['customer'];?>
/"><img src="<?php echo $_smarty_tpl->tpl_vars['AltSkinDir']->value;?>
/_images/logo.png" alt="<?php echo $_smarty_tpl->tpl_vars['config']->value['Company']['company_name'];?>
" /></a></div>
          </div>
          <div class="col-xs-12 col-menu">
            <ul>
              <li class="dropdown-nav"><a href="javascript:;">FANS</a>
                <div class="dropdown-menu-sub first">
                  <div class="clears">
                    <dl class="fl">
                  	<?php  $_smarty_tpl->tpl_vars['cat_1'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat_1']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories_1']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['cat1']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['cat_1']->key => $_smarty_tpl->tpl_vars['cat_1']->value) {
$_smarty_tpl->tpl_vars['cat_1']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['cat1']['index']++;
?>
                    	<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['cat1']['index']==$_smarty_tpl->tpl_vars['half_1']->value) {?>
                    </dl>
                    <dl class="fl">
                      <dd><a href="home.php?cat=<?php echo $_smarty_tpl->tpl_vars['cat_1']->value['categoryid'];?>
"><?php echo $_smarty_tpl->tpl_vars['cat_1']->value['category'];?>
</a></dd>
                      <?php } else { ?>
                      <dd><a href="home.php?cat=<?php echo $_smarty_tpl->tpl_vars['cat_1']->value['categoryid'];?>
"><?php echo $_smarty_tpl->tpl_vars['cat_1']->value['category'];?>
</a></dd>
                      <?php }?>
                    <?php } ?>
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
                  	<?php  $_smarty_tpl->tpl_vars['cat_2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat_2']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories_2']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat_2']->key => $_smarty_tpl->tpl_vars['cat_2']->value) {
$_smarty_tpl->tpl_vars['cat_2']->_loop = true;
?>
                    <dd><a href="javascript:;"><?php echo $_smarty_tpl->tpl_vars['cat_2']->value['category'];?>
</a>
                      <div class="dropdown-menu-3 second">
                        <ol>
                        <?php  $_smarty_tpl->tpl_vars['cat_2_sub'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat_2_sub']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cat_2']->value['sub']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['cat_2_sub']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['cat_2_sub']->key => $_smarty_tpl->tpl_vars['cat_2_sub']->value) {
$_smarty_tpl->tpl_vars['cat_2_sub']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['cat_2_sub']['index']++;
?>
                        <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['cat_2_sub']['index']==7) {?>
                        </ol>
                        <ol>
                          <li><a href="<?php echo $_smarty_tpl->tpl_vars['cat_2_sub']->value['categoryid'];?>
"><?php echo $_smarty_tpl->tpl_vars['cat_2_sub']->value['category'];?>
</a></li>
                        <?php } else { ?>
                          <li><a href="<?php echo $_smarty_tpl->tpl_vars['cat_2_sub']->value['categoryid'];?>
"><?php echo $_smarty_tpl->tpl_vars['cat_2_sub']->value['category'];?>
</a></li>
                        <?php }?>
                        <?php } ?>
                        </ol>
                      </div>
                    </dd>
                    <?php } ?>
                    <dd><a class="btn btn-gold" href="ChooseYourStyle.html">FIND YOUR STYLE</a></dd>
                  </dl>
                </div>
              </li>
              <li class="dropdown-nav"><a href="javascript:;">EXTERIOR LIGHTING</a>
                <div class="dropdown-menu-sub">
                  <dl>
                  	<?php  $_smarty_tpl->tpl_vars['cat_3'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat_3']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories_3']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat_3']->key => $_smarty_tpl->tpl_vars['cat_3']->value) {
$_smarty_tpl->tpl_vars['cat_3']->_loop = true;
?>
                    <dd><a href="javascript:;"><?php echo $_smarty_tpl->tpl_vars['cat_3']->value['category'];?>
</a>
                      <div class="dropdown-menu-3">
                        <ol>
                        <?php  $_smarty_tpl->tpl_vars['cat_3_sub'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat_3_sub']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cat_3']->value['sub']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat_3_sub']->key => $_smarty_tpl->tpl_vars['cat_3_sub']->value) {
$_smarty_tpl->tpl_vars['cat_3_sub']->_loop = true;
?>
                          <li><a href="<?php echo $_smarty_tpl->tpl_vars['cat_2_sub']->value['categoryid'];?>
"><?php echo $_smarty_tpl->tpl_vars['cat_3_sub']->value['category'];?>
</a></li>
                        <?php } ?>
                        </ol>
                      </div>
                    </dd>
                    <?php } ?>
                    <dd><a class="btn btn-gold" href="ChooseYourStyle.html">FIND YOUR STYLE</a></dd>
                  </dl>
                </div>
              </li>
              <li class="dropdown-nav"><a href="javascript:;">BRANDS</a>
                <div class="dropdown-menu-sub">
                  <dl>
                  <?php  $_smarty_tpl->tpl_vars['cat_4'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat_4']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories_4']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat_4']->key => $_smarty_tpl->tpl_vars['cat_4']->value) {
$_smarty_tpl->tpl_vars['cat_4']->_loop = true;
?>
                    <dd><a href="home.php?cat=<?php echo $_smarty_tpl->tpl_vars['cat_4']->value['categoryid'];?>
"><?php echo $_smarty_tpl->tpl_vars['cat_4']->value['category'];?>
</a></dd>
                  <?php } ?>
                  </dl>
                </div>
              </li>
              <li class="dropdown-nav"><a href="javascript:;">STYLES</a>
                <div class="dropdown-menu-sub">
                  <dl>
                  <?php  $_smarty_tpl->tpl_vars['cat_5'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat_5']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories_5']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat_5']->key => $_smarty_tpl->tpl_vars['cat_5']->value) {
$_smarty_tpl->tpl_vars['cat_5']->_loop = true;
?>
                    <dd><a href="home.php?cat=<?php echo $_smarty_tpl->tpl_vars['cat_5']->value['categoryid'];?>
"><?php echo $_smarty_tpl->tpl_vars['cat_5']->value['category'];?>
</a></dd>
                  <?php } ?>
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
              <input type="search" placeholder="SEARCH" name="posted_data[substring]" value="<?php echo $_smarty_tpl->tpl_vars['search_prefilled']->value['substring'];?>
" class="form-control">
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
          <a class="navbar-brand logo" href="index.html"><img src="<?php echo $_smarty_tpl->tpl_vars['AltSkinDir']->value;?>
/_images/logo.png"></a> <!--<a class="mob-user-circle-btn" href="#"><i class="fa fa-heart"></i></a>--> <a class="mob-search-btn" href="#">
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
            <input type="search" placeholder="SEARCH" name="posted_data[substring]" value="<?php echo $_smarty_tpl->tpl_vars['search_prefilled']->value['substring'];?>
" class="form-control">
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
        <div class="col-xs-12 ac"> <img src="<?php echo $_smarty_tpl->tpl_vars['AltSkinDir']->value;?>
/_images/Navigation-bg-01.jpg"> </div>
      </div>
      <div class="row" id="nav-2">
        <div class="col-xs-12 ac"> <img src="<?php echo $_smarty_tpl->tpl_vars['AltSkinDir']->value;?>
/_images/Navigation-bg-02.jpg"> </div>
      </div>
      <div class="row" id="nav-3">
        <div class="col-xs-12 ac"> <img src="<?php echo $_smarty_tpl->tpl_vars['AltSkinDir']->value;?>
/_images/Navigation-bg-03.jpg"> </div>
      </div>
      <div class="row" id="nav-4">
        <div class="col-xs-12 ac"> <img src="<?php echo $_smarty_tpl->tpl_vars['AltSkinDir']->value;?>
/_images/Navigation-bg-04.jpg"> </div>
      </div>
      <div class="row" id="nav-5">
        <div class="col-xs-12 ac"> <img src="<?php echo $_smarty_tpl->tpl_vars['AltSkinDir']->value;?>
/_images/Navigation-bg-05.jpg"> </div>
      </div>
    </div>
  </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("customer/noscript.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <?php }} ?>
