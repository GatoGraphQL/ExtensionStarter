<?php

declare(strict_types=1);

namespace ExtensionVendor\ExtensionName\ModuleResolvers;

use ExtensionVendor\ExtensionName\GatoGraphQLExtension;
use GatoGraphQL\GatoGraphQL\ContentProcessors\MarkdownContentParserInterface;
use GatoGraphQL\GatoGraphQL\ModuleResolvers\AbstractModuleResolver;
use GatoGraphQL\GatoGraphQL\ModuleResolvers\SchemaTypeModuleResolverTrait;
use GatoGraphQL\GatoGraphQL\ObjectModels\DependedOnActiveWordPressPlugin;

class SchemaTypeModuleResolver extends AbstractModuleResolver
{
    use ModuleResolverTrait;
    use SchemaTypeModuleResolverTrait {
        SchemaTypeModuleResolverTrait::getPriority as getUpstreamPriority;
    }

    public final const SCHEMA_EXTENSION_NAME = GatoGraphQLExtension::NAMESPACE . '\schema-extension-name';

    private ?MarkdownContentParserInterface $markdownContentParser = null;

    final protected function getMarkdownContentParser(): MarkdownContentParserInterface
    {
        if ($this->markdownContentParser === null) {
            /** @var MarkdownContentParserInterface */
            $markdownContentParser = $this->instanceManager->getInstance(MarkdownContentParserInterface::class);
            $this->markdownContentParser = $markdownContentParser;
        }
        return $this->markdownContentParser;
    }

    /**
     * @return string[]
     */
    public function getModulesToResolve(): array
    {
        return [
            self::SCHEMA_EXTENSION_NAME,
        ];
    }

    /**
     * @return DependedOnActiveWordPressPlugin[]
     */
    public function getDependentOnActiveWordPressPlugins(string $module): array
    {
        return match ($module) {
            self::SCHEMA_EXTENSION_NAME => [
                new DependedOnActiveWordPressPlugin(
                    \__('Extension Name', 'gatographql-extension-name'),
                    'extension-wordpress-plugin/extension-wordpress-plugin-php-filename.php',
                    'extension-wordpress-plugin-constraint',
                ),
            ],
            default => parent::getDependentOnActiveWordPressPlugins($module),
        };
    }

    public function getName(string $module): string
    {
        return match ($module) {
            self::SCHEMA_EXTENSION_NAME => \__('Extension Name Schema', 'gatographql-extension-name'),
            default => $module,
        };
    }

    public function getDescription(string $module): string
    {
        return match ($module) {
            self::SCHEMA_EXTENSION_NAME => \__('Add schema elements for the Extension Name extension for Gato GraphQL.', 'gatographql-extension-name'),
            default => parent::getDescription($module),
        };
    }
}
