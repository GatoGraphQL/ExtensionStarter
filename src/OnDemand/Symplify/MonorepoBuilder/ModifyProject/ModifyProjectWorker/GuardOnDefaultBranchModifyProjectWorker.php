<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\ModifyProjectWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\InitializeProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;
use Symplify\MonorepoBuilder\ValueObject\Option;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\SymplifyKernel\Exception\ShouldNotHappenException;

final class GuardOnDefaultBranchModifyProjectWorker implements InitializeProjectWorkerInterface
{
    private string $branchName;

    public function __construct(
        private ProcessRunner $processRunner,
        ParameterProvider $parameterProvider
    ) {
        $this->branchName = $parameterProvider->provideStringParameter(Option::DEFAULT_BRANCH_NAME);
    }

    public function work(ModifyProjectInputObjectInterface $inputObject): void
    {
        $currentBranchName = trim($this->processRunner->run('git branch --show-current'));
        if ($currentBranchName !== $this->branchName) {
            throw new ShouldNotHappenException(sprintf(
                'Switch from branch "%s" to "%s" before modifying the project',
                $currentBranchName,
                $this->branchName
            ));
        }
    }

    public function getDescription(ModifyProjectInputObjectInterface $inputObject): string
    {
        return 'Check we are on the default branch, to avoid commit/push to a different branch';
    }
}
