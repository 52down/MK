/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * IP address checking script
 * 
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com> 
 * @version    f2739377a4ee428cf3dd53b67da2c88256c97b1e, v3 (xcart_4_7_8), 2017-04-10 09:18:55, check_ip_address.js, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

// Check IP address
function checkIPAddress(str, blockAlert) {
  var obj = false;

  if (typeof(str) != 'string' && str.tagName && str.tagName.toUpperCase() == 'INPUT') {
    obj = str;
    str = str.value;
  }

  if (typeof(str) != 'string') {
    return false;
  }

  var is_ipv6 = str.indexOf(':') > 0;
  if (is_ipv6) {
    var validate_regex = /^[0-9a-z]+$/;
    var octet_count = 8;
    var arr = str.split(':');
  } else {
    var validate_regex = /^\d+$/;
    var octet_count = 4;
    var arr = str.split('.');
  }

  var res = false;
  if (arr.length == octet_count) {
      res = true;
      var isMask = false;
      for (var i = 0; i < octet_count; i++) {
          var failed_ip_group_check = is_ipv6 ? false : (parseInt(arr[i]) < 0 || parseInt(arr[i]) > 255);
          if (arr[i] == '*') {
              isMask = true;

          } else if (arr[i].search(validate_regex) == -1 || failed_ip_group_check || isMask) {
              res = false;
              break;
          }
      }
  }

  if (!res && !blockAlert && window.lbl_ip_address_format_incorrect) {
    markErrorField(obj);
    alert(lbl_ip_address_format_incorrect);
    if (obj && obj.focus)
      obj.focus();
  }

  return res;
}
