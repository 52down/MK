/* vim: set ts=2 sw=2 sts=2 et: */

/* global ajax, is_responsive_skin */

$(function () {

  $(ajax.messages).bind(
    'productAdded',
    function(e, data) {

      $('.product-added').find('.ui-dialog-content').dialog('close').dialog('destroy').remove();

      var dialog = $(data.content).not('script');
      var dialogScripts = $(data.content).filter('script');

      if (isXCResponsiveSkinOpenOnMobileDevice()) {
        // Do not display if using responsive skin in mobile mode
        return true;
      }


      dialog.dialog({

        autoOpen: false,
        classes: {
          'ui-dialog': 'ui-corner-all product-added'
        },
        modal: true,
        title: data.title,
        width: 575,
        draggable: false,
        resizable: false,
        position:  {my : 'center center', at : 'center center'},
        closeOnEscape: true,

        close: function() {
          dialogScripts.remove();
        },

        open: function () {
          $(".product-added .view-cart").button();
          $(".product-added .continue-shopping").button().click(function () {
            dialog.dialog('close');
            return false;
          });
          $(".product-added .proceed-to-checkout").button().click(function () {
            dialog.dialog('close');
          });
          $('.ui-widget-overlay').click(function () {
            dialog.dialog('close');
          });
        }

      });

      dialogScripts.appendTo('body');
      dialog.dialog('open');

      ajax.widgets.products();
    }
  );

});
