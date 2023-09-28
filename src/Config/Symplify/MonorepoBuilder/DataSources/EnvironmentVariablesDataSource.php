<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\ExtensionStarter\Monorepo\MonorepoMetadata;
use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\EnvironmentVariablesDataSource as UpstreamEnvironmentVariablesDataSource;

class EnvironmentVariablesDataSource extends UpstreamEnvironmentVariablesDataSource
{
    /**
     * @return array<string,string>
     */
    public function getEnvironmentVariables(): array
    {
        return array_merge(
            parent::getEnvironmentVariables(),
            [
                self::RETENTION_DAYS_FOR_GENERATED_PLUGINS => (string) 90,
                self::GIT_BASE_BRANCH => MonorepoMetadata::GIT_BASE_BRANCH,
                self::GIT_USER_NAME => MonorepoMetadata::GIT_USER_NAME,
                self::GIT_USER_EMAIL => MonorepoMetadata::GIT_USER_EMAIL,
            ]
        );
    }
}
