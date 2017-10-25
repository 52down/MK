/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Popup product
 * 
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com> 
 * @version    4bfaf0882c51067bb46376e03b47b300bbab3fc6, v6 (xcart_4_7_4), 2015-10-01 15:04:32, popup_product.js, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

function popup_product(field_productid, field_product, only_regular) {
  return popupOpen(
    'popup_product.php?field_productid=' + field_productid + '&field_product=' + field_product + '&only_regular=' + only_regular,
    '',
    { 
      width: Math.max($(this).width()-150, 800),
      maxWidth: Math.max($(this).width()-150, 800),
      height: 600,
      draggable: true
    }
  );
}

/* Add autocomplete 'productcode' feature for autocomplete_field_selector fields*/
/*IN: autocomplete_field_selector js_ajax_session_quick_key*/
var autocomplete_field_selector, js_ajax_session_quick_key;
autocomplete_field_selector && js_ajax_session_quick_key && $(function() {
  function aqsSplit( val ) {
    return val.split( /,\s*/ );
  }
  function aqsExtractLast( term ) {
    return aqsSplit( term ).pop();
  }

  $(autocomplete_field_selector)
    // do not navigate away from the field on tab when selecting an item
    .bind( "keydown", function( event ) {
      if ( event.keyCode === $.ui.keyCode.TAB &&
          $( this ).autocomplete( "instance" ).menu.active ) {
        event.preventDefault();
      }
    })
    .autocomplete({
      minLength: 2, /*The minimum number of characters a user must type before a search is performed. */
      delay: 500, /* The delay in milliseconds between when a keystroke occurs and when a search is performed. */
      source: function( request, response ) {
        $.getJSON( "ajax_search_products.php?posted_ajax_session_quick_key="+js_ajax_session_quick_key, {
          term: aqsExtractLast( request.term )
        }, response );
      },
      search: function() {
        // custom minLength
        var term = aqsExtractLast( this.value );
        if ( term.length < 2 ) {
          return false;
        }
      },
      focus: function() {
        // prevent value inserted on focus
        return false;
      },
      select: function( event, ui ) {
        var terms = aqsSplit( this.value );
        // remove the current input
        terms.pop();
        // add the selected item
        terms.push( ui.item.value );
        // add placeholder to get the comma-and-space at the end
        terms.push( "" );
        this.value = terms.join( "," );
        return false;
      }
    });
});
