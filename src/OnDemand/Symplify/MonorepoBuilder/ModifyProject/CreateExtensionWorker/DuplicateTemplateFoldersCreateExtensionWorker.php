<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\CreateExtensionInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;

class DuplicateTemplateFoldersCreateExtensionWorker extends AbstractDuplicateTemplateFoldersCreateExtensionWorker
{
    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function work(ModifyProjectInputObjectInterface $inputObject): void
    {
        $folders = $this->getExtensionTemplateFolders();

        // For each entry, copy to the destination, and execute a search/replace
        $patternReplacements = [];
        $templateName = $this->getTemplateName();
        $extensionSlug = $inputObject->getExtensionSlug();
        foreach ($folders as $folder) {
            $toFolder = str_replace(
                ['templates/' . $templateName, 'extension-template'],
                ['layers', $extensionSlug],
                $folder
            );
            $this->fileCopierSystem->copyFilesFromFolder(
                $folder,
                $toFolder,
                false,
                $patternReplacements,
            );
        }
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function getDescription(ModifyProjectInputObjectInterface $inputObject): string
    {
        return sprintf(
            'Duplicate the extension template folders, using extension slug "%s"',
            $inputObject->getExtensionSlug()
        );
    }
}
