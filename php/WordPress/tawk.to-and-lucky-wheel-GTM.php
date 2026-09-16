<?php
add_action('wp_footer', function () {
    ?>
        <script>
            (function($) {
                'use strict';

                window.dataLayer = window.dataLayer || [];
                window.Tawk_API = window.Tawk_API || {};

                // ----------------------------------------------------
                // Tawk.to: Track Chat Started (First Visitor Message)
                // ----------------------------------------------------
                var isChatStarted = false;

                // Neutralize proactive greetings/triggers from falsely firing chat started
                window.Tawk_API.onChatStarted = function() {};

                // Fire event only when visitor actually sends a message
                window.Tawk_API.onChatMessageVisitor = function() {
                    if (isChatStarted) return;
                    isChatStarted = true;

                    window.dataLayer.push({
                        event: 'tawk_to_chat_started'
                    });

                    if (typeof window.fbq === 'function') {
                        window.fbq('trackCustom', 'tawk_to_chat_started');
                    }
                };

                // Reset state when chat concludes
                window.Tawk_API.onChatEnded = function() {
                    isChatStarted = false;
                };

                // ----------------------------------------------------
                // Lucky Wheel
                // ----------------------------------------------------
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
