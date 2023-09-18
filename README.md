![Unit tests](https://github.com/GatoGraphQL/GatoGraphQL/actions/workflows/unit_tests.yml/badge.svg)![Downgrade PHP tests](https://github.com/GatoGraphQL/GatoGraphQL/actions/workflows/downgrade_php_tests.yml/badge.svg)
![Scoping tests](https://github.com/GatoGraphQL/GatoGraphQL/actions/workflows/scoping_tests.yml/badge.svg)
![Generate plugins](https://github.com/GatoGraphQL/GatoGraphQL/actions/workflows/generate_plugins.yml/badge.svg)
![PHPStan](https://github.com/GatoGraphQL/GatoGraphQL/actions/workflows/phpstan.yml/badge.svg)

# My Extension

This a Gato GraphQL extension.

@todo Complete!!!

## Installation

Download [the latest release of the plugin][latest-release-url] as a .zip file.

Then, in the WordPress admin:

- Go to `Plugins => Add New`
- Click on `Upload Plugin`
- Select the .zip file
- Click on `Install Now` (it may take a few minutes)
- Once installed, click on `Activate`

Requirements:

- WordPress 5.4+
- PHP 7.2+

## Development

- [Setting-up the development environment](docs/development-environment.md)
- [Running tests](docs/running-tests.md)

### Supported PHP features

Check the list of [Supported PHP features](docs/supported-php-features.md).

### Gutenberg JS builds

Compiled JavaScript code (such as all files under a block's `build/` folder) is added to the repo, but only as compiled for production, i.e. after running `npm run build`.

Code compiled for development, i.e. after running `npm start`, cannot be commited/pushed to the repo.

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

<!-- ## Release notes

... -->

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

To execute [PHPUnit](https://phpunit.de/), run:

``` bash
composer test
```

## Static Analysis

To execute [PHPStan](https://github.com/phpstan/phpstan), run:

``` bash
composer analyse
```

## Downgrading code

To visualize how [Rector](https://github.com/rectorphp/rector) will downgrade the code to PHP 7.2:

```bash
composer preview-code-downgrade
```

## Report issues

@todo Complete!!!

## Contributing

@todo Complete!!!

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email leo@getpop.org instead of using the issue tracker.

## Credits

- [Leonardo Losoviz][link-author]

## License

@todo Complete!!!

GPLv2 or later. Please see [License File](LICENSE.md) for more information.

[ico-license]: https://img.shields.io/badge/license-GPL%20(%3E%3D%202)-brightgreen.svg?style=flat-square
[ico-release]: https://img.shields.io/github/release/GatoGraphQL/GatoGraphQL.svg
[ico-downloads]: https://img.shields.io/github/downloads/GatoGraphQL/GatoGraphQL/total.svg

[link-author]: https://github.com/leoloso
[latest-release-url]: https://github.com/GatoGraphQL/GatoGraphQL/releases/download/1.0.6/gatographql-1.0.6.zip
