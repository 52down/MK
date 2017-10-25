/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Amazon Feeds controller
 */

(function ($) {

    var currentFeed = '';
    var loopGuard = 0;

    onObtainMarketplaces = function ()
    {
        $('<form method="post" action="configuration.php?option=Amazon_Feeds&controller=GetMarketplaces"></form>')
                .appendTo('body').submit();
    };

    onBeforeUnload = function ()
    {
        if (typeof txt_amazon_feeds_on_close_page_warning !== 'undefined') {
            return txt_amazon_feeds_on_close_page_warning;
        }
    };

    onSubmitFeeds = function ()
    {
        $.post('configuration.php?option=Amazon_Feeds&controller=FeedsSubmit');
        setTimeout(getProgress, 1500);
    };

    onFeedsResults = function ()
    {
        $.post('configuration.php?option=Amazon_Feeds&controller=FeedsResults');
        setTimeout(getProgress, 1500);
    };

    redirectToFeeds = function() {
        $(window).off('beforeunload', onBeforeUnload);

        setTimeout(function () {
            window.location = 'configuration.php?option=Amazon_Feeds&controller=Feeds';
        }, 1000);
    };

    getProgress = function ()
    {
        $.getJSON('configuration.php?option=Amazon_Feeds&controller=FeedsProgress')
            .done(function (data) {

                if (!data) {
                    setTimeout(getProgress, 1500);
                    loopGuard++;
                    if (loopGuard > 10) {
                        redirectToFeeds();
                    }
                    return;
                }

                loopGuard = 0;

                var feedText = (
                    data.feed !== '::begin'
                        && data.feed !== '::end'
                    ? ': ' + data.feed + ' ( #progress#% ) '
                    : ' #progress#% '
                );

                if (currentFeed !== feedText) {
                    var tmp = currentFeed;
                    currentFeed = feedText;
                    // complete previous feed
                    if (tmp) {
                        feedText = tmp;
                        data.progress = 100;
                    }
                }

                $('.afds-progress-bar').css({width: data.progress + '%'});

                var textElement = $('.afds-progress-bar-text');
                textElement.text(data.step.name + feedText.replace('#progress#', data.progress));

                if (data.progress >= 55) {
                    textElement.addClass('afds-text-light');
                } else {
                    textElement.removeClass('afds-text-light');
                }

                if (
                    data.feed === '::end'
                    && data.progress === 100
                ) {

                    redirectToFeeds();

                } else {

                    setTimeout(getProgress, 1500);
                }
            });
    };

    onFeedsProductTypeChange = function () {
        var element = $(this);
        var result = (element.val() !== '');

        if (!result) {
            element.parent().addClass('fill-error');
        } else {
            element.parent().removeClass('fill-error');
        }
    };

    onFeedsDetailsFormSubmit = function() {
        var element = $('[name="product[amazon_feeds_product_type]"]');
        var value = element.val();

        onFeedsProductTypeChange.apply(element);

        return value !== '';
    };

    init = function () {
        $('.afds-get-marketplaces').on('click', onObtainMarketplaces);

        if ($('.afds-progress[data-controller="FeedsSubmit"]').length > 0) {
            $(window).on('beforeunload', onBeforeUnload);
            onSubmitFeeds();
        }

        if ($('.afds-progress[data-controller="FeedsResults"]').length > 0) {
            $(window).on('beforeunload', onBeforeUnload);
            onFeedsResults();
        }

        $('form[name="productfeedsdetailsform"]').on('submit', onFeedsDetailsFormSubmit);
        $('[name="product[amazon_feeds_product_type]"]').on('change', onFeedsProductTypeChange);
    };

    $(document).ready(init);

})(jQuery);
