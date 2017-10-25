/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Common controller
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @version    024f9f3b82292c8cd221c5dd80f554ee86830b82, v8 (xcart_4_7_7), 2016-09-01 17:23:08, controller.js, mixon
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

function xauthTogglePopup(link, mode)
{
  xauthLoadingChecker(true);

  return !popupOpen(
    'xauth_layer.php' + (mode ? '?mode=' + mode : ''),
    null,
    {
      width: 'auto',
      height: 'auto',
      closeOnEscape: true
    }
  );
}

function xauthLoadingChecker(reset)
{
  if (reset) {
    arguments.callee.counter = 0;
  }

  /*
   * Work around for the jQuery popup issue with the script not generating proper elements if 
   * executed via jQuery script eval witch imitates the real popup window behavior
   */
  if (
    0 < jQuery('#janrainEngageEmbed').children('.xauth-bg-loading').length 
    && undefined != window.janrain 
    && undefined != window.janrain.engage
    && undefined != window.janrain.engage.signin
    && undefined != window.janrain.engage.signin.widget
  ) {
      janrain.engage.signin.widget.init();
      janrain.engage.signin.widget.refresh();

  } else if (
    arguments.callee.counter < 60 
    && (
      0 == jQuery('#janrainEngageEmbed').length 
      || 0 < jQuery('#janrainEngageEmbed').children('.xauth-bg-loading').length
    )
  ) {
    setTimeout(arguments.callee, 500);
    arguments.callee.counter++;

    return false;
  }

  if (
    0 < jQuery('#janrainEngageEmbed').length
  ) {
    jQuery('#janrainEngageEmbed').attr('id', '');
  }
}
xauthLoadingChecker.counter = 0;

function xauthOpenProductShare(button)
{
  var product = jQuery('h1').eq(0).text();
  var description = jQuery('.product-details .descr').text();
  
  if (!product || !window.janrain) {
    return false;
  }

  window.janrain.engage.share.reset();
  window.janrain.engage.share.setDescription(xauthRPXEscape(description ? description : product));
  window.janrain.engage.share.setUrl(self.location + '');
  window.janrain.engage.share.show();
  return true;
}

function xauthOpenCartItemShare(elm)
{
  var tbl = jQuery(elm).closest(':has(.details a)');
  var product = jQuery('.details a', tbl).text();
  var description = jQuery('.details .descr', tbl).text();
  var url = jQuery('.details a', tbl).attr('href');

  if (!tbl.length || !product || !url || !window.janrain) {
    return false;
  }

  if (url.search(/^\//) != -1) {
    url = 'http://' + xauth_current_host + url;

  } else if (url.search(/^https?:\/\//) == -1) {
    url = xauth_catalogs_customer + '/' + url;
  }

  window.janrain.engage.share.reset();
  window.janrain.engage.share.setDescription(xauthRPXEscape(description ? description : product));
  window.janrain.engage.share.setUrl(url);
  window.janrain.engage.share.show();

  return true;
}

function xauthOpenInvoiceShare(elm)
{
  if (!window.janrain) {
    return false;
  } 

  window.janrain.engage.share.reset();
  window.janrain.engage.share.show();

  return true;
}

function xauthRPXEscape(str)
{
  str = str.substr(0, 760);

  var len = str.length;
  var collect = '';
  var c, x, n;

  for (var i = 0; i < len; i++) {
    n = str.charCodeAt(i);

    if (n <= 127) {
        collect += str.substr(i, 1);

    } else {
        c = n.toString(16);
        for (x = c.length; x < 4; x++) {
          c = '0' + c;
        }
        collect += '\\u' + c;
    }
  }

  return collect;
}

function xauthRPXPrepareURL(url)
{
  if (url.substr(0, 1) == '/') {
    url = self.location.protocol + '//'
      + self.location.host
      + (self.location.port ? ':' + self.location.port : '')
      + url

  } else if (-1 == url.search(/^https?:\/\//)) {
    url = self.location.protocol + '//'
      + self.location.host
      + (self.location.port ? ':' + self.location.port : '')
      + self.location.pathname.replace(/\/[^\/]+\.(php|html|htm)$/, '') + '/' + url;
  }

  return url;
}

setTimeout(
  function() {
    jQuery(document).ready(
      function() {
        if (jQuery('#dialog-message .xauth-err').length) {
          jQuery('#dialog-message').clearQueue();
        }

        jQuery('a,input,button').filter(
          function() {
            return 'undefined' != typeof(this.onclick)
              && this.onclick
              && this.onclick.toString().search(/popupOpen..login\.php../) != -1;
          }
        ).click(
          function() {
            xauthLoadingChecker(true);
          }
        );

        if (jQuery('#janrainEngageEmbed').length > 0) {
          xauthLoadingChecker(true);
        }
      }
    );
  },
  500
);
