<?php

namespace Xylene\Actor;

use Xylene\Actor\Contract\ActorInterface;

/**
 * Class OmnipotentActor.
 */
class OmnipotentActor implements ActorInterface
{
    /**
     * An omnipotent actor can execute any use case.
     */
    public function canExecute(string $useCaseName): bool
    {
        return true;
    }

    public function getName(): string
    {
        return 'omnipotent';
    }
}
