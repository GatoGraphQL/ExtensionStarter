<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Command;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\SmartFile\CopyUpstreamMonorepoFolderEntriesProvider;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\SmartFile\FileCopierSystem;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
use Symplify\PackageBuilder\Console\Command\CommandNaming;

final class CopyUpstreamMonorepoFoldersCommand extends AbstractSymplifyCommand
{
    public function __construct(
        private FileCopierSystem $fileCopierSystem,
        private CopyUpstreamMonorepoFolderEntriesProvider $copyUpstreamMonorepoFolderEntriesProvider,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(CommandNaming::classToName(self::class));
        $this->setDescription('Copy all files from specific folders from the upstream to the downstream monorepo');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Get the entries from the provider
        $entries = $this->copyUpstreamMonorepoFolderEntriesProvider->provideCopyUpstreamMonorepoFolderEntries();

        // For each entry, copy to the destination, and execute a search/replace
        $copiedFiles = [];
        foreach ($entries as $entry) {
            $copiedFiles = array_merge(
                $copiedFiles,
                $this->fileCopierSystem->copyFilesFromFolder(
                    $entry['fromFolder'],
                    $entry['toFolder'],
                    false,
                    $entry['patternReplacements'] ?? [],
                )
            );
        }

        if ($copiedFiles === []) {
            $message = 'No files were copied';
        } else {
            $message = sprintf(
                'Copied (and edited) files: "%s"',
                implode('", "', $copiedFiles)
            );
        }


        $this->symfonyStyle->success($message);

        return self::SUCCESS;
    }
}
