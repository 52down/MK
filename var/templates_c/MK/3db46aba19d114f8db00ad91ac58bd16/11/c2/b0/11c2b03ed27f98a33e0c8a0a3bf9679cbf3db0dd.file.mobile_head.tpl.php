<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:11:20
         compiled from "D:\website\MK\skin\MK\customer\mobile_head.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1222059ec52a87a0b75-29934896%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '11c2b03ed27f98a33e0c8a0a3bf9679cbf3db0dd' => 
    array (
      0 => 'D:\\website\\MK\\skin\\MK\\customer\\mobile_head.tpl',
      1 => 1508648194,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1222059ec52a87a0b75-29934896',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'AltSkinDir' => 0,
    'categories_1' => 0,
    'cat_1' => 0,
    'categories_2' => 0,
    'cat_2' => 0,
    'categories_3' => 0,
    'cat_3' => 0,
    'categories_4' => 0,
    'cat_4' => 0,
    'categories_5' => 0,
    'cat_5' => 0,
    'cat_2_sub' => 0,
    'cat_3_sub' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec52a87b4435_85087848',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec52a87b4435_85087848')) {function content_59ec52a87b4435_85087848($_smarty_tpl) {?><div class="landscape-show ac">
  <div class="div-table">
    <div class="table-cell">
	  <img src="<?php echo $_smarty_tpl->tpl_vars['AltSkinDir']->value;?>
/_images/portrait.png">
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
              <?php  $_smarty_tpl->tpl_vars['cat_1'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat_1']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories_1']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat_1']->key => $_smarty_tpl->tpl_vars['cat_1']->value) {
$_smarty_tpl->tpl_vars['cat_1']->_loop = true;
?>
                <dd><a href="home.php?cat=<?php echo $_smarty_tpl->tpl_vars['cat_1']->value['categoryid'];?>
"><?php echo $_smarty_tpl->tpl_vars['cat_1']->value['category'];?>
</a></dd>
              <?php } ?>
              </dl>
            </div>
        </li>
        <li class="dropdown-sub"><a href="#">Interior Lighting <span class="plus-ico">+</span><span class="minus-ico">-</span></a>
        	<div class="mob-menu-sub">
            	<dl>
              <?php  $_smarty_tpl->tpl_vars['cat_2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat_2']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories_2']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat_2']->key => $_smarty_tpl->tpl_vars['cat_2']->value) {
$_smarty_tpl->tpl_vars['cat_2']->_loop = true;
?>
                <dd class="link-nav-c"><a href="javascript:;" rel="<?php echo $_smarty_tpl->tpl_vars['cat_2']->value['categoryid'];?>
"><?php echo $_smarty_tpl->tpl_vars['cat_2']->value['category'];?>
 <i class="fa fa-angle-right"></i></a></dd>
              <?php } ?>
                <dd><a class="btn btn-gold" href="ChooseYourStyle.html">FIND YOUR STYLE</a></dd>
              </dl>
            </div>
        </li>
        <li class="dropdown-sub"><a href="#">Exterior Lighting <span class="plus-ico">+</span><span class="minus-ico">-</span></a>
        	<div class="mob-menu-sub">
            	<dl>
              <?php  $_smarty_tpl->tpl_vars['cat_3'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat_3']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories_3']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat_3']->key => $_smarty_tpl->tpl_vars['cat_3']->value) {
$_smarty_tpl->tpl_vars['cat_3']->_loop = true;
?>
                <dd class="link-nav-c"><a href="javascript:;" rel="<?php echo $_smarty_tpl->tpl_vars['cat_3']->value['categoryid'];?>
"><?php echo $_smarty_tpl->tpl_vars['cat_3']->value['category'];?>
 <i class="fa fa-angle-right"></i></a></dd>
              <?php } ?>
                <dd><a class="btn btn-gold" href="ChooseYourStyle.html">FIND YOUR STYLE</a></dd>
              </dl>
            </div>
        </li>
        <li class="dropdown-sub"><a href="#">Brands <span class="plus-ico">+</span><span class="minus-ico">-</span></a>
        	<div class="mob-menu-sub">
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
        <li class="dropdown-sub"><a href="#">Styles <span class="plus-ico">+</span><span class="minus-ico">-</span></a>
        	<div class="mob-menu-sub">
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
    <?php  $_smarty_tpl->tpl_vars['cat_2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat_2']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories_2']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat_2']->key => $_smarty_tpl->tpl_vars['cat_2']->value) {
$_smarty_tpl->tpl_vars['cat_2']->_loop = true;
?>
    <div class="mob-nav-c-<?php echo $_smarty_tpl->tpl_vars['cat_2']->value['categoryid'];?>
 mob-nav-c">
      <dl>
        <dt><a href="javascript:;"><i class="fa fa-angle-left"></i> INTERIOR LIGHTING</a></dt>
        <dd><a href="javascript:;"><?php echo mb_strtoupper($_smarty_tpl->tpl_vars['cat_2']->value['category'], 'UTF-8');?>
</a></dd>
        <?php  $_smarty_tpl->tpl_vars['cat_2_sub'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat_2_sub']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cat_2']->value['sub']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat_2_sub']->key => $_smarty_tpl->tpl_vars['cat_2_sub']->value) {
$_smarty_tpl->tpl_vars['cat_2_sub']->_loop = true;
?>
        <dd><a href="home.php?cat=<?php echo $_smarty_tpl->tpl_vars['cat_2_sub']->value['categoryid'];?>
"><?php echo $_smarty_tpl->tpl_vars['cat_2_sub']->value['category'];?>
</a></dd>
        <?php } ?>
      </dl>
    </div>
    <?php } ?>
    <?php  $_smarty_tpl->tpl_vars['cat_3'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat_3']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories_3']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat_3']->key => $_smarty_tpl->tpl_vars['cat_3']->value) {
$_smarty_tpl->tpl_vars['cat_3']->_loop = true;
?>
    <div class="mob-nav-c-<?php echo $_smarty_tpl->tpl_vars['cat_3']->value['categoryid'];?>
 mob-nav-c">
      <dl>
        <dt><a href="javascript:;"><i class="fa fa-angle-left"></i> Exterior LIGHTING</a></dt>
        <dd><a href="javascript:;"><?php echo mb_strtoupper($_smarty_tpl->tpl_vars['cat_3']->value['category'], 'UTF-8');?>
</a></dd>
        <?php  $_smarty_tpl->tpl_vars['cat_3_sub'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat_3_sub']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cat_3']->value['sub']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat_3_sub']->key => $_smarty_tpl->tpl_vars['cat_3_sub']->value) {
$_smarty_tpl->tpl_vars['cat_3_sub']->_loop = true;
?>
        <dd><a href="home.php?cat=<?php echo $_smarty_tpl->tpl_vars['cat_3_sub']->value['categoryid'];?>
"><?php echo $_smarty_tpl->tpl_vars['cat_3_sub']->value['category'];?>
</a></dd>
        <?php } ?>
      </dl>
    </div>
    <?php } ?>
    
  </div>
</div>
<?php }} ?>
