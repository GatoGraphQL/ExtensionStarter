<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\FilesContainingStringFinder;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\CreateExtensionWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\CreateExtensionInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;
use PoP\PoP\Extensions\Symplify\MonorepoBuilder\SmartFile\FileContentReplacerSystem;

class UpdateMonorepoExtensionPluginConfigCreateExtensionWorker implements CreateExtensionWorkerInterface
{
    public const COMMAND_PLACEHOLDER = '// { Command Placeholder: Integration plugin Composer package }';

    use CreateExtensionWorkerTrait;
    
    public function __construct(
        private FilesContainingStringFinder $filesContainingStringFinder,
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
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    protected function updateDataToAppendAndRemoveDataSourceFile(
        CreateExtensionInputObjectInterface $inputObject,
    ): void {
        $this->fileContentReplacerSystem->replaceContentInFiles(
            [
                $this->getDataToAppendAndRemoveDataSourceFile(),
            ],
            [
                '#(\s+?)(' . self::COMMAND_PLACEHOLDER . ')#' => '$1\'' . $this->getIntegrationPluginWPackagistDependency($inputObject) . '\',' . '$1$2',
            ],
            true,
        );
    }

    protected function getDataToAppendAndRemoveDataSourceFile(): string
    {
        $rootFolder = dirname(__DIR__, 6);
        return $rootFolder . '/src/Config/Symplify/MonorepoBuilder/DataSources/DataToAppendAndRemoveDataSource.php';
    }
}
