/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Javascript code for categoryselector widget
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Skin
 * @author     Michael Bugrov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @version    ab037e1f10a534cb62fd6b4a4ec203dd44ce9bed, v8 (xcart_4_7_7), 2017-01-24 09:39:46, categoryselector.js, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

/* global $, document, JSON, localStorage, sessionStorage, window */

$(document).ready(function () {
  /* elements selector */
  var elements = $('select.categoryselector');

  $.each(elements, function () {
    var element = $(this);
    var config = JSON.parse(element.attr('data-categoryselectorconfig').trim()) || {};

    if (config.sorter) {
        config.sorter = window[config.sorter];
    }

    var element_name = element.attr('name');
    var element_key = 'categoryselector-' + element_name;

    var switchers = element.parent().find('.categoryselector-widget-switcher');
    // resize switchers
    switchers.width(element.outerWidth());

    var used_storage = isLocalStorageSupported() ? localStorage : sessionStorage;

    if (
      typeof used_storage[element_key] === 'undefined'
      || used_storage[element_key] === 'widget'
    ) {
      // enable widget
      element.select2(config);
      // save widget state
      used_storage[element_key] = 'widget';
    }

    $.each(switchers, function() {
      var switcher = $(this);
      var controls = switcher.find('[data-action]');

      $.each(controls, function() {
        var control = $(this);
        var action = control.data('action');

        if (used_storage[element_key] === action) {
          control.addClass('active');
        } else {
          control.removeClass('active');
        }

        control.on('click', function() {
          var hasWidget = element.data('select2');

          switch (action) {
            case 'widget':
              if (!hasWidget) {
                element.select2(config);
              }
              break;
            case 'default':
              if (hasWidget) {
                element.select2('destroy');
              }
              break;
          }

          used_storage[element_key] = action;
          control.parent().find('.active').removeClass('active');
          control.addClass('active');
        });
      });

    });
  });

});
