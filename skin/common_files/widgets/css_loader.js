/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Javascript widget css loader
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Skin
 * @author     Michael Bugrov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @version    22ef90b756fdba374f55781e61efedd7a25ccb33, v5 (xcart_4_7_7), 2016-11-07 13:17:21, css_loader.js, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

/**
 * Load CSS file
 *
 * @param {string} file
 * @param {string} type
 *
 * @returns void
 */
function xc_load_css(file, type) {
    var element;

    appendElement = function(element, file) {
        if (
            $('link[href="' + file + '"]').length === 0
            && $('style[data-file="' + file + '"]').length === 0
        ) {
            $('head').append(element);
        }
    };

    switch (type) {
        case 'link':
            element = '<link rel="stylesheet" type="text/css" href="' + file + '"></link>';
            appendElement(element, file);
            break;
        case 'style':
            $.get(file).done(function (content) {
                element = '<style data-file="' + file + '">' + content + '</style>';
                appendElement(element, file);
            });
            break;
    }
};
