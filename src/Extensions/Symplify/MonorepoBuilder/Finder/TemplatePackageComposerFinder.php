<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Finder;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ValueObject\Option as CustomOption;
use Symfony\Component\Finder\Finder;
use Symplify\MonorepoBuilder\Exception\ConfigurationException;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\SmartFileSystem\Finder\FinderSanitizer;
use Symplify\SmartFileSystem\SmartFileInfo;

/**
 * This class is a copy/paste from:
 * Symplify\MonorepoBuilder\Finder\PackageComposerFinder
 */
final class TemplatePackageComposerFinder
{
    /**
     * @var string[]
     */
    private array $packageDirectories = [];

    /**
     * @var string[]
     */
    private array $packageDirectoriesExcludes = [];

    /**
     * @var SmartFileInfo[]
     */
    private array $cachedPackageComposerFiles = [];

    public function __construct(
        ParameterProvider $parameterProvider,
        private FinderSanitizer $finderSanitizer
    ) {
        $this->packageDirectories = $parameterProvider->provideArrayParameter(CustomOption::TEMPLATE_PACKAGE_DIRECTORIES);
        $this->packageDirectoriesExcludes = $parameterProvider->provideArrayParameter(
            CustomOption::TEMPLATE_PACKAGE_DIRECTORIES_EXCLUDES
        );
    }

    public function getRootPackageComposerFile(): SmartFileInfo
    {
        return new SmartFileInfo(getcwd() . DIRECTORY_SEPARATOR . 'composer.json');
    }

    /**
     * @return SmartFileInfo[]
     */
    public function getPackageComposerFiles(): array
    {
        if ($this->packageDirectories === []) {
            $errorMessage = sprintf(
                'First define package directories in "monorepo-builder.php" config.%sUse $parameters->set(Option::%s, "...");',
                PHP_EOL,
                CustomOption::TEMPLATE_PACKAGE_DIRECTORIES
            );
            throw new ConfigurationException($errorMessage);
        }

        if ($this->cachedPackageComposerFiles === []) {
            $finder = Finder::create()
                ->files()
                ->in($this->packageDirectories)
                // sub-directory for wrapping to phar
                ->exclude('compiler')
                // "init" command template data
                ->exclude('templates')
                ->exclude('vendor')
                // usually designed for prefixed/downgraded versions
                ->exclude('build')
                ->exclude('node_modules')
                ->name('composer.json');

            if ($this->packageDirectoriesExcludes !== []) {
                $finder->exclude($this->packageDirectoriesExcludes);
            }

            if (! $this->isPHPUnit()) {
                $finder->notPath('#tests#');
            }

            $this->cachedPackageComposerFiles = $this->finderSanitizer->sanitize($finder);
        }

        return $this->cachedPackageComposerFiles;
    }

    private function isPHPUnit(): bool
    {
        // defined by PHPUnit
        return defined('PHPUNIT_COMPOSER_INSTALL') || defined('__PHPUNIT_PHAR__');
    }
}
