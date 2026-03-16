/**
 * Tawk.to Screenshot Capture
 *
 * Takes a screenshot of the page using html2canvas when a chat starts
 * and sends it as a Tawk.to event/attribute.
 *
 * Enable via config: TAWK_CAPTURE_SCREENSHOT=true
 *
 * Requires html2canvas loaded on the page (loaded from CDN automatically).
 */
(function() {
    // Load html2canvas from CDN
    var script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js';
    script.integrity = 'sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoFM/HPeLTC2BbQG0e2LOKKL7lXIA==';
    script.crossOrigin = 'anonymous';
    script.referrerPolicy = 'no-referrer';
    document.head.appendChild(script);

    function captureScreenshot(callback) {
        if (typeof html2canvas === 'undefined') {
            callback(null);
            return;
        }

        try {
            html2canvas(document.body, {
                logging: false,
                useCORS: true,
                scale: 0.5,
                width: window.innerWidth,
                height: window.innerHeight,
                windowWidth: window.innerWidth,
                windowHeight: window.innerHeight,
            }).then(function(canvas) {
                var dataUrl = canvas.toDataURL('image/jpeg', 0.6);
                callback(dataUrl);
            }).catch(function() {
                callback(null);
            });
        } catch(e) {
            callback(null);
        }
    }

    if (typeof Tawk_API !== 'undefined') {
        Tawk_API.onChatStarted = function() {
            captureScreenshot(function(dataUrl) {
                if (!dataUrl) return;

                // Send as custom attribute (truncated if too long for Tawk limits)
                // Tawk custom attributes have a ~32KB limit
                if (dataUrl.length < 32000) {
                    Tawk_API.setAttributes({
                        'page-screenshot': dataUrl
                    }, function(error) {});
                }

                // Also send as an event with page info
                Tawk_API.addEvent('screenshot-captured', {
                    url: window.location.href,
                    viewport: window.innerWidth + 'x' + window.innerHeight,
                    timestamp: new Date().toISOString()
                }, function(error) {});
            });
        };
    }
})();
