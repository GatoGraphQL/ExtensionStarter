# Gato GraphQL - Extension Starter

GitHub template repository to develop and release your extensions for Gato GraphQL.

![Unit tests](https://github.com/GatoGraphQL/ExtensionStarter/actions/workflows/unit_tests.yml/badge.svg)
![Downgrade PHP tests](https://github.com/GatoGraphQL/ExtensionStarter/actions/workflows/downgrade_php_tests.yml/badge.svg)
![Scoping tests](https://github.com/GatoGraphQL/ExtensionStarter/actions/workflows/scoping_tests.yml/badge.svg)
![Generate plugins](https://github.com/GatoGraphQL/ExtensionStarter/actions/workflows/generate_plugins.yml/badge.svg)
![PHPStan](https://github.com/GatoGraphQL/ExtensionStarter/actions/workflows/phpstan.yml/badge.svg)

<!--
@gatographql-project-info

Show a badge for the integration tests against InstaWP

@gatographql-project-action-maybe-required

If these tests are enabled, add the badge code:

![Integration tests](https://github.com/GatoGraphQL/ExtensionStarter/actions/workflows/integration_tests.yml/badge.svg)
-->

## What are Gato GraphQL Extensions?

Gato GraphQL extensions add functionality and expand the GraphQL schema provided by the [Gato GraphQL](https://gatographql.com) plugin.

Check [gatographql.com/extensions](https://gatographql.com/extensions/) to browse the list of existing (commercial) extensions, to give you ideas of what you can do via them.

## About this Extension Starter

`GatoGraphQL/ExtensionStarter` is a [monorepo](https://css-tricks.com/from-a-single-repo-to-multi-repos-to-monorepo-to-multi-monorepo/#aa-stage-3-monorepo), containing the codebase for not only 1, but multiple extension plugins for Gato GraphQL (and also their packages).

`GatoGraphQL/ExtensionStarter` is also a [multi-monorepo](https://css-tricks.com/from-a-single-repo-to-multi-repos-to-monorepo-to-multi-monorepo/#aa-stage-4-multi-monorepo), containing the source code of the main Gato GraphQL plugin, hosted under the [`GatoGraphQL/GatoGraphQL`](https://github.com/GatoGraphQL/GatoGraphQL) monorepo, as a Git submodule.

The monorepo is managed via the [Monorepo Builder](https://github.com/symplify/monorepo-builder).

## Why a multi-monorepo

The benefits of using the multi-monorepo approach as a starter project are several.

**Heads up!** All extensions from [gatographql.com/extensions](https://gatographql.com/extensions/) (that is 26 extensions and 4 bundles to date) are hosted on a repo created from `GatoGraphQL/ExtensionStarter`! So you get access to the same tools as the creators of these commercial extensions are themselves using.

### Everything is automated

There are scripts and workflows to automate (as much as possible) the whole process of creating an extension plugin, from developing it, to testing it, to releasing it.

As a consequence, you only need to concentrate on the actual code for your extension; you won't need to worry about tools and boilerplate for the project (saving you no little time and effort).

### Browse the Gato GraphQL source code

The source code of the Gato GraphQL plugin is always readily-available when developing our extensions, and it is kept up to date just by fetching the Git changes from the upstream repo.

This is important as documentation (mostly when we first start developing with Gato GraphQL) and for debugging (XDebug is integrated out of the box, see below).

### Host the codebase for multiple extensions, and all their packages, all together

The repo contains the source code for not only 1, but multiple extension plugins for Gato GraphQL, and also for all their packages.

By hosting all extensions and their packages together, you avoid [dependency hell](https://en.wikipedia.org/wiki/Dependency_hell).

You are also able to do bulk modifications, such as searching and replacing a piece of code across different plugins, in a single action (and push it to the repo using a single commit).

### Use the same GitHub Actions workflows developed for the Gato GraphQL plugin

The GitHub Actions workflows developed for the Gato GraphQL plugin are readily-available to create and release our extensions. This includes Continuous Integration workflows to:

- Generate the plugin (when merging a PR, or creating a release from a tag)
- Scope the extension plugin
- Downgrade the code from PHP 8.1 (for DEV), to PHP 7.2 (for PROD)
- Run coding standard checks (via PHPCS), unit tests (via PHPUnit) and static code analysis (via PHPStan)
- Run integration tests via InstaWP (automatically installing the newly-generated extension plugin on the InstaWP instance)

### Lando is ready

Lando is already set-up and configured, making 2 webservers available:

1. A webserver to develop the extensions, using PHP 8.1
2. A webserver to test the generated extension plugins, using PHP 7.2

The first Lando webserver (for DEV) maps the source code from the repo to be used within the container. Hence, changes to the source code will be immediately reflected in the webserver.

### XDebug is ready

XDebug is already integrated (when using VSCode), mapping both to the extension's source code, and the main Gato GraphQL plugin's source code.

Then, during development, you can add a break at some point in the code, and analyze the full stack trace to see how the code and logic works.

### Documentation images in the extension are served from the repo

When generating the extension plugin, images to be displayed in the documentation are excluded from the `.zip` file (thus reducing its size), and referenced directly from the GitHub repo (under `raw.githubusercontent.com`).

## Features

The extension starter offers the following features:

### Code Downgrades (PHP 8.1 during DEV, to PHP 7.2 for PROD)

The source code for the main Gato GraphQL plugin, and its extensions, is PHP 8.1.

The plugin for distribution, though, uses PHP 7.2, thanks to a "downgrade" process of its code via [Rector](https://github.com/rectorphp/rector/).

Downgrading code provides the best trade-off between availability of PHP features (during development), and the size of the potential userbase (when releasing the plugin):

- Use the strict typing features from PHP 8.1 (typed properties, union types, and others) to develop the plugin, reducing the possibility it will contain bugs
- Increase the potential number of users who can use your plugin, in production, by releasing it with PHP 7.2

Please notice that not all PHP 8.1 features are available, but only those ones that are "downgradeable" via Rector. Check the list of [Supported PHP features in `GatoGraphQL/GatoGraphQL`](https://github.com/GatoGraphQL/GatoGraphQL/blob/master/docs/supported-php-features.md).

### Monorepo Split

When pushing code to the monorepo, the "monorepo split" feature copies the code for each of the modified plugins and packages into their own GitHub repo.

This is useful for:

- Distributing them via Composer
- Exploring their source code outside of the monorepo

This feature is disabled by default. To enable it, return an empty array in `getExtensionSkipMonorepoSplitPackagePaths()` in [`src/Config/Symplify/MonorepoBuilder/DataSources/MonorepoSplitPackageDataSource.php`](src/Config/Symplify/MonorepoBuilder/DataSources/MonorepoSplitPackageDataSource.php).



* Partial paths to the packages for which to disable doing a
* "monorepo split"
*

*
* (Eg: package "hello-dolly-schema" could be pushed to
* http://github.com/GatoGraphQL/hello-dolly-schema.)
*
* This feature:
*
* Otherwise, it is not needed for creating a Gato GraphQL
* extension plugin (hence all packages are disabled by default).
*
* @gatographql-project-action-maybe-required
*
* 

## Requirements

- [Lando](https://lando.dev/)
- [Composer](https://getcomposer.org/)

### Recommended to use

- [XDebug](https://xdebug.org/) (integrated out of the box when using [VSCode](https://code.visualstudio.com/))

## Create and Initialize your Gato GraphQL Extension Project

Follow these steps:

### 1. Create a new repository from this template

Create your own repository from the `GatoGraphQL/ExtensionStarter` template:

- Click on "Use this template => Create a new repository"
- Select the GitHub owner, and choose a proper name for your repository (eg: `youraccount/GatoGraphQLExtensionsForMyCompany`)
- Choose if to make it Public or Private
- Click on "Create repository"

### 2. Clone the project locally

Once you have created your repository `youraccount/GatoGraphQLExtensionsForMyCompany`, clone it in your local drive using the `--recursive` option (to also clone Git submodule `GatoGraphQL/GatoGraphQL`):

```bash
git clone --recursive https://github.com/youraccount/GatoGraphQLExtensionsForMyCompany
```

### 

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
