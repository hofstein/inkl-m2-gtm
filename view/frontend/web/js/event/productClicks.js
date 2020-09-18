define(['jquery'], function ($) {
    "use strict";

    var productClickHandler = {

        bindEvents: function () {
            var self = this;

            $('.toolbar').nextAll('.product-list').children('li').each(function (index, element) {
                $(element).click({
                    'index': index,
                    'url': $(element).find('a:not([href*=#])').attr('href')
                }, self.onClick);
            });
        },

        onClick: function (e) {

            try {
                var impressionProducts = productClickHandler.getImpressionProducts();
                var productData = impressionProducts[e.data.index];

                productClickHandler.sendGtmEvent(productData, e.data.url);

                e.preventDefault();
                return false;
            } catch (exception) {
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
                    location.href = url;
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