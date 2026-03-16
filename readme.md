# Tawk for Laravel

![Tawk for Laravel masthead image.](https://repository-images.githubusercontent.com/204191162/32612b80-f346-11e9-8bff-dca042a4ae5d)

Easily and quickly integrate [Tawk.to]() LiveChat into your laravel app in under
5 minutes!

## Features
- all the default Tawk.to LiveChat features.
- automatic user identification (for logged-in users).
- secure chat API (for logged-in users).

## Requirements
- PHP 8.2+
- Laravel 8.0+

## Supported Versions

| PHP | Laravel |
|-----|---------|
| 8.2 | 8.x – 11.x |
| 8.3 | 8.x – 11.x |
| 8.4 | 8.x – 11.x |
| 8.5 | 8.x – 11.x |


## Installation
```sh
composer require "genealabs/laravel-tawk:*"
```

## Configuration
Refer to the Property Settings page in your Tawk.to dashboard for the required
values. Add the following to your `.env` file:
```
TAWK_API_KEY=xxxxxxxxxxxxxxx
TAWK_SITE_ID=yyyyyyyyyyyyyyy
```

## Implementation
### Laravel App
Add the following to your layout blade template immediately before the closing
`</body>` tag:
```php
            @tawk
//      </body>
// </html>
```

### Laravel Nova
If you are using Laravel Nova as a dashboard for your users, first publish the
layout blade template, then insert the blade directive immediate prior to the
closing `</body>` tag in `resources/views/vendor/nova/layout.blade.php`:
```php
            @tawk
//      </body>
// </html>
```


### Screenshot Capture
To automatically take a screenshot of the page when a visitor starts a chat, add the following to your `.env`:
```
TAWK_CAPTURE_SCREENSHOT=true
```

When enabled, html2canvas (loaded from CDN) captures the visible page and sends it as a Tawk.to custom attribute. The screenshot appears in the agent dashboard as a base64 JPEG image.

**Note:** Screenshots are compressed (50% scale, 60% JPEG quality) to stay within Tawk.to's attribute size limits. Very large pages may exceed the limit and the screenshot will be skipped.

