# This is my package spatie-activitylog-resources


[![Latest Version on Packagist](https://img.shields.io/packagist/v/marwanosama8/spatie-activitylog-resources?style=flat-square)](https://packagist.org/packages/marwanosama8/spatie-activitylog-resources)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=flat-square&logo=php)](https://www.php.net/)
[![Laravel](https://img.shields.io/badge/Laravel-10%20%7C%2011-red?style=flat-square&logo=laravel)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-v3-orange?style=flat-square)](https://filamentphp.com)
[![License](https://img.shields.io/packagist/l/marwanosama8/spatie-activitylog-resources?style=flat-square)](LICENSE)
[![Status](https://img.shields.io/badge/status-stable-brightgreen?style=flat-square)](#)


This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

# Installation
## First
You need to install Spatie laravel-activitylog, and it's base installation,

follow this page instructions [https://spatie.be/docs/laravel-activitylog/v4/installation-and-setup] 
## Second
Install my package to your application,

after successfully install run :
```bash
php artisan spatie-activitylog-resources:install
```



## Usage
Add the plugin to plugin method placed in your panel service provider 
```php
// Ex: AdminServiceProvider
 return $panel
            ->plugins([
                SpatieActivitylogResourcesPlugin::make()
                    ]);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [marwanosama8](https://github.com/marwanosama8)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
