<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\Configurators;

use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources\AdditionalIntegrationTestPluginsDataSource;
use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources\CopyUpstreamMonorepoFilesDataSource;
use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources\CopyUpstreamMonorepoFoldersDataSource;
use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources\CreateExtensionWorkersDataSource;
use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources\DataToAppendAndRemoveDataSource;
use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources\DowngradeRectorDataSource;
use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources\EnvironmentVariablesDataSource;
use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources\InitializeProjectWorkersDataSource;
use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources\InstaWPConfigDataSource;
use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources\MonorepoSplitPackageDataSource;
use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources\PHPStanDataSource;
use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources\PackageOrganizationDataSource;
use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources\PluginDataSource;
use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources\ReleaseWorkersDataSource;
use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources\SkipDowngradeTestPathsDataSource;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ValueObject\Option as CustomOption;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ValueObject\Param;
use PoP\ExtensionStarter\Monorepo\MonorepoMetadata;
use PoP\PoP\Config\Symplify\MonorepoBuilder\Configurators\ContainerConfigurationService as UpstreamContainerConfigurationService;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Symplify\MonorepoBuilder\ValueObject\Option;
use Symplify\PackageBuilder\Neon\NeonPrinter;

class ContainerConfigurationService extends UpstreamContainerConfigurationService
{
    public function __construct(
        ContainerConfigurator $containerConfigurator,
        string $rootDirectory,
        protected string $upstreamRelativeRootPath,
        protected bool $includeUpstreamPackages,
    ) {
        parent::__construct(
            $containerConfigurator,
            $rootDirectory,
        );
    }

    public function configureContainer(): void
    {
        parent::configureContainer();

        $parameters = $this->containerConfigurator->parameters();

        $parameters->set(Option::DEFAULT_BRANCH_NAME, MonorepoMetadata::GIT_BASE_BRANCH);

        /**
         * Indicate which is the upstream path to the Release Workers
         */
        $parameters->set(
            Param::UPSTREAM_RELATIVE_PATH,
            $this->upstreamRelativeRootPath
        );

        /**
         * Copy files in folders from the upstream monorepo
         */
        if ($copyUpstreamMonorepoFoldersDataSource = $this->getCopyUpstreamMonorepoFoldersDataSource()) {
            $parameters->set(
                CustomOption::COPY_UPSTREAM_MONOREPO_FOLDER_ENTRIES,
                $copyUpstreamMonorepoFoldersDataSource->getCopyUpstreamMonorepoFoldersEntries()
            );
        }

        /**
         * Copy files from the upstream monorepo
         */
        if ($copyUpstreamMonorepoFilesDataSource = $this->getCopyUpstreamMonorepoFilesDataSource()) {
            $parameters->set(
                CustomOption::COPY_UPSTREAM_MONOREPO_FILE_ENTRIES,
                $copyUpstreamMonorepoFilesDataSource->getCopyUpstreamMonorepoFilesEntries()
            );
        }
    }

    protected function getPackageOrganizationDataSource(): ?PackageOrganizationDataSource
    {
        return new PackageOrganizationDataSource(
            $this->rootDirectory,
            $this->upstreamRelativeRootPath,
            $this->includeUpstreamPackages,
        );
    }

    protected function getMonorepoSplitPackageDataSource(): ?MonorepoSplitPackageDataSource
    {
        return new MonorepoSplitPackageDataSource(
            $this->rootDirectory,
            $this->upstreamRelativeRootPath,
            $this->includeUpstreamPackages,
        );
    }

    protected function getPluginDataSource(): ?PluginDataSource
    {
        return new PluginDataSource(
            $this->rootDirectory
        );
    }

    protected function getInstaWPConfigDataSource(): ?InstaWPConfigDataSource
    {
        return new InstaWPConfigDataSource(
            $this->rootDirectory
        );
    }

    protected function getSkipDowngradeTestPathsDataSource(): ?SkipDowngradeTestPathsDataSource
    {
        return new SkipDowngradeTestPathsDataSource(
            $this->rootDirectory,
            $this->upstreamRelativeRootPath,
        );
    }

