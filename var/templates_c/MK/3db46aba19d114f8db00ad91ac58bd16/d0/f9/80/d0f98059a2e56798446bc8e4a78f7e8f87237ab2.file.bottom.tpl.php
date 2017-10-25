<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:58:16
         compiled from "D:\website\MK\skin\MK\customer\bottom.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1493259ec52a9243e72-98764865%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd0f98059a2e56798446bc8e4a78f7e8f87237ab2' => 
    array (
      0 => 'D:\\website\\MK\\skin\\MK\\customer\\bottom.tpl',
      1 => 1508662693,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1493259ec52a9243e72-98764865',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec52a9245161_05476550',
  'variables' => 
  array (
    'AltSkinDir' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec52a9245161_05476550')) {function content_59ec52a9245161_05476550($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\website\\MK\\include\\lib\\smarty3\\plugins\\modifier.date_format.php';
?>
<footer class="footer">
  <div class="footer-help">
    <div class="container-fluid">
      <div class="col-xs-12 col-sm-4">
        <div class="footer-help-box">
          <h4>Dealer Locator</h4>
          <form>
            <div class="footer-help-box-txt">
              <div class="form-group">
                <div class="controls">
                  <input type="text" id="Email-address" class="floatLabel" name="">
                  <label for="">Enter Zip Code</label>
                </div>
              </div>
              <div class="form-group">
                <div class="controls"> <i class="fa fa-angle-down"></i>
                  <select class="floatLabel">
                    <option value="blank"></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
                  <label for="fruit">Distance</label>
                </div>
              </div>
            </div>
            <div class="form-group ac"> <a href="#" class="btn btn-gold-t">SEARCH</a> </div>
          </form>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4">
        <div class="footer-help-box">
          <h4>Contact Us</h4>
          <div class="footer-help-box-txt">
            <p>Monday - Friday 6:00 a.m. - 5:00 p.m. PST<br>
              Toll Free: 1 (800) 221-7977<br>
              Email: sales@minkagroup.net</p>
          </div>
          <div class="ac"> <a class="btn btn-gold-t" href="Contact.html">CONTACT US</a> </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4">
        <div class="footer-help-box">
          <h4>Resources</h4>
          <div class="footer-help-box-txt">
            <p>Can’t find what you’re looking for?<br>
              View our Resources page.</p>
          </div>
          <div class="ac"> <a class="btn btn-gold-t" href="Resources_01.html">RESOURCES</a> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-main">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12">
          <div class="footer-logo"> <img src="<?php echo $_smarty_tpl->tpl_vars['AltSkinDir']->value;?>
/_images/footer-logo.png"> </div>
          <ul>
            <li><a class="effect-3" href="OurStory.html">About</a></li>
            <li><a class="effect-3" href="FAQ.html">FAQ</a></li>
            <li><a class="effect-3" href="WhereToBuy.html">Dealer Locator</a></li>
            <li><a class="effect-3" href="Warranty-Registration.html">Warranty Registration</a></li>
            <li><a class="effect-3" href="Contact.html">Contact</a></li>
          </ul>
          <p class="copy">&copy; <?php echo smarty_modifier_date_format(XC_TIME,"Y");?>
 Minka Lighting Inc. All rights reserved.</p>
        </div>
      </div>
    </div>
  </div>
</footer>
<a class="live-chat-link live-chat-icon" href="#"><i class="fa fa-comments-o"></i></a>
<div class="pop-wrap live-chat-pop ">
  <div class="pop-wrap-bg"></div>
  <div class="div-table">
    <div class="table-cell">
      <div class="pop-main live-chat-pop-main">
        <div class="live-chat-box">
          <div class="live-chat-box-top">
            <div class="userphoto" style="background-image:url(<?php echo $_smarty_tpl->tpl_vars['AltSkinDir']->value;?>
/_images/Send-a-message.._03.jpg);"></div>
            <h6>Elizabeth</h6>
            <div class=""> <img class="live-logo" src="<?php echo $_smarty_tpl->tpl_vars['AltSkinDir']->value;?>
/_images/logo.png"> </div>
            <a class="live-tel" href="tel:323-213-8026">323-213-8026</a> </div>
          <div class="live-chat-box-middle">
            <div class="live-chat-box-content">
              <p><span>Elizabeth:</span> How can I help you today?</p>
            </div>
          </div>
          <div class="live-chat-box-bottom">
            <input type="text" class="form-control" placeholder="Send a message....">
          </div>
        </div>
        <div class="ac"><a class="close-icon" href="#"><span class="line-bar"></span><span class="line-bar"></span></a></div>
      </div>
    </div>
  </div>
</div>
<div class="pop-wrap video-pop ">
  <div class="pop-wrap-bg"></div>
  <div class="div-table">
    <div class="table-cell">
      <div class="pop-main video-main">
        <div class="video-pop-box">
          <div class="ar"><a class="close-icon" href="#"><span class="line-bar"></span><span class="line-bar"></span></a></div>
          <img src="<?php echo $_smarty_tpl->tpl_vars['AltSkinDir']->value;?>
/_images/Minka_Video_Lightbox_03.jpg"> </div>
      </div>
    </div>
  </div>
</div>
<?php }} ?>
