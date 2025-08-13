# This is my package core

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tenant-forge/core.svg?style=flat-square)](https://packagist.org/packages/tenant-forge/core)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/tenant-forge/core/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/tenant-forge/core/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/tenant-forge/core/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/tenant-forge/core/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/tenant-forge/core.svg?style=flat-square)](https://packagist.org/packages/tenant-forge/core)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require tenant-forge/core
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="core-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="core-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="core-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$core = new TenantForge\Core();
echo $core->echoPhrase('Hello, TenantForge!');
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

- [Francisco Barrento](https://github.com/fbarrento)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
