<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\ModifyProjectWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\InitializeProjectInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;

class SearchAndReplaceInitialTextInCodebaseInitializeProjectWorker extends AbstractSearchAndReplaceTextInCodebaseInitializeProjectWorker
{
    /**
     * @param InitializeProjectInputObjectInterface $inputObject
     */
    public function getDescription(ModifyProjectInputObjectInterface $inputObject): string
    {
        return sprintf(
            'Replace strings with the user inputs: %s%s',
            PHP_EOL,
            $this->printReplacements($inputObject)
        );
    }

    protected function printReplacements(InitializeProjectInputObjectInterface $inputObject): string
    {
        $items = [];
        foreach ($this->getReplacements($inputObject) as $search => $replace) {
            $items[] = sprintf(
                '- "%s" => "%s"',
                $search,
                $replace
            );
        }
        return implode(PHP_EOL, $items);
    }

    /**
     * @return array<string,string> Key: string to search, Value: string to replace with
     */
    protected function getReplacements(InitializeProjectInputObjectInterface $inputObject): array
    {
        return [
            'MyCompanyForGatoGraphQL' => $inputObject->getPHPNamespaceOwner(),
            'my-company-for-gatographql' => $inputObject->getComposerVendor(),
            /**
             * Replace Composer package in regex patterns.
             *
             * @see ci/scoping/scoper-extensions.inc.php
             */
            preg_quote('my-company-for-gatographql') => preg_quote($inputObject->getComposerVendor()),

            'My Company' => $inputObject->getMyCompanyName(),
            'name@company.com' => $inputObject->getMyCompanyEmail(),
            'https://mysite.com' => $inputObject->getMyCompanyWebsite(),
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
            $rootFolder . '/ci',
            $rootFolder . '/layers',
            $rootFolder . '/src/Config/Symplify/MonorepoBuilder/DataSources',
            $rootFolder . '/webservers/gatographql-extensions',
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
            '*.md',
            '*.pot',
            '*.yaml',
            '*.yml',
            // File: .lando.upstream.yml
            '.*.yml',
        ];
    }

    /**
     * Because the monorepo's composer.json falls outside the
     * "search in" folders, explicitly add it as a result.
     *
     * @param string[] $searchInFolders
     * @param string[] $excludeFolders
     * @param string[] $fileExtensions
     * @return string[]
     */
    protected function findFilesContainingString(
        string $search,
        array $searchInFolders,
        array $excludeFolders,
        array $fileExtensions,
        bool $ignoreDotFiles,
    ): array {
        $rootFolder = $this->getRootFolder();
        return [
            ...parent::findFilesContainingString(
                $search,
                $searchInFolders,
                $excludeFolders,
                $fileExtensions,
                $ignoreDotFiles
            ),
            ...array_map(
                fn (string $fileName) => $rootFolder . '/' . $fileName,
                $this->getRootFolderFileNamesToSearchReplace()
            ),
        ];
    }

    protected function getRootFolderFileNamesToSearchReplace(): array
    {
        return [
            'composer.json',
            'CODE_OF_CONDUCT.md',
            'README.md',
        ];
    }
}
