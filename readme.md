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

## Troubleshooting

### Blank page / Tawk widget not appearing
1. **Check your `.env` values:** Ensure `TAWK_SITE_ID` and `TAWK_API_KEY` are set correctly. You can find these in your Tawk.to dashboard under Property Settings.
2. **Clear config cache:** Run `php artisan config:clear` after updating `.env`.
3. **Check the HTML source:** View your page source and look for the Tawk.to script tag. If it's missing entirely, the `@tawk` directive may not be in your layout. If it shows a comment about missing `TAWK_SITE_ID`, update your `.env`.
4. **Check browser console:** Open the browser developer tools console for JavaScript errors.
5. **Verify the directive placement:** The `@tawk` directive must be placed immediately before the closing `</body>` tag in your layout blade template.
