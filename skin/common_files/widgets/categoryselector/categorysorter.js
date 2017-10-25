/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Category sort functions for categoryselector widget
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Skin
 * @author     Michael Bugrov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @version    ab037e1f10a534cb62fd6b4a4ec203dd44ce9bed, v2 (xcart_4_7_7), 2017-01-24 09:39:46, categorysorter.js, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

/**
 * Sort list using lowercase comparison
 *
 * @param {array} list
 * @returns {array}
 */
function xcartCategoryselectorLowercaseComparison(list) {
    return list.sort(
        function(a,b) {
            a = a.text.toLowerCase();
            b = b.text.toLowerCase();
            if(a > b) {
                return 1;
            } else if (a < b) {
                return -1;
            }
            return 0;
        }
    );
};
