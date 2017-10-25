/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Common JavaScript variables and functions
 * 
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage ____sub_package____
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    0b0633768559e57d1124488556a9dbf71d865723, v4 (xcart_4_7_7), 2017-01-23 20:12:10, common.js, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

function func_orderstatuses_change_circle(elem, new_status)
{
  var circle_div = $(elem).parent().parent().children('div[class^="xostatus-search-status-indicator xostatus-orderstatus-background"]');
  if (
    $(circle_div).length > 0
  ) {
    $(circle_div).attr('class', 'xostatus-search-status-indicator xostatus-orderstatus-background-' + $(elem).val());
  }
}
