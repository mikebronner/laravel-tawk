# Tawk for Laravel
Easily and quickly integrate [Tawk.to]() LiveChat into your laravel app in under
5 minutes!

## Features
- all the default Tawk.to LiveChat features.
- automatic user identification (for logged-in users).
- secure chat API (for logged-in users).

## Requirements
- Laravel 5.8+

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
closing `</body>` tag:
```php
            @tawk
//      </body>
// </html>
```
