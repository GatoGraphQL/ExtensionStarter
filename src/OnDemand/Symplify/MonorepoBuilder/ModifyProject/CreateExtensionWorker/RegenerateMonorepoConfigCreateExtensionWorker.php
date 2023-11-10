<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

final class RegenerateMonorepoConfigCreateExtensionWorker extends AbstractExecuteBashCommandCreateExtensionWorker
{
    protected function getBashCommand(): string
    {
        return 'composer update-monorepo-config';
    }
}
