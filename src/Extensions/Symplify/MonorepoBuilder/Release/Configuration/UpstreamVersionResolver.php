<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Release\Configuration;

use PharIo\Version\Version;
use PoP\PoP\Extensions\Symplify\MonorepoBuilder\Utils\VersionUtils;
use Symplify\MonorepoBuilder\Git\MostRecentTagResolver;

final class UpstreamVersionResolver
{
    /** @var array<string,Version> */
    private array $cachedVersions = [];

    public function __construct(
        private MostRecentTagResolver $mostRecentTagResolver,
        private VersionUtils $versionUtils,
    ) {
    }

    public function resolveVersion(string $upstreamRelativePath): Version
    {
        /**
         * When bumping the dev version without a release, the upstream
         * has no new tag, and the command sets the version to use
         */
        $upstreamVersion = $this->versionUtils->getUpstreamVersion();
        if ($upstreamVersion !== null) {
            return $upstreamVersion;
        }

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
