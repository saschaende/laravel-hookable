# Laravel Hookable

[![Latest Version on Packagist](https://img.shields.io/packagist/v/saschaende/laravel-hookable.svg?style=flat-square)](https://packagist.org/packages/saschaende/laravel-hookable)

Laravel Hookable is a package that allows you to use hooks (actions and filters) in Laravel applications – similar to the hook system in WordPress.

## Installation

You can install the package via Composer:

```bash
composer require saschaende/laravel-hookable
```

The package is automatically registered by Laravel (see `composer.json`).

## How it works

- **Actions**: Execute code without modifying data (e.g., for events or extensions).
- **Filters**: Allow modification of data.

The package provides a `Hookable` facade that exposes the main methods. The binding is handled automatically via the ServiceProvider.

## Usage

### Adding actions

```php
use SaschaEnde\Hookable\Facades\Hookable;

Hookable::action('my_action', function ($arg1, $arg2) {
    // Do something with $arg1 and $arg2
});
```

To execute the action (e.g., at a specific point in your code):

```php
Hookable::renderActions('my_action', $arg1, $arg2);
```

### Adding filters

```php
use SaschaEnde\Hookable\Facades\Hookable;

Hookable::filter('my_filter', function ($value) {
    // Modify $value
    return $value;
});
```

Apply the filter:

```php
$value = Hookable::applyFilters('my_filter', $value);
```

### Priorities and arguments

You can specify the priority and the number of arguments for hooks:

```php
Hookable::action('my_action', function ($arg1, $arg2) {
    // Do something
}, 20);
```

In this example, the action will be executed with priority 20 and will receive 2 arguments.

## Blade Directives

The package registers two Blade directives to use hooks directly in Blade templates:

```blade
@applyFilter('my_filter', $value)
@doAction('my_action', $arg1, $arg2)
```

- `@applyFilter('filter_name', $value)`: Applies a filter to a value and outputs the result.
- `@doAction('action_name', ...)`: Executes an action and outputs its result.

## Testing

You can run the tests using PHPUnit:

```bash
vendor/bin/phpunit
```

## Contributing

Contributions are welcome! Please submit a pull request or open an issue on GitHub.

## License

This package is open-source software licensed under the MIT license.
