<?php

return [
    "tawk" => [
        "api-key" => env('TAWK_API_KEY'),
        "site-id" => env('TAWK_SITE_ID'),
        "capture-console" => env('TAWK_CAPTURE_CONSOLE', false),
        "capture-screenshot" => env('TAWK_CAPTURE_SCREENSHOT', false),
        "html2canvas-url" => env('TAWK_HTML2CANVAS_URL', 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js'),
    ]
];
