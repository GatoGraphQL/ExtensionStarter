<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\InstaWPConfigDataSource as UpstreamInstaWPConfigDataSource;

class InstaWPConfigDataSource extends UpstreamInstaWPConfigDataSource
{
    /**
     * @return array<array<mixed>
     */
    public function getInstaWPConfigEntries(): array
    {
        return [
            // @todo Complete for Extension Name!
            [
                'templateSlug' => '???',
                'repoID' => 0,
            ],
        ];
    }
}
