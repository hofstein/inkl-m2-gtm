define(['jquery'], function ($) {
    "use strict";

    var productClickHandler = {

        bindEvents: function () {
            var self = this;

            $('.toolbar:last-child').prevAll('.product-list').find('a:not([href*="#"])').each(function (index, element) {
                var $element = $(element);
                var clickData = {
                    'index': index,
                    'url': $element.attr('href')
                };

                $element.click(clickData, self.onClick);
                $element.parents('li').find('.product-list-click').each(function (index, element) {
                    var $element = $(element);
                    clickData.origHandler = $(this).prop('onclick');

                    $element.removeProp('onclick');
                    $element.click(clickData, self.onClick);
                });
            });
        },

        onClick: function (e) {
            try {
                if (typeof window.google_tag_manager !== 'undefined') {
                    var impressionProducts = productClickHandler.getImpressionProducts();
                    var productData = impressionProducts[e.data.index];

                    productClickHandler.sendGtmEvent(productData, e.data.url);

                    e.stopPropagation();
                    e.preventDefault();
                    return false;
                }
            } catch (exception) {
                console.log(exception);
            }

            if (e.data.hasOwnProperty('origHandler'))
            {
                e.data.origHandler();
            }
        },

        sendGtmEvent: function (productData, url) {
            var dataLayerData = {
                'event': 'productClick',
                'actionField': {'list': productData['list']},
                'ecommerce': {
                    'click': {
                        'products': [productData]
                    }
                },
                'eventCallback': function () {
                    // location.href = url;
                    console.log('redirect');
                },
                'eventTimeout': 500
            };

            window.dataLayer.push(dataLayerData);
        },

        getImpressionProducts: function () {

            var dataLayerImpressions = window.dataLayer.filter(function (item) {
                return (
                    item.ecommerce !== undefined &&
                    item.ecommerce.impressions !== undefined
                );
            });

            if (dataLayerImpressions.length > 0) {
                return dataLayerImpressions[0]['ecommerce']['impressions'];
            }

            return [];
        }

    };

    $(function () {
        productClickHandler.bindEvents();
    });
});