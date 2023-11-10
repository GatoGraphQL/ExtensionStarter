<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

final class RegenerateMonorepoConfigExecuteBashCommandCreateExtensionWorker extends AbstractExecuteBashCommandCreateExtensionWorker
{
    protected function getBashCommand(): string
    {
        return 'composer update-monorepo-config';
    }
}
