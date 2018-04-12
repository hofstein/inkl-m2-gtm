define(['jquery', 'mage/cookies'], function ($) {
    "use strict";

    var customerEmail = $.cookie('dataLayerCustomerEmail');
    if (customerEmail) {
        dataLayer.push({
            'customerEmail': customerEmail
        });
    }
});