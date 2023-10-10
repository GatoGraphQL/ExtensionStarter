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
        $replaced = preg_replace(
            '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/',
            $us,
            $string
        );
        if ($replaced === null) {
            return '';
        }
        return strtolower($replaced);
    }

    /**
     * @see https://stackoverflow.com/a/2792045/14402031
     */
    public function dashesToCamelCase(string $string, bool $capitalizeFirstCharacter = false): string
    {
        $str = str_replace('-', '', ucwords($string, '-'));

        if (!$capitalizeFirstCharacter) {
            $str = lcfirst($str);
        }

        return $str;
    }
}
