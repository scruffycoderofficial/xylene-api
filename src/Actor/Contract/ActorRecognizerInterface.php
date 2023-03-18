<?php

declare(strict_types=1);

namespace Xylene\Actor\Contract;

/**
 * Interface ActorRecognizerInterface.
 */
interface ActorRecognizerInterface
{
    /**
     * @param object $useCaseRequest
     */
    public function recognizeActor($useCaseRequest): ActorInterface;
}
