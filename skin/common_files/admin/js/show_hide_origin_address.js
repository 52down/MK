/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Show/Hide Company shipfrom address section on configuration.php?option=Company page
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @version    ab037e1f10a534cb62fd6b4a4ec203dd44ce9bed, v2 (xcart_4_7_7), 2017-01-24 09:39:46, show_hide_origin_address.js, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */
function func_toggle_shipfrom_address(duration, is_hide) {
  if (is_hide) {
    $("tr[id^='tr_shipfrom_']").not("#tr_shipfrom_address_separator,#tr_shipfrom_address_as_company_one").fadeOut( duration );
  } else {
    $("tr[id^='tr_shipfrom_']").not("#tr_shipfrom_address_separator,#tr_shipfrom_address_as_company_one").fadeIn( duration );
  }
}

$(document).ready(
  function() {

    $('#opt_shipfrom_address_as_company_one').change(function() {
      func_toggle_shipfrom_address(200, this.checked);
    });

    func_toggle_shipfrom_address(0, $('#opt_shipfrom_address_as_company_one').is(':checked'));
  }
);
