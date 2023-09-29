<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Configuration;

use Symfony\Component\Console\Input\InputInterface;

interface ModifyProjectStageResolverInterface
{
    public function resolveFromInput(InputInterface $input): string;
}
