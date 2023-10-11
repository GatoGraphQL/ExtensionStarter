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

## Requirements

- PHP 8.1
- [Lando](https://lando.dev/)
- [Composer](https://getcomposer.org/)

### Recommended to use

- [XDebug](https://xdebug.org/) (integrated out of the box when using [VSCode](https://code.visualstudio.com/))

## What are Gato GraphQL Extensions?

Gato GraphQL extensions add functionality and expand the GraphQL schema provided by the [Gato GraphQL](https://gatographql.com) plugin.

Check [gatographql.com/extensions](https://gatographql.com/extensions/) to browse the list of existing (commercial) extensions, to give you ideas of what you can do via them.

## Install

Follow these steps:

### Create your repo from this template

Create your own repository from the `GatoGraphQL/ExtensionStarter` template:

- Click on "Use this template => Create a new repository"
- Select the GitHub owner, and choose a proper name for your repository (eg: `my-account/GatoGraphQLExtensionsForMyCompany`)
- Choose if to make it Public or Private
- Click on "Create repository"

### Disable unused GitHub Actions workflows

The following GitHub Actions workflows are not initially needed:

- [`integration_tests.yml`](.github/workflows/integration_tests.yml): You need to configure InstaWP first
- [`split_monorepo_tagged.yml`](.github/workflows/split_monorepo_tagged.yml): The "Monorepo Split" is not enabled by default (see section "Monorepo Split" below)
- [`split_monorepo.yml`](.github/workflows/split_monorepo.yml): Same as above

As such, you can [disable these workflows](https://docs.github.com/en/actions/using-workflows/disabling-and-enabling-a-workflow) so they don't run unnecessarily.

### Clone your repo locally

Once you have created your repository, clone it in your local drive using the `--recursive` option (needed to clone Git submodule `GatoGraphQL/GatoGraphQL`):

```bash
git clone --recursive https://github.com/my-account/GatoGraphQLExtensionsForMyCompany
```

### Install Composer dependencies

Run:

```bash
$ cd {project folder}
$ cd submodules/GatoGraphQL && composer install && cd ../.. && composer install
```

### Initialize the Project

This step will replace all the generic strings in the extension starter (the PHP namespace `MyCompanyForGatoGraphQL`, company name `My Company`, and others) with the values corresponding to your project.

Input your values in the command below and run:

```bash
composer initialize-project -- \
  --php-namespace-owner=MyCompanyName \
  --my-company-name="My Company Name" \
  --my-company-email=email@mycompany.com \
  --my-company-website=https://www.mycompany.com
```

These arguments (and additional ones, see below) are optional. If any of them is not provided, a default value is computed from the configuration in Git and the GitHub repo.

To see the default values, run:

```bash
composer initialize-project -- --dry-run
```

<details>

<summary>All <code>initialize-project</code> command arguments</summary>

To print all the arguments for the `initialize-project` command, run:

```bash
composer initialize-project -- --help
```

This will print:

| Option | Description |
| --- | --- |
| `--git-base-branch` | Base branch of the GitHub repository where this project is hosted. If not provided, this value is retrieved using `git` |
| `--git-user-name` | Git user name, to "split" code and push it to a different repo when merging a PR. If not provided, this value is retrieved from the global `git` config |
| `--git-user-email` | Git user email, to "split" code and push it to a different repo when merging a PR. If not provided, this value is retrieved from the global `git` config |
| `--github-repo-owner` | Owner of the GitHub repository where this project is hosted (eg: "GatoGraphQL" in "https://github.com/GatoGraphQL/ExtensionStarter"). If not provided, this value is retrieved using `git` |
| `--github-repo-name` | Name of the GitHub repository where this project is hosted (eg: "ExtensionStarter" in "https://github.com/GatoGraphQL/ExtensionStarter"). If not provided, this value is retrieved using `git` |
| `--docs-git-base-branch` | Base branch of the (public) GitHub repository hosting the documentation for the extension, to access the images in PROD. If not provided, the value for option `git-base-branch` is used |
| `--docs-github-repo-owner` | Owner of the (public) GitHub repository hosting the documentation for the extension, to access the images in PROD. If not provided, the value for option `github-repo-owner` is used |
| `--docs-github-repo-name` | Name of the (public) GitHub repository hosting the documentation for the extension, to access the images in PROD. If not provided, the value for option `github-repo-name` is used |
| `--php-namespace-owner` | PHP namespace owner to use in the codebase (eg: "MyCompanyName"). If not provided, the value from the "github-repo-owner" option is used |
| `--composer-vendor` | Composer vendor to distribute the packages in the repo. If not provided, it is generated from the "php-namespace-owner" option |
| `--my-company-name` | Name of the person or company owning the extension. If not provided, the value for option `git-user-name` is used |
| `--my-company-email` | Email of the person or company owning the extension. If not provided, the value for option `git-user-email` is used |
| `--my-company-website` | Website of the person or company owning the extension. If not provided, the GitHub repo for this project is used |

</details>

### Review the License

The [license in the monorepo](LICENSE) is GPL v2.

If this this not your license, remove/replace this file.

### Commit, Push and Tag the Initial Project

Review the changes applied to the codebase on the step above. If any value is not correct (eg: if the PHP namespace should be a different one), you can undo all changes, and run `composer initialize-project` again providing the right values.

Once all values are right, run:

```bash
git add . && git commit -m "Initialized project" && git push origin && git tag 0.0.0 && git push --tags
```

This will commit the codebase to your GitHub repo, and tag it with version `0.0.0`. (This tag is needed to start incrementing the version automatically from now on.)

## Build the Lando webserver for DEV

This Lando webserver uses:

- The source code on the repo
- PHP 8.1
- XDebug enabled

To build the webserver, run:

```bash
composer build-server
```

After a few minutes, the website will be available under `https://gatographql-{composer-vendor}-extensions.lndo.site`.

(`{composer-vendor}` is an argument to the `initialize-project` command above; its default value is generated from the `php-namespace-owner` option.)

The URL is printed on the console under "APPSERVER URLS" (you will need to scroll up):

![Lando webserver URL](assets/img/lando-webserver-url.png)

To print the URL again, run:

```bash
composer server-info
```

<details>

<summary>Additional plugins installed in the webserver</summary>

In addition to the main Gato GraphQL plugin, 2 other plugins are installed:

- [Gato GraphQL - Testing](submodules/GatoGraphQL/layers/GatoGraphQLForWP/phpunit-plugins/gatographql-testing/gatographql-testing.php)
- [Gato GraphQL - Testing Schema](submodules/GatoGraphQL/layers/GatoGraphQLForWP/plugins/testing-schema/gatographql-testing-schema.php)

These are utilities to run integration tests for Gato GraphQL (for instance, to install the "Dummy CPT" to test field `Root.customPosts`, and others).

Besides, some initial configuration has been applied on the Gato GraphQL plugin Settings. That's why the single endpoint is enabled (otherwise, it will be disabled by default).

</details>

### `wp-admin` login credentials

- Username: `admin`
- Password: `admin`

### Using XDebug

XDebug is enabled but inactive.

To activate XDebug for a request, append parameter `?XDEBUG_TRIGGER=1` to the URL (for any page on the Gato GraphQL plugin, including any page in the wp-admin, the GraphiQL or Interactive Schema public clients, or other).

### Purging the cache

When developing an extension and testing it in the DEV webserver, whenever we create a new PHP service or modify the signature of an existing one (such as the PHP classname), we need to purge the container cache.

Run:

```bash
composer purge-cache
```

<details>

<summary>Container services in Gato GraphQL</summary>

The Gato GraphQL plugin uses a service container (via the [Symfony DependencyInjection](https://symfony.com/doc/current/components/dependency_injection.html) library), to manage all services in PHP.

Services are PHP classes, and must be defined in configuration files `services.yaml` and `schema-services.yaml` to be injected into the container.

The first time the application is invoked, the container gathers all injected services and compiles them, generating a single PHP file that is loaded in the application.

Generating this file can take several seconds. To avoid waiting for this time on each request, the Gato GraphQL plugin caches this file after it has been generated the first time.

The container needs to be purged whenever a service is created, or an existing one updated or removed.

The GraphQL schema is composed via services. Some examples are:

- Type resolvers (eg: [`StringScalarTypeResolver`](submodules/GatoGraphQL/layers/Engine/packages/component-model/src/TypeResolvers/ScalarType/StringScalarTypeResolver.php))
- Field resolvers (eg: [`UserObjectTypeFieldResolver`](submodules/GatoGraphQL/layers/CMSSchema/packages/users/src/FieldResolvers/ObjectType/UserObjectTypeFieldResolver.php))
- Directive resolvers (eg: [`SkipFieldDirectiveResolver`](submodules/GatoGraphQL/layers/Engine/packages/engine/src/DirectiveResolvers/SkipFieldDirectiveResolver.php))

</details>

## Start the Lando webserver for DEV

Building the webserver (above) is needed only the first time.

From then on, run:

```bash
composer init-server
```

## Manage the Lando webserver for DEV

### Re-install the WordPress site

You can at any moment re-install the WordPress site (and import the initial dataset).

Run:

```bash
composer reset-db
```

This is useful when:

- The installation when doing `build-server` was halted midway (or failed for some reason)
- Running the integration tests was not completed (modifying the DB data to a different state, so that running the tests again will fail)

### Re-build the Lando webserver

When a plugin or package folder has been renamed, after updating the `overrides` section in the Lando config to the new path, you need to rebuild the Lando webserver.

Run:

```bash
composer rebuild-server
```

### Regenerate the Composer autoload files

When a new extension plugin is added to the monorepo, it must have its Composer autoload file generated, and the plugin must be symlinked to the Lando webserver.

Run:

```bash
composer rebuild-app-and-server
```

## Build the Lando webserver for PROD

This Lando webserver uses:

- The generated plugins for PROD
- PHP 7.2
- XDebug not enabled

To build the webserver, run:

```bash
composer build-server-prod
```

After a few minutes, the website will be available under `https://gatographql-{composer-vendor}-extensions-for-prod.lndo.site`.

(The URL is the same one as for DEV above, plus appending `-for-prod` to the domain name.)

To print the URL again, run:

```bash
composer server-info-prod
```

The `wp-admin` login credentials are the same ones as for DEV.

To re-install the WordPress site, run:

```bash
composer reset-db-prod
```

## Start the Lando webserver for PROD

Building the webserver (above) is needed only the first time.

From then on, run:

```bash
composer init-server-prod
```

## Release your extension plugins

Follow these steps:

### Tag the monorepo as "patch", "minor" or "major"

(Given that the current version is `0.0.0`...)

To release version `0.0.1`, run:

```bash
composer release-patch
```

To release version `0.1.0`, run:

```bash
composer release-minor
```

To release version `1.0.0`, run:

```bash
composer release-major
```

Executing any of these commands will first prepare the repo for PROD:

- Update the version (in the plugin file's header, readme.txt's Stable tag, others) for all the extension plugins in the monorepo
- Update the documentation image URLs to point to that tag, under `raw.githubusercontent.com`
- Commit and push
- Git tag with the version, and push tag to GitHub

And then, it will prepare the repo for DEV again:

- Update the version to the next DEV version (next number + `-dev`)
- Commit and push

To preview running the command without actually executing it, append `-- --dry-run`:

```bash
composer release-patch -- --dry-run
```

### Create release from tag in GitHub

To generate the release plugin for PROD, head over to tags page in your GitHub repo (eg: `https://github.com/my-account/GatoGraphQLExtensionsForMyCompany/tags`), and click on the new tag (eg: `0.1.0`).

On the tag page, click on "Create release from tag".

This will trigger the `generate_plugins` workflow, which will generate the extension plugins and attach them as assets to the tag page.

For instance, after tagging Gato GraphQL with `1.0.9`, assets `gatographql-1.0.9.zip`, `gatographql-testing-1.0.9.zip` and `gatographql-testing-schema-1.0.9.zip` were attached to [GatoGraphQL/GatoGraphQL/releases/tag/1.0.9](https://github.com/GatoGraphQL/GatoGraphQL/releases/tag/1.0.9)

### Install the extension in the PROD webserver

Once the extension plugin has been generated, install it on the PROD webserver to test it.

For instance, if your repo is `my-account/GatoGraphQLExtensionsForMyCompany` and you have released version `0.1.0`, run:

```bash
$ cd webservers/gatographql-extensions-for-prod
$ lando wp plugin install https://github.com/my-account/GatoGraphQLExtensionsForMyCompany/releases/latest/download/gatographql-hello-dolly-0.1.0.zip --force --activate --path=/app/wordpress
$ cd ../..
```

## Updating the monorepo

After adding a plugin or package to the monorepo, the configuration must be updated.

Run:

```bash
composer update-monorepo-config
```

This command will:

- Update the root `composer.json` with the new packages
- Update the root `phpstan.neon` with the new packages

## Architecture of the Extension Starter

`GatoGraphQL/ExtensionStarter` is a [monorepo](https://css-tricks.com/from-a-single-repo-to-multi-repos-to-monorepo-to-multi-monorepo/#aa-stage-3-monorepo), containing the codebase for not only 1, but multiple extension plugins for Gato GraphQL (and also their packages).

`GatoGraphQL/ExtensionStarter` is also a [multi-monorepo](https://css-tricks.com/from-a-single-repo-to-multi-repos-to-monorepo-to-multi-monorepo/#aa-stage-4-multi-monorepo), containing the source code of the main Gato GraphQL plugin, hosted under the [`GatoGraphQL/GatoGraphQL`](https://github.com/GatoGraphQL/GatoGraphQL) monorepo, as a Git submodule.

The monorepo is managed via the [Monorepo Builder](https://github.com/symplify/monorepo-builder).

## Why a Multi-monorepo

The benefits of using the multi-monorepo approach as a starter project are several.

**Heads up!** All extensions from [gatographql.com/extensions](https://gatographql.com/extensions/) (that is 26 extensions and 4 bundles to date) are hosted on a repo created from `GatoGraphQL/ExtensionStarter`! So you get access to the same tools as the creators of these commercial extensions are themselves using.

### Automation

There are scripts and workflows to automate (as much as possible) the whole process of creating an extension plugin, from developing it, to testing it, to releasing it.

As a consequence, you only need to concentrate on the actual code for your extension; you won't need to worry about tools and boilerplate for the project (saving you no little time and effort).

### Browse the Gato GraphQL source code

The source code of the Gato GraphQL plugin is always readily-available when developing our extensions, and it is kept up to date just by fetching the Git changes from the upstream repo.

This is important as documentation (mostly when we first start developing with Gato GraphQL) and for debugging (XDebug is integrated out of the box, see below).

### Host the codebase for multiple extensions, and all their packages, all together

The repo contains the source code for not only 1, but multiple extension plugins for Gato GraphQL, and also for all their packages.

By hosting all extensions and their packages together, you avoid [dependency hell](https://en.wikipedia.org/wiki/Dependency_hell).

You are also able to do bulk modifications, such as searching and replacing a piece of code across different plugins, in a single action (and push it to the repo using a single commit).

### Continuously access newly-developed code

Once we create a new repository from a GitHub template, the repository and the template are two separate entities. From that moment on, when the template is updated, these changes are not reflected in the repository.

The Gato GraphQL monorepo deals with this issue by providing tools that copy content (code, scripts, workflows, etc) from the Gato GraphQL repo (available as a Git submodule) to the extension project repo. This enables the extension project to be updated when there are changes to the main plugin.

See section "Synchronizing files from the upstream Gato GraphQL repo" to learn more.

### Use the GitHub Actions workflows developed for the Gato GraphQL plugin

The GitHub Actions workflows developed for the Gato GraphQL plugin are readily-available to create and release our extensions.

This includes Continuous Integration workflows to:

- Generate the plugin (when merging a PR, or creating a release from a tag)
- Scope the extension plugin
- Downgrade the code from PHP 8.1 (for DEV), to PHP 7.2 (for PROD)
- Run coding standard checks (via PHPCS), unit tests (via PHPUnit) and static code analysis (via PHPStan)
- Run integration tests via InstaWP (automatically installing the newly-generated extension plugin on the InstaWP instance)

### Downgrade Code - PHP 8.1 (during DEV) is converted to PHP 7.2 (for PROD)

The source code for the main Gato GraphQL plugin, and any of its extensions, is PHP 8.1.

For distribution, though, the plugin and extensions use PHP 7.2, thanks to a "downgrade" process of its code via [Rector](https://github.com/rectorphp/rector/).

Downgrading code provides the best trade-off between availability of PHP features (during development), and the size of the potential userbase (when releasing the plugin):

- Use the strict typing features from PHP 8.1 (typed properties, union types, and others) to develop the plugin, reducing the possibility it will contain bugs
- Increase the potential number of users who can use your plugin, in production, by releasing it with PHP 7.2

**Heads up!** Not all PHP 8.1 features are available, but only those ones that are "downgradeable" via Rector. Check the list of [Supported PHP features in `GatoGraphQL/GatoGraphQL`](https://github.com/GatoGraphQL/GatoGraphQL/blob/master/docs/supported-php-features.md).

### Scope 3rd-party libraries

When the extension uses 3rd-party libraries (loaded via Composer), these must be "scoped" by prepending a custom PHP namespace on their source code.

This is needed to prevent potential conflicts from other plugins installed in the same WordPress site referencing a different version of the same library.

[PHP-Scoper](https://github.com/humbug/php-scoper) is already integrated in this monorepo (ready to be used whenever needed).

### Lando webservers are ready

Lando is already set-up and configured, making 2 webservers available:

1. A webserver to develop the extensions, using PHP 8.1
2. A webserver to test the generated extension plugins, using PHP 7.2

### The source code is mapped to Lando's DEV webserver

The Lando webserver for DEV (on PHP 8.1) overrides the code deployed within the container, mapping the source code from the repo instead.

As such, changes to the source code will be immediately reflected in the webserver.

### XDebug is already configured

XDebug is already integrated (when using VSCode), supporting:

- The extension's source code
- The main Gato GraphQL plugin's source code (accessible via the Git submodule)
- The WordPress core files

This allows you to add breakpoints in the code, and analyze the full stack trace to see how the code and logic works, anywhere.

### Documentation images in the extension are served from the repo

When generating the extension plugin, images to be displayed in the documentation are excluded from the `.zip` file (thus reducing its size), and referenced directly from the GitHub repo (under `raw.githubusercontent.com`).

### Monorepo Split

Even though the code for all plugins and packages is hosted all together in a monorepo, we can optionally also deploy their code to a separate repo of their own.

This is useful for:

- Distributing them via Composer
- Exploring their source code outside of the monorepo

This is achieved via a "monorepo split": When pushing code to the monorepo, the code for each of the modified plugins and packages is copied into their own GitHub repo.

This feature is disabled by default. To enable it, return an empty array in method `getExtensionSkipMonorepoSplitPackagePaths` from class [`MonorepoSplitPackageDataSource`](src/Config/Symplify/MonorepoBuilder/DataSources/MonorepoSplitPackageDataSource.php).

### Distribute PROD code to its own repo

Similar to the monorepo split, when generating the plugin for PROD, we can deploy its code (scoped, downgraded, with the Composer autoload generated, etc) into its own repo.

This is useful for:

- Allowing users to create issues, pinpointing where a problem happens

## Multi-Monorepo Commands

Retrieve the list of all Composer commands available in the monorepo:

```bash
composer list
```

This will print the monorepo commands (among other ones):

| Composer command | Description |
| --- | --- |
| `analyse` | Run PHPStan static analysis of the code |
| `build-js` | Build all JS packages, blocks and editor scripts for all plugins in the Gato GraphQL - Extension Starter repo |
| `build-server` | Initialize the Lando webserver with the 'Gato GraphQL' demo site, for development. To be executed only the first time |
| `build-server-prod` | Initialize the Lando webserver with the 'Gato GraphQL' demo site, for production. To be executed only the first time |
| `check-style` | Validate PSR-12 coding standards (via phpcs) |
| `copy-files-from-upstream-monorepo` | [multi-monorepo] Copy specific files to be reused across monorepos, from the upstream GatoGraphQL/GatoGraphQL to this downstream repo |
| `copy-folders-from-upstream-monorepo` | [multi-monorepo] Copy all files in specific folders to be reused across monorepos, from the upstream GatoGraphQL/GatoGraphQL to this downstream repo |
| `copy-upstream-files` | [multi-monorepo] Copy both specific files, and all files in specific folders, to be reused across monorepos, from the upstream GatoGraphQL/GatoGraphQL to this downstream repo |
| `debug` | Run and debug PHPUnit tests |
| `delete-settings` | Delete the plugin settings from the DB |
| `deoptimize-autoloader` | Removes the optimization of the Composer autoloaders for all the plugins installed in the webserver |
| `destroy-server` | Destroy the Lando webserver with the 'Gato GraphQL' demo site |
| `destroy-server-prod` | Destroy the Lando webserver with the 'Gato GraphQL' demo site for PROD |
| `disable-caching` | Disable caching for the 'Gato GraphQL' in DEV |
| `disable-restrictive-defaults` | Do not use restrictive default values for the Settings |
| `enable-caching` | Enable caching for the 'Gato GraphQL' in DEV |
| `enable-restrictive-defaults` | Use restrictive default values for the Settings |
| `fix-style` | Fix PSR-12 coding standards (via phpcbf) |
| `import-data` | Imports pre-defined data into the DB (posts, users, CPTs, etc) |
| `improve-code-quality` | Improve code quality (via Rector) |
| `init-server` | Alias of 'start-server |
| `init-server-prod` | Runs the init-server-prod script as defined in composer.json |
| `init-server-upstream` | Runs the init-server-upstream script as defined in composer.json |
| `initialize-project` | Initialize the project, replacing the extension starter data with your own data |
| `install-deps-build-js` | Install all dependencies from npm to build the JS packages, blocks and editor scripts for all plugins in the Gato GraphQL - Extension Starter repo |
| `install-site` | Installs the WordPress site |
| `install-site-prod` | Installs the WordPress site in the PROD server |
| `integration-test` | Execute integration tests (PHPUnit) |
| `log-server-errors` | Show (on real time) the errors from the Lando webserver |
| `log-server-warnings` | Show (on real time) the warnings from the Lando webserver |
| `merge-monorepo` | Create the monorepo's composer.json file, containing all dependencies from all packages |
| `merge-phpstan` | Generate a single PHPStan config for the monorepo, invoking the config for the PHPStan config for all packages |
| `preview-code-downgrade` | Run Rector in 'dry-run' mode to preview how the all code (i.e. src/ + vendor/ folders) will be downgraded to PHP 7.2 |
| `preview-hello-dolly-downgrade` | Runs the preview-hello-dolly-downgrade script as defined in composer.json |
| `preview-src-downgrade` | Run Rector in 'dry-run' mode to preview how the src/ folder will be downgraded to PHP 7.2 |
| `preview-vendor-downgrade` | Run Rector in 'dry-run' mode to preview how the vendor/ folder will be downgraded to PHP 7.2 |
| `prod-integration-test` | Execute integration tests (PHPUnit) against the PROD webserver |
| `propagate-monorepo` | Propagate versions from the monorepo's composer.json file to all packages |
| `purge-cache` | Purge the cache for the 'Gato GraphQL' in DEV |
| `purge-cache-upstream` | Runs the purge-cache-upstream script as defined in composer.json |
| `rebuild-app-and-server` | Update the App dependencies (from Composer) and rebuild the Lando webserver |
| `rebuild-app-and-server-prod` | Runs the rebuild-app-and-server-prod script as defined in composer.json |
| `rebuild-server` | Runs the rebuild-server script as defined in composer.json |
| `release-major` | Release a new 'major' version (MAJOR.xx.xx) (bump version, commit, push, tag, revert to 'dev-master', commit, push) |
| `release-minor` | Release a new 'minor' version (xx.MINOR.xx) (bump version, commit, push, tag, revert to 'dev-master', commit, push) |
| `release-patch` | Release a new 'patch' version (xx.xx.PATCH) (bump version, commit, push, tag, revert to 'dev-master', commit, push) |
| `remove-unused-imports` | Remove unused `use` imports |
| `reset-db` | Resets the WordPress database |
| `reset-db-prod` | Resets the WordPress database in the PROD server |
| `server-info` | Retrieve information from the Lando webserver |
| `server-info-prod` | Retrieve information from the Lando webserver for PROD |
| `ssh-server` | SSH into the Lando webserver with the 'Gato GraphQL' demo site |
| `start-server` | Start the Lando webserver with the 'Gato GraphQL' demo site, for development |
| `status` | Shows a list of locally modified packages |
| `stop-server-prod` | Stop the Lando webserver for PROD |
| `stop-server-upstream` | Runs the stop-server-upstream script as defined in composer.json |
| `stopping-integration-test` | Runs the stopping-integration-test script as defined in composer.json |
| `stopping-prod-integration-test` | Execute integration tests (PHPUnit) against the PROD webserver, stopping as soon as there's an error or failure |
| `stopping-unit-test` | Runs the stopping-unit-test script as defined in composer.json |
| `unit-test` | Execute unit tests (PHPUnit) |
| `update-deps` | Update the Composer dependencies for the 'Gato GraphQL' plugins |
| `update-monorepo-config` | Update the monorepo's composer.json and phpstan.neon files, with data from all packages |
| `use-default-restrictive-defaults` | Remove the set value, use the default one |
| `validate-monorepo` | Validate that version constraints for dependencies are the same for all packages |

## Synchronizing files from the upstream Gato GraphQL repo

Run:

```bash
composer copy-upstream-files
```

This command will copy files (including GitHub Actions workflows and Lando config files) from the "upstream" `GatoGraphQL/GatoGraphQL` repo (which is a Git submodule), to the "downstream" `my-account/GatoGraphQLExtensionsForMyCompany` repo.

For instance, the Lando webserver for DEV (see above) uses the source code files from the main Gato GraphQL plugin, via the mapping defined in the upstream file [`.lando.upstream.yml`](submodules/GatoGraphQL/webservers/gatographql/.lando.upstream.yml).

Wheneven that file is updated in the Gato GraphQL repo, by executing `composer copy-upstream-files` we will fetch that updated file and copy it as the downstream [`.lando.base.yml`](webservers/gatographql-extensions/.lando.base.yml) file. Then we execute `composer rebuild-server`, and the new mapping will take effect.

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
