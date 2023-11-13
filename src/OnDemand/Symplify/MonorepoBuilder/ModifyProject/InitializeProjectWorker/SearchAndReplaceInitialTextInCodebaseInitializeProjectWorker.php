<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\InitializeProjectWorker;

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
        $landoSubdomain = sprintf(
            'gatographql-%s-extensions',
            $inputObject->getComposerVendor()
        );
        $replacements = [
            'MyCompanyForGatoGraphQL' => $inputObject->getPHPNamespaceOwner(),
            'my-company-for-gatographql' => $inputObject->getComposerVendor(),
            /**
             * Replace Composer package in regex patterns.
             *
             * @see ci/scoping/scoper-extensions.inc.php
             */
            preg_quote('my-company-for-gatographql') => preg_quote($inputObject->getComposerVendor()),
            '{composer-vendor}' => $inputObject->getComposerVendor(),

            'My Company' => $inputObject->getMyCompanyName(),
            'name@mycompany.com' => $inputObject->getMyCompanyEmail(),
            'https://mycompany.com' => $inputObject->getMyCompanyWebsite(),

            'Gato GraphQL - Extension Starter' => sprintf(
                '%s - Gato GraphQL Extensions',
                $inputObject->getMyCompanyName()
            ),
            'GitHub template repository to develop and release your extensions for Gato GraphQL.' => sprintf(
                'Monorepo hosting the Gato GraphQL extensions for %s',
                $inputObject->getMyCompanyName()
            ),

            'https://github.com/GatoGraphQL/ExtensionStarter' => sprintf(
                'https://github.com/%s/%s',
                $inputObject->getGithubRepoOwner(),
                $inputObject->getGithubRepoName()
            ),
            'my-account/GatoGraphQLExtensionsForMyCompany' => sprintf(
                '%s/%s',
                $inputObject->getGithubRepoOwner(),
                $inputObject->getGithubRepoName()
            ),
            'https://github.com/GatoGraphQL/hello-dolly' => sprintf(
                'https://github.com/%s/hello-dolly',
                $inputObject->getGithubRepoOwner()
            ),

            /**
             * Replace "gatographql-extensions" with "gatographql-{composer-vendor}-extensions".
             * Because the folder "webservers/gatographql-extensions" is not renamed,
             * but it is referenced in the config (as "webservers/gatographql-extensions"),
             * then apply the change for everything and revert it for this case.
             */
            'gatographql-extensions' => $landoSubdomain,
            sprintf(
                'webservers/%s',
                $landoSubdomain
            ) => 'webservers/gatographql-extensions',
        ];
        if ($inputObject->getGitBaseBranch() !== 'main') {
            $replacements['dev-main'] = sprintf('dev-%s', $inputObject->getGitBaseBranch());
            // Branches in GitHub Action Workflows
            $replacements['- main'] = sprintf('- %s', $inputObject->getGitBaseBranch());
        }
        return $replacements;
    }

    /**
     * @return string[]
     */
    protected function getSearchInFolders(): array
    {
        $rootFolder = $this->getRootFolder();
        return [
            $rootFolder . '/.github/workflows',
            $rootFolder . '/.vscode',
            $rootFolder . '/ci',
            $rootFolder . '/layers',
            $rootFolder . '/src/Config/Symplify/MonorepoBuilder/DataSources',
            $rootFolder . '/templates',
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
            '*.md',
            '*.pot',
            '*.sh',
            '*.xml.dist',
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

    /**
     * Files in the root folder which may also contain some
     * string to search/replace
     *
     * @return string[]
     */
    protected function getRootFolderFileNamesToSearchReplace(): array
    {
        return [
            'composer.json',
            'CODE_OF_CONDUCT.md',
            'CONTRIBUTING.md',
            'phpunit.xml.dist',
            'README.md',
        ];
    }
}
