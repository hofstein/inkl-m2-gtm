define(['jquery', 'mage/cookies'], function ($) {
    "use strict";

    var customerEmailSha1 = $.cookie('dataLayerCustomerEmailSha1');
    if (customerEmailSha1) {
        dataLayer.push({
            'customerEmailSha1': customerEmailSha1
        });
    }
});