/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Alibaba Wholesale widget
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Michael Bugrov
 * @version    ee8fb4ea37d363887326bb281100a27746bc181e, v9 (xcart_4_7_4), 2015-10-12 09:49:37, controller.js, mixon
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

(function alibaba_wholesale($) {

    // Define constants
    Object.defineProperty(alibaba_wholesale, 'ROOT', {
        value: 'root'
    });
    Object.defineProperty(alibaba_wholesale, 'DIRECTION', {
        value: {
            up: 'up',
            down: 'down'
        }
    });

    var jqref_document = $(document);
    var jqref_window = $(window);

    var lastScrollTop = 0;

    hashManager = function () {
        // get hash value
        var hash = window.location.hash;

        // check if starts with #
        if (hash && hash.substr(0,1) === '#') {
            // skip # use rest
            hash = hash.substr(1);
        }

        // ! is used as separator
        hash = hash.split('!');

        hashManager.prototype.get = function (key) {
            var value = null;

            $.each(
                    hash,
                    function (i, v) {
                        if (v) {
                            if (v.substr(0, key.length) === key) {
                                value = v.substr(key.length);
                            }
                        }
                    }
            );

            return value;
        };

        hashManager.prototype.set = function (key, value) {

            var current_value = this.get(key);

            if (current_value) {
                $.each(
                    hash,
                    function (i, v) {
                        if (v) {
                            if (v.substr(0, key.length) === key) {
                                hash[i] = key + value;
                            }
                        }
                    }
                );
            } else {
                hash.push(key + value);
            }

            window.location.hash = hash.join('!');
        };

        hashManager.prototype.clear = function() {
            window.location.hash = '';
        };
    };

    detectDirection = function () {
        var offset = window.pageYOffset;
        var direction = alibaba_wholesale.DIRECTION.up;

        if (offset > lastScrollTop) {
            direction = alibaba_wholesale.DIRECTION.down;
        }
        lastScrollTop = offset;

        return direction;
    };

    getStorageName = function (element) {
        return 'aw_input_' + element + xcart_web_dir;
    };

    searchHandler = function () {
        var keyword = $('#aw_catalog input[name="search_substring"]');
        if (keyword.val() || $('#aw_catalog .aw-filter-panel.aw-animate-show').length > 0) {
            var hmgr = new hashManager();
            var category_id = hmgr.get('category');
            if (keyword.val()) {
                search_products(false, keyword.val());
            } else if(category_id) {
                search_products(category_id, false);
            } else {
                search_products(alibaba_wholesale.ROOT);
            }
        } else {
            keyword.focus();
        }
    };

    init = function () {

        $('#aw_catalog .aw-logo').on(
                'click',
                function () {
                    search_products(alibaba_wholesale.ROOT);
                }
        );

        $('#aw_catalog .aw-search-btn button').on(
                'click',
                searchHandler
        );

        $('#aw_catalog input[name="search_substring"], #aw_catalog input[name^="aw_"]').on(
                'keypress',
                function(e) {
                    if (e.keyCode === 13) {
                        searchHandler();
                    }
                }
        );

        $('#aw_catalog .aw-filter-btn').on(
                'click',
                function() {
                    var panel = $('#aw_catalog .aw-filter-panel');
                    if (panel.height() > 0) {
                        panel.removeClass('aw-animate-show').addClass('aw-animate-hide');
                        $('.aw-search-keywords button span.ui-button-text').removeClass('hover');
                    } else {
                        panel.removeClass('aw-animate-hide').addClass('aw-animate-show');
                        $('.aw-search-keywords button span.ui-button-text').addClass('hover');
                    }
                }
        );

        jqref_window.on(
                'scroll',
                function () {
                    // check if blocked
                    var not_blocked = $('.ui-widget-overlay').length === 0;
                    // get product line height
                    var line_height = $('#aw_catalog .aw-products ul li:first').height() / 3;
                    // check scroll conditions
                    if (
                        not_blocked
                        && detectDirection() === alibaba_wholesale.DIRECTION.down
                        &&
                            (jqref_window.scrollTop() + jqref_window.height())
                            >= (jqref_document.height() - line_height)
                    ) {
                        var hmgr = new hashManager();
                        var category_id = hmgr.get('category');
                        if (
                            category_id
                            && category_id !== alibaba_wholesale.ROOT
                        ) {
                            var keyword = hmgr.get('keyword');
                            var page = hmgr.get('page');

                            search_products(category_id, keyword, parseInt(page) + 1);
                        }
                    }
                }
        );

        // isLocalStorageSupported is defined in versions ge 4.6.2
        if (isLocalStorageSupported()) {
            var elements = ['aw_price_from', 'aw_price_to', 'aw_sort_by'];
            $.each(elements, function(key, value) {
                var stVal = localStorage[getStorageName(value)];
                if (stVal) {
                    $('#' + value).val(stVal);
                }
            });
        }

        search_products(alibaba_wholesale.ROOT);
    };

    search_products = function (category_id, keyword, page) {
        if (!ajax.core.isReady()) {
            return false;
        }

        // define default values
        category_id = category_id ? category_id : false;
        keyword = keyword ? keyword : false;
        page = page ? page : 1;

        var container = $('#aw_catalog .aw-search');

        var price_from = $('#aw_catalog input[name="aw_price_from"]').val();
        var price_to = $('#aw_catalog input[name="aw_price_to"]').val();
        var sort_by = $('#aw_catalog select[name="aw_sort_by"] option:selected').val();

        if (isLocalStorageSupported()) {
            var elements = ['aw_price_from', 'aw_price_to', 'aw_sort_by'];
            $.each(elements, function(key, value) {
                var elVal = $('#' + value).val();
                if (elVal) {
                    localStorage[getStorageName(value)] = elVal;
                }
            });
        }

        // block UI
        $.blockUI({
            css: {
                left: jqref_window.width() / 2 - 100
            }
        });

        var request_data = {};

        // prepare request data

        if (category_id) {
            request_data.aw_category_id = category_id;
        }

        if (keyword) {
            request_data.aw_keyword = keyword;
        }

        if (page) {
            request_data.aw_page = page;
        }

        if (price_from) {
            request_data.aw_price_from = price_from;
        }

        if (price_to) {
            request_data.aw_price_to = price_to;
        }

        if (sort_by) {
            request_data.aw_sort_by = sort_by;
        }

        var xhr = false;
        try {
            xhr = $.ajax(
                    {
                        url: current_location + '/get_block.php?block=alibaba_wholesale_search',
                        type: 'GET',
                        data: request_data,
                        dataType: 'html',
                        complete: function(res, status) {
                            xhr_search_products_complete(res, status, category_id, keyword, page, container);
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            xhr_search_products_error(xhr, textStatus, errorThrown, category_id, keyword, page);
                        },
                        timeout: 6000 // set timeout to 6 seconds
                    });

            return xhr;

        } catch (e) {

            return false;
        }

        return false;
    };

    xhr_search_products_complete = function (res, status, category_id, keyword, page, container) {
        // check status
        if (status === 'success') {

            var listChanged = false;

            // check page number
            if (page === 1) {

                // clear content
                container.html('');
                // show response HTML
                container.html(res.responseText);
                // consider changed
                listChanged = true;

            } else {

                // update only products section
                container = container.find('.aw-products ul');
                // count elements
                var beforeAppend = container.find('li').length;
                // append products
                container.append($('<div>' + res.responseText + '</div>').find('.aw-products ul li'));
                // count elements
                var afterAppend = container.find('li').length;
                // reset container to last list
                container = container.find('li').slice(-awProductsPerPage);
                // check state
                listChanged = beforeAppend !== afterAppend;
            }

            var hmgr = new hashManager();

            // update window hash
            if (category_id === alibaba_wholesale.ROOT) {
                hmgr.clear();
            } else {
                if (category_id) {
                    hmgr.set('category', category_id);
                }
                if (keyword) {
                    hmgr.set('keyword', keyword);
                }
                if (page) {
                    hmgr.set('page', page);
                }
            }

            // attach rootcat handler
            $('#aw_catalog .aw-categories > h2').on(
                'click',
                function () {
                    search_products(alibaba_wholesale.ROOT);
                }
            );

            // attach category handlers
            $.each(
                    container,
                    function (index, value) {
                        $(value).find('a[data-type="category"]').on(
                                'click',
                                function (e) {
                                    search_products(e.currentTarget.id, $('#aw_catalog input[name="search_substring"]').val(), 1);
                                });
                    });

            // attach product handlers
            if (listChanged) {
                // only if changed
                $.each(
                        container,
                        function (index, value) {
                            $(value).find('a[data-type="product"]').on(
                                    'click',
                                    function (e) {
                                        open_product(e.currentTarget.id);
                                    });
                        });
            }

            // unblock UI
            $.unblockUI();
        }
    };

    xhr_search_products_error = function (xhr, textStatus, errorThrown, category_id, keyword, page) {
        if (errorThrown === 'timeout') {
            // reload section on timout
            search_products(category_id, keyword, page);
        }
    };

    open_product = function (product_id, hash) {
        if (!ajax.core.isReady()) {
            return false;
        }

        // block UI
        $.blockUI({
            css: {
                left: jqref_window.width() / 2 - 100
            }
        });

        hash = hash ? hash : window.location.hash;

        var xhr = false;
        try {
            xhr = $.ajax(
                    {
                        url: current_location + '/get_block.php?block=alibaba_wholesale_product',
                        type: 'GET',
                        data: {
                            aw_product_id: product_id
                        },
                        dataType: 'html',
                        complete: function (res, status) {
                            xhr_open_product_complete(res, status, product_id, hash);
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            xhr_open_product_error(xhr, textStatus, errorThrown, product_id, hash);
                        },
                        timeout: 3000 // set timeout to 3 seconds
                    });

            return xhr;

        } catch (e) {

            return false;
        }

        return false;
    };

    xhr_open_product_complete = function (res, status, product_id, hash) {
        // check status
        if (status === 'success') {
            var content = $(res.responseText);
            var title = content.find('h1');

            content.dialog({
                title: title.html(),
                modal: true,
                minWidth: 665,
                minHeight: 650,
                close: function () {
                    window.location.hash = hash;
                    $(this).remove();
                }
            });

            // attach handlers
            content.find('.aw-images > ul li img').on(
                    'hover',
                    function (e) {
                        content.find('.aw-images > div > img').attr('src', e.currentTarget.src);
                    }
            );
            content.find('.aw-images > ul li a[rel="aw-images"]').colorbox(awCboxOpts);

            // unblock UI
            $.unblockUI();
        }
    };

    xhr_open_product_error = function (xhr, textStatus, errorThrown, product_id, hash) {
        if (errorThrown === 'timeout') {
            // reload section on timout
            open_product(product_id, hash);
        }
    };

    $(document).ready(init);
})($);
