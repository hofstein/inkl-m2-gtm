define(['jquery', 'mage/cookies'], function ($) {
    "use strict";

    var customerEmailSha256 = $.cookie('dataLayerCustomerEmailSha256');
    if (customerEmailSha256) {
        dataLayer.push({
            'customerEmailSha256': customerEmailSha256
        });
    }
});