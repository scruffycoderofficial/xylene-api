<?php

namespace Xylene\Actor;

use Xylene\Actor\Contract\ActorInterface;

/**
 * Class UnableActor.
 */
class UnableActor implements ActorInterface
{
    public function canExecute(string $useCaseName): bool
    {
        return false;
    }

    public function getName(): string
    {
        return 'unable';
    }
}
