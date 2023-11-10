<?php

declare(strict_types=1);

namespace MyCompanyForGatoGraphQL\ExtensionTemplate\ContentProcessors;

use MyCompanyForGatoGraphQL\ExtensionTemplate\GatoGraphQLExtension;
use GatoGraphQL\GatoGraphQL\ContentProcessors\ExtensionMarkdownContentRetrieverTrait as UpstreamExtensionMarkdownContentRetrieverTrait;
use GatoGraphQL\GatoGraphQL\PluginSkeleton\ExtensionInterface;

trait ExtensionMarkdownContentRetrieverTrait
{
    use UpstreamExtensionMarkdownContentRetrieverTrait;

    /**
     * @return class-string<ExtensionInterface>
     */
    protected function getExtensionClass(): string
    {
        return GatoGraphQLExtension::class;
    }
}
