<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

final class RebuildLandoDevWebserverExecuteBashCommandCreateExtensionWorker extends AbstractExecuteBashCommandCreateExtensionWorker
{
    protected function getBashCommand(): string
    {
        return 'composer rebuild-app-and-server';
    }
}
