<?php

add_action('wp_footer', function () {
?>
<script>
    // Initialize GTM dataLayer
    window.dataLayer = window.dataLayer || [];

    // Initialize Tawk API
    window.Tawk_API = window.Tawk_API || {};

    /**
     * Tawk.to chat started
     */
    window.Tawk_API.onChatStarted = function () {

        // Fire Google event through GTM
        window.dataLayer.push({
            event: 'tawk_to_chat_started'
        });

        // Fire Meta/Facebook event directly
        if (typeof fbq === 'function') {
            fbq('trackCustom', 'tawk_to_chat_started');
        }
    };

    /**
     * Lucky Wheel successful submission
     */
    jQuery(function ($) {

        $(document).ajaxSuccess(function (event, xhr, settings) {

            var requestData = settings.data || '';

            // Check whether this is the Lucky Wheel AJAX request
            var isLuckyWheelRequest =
                (
                    typeof requestData === 'string' &&
                    requestData.indexOf('action=wof-email-optin') !== -1
                ) ||
                (
                    typeof requestData === 'object' &&
                    requestData.action === 'wof-email-optin'
                );

            if (!isLuckyWheelRequest) {
                return;
            }

            var response = xhr.responseJSON;

            // Parse the response if it was not automatically parsed
            if (!response && xhr.responseText) {
                try {
                    response = JSON.parse(xhr.responseText);
                } catch (error) {
                    return;
                }
            }

            if (response && response.success === true) {

                // Fire Google event through GTM
                window.dataLayer.push({
                    event: 'lucky_wheel_submit'
                });

                // Fire Meta/Facebook event directly
                if (typeof fbq === 'function') {
                    fbq('trackCustom', 'lucky_wheel_submit');
                }
            }
        });
    });
</script>
<?php
}, 100);
