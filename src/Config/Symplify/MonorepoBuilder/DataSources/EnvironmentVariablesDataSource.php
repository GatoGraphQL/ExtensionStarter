<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

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
                self::RETENTION_DAYS_FOR_GENERATED_PLUGINS => 90,
                self::GIT_USER_NAME => 'extension-git-user-name',
                self::GIT_USER_EMAIL => 'extension-git-user@email.com',
            ]
        );
    }
}
