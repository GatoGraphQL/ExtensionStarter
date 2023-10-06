<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\BumpVersionForDevInMonorepoMetadataFileReleaseWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\BumpVersionForDevInPluginMainFileReleaseWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\BumpVersionForDevInPluginNodeJSPackageJSONFilesReleaseWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\ConvertStableTagVersionForProdInPluginReadmeFileReleaseWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\ConvertVersionForProdInMonorepoMetadataFileReleaseWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\ConvertVersionForProdInPluginBlockCompiledMarkdownFilesReleaseWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\ConvertVersionForProdInPluginMainFileReleaseWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\ConvertVersionForProdInPluginNodeJSPackageJSONFilesReleaseWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\RestoreVersionForDevInPluginBlockCompiledMarkdownFilesReleaseWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualConflictsReleaseWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualDependenciesReleaseWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\SetNextMutualDependenciesReleaseWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateBranchAliasReleaseWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateReplaceReleaseWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateVersionConstraintToGatoGraphQLPluginInPluginMainFileReleaseWorker;
use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\ReleaseWorkersDataSource as UpstreamReleaseWorkersDataSource;
use PoP\PoP\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\BumpVersionForDevInMonorepoMetadataFileReleaseWorker as UpstreamBumpVersionForDevInMonorepoMetadataFileReleaseWorker;
use PoP\PoP\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\BumpVersionForDevInPluginMainFileReleaseWorker as UpstreamBumpVersionForDevInPluginMainFileReleaseWorker;
use PoP\PoP\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\BumpVersionForDevInPluginNodeJSPackageJSONFilesReleaseWorker as UpstreamBumpVersionForDevInPluginNodeJSPackageJSONFilesReleaseWorker;
use PoP\PoP\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\ConvertStableTagVersionForProdInPluginReadmeFileReleaseWorker as UpstreamConvertStableTagVersionForProdInPluginReadmeFileReleaseWorker;
use PoP\PoP\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\ConvertVersionForProdInMonorepoMetadataFileReleaseWorker as UpstreamConvertVersionForProdInMonorepoMetadataFileReleaseWorker;
use PoP\PoP\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\ConvertVersionForProdInPluginBlockCompiledMarkdownFilesReleaseWorker as UpstreamConvertVersionForProdInPluginBlockCompiledMarkdownFilesReleaseWorker;
use PoP\PoP\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\ConvertVersionForProdInPluginMainFileReleaseWorker as UpstreamConvertVersionForProdInPluginMainFileReleaseWorker;
use PoP\PoP\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\ConvertVersionForProdInPluginNodeJSPackageJSONFilesReleaseWorker as UpstreamConvertVersionForProdInPluginNodeJSPackageJSONFilesReleaseWorker;
use PoP\PoP\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\RestoreVersionForDevInPluginBlockCompiledMarkdownFilesReleaseWorker as UpstreamRestoreVersionForDevInPluginBlockCompiledMarkdownFilesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualConflictsReleaseWorker as UpstreamSetCurrentMutualConflictsReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualDependenciesReleaseWorker as UpstreamSetCurrentMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetNextMutualDependenciesReleaseWorker as UpstreamSetNextMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateBranchAliasReleaseWorker as UpstreamUpdateBranchAliasReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateReplaceReleaseWorker as UpstreamUpdateReplaceReleaseWorker;

