<?php

return [
    "tawk" => [
        "api-key" => env('TAWK_API_KEY'),
        "site-id" => env('TAWK_SITE_ID'),
        "capture-console" => env('TAWK_CAPTURE_CONSOLE', false),
        "capture-screenshot" => env('TAWK_CAPTURE_SCREENSHOT', false),
    ]
];
