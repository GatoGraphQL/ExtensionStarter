<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\ModifyProjectWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\InitializeProjectInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;

class SearchAndReplaceInitialTextInCodebaseInitializeProjectWorker extends AbstractSearchAndReplaceTextInCodebaseInitializeProjectWorker
{
    public function getDescription(ModifyProjectInputObjectInterface $inputObject): string
    {
        return 'Search the initital strings in the Extension Starter and replace them with the user\' values';
    }

    /**
     * @return array<string,string> Key: string to search, Value: string to replace with
     */
    protected function getReplacements(InitializeProjectInputObjectInterface $inputObject): array
    {
        return [
            'MyCompanyForGatoGraphQL' => 'TemporaryTestDeleteThisValue',
            'my-company-for-gatographql' => 'temporary-test-delete-this-value',
        ];
    }

    /**
     * @return string[]
     */
    protected function getSearchInFolders(): array
    {
        $rootFolder = $this->getRootFolder();
        return [
            $rootFolder . '/.vscode',
            $rootFolder . '/layers',
            $rootFolder . '/webservers',
        ];
    }

    /**
     * @return string[]
     */
    protected function getExcludeFolders(): array
    {
        return [
            ...parent::getExcludeFolders(),
            'wordpress',
        ];
    }

    /**
     * @return string[]
     */
    protected function getFileExtensions(): array
    {
        return [
            ...parent::getFileExtensions(),
            '*.json',
            '*.yml',
        ];
    }
}
