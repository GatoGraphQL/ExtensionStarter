<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\CreateExtensionWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\CreateExtensionInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;
use PoP\PoP\Extensions\Symplify\MonorepoBuilder\SmartFile\FileContentReplacerSystem;

class UpdateMonorepoExtensionPluginConfigCreateExtensionWorker implements CreateExtensionWorkerInterface
{
    use CreateExtensionWorkerTrait;

    public const COMMAND_PLACEHOLDER = '// { Command Placeholder: Integration plugin Composer package }';

    public function __construct(
        private FileContentReplacerSystem $fileContentReplacerSystem,
    ) {
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function getDescription(ModifyProjectInputObjectInterface $inputObject): string
    {
        $items = [];
        if ($inputObject->getIntegrationPluginSlug() !== '') {
            $items[] = sprintf(
                'Remove "%s" from the "require-dev" entry',
                $this->getIntegrationPluginWPackagistDependency($inputObject)
            );
        }
        $description = 'Update the configuration for the `merge-monorepo` command';
        if ($items !== []) {
            return sprintf(
                '%s:%s%s',
                $description,
                PHP_EOL . '- ',
                implode(PHP_EOL . '- ', $items)
            );
        }
        return $description;
    }

    /**
     * Check there's an integration plugin required, otherwise
     * nothing to do.
     *
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function work(ModifyProjectInputObjectInterface $inputObject): void
    {
        if ($inputObject->getIntegrationPluginSlug() === '') {
            return;
        }

        $this->updateDataToAppendAndRemoveDataSourceFile($inputObject);
        $this->updatePluginDataSourceFile($inputObject);
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    protected function updateDataToAppendAndRemoveDataSourceFile(CreateExtensionInputObjectInterface $inputObject): void
    {
        $this->fileContentReplacerSystem->replaceContentInFiles(
            [
                $this->getDataToAppendAndRemoveDataSourceFile(),
            ],
            [
                '#(\s+?)(' . self::COMMAND_PLACEHOLDER . ')#' => '$1$2$1\'' . $this->getIntegrationPluginWPackagistDependency($inputObject) . '\',',
            ],
            true,
        );
    }

    protected function getDataToAppendAndRemoveDataSourceFile(): string
    {
        $rootFolder = dirname(__DIR__, 6);
        return $rootFolder . '/src/Config/Symplify/MonorepoBuilder/DataSources/DataToAppendAndRemoveDataSource.php';
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    protected function updatePluginDataSourceFile(CreateExtensionInputObjectInterface $inputObject): void
    {
        $extensionSlug = $inputObject->getExtensionSlug();
        $extensionName = $inputObject->getExtensionName();
        $code = "
            // Gato GraphQL - $extensionName
            [
                'path' => 'layers/GatoGraphQLForWP/plugins/$extensionSlug',
                'plugin_slug' => 'gatographql-$extensionSlug',
                'main_file' => 'gatographql-$extensionSlug.php',
                'rector_downgrade_config' => \$this->rootDir . '/config/rector/downgrade/$extensionSlug/rector.php',
                'exclude_files' => implode(' ', [
                    'docs/images/\*',
                ]),
            ],";
        $this->fileContentReplacerSystem->replaceContentInFiles(
            [
                $this->getPluginDataSourceFile(),
            ],
            [
                '#(\s+?)(' . self::COMMAND_PLACEHOLDER . ')#' => '$1$2' . PHP_EOL . $code,
            ],
            true,
        );
    }

    protected function getPluginDataSourceFile(): string
    {
        $rootFolder = dirname(__DIR__, 6);
        return $rootFolder . '/src/Config/Symplify/MonorepoBuilder/DataSources/PluginDataSource.php';
    }
}
