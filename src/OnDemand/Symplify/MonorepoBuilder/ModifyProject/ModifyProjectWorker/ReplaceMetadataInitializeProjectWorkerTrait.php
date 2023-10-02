<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\ModifyProjectWorker;

trait ReplaceMetadataInitializeProjectWorkerTrait
{
    /**
     * @return array<string,string>
     */
    protected function getRegexReplacement(string $constName, string $newValue): array
    {
        return [
            "/(\s+)const(\s+)" . $constName . "(\s+)?=(\s+)?['\"](.+)?['\"](\s+)?;/" => " const " . $constName . " = '" . $newValue . "';",
        ];
    }
}
