<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\InitializeProjectWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\InitializeProjectInputObjectInterface;

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

    protected function printReplacements(InitializeProjectInputObjectInterface $inputObject): string
    {
        $items = [];
        foreach ($this->getReplacements($inputObject) as $constName => $newValue) {
            $items[] = sprintf(
                '- %s => "%s"',
                $constName,
                $newValue
            );
        }
        return implode(PHP_EOL, $items);
    }

    /**
     * @return array<string,string> Key: const name, Value: new value to set for that const
     */
    abstract protected function getReplacements(InitializeProjectInputObjectInterface $inputObject): array;
}
