# This is my package spatie-activitylog-resources

[![Latest Version on Packagist](https://img.shields.io/packagist/v/marwanosama8/spatie-activitylog-resources.svg?style=flat-square)](https://packagist.org/packages/marwanosama8/spatie-activitylog-resources)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/marwanosama8/spatie-activitylog-resources/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/marwanosama8/spatie-activitylog-resources/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/marwanosama8/spatie-activitylog-resources/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/marwanosama8/spatie-activitylog-resources/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/marwanosama8/spatie-activitylog-resources.svg?style=flat-square)](https://packagist.org/packages/marwanosama8/spatie-activitylog-resources)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

# Installation
## First
You need to install Spatie laravel-activitylog, and it's base installation,

follow this page instructions [https://spatie.be/docs/laravel-activitylog/v4/installation-and-setup] 
## Second
install my package to your application,

after successfully install run :
```bash
php artisan spatie-activitylog-resources:install
```



## Usage
Add the plucgen to plugin method placed in your panel service provider 
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
