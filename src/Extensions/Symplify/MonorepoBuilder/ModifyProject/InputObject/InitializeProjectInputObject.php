<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject;

class InitializeProjectInputObject implements InitializeProjectInputObjectInterface
{
    public function __construct(
        public string $githubRepoOwner,
        public string $githubRepoName,
    ){        
    }
}
