# Gato GraphQL - Extension Starter

GitHub template repository to quickstart your extension for Gato GraphQL.

![Unit tests](https://github.com/GatoGraphQL/ExtensionStarter/actions/workflows/unit_tests.yml/badge.svg)<!-- ![Integration tests](https://github.com/GatoGraphQL/ExtensionStarter/actions/workflows/integration_tests.yml/badge.svg) -->
![Downgrade PHP tests](https://github.com/GatoGraphQL/ExtensionStarter/actions/workflows/downgrade_php_tests.yml/badge.svg)
![Scoping tests](https://github.com/GatoGraphQL/ExtensionStarter/actions/workflows/scoping_tests.yml/badge.svg)
![Generate plugins](https://github.com/GatoGraphQL/ExtensionStarter/actions/workflows/generate_plugins.yml/badge.svg)
![PHPStan](https://github.com/GatoGraphQL/ExtensionStarter/actions/workflows/phpstan.yml/badge.svg)

## Requirements

- PHP 8.1+ for development
- PHP 7.2+ for production

## Install

Clone the monorepo, with the `--recursive` (to also clone submodule `GatoGraphQL/GatoGraphQL`):

```bash
git clone --recursive https://github.com/GatoGraphQL/ExtensionStarter.git
```

And then install all the dependencies, via Composer

```bash
$ cd {project folder}
$ composer install
$ cd submodules/GatoGraphQL
$ composer install
```

## Standards

[PSR-1](https://www.php-fig.org/psr/psr-1), [PSR-4](https://www.php-fig.org/psr/psr-4) and [PSR-12](https://www.php-fig.org/psr/psr-12).

To check the coding standards via [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer), run:

``` bash
composer check-style
```

To automatically fix issues, run:

``` bash
composer fix-style
```

## Testing

To execute [PHPUnit](https://phpunit.de/), run:

``` bash
composer test
```

## Static analysis

To execute [PHPStan](https://github.com/phpstan/phpstan), run:

``` bash
composer analyse
```

## Previewing code downgrade

Via [Rector](https://github.com/rectorphp/rector) (dry-run mode):

```bash
composer preview-code-downgrade
```

## Report issues

Use the [issue tracker](https://github.com/GatoGraphQL/ExtensionStarter/issues) to report a bug or request a new feature for all packages in the monorepo.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email name@mycompany.com instead of using the issue tracker.
