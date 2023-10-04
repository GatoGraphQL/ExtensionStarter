<?php

declare(strict_types=1);

namespace MyCompanyForGatoGraphQL\HelloDolly\Integration;

use PHPUnitForGatoGraphQL\WebserverRequests\AbstractFixtureThirdPartyPluginDependencyWordPressAuthenticatedUserWebserverRequestTestCase;

/**
 * Test that enabling/disabling a required 3rd-party plugin works well.
 */
class FixtureThirdPartyPluginDependencyWordPressAuthenticatedUserWebserverRequestTest extends AbstractFixtureThirdPartyPluginDependencyWordPressAuthenticatedUserWebserverRequestTestCase
{
    protected static function getFixtureFolder(): string
    {
        return __DIR__ . '/fixture-3rd-party-plugins';
    }
}