class ReleaseWorkersDataSource extends UpstreamReleaseWorkersDataSource
{
    /**
     * After injecting the version from downstream, do it once again
     * with the version from upstream for the upstream packages only.
     *
     * @return string[]
     */
    public function getReleaseWorkerClasses(): array
    {
        // Obtain the classes from upstream
        $releaseWorkerClasses = parent::getReleaseWorkerClasses();

        /**
         * After executing each release worker from upstream, the version from downstream will have been injected
         * Then, execute an additional release worker, to replace that version with the one from upstream,
         * for the upstream packages only
         */
        $upstreamDownstreamClasses = [
            UpstreamUpdateReplaceReleaseWorker::class => UpdateReplaceReleaseWorker::class,
            UpstreamSetCurrentMutualConflictsReleaseWorker::class => SetCurrentMutualConflictsReleaseWorker::class,
            UpstreamSetCurrentMutualDependenciesReleaseWorker::class => SetCurrentMutualDependenciesReleaseWorker::class,
            UpstreamSetNextMutualDependenciesReleaseWorker::class => SetNextMutualDependenciesReleaseWorker::class,
            UpstreamUpdateBranchAliasReleaseWorker::class => UpdateBranchAliasReleaseWorker::class,
        ];
        foreach ($upstreamDownstreamClasses as $upstreamClass => $downstreamClass) {
            $pos = array_search($upstreamClass, $releaseWorkerClasses);
            if ($pos === false) {
                continue;
            }
            /** @var int $pos */
            array_splice(
                $releaseWorkerClasses,
                $pos + 1,
                0,
                [
                    $downstreamClass
                ]
            );
        }

        /**
         * Replace "-dev" to deploy to PROD, and bump to the new version,
         * on the downstream source code only, so these release workers replace
         * the ones from upstream.
         */
        $upstreamDownstreamClasses = [
            UpstreamConvertVersionForProdInPluginMainFileReleaseWorker::class => ConvertVersionForProdInPluginMainFileReleaseWorker::class,
            UpstreamConvertStableTagVersionForProdInPluginReadmeFileReleaseWorker::class => ConvertStableTagVersionForProdInPluginReadmeFileReleaseWorker::class,
            UpstreamConvertVersionForProdInPluginNodeJSPackageJSONFilesReleaseWorker::class => ConvertVersionForProdInPluginNodeJSPackageJSONFilesReleaseWorker::class,
            UpstreamConvertVersionForProdInMonorepoMetadataFileReleaseWorker::class => ConvertVersionForProdInMonorepoMetadataFileReleaseWorker::class,
            UpstreamConvertVersionForProdInPluginBlockCompiledMarkdownFilesReleaseWorker::class => ConvertVersionForProdInPluginBlockCompiledMarkdownFilesReleaseWorker::class,
            UpstreamRestoreVersionForDevInPluginBlockCompiledMarkdownFilesReleaseWorker::class => RestoreVersionForDevInPluginBlockCompiledMarkdownFilesReleaseWorker::class,
            UpstreamBumpVersionForDevInMonorepoMetadataFileReleaseWorker::class => BumpVersionForDevInMonorepoMetadataFileReleaseWorker::class,
            UpstreamBumpVersionForDevInPluginNodeJSPackageJSONFilesReleaseWorker::class => BumpVersionForDevInPluginNodeJSPackageJSONFilesReleaseWorker::class,
            UpstreamBumpVersionForDevInPluginMainFileReleaseWorker::class => BumpVersionForDevInPluginMainFileReleaseWorker::class,
        ];
        foreach ($upstreamDownstreamClasses as $upstreamClass => $downstreamClass) {
            $pos = array_search($upstreamClass, $releaseWorkerClasses);
            if ($pos === false) {
                continue;
            }
            /** @var int $pos */
            array_splice(
                $releaseWorkerClasses,
                $pos,
                1,
                [
                    $downstreamClass
                ]
            );
        }

        /**
         * Append additional workers
         */
        $afterWorkerAppendWorkerClasses = [
            ConvertVersionForProdInPluginMainFileReleaseWorker::class => [
                UpdateVersionConstraintToGatoGraphQLPluginInPluginMainFileReleaseWorker::class,
            ],
        ];
        foreach ($afterWorkerAppendWorkerClasses as $workerClass => $additionalWorkerClasses) {
            /** @var int */
            $pos = array_search($workerClass, $releaseWorkerClasses);
            array_splice(
                $releaseWorkerClasses,
                $pos + 1,
                0,
                $additionalWorkerClasses
            );
        }

        return $releaseWorkerClasses;
    }
}
