define(['jquery'], function ($) {
    "use strict";

    $(function() {
        var productAddToCartButton = $('#product-addtocart-button');
        if (productAddToCartButton.length > 0) {
            productAddToCartButton.click(function (e) {
                window.dataLayer.push({
                    'event': 'addToCartClick'
                });
            });
        }
    });
});