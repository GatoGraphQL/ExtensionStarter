<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\CreateExtensionWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\CreateExtensionInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;
use Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection;
use Symplify\SmartFileSystem\SmartFileInfo;

class UpdateMonorepoLandoComposerCreateExtensionWorker implements CreateExtensionWorkerInterface
{
    public function __construct(
        protected JsonFileManager $jsonFileManager,
    ) {
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function getDescription(ModifyProjectInputObjectInterface $inputObject): string
    {
        $items = [
            'Execute `composer install` for the extension plugin'
        ];
        return sprintf(
            '%s:%s%s',
            'Update the monorepo\'s Lando composer.json file',
            PHP_EOL . '- ',
            implode(PHP_EOL . '- ', $items)
        );
    }

    /**
     * Check there's an integration plugin required, otherwise
     * nothing to do.
     *
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function work(ModifyProjectInputObjectInterface $inputObject): void
    {
        $composerJSONFiles = $this->getMonorepoLandoComposerFiles($inputObject);
        foreach ($composerJSONFiles as $composerJSONFile) {
            $this->addUpdateDepsScriptInComposerJSON(
                $inputObject,
                $composerJSONFile,
            );
        }
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    protected function addUpdateDepsScriptInComposerJSON(
        CreateExtensionInputObjectInterface $inputObject,
        string $composerJSONFile,
    ): void {
        $composerJSONFileSmartFileInfo = new SmartFileInfo($composerJSONFile);

        $json = $this->jsonFileManager->loadFromFileInfo($composerJSONFileSmartFileInfo);

        $extensionSlug = $inputObject->getExtensionSlug();
        $scriptName = "symlink-vendor-for-gatographql-{$extensionSlug}";

        // Insert the new script entry under "update-deps"
        $json[ComposerJsonSection::SCRIPTS]['update-deps'][] = "@{$scriptName}";
        $json[ComposerJsonSection::SCRIPTS][$scriptName] = [
            "php -r \"copy('../../layers/GatoGraphQLForWP/plugins/{$extensionSlug}/composer.json', '../../layers/GatoGraphQLForWP/plugins/{$extensionSlug}/composer.local.json');\"",
            "cd ../../ && vendor/bin/monorepo-builder symlink-local-package --config=config/monorepo-builder/symlink-local-package.php layers/GatoGraphQLForWP/plugins/{$extensionSlug}/composer.local.json",
            "COMPOSER=composer.local.json composer update --no-dev --working-dir=../../layers/GatoGraphQLForWP/plugins/{$extensionSlug}"
        ];

        // Optimize/Deoptimize autoloader scripts
        $json[ComposerJsonSection::SCRIPTS]['optimize-autoloader'][] = "COMPOSER=composer.local.json composer dump-autoload --optimize --working-dir=../../layers/GatoGraphQLForWP/plugins/{$extensionSlug}";
        $json[ComposerJsonSection::SCRIPTS]['deoptimize-autoloader'][] = "COMPOSER=composer.local.json composer dump-autoload --working-dir=../../layers/GatoGraphQLForWP/plugins/{$extensionSlug}";

        $this->jsonFileManager->printJsonToFileInfo($json, $composerJSONFileSmartFileInfo);
    }

    /**
     * @return string[]
     */
    protected function getMonorepoLandoComposerFiles(CreateExtensionInputObjectInterface $inputObject): array
    {
        $rootFolder = dirname(__DIR__, 6);
        return [
            $rootFolder . '/webservers/gatographql-extensions/composer.json',
        ];
    }
}
