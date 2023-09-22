<?php

declare(strict_types=1);

namespace DollyShepherd\HelloDolly\ModuleResolvers;

use DollyShepherd\HelloDolly\GatoGraphQLExtension;
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

    public final const SCHEMA_EXTENSION_NAME = GatoGraphQLExtension::NAMESPACE . '\schema-hello-dolly';

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
                    \__('Hello Dolly', 'gatographql-hello-dolly'),
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
            self::SCHEMA_EXTENSION_NAME => \__('Hello Dolly Schema', 'gatographql-hello-dolly'),
            default => $module,
        };
    }

    public function getDescription(string $module): string
    {
        return match ($module) {
            self::SCHEMA_EXTENSION_NAME => \__('Add schema elements for the Hello Dolly extension for Gato GraphQL.', 'gatographql-hello-dolly'),
            default => parent::getDescription($module),
        };
    }
}
