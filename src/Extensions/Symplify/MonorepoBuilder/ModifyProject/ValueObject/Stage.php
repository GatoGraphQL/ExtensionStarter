<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\ValueObject;

final class Stage
{
    /**
     * @var string
     */
    public const MAIN = 'main';
    /**
     * @var string
     */
    public const ADAPT_PROJECT = 'adapt-project';
    /**
     * @var string
     */
    public const COMMIT = 'commit';
}
