<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Release\Configuration;

use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Git\MostRecentTagResolver;

final class UpstreamVersionResolver
{
    /** @var array<string,Version> */
    private array $cachedVersions = [];

    public function __construct(
        private MostRecentTagResolver $mostRecentTagResolver
    ) {
    }

    public function resolveVersion(string $upstreamRelativePath): Version
    {
        if (isset($this->cachedVersions[$upstreamRelativePath])) {
            return $this->cachedVersions[$upstreamRelativePath];
        }

        $upstreamPath = getcwd() . DIRECTORY_SEPARATOR . $upstreamRelativePath;

        // get current version
        $mostRecentUpstreamVersion = $this->mostRecentTagResolver->resolve($upstreamPath);
        if ($mostRecentUpstreamVersion === null) {
            // the very first tag
            $mostRecentUpstreamVersion = 'v0.1.0';
        }
        $this->cachedVersions[$upstreamRelativePath] = new Version($mostRecentUpstreamVersion);
        return $this->cachedVersions[$upstreamRelativePath];
    }
}
