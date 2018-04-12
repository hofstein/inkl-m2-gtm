define(['jquery'], function ($) {
    "use strict";

    function gtmEventAddToCart(callback) {

        var gtmTimeout = setTimeout(callback, 2000);

        window.dataLayer.push({
            'event': 'addToCartClick',
            'eventCallback': function () {
                clearTimeout(gtmTimeout);
                callback();
            }
        });
    }

    var submitForm = false;
    var productAddToCartForm = $('#product_addtocart_form');
    if (productAddToCartForm.length > 0) {
        productAddToCartForm.submit(function (e) {
            if (!submitForm) {
                gtmEventAddToCart(function () {
                    submitForm = true;
                    productAddToCartForm.submit();
                });
                if (!submitForm) e.preventDefault();
            }
        });
    }
});