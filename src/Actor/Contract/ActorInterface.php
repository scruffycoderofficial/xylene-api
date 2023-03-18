<?php

declare(strict_types=1);

namespace Xylene\Actor\Contract;

/**
 * Interface ActorInterface.
 */
interface ActorInterface
{
    public function canExecute(string $useCaseName): bool;

    public function getName(): string;
}
