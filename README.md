# Laravel User Status

[![Latest Version on Packagist](https://img.shields.io/packagist/v/brianclogan/laravel-user-status.svg?style=flat-square)](https://packagist.org/packages/brianclogan/laravel-user-status)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/brianclogan/laravel-user-status/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/brianclogan/laravel-user-status/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/brianclogan/laravel-user-status/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/brianclogan/laravel-user-status/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/brianclogan/laravel-user-status.svg?style=flat-square)](https://packagist.org/packages/brianclogan/laravel-user-status)

Track user status automatically, or have custom statuses set by the user.

Originally, this package was going to be for users, but I realized that it
could be used for any model that you want to track the status of (ie: Teams). 

So, while it's called Laravel User Status, it can be used for any model that
you want to track the status of.

## Features

- [x] Automatically track user status
- [x] Custom statuses
- [x] Real-time status updates
- [x] Keep history of statuses
- [x] Customizable
- [x] Laravel Echo support


## Installation

You can install the package via composer:

```bash
composer require brianclogan/laravel-user-status
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-user-status-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-user-status-config"
```

This is the contents of the published config file:

```php
return [

    /**
     * Tables
     *
     * The table names used by the package.
     */
    'tables' => [
        'status_table' => 'user_statuses',
    ],

    /**
     * Laravel Echo Configuration
     *
     * This is used to broadcast the status changes to the frontend
     * and update the status in real-time. (if enabled)
     */
    'echo' => [
        /**
         * Enable or disable the broadcasting of the status changes
         */
        'enabled' => false,
        'channel' => 'statusable.{type}.{id}',
        /**
         * Enable or disable the broadcasting of the presence changes
         */
        'presences_enabled' => false,
        'presences' => 'statusable.{type}.{id}.presences',
    ],

    /**
     * Status Model
     *
     * The model used to store the statuses, you can extend the model
     * and change the class here. NOT RECOMMENDED, but possible.
     */
    'status_model' => \BrianLogan\LaravelUserStatus\Models\Status::class,

    /**
     * Keep History
     *
     * If enabled, the package will keep past statuses in the database.
     *
     * This is useful for analytics and other purposes, but is disabled
     * by default to reduce the size of the database.
     *
     * If you enable this, you should also enable the `echo.enabled` option
     * to keep the frontend in sync with the backend.
     *
     * This will update the status model to use a morphMany relationship
     * instead of a morphOne relationship.
     */
    'keep_history' => false,

];
```

## Usage

Add the `HasStatus` trait to the model you want to track the status of.

```php
use BrianLogan\LaravelUserStatus\Traits\HasStatus;

class User extends Model
{
    use HasStatus;
}
```

### Get the latest status
```php
$user = User::find(1);
$user->getLatestStatus();
```

### Set a status

When calling `setStatus`, only the `status` is required. The `reason` and `meta` are optional.

`meta` can be used to store additional information about the status, such as colors, icons, custom messages, etc.

```php
$user = User::find(1);
$user->setStatus(status: 'active', reason: 'User is active', meta: ['foo' => 'bar']);
```
> *NOTE:* If you have `keep_history` enabled, rather than updating the status, it will create a new record. 

## Scopes

### Get all with a specific status

```php
User::whereStatus('active')->get();
```

> *NOTE:* If you have `keep_history` enabled, it will return all records with the status, not just the latest.

### Get all with a specific status reason
```php
User::whereStatusReason('User is active')->get();
```

> *NOTE:* If you have `keep_history` enabled, it will return all records with the status, not just the latest.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Brian Logan](https://github.com/brianclogan)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
