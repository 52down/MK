/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Javascript code for daterangepicker widget
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Skin
 * @author     Michael Bugrov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @version    ab037e1f10a534cb62fd6b4a4ec203dd44ce9bed, v5 (xcart_4_7_7), 2017-01-24 09:39:46, daterangepicker.js, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

$(document).ready(function () {
    var elements = $('input.date-range');

    $.each(elements, function () {
        var element = $(this);
        var config = JSON.parse(element.attr('data-daterangeconfig').trim()) || {};

        if (element.data('start-date')) {
            config.startDate = element.data('start-date');
        }
        if (element.data('end-date')) {
            config.endDate = element.data('end-date');
        }

        if (config.customShortcuts && config.customShortcuts.length > 0) {
            for (i = 0; i < config.customShortcuts.length; i++) {
                var customSortcut = config.customShortcuts[i];

                if ('today' === customSortcut) {
                    config.customShortcuts[i] = {
                        name: customSortcut,
                        dates: function () {
                            return [moment().toDate(), moment().toDate()];
                        }
                    };

                } else if ('this week' === customSortcut) {
                    config.customShortcuts[i] = {
                        name: customSortcut,
                        dates: function () {
                            if (config.startOfWeek === 'monday') {
                                return [moment().startOf('isoweek').toDate(), moment().toDate()];
                            }
                            return [moment().startOf('week').toDate(), moment().toDate()];
                        }
                    };

                } else if ('this month' === customSortcut) {
                    config.customShortcuts[i] = {
                        name: customSortcut,
                        dates: function () {
                            return [moment().startOf('month').toDate(), moment().toDate()];
                        }
                    };

                } else if ('this quarter' === customSortcut) {
                    config.customShortcuts[i] = {
                        name: customSortcut,
                        dates: function () {
                            return [moment().startOf('quarter').toDate(), moment().toDate()];
                        }
                    };

                } else if ('this year' === customSortcut) {
                    config.customShortcuts[i] = {
                        name: customSortcut,
                        dates: function () {
                            return [moment().startOf('year').toDate(), moment().toDate()];
                        }
                    };
                }
            }
        }

        element.dateRangePicker(config);
    });
});
