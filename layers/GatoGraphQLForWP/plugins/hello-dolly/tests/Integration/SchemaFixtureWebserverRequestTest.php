<?php

declare(strict_types=1);

namespace MyCompanyForGatoGraphQL\HelloDolly\Integration;

use PHPUnitForGatoGraphQL\GatoGraphQL\Integration\AbstractApplicationPasswordQueryExecutionFixtureWebserverRequestTestCase;

class SchemaFixtureWebserverRequestTest extends AbstractApplicationPasswordQueryExecutionFixtureWebserverRequestTestCase
{
    protected static function getFixtureFolder(): string
    {
        return __DIR__ . '/fixture-schema';
    }

    protected static function getEndpoint(): string
    {
        return 'graphql/';
    }
}
