<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Utils;

final class StringUtils
{
    /**
     * @see https://stackoverflow.com/a/40514305/14402031
     */
    public function camelToUnderscore(string $string, string $us = '-'): string
    {
        return strtolower(
            preg_replace(
                '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/',
                $us,
                $string
            )
        );
    }
}
