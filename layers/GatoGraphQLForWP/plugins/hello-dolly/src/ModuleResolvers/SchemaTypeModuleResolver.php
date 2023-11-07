<?php

declare(strict_types=1);

namespace MyCompanyForGatoGraphQL\HelloDolly\ModuleResolvers;

use MyCompanyForGatoGraphQL\HelloDolly\GatoGraphQLExtension;
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

    public final const SCHEMA_HELLO_DOLLY = GatoGraphQLExtension::NAMESPACE . '\schema-hello-dolly';

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
            self::SCHEMA_HELLO_DOLLY,
        ];
    }

    /**
     * @return DependedOnActiveWordPressPlugin[]
     */
    public function getDependentOnActiveWordPressPlugins(string $module): array
    {
        $requiredPluginName = __('Hello Dolly', 'gatographql-hello-dolly');
        $requiredPluginFile = 'hello-dolly/hello.php';
        $requiredPluginVersion = '^1.7';
        return match ($module) {
            self::SCHEMA_HELLO_DOLLY => [
                /**
                 * @gatographql-extension-info
                 *
                 * If the extension is an integration for some plugin (eg: WooCommerce,
                 * Yoast SEO or, in this case, Hello Dolly), add below:
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
            ],
            default => parent::getDependentOnActiveWordPressPlugins($module),
        };
    }

    public function getName(string $module): string
    {
        return match ($module) {
            self::SCHEMA_HELLO_DOLLY => \__('Hello Dolly Schema', 'gatographql-hello-dolly'),
            default => $module,
        };
    }

    public function getDescription(string $module): string
    {
        return match ($module) {
            self::SCHEMA_HELLO_DOLLY => \__('Add schema elements for the Hello Dolly extension for Gato GraphQL.', 'gatographql-hello-dolly'),
            default => parent::getDescription($module),
        };
    }
}
