<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use Nette\Neon\Neon;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\CreateExtensionWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\CreateExtensionInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;
use Symplify\PackageBuilder\Neon\NeonPrinter;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;

class UpdateExtensionPluginPHPStanConfigCreateExtensionWorker implements CreateExtensionWorkerInterface
{
    use CreateExtensionWorkerTrait;

    public function __construct(
        private NeonPrinter $neonPrinter,
        private SmartFileSystem $smartFileSystem,
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
                'Bootstrap the stub file for integration plugin "%s"',
                $inputObject->getIntegrationPluginName()
            );
        }
        $description = 'Update the extension plugin\'s PHPStan config files';
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

        $phpstanNeonFiles = $this->getExtensionPluginPHPStanNeonFiles($inputObject);
        foreach ($phpstanNeonFiles as $phpstanNeonFile) {
            $this->addBootstrapFilesInPHPStanNeonFile(
                $inputObject,
                $phpstanNeonFile,
            );
        }
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    protected function addBootstrapFilesInPHPStanNeonFile(
        CreateExtensionInputObjectInterface $inputObject,
        string $phpstanNeonFile,
    ): void {
        $phpstanNeonFileSmartFileInfo = new SmartFileInfo($phpstanNeonFile);

        $phpstanNeonContent = $phpstanNeonFileSmartFileInfo->getContents();
        $phpstanNeonData = (array) Neon::decode($phpstanNeonContent);

        $phpstanNeonData['parameters']['bootstrapFiles'] ??= [];
        $phpstanNeonData['parameters']['bootstrapFiles'][] = "%currentWorkingDirectory%/stubs/{$this->getIntegrationPluginWPackagistDependency($inputObject)}/stubs.php";

        $phpstanNeonContent = $this->neonPrinter->printNeon($phpstanNeonData);
        $this->smartFileSystem->dumpFile($phpstanNeonFile, $phpstanNeonContent);
    }

    /**
     * @return string[]
     */
    protected function getExtensionPluginPHPStanNeonFiles(CreateExtensionInputObjectInterface $inputObject): array
    {
        $rootFolder = dirname(__DIR__, 6);
        return [
            $rootFolder . '/layers/GatoGraphQLForWP/packages/' . $inputObject->getExtensionSlug() . '-schema/phpstan.neon.dist',
        ];
    }
}
