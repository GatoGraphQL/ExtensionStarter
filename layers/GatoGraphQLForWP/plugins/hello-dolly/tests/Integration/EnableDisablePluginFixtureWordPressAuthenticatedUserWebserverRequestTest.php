<?php

declare(strict_types=1);

namespace MyCompanyForGatoGraphQL\HelloDolly\Integration;

use PHPUnitForGatoGraphQL\WebserverRequests\AbstractFixtureThirdPartyPluginDependencyWordPressAuthenticatedUserWebserverRequestTestCase;

/**
 * Test that enabling/disabling the plugin does not break anything.
 */
class EnableDisablePluginFixtureWordPressAuthenticatedUserWebserverRequestTest extends AbstractFixtureThirdPartyPluginDependencyWordPressAuthenticatedUserWebserverRequestTestCase
{
    protected static function getFixtureFolder(): string
    {
        return __DIR__ . '/fixture-enable-disable-plugins';
    }
}
