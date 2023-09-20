<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\DataToAppendAndRemoveDataSource as UpstreamDataToAppendAndRemoveDataSource;

class DataToAppendAndRemoveDataSource extends UpstreamDataToAppendAndRemoveDataSource
{
    public function __construct(
        protected string $upstreamRelativeRootPath
    ) {
    }

    /**
     * @return array<string,mixed>
     */
    public function getDataToAppend(): array
    {
        $dataToAppend = parent::getDataToAppend();
        $dataToAppend['autoload']['psr-4']['PoP\\PoP\\'] = $this->upstreamRelativeRootPath . '/src';
        $dataToAppend['autoload']['psr-4']['PoP\\ExtensionStarter\\'] = 'src';
        return $dataToAppend;
    }

    /**
     * @return array<string,mixed>
     */
    public function getDataToRemove(): array
    {
        $dataToRemove = parent::getDataToRemove();
        $dataToRemove['require-dev']['wpackagist-plugin/extension-wordpress-plugin'] = '*';
        return $dataToRemove;
    }
}
