<?php

declare(strict_types=1);

namespace MyCompanyForGatoGraphQL\ExtensionTemplate\ModuleResolvers;

use MyCompanyForGatoGraphQL\ExtensionTemplate\GatoGraphQLExtension;
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

    public final const SCHEMA_EXTENSION_TEMPLATE = GatoGraphQLExtension::NAMESPACE . '\schema-extension-template';

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
            self::SCHEMA_EXTENSION_TEMPLATE,
        ];
    }

    /**
     * @return DependedOnActiveWordPressPlugin[]
     */
    public function getDependentOnActiveWordPressPlugins(string $module): array
    {
        $requiredPluginName = __('Integration Plugin Template', 'gatographql-extension-template');
        $requiredPluginFile = 'extension-template/extension-template.php';
        $requiredPluginVersion = '*';
        return match ($module) {
            self::SCHEMA_EXTENSION_TEMPLATE => $requiredPluginFile !== '' ? [
                /**
                 * @gatographql-extension-info
                 *
                 * If the extension is an integration for some plugin (eg: WooCommerce,
                 * Yoast SEO or, in this case, Extension Template), add below:
                 *
                 * - the plugin's name
                 * - the plugin's main file
                 * - the minimum required version (via a Composer version constraint)
                 */
                new DependedOnActiveWordPressPlugin(
                    $requiredPluginName,
                    $requiredPluginFile,
                    $requiredPluginVersion,
                ),
            ]
            /** @phpstan-ignore-next-line */
            : [],
            default => parent::getDependentOnActiveWordPressPlugins($module),
        };
    }

    public function getName(string $module): string
    {
        return match ($module) {
            self::SCHEMA_EXTENSION_TEMPLATE => \__('Extension Template Schema', 'gatographql-extension-template'),
            default => $module,
        };
    }

    public function getDescription(string $module): string
    {
        return match ($module) {
            self::SCHEMA_EXTENSION_TEMPLATE => \__('Add schema elements for the Extension Template extension for Gato GraphQL.', 'gatographql-extension-template'),
            default => parent::getDescription($module),
        };
    }
}
