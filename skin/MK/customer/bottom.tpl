{*
22f6923a9e65090657fef8e74ebb5436d9e861ee, v4 (xcart_4_6_0), 2013-05-23 14:12:07, bottom.tpl, random
vim: set ts=2 sw=2 sts=2 et:
<div class="box">
  <div class="subbox"> {if $active_modules.Klarna_Payments}
    {include file="modules/Klarna_Payments/footer_logo.tpl"}
    {/if}
    <div class="left">{include file="main/prnotice.tpl"}</div>
    <div class="right">{include file="copyright.tpl"}</div>
  </div>
</div>
*}
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
          <div class="footer-logo"> <img src="{$AltSkinDir}/_images/footer-logo.png"> </div>
          <ul>
            <li><a class="effect-3" href="OurStory.html">About</a></li>
            <li><a class="effect-3" href="FAQ.html">FAQ</a></li>
            <li><a class="effect-3" href="WhereToBuy.html">Dealer Locator</a></li>
            <li><a class="effect-3" href="Warranty-Registration.html">Warranty Registration</a></li>
            <li><a class="effect-3" href="Contact.html">Contact</a></li>
          </ul>
          <p class="copy">&copy; {$smarty.now|date_format:"Y"} Minka Lighting Inc. All rights reserved.</p>
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
            <div class="userphoto" style="background-image:url({$AltSkinDir}/_images/Send-a-message.._03.jpg);"></div>
            <h6>Elizabeth</h6>
            <div class=""> <img class="live-logo" src="{$AltSkinDir}/_images/logo.png"> </div>
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
          <img src="{$AltSkinDir}/_images/Minka_Video_Lightbox_03.jpg"> </div>
      </div>
    </div>
  </div>
</div>
