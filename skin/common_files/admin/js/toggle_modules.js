/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Toggle modules using AJAX
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com> 
 * @version    1803c66a898d4a92da393bae7c686d548bcbd9ba, v6 (xcart_4_7_7), 2016-10-20 16:06:56, toggle_modules.js, mixon
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

/* global ajax, constants, images_dir */

/**
 * Toggle module
 *
 * @param {string} module_name
 *
 * @returns {void}
 */
function toggleModule(module_name) {

  var opts = {
    overlayCSS: {
      background: 'white',
      opacity: '0.3'
    },
    message: null
  };
  $('#modules-list').block(opts);

  opts.overlayCSS.opacity = '0';
  opts.message = '<img src="' + images_dir + '/loading.gif" />';
  $('#li_modules_' + module_name).block(opts);

  toggleModuleBlockMenu();

  post = {
    mode: 'toggle',
    module_name: module_name,
    active: ($('#' + module_name).prop('checked')) ? 1 : 0
  };

  ajax.query.add({
    type: 'GET',
    data: post,
    url: 'modules.php',
    success: function(a, b, c, d) {

      var ok = false;

      if (c.messages) {
        for (var i = 0; i < c.messages.length; i++) {
          if (c.messages[i].name == 'moduleToggle') {
            data = c.messages[i].params;
            if (data) {
              ok = true;
              if (!data.redirect) {
                $('#dialog-message').hide();
                $('#li_modules_' + module_name).unblock();
                $('#modules-list').unblock();
                if (data.result) {
                  $('#li_modules_' + module_name).toggleClass('active');
                  toggleModuleBlockMenu();
                  ajax.core.loadBlock($('#horizontal-menu'), 'admin_menu', { _request_prefix : constants.DIR_ADMIN, _request_type : 'GET'});
                } else {
                  $('#horizontal-menu').unblock();
                  $('#' + module_name).prop(
                    'checked',
                    function(i, val) {
                      return !val;
                    }
                  );
                }
                if (data.message) {
                  showTopMessage(data.message.content, data.message.type);
                }
              } else {
                window.location = data.redirect;
              }
            }
            break;
          }
        }
      }

      if (!ok) {
        window.location.reload();
      }

    },
    error: function(a, b, c, d) {
      window.location.reload();
    }
  });

};

function toggleModuleBlockMenu() {
  var opts = {
    overlayCSS: {
      background: $('#head-admin').css('background-color'),
      opacity: '0.6'
    },
    message: null
  };
  $('#horizontal-menu').block(opts);
}
