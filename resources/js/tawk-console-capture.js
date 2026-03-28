/**
 * Tawk.to Console Capture
 *
 * Intercepts browser console output (log, warn, error) and sends it
 * as custom attributes to Tawk.to when a chat is started.
 *
 * Enable via config: TAWK_CAPTURE_CONSOLE=true
 */
(function() {
    var maxEntries = 50;
    var consoleLogs = [];

    var originalLog = console.log;
    var originalWarn = console.warn;
    var originalError = console.error;

    function capture(level, args) {
        var message = Array.prototype.slice.call(args).map(function(arg) {
            if (typeof arg === 'object') {
                try { return JSON.stringify(arg); } catch(e) { return String(arg); }
            }
            return String(arg);
        }).join(' ');

        consoleLogs.push({
            level: level,
            message: message.substring(0, 500),
            time: new Date().toISOString()
        });

        if (consoleLogs.length > maxEntries) {
            consoleLogs.shift();
        }
    }

    console.log = function() {
        capture('log', arguments);
        originalLog.apply(console, arguments);
    };

    console.warn = function() {
        capture('warn', arguments);
        originalWarn.apply(console, arguments);
    };

    console.error = function() {
        capture('error', arguments);
        originalError.apply(console, arguments);
    };

    // Also capture unhandled errors
    window.addEventListener('error', function(event) {
        capture('error', [event.message + ' at ' + event.filename + ':' + event.lineno]);
    });

    window.addEventListener('unhandledrejection', function(event) {
        capture('error', ['Unhandled Promise: ' + String(event.reason)]);
    });

    // Send console logs when Tawk chat starts
    if (typeof Tawk_API !== 'undefined') {
        Tawk_API.onChatStarted = function() {
            if (consoleLogs.length === 0) return;

            var errors = consoleLogs.filter(function(l) { return l.level === 'error'; });
            var warnings = consoleLogs.filter(function(l) { return l.level === 'warn'; });

            var summary = 'Errors: ' + errors.length + ', Warnings: ' + warnings.length + ', Total: ' + consoleLogs.length;

            var recentErrors = errors.slice(-10).map(function(l) {
                return '[' + l.time + '] ' + l.message;
            }).join('\n');

            var recentLogs = consoleLogs.slice(-20).map(function(l) {
                return '[' + l.level.toUpperCase() + ' ' + l.time + '] ' + l.message;
            }).join('\n');

            Tawk_API.setAttributes({
                'console-summary': summary,
                'console-errors': recentErrors || 'None',
                'console-log': recentLogs
            }, function(error) {});
        };
    }
})();
