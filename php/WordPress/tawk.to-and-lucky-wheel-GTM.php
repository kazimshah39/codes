<?php

add_action('wp_footer', function () {
?>
    <script>
        (function($) {
            'use strict';

            window.dataLayer = window.dataLayer || [];
            window.Tawk_API = window.Tawk_API || {};

            // Tawk.to Chat Started
            window.Tawk_API.onChatStarted = function() {
                window.dataLayer.push({
                    event: 'tawk_to_chat_started'
                });

                if (typeof window.fbq === 'function') {
                    window.fbq('trackCustom', 'tawk_to_chat_started');
                }
            };

            // Lucky Wheel
            $(document).on('wof:play', function(event, data) {
                window.dataLayer.push({
                    event: 'lucky_wheel_submit',
                    wheel_id: data.wheel || null,
                    is_winner: Boolean(data.winning),
                    segment_id: data.segment || null,
                    segment_text: data.segment_text || '',
                    prize: data.segment_prize || ''
                });

                if (typeof window.fbq === 'function') {
                    window.fbq('trackCustom', 'lucky_wheel_submit');
                }
            });

        })(jQuery);
    </script>
<?php
}, 100);
