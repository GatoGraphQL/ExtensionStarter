<?php

declare(strict_types=1);

namespace DollyShepherd\HelloDolly\ContentProcessors;

use DollyShepherd\HelloDolly\GatoGraphQLExtension;
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
