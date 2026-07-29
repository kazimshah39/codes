<?php
add_action('wp_footer', function () {
?>
<script>
    // Initialize the existing GTM dataLayer without overwriting it
    window.dataLayer = window.dataLayer || [];

    /**
     * Tawk.to Chat Started
     */
    var Tawk_API = window.Tawk_API = window.Tawk_API || {};

    Tawk_API.onChatStarted = function () {

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
     * Lucky Wheel
     */
    jQuery(function ($) {
        $.ajaxPrefilter(function (options) {

            var requestData = options.data || '';

            var isLuckyWheelRequest =
                (
                    typeof requestData === 'string' &&
                    requestData.indexOf('action=wof-email-optin') !== -1
                ) ||
                (
                    typeof requestData === 'object' &&
                    requestData.action === 'wof-email-optin'
                );

            if (isLuckyWheelRequest) {

                // Preserve the plugin's existing success callback
                var originalSuccess = options.success;

                options.success = function (response) {

                    // Run the plugin's original success callback first
                    if (typeof originalSuccess === 'function') {
                        originalSuccess.apply(this, arguments);
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
                };
            }
        });
    });
</script>
<?php
}, 100);
