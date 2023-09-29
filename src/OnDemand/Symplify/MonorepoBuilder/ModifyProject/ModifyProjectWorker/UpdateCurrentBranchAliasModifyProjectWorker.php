<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\ModifyProjectWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\ModifyProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\StageAwareModifyProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\ValueObject\Stage;
use Symplify\MonorepoBuilder\DevMasterAliasUpdater;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;

final class UpdateCurrentBranchAliasModifyProjectWorker implements ModifyProjectWorkerInterface, StageAwareModifyProjectWorkerInterface
{
    public function __construct(
        private DevMasterAliasUpdater $devMasterAliasUpdater,
        private ComposerJsonProvider $composerJsonProvider,
        // private VersionUtils $versionUtils
    ) {
    }

    public function getStage(): string
    {
        return Stage::INITIALIZE;
    }

    public function work(ModifyProjectInputObjectInterface $inputObject): void
    {
        // @todo Fix ModifyProject
        // $nextAlias = $this->versionUtils->getCurrentAliasFormat($version);
        $nextAlias = '1.0.0';

        $this->devMasterAliasUpdater->updateFileInfosWithAlias(
            $this->composerJsonProvider->getPackagesComposerFileInfos(),
            $nextAlias
        );
    }

    public function getDescription(ModifyProjectInputObjectInterface $inputObject): string
    {
        // @todo Fix ModifyProject
        // $nextAlias = $this->versionUtils->getCurrentAliasFormat($version);
        $nextAlias = '1.0.0';

        return sprintf('Set branch alias "%s" to all packages', $nextAlias);
    }
}
