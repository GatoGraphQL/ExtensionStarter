<?php

declare(strict_types=1);

namespace ExtensionVendor\ExtensionName\ModuleResolvers;

use ExtensionVendor\ExtensionName\ContentProcessors\ExtensionMarkdownContentRetrieverTrait;
use ExtensionVendor\ExtensionName\ExtensionStaticHelpers;
use GatoGraphQL\GatoGraphQL\ModuleResolvers\CommonModuleResolverTrait;
use GatoGraphQL\GatoGraphQL\ModuleResolvers\HasMarkdownDocumentationModuleResolverTrait;

trait ModuleResolverTrait
{
    use HasMarkdownDocumentationModuleResolverTrait;
    use ExtensionMarkdownContentRetrieverTrait;
    use CommonModuleResolverTrait;

    /**
     * Get the GitHub repo URL, to retrieve images for PROD.
     */
    protected function getGitHubRepoDocsRootPathURL(): string
    {
        return ExtensionStaticHelpers::getGitHubRepoDocsRootPathURL();
    }
}
