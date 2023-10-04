<?php

declare(strict_types=1);

namespace MyCompanyForGatoGraphQL\HelloDolly\Integration;

use PHPUnitForGatoGraphQL\GatoGraphQL\Integration\AbstractAdminClientQueryExecutionFixtureWebserverRequestTestCase;

class SchemaFixtureWebserverRequestTest extends AbstractAdminClientQueryExecutionFixtureWebserverRequestTestCase
{
    protected static function getFixtureFolder(): string
    {
        return __DIR__ . '/fixture-schema';
    }
}
