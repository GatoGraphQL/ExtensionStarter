<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Command;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\SmartFile\CopyUpstreamMonorepoFileEntriesProvider;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\SmartFile\FileCopierSystem;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
use Symplify\PackageBuilder\Console\Command\CommandNaming;

final class CopyUpstreamMonorepoFilesCommand extends AbstractSymplifyCommand
{
    public function __construct(
        private FileCopierSystem $fileCopierSystem,
        private CopyUpstreamMonorepoFileEntriesProvider $copyUpstreamMonorepoFileEntriesProvider,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(CommandNaming::classToName(self::class));
        $this->setDescription('Copy files from the upstream to the downstream monorepo');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Get the entries from the provider
        $entries = $this->copyUpstreamMonorepoFileEntriesProvider->provideCopyUpstreamMonorepoFileEntries();

        // For each entry, copy to the destination, and execute a search/replace
        $copiedFiles = [];
        foreach ($entries as $entry) {
            $copiedFiles = array_merge(
                $copiedFiles,
                $this->fileCopierSystem->copyFiles(
                    $entry['files'],
                    $entry['toFolder'],
                    $entry['patternReplacements'] ?? [],
                    $entry['renameFiles'] ?? [],
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