    protected function getDowngradeRectorDataSource(): ?DowngradeRectorDataSource
    {
        return new DowngradeRectorDataSource(
            $this->rootDirectory,
            $this->upstreamRelativeRootPath,
        );
    }

    protected function getAdditionalIntegrationTestPluginsDataSource(): ?AdditionalIntegrationTestPluginsDataSource
    {
        return new AdditionalIntegrationTestPluginsDataSource(
            $this->rootDirectory,
            $this->upstreamRelativeRootPath,
        );
    }

    protected function getEnvironmentVariablesDataSource(): ?EnvironmentVariablesDataSource
    {
        return new EnvironmentVariablesDataSource();
    }

    protected function getPHPStanDataSource(): ?PHPStanDataSource
    {
        return new PHPStanDataSource(
            $this->upstreamRelativeRootPath,
        );
    }

    protected function getDataToAppendAndRemoveDataSource(): ?DataToAppendAndRemoveDataSource
    {
        return new DataToAppendAndRemoveDataSource(
            $this->upstreamRelativeRootPath,
        );
    }

    protected function getReleaseWorkersDataSource(): ?ReleaseWorkersDataSource
    {
        return new ReleaseWorkersDataSource();
    }

    protected function getInitializeProjectWorkersDataSource(): ?InitializeProjectWorkersDataSource
    {
        return new InitializeProjectWorkersDataSource();
    }

    protected function getCreateExtensionWorkersDataSource(): ?CreateExtensionWorkersDataSource
    {
        return new CreateExtensionWorkersDataSource();
    }

    protected function setCustomServices(ServicesConfigurator $services): void
    {
        $services
            ->set(NeonPrinter::class) // Required to inject into PHPStanNeonContentProvider
            ->load('PoP\\PoP\\Config\\', $this->rootDirectory . '/' . $this->upstreamRelativeRootPath . '/src/Config/*')
            ->load('PoP\\PoP\\Extensions\\', $this->rootDirectory . '/' . $this->upstreamRelativeRootPath . '/src/Extensions/*')
            ->load('PoP\\PoP\\Monorepo\\', $this->rootDirectory . '/' . $this->upstreamRelativeRootPath . '/src/Monorepo/*')
            ->load('PoP\\ExtensionStarter\\Config\\', $this->rootDirectory . '/src/Config/*')
            ->load('PoP\\ExtensionStarter\\Extensions\\', $this->rootDirectory . '/src/Extensions/*');
    }

    protected function setServices(ServicesConfigurator $services): void
    {
        parent::setServices($services);

        $this->setInitializeProjectWorkerServices($services);
        $this->setCreateExtensionWorkerServices($services);
    }

    protected function setInitializeProjectWorkerServices(ServicesConfigurator $services): void
    {
        if ($initializeProjectWorkersConfig = $this->getInitializeProjectWorkersDataSource()) {
            foreach ($initializeProjectWorkersConfig->getInitializeProjectWorkerClasses() as $initializeProjectWorkerClass) {
                $services->set($initializeProjectWorkerClass);
            }
        }
    }

    protected function setCreateExtensionWorkerServices(ServicesConfigurator $services): void
    {
        if ($createExtensionWorkersConfig = $this->getCreateExtensionWorkersDataSource()) {
            foreach ($createExtensionWorkersConfig->getCreateExtensionWorkerClasses() as $createExtensionWorkerClass) {
                $services->set($createExtensionWorkerClass);
            }
        }
    }

    protected function getCopyUpstreamMonorepoFoldersDataSource(): ?CopyUpstreamMonorepoFoldersDataSource
    {
        return new CopyUpstreamMonorepoFoldersDataSource(
            $this->rootDirectory,
            $this->upstreamRelativeRootPath,
        );
    }

    protected function getCopyUpstreamMonorepoFilesDataSource(): ?CopyUpstreamMonorepoFilesDataSource
    {
        return new CopyUpstreamMonorepoFilesDataSource(
            $this->rootDirectory,
            $this->upstreamRelativeRootPath,
        );
    }
}
