# Laravel Hookable

[![Latest Version on Packagist](https://img.shields.io/packagist/v/saschaende/laravel-hookable.svg?style=flat-square)](https://packagist.org/packages/saschaende/laravel-hookable)

Laravel Hookable is a package that allows you to easily add hooks (actions and filters) to your Laravel applications,
similar to the hook system in WordPress.

## Installation

You can install the package via Composer:

```bash
composer require saschaende/laravel-hookable
```

## Usage

### Adding Hooks

You can add hooks using the `Hookable` facade. There are two types of hooks: actions and filters.

#### Actions

Actions are hooks that do not modify data. You can add an action like this:

```php
use SaschaEnde\Hookable\Facades\Hookable;
Hookable::action('my_action', function ($arg1, $arg2) {
    // Do something with $arg1 and $arg2
});
```

You can then trigger the action like this:

```php
Hookable::action('my_action', $arg1, $arg2);
```

#### Filters

Filters are hooks that modify data. You can add a filter like this:

```php
use SaschaEnde\Hookable\Facades\Hookable;
Hookable::filter('my_filter', function ($value) {
    // Modify $value
    return $value;
});
```

You can then apply the filter like this:

```php
$value = Hookable::applyFilters('my_filter', $value);
```

### Priorities and Arguments

You can specify the priority and number of arguments for your hooks.

```php
Hookable::filter('my_action', function ($arg1, $arg2) {
    // Do something
}, 20);
```

In this example, the action will be executed with a priority of 20 and will receive
2 arguments.

## Testing

You can run the tests using PHPUnit:

```bash
vendor/bin/phpunit
```

## Contributing

Contributions are welcome! Please submit a pull request or open an issue on GitHub.

## License

This package is open-sourced software licensed under the MIT license.

